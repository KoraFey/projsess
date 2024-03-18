--create table user
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    url_pfp VARCHAR(255),
    type_usager ENUM('regulier', 'admin') NOT NULL DEFAULT 'regulier'
);


--creation de la table settings
CREATE TABLE settings(
    user_id INT,
    dark_mode BOOLEAN NOT NULL DEFAULT 0,
    notification BOOLEAN NOT NULL DEFAULT 0,
    
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
);


--table block list
CREATE TABLE Block_List(
    id int PRIMARY KEY,
    user_id int NOT NULL,
    blocked_id int NOT NULL,

    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (blocked_id) REFERENCES users(id)

);