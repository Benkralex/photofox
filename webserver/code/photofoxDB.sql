
CREATE DATABASE IF NOT EXISTS `photofox`;

USE `photofox`;

CREATE USER IF NOT EXISTS 'photofoxDBuser'@'db' IDENTIFIED BY '#!2024passw0rdDB';
GRANT ALL PRIVILEGES ON `photofox`.* TO 'photofoxDBuser'@'db';
FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    permission_level TINYINT NOT NULL DEFAULT 0,
    profile_pic VARCHAR(255),
    member_since DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    warnings INT DEFAULT 0,
    primary_color CHAR(7),
    biography TEXT,
    birthday DATE
);

CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255),
    description TEXT,
    src VARCHAR(255),
    allowed BOOLEAN,
    reported BOOLEAN DEFAULT FALSE,
    tags JSON,
    posted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    comments_active BOOLEAN DEFAULT TRUE,
    type ENUM('video', 'image') NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    answer_of INT,
    content TEXT NOT NULL,
    reported BOOLEAN DEFAULT FALSE,
    allowed BOOLEAN DEFAULT TRUE,
    written_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    thumbs_up INT DEFAULT 0,
    thumbs_down INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (answer_of) REFERENCES comments(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS followers (
    follower_id INT NOT NULL,
    followed_id INT NOT NULL,
    PRIMARY KEY (follower_id, followed_id),
    FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (followed_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS views (
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    PRIMARY KEY (user_id, post_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS likes (
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    PRIMARY KEY (user_id, post_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS logincodes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    used BOOLEAN NOT NULL DEFAULT FALSE,
    active BOOLEAN NOT NULL DEFAULT TRUE,
    created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    code CHAR(7) NOT NULL UNIQUE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO users (email, name, username, password, permission_level) VALUES (
    'admin@foxgalaxy.de',
    'Admin',
    'ADMIN',
    '$2y$10$e0MYzXyjpJS2Hd/ZKiT/bOQEE5.YSU1aGB/XRCq1UtQF7vAB1D1sy!',
    10
);
