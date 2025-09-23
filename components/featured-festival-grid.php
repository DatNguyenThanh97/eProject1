<?php
$today = date('Y-m-d');

$sql = "SELECT f.*, r.name as religion_name, 
               GROUP_CONCAT(DISTINCT c.name SEPARATOR ', ') as countries,
               DATEDIFF(f.start_date, ?) as days_until
        FROM festival f 
        LEFT JOIN religion r ON f.religion_id = r.religion_id
        LEFT JOIN festival_country fc ON f.festival_id = fc.festival_id
        LEFT JOIN country c ON fc.country_id = c.country_id
        WHERE f.start_date >= ?
        GROUP BY f.festival_id, f.name, f.slug, f.description, f.history, 
                 f.thumbnail_url, f.start_date, f.end_date, f.month, 
                 f.religion_id, f.created_at, f.updated_at, r.name
        ORDER BY f.start_date ASC 
        LIMIT 3";

$stmt = $db->prepare($sql);
$stmt->bind_param("ss", $today, $today);
$stmt->execute();
$result = $stmt->get_result();

$featured_festivals = [];
while ($row = $result->fetch_assoc()) {
    // Format date
    $row['formatted_date'] = date('F j, Y', strtotime($row['start_date']));
    $row['month_name'] = date('F', strtotime($row['start_date']));
    
    // Tính số ngày còn lại
    if ($row['days_until'] == 0) {
        $row['time_until'] = 'Today!';
    } elseif ($row['days_until'] == 1) {
        $row['time_until'] = 'Tomorrow';
    } elseif ($row['days_until'] <= 30) {
        $row['time_until'] = $row['days_until'] . ' days left';
    } else {
        $months = floor($row['days_until'] / 30);
        $row['time_until'] = $months . ' month' . ($months > 1 ? 's' : '') . ' left';
    }

    $featured_festivals[] = $row;
}

$stmt->close();
?>

<div class="featured-grid">
    <?php if (empty($featured_festivals)): ?>
        <div class="no-upcoming">
            <p>No upcoming festivals scheduled at this time.</p>
            <p>Check back soon for new festival announcements!</p>
        </div>
    <?php else: ?>
        <?php foreach ($featured_festivals as $festival): ?>
            <div class="featured-card" onclick="openFestivalModal('<?php echo htmlspecialchars($festival['slug']); ?>')">
                <div class="featured-image">
                    <img src="<?php echo htmlspecialchars($festival['thumbnail_url']); ?>" 
                        alt="<?php echo htmlspecialchars($festival['name']); ?>"
                        onerror="this.src='assets/images/thumbnail/default.jpg'">
                    <div class="countdown-badge">
                        <?php echo htmlspecialchars($festival['time_until']); ?>
                    </div>
                </div>
                <div class="featured-content">
                    <div class="festival-meta">
                        <span class="festival-date">
                            <i class="fas fa-calendar-alt"></i>
                            <?php echo htmlspecialchars($festival['formatted_date']); ?>
                        </span>
                        <?php if ($festival['religion_name']): ?>
                            <span class="festival-religion">
                                <i class="fas fa-pray"></i>
                                <?php echo htmlspecialchars($festival['religion_name']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <h3><?php echo htmlspecialchars($festival['name']); ?></h3>
                    <p class="featured-description">
                        <?php echo htmlspecialchars(substr($festival['description'], 0, 120)) . (strlen($festival['description']) > 120 ? '...' : ''); ?>
                    </p>
                    <?php if ($festival['countries']): ?>
                        <div class="festival-countries">
                            <i class="fas fa-globe"></i>
                            <span><?php echo htmlspecialchars($festival['countries']); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="featured-action">
                        <span class="learn-more">Learn More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
