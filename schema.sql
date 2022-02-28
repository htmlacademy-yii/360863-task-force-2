CREATE DATABASE IF NOT EXISTS task_force
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE task_force;

CREATE TABLE IF NOT EXISTS user (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    registration_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                    name VARCHAR(79) NOT NULL,
                                    email VARCHAR(79) NOT NULL UNIQUE,
                                    password VARCHAR(79) NOT NULL,
                                    avatar VARCHAR(255),
                                    birth_date DATETIME,
                                    telephone INT(11),
                                    telegram VARCHAR(64),
                                    description VARCHAR(255),
                                    rating INT(63),
                                    user_role_id INT,
                                    city_id INT,
                                    user_status_id INT
);

CREATE TABLE IF NOT EXISTS user_role (
                                         id INT AUTO_INCREMENT PRIMARY KEY,
                                         title VARCHAR(79) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS city (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    title VARCHAR(192) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS user_status (
                                           id INT AUTO_INCREMENT PRIMARY KEY,
                                           title VARCHAR(79) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS reviews (
                                       id INT AUTO_INCREMENT PRIMARY KEY,
                                       description VARCHAR(255) NOT NULL,
                                       creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                       task_id INT,
                                       grade_id INT
);

CREATE TABLE IF NOT EXISTS grade (
                                     id INT AUTO_INCREMENT PRIMARY KEY,
                                     value INT(8) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS task (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    title VARCHAR(79) NOT NULL,
                                    description VARCHAR(159) NOT NULL,
                                    budget INT,
                                    creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                    expiration_date DATETIME,
                                    address_description VARCHAR(255),
                                    task_status_id INT,
                                    category_id INT,
                                    customer_id INT,
                                    worker_id INT,
                                    task_address_id INT
);

CREATE TABLE IF NOT EXISTS task_address (
                                            id INT AUTO_INCREMENT PRIMARY KEY,
                                            latitude FLOAT(15),
                                            longitude FLOAT(15),
                                            city_id INT
);

CREATE TABLE IF NOT EXISTS task_status (
                                           id INT AUTO_INCREMENT PRIMARY KEY,
                                           title VARCHAR(79) NOT NULL
);

CREATE TABLE IF NOT EXISTS task_files (
                                          id INT AUTO_INCREMENT PRIMARY KEY,
                                          file VARCHAR(255) NOT NULL,
                                          task_id INT
);

CREATE TABLE IF NOT EXISTS category (
                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                        title VARCHAR(79) NOT NULL
);

CREATE TABLE IF NOT EXISTS user_categories (
                                               id INT AUTO_INCREMENT PRIMARY KEY,
                                               category_id INT,
                                               worker_id INT
);

CREATE TABLE IF NOT EXISTS responses (
                                         id INT AUTO_INCREMENT PRIMARY KEY,
                                         message VARCHAR(255),
                                         price INT,
                                         creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                         task_id INT,
                                         worker_id INT
);

ALTER TABLE user
    ADD (
        FOREIGN KEY (user_role_id) REFERENCES user_role(id) ON DELETE CASCADE,
        FOREIGN KEY (city_id) REFERENCES city(id) ON DELETE CASCADE,
        FOREIGN KEY (user_status_id) REFERENCES user_status(id) ON DELETE CASCADE
        );

ALTER TABLE reviews
    ADD (
        FOREIGN KEY (task_id) REFERENCES task(id) ON DELETE CASCADE,
        FOREIGN KEY (grade_id) REFERENCES grade(id) ON DELETE CASCADE
        );

ALTER TABLE task
    ADD (
        FOREIGN KEY (task_status_id) REFERENCES task_status(id) ON DELETE CASCADE,
        FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE CASCADE,
        FOREIGN KEY (customer_id) REFERENCES user(id) ON DELETE CASCADE,
        FOREIGN KEY (worker_id) REFERENCES user(id) ON DELETE CASCADE,
        FOREIGN KEY (task_address_id) REFERENCES task_address(id) ON DELETE CASCADE
        );

ALTER TABLE task_address
    ADD (
        FOREIGN KEY (city_id) REFERENCES city(id) ON DELETE CASCADE
        );

ALTER TABLE task_files
    ADD (
        FOREIGN KEY (task_id) REFERENCES task(id) ON DELETE CASCADE
        );

ALTER TABLE user_categories
    ADD (
        FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE CASCADE,
        FOREIGN KEY (worker_id) REFERENCES user(id) ON DELETE CASCADE
        );

ALTER TABLE responses
    ADD (
        FOREIGN KEY (task_id) REFERENCES task(id) ON DELETE CASCADE,
        FOREIGN KEY (worker_id) REFERENCES user(id) ON DELETE CASCADE
        );