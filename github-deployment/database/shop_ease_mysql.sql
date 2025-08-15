-- ShopEase MySQL Database Structure and Sample Data
-- This file contains the complete database setup for MySQL/MariaDB

-- Create database (run this in phpMyAdmin or MySQL command line)
-- CREATE DATABASE IF NOT EXISTS shop_ease_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE shop_ease_db;

-- Users table
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Wallets table
CREATE TABLE IF NOT EXISTS `wallets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wallets_user_id_foreign` (`user_id`),
  CONSTRAINT `wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Wallet transactions table
CREATE TABLE IF NOT EXISTS `wallet_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wallet_id` bigint(20) unsigned NOT NULL,
  `type` enum('credit','debit') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wallet_transactions_wallet_id_foreign` (`wallet_id`),
  CONSTRAINT `wallet_transactions_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Categories table
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Brands table
CREATE TABLE IF NOT EXISTS `brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Products table
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `brand_id` bigint(20) unsigned DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_digital` tinyint(1) NOT NULL DEFAULT 0,
  `digital_file` varchar(255) DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `dimensions` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_brand_id_foreign` (`brand_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Shipping addresses table
CREATE TABLE IF NOT EXISTS `shipping_addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address_line_1` varchar(255) NOT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state_province` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipping_addresses_user_id_foreign` (`user_id`),
  CONSTRAINT `shipping_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Orders table
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `order_number` varchar(50) NOT NULL UNIQUE,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `shipping_address_id` bigint(20) unsigned DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `shipping_method` varchar(100) DEFAULT NULL,
  `shipping_cost` decimal(8,2) DEFAULT 0.00,
  `tax_amount` decimal(8,2) DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_shipping_address_id_foreign` (`shipping_address_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_shipping_address_id_foreign` FOREIGN KEY (`shipping_address_id`) REFERENCES `shipping_addresses` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Order items table
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Order tracking table
CREATE TABLE IF NOT EXISTS `order_trackings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `status` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `tracked_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_trackings_order_id_foreign` (`order_id`),
  CONSTRAINT `order_trackings_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Product reviews table
CREATE TABLE IF NOT EXISTS `product_reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_reviews_product_id_foreign` (`product_id`),
  KEY `product_reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Chat rooms table
CREATE TABLE IF NOT EXISTS `chat_rooms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `status` enum('open','closed') NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_rooms_user_id_foreign` (`user_id`),
  CONSTRAINT `chat_rooms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Chat messages table
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `chat_room_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `message` text NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_messages_chat_room_id_foreign` (`chat_room_id`),
  KEY `chat_messages_user_id_foreign` (`user_id`),
  CONSTRAINT `chat_messages_chat_room_id_foreign` FOREIGN KEY (`chat_room_id`) REFERENCES `chat_rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chat_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cache table
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Jobs table
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Failed jobs table
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL UNIQUE,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migrations table
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data

-- Sample users
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@shopease.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW()),
(2, 'Test User', 'user@shopease.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', NOW(), NOW()),
(3, 'John Doe', 'john@example.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', NOW(), NOW()),
(4, 'Jane Smith', 'jane@example.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', NOW(), NOW());

-- Sample wallets
INSERT INTO `wallets` (`id`, `user_id`, `balance`, `created_at`, `updated_at`) VALUES
(1, 1, 1000.00, NOW(), NOW()),
(2, 2, 500.00, NOW(), NOW()),
(3, 3, 250.00, NOW(), NOW()),
(4, 4, 750.00, NOW(), NOW());

-- Sample categories
INSERT INTO `categories` (`id`, `name`, `description`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', 'Electronic devices and gadgets', 'electronics', NOW(), NOW()),
(2, 'Clothing', 'Fashion and apparel', 'clothing', NOW(), NOW()),
(3, 'Books', 'Books and literature', 'books', NOW(), NOW()),
(4, 'Home & Garden', 'Home improvement and gardening', 'home-garden', NOW(), NOW()),
(5, 'Sports', 'Sports equipment and accessories', 'sports', NOW(), NOW());

-- Sample brands
INSERT INTO `brands` (`id`, `name`, `description`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'TechCorp', 'Leading technology company', 'techcorp-logo.png', NOW(), NOW()),
(2, 'FashionPlus', 'Premium fashion brand', 'fashionplus-logo.png', NOW(), NOW()),
(3, 'BookWorld', 'Your favorite bookstore', 'bookworld-logo.png', NOW(), NOW()),
(4, 'HomeStyle', 'Quality home products', 'homestyle-logo.png', NOW(), NOW()),
(5, 'SportMax', 'Professional sports equipment', 'sportmax-logo.png', NOW(), NOW());

-- Sample products
INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `category_id`, `brand_id`, `image`, `is_digital`, `weight`, `dimensions`, `created_at`, `updated_at`) VALUES
(1, 'Smartphone X1', 'Latest smartphone with advanced features', 599.99, 50, 1, 1, 'smartphone-x1.jpg', 0, 0.18, '15.5x7.5x0.8cm', NOW(), NOW()),
(2, 'Wireless Headphones', 'Premium wireless headphones with noise cancellation', 199.99, 100, 1, 1, 'wireless-headphones.jpg', 0, 0.25, '18x15x8cm', NOW(), NOW()),
(3, 'Designer T-Shirt', 'Comfortable cotton t-shirt with modern design', 29.99, 200, 2, 2, 'designer-tshirt.jpg', 0, 0.15, 'M', NOW(), NOW()),
(4, 'Programming Guide', 'Complete guide to modern programming', 39.99, 150, 3, 3, 'programming-guide.jpg', 1, NULL, NULL, NOW(), NOW()),
(5, 'Garden Tool Set', 'Professional garden tools for all seasons', 89.99, 75, 4, 4, 'garden-tool-set.jpg', 0, 2.5, '45x25x15cm', NOW(), NOW()),
(6, 'Running Shoes', 'Comfortable running shoes for all terrains', 129.99, 120, 5, 5, 'running-shoes.jpg', 0, 0.8, '42', NOW(), NOW()),
(7, 'Laptop Pro', 'High-performance laptop for professionals', 1299.99, 25, 1, 1, 'laptop-pro.jpg', 0, 2.1, '35x24x2cm', NOW(), NOW()),
(8, 'Digital Art Course', 'Online course for digital art creation', 79.99, 999, 3, 3, 'digital-art-course.jpg', 1, NULL, NULL, NOW(), NOW()),
(9, 'Kitchen Mixer', 'Professional kitchen mixer for home use', 149.99, 60, 4, 4, 'kitchen-mixer.jpg', 0, 3.2, '30x20x25cm', NOW(), NOW());

-- Sample shipping addresses
INSERT INTO `shipping_addresses` (`id`, `user_id`, `full_name`, `phone`, `address_line_1`, `address_line_2`, `city`, `state_province`, `postal_code`, `country`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 2, 'Test User', '+1234567890', '123 Main Street', 'Apt 4B', 'New York', 'NY', '10001', 'USA', 1, NOW(), NOW()),
(2, 3, 'John Doe', '+1987654321', '456 Oak Avenue', NULL, 'Los Angeles', 'CA', '90210', 'USA', 1, NOW(), NOW()),
(3, 4, 'Jane Smith', '+1122334455', '789 Pine Road', 'Suite 10', 'Chicago', 'IL', '60601', 'USA', 1, NOW(), NOW());

-- Sample orders
INSERT INTO `orders` (`id`, `user_id`, `order_number`, `total_amount`, `status`, `shipping_address_id`, `tracking_number`, `shipping_method`, `shipping_cost`, `tax_amount`, `created_at`, `updated_at`) VALUES
(1, 2, 'ORD-2024-001', 229.98, 'delivered', 1, 'TRK123456789', 'Standard Shipping', 9.99, 19.99, NOW(), NOW()),
(2, 3, 'ORD-2024-002', 89.99, 'processing', 2, 'TRK987654321', 'Express Shipping', 14.99, 7.50, NOW(), NOW()),
(3, 4, 'ORD-2024-003', 149.99, 'shipped', 3, 'TRK456789123', 'Standard Shipping', 9.99, 12.50, NOW(), NOW());

-- Sample order items
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 2, 29.99, NOW(), NOW()),
(2, 1, 4, 1, 39.99, NOW(), NOW()),
(3, 1, 6, 1, 129.99, NOW(), NOW()),
(4, 2, 5, 1, 89.99, NOW(), NOW()),
(5, 3, 9, 1, 149.99, NOW(), NOW());

-- Sample order tracking
INSERT INTO `order_trackings` (`id`, `order_id`, `status`, `description`, `location`, `tracked_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Order Placed', 'Order has been placed successfully', 'New York', NOW(), NOW(), NOW()),
(2, 1, 'Processing', 'Order is being processed', 'New York', NOW(), NOW(), NOW()),
(3, 1, 'Shipped', 'Order has been shipped', 'New York', NOW(), NOW(), NOW()),
(4, 1, 'Delivered', 'Order has been delivered', 'New York', NOW(), NOW(), NOW()),
(5, 2, 'Order Placed', 'Order has been placed successfully', 'Los Angeles', NOW(), NOW(), NOW()),
(6, 2, 'Processing', 'Order is being processed', 'Los Angeles', NOW(), NOW(), NOW()),
(7, 3, 'Order Placed', 'Order has been placed successfully', 'Chicago', NOW(), NOW(), NOW()),
(8, 3, 'Processing', 'Order is being processed', 'Chicago', NOW(), NOW(), NOW()),
(9, 3, 'Shipped', 'Order has been shipped', 'Chicago', NOW(), NOW(), NOW());

-- Sample product reviews
INSERT INTO `product_reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 5, 'Excellent smartphone! Great camera and battery life.', 1, NOW(), NOW()),
(2, 3, 3, 4, 'Very comfortable t-shirt, fits perfectly.', 1, NOW(), NOW()),
(3, 4, 4, 5, 'Amazing programming guide, learned a lot!', 1, NOW(), NOW()),
(4, 6, 2, 4, 'Great running shoes, very comfortable for long runs.', 1, NOW(), NOW()),
(5, 9, 3, 5, 'Professional quality mixer, perfect for home use.', 1, NOW(), NOW());

-- Sample chat rooms
INSERT INTO `chat_rooms` (`id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'open', NOW(), NOW()),
(2, 3, 'open', NOW(), NOW()),
(3, 4, 'closed', NOW(), NOW());

-- Sample chat messages
INSERT INTO `chat_messages` (`id`, `chat_room_id`, `user_id`, `message`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Hello, I have a question about my order', 0, NOW(), NOW()),
(2, 1, 1, 'Hello! How can I help you today?', 1, NOW(), NOW()),
(3, 1, 2, 'When will my order be delivered?', 0, NOW(), NOW()),
(4, 1, 1, 'Your order is scheduled for delivery tomorrow', 1, NOW(), NOW()),
(5, 2, 3, 'I need help with a product return', 0, NOW(), NOW()),
(6, 2, 1, 'I can help you with that. What\'s the issue?', 1, NOW(), NOW());

-- Insert migration records
INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2025_08_09_194058_add_role_to_users_table', 1),
('2025_08_09_194102_create_wallet_transactions_table', 1),
('2025_08_09_194107_create_products_table', 1),
('2025_08_09_194110_create_orders_table', 1),
('2025_08_12_090012_add_physical_product_fields_to_products_table', 1),
('2025_08_12_090047_create_categories_table', 1),
('2025_08_12_090104_create_brands_table', 1),
('2025_08_12_090122_create_product_reviews_table', 1),
('2025_08_12_090140_create_shipping_addresses_table', 1),
('2025_08_12_090157_add_physical_order_fields_to_orders_table', 1),
('2025_08_12_103733_create_order_trackings_table', 1),
('2025_08_12_124619_fix_products_table_structure', 1),
('2025_08_13_000000_create_chat_rooms_table', 2),
('2025_08_13_000001_create_chat_messages_table', 2);

-- Default admin credentials:
-- Email: admin@shopease.com
-- Password: password
-- 
-- Default user credentials:
-- Email: user@shopease.com  
-- Password: password
