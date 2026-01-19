-- Create database
CREATE DATABASE IF NOT EXISTS user_db;
USE user_db;

-- =========================
-- USERS TABLE
-- =========================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    photo VARCHAR(255) DEFAULT NULL
);

-- Sample student (for login / demo)
INSERT INTO users (fullname, phone, email, password)
VALUES (
    'Test Student',
    '01700000000',
    'student@test.com',
    '$2y$10$eImiTXuWVxfM37uY4JANjQ=='
);

-- =========================
-- TEACHER TABLE
-- =========================
CREATE TABLE teacher (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Sample teacher
INSERT INTO teacher (teacher_name, email, password)
VALUES (
    'Test Teacher',
    'teacher@test.com',
    '123456'
);

-- =========================
-- COURSES TABLE
-- =========================
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(100) NOT NULL,
    course_code VARCHAR(50) NOT NULL
);

-- Sample course
INSERT INTO courses (course_name, course_code)
VALUES ('Web Programming', 'CSE-321');
