-- =========================
-- INSERT FESTIVALS: Christmas & Halloween
-- =========================

-- -------------------------
-- 1. Add Religion:
-- -------------------------
-- Christianity
INSERT INTO religion (name, description)
SELECT 'Christianity', 'The religion based on the life and teachings of Jesus Christ.'
WHERE NOT EXISTS (SELECT 1 FROM religion WHERE name = 'Christianity');

-- Hinduism
INSERT INTO religion (name, description)
SELECT 'Hinduism', 'A major world religion originating in the Indian subcontinent.'
WHERE NOT EXISTS (SELECT 1 FROM religion WHERE name = 'Hinduism');

-- Buddhism
INSERT INTO religion (name, description)
SELECT 'Buddhism', 'A major world religion based on the teachings of Siddhartha Gautama, the Buddha.'
WHERE NOT EXISTS (SELECT 1 FROM religion WHERE name = 'Buddhism');

-- Get religion_id
SET @christianity_id = (SELECT religion_id FROM religion WHERE name = 'Christianity');
SET @hinduism_id = (SELECT religion_id FROM religion WHERE name = 'Hinduism');
SET @buddhism_id = (SELECT religion_id FROM religion WHERE name = 'Buddhism');

-- -------------------------
-- 2. Add Festivals
-- -------------------------
-- Christmas
INSERT INTO festival (name, slug, description, history, start_date, end_date, religion_id, thumbnail_url)
VALUES (
    'Christmas',
    'christmas',
    'Christmas is an annual Christian holiday commemorating the birth of Jesus Christ, celebrated with religious services, family gatherings, gift-giving, and festive decorations such as Christmas trees and lights.',
    'Christmas began around the 4th century when the Church chose December 25th to commemorate the birth of Jesus Christ, coinciding with Roman festivals like Sol Invictus and Saturnalia. As Christianity spread across Europe, traditions from Northern Europe and Germanic cultures were added: evergreen wreaths (later the Advent wreath) symbolizing eternal life, the Yule log from the winter solstice festival Yule, and the Christmas tree from Germanic customs. Over time, Christmas became both a religious and cultural holiday worldwide, featuring symbols like Santa Claus and festive gift exchanges.',
    '2025-12-25',
    '2025-12-25',
    @christianity_id,
    'assets/images/christmas.jpg'
);

-- Halloween
INSERT INTO festival (name, slug, description, history, start_date, end_date, religion_id, thumbnail_url)
VALUES (
    'Halloween',
    'halloween',
    'Halloween is a celebration observed in many countries on the night of October 31st, featuring costumes, trick-or-treating, and spooky decorations.',
    'Halloween comes from the ancient Celtic festival of Samhain (about 2,000 years ago), marking the end of summer and the start of winter. Later, the Catholic Church linked it with “All Hallows’ Eve” (the night before All Saints’ Day).',
    '2025-10-31',
    '2025-10-31',
    @christianity_id,
    'assets/images/halloween.jpg'
);

-- National Day of Vietnam
INSERT INTO festival (name, slug, description, history, start_date, end_date, religion_id, thumbnail_url)
VALUES (
    'Vietnam National Day',
    'vietnam-national-day',
    'Vietnam National Day is the annual celebration on September 2nd, commemorating the declaration of independence from French colonial rule in 1945. It is celebrated with official ceremonies, parades, and public festivities.',
    'Vietnam declared its independence from French colonial rule on September 2, 1945, when President Ho Chi Minh read the Declaration of Independence in Hanoi. The day has since been celebrated annually as the National Day of Vietnam with patriotic events and public celebrations.',
    '2025-09-02',
    '2025-09-02',
    NULL,
    'assets/images/vietnam-national-day.jpg'
);

-- Mid-Autumn-Festival
INSERT INTO festival (name, slug, description, history, start_date, end_date, religion_id, thumbnail_url)
VALUES (
    'Mid-Autumn Festival',
    'mid-autumn-festival',
    'The Mid-Autumn Festival is a traditional festival celebrated in many East Asian countries, featuring mooncakes, lanterns, and family gatherings.',
    'The Mid-Autumn Festival has been celebrated for over 3,000 years, originating from moon worship and harvest celebrations in ancient China. It marks the 15th day of the 8th lunar month when the moon is at its fullest and brightest. Over time, the festival spread to Vietnam and other East Asian countries, becoming a celebration of family reunion, harvest, and thanksgiving.',
    '2025-09-29',
    '2025-09-29',
    NULL,
    'assets/images/mid-autumn-festival.jpg'
);

-- Holi
INSERT INTO festival (name, slug, description, history, start_date, end_date, religion_id, thumbnail_url)
VALUES (
    'Holi',
    'holi',
    'Holi, also known as the Festival of Colors, is an ancient Hindu festival celebrating the arrival of spring, the victory of good over evil, and community togetherness.',
    'Holi originated in India as a Hindu festival to mark the arrival of spring and celebrate the triumph of good over evil, based on the legend of Prahlad and Holika. It has been celebrated for centuries with the throwing of colored powders, bonfires, music, and festive gatherings.',
    '2025-03-17', -- Ngày Holi 2025 (tính theo dương lịch)
    '2025-03-17',
    @hinduism_id,
    'assets/images/holi.jpg'
);

-- Lunar New Year
INSERT INTO festival (name, slug, description, history, start_date, end_date, religion_id, thumbnail_url)
VALUES (
    'Lunar New Year',
    'lunar-new-year',
    'Lunar New Year, also known as Chinese New Year or Tết in Vietnam, is celebrated on the first day of the lunar calendar year with family gatherings, traditional foods, and cultural customs.',
    'Lunar New Year has been celebrated for thousands of years in East Asia, originating from ancient agricultural societies. It marks the beginning of the lunar calendar year and is associated with family reunions, ancestor worship, and various cultural rituals.',
    '2025-01-29', -- Ngày mùng 1 Tết 2025 dương lịch
    '2025-01-29',
    NULL,
    'assets/images/lunar-new-year.jpg'
);

-- Vesak
INSERT INTO festival (name, slug, description, history, start_date, end_date, religion_id, thumbnail_url)
VALUES (
    'Vesak (Buddha’s Birthday)',
    'vesak',
    'Vesak, also known as Buddha’s Birthday, commemorates the birth, enlightenment, and passing of the Buddha. It is the most important Buddhist festival, marked with rituals, lanterns, and acts of compassion.',
    'Vesak has been observed for over two millennia, originating in India to honor the life of Siddhartha Gautama, the Buddha. It commemorates his birth, enlightenment, and parinirvana (passing). The festival spread across Asia and is celebrated with temple ceremonies, lanterns, almsgiving, and prayers for peace. The United Nations recognized Vesak as an international day of celebration in 1999.',
    '2025-05-12', -- Vesak 2025 dương lịch
    '2025-05-12',
    @buddhism_id,
    'assets/images/vesak.jpg'
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

-- China
INSERT INTO country (name, description)
SELECT 'China', 'Mid-Autumn Festival is a major harvest festival in China, celebrated with mooncakes, lanterns, and family reunions.'
WHERE NOT EXISTS (SELECT 1 FROM country WHERE name = 'China');

-- India
INSERT INTO country (name, description)
SELECT 'India', 'Holi is widely celebrated in India with colors, water fights, and festive gatherings.'
WHERE NOT EXISTS (SELECT 1 FROM country WHERE name = 'India');

-- South Korea
INSERT INTO country (name, description)
SELECT 'South Korea', 'Seollal is the Korean Lunar New Year, celebrated with family gatherings and traditional rituals.'
WHERE NOT EXISTS (SELECT 1 FROM country WHERE name = 'South Korea');

-- Sri Lanka
INSERT INTO country (name, description)
SELECT 'Sri Lanka', 'Vesak is a national holiday in Sri Lanka, celebrated with lanterns, rituals, and acts of charity.'
WHERE NOT EXISTS (SELECT 1 FROM country WHERE name = 'Sri Lanka');

-- Thailand
INSERT INTO country (name, description)
SELECT 'Thailand', 'Vesak is one of the most important Buddhist festivals in Thailand, with ceremonies in temples nationwide.'
WHERE NOT EXISTS (SELECT 1 FROM country WHERE name = 'Thailand');
-- -------------------------
-- 4. Link Festivals with Countries
-- -------------------------
-- Get festival_id
SET @christmas_id = (SELECT festival_id FROM festival WHERE slug = 'christmas');
SET @halloween_id = (SELECT festival_id FROM festival WHERE slug = 'halloween');
SET @vietnam_nd_id = (SELECT festival_id FROM festival WHERE slug = 'vietnam-national-day');
SET @mid_autumn_id = (SELECT festival_id FROM festival WHERE slug = 'mid-autumn-festival');
SET @holi_id = (SELECT festival_id FROM festival WHERE slug = 'holi');
SET @lunar_new_year_id = (SELECT festival_id FROM festival WHERE slug = 'lunar-new-year');
SET @vesak_id = (SELECT festival_id FROM festival WHERE slug = 'vesak');

-- Get country_ids
SET @us_id = (SELECT country_id FROM country WHERE name = 'United States');
SET @uk_id = (SELECT country_id FROM country WHERE name = 'United Kingdom');
SET @germany_id = (SELECT country_id FROM country WHERE name = 'Germany');
SET @philippines_id = (SELECT country_id FROM country WHERE name = 'Philippines');
SET @canada_id = (SELECT country_id FROM country WHERE name = 'Canada');
SET @vietnam_id = (SELECT country_id FROM country WHERE name = 'Vietnam');
SET @china_id = (SELECT country_id FROM country WHERE name = 'China');
SET @india_id = (SELECT country_id FROM country WHERE name = 'India');
SET @south_korea_id = (SELECT country_id FROM country WHERE name = 'South Korea');
SET @srilanka_id = (SELECT country_id FROM country WHERE name = 'Sri Lanka');
SET @thailand_id = (SELECT country_id FROM country WHERE name = 'Thailand');

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

-- Mid Autumn Festival
INSERT INTO festival_country (festival_id, country_id)
VALUES 
(@mid_autumn_id, @vietnam_id),
(@mid_autumn_id, @china_id);

-- Holi
INSERT INTO festival_country (festival_id, country_id)
VALUES (@holi_id, @india_id);

-- Lunar New Year
INSERT INTO festival_country (festival_id, country_id)
VALUES 
(@lunar_new_year_id, @china_id),
(@lunar_new_year_id, @vietnam_id),
(@lunar_new_year_id, @south_korea_id);

-- Vesak
INSERT INTO festival_country (festival_id, country_id)
VALUES 
(@vesak_id, @srilanka_id),
(@vesak_id, @thailand_id),
(@vesak_id, @vietnam_id);