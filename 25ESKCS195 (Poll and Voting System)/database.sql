-- =========================================================
-- Polling and Voting System - Database Script
-- =========================================================
-- How to use:
-- 1. Open phpMyAdmin (http://localhost/phpmyadmin)
-- 2. Click "Import" and select this file
--    OR copy-paste this whole script into the SQL tab and run it
-- =========================================================

-- Create the database
CREATE DATABASE IF NOT EXISTS polling_system;
USE polling_system;

-- ---------------------------------------------------------
-- Table: users
-- Stores normal (voter) accounts
-- ---------------------------------------------------------
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,   -- stores a hashed password, never plain text
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------
-- Table: admin
-- Stores admin accounts (separate from normal users)
-- ---------------------------------------------------------
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- NOTE: We do NOT insert the default admin here, because passwords must be
-- hashed using PHP's password_hash() function to work with password_verify().
-- After importing this file, open setup_admin.php ONE TIME in your browser
-- (example: http://localhost/polling-voting-system/setup_admin.php)
-- It will create the default admin account for you:
--   username: admin
--   password: admin123
-- Delete setup_admin.php after you have used it, for security.

-- ---------------------------------------------------------
-- Table: polls
-- Stores each poll question created by admin
-- ---------------------------------------------------------
CREATE TABLE polls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------
-- Table: poll_options
-- Stores the possible answer options for each poll
-- ---------------------------------------------------------
CREATE TABLE poll_options (
    id INT AUTO_INCREMENT PRIMARY KEY,
    poll_id INT NOT NULL,
    option_text VARCHAR(150) NOT NULL,
    FOREIGN KEY (poll_id) REFERENCES polls(id) ON DELETE CASCADE
);

-- ---------------------------------------------------------
-- Table: votes
-- Stores each vote. One row = one user's vote in one poll.
-- The UNIQUE KEY below stops a user voting twice in the same poll.
-- ---------------------------------------------------------
CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    poll_id INT NOT NULL,
    option_id INT NOT NULL,
    user_id INT NOT NULL,
    voted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (poll_id) REFERENCES polls(id) ON DELETE CASCADE,
    FOREIGN KEY (option_id) REFERENCES poll_options(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY one_vote_per_poll (poll_id, user_id)
);

-- ---------------------------------------------------------
-- Sample data (optional) - a demo poll so the app is not empty
-- ---------------------------------------------------------
INSERT INTO polls (question, status) VALUES
('What is your favorite programming language?', 'active');

INSERT INTO poll_options (poll_id, option_text) VALUES
(1, 'PHP'),
(1, 'Python'),
(1, 'JavaScript'),
(1, 'Java');
