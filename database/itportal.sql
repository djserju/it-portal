-- Export for database: itportal
-- Structure and sample data

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Create and select the application database
CREATE DATABASE IF NOT EXISTS itportal
  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE itportal;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS staff;
DROP TABLE IF EXISTS courses;

-- Course records
CREATE TABLE courses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(25) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    credits TINYINT UNSIGNED NOT NULL,
    prerequisites VARCHAR(255) NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Staff profiles and photo file names
CREATE TABLE staff (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    photo VARCHAR(255) NOT NULL
);

-- Contact form submissions
CREATE TABLE messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Administrator login accounts
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

-- Sample data
-- 10 sample IT courses
INSERT INTO courses (code, name, credits, prerequisites, description) VALUES
('ITT101', 'Computer Information Systems', 3, NULL, 'Introduction to computer hardware and software.'),
('ITT102', 'Programming Techniques', 3, 'ITT101', 'Fundamentals of structured programming.'),
('ITT200', 'Object-Oriented Programming', 3, 'ITT102', 'Principles of OOP.'),
('ITT201', 'Data Structures and File Management', 3, 'ITT200', 'Design and implementation of arrays, stacks and queues.'),
('ITT202', 'Internet Authoring I', 3, 'ITT101', 'Client-side web development using HTML5.'),
('ITT301', 'Database Management Systems', 3, 'ITT201', 'Relational database design, normalization and SQL quering.'),
('ITT302', 'Computer Networks and Data Communications', 3, 'ITT101', 'OSI and TCP/IP models, routing, switching and network protocols.'),
('ITT303', 'Internet Authoring II', 3, 'ITT202', 'Server-side web application development using PHP and MySQL.'),
('ITT401', 'Information Systems Security', 3, 'ITT302', 'Cybersecurity principles, cryptography, risk management and network defense.'),
('ITT402', 'Software Engineering', 3, 'ITT301', 'Software development life cycle, agile methodologies and system testing.');

-- 5 sample staff members
INSERT INTO staff (name, position, phone, email, photo) VALUES
('Mrs. Marcia Campbell', 'Head of Department (IT)', '876-906-3000', 'hod.it@ucc.edu.jm', 'staff_hod.jpg'),
('Mr. Devon Brown', 'Senior Lecturer - Software Engineering', '876-906-3011', 'dbrown@ucc.edu.jm', 'staff_brown.jpg'),
('Ms. Simone Reid', 'Lecturer - Database & Web Systems', '876-906-3012', 'sreid@ucc.edu.jm', 'staff_reid.jpg'),
('Mr. Andre Grant', 'Lecturer - Networking & Security', '876-906-3013', 'agrant@ucc.edu.jm', 'staff_grant.jpg'),
('Mrs. Keisha Thompson', 'Departmental Administrative Assistant', '876-906-3014', 'kthompson@ucc.edu.jm', 'staff_thompson.jpg');

-- 1 sample admin account
-- The password is stored only as a PHP password_hash() value.
INSERT INTO users (name, email, password_hash) VALUES
('IT Portal Admin', 'admin@ucc.edu.jm', '$2y$10$trWE3jZvcYncqX9qi52tKuWvU.RpMUSoDURLekFGImmpNGLREwGKW');