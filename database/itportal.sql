-- Database: itportal
-- Purpose: Stores courses, staff profiles, HOD messages and admin login accounts.

-- Creates the database if it does not already exist, then uses itportal
CREATE DATABASE IF NOT EXISTS itportal;
USE itportal;

-- Courses table stores academic courses. 
-- 'code' has a unique constraint to prevent duplicate course codes.
-- 'prerequisites' allows NULL because introductory courses have no prerequisites.
CREATE TABLE courses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code CHAR(6) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    credits TINYINT UNSIGNED NOT NULL,
    prerequisites VARCHAR(255) DEFAULT NULL,
    description TEXT NOT NULL
);

-- Staff table stores staff. 
-- 'photo' stores the image filename saved in the uploads folder
CREATE TABLE staff (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    photo VARCHAR(255) NOT NULL
);

-- Messages table stores student inquiries submitted via the "Contact the HOD" form
-- 'created_at' automatically records the date and time each message is saved.
CREATE TABLE messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Users table stores authorized departmental staff accounts for the admin dashboard.
-- Passwords are stored as secure hashes.
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

-- Sample data
-- 10 Sample IT courses
INSERT INTO courses (code, name, credits, prerequisites, description) VALUES
('ITT101', 'Computer Information Systems', 3, NULL, 'Introduction to computer hardware and software.'),
('ITT102', 'Programming Techniques', 3, ITT101, 'Fundamentals of structured programming.'),
('ITT200', 'Object-Oriented Programming', 3, ITT102, 'Principles of OOP.'),
('ITT201', 'Data Structures and File Management', 3, ITT200, 'Design and implementation of arrays, stacks and queues.'),
('ITT202', 'Internet Authoring I', 3, ITT101, 'Client-side web development using HTML5.'),
('ITT301', 'Database Management Systems', 3, ITT201, 'Relational database design, normalization and SQL quering.'),
('ITT302', 'Computer Networks and Data Communications', 3, ITT101, 'OSI and TCP/IP models, routing, switching and network protocols.'),
('ITT303', 'Internet Authoring II', 3, ITT202, 'Server-side web application development using PHP and MySQL.'),
('ITT401', 'Information Systems Security', 3, ITT302, 'Cybersecurity principles, cryptography, risk management and network defense.'),
('ITT402', 'Software Engineering', 3, ITT301, 'Software development life cycle, agile methodologies and system testing.');

-- 5 Sample staff members
INSERT INTO staff (name, position, phone, email, photo) VALUES
('Mrs. Marcia Campbell', 'Head of Department (IT)', '876-906-3000', 'hod.it@ucc.edu.jm', 'staff_hod.jpg'),
('Mr. Devon Brown', 'Senior Lecturer - Software Engineering', '876-906-3011', 'dbrown@ucc.edu.jm', 'staff_brown.jpg'),
('Ms. Simone Reid', 'Lecturer - Database & Web Systems', '876-906-3012', 'sreid@ucc.edu.jm', 'staff_reid.jpg'),
('Mr. Andre Grant', 'Lecturer - Networking & Security', '876-906-3013', 'agrant@ucc.edu.jm', 'staff_grant.jpg'),
('Mrs. Keisha Thompson', 'Departmental Administrative Assistant', '876-906-3014', 'kthompson@ucc.edu.jm', 'staff_thompson.jpg');

-- Sample admin user account
-- Login email: admin@ucc.edu.jm
-- Login password: Password123! 
-- Password is hashed using PHP password_hash()
INSERT INTO users (name, email, password_hash) VALUES
('IT Portal Admin', 'admin@ucc.edu.jm', '$2y$10$gdZ5BEDbuWfcwd8.nQT/hO09cNRXrn.7YVQnlP/Uktb3JWlGrbTJ2');