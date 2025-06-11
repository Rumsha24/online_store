CREATE DATABASE IF NOT EXISTS ecommerce;
USE ecommerce;

-- USERS
CREATE TABLE users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    username VARCHAR(50),
    shippingAddress TEXT
);

-- PRODUCTS
CREATE TABLE products (
    productID INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT,
    image VARCHAR(255),
    price DECIMAL(10, 2),
    shippingCost DECIMAL(10, 2)
);

-- COMMENTS
CREATE TABLE comments (
    commentID INT AUTO_INCREMENT PRIMARY KEY,
    productID INT,
    userID INT,
    rating INT,
    image VARCHAR(255),
    text TEXT,
    FOREIGN KEY (productID) REFERENCES products(productID),
    FOREIGN KEY (userID) REFERENCES users(userID)
);

-- CART
CREATE TABLE cart (
    cartID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    productID INT,
    quantity INT,
    FOREIGN KEY (userID) REFERENCES users(userID),
    FOREIGN KEY (productID) REFERENCES products(productID),
    UNIQUE KEY unique_user_product (userID, productID)
);

-- ORDERS
CREATE TABLE orders (
    orderID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    orderDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    totalAmount DECIMAL(10,2),
    FOREIGN KEY (userID) REFERENCES users(userID)
);

CREATE TABLE wishlists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    UNIQUE KEY unique_wishlist (user_id, product_id)
);

-- Sample data for testing
INSERT INTO users (email, password, username, shippingAddress) VALUES
('test@example.com', 'testpass123', 'TestUser', '123 Main St');

INSERT INTO products (description, image, price, shippingCost) VALUES
('Wireless Mouse', 'images/mouse.jpg', 29.99, 5.00),
('Gaming Keyboard', 'images/keyboard.jpg', 79.99, 7.00);
