-- Drop database if exists (to avoid errors)
DROP DATABASE IF EXISTS ncc_dbatu;

-- Create and use database
CREATE DATABASE ncc_dbatu;
USE ncc_dbatu;

-- Create applications table
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
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
); 