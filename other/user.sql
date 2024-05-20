--  mysql -u root -p

CREATE DATABASE photofox;

USE photofox;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    permission_level TINYINT NOT NULL CHECK (permission_level BETWEEN 0 AND 10),
    posts_quantity INT DEFAULT 0,
    profile_pic VARCHAR(255),
    member_since DATE NOT NULL,
    followers INT DEFAULT 0,
    warnings INT DEFAULT 0,
    primary_color CHAR(7),
    biography TEXT,
    birthday DATE
);

CREATE TABLE Posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255),
    description TEXT,
    src VARCHAR(255),
    views INT DEFAULT 0,
    likes INT DEFAULT 0,
    allowed BOOLEAN DEFAULT TRUE,
    reported BOOLEAN DEFAULT FALSE,
    tags JSON,
    posted_at DATETIME NOT NULL,
    type ENUM('video', 'image') NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users(id)
);

CREATE TABLE Comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    answer_of INT,
    content TEXT NOT NULL,
    reported BOOLEAN DEFAULT FALSE,
    allowed BOOLEAN DEFAULT TRUE,
    written_at DATETIME NOT NULL,
    thumbs_up INT DEFAULT 0,
    thumbs_down INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES Users(id),
    FOREIGN KEY (post_id) REFERENCES Posts(id) ON DELETE CASCADE,
    FOREIGN KEY (answer_of) REFERENCES Comments(id) ON DELETE CASCADE
);

CREATE TABLE Followers (
    follower_id INT NOT NULL,
    followed_id INT NOT NULL,
    PRIMARY KEY (follower_id, followed_id),
    FOREIGN KEY (follower_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (followed_id) REFERENCES Users(id) ON DELETE CASCADE
);


-- Insert a sample user (username: admin, password: password123 hashed with bcrypt)
INSERT INTO users (email, name, username, password, permission_level, member_since) VALUES (
    'admin@example.com',
    'Admin User',
    'admin',
    '$2y$10$e0MYzXyjpJS2Hd/ZKiT/bOQEE5.YSU1aGB/XRCq1UtQF7vAB1D1sy',
    32,
    now()
); 