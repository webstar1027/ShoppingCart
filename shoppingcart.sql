-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.21 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table shoppingcart.carts
CREATE TABLE IF NOT EXISTS `carts` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `FK_carts_users` (`user_id`),
  KEY `FK_carts_products` (`product_id`),
  CONSTRAINT `FK_carts_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_carts_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table shoppingcart.carts: ~0 rows (approximately)
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;

-- Dumping structure for table shoppingcart.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `pay_price` float NOT NULL,
  `rest_price` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`payment_id`),
  KEY `FK_payments_users` (`user_id`),
  CONSTRAINT `FK_payments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- Dumping data for table shoppingcart.payments: ~2 rows (approximately)
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` (`payment_id`, `user_id`, `pay_price`, `rest_price`, `created_at`, `updated_at`) VALUES
	(31, 41, 25.56, 74.44, '2018-03-08 21:05:59', '0000-00-00 00:00:00'),
	(32, 41, 30.56, 43.88, '2018-03-08 21:12:21', '0000-00-00 00:00:00'),
	(33, 41, 30.56, 13.32, '2018-03-08 21:12:28', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;

-- Dumping structure for table shoppingcart.products
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table shoppingcart.products: ~4 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`product_id`, `name`, `image`, `price`, `rating`, `created_at`, `updated_at`) VALUES
	(1, 'apple', 'apple.jpg', 0.3, 5, '2018-03-06 20:08:28', '2018-03-06 20:08:29'),
	(2, 'beer', 'beer.jpg', 2, 3, '2018-03-06 20:08:54', '2018-03-06 20:08:55'),
	(3, 'water', 'cheese.jpg', 1, 4, '2018-03-06 20:09:38', '2018-03-06 20:09:39'),
	(4, 'cheese', 'water.jpg', 3.74, 4, '2018-03-06 20:09:54', '2018-03-06 20:09:55');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table shoppingcart.ratings
CREATE TABLE IF NOT EXISTS `ratings` (
  `rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `rating_value` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`rate_id`),
  KEY `FK_ratings_users` (`user_id`),
  KEY `FK_ratings_products` (`product_id`),
  CONSTRAINT `FK_ratings_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ratings_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- Dumping data for table shoppingcart.ratings: ~7 rows (approximately)
/*!40000 ALTER TABLE `ratings` DISABLE KEYS */;
INSERT INTO `ratings` (`rate_id`, `user_id`, `product_id`, `rating_value`, `created_at`, `updated_at`) VALUES
	(19, 41, 1, 5, NULL, NULL),
	(20, 41, 2, 5, NULL, NULL),
	(21, 41, 3, 5, NULL, NULL),
	(22, 41, 4, 5, NULL, NULL),
	(23, 40, 1, 5, NULL, NULL),
	(24, 40, 2, 1, NULL, NULL),
	(25, 40, 3, 2, NULL, NULL),
	(26, 40, 4, 3, NULL, NULL);
/*!40000 ALTER TABLE `ratings` ENABLE KEYS */;

-- Dumping structure for table shoppingcart.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- Dumping data for table shoppingcart.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
	(40, 'daniel cherevashko', 'webstar1027@gmail.com', '371401be87592fcbb4dcd85ccf080579c9d18ca6', '2018-03-07 07:45:40', '0000-00-00 00:00:00'),
	(41, 'webdeveloper1027', 'webdeveloper1027@yahoo.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2018-03-07 12:33:59', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
