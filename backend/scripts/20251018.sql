DROP DATABASE IF EXISTS se_project;
CREATE DATABASE se_project;
USE se_project;

-- Users
    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        role CHAR NOT NULL, -- A=Admin, C=Cashier, K=KitchenStaff
        password VARCHAR(255) NOT NULL 
    );

    INSERT INTO users (name, email, role, password) VALUES ('admin', 'admin@gmail.com', 'A', 'admin');

-- Session
    CREATE TABLE session (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        token VARCHAR(64) NOT NULL,
        expire_at DATETIME NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );

-- ------------------------------
-- Table (Dining Table)
-- ------------------------------
CREATE TABLE seating (
    id INT AUTO_INCREMENT PRIMARY KEY,
    table_no INT UNIQUE NOT NULL,
    status CHAR(1) NOT NULL CHECK (status IN ('F', 'P', 'C')), -- F=Free, P=Pending, C=Complete
    floor INT NOT NULL
);

-- ------------------------------
-- Category Table
-- ------------------------------
CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    `desc` TEXT,
    status BIT NOT NULL
);

-- ------------------------------
-- Item Table
-- ------------------------------
CREATE TABLE item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    `desc` TEXT,
    price DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(200),
    category_id INT NOT NULL,
    FOREIGN KEY (category_id) REFERENCES category(id)
);

-- ------------------------------
-- Order Table
-- ------------------------------
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    table_id INT NOT NULL,
    order_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    pax INT NOT NULL, 
    FOREIGN KEY (table_id) REFERENCES seating(id)
);

-- ------------------------------
-- Order Details Table
-- ------------------------------
CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    item_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (item_id) REFERENCES item(id)
);
