-- First clear existing sample data
DELETE FROM ncc_applications;

-- Reset auto increment
ALTER TABLE ncc_applications AUTO_INCREMENT = 1;

-- Insert sample data for Computer Engineering (CSE)
INSERT INTO ncc_applications (registration_id, full_name, email, phone, branch, current_year, gender, motivation, status, created_at) VALUES
('DBATU/NCC/CSE/2024/001', 'Rahul Sharma', 'rahul.sharma@example.com', '9876543210', 'Computer Engineering', 'Second Year', 'Male', 'I want to develop leadership skills and serve the nation.', 'approved', '2024-03-15 09:30:00'),
('DBATU/NCC/CSE/2024/002', 'Priya Patel', 'priya.patel@example.com', '9876543211', 'Computer Engineering', 'First Year', 'Female', 'Interested in NCC activities and want to build discipline.', 'pending', '2024-03-16 10:15:00');

-- Insert sample data for Mechanical Engineering (MECH)
INSERT INTO ncc_applications (registration_id, full_name, email, phone, branch, current_year, gender, motivation, status, created_at) VALUES
('DBATU/NCC/MECH/2024/001', 'Amit Kumar', 'amit.kumar@example.com', '9876543212', 'Mechanical Engineering', 'Third Year', 'Male', 'Want to join defense services through NCC.', 'assigned', '2024-03-14 11:45:00'),
('DBATU/NCC/MECH/2024/002', 'Neha Singh', 'neha.singh@example.com', '9876543213', 'Mechanical Engineering', 'Second Year', 'Female', 'Passionate about serving the nation through NCC.', 'approved', '2024-03-15 14:20:00');

-- Insert sample data for Electrical Engineering (EE)
INSERT INTO ncc_applications (registration_id, full_name, email, phone, branch, current_year, gender, motivation, status, created_at) VALUES
('DBATU/NCC/EE/2024/001', 'Suresh Kumar', 'suresh.kumar@example.com', '9876543214', 'Electrical Engineering', 'Second Year', 'Male', 'Want to develop physical and mental strength.', 'pending', '2024-03-16 09:10:00'),
('DBATU/NCC/EE/2024/002', 'Anjali Desai', 'anjali.desai@example.com', '9876543215', 'Electrical Engineering', 'First Year', 'Female', 'Interested in adventure activities and social service.', 'approved', '2024-03-17 10:30:00');

-- Insert sample data for Civil Engineering (CIVIL)
INSERT INTO ncc_applications (registration_id, full_name, email, phone, branch, current_year, gender, motivation, status, created_at) VALUES
('DBATU/NCC/CIVIL/2024/001', 'Rajesh Verma', 'rajesh.verma@example.com', '9876543216', 'Civil Engineering', 'Third Year', 'Male', 'Want to participate in Republic Day parade.', 'assigned', '2024-03-13 15:45:00'),
('DBATU/NCC/CIVIL/2024/002', 'Pooja Shah', 'pooja.shah@example.com', '9876543217', 'Civil Engineering', 'Second Year', 'Female', 'Interested in camp activities and team building.', 'pending', '2024-03-14 16:20:00');

-- Insert sample data for Chemical Engineering (CHEM)
INSERT INTO ncc_applications (registration_id, full_name, email, phone, branch, current_year, gender, motivation, status, created_at) VALUES
('DBATU/NCC/CHEM/2024/001', 'Vikram Patil', 'vikram.patil@example.com', '9876543218', 'Chemical Engineering', 'Second Year', 'Male', 'Want to develop leadership and management skills.', 'approved', '2024-03-15 13:30:00'),
('DBATU/NCC/CHEM/2024/002', 'Sneha Joshi', 'sneha.joshi@example.com', '9876543219', 'Chemical Engineering', 'First Year', 'Female', 'Interested in national integration and social awareness.', 'pending', '2024-03-16 14:15:00');

-- Add some very recent applications (today's applications)
INSERT INTO ncc_applications (registration_id, full_name, email, phone, branch, current_year, gender, motivation, status, created_at) VALUES
('DBATU/NCC/CSE/2024/003', 'Aditya Mehta', 'aditya.mehta@example.com', '9876543220', 'Computer Engineering', 'First Year', 'Male', 'Passionate about cybersecurity and want to serve in defense.', 'pending', NOW()),
('DBATU/NCC/MECH/2024/003', 'Riya Kapoor', 'riya.kapoor@example.com', '9876543221', 'Mechanical Engineering', 'Second Year', 'Female', 'Want to join armed forces through NCC entry.', 'pending', NOW()),
('DBATU/NCC/EE/2024/003', 'Arjun Singh', 'arjun.singh@example.com', '9876543222', 'Electrical Engineering', 'First Year', 'Male', 'Interested in drill and parade activities.', 'pending', NOW()); 