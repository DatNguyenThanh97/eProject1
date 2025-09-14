-- =========================
-- INSERT FESTIVALS: Christmas & Halloween
-- =========================

-- -------------------------
-- 1. Add Religion: Christianity
-- -------------------------
INSERT INTO religion (name, description)
SELECT 'Christianity', 'The religion based on the life and teachings of Jesus Christ.'
WHERE NOT EXISTS (SELECT 1 FROM religion WHERE name = 'Christianity');

-- Get religion_id
SET @christianity_id = (SELECT religion_id FROM religion WHERE name = 'Christianity');

-- -------------------------
-- 2. Add Festivals
-- -------------------------
-- Christmas
INSERT INTO festival (name, slug, description, history, start_date, end_date, religion_id)
VALUES (
    'Christmas',
    'christmas',
    'Christmas is an annual Christian holiday commemorating the birth of Jesus Christ, celebrated with religious services, family gatherings, gift-giving, and festive decorations such as Christmas trees and lights.',
    'Christmas began around the 4th century when the Church chose December 25th to commemorate the birth of Jesus Christ, coinciding with Roman festivals like Sol Invictus and Saturnalia. As Christianity spread across Europe, traditions from Northern Europe and Germanic cultures were added: evergreen wreaths (later the Advent wreath) symbolizing eternal life, the Yule log from the winter solstice festival Yule, and the Christmas tree from Germanic customs. Over time, Christmas became both a religious and cultural holiday worldwide, featuring symbols like Santa Claus and festive gift exchanges.',
    '2025-12-25',
    '2025-12-25',
    @christianity_id
);

-- Halloween
INSERT INTO festival (name, slug, description, history, start_date, end_date, religion_id)
VALUES (
    'Halloween',
    'halloween',
    'Halloween is a celebration observed in many countries on the night of October 31st, featuring costumes, trick-or-treating, and spooky decorations.',
    'Halloween comes from the ancient Celtic festival of Samhain (about 2,000 years ago), marking the end of summer and the start of winter. Later, the Catholic Church linked it with “All Hallows’ Eve” (the night before All Saints’ Day).',
    '2025-10-31',
    '2025-10-31',
    @christianity_id
);

-- National Day of Vietnam
INSERT INTO festival (name, slug, description, history, start_date, end_date, religion_id)
VALUES (
    'Vietnam National Day',
    'vietnam-national-day',
    'Vietnam National Day is the annual celebration on September 2nd, commemorating the declaration of independence from French colonial rule in 1945. It is celebrated with official ceremonies, parades, and public festivities.',
    'Vietnam declared its independence from French colonial rule on September 2, 1945, when President Ho Chi Minh read the Declaration of Independence in Hanoi. The day has since been celebrated annually as the National Day of Vietnam with patriotic events and public celebrations.',
    '2025-09-02',
    '2025-09-02',
    NULL
);
-- -------------------------
-- 3. Add Countries
-- -------------------------
-- United States
INSERT INTO country (name, description)
SELECT 'United States', 'Widely celebrated holidays with both religious and cultural traditions.'
WHERE NOT EXISTS (SELECT 1 FROM country WHERE name = 'United States');

-- United Kingdom
INSERT INTO country (name, description)
SELECT 'United Kingdom', 'Widely celebrated with church services, family meals, and cultural traditions.'
WHERE NOT EXISTS (SELECT 1 FROM country WHERE name = 'United Kingdom');

-- Germany
INSERT INTO country (name, description)
SELECT 'Germany', 'Rich Christmas traditions such as Advent calendars, Christmas markets, and decorated trees.'
WHERE NOT EXISTS (SELECT 1 FROM country WHERE name = 'Germany');

-- Philippines
INSERT INTO country (name, description)
SELECT 'Philippines', 'One of the world’s longest Christmas seasons, beginning in September.'
WHERE NOT EXISTS (SELECT 1 FROM country WHERE name = 'Philippines');

-- Canada
INSERT INTO country (name, description)
SELECT 'Canada', 'Halloween is widely celebrated in Canada.'
WHERE NOT EXISTS (SELECT 1 FROM country WHERE name = 'Canada');

-- Vietnam
INSERT INTO country (name, description)
SELECT 'Vietnam', 'Vietnam celebrates its National Day on September 2nd every year, marking the declaration of independence in 1945.'
WHERE NOT EXISTS (SELECT 1 FROM country WHERE name = 'Vietnam');
-- -------------------------
-- 4. Link Festivals with Countries
-- -------------------------
-- Get festival_id
SET @christmas_id = (SELECT festival_id FROM festival WHERE slug = 'christmas');
SET @halloween_id = (SELECT festival_id FROM festival WHERE slug = 'halloween');
SET @vietnam_nd_id = (SELECT festival_id FROM festival WHERE slug = 'vietnam-national-day');

-- Get country_ids
SET @us_id = (SELECT country_id FROM country WHERE name = 'United States');
SET @uk_id = (SELECT country_id FROM country WHERE name = 'United Kingdom');
SET @germany_id = (SELECT country_id FROM country WHERE name = 'Germany');
SET @philippines_id = (SELECT country_id FROM country WHERE name = 'Philippines');
SET @canada_id = (SELECT country_id FROM country WHERE name = 'Canada');
SET @vietnam_id = (SELECT country_id FROM country WHERE name = 'Vietnam');

-- Christmas
INSERT INTO festival_country (festival_id, country_id)
VALUES 
(@christmas_id, @us_id),
(@christmas_id, @uk_id),
(@christmas_id, @germany_id),
(@christmas_id, @philippines_id);

-- Halloween
INSERT INTO festival_country (festival_id, country_id)
VALUES 
(@halloween_id, @us_id),
(@halloween_id, @uk_id),
(@halloween_id, @canada_id);

-- National Day of Vietnam
INSERT INTO festival_country (festival_id, country_id)
VALUES (@vietnam_nd_id, @vietnam_id);