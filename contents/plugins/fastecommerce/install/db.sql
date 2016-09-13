-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2016 at 12:19 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `2015_project_noblessev2`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--


CREATE TABLE IF NOT EXISTS `vouchers` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `date_added` datetime NOT NULL,
  `date_expires` datetime DEFAULT NULL,
  `date_start` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `code` varchar(255) NOT NULL,
  `money` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `newsletters` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `affiliate_ranks` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `commission` float NOT NULL DEFAULT '5',
  `orders` int(9) NOT NULL DEFAULT '1',
  `image` varchar(255) DEFAULT NULL,
  `parentid` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `affiliate_ranks`
--

INSERT INTO `affiliate_ranks` (`id`, `title`, `date_added`, `status`, `commission`, `orders`, `image`, `parentid`) VALUES
(1, 'Level 1', '2016-08-19 21:36:45', 1, 6, 1, NULL, 0),
(2, 'Level 2', '2016-08-19 21:51:22', 1, 7, 100, NULL, 0),
(3, 'Level 3', '2016-08-19 21:51:46', 1, 8, 500, NULL, 0),
(4, 'Level 4', '2016-08-19 21:52:14', 1, 9, 800, NULL, 0),
(5, 'Level 5', '2016-08-19 21:52:26', 1, 10, 1000, NULL, 0);

CREATE TABLE IF NOT EXISTS `collections_products` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `productid` int(9) NOT NULL,
  `friendly_url` int(11) NOT NULL,
  `views` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `affiliate_stats` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `userid` int(9) NOT NULL,
  `money` double NOT NULL,
  `date_added` datetime NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `orderid` int(9) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `brands` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `friendly_url` varchar(255) NOT NULL,
  `views` int(9) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE IF NOT EXISTS `coupons` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL DEFAULT 'percent',
  `code` varchar(150) NOT NULL,
  `amount` double NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `freeshipping` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `userid` int(9) NOT NULL,
  `points` int(9) NOT NULL DEFAULT '0',
  `commission` double NOT NULL DEFAULT '0',
  `orders` int(9) NOT NULL DEFAULT '0',
  `reviews` int(9) NOT NULL DEFAULT '0',
  `balance` double NOT NULL DEFAULT '0',
  `withdraw_summary` varchar(500) DEFAULT NULL,
  `affiliaterankid` int(9) NOT NULL DEFAULT '1',
  `affiliate_orders` int(9) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE IF NOT EXISTS `discounts` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `date_added` datetime NOT NULL,
  `date_discount` datetime NOT NULL,
  `date_enddiscount` datetime NOT NULL,
  `percent` double NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE IF NOT EXISTS `downloads` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--


CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `date_added` datetime NOT NULL,
  `userid` int(9) NOT NULL,
  `shipping_firstname` varchar(30) NOT NULL,
  `shipping_lastname` varchar(30) NOT NULL,
  `shipping_company` varchar(150) DEFAULT NULL,
  `shipping_address1` varchar(150) DEFAULT NULL,
  `shipping_address2` varchar(150) DEFAULT NULL,
  `shipping_city` varchar(50) DEFAULT NULL,
  `shipping_postcode` varchar(20) DEFAULT NULL,
  `shipping_state` varchar(30) DEFAULT NULL,
  `shipping_country` varchar(50) NOT NULL,
  `shipping_method` varchar(50) DEFAULT NULL,
  `shipping_phone` varchar(20) DEFAULT NULL,
  `shipping_fax` varchar(20) DEFAULT NULL,
  `shipping_url` varchar(555) DEFAULT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `affiliateid` int(9) NOT NULL DEFAULT '0',
  `commission` double NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `products` longtext,
  `vat` double NOT NULL DEFAULT '0',
  `before_vat` double NOT NULL DEFAULT '0',
  `total` double NOT NULL DEFAULT '0',
  `summary` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE IF NOT EXISTS `order_products` (
  `orderid` int(9) NOT NULL,
  `productid` int(9) NOT NULL,
  `quantity` int(9) NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `total` double NOT NULL DEFAULT '0',
  `log` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE IF NOT EXISTS `payment_methods` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `foldername` varchar(155) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `catid` int(9) NOT NULL,
  `category_str` longtext,
  `title` varchar(255) NOT NULL,
  `friendly_url` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `views` int(9) NOT NULL DEFAULT '0',
  `rating` int(2) NOT NULL DEFAULT '0',
  `likes` int(9) NOT NULL DEFAULT '0',
  `reviews` int(9) NOT NULL DEFAULT '0',
  `orders` int(9) NOT NULL DEFAULT '0',
  `points` int(9) NOT NULL DEFAULT '0',
  `sku` varchar(50) DEFAULT NULL,
  `upc` varchar(50) DEFAULT NULL,
  `model` varchar(150) DEFAULT NULL,
  `content` longtext,
  `shortdesc` text,
  `image` varchar(255) DEFAULT NULL,
  `userid` int(9) NOT NULL,
  `is_featured` int(1) NOT NULL DEFAULT '0',
  `date_featured` datetime DEFAULT NULL,
  `require_shipping` int(1) NOT NULL DEFAULT '1',
  `brandid` int(9) NOT NULL DEFAULT '0',
  `quantity` int(9) NOT NULL DEFAULT '1',
  `sort_order` int(9) NOT NULL DEFAULT '0',
  `require_minimum` int(9) NOT NULL DEFAULT '1',
  `date_available` datetime DEFAULT NULL,
  `date_expires` datetime DEFAULT NULL,
  `price` double NOT NULL DEFAULT '0',
  `sale_price` double NOT NULL DEFAULT '0',
  `sale_price_from` datetime DEFAULT NULL,
  `sale_price_to` datetime DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'published',
  `type` varchar(50) NOT NULL DEFAULT 'normal',
  `category_data` text,
  `brand_data` text,
  `tag_data` text,
  `attr_data` text,
  `attr_str` longtext,
  `download_data` text,
  `image_data` text,
  `discount_data` text,
  `weight` double NOT NULL DEFAULT '0',
  `shipping_class` int(9) NOT NULL DEFAULT '0',
  `is_stock_manage` int(1) NOT NULL DEFAULT '1',
  `purchase_note` text,
  `enable_review` int(1) NOT NULL DEFAULT '1',
  `page_title` varchar(255) DEFAULT NULL,
  `descriptions` varchar(155) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `review_data` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_attrs`
--


CREATE TABLE IF NOT EXISTS `product_attrs` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `productid` int(9) NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_brands`
--

CREATE TABLE IF NOT EXISTS `product_brands` (
  `productid` int(9) NOT NULL,
  `brandid` int(9) NOT NULL,
  `product_title` varchar(255) DEFAULT NULL,
  `product_friendly_url` varchar(255) DEFAULT NULL,
  `brand_title` varchar(255) DEFAULT NULL,
  `brand_friendly_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE IF NOT EXISTS `product_categories` (
  `productid` int(9) NOT NULL,
  `catid` int(9) NOT NULL,
  `product_title` varchar(255) DEFAULT NULL,
  `product_friendly_url` varchar(255) DEFAULT NULL,
  `cat_title` varchar(255) DEFAULT NULL,
  `cat_friendly_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_discounts`
--

CREATE TABLE IF NOT EXISTS `product_discounts` (
  `productid` int(9) NOT NULL,
  `date_discount` datetime NOT NULL,
  `date_enddiscount` datetime NOT NULL,
  `percent` double NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `product_title` varchar(255) DEFAULT NULL,
  `product_friendly_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_downloads`
--

CREATE TABLE IF NOT EXISTS `product_downloads` (
  `productid` int(9) NOT NULL,
  `downloadid` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE IF NOT EXISTS `product_images` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `productid` int(9) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE IF NOT EXISTS `product_reviews` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `userid` int(9) NOT NULL,
  `rating` int(1) NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  `date_added` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `is_spam` int(1) NOT NULL DEFAULT '0',
  `productid` int(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_tags`
--

CREATE TABLE IF NOT EXISTS `product_tags` (
  `productid` int(9) NOT NULL,
  `title` varchar(150) NOT NULL,
  `friendly_url` varchar(150) NOT NULL,
  `views` int(9) NOT NULL DEFAULT '0',
  `product_title` varchar(255) DEFAULT NULL,
  `product_friendly_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `productid` int(9) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `url` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `date_added` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  `userid` int(9) NOT NULL,
  `report` int(1) NOT NULL DEFAULT '0',
  `rating` int(1) NOT NULL DEFAULT '5',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `store_log`
--

CREATE TABLE IF NOT EXISTS `store_log` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `content` varchar(500) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `taxrates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `type` varchar(30) NOT NULL DEFAULT 'fixed',
  `countries` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;


CREATE TABLE IF NOT EXISTS `shippingrates` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;


CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `date_added` datetime NOT NULL,
  `userid` int(9) NOT NULL,
  `productid` int(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
