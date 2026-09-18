CREATE DATABASE IF NOT EXISTS allowance_db;

USE allowance_db;

CREATE TABLE IF NOT EXISTS student_name (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    course VARCHAR(100) NOT NULL,
    year_level VARCHAR(10),
    allowance DECIMAL(10,2) NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
