-- Create Database
CREATE DATABASE IF NOT EXISTS miss_rose_store;
USE miss_rose_store;

-- Categories Table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products Table
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    image VARCHAR(255),
    category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Users Table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders Table
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    address TEXT NOT NULL,
    phone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Order Items Table
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Insert Categories
INSERT INTO categories (name, description) VALUES 
('Lips', 'Lipsticks, lip glosses, and lip care products'),
('Eyes', 'Mascara, eyeliner, and eye shadows'),
('Face', 'Foundation, concealer, and face powders'),
('Palettes', 'Makeup palettes and sets'),
('Tools', 'Makeup brushes and accessories'),
('Nails', 'Nail polishes and nail care'),
('Cheeks', 'Blush, bronzer, and highlighters');

-- Insert Products
INSERT INTO products (name, description, price, category_id, stock, image) VALUES 
('Red Lipstick', 'Long-lasting matte lipstick with intense color payoff', 19.99, 1, 50, 'lipstick-red.jpg'),
('Black Mascara', 'Volumizing and lengthening mascara', 15.99, 2, 40, 'mascara-black.jpg'),
('Medium Foundation', 'Full coverage foundation with natural finish', 29.99, 3, 30, 'foundation-medium.jpg'),
('Eyeshadow Palette', 'Professional 12-shade palette', 45.99, 4, 25, 'eyeshadow-palette.jpg'),
('Makeup Brush Set', 'Professional 12-piece brush set', 39.99, 5, 20, 'brush-set.jpg'),
('Face Powder', 'Translucent setting powder', 24.99, 3, 35, 'face-powder.jpg'),
('Pink Nail Polish', 'Long-lasting nail polish', 9.99, 6, 60, 'nail-polish-pink.jpg'),
('Black Eyeliner', 'Waterproof liquid eyeliner', 12.99, 2, 45, 'eyeliner-black.jpg'),
('Rose Blush', 'Natural finish blush', 22.99, 7, 30, 'blush-rose.jpg'),
('Light Concealer', 'Full coverage concealer', 17.99, 3, 40, 'concealer-light.jpg');

-- Insert Admin User (password: password)
INSERT INTO users (name, email, password, is_admin) VALUES 
('Admin User', 'admin@missrose.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

-- Insert Sample User (password: password123)
INSERT INTO users (name, email, password) VALUES 
('John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert Sample Orders
INSERT INTO orders (user_id, total_amount, status, address, phone) VALUES 
(2, 65.97, 'pending', '123 Main St, City, Country', '1234567890'),
(2, 89.98, 'processing', '456 Oak St, City, Country', '0987654321');

-- Insert Sample Order Items
INSERT INTO order_items (order_id, product_id, quantity, price) VALUES 
(1, 1, 1, 19.99),
(1, 2, 1, 15.99),
(1, 7, 3, 9.99),
(2, 4, 1, 45.99),
(2, 6, 1, 24.99),
(2, 8, 1, 12.99);

-- Add indexes for better performance
ALTER TABLE products ADD INDEX idx_category (category_id);
ALTER TABLE orders ADD INDEX idx_user (user_id);
ALTER TABLE order_items ADD INDEX idx_order (order_id);
ALTER TABLE order_items ADD INDEX idx_product (product_id);

-- Create cart table for shopping cart functionality
CREATE TABLE cart (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Create wishlist table
CREATE TABLE wishlist (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    UNIQUE KEY unique_wish (user_id, product_id)
);

-- Create reviews table
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Add indexes for cart, wishlist, and reviews
ALTER TABLE cart ADD INDEX idx_user_product (user_id, product_id);
ALTER TABLE wishlist ADD INDEX idx_user_product (user_id, product_id);
ALTER TABLE reviews ADD INDEX idx_product (product_id);