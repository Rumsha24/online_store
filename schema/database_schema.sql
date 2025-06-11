CREATE DATABASE IF NOT EXISTS ecommerce;
USE ecommerce;

-- USERS Table
CREATE TABLE users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    username VARCHAR(50),
    shippingAddress TEXT
);

-- PRODUCTS Table
CREATE TABLE products (
    productID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL, -- Added name column
    description TEXT,
    image VARCHAR(255),
    price DECIMAL(10, 2),
    shippingCost DECIMAL(10, 2)
);

-- COMMENTS Table
CREATE TABLE comments (
    commentID INT AUTO_INCREMENT PRIMARY KEY,
    productID INT,
    userID INT,
    rating INT,
    image VARCHAR(255),
    text TEXT,
    FOREIGN KEY (productID) REFERENCES products(productID) ON DELETE CASCADE,
    FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE CASCADE
);

-- CART Table
CREATE TABLE cart (
    cartID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    productID INT,
    quantity INT,
    FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE CASCADE,
    FOREIGN KEY (productID) REFERENCES products(productID) ON DELETE CASCADE,
    UNIQUE KEY unique_user_product (userID, productID)
);

-- ORDERS Table
CREATE TABLE orders (
    orderID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    orderDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    totalAmount DECIMAL(10,2),
    FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE CASCADE
);

-- WISHLISTS Table (Corrected Foreign Keys)
CREATE TABLE wishlists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(userID) ON DELETE CASCADE,       -- CORRECTED
    FOREIGN KEY (product_id) REFERENCES products(productID) ON DELETE CASCADE, -- CORRECTED
    UNIQUE KEY unique_wishlist (user_id, product_id)
);

-- Sample data for testing
INSERT INTO users (email, password, username, shippingAddress) VALUES
('test@example.com', 'testpass123', 'TestUser', '123 Main St'),
('john.doe@example.com', 'hashedpassword', 'JohnDoe', '456 Oak Ave');

INSERT INTO products (name, description, image, price, shippingCost) VALUES
('Velvet Aurora', 'A radiant blend of violet, musk, and soft amber for a dreamy evening. 100ml', 'Velvet Aurora.jpeg', 99.00, 0.00),
('Midnight Peony', 'Peony and blackcurrant wrapped in a mysterious vanilla base. 50ml', 'Midnight Peony.jpeg', 120.00, 0.00),
('Amber Whisper', 'Warm amber, sandalwood, and a hint of fig for a cozy embrace. 90ml', 'Amber Whisper.jpeg', 88.00, 0.00),
('Celestial Bloom', 'A celestial bouquet of jasmine, neroli, and white tea. 100ml', 'Celestial Bloom.jpeg', 135.00, 0.00),
('Rosewood Reverie', 'Rose, cedar, and a touch of citrus for a modern classic. 50ml', 'ROSEWOOD.jpeg', 105.00, 0.00),
('Golden Mirage', 'A sparkling blend of saffron, pear, and golden woods. 90ml', 'Golden Mirage.jpeg', 112.50, 0.00),
('Lush Serenity', 'Green tea, bamboo, and lotus for a calming escape. 75ml', 'Lush Serenity.jpeg', 89.00, 0.00),
('Moonlit Jasmine', 'Night-blooming jasmine with hints of citrus and musk. 80ml', 'Moonlit Jasmine.jpeg', 75.00, 0.00),
('Saffron Veil', 'Saffron, rose, and creamy sandalwood for a rich finish. 50ml', 'Saffron Veil.jpeg', 120.00, 0.00),
('Petal Noir', 'Dark rose, patchouli, and black pepper for a bold statement. 100ml', 'Petal Noir.jpeg', 130.00, 0.00),
('Azure Muse', 'Aquatic notes, blue lotus, and driftwood for a fresh vibe. 100ml', 'Azure Muse.jpeg', 108.00, 0.00),
('Blush Ember', 'Pink pepper, rose, and smoky woods for a warm embrace. 85ml', 'Blush Ember.jpeg', 118.00, 0.00),
('Opal Essence', 'Iris, white musk, and pear for a luminous signature. 100ml', 'Opal Essence.jpeg', 95.00, 0.00),
('Wild Iris', 'Wild iris, bergamot, and vetiver for a fresh, green scent. 75ml', 'Wild Iris.jpeg', 89.00, 0.00),
('Enchanted Fig', 'Fig, coconut, and tonka bean for a sweet, creamy finish. 90ml', 'Enchanted Fig.jpeg', 122.00, 0.00);

