-- ==================================================================
-- MOONLIGHT EVENTS - TRIGGERS AND AUTOMATION
-- File: triggers.sql
-- Purpose: Auto-update festival years and maintain data freshness
-- Dependencies: Requires schema.sql and insert.sql to be run first
-- ==================================================================

USE moonlight_event;

-- ==================================================================
-- 1. STORED PROCEDURES
-- ==================================================================

-- Drop existing procedures if they exist
DROP PROCEDURE IF EXISTS UpdateExpiredFestivals;
DROP PROCEDURE IF EXISTS GetFestivalStatistics;

-- Main procedure to update expired festivals
DELIMITER //
CREATE PROCEDURE UpdateExpiredFestivals()
BEGIN
    DECLARE festival_count INT DEFAULT 0;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;

    -- Count festivals that need updating
    SELECT COUNT(*) INTO festival_count
    FROM festival 
    WHERE start_date < CURDATE() 
    AND YEAR(start_date) < YEAR(CURDATE());

    -- Update expired festivals to next year
    UPDATE festival 
    SET start_date = DATE_ADD(start_date, INTERVAL 1 YEAR),
        end_date = DATE_ADD(end_date, INTERVAL 1 YEAR),
        updated_at = CURRENT_TIMESTAMP
    WHERE start_date < CURDATE() 
    AND YEAR(start_date) < YEAR(CURDATE());

    COMMIT;

    -- Log the update
    INSERT INTO system_log (action, details, created_at) 
    VALUES (
        'AUTO_UPDATE_FESTIVALS', 
        CONCAT('Updated ', festival_count, ' expired festivals to next year'),
        CURRENT_TIMESTAMP
    );

    -- Return result
    SELECT 
        festival_count as festivals_updated,
        CURRENT_TIMESTAMP as update_time,
        'Festival years updated successfully' as message;

END //
DELIMITER ;

-- Statistics procedure for monitoring
DELIMITER //
CREATE PROCEDURE GetFestivalStatistics()
BEGIN
    SELECT 
        'UPCOMING' as category,
        COUNT(*) as count,
        GROUP_CONCAT(name ORDER BY start_date LIMIT 5) as examples
    FROM festival 
    WHERE start_date >= CURDATE()
    
    UNION ALL
    
    SELECT 
        'TODAY' as category,
        COUNT(*) as count,
        GROUP_CONCAT(name) as examples
    FROM festival 
    WHERE start_date = CURDATE()
    
    UNION ALL
    
    SELECT 
        'THIS_MONTH' as category,
        COUNT(*) as count,
        GROUP_CONCAT(name ORDER BY start_date LIMIT 3) as examples
    FROM festival 
    WHERE start_date >= CURDATE() 
    AND start_date < LAST_DAY(CURDATE()) + INTERVAL 1 DAY
    
    UNION ALL
    
    SELECT 
        'NEXT_30_DAYS' as category,
        COUNT(*) as count,
        GROUP_CONCAT(name ORDER BY start_date LIMIT 3) as examples
    FROM festival 
    WHERE start_date >= CURDATE() 
    AND start_date <= CURDATE() + INTERVAL 30 DAY;
END //
DELIMITER ;

-- ==================================================================
-- 2. SYSTEM LOG TABLE (for tracking updates)
-- ==================================================================

CREATE TABLE IF NOT EXISTS system_log (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    action VARCHAR(100) NOT NULL,
    details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_log_action (action),
    INDEX idx_log_created (created_at)
);

-- ==================================================================
-- 3. EVENT SCHEDULER SETUP
-- ==================================================================

-- Enable event scheduler
SET GLOBAL event_scheduler = ON;

-- Drop existing event if exists
DROP EVENT IF EXISTS update_festival_years;

-- Create daily event to update festival years
CREATE EVENT update_festival_years
ON SCHEDULE EVERY 1 DAY 
STARTS (TIMESTAMP(CURRENT_DATE) + INTERVAL 1 DAY + INTERVAL 1 MINUTE)
ON COMPLETION PRESERVE
ENABLE
COMMENT 'Auto-update expired festivals to next year'
DO 
  CALL UpdateExpiredFestivals();

-- ==================================================================
-- 4. INITIAL EXECUTION
-- ==================================================================

-- Run the update procedure immediately to fix any current expired festivals
CALL UpdateExpiredFestivals();

-- Log the initial setup
INSERT INTO system_log (action, details) 
VALUES ('TRIGGER_SYSTEM_SETUP', 'Auto-update system initialized successfully');

-- ==================================================================
-- 5. UTILITY VIEWS (for easy monitoring)
-- ==================================================================

-- View for upcoming festivals
CREATE OR REPLACE VIEW upcoming_festivals AS
SELECT 
    f.name,
    f.slug,
    f.start_date,
    f.end_date,
    r.name as religion_name,
    GROUP_CONCAT(DISTINCT c.name SEPARATOR ', ') as countries,
    DATEDIFF(f.start_date, CURDATE()) as days_until,
    CASE 
        WHEN f.start_date = CURDATE() THEN 'TODAY'
        WHEN f.start_date = CURDATE() + INTERVAL 1 DAY THEN 'TOMORROW'
        WHEN DATEDIFF(f.start_date, CURDATE()) <= 7 THEN 'THIS_WEEK'
        WHEN DATEDIFF(f.start_date, CURDATE()) <= 30 THEN 'THIS_MONTH'
        WHEN DATEDIFF(f.start_date, CURDATE()) <= 90 THEN 'NEXT_3_MONTHS'
        ELSE 'FUTURE'
    END as time_category
FROM festival f
LEFT JOIN religion r ON f.religion_id = r.religion_id
LEFT JOIN festival_country fc ON f.festival_id = fc.festival_id
LEFT JOIN country c ON fc.country_id = c.country_id
WHERE f.start_date >= CURDATE()
GROUP BY f.festival_id, f.name, f.slug, f.start_date, f.end_date, r.name
ORDER BY f.start_date ASC;

-- ==================================================================
-- 6. MONITORING QUERIES
-- ==================================================================

-- Check event scheduler status
SELECT 'Event Scheduler Status' as info, @@event_scheduler as status;

-- Show active events
SELECT 
    event_name,
    event_definition,
    interval_value,
    interval_field,
    status,
    created,
    last_executed,
    next_execution_time
FROM information_schema.events 
WHERE event_schema = 'moonlight_event';

-- Show recent system logs
SELECT * FROM system_log 
ORDER BY created_at DESC 
LIMIT 10;

-- Show upcoming festivals summary
SELECT 
    time_category,
    COUNT(*) as festival_count,
    GROUP_CONCAT(name ORDER BY start_date LIMIT 3) as examples
FROM upcoming_festivals
GROUP BY time_category
ORDER BY 
    CASE time_category
        WHEN 'TODAY' THEN 1
        WHEN 'TOMORROW' THEN 2
        WHEN 'THIS_WEEK' THEN 3
        WHEN 'THIS_MONTH' THEN 4
        WHEN 'NEXT_3_MONTHS' THEN 5
        ELSE 6
    END;

-- ==================================================================
-- 7. MAINTENANCE COMMANDS (commented out - use when needed)
-- ==================================================================

/*
-- Disable the event temporarily
-- ALTER EVENT update_festival_years DISABLE;

-- Enable the event
-- ALTER EVENT update_festival_years ENABLE;

-- Drop the event completely
-- DROP EVENT IF EXISTS update_festival_years;

-- Drop all procedures
-- DROP PROCEDURE IF EXISTS UpdateExpiredFestivals;
-- DROP PROCEDURE IF EXISTS GetFestivalStatistics;

-- Clear system logs older than 30 days
-- DELETE FROM system_log WHERE created_at < DATE_SUB(CURDATE(), INTERVAL 30 DAY);

-- Manual festival update (if needed)
-- CALL UpdateExpiredFestivals();

-- Get current festival statistics
-- CALL GetFestivalStatistics();
*/

-- ==================================================================
-- SETUP COMPLETE MESSAGE
-- ==================================================================

SELECT 
    'MOONLIGHT EVENTS TRIGGER SYSTEM' as system,
    'SETUP COMPLETED SUCCESSFULLY' as status,
    CURRENT_TIMESTAMP as setup_time,
    'Auto-update will run daily at 00:01' as schedule;