-- สร้างตาราง Users (ครู, เจ้าหน้าที่ยานพาหนะ, ผอ.)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    position VARCHAR(100), -- ตำแหน่ง
    department VARCHAR(100), -- กลุ่มสาระ/กลุ่มงาน
    role ENUM('user', 'staff', 'admin') DEFAULT 'user', -- user=ครู, staff=จนท.ยานพาหนะ, admin=ผอ.
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- สร้างตาราง Vehicles (รถตู้, รถกระบะ ตามเอกสาร)
CREATE TABLE vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL, -- เช่น รถตู้ หมายเลข 7952
    plate_number VARCHAR(20),
    type ENUM('van', 'pickup') NOT NULL,
    status ENUM('available', 'maintenance') DEFAULT 'available'
);

-- สร้างตาราง Bookings (ใบขออนุญาต)
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    purpose TEXT NOT NULL, -- เพื่อ...
    destination VARCHAR(255) NOT NULL, -- สถานที่
    passengers INT NOT NULL, -- จำนวนคน
    start_date DATETIME NOT NULL, -- ไปวันที่
    end_date DATETIME NOT NULL, -- ถึงวันที่
    
    -- ส่วนของเจ้าหน้าที่ควบคุมยานพาหนะ
    status ENUM('pending', 'staff_approved', 'director_approved', 'rejected') DEFAULT 'pending',
    vehicle_id INT NULL,
    driver_name VARCHAR(100) NULL,
    staff_comment TEXT NULL,
    staff_approved_at DATETIME NULL,
    
    -- ส่วนของผู้อำนวยการ
    director_comment TEXT NULL,
    director_approved_at DATETIME NULL,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id)
);

-- Mock Data (ข้อมูลตัวอย่าง)
INSERT INTO users (username, password, fullname, role, position, department) VALUES 
('teacher', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ครูสมศรี ใจดี', 'user', 'ครูชำนาญการ', 'ภาษาต่างประเทศ'), -- password: password
('staff', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ลุงสมหมาย ขับรถ', 'staff', 'จนท.ยานพาหนะ', 'บริหารทั่วไป'),
('director', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ผอ. มุ่งมั่น', 'admin', 'ผู้อำนวยการ', 'บริหาร');

INSERT INTO vehicles (name, plate_number, type) VALUES 
('รถตู้ นข 7952', 'นข 7952', 'van'),
('รถตู้ นข 3738', 'นข 3738', 'van'),
('รถตู้ นข 1701', 'นข 1701', 'van'),
('รถกระบะ 4 ประตู กต 5017', 'กต 5017', 'pickup'),
('รถกระบะ 2 ประตู บษ 1031', 'บษ 1031', 'pickup');