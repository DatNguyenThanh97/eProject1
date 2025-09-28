CREATE DATABASE IF NOT EXISTS moonlight_event;
USE moonlight_event;

-- Quốc gia
CREATE TABLE IF NOT EXISTS country (
    country_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

-- Tôn giáo
CREATE TABLE IF NOT EXISTS religion (
    religion_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

-- Lễ hội
CREATE TABLE IF NOT EXISTS festival (
    festival_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(180) NOT NULL UNIQUE,
    description TEXT,
    history TEXT,
    thumbnail_url VARCHAR(255),
    start_date DATE NULL,
    end_date DATE NULL,
    -- Hỗ trợ lọc theo tháng; cột sinh tự động từ start_date (MySQL 8+)
    month TINYINT GENERATED ALWAYS AS (MONTH(start_date)) STORED,
    religion_id INT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_festival_religion
        FOREIGN KEY (religion_id) REFERENCES religion(religion_id) ON DELETE SET NULL
);

-- Indexes cho festival
-- Indexes (MySQL CREATE INDEX doesn't support IF NOT EXISTS reliably). Fresh DB => safe to add.
ALTER TABLE festival ADD INDEX idx_festival_religion (religion_id);
ALTER TABLE festival ADD INDEX idx_festival_month (month);
ALTER TABLE festival ADD INDEX idx_festival_start_date (start_date);

-- Bảng trung gian nối festival và country (nhiều-nhiều)
CREATE TABLE IF NOT EXISTS festival_country (
    festival_id INT,
    country_id INT,
    PRIMARY KEY (festival_id, country_id),
    FOREIGN KEY (festival_id) REFERENCES festival(festival_id) ON DELETE CASCADE,
    FOREIGN KEY (country_id) REFERENCES country(country_id) ON DELETE CASCADE
);

-- Indexes cho bảng nối
ALTER TABLE festival_country ADD INDEX idx_fc_festival (festival_id);
ALTER TABLE festival_country ADD INDEX idx_fc_country (country_id);

-- Hình ảnh lễ hội
CREATE TABLE IF NOT EXISTS gallery (
    gallery_id INT PRIMARY KEY AUTO_INCREMENT,
    festival_id INT,
    country_id INT null,
    FOREIGN KEY (festival_id) REFERENCES festival(festival_id) ON DELETE CASCADE,
    FOREIGN KEY (country_id) REFERENCES country(country_id) ON DELETE CASCADE,
    image_url VARCHAR(255) NOT NULL,
    caption VARCHAR(255)
);

ALTER TABLE gallery ADD INDEX idx_gallery_festival (festival_id);
ALTER TABLE gallery ADD INDEX idx_gallery_country (country_id);

-- Phản hồi người dùng
CREATE TABLE IF NOT EXISTS feedback (
    feedback_id INT PRIMARY KEY AUTO_INCREMENT,
    festival_id INT NULL,
    FOREIGN KEY (festival_id) REFERENCES festival(festival_id) ON DELETE SET NULL,
    username VARCHAR(50) DEFAULT 'Anonymous',
    email VARCHAR(100),
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE feedback ADD INDEX idx_feedback_festival (festival_id);

-- Bộ đếm lượt truy cập (đảm bảo chỉ có 1 hàng)
CREATE TABLE IF NOT EXISTS visitor_count (
    id INT PRIMARY KEY CHECK (id = 1),
    total_visits INT NOT NULL DEFAULT 0,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO visitor_count (id, total_visits)
SELECT 1, 0
WHERE NOT EXISTS (SELECT 1 FROM visitor_count WHERE id = 1);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE
);

-- Tạo index để tối ưu hóa truy vấn
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_active ON users(is_active);

-- Thêm cột user_id vào bảng feedback để liên kết với bảng users
ALTER TABLE feedback 
ADD COLUMN user_id INT NULL;

-- Tạo foreign key từ user_id sang bảng users
ALTER TABLE feedback 
ADD CONSTRAINT fk_feedback_user 
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;

-- Index cho cột user_id trong bảng feedback (để tối ưu hóa các truy vấn liên quan đến người dùng)
CREATE INDEX idx_feedback_user ON feedback(user_id);
