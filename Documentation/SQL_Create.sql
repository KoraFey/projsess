-- drop les tables sil existent deja
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

DROP TABLE IF EXISTS publication_tags;
DROP TABLE IF EXISTS publication_images;
DROP TABLE IF EXISTS publication_commentaire;
DROP TABLE IF EXISTS publication_likes;

DROP TABLE IF EXISTS Publication;
DROP TABLE IF EXISTS Chat_Room_User;
DROP TABLE IF EXISTS Chat_Room;
DROP TABLE IF EXISTS Block_List;
DROP TABLE IF EXISTS settings;
DROP TABLE IF EXISTS users;

-- create table user
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    url_pfp VARCHAR(255),
    type_usager ENUM('regulier', 'admin') NOT NULL DEFAULT 'regulier'
);

-- creation de la table settings
CREATE TABLE settings(
    user_id INT,
    dark_mode BOOLEAN NOT NULL DEFAULT 0,
    notification BOOLEAN NOT NULL DEFAULT 0,
    
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
);

-- table block list
CREATE TABLE Block_List(
    id int PRIMARY KEY,
    user_id int NOT NULL,
    blocked_id int NOT NULL,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (blocked_id) REFERENCES users(id) ON DELETE CASCADE
);

-- table des chat room
CREATE TABLE Chat_Room(
    id int AUTO_INCREMENT PRIMARY KEY,
    owner_id int,
    name varchar(50) NOT NULL,
    url_icone varchar(255)
);

-- liaison chat room et user
CREATE TABLE Chat_Room_User(
    chat_room_id int NOT NULL,
    user_id int NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (chat_room_id) REFERENCES Chat_Room(id) ON DELETE CASCADE
);

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `logs` (
  `user_id` int(11) NOT NULL,
  `chatroom_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `time` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `logs`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `chatroom_id` (`chatroom_id`);

-- pour les posts
CREATE TABLE Publication (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    description VARCHAR(1000),
    type VARCHAR(20) CHECK (type IN ('actualite', 'annonce')),
    prix DECIMAL(10, 2),
    date_publication DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE publication_tags (
    id_publication INT,
    user_id INT,
    PRIMARY KEY (id_publication, user_id),
    FOREIGN KEY (id_publication) REFERENCES Publication(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE publication_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_publication INT,
    url VARCHAR(255),
    FOREIGN KEY (id_publication) REFERENCES Publication(id)
);

CREATE TABLE publication_commentaire (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_publication INT,
    user_id INT,
    commentaire VARCHAR(255),
    FOREIGN KEY (id_publication) REFERENCES Publication(id),
    FOREIGN KEY (user_id) REFERENCES users(id)

);

CREATE TABLE publication_likes (
    id_publication INT,
    user_id INT,
    PRIMARY KEY (id_publication, user_id),
    FOREIGN KEY (id_publication) REFERENCES Publication(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);