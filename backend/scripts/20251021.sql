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

-- Seating
    CREATE TABLE seating (
        id INT AUTO_INCREMENT PRIMARY KEY,
        table_no INT UNIQUE NOT NULL,
        status CHAR(1) NOT NULL CHECK (status IN ('F', 'P', 'C')), -- F=Free, P=Pending, C=Complete
        floor INT NOT NULL
    );

    INSERT INTO seating (table_no, status, floor) VALUES (1, 'F', 1);
    INSERT INTO seating (table_no, status, floor) VALUES (2, 'F', 1);
    INSERT INTO seating (table_no, status, floor) VALUES (3, 'F', 1);
    INSERT INTO seating (table_no, status, floor) VALUES (4, 'F', 1);
    INSERT INTO seating (table_no, status, floor) VALUES (5, 'F', 2);
    INSERT INTO seating (table_no, status, floor) VALUES (6, 'F', 2);
    INSERT INTO seating (table_no, status, floor) VALUES (7, 'F', 2);
    INSERT INTO seating (table_no, status, floor) VALUES (8, 'F', 2);
    INSERT INTO seating (table_no, status, floor) VALUES (9, 'F', 3);
    INSERT INTO seating (table_no, status, floor) VALUES (10, 'F', 3);
    INSERT INTO seating (table_no, status, floor) VALUES (11, 'F', 3);
    INSERT INTO seating (table_no, status, floor) VALUES (12, 'F', 3);

-- Category
    CREATE TABLE category (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        description TEXT,
        status BIT NOT NULL
    );

    INSERT INTO category (name, description, status) VALUES ('Coffee', 'Coffee drinks to boost your day.', 1);
    INSERT INTO category (name, description, status) VALUES ('Juices', 'Healthy juices that taste great.', 1);
    INSERT INTO category (name, description, status) VALUES ('Cakes', 'Beautiful cake slices that look super appetizing.', 1);
    INSERT INTO category (name, description, status) VALUES ('Cookies', 'Delicious cookies baked with love.', 1);

-- Item
    CREATE TABLE item (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(200) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL,
        image_url VARCHAR(200),
        category_id INT NOT NULL,
        FOREIGN KEY (category_id) REFERENCES category(id)
    );

    INSERT INTO item (name, description, price, image_url, category_id) VALUES
        ('Espresso', 'Strong and rich single-shot espresso to kickstart your day.', 6.50, '/coffee_espresso.png', 1),
        ('Americano', 'Smooth black coffee made with espresso and hot water.', 7.00, '/coffee_americano.png', 1),
        ('Cappuccino', 'Espresso topped with steamed milk and frothy foam.', 8.00, '/coffee_cappuccino.png', 1);

    INSERT INTO item (name, description, price, image_url, category_id) VALUES
        ('Orange Juice', 'Freshly squeezed oranges packed with vitamin C.', 6.00, '/juice_orange.png', 2),
        ('Apple Juice', 'Crisp and refreshing apple juice.', 6.00, '/juice_apple.png', 2),
        ('Watermelon Cooler', 'Chilled watermelon juice with a hint of mint.', 7.00, '/juice_watermelon.png', 2);

    INSERT INTO item (name, description, price, image_url, category_id) VALUES
        ('Chocolate Fudge Cake', 'Rich and moist chocolate cake with creamy fudge frosting.', 12.00, '/cake_chocolate_fudge.png', 3),
        ('Cheesecake', 'Classic creamy cheesecake with a buttery biscuit base.', 11.00, '/cake_cheesecake.png', 3),
        ('Red Velvet Cake', 'Soft red velvet sponge layered with cream cheese frosting.', 12.50, '/cake_red_velvet.png', 3);

    INSERT INTO item (name, description, price, image_url, category_id) VALUES
        ('Chocolate Chip Cookie', 'Classic chewy cookie loaded with chocolate chips.', 4.00, '/cookie_choc_chip.png', 4),
        ('Oatmeal Raisin Cookie', 'Hearty cookie with oats and sweet raisins.', 4.50, '/cookie_oatmeal_raisin.png', 4),
        ('Double Chocolate Cookie', 'Rich chocolate cookie with chocolate chunks.', 4.50, '/cookie_double_choc.png', 4);

-- Orders
    CREATE TABLE orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        table_id INT NOT NULL,
        order_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        total DECIMAL(10,2) NOT NULL,
        pax INT NOT NULL, 
        status CHAR(1) NOT NULL CHECK (status IN ('N', 'Y')),
        FOREIGN KEY (table_id) REFERENCES seating(id)
    );
    INSERT INTO orders (table_id, total, pax, status) VALUES (1, 10.2, 1, 'Y');
    INSERT INTO orders (table_id, total, pax, status) VALUES (2, 8.2, 2, 'Y');
    INSERT INTO orders (table_id, total, pax, status) VALUES (3, 6.2, 2, 'Y');
    INSERT INTO orders (table_id, total, pax, status) VALUES (4, 10.0, 2, 'Y');
    INSERT INTO orders (table_id, total, pax, status) VALUES (5, 4.4, 2, 'Y');

-- Order Details
    CREATE TABLE order_details (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        item_id INT NOT NULL,
        quantity INT NOT NULL DEFAULT 1,
        status CHAR(1) NOT NULL CHECK (status IN ('O', 'P', 'D')), -- Ordered, Pending, Delivered,
        FOREIGN KEY (order_id) REFERENCES orders(id),
        FOREIGN KEY (item_id) REFERENCES item(id)
    );

    INSERT INTO order_details (order_id, item_id, quantity, status) VALUES (1, 1, 1, 'D');
    INSERT INTO order_details (order_id, item_id, quantity, status) VALUES (1, 2, 1, 'D');
    INSERT INTO order_details (order_id, item_id, quantity, status) VALUES (2, 3, 1, 'D');
    INSERT INTO order_details (order_id, item_id, quantity, status) VALUES (2, 3, 1, 'D');
    INSERT INTO order_details (order_id, item_id, quantity, status) VALUES (3, 4, 2, 'D');
    INSERT INTO order_details (order_id, item_id, quantity, status) VALUES (3, 4, 2, 'D');
