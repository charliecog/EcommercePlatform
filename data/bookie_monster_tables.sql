DROP TABLE IF EXISTS `admin_user`;

CREATE TABLE `admin_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password_hash` varchar(250) NOT NULL DEFAULT '',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `live` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `admin_user` WRITE;
INSERT INTO `admin_user` (`id`, `username`, `password_hash`, `date_created`, `date_modified`, `live`)
VALUES
	(1,'Mike','$2y$10$Uolfyl8TQmyuz6cFetLUzu0G88ccA9TfA9MbXXZkEbLDwmmGWISxy','2016-03-01 14:00:06','2016-03-01 14:00:06',1);

UNLOCK TABLES;
DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `format`;

CREATE TABLE `format` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `book`;

CREATE TABLE `book` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(300) NOT NULL DEFAULT '',
  `author` varchar(300) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `format_id` int(11) unsigned NOT NULL,
  `year_published` smallint(4) DEFAULT NULL,
  `publisher` varchar(50) DEFAULT '',
  `image` varchar(50) DEFAULT '',
  `cost_price` decimal(7,2) unsigned NOT NULL DEFAULT '0.00',
  `sell_price` decimal(7,2) unsigned NOT NULL,
  `stock_level` int(11) unsigned NOT NULL DEFAULT '1',
  `notes` text,
  `featured` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `format_id` (`format_id`),
  CONSTRAINT `book_ibfk_2` FOREIGN KEY (`format_id`) REFERENCES `format` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `book_category`;

CREATE TABLE `book_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `book_category_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  CONSTRAINT `book_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `order`;

CREATE TABLE `order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `total` decimal(7,2) unsigned NOT NULL,
  `customer_name` varchar(30) NOT NULL DEFAULT '',
  `customer_surname` varchar(30) NOT NULL DEFAULT '',
  `customer_email` varchar(320) NOT NULL DEFAULT '',
  `delivery_address` varchar(160) NOT NULL DEFAULT '',
  `billing_address` varchar(160) NOT NULL DEFAULT '',
  `name_on_card` varchar(26) NOT NULL DEFAULT '',
  `card_number` int(4) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `order_book`;

CREATE TABLE `order_book` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL,
  `book_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_book_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  CONSTRAINT `order_book_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;