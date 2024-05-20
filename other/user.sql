CREATE DATABASE photofox;

USE photofox;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    permission-level TINYINT(32) DEFAULT 0
);

-- Insert a sample user (username: admin, password: password123 hashed with bcrypt)
INSERT INTO users (email, name, username, password, permission_level) VALUES (
    'admin@example.com',
    'Admin User',
    'admin',
    '$2y$10$e0MYzXyjpJS2Hd/ZKiT/bOQEE5.YSU1aGB/XRCq1UtQF7vAB1D1sy',
    32
); 


--  mysql -u root -p