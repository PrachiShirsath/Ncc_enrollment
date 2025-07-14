-- NCC DBATU Database Setup
-- Create database
CREATE DATABASE IF NOT EXISTS ncc_dbatu;
USE ncc_dbatu;

-- NCC Applications table
CREATE TABLE ncc_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_id VARCHAR(20) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    branch VARCHAR(50) NOT NULL,
    current_year VARCHAR(20) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    motivation TEXT NOT NULL,
    status ENUM('pending', 'approved', 'rejected', 'assigned') DEFAULT 'pending',
    batch_id INT NULL,
    assigned_date DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_registration_id (registration_id),
    INDEX idx_status (status),
    INDEX idx_email (email)
);

-- NCC Batches table
CREATE TABLE ncc_batches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    batch_name VARCHAR(50) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    max_capacity INT NOT NULL DEFAULT 50,
    current_enrollment INT DEFAULT 0,
    status ENUM('upcoming', 'active', 'completed') DEFAULT 'upcoming',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_dates (start_date, end_date)
);

-- Admin users table (for NCC officers)
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role ENUM('admin', 'officer') DEFAULT 'officer',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
);

-- Insert sample admin user (password: admin123)
INSERT INTO admin_users (username, password, full_name, email, role) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'NCC Admin', 'admin@dbatu.ac.in', 'admin');

-- Insert sample batches
INSERT INTO ncc_batches (batch_name, start_date, end_date, max_capacity, description) VALUES 
('NCC Batch 2024-01', '2024-06-01', '2024-06-15', 50, 'Summer Training Camp 2024'),
('NCC Batch 2024-02', '2024-07-01', '2024-07-15', 50, 'Monsoon Training Camp 2024'),
('NCC Batch 2024-03', '2024-08-01', '2024-08-15', 50, 'Advanced Leadership Camp 2024');

-- Create view for application status
CREATE VIEW application_status_view AS
SELECT 
    a.id,
    a.registration_id,
    a.full_name,
    a.email,
    a.phone,
    a.branch,
    a.current_year,
    a.gender,
    a.status,
    a.created_at,
    b.batch_name,
    b.start_date,
    b.end_date
FROM ncc_applications a
LEFT JOIN ncc_batches b ON a.batch_id = b.id;

-- Create trigger to update batch enrollment count
DELIMITER //
CREATE TRIGGER update_batch_enrollment
AFTER UPDATE ON ncc_applications
FOR EACH ROW
BEGIN
    IF NEW.batch_id != OLD.batch_id THEN
        -- Decrease count for old batch
        IF OLD.batch_id IS NOT NULL THEN
            UPDATE ncc_batches 
            SET current_enrollment = current_enrollment - 1 
            WHERE id = OLD.batch_id;
        END IF;
        
        -- Increase count for new batch
        IF NEW.batch_id IS NOT NULL THEN
            UPDATE ncc_batches 
            SET current_enrollment = current_enrollment + 1 
            WHERE id = NEW.batch_id;
        END IF;
    END IF;
END//
DELIMITER ;

-- Create trigger for new applications
DELIMITER //
CREATE TRIGGER new_application_enrollment
AFTER INSERT ON ncc_applications
FOR EACH ROW
BEGIN
    IF NEW.batch_id IS NOT NULL THEN
        UPDATE ncc_batches 
        SET current_enrollment = current_enrollment + 1 
        WHERE id = NEW.batch_id;
    END IF;
END//
DELIMITER ;

-- Sample data for testing
INSERT INTO ncc_applications (registration_id, full_name, email, phone, branch, current_year, gender, motivation) VALUES 
('NCC2024ABC12345', 'John Doe', 'john.doe@example.com', '9876543210', 'Computer Engineering', 'Second Year', 'Male', 'I want to develop leadership skills and serve the nation.'),
('NCC2024DEF67890', 'Jane Smith', 'jane.smith@example.com', '9876543211', 'Mechanical Engineering', 'Third Year', 'Female', 'Interested in military training and discipline.'),
('NCC2024GHI11111', 'Mike Johnson', 'mike.johnson@example.com', '9876543212', 'Electrical Engineering', 'First Year', 'Male', 'Want to join NCC for adventure and character building.');

-- Update some applications to approved status
UPDATE ncc_applications SET status = 'approved' WHERE registration_id = 'NCC2024ABC12345';
UPDATE ncc_applications SET status = 'assigned', batch_id = 1, assigned_date = '2024-05-15' WHERE registration_id = 'NCC2024DEF67890'; 