-- Supprimer la table Chat_Room_User
DROP TABLE Chat_Room_User;

-- Supprimer la table Chat_Room
DROP TABLE Chat_Room;

-- Supprimer la table Block_List
DROP TABLE Block_List;

-- Supprimer la table settings
DROP TABLE settings;

-- Supprimer la table users
DROP TABLE users;



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

/*
-- user chat 1 on 1?
CREATE TABLE Chat_User(
    user_id int NOT NULL,
    user2_id int NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (user2_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE GIFs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    giphy_id VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    image_url VARCHAR(255) NOT NULL
);

INSERT INTO GIFs (giphy_id, title, url, image_url)
VALUES ('FiGiRei2ICzzG', 'Funny Cat GIF', 'http://giphy.com/gifs/funny-cat-FiGiRei2ICzzG', 'http://media0.giphy.com/media/FiGiRei2ICzzG/200.gif');
INSERT INTO GIFs (giphy_id, title, url, image_url)
VALUES ('AbCdEfG1HijK2Lmn', 'Cute Dog GIF', 'http://giphy.com/gifs/cute-dog-AbCdEfG1HijK2Lmn', 'http://media1.giphy.com/media/AbCdEfG1HijK2Lmn/200.gif');
INSERT INTO GIFs (giphy_id, title, url, image_url)
VALUES ('ETSLogo', 'École de Technologie Supérieure Logo', 'https://upload.wikimedia.org/wikipedia/en/2/2f/%C3%89cole_de_technologie_sup%C3%A9rieure_%28logo%29.png', 'https://upload.wikimedia.org/wikipedia/en/2/2f/%C3%89cole_de_technologie_sup%C3%A9rieure_%28logo%29.png');

*/