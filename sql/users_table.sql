-- Đã thêm vào phần schema ở đây chỉ còn phần test nhe

-- Thêm một số user mẫu để test
INSERT INTO users (username, email, password, full_name) VALUES 
('admin', 'admin@moonlightevents.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator'),
('testuser', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Test User');

-- Password mẫu là "password" đã được hash bằng bcrypt
