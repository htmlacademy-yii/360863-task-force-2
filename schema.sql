CREATE DATABASE IF NOT EXISTS task_force
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE task_force;

CREATE TABLE IF NOT EXISTS user (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    registration_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                    name VARCHAR(45) NOT NULL,
                                    email VARCHAR(45) NOT NULL UNIQUE,
                                    password VARCHAR(255) NOT NULL,
                                    avatar VARCHAR(255),
                                    birth_date DATETIME,
                                    telephone VARCHAR(20),
                                    telegram VARCHAR(45),
                                    description VARCHAR(255),
                                    city_id INT
);

CREATE TABLE IF NOT EXISTS city (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    title VARCHAR(45) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS review (
                                       id INT AUTO_INCREMENT PRIMARY KEY,
                                       description VARCHAR(255) NOT NULL,
                                       creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                       grade INT(7) NOT NULL,
                                       task_id INT NOT NULL

);

CREATE TABLE IF NOT EXISTS task (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    title VARCHAR(255) NOT NULL,
                                    description VARCHAR(255) NOT NULL,
                                    budget INT,
                                    creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                    expiration_date DATETIME,
                                    status TINYINT(1) NOT NULL,
                                    latitude FLOAT(15),
                                    longitude FLOAT(15),
                                    category_id INT NOT NULL,
                                    customer_id INT NOT NULL,
                                    worker_id INT,
                                    city_id INT


);

CREATE TABLE IF NOT EXISTS task_file (
                                          id INT AUTO_INCREMENT PRIMARY KEY,
                                          file VARCHAR(255) NOT NULL,
                                          mime_type INT(1) NOT NULL DEFAULT 1,
                                          task_id INT NOT NULL
);

CREATE TABLE IF NOT EXISTS category (
                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                        title VARCHAR(45) NOT NULL
);

CREATE TABLE IF NOT EXISTS user_category (
                                               id INT AUTO_INCREMENT PRIMARY KEY,
                                               category_id INT NOT NULL,
                                               user_id INT NOT NULL
);

CREATE TABLE IF NOT EXISTS response (
                                         id INT AUTO_INCREMENT PRIMARY KEY,
                                         message VARCHAR(255),
                                         price INT NOT NULL,
                                         creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                         task_id INT NOT NULL,
                                         user_id INT NOT NULL
);

ALTER TABLE user
    ADD (
        FOREIGN KEY (city_id) REFERENCES city(id)
        );

ALTER TABLE review
    ADD (
        FOREIGN KEY (task_id) REFERENCES task(id)
        );

ALTER TABLE task
    ADD (
        FOREIGN KEY (category_id) REFERENCES category(id),
        FOREIGN KEY (customer_id) REFERENCES user(id),
        FOREIGN KEY (worker_id) REFERENCES user(id),
        FOREIGN KEY (city_id) REFERENCES city(id)
        );

ALTER TABLE task_file
    ADD (
        FOREIGN KEY (task_id) REFERENCES task(id)
        );

ALTER TABLE user_category
    ADD (
        FOREIGN KEY (category_id) REFERENCES category(id),
        FOREIGN KEY (user_id) REFERENCES user(id)
        );

ALTER TABLE response
    ADD (
        FOREIGN KEY (task_id) REFERENCES task(id),
        FOREIGN KEY (user_id) REFERENCES user(id)
        );