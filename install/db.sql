-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2015 at 05:10 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `2015_project_noblessecms`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `userid` int(9) NOT NULL,
  `company` varchar(64) CHARACTER SET utf8 NOT NULL,
  `firstname` varchar(32) CHARACTER SET utf8 NOT NULL,
  `lastname` varchar(32) CHARACTER SET utf8 NOT NULL,
  `address_1` varchar(128) CHARACTER SET utf8 NOT NULL,
  `address_2` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `city` varchar(64) CHARACTER SET utf8 NOT NULL,
  `state` varchar(64) CHARACTER SET utf8 NOT NULL,
  `postcode` varchar(20) CHARACTER SET utf8 NOT NULL,
  `country` varchar(32) CHARACTER SET utf8 NOT NULL,
  `phone` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `fax` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`userid`, `company`, `firstname`, `lastname`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country`, `phone`, `fax`) VALUES
(1, '', 'James', 'Brown', 'sdfdsfd', 'fdf', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `affiliate`
--

CREATE TABLE IF NOT EXISTS `affiliate` (
  `userid` int(9) NOT NULL,
  `earned` double NOT NULL DEFAULT '0',
  `commission` double NOT NULL DEFAULT '0',
  `payment_method` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `payment_account` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `cheque` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `bank_name` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `bank_branch_number` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `bank_swift_code` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `bank_account_name` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `bank_account_number` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `affiliate`
--

INSERT INTO `affiliate` (`userid`, `earned`, `commission`, `payment_method`, `payment_account`, `cheque`, `bank_name`, `bank_branch_number`, `bank_swift_code`, `bank_account_name`, `bank_account_number`) VALUES
(1, 0, 40, 'Paypal', 'test@gmail.com', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `catid` int(9) NOT NULL AUTO_INCREMENT,
  `cattitle` varchar(90) CHARACTER SET utf8 NOT NULL,
  `friendly_url` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `parentid` varchar(128) NOT NULL DEFAULT '0',
  `image` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `isreaded` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`catid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`catid`, `cattitle`, `friendly_url`, `parentid`, `image`, `sort_order`, `date_added`, `isreaded`, `status`) VALUES
(15, 'United', 'United', '0', '/uploads/images/2231793638/post_2.jpg', 15, '2015-01-18 07:57:36', 0, 1),
(16, 'Manhua', 'Manhua', '0', NULL, 0, '2015-03-31 09:41:26', 0, 1),
(17, 'Action', 'Action', '0', NULL, 0, '2015-03-31 09:41:30', 0, 1),
(18, 'Adventure', 'Adventure', '0', NULL, 0, '2015-03-31 09:41:34', 0, 1),
(19, 'Cat 1', 'Cat_1', '0', NULL, 0, '2015-03-31 09:41:40', 0, 1),
(20, 'Cat 2', 'Cat_2', '0', NULL, 0, '2015-03-31 09:41:42', 0, 1),
(21, 'Cat 3', 'Cat_3', '0', NULL, 0, '2015-03-31 09:41:46', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `commentid` int(9) NOT NULL AUTO_INCREMENT,
  `postid` varchar(128) NOT NULL,
  `method` varchar(30) NOT NULL DEFAULT 'post',
  `fullname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `email` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `parentid` int(9) NOT NULL DEFAULT '0',
  `date_added` datetime DEFAULT NULL,
  `isreaded` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `content` longtext CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`commentid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentid`, `postid`, `method`, `fullname`, `email`, `parentid`, `date_added`, `isreaded`, `status`, `content`) VALUES
(1, '1', 'post', 'sÄ‘s', 'gdfgfg@gmai.com', 0, '2015-03-16 05:38:40', 0, 1, 'sdgsdsdfsdfsdfsdf'),
(2, '1', 'post', 'james', 'dfsdfdf@gmail.com', 0, '2015-03-16 05:39:31', 0, 1, '1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE IF NOT EXISTS `contactus` (
  `contactid` int(9) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(64) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `content` longtext CHARACTER SET utf8 NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `isreaded` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`contactid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `address_format` text NOT NULL,
  `postcode_required` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=252 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `name`, `iso_code_2`, `iso_code_3`, `address_format`, `postcode_required`, `status`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', '', 0, 1),
(2, 'Albania', 'AL', 'ALB', '', 0, 1),
(3, 'Algeria', 'DZ', 'DZA', '', 0, 1),
(4, 'American Samoa', 'AS', 'ASM', '', 0, 1),
(5, 'Andorra', 'AD', 'AND', '', 0, 1),
(6, 'Angola', 'AO', 'AGO', '', 0, 1),
(7, 'Anguilla', 'AI', 'AIA', '', 0, 1),
(8, 'Antarctica', 'AQ', 'ATA', '', 0, 1),
(9, 'Antigua and Barbuda', 'AG', 'ATG', '', 0, 1),
(10, 'Argentina', 'AR', 'ARG', '', 0, 1),
(11, 'Armenia', 'AM', 'ARM', '', 0, 1),
(12, 'Aruba', 'AW', 'ABW', '', 0, 1),
(13, 'Australia', 'AU', 'AUS', '', 0, 1),
(14, 'Austria', 'AT', 'AUT', '', 0, 1),
(15, 'Azerbaijan', 'AZ', 'AZE', '', 0, 1),
(16, 'Bahamas', 'BS', 'BHS', '', 0, 1),
(17, 'Bahrain', 'BH', 'BHR', '', 0, 1),
(18, 'Bangladesh', 'BD', 'BGD', '', 0, 1),
(19, 'Barbados', 'BB', 'BRB', '', 0, 1),
(20, 'Belarus', 'BY', 'BLR', '', 0, 1),
(21, 'Belgium', 'BE', 'BEL', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 0, 1),
(22, 'Belize', 'BZ', 'BLZ', '', 0, 1),
(23, 'Benin', 'BJ', 'BEN', '', 0, 1),
(24, 'Bermuda', 'BM', 'BMU', '', 0, 1),
(25, 'Bhutan', 'BT', 'BTN', '', 0, 1),
(26, 'Bolivia', 'BO', 'BOL', '', 0, 1),
(27, 'Bosnia and Herzegovina', 'BA', 'BIH', '', 0, 1),
(28, 'Botswana', 'BW', 'BWA', '', 0, 1),
(29, 'Bouvet Island', 'BV', 'BVT', '', 0, 1),
(30, 'Brazil', 'BR', 'BRA', '', 0, 1),
(31, 'British Indian Ocean Territory', 'IO', 'IOT', '', 0, 1),
(32, 'Brunei Darussalam', 'BN', 'BRN', '', 0, 1),
(33, 'Bulgaria', 'BG', 'BGR', '', 0, 1),
(34, 'Burkina Faso', 'BF', 'BFA', '', 0, 1),
(35, 'Burundi', 'BI', 'BDI', '', 0, 1),
(36, 'Cambodia', 'KH', 'KHM', '', 0, 1),
(37, 'Cameroon', 'CM', 'CMR', '', 0, 1),
(38, 'Canada', 'CA', 'CAN', '', 0, 1),
(39, 'Cape Verde', 'CV', 'CPV', '', 0, 1),
(40, 'Cayman Islands', 'KY', 'CYM', '', 0, 1),
(41, 'Central African Republic', 'CF', 'CAF', '', 0, 1),
(42, 'Chad', 'TD', 'TCD', '', 0, 1),
(43, 'Chile', 'CL', 'CHL', '', 0, 1),
(44, 'China', 'CN', 'CHN', '', 0, 1),
(45, 'Christmas Island', 'CX', 'CXR', '', 0, 1),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', '', 0, 1),
(47, 'Colombia', 'CO', 'COL', '', 0, 1),
(48, 'Comoros', 'KM', 'COM', '', 0, 1),
(49, 'Congo', 'CG', 'COG', '', 0, 1),
(50, 'Cook Islands', 'CK', 'COK', '', 0, 1),
(51, 'Costa Rica', 'CR', 'CRI', '', 0, 1),
(52, 'Cote D''Ivoire', 'CI', 'CIV', '', 0, 1),
(53, 'Croatia', 'HR', 'HRV', '', 0, 1),
(54, 'Cuba', 'CU', 'CUB', '', 0, 1),
(55, 'Cyprus', 'CY', 'CYP', '', 0, 1),
(56, 'Czech Republic', 'CZ', 'CZE', '', 0, 1),
(57, 'Denmark', 'DK', 'DNK', '', 0, 1),
(58, 'Djibouti', 'DJ', 'DJI', '', 0, 1),
(59, 'Dominica', 'DM', 'DMA', '', 0, 1),
(60, 'Dominican Republic', 'DO', 'DOM', '', 0, 1),
(61, 'East Timor', 'TL', 'TLS', '', 0, 1),
(62, 'Ecuador', 'EC', 'ECU', '', 0, 1),
(63, 'Egypt', 'EG', 'EGY', '', 0, 1),
(64, 'El Salvador', 'SV', 'SLV', '', 0, 1),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', '', 0, 1),
(66, 'Eritrea', 'ER', 'ERI', '', 0, 1),
(67, 'Estonia', 'EE', 'EST', '', 0, 1),
(68, 'Ethiopia', 'ET', 'ETH', '', 0, 1),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', '', 0, 1),
(70, 'Faroe Islands', 'FO', 'FRO', '', 0, 1),
(71, 'Fiji', 'FJ', 'FJI', '', 0, 1),
(72, 'Finland', 'FI', 'FIN', '', 0, 1),
(74, 'France, Metropolitan', 'FR', 'FRA', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 1, 1),
(75, 'French Guiana', 'GF', 'GUF', '', 0, 1),
(76, 'French Polynesia', 'PF', 'PYF', '', 0, 1),
(77, 'French Southern Territories', 'TF', 'ATF', '', 0, 1),
(78, 'Gabon', 'GA', 'GAB', '', 0, 1),
(79, 'Gambia', 'GM', 'GMB', '', 0, 1),
(80, 'Georgia', 'GE', 'GEO', '', 0, 1),
(81, 'Germany', 'DE', 'DEU', '{company}\r\n{firstname} {lastname}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 1, 1),
(82, 'Ghana', 'GH', 'GHA', '', 0, 1),
(83, 'Gibraltar', 'GI', 'GIB', '', 0, 1),
(84, 'Greece', 'GR', 'GRC', '', 0, 1),
(85, 'Greenland', 'GL', 'GRL', '', 0, 1),
(86, 'Grenada', 'GD', 'GRD', '', 0, 1),
(87, 'Guadeloupe', 'GP', 'GLP', '', 0, 1),
(88, 'Guam', 'GU', 'GUM', '', 0, 1),
(89, 'Guatemala', 'GT', 'GTM', '', 0, 1),
(90, 'Guinea', 'GN', 'GIN', '', 0, 1),
(91, 'Guinea-Bissau', 'GW', 'GNB', '', 0, 1),
(92, 'Guyana', 'GY', 'GUY', '', 0, 1),
(93, 'Haiti', 'HT', 'HTI', '', 0, 1),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', '', 0, 1),
(95, 'Honduras', 'HN', 'HND', '', 0, 1),
(96, 'Hong Kong', 'HK', 'HKG', '', 0, 1),
(97, 'Hungary', 'HU', 'HUN', '', 0, 1),
(98, 'Iceland', 'IS', 'ISL', '', 0, 1),
(99, 'India', 'IN', 'IND', '', 0, 1),
(100, 'Indonesia', 'ID', 'IDN', '', 0, 1),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN', '', 0, 1),
(102, 'Iraq', 'IQ', 'IRQ', '', 0, 1),
(103, 'Ireland', 'IE', 'IRL', '', 0, 1),
(104, 'Israel', 'IL', 'ISR', '', 0, 1),
(105, 'Italy', 'IT', 'ITA', '', 0, 1),
(106, 'Jamaica', 'JM', 'JAM', '', 0, 1),
(107, 'Japan', 'JP', 'JPN', '', 0, 1),
(108, 'Jordan', 'JO', 'JOR', '', 0, 1),
(109, 'Kazakhstan', 'KZ', 'KAZ', '', 0, 1),
(110, 'Kenya', 'KE', 'KEN', '', 0, 1),
(111, 'Kiribati', 'KI', 'KIR', '', 0, 1),
(112, 'North Korea', 'KP', 'PRK', '', 0, 1),
(113, 'Korea, Republic of', 'KR', 'KOR', '', 0, 1),
(114, 'Kuwait', 'KW', 'KWT', '', 0, 1),
(115, 'Kyrgyzstan', 'KG', 'KGZ', '', 0, 1),
(116, 'Lao People''s Democratic Republic', 'LA', 'LAO', '', 0, 1),
(117, 'Latvia', 'LV', 'LVA', '', 0, 1),
(118, 'Lebanon', 'LB', 'LBN', '', 0, 1),
(119, 'Lesotho', 'LS', 'LSO', '', 0, 1),
(120, 'Liberia', 'LR', 'LBR', '', 0, 1),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', '', 0, 1),
(122, 'Liechtenstein', 'LI', 'LIE', '', 0, 1),
(123, 'Lithuania', 'LT', 'LTU', '', 0, 1),
(124, 'Luxembourg', 'LU', 'LUX', '', 0, 1),
(125, 'Macau', 'MO', 'MAC', '', 0, 1),
(126, 'FYROM', 'MK', 'MKD', '', 0, 1),
(127, 'Madagascar', 'MG', 'MDG', '', 0, 1),
(128, 'Malawi', 'MW', 'MWI', '', 0, 1),
(129, 'Malaysia', 'MY', 'MYS', '', 0, 1),
(130, 'Maldives', 'MV', 'MDV', '', 0, 1),
(131, 'Mali', 'ML', 'MLI', '', 0, 1),
(132, 'Malta', 'MT', 'MLT', '', 0, 1),
(133, 'Marshall Islands', 'MH', 'MHL', '', 0, 1),
(134, 'Martinique', 'MQ', 'MTQ', '', 0, 1),
(135, 'Mauritania', 'MR', 'MRT', '', 0, 1),
(136, 'Mauritius', 'MU', 'MUS', '', 0, 1),
(137, 'Mayotte', 'YT', 'MYT', '', 0, 1),
(138, 'Mexico', 'MX', 'MEX', '', 0, 1),
(139, 'Micronesia, Federated States of', 'FM', 'FSM', '', 0, 1),
(140, 'Moldova, Republic of', 'MD', 'MDA', '', 0, 1),
(141, 'Monaco', 'MC', 'MCO', '', 0, 1),
(142, 'Mongolia', 'MN', 'MNG', '', 0, 1),
(143, 'Montserrat', 'MS', 'MSR', '', 0, 1),
(144, 'Morocco', 'MA', 'MAR', '', 0, 1),
(145, 'Mozambique', 'MZ', 'MOZ', '', 0, 1),
(146, 'Myanmar', 'MM', 'MMR', '', 0, 1),
(147, 'Namibia', 'NA', 'NAM', '', 0, 1),
(148, 'Nauru', 'NR', 'NRU', '', 0, 1),
(149, 'Nepal', 'NP', 'NPL', '', 0, 1),
(150, 'Netherlands', 'NL', 'NLD', '', 0, 1),
(151, 'Netherlands Antilles', 'AN', 'ANT', '', 0, 1),
(152, 'New Caledonia', 'NC', 'NCL', '', 0, 1),
(153, 'New Zealand', 'NZ', 'NZL', '', 0, 1),
(154, 'Nicaragua', 'NI', 'NIC', '', 0, 1),
(155, 'Niger', 'NE', 'NER', '', 0, 1),
(156, 'Nigeria', 'NG', 'NGA', '', 0, 1),
(157, 'Niue', 'NU', 'NIU', '', 0, 1),
(158, 'Norfolk Island', 'NF', 'NFK', '', 0, 1),
(159, 'Northern Mariana Islands', 'MP', 'MNP', '', 0, 1),
(160, 'Norway', 'NO', 'NOR', '', 0, 1),
(161, 'Oman', 'OM', 'OMN', '', 0, 1),
(162, 'Pakistan', 'PK', 'PAK', '', 0, 1),
(163, 'Palau', 'PW', 'PLW', '', 0, 1),
(164, 'Panama', 'PA', 'PAN', '', 0, 1),
(165, 'Papua New Guinea', 'PG', 'PNG', '', 0, 1),
(166, 'Paraguay', 'PY', 'PRY', '', 0, 1),
(167, 'Peru', 'PE', 'PER', '', 0, 1),
(168, 'Philippines', 'PH', 'PHL', '', 0, 1),
(169, 'Pitcairn', 'PN', 'PCN', '', 0, 1),
(170, 'Poland', 'PL', 'POL', '', 0, 1),
(171, 'Portugal', 'PT', 'PRT', '', 0, 1),
(172, 'Puerto Rico', 'PR', 'PRI', '', 0, 1),
(173, 'Qatar', 'QA', 'QAT', '', 0, 1),
(174, 'Reunion', 'RE', 'REU', '', 0, 1),
(175, 'Romania', 'RO', 'ROM', '', 0, 1),
(176, 'Russian Federation', 'RU', 'RUS', '', 0, 1),
(177, 'Rwanda', 'RW', 'RWA', '', 0, 1),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', '', 0, 1),
(179, 'Saint Lucia', 'LC', 'LCA', '', 0, 1),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', '', 0, 1),
(181, 'Samoa', 'WS', 'WSM', '', 0, 1),
(182, 'San Marino', 'SM', 'SMR', '', 0, 1),
(183, 'Sao Tome and Principe', 'ST', 'STP', '', 0, 1),
(184, 'Saudi Arabia', 'SA', 'SAU', '', 0, 1),
(185, 'Senegal', 'SN', 'SEN', '', 0, 1),
(186, 'Seychelles', 'SC', 'SYC', '', 0, 1),
(187, 'Sierra Leone', 'SL', 'SLE', '', 0, 1),
(188, 'Singapore', 'SG', 'SGP', '', 0, 1),
(189, 'Slovak Republic', 'SK', 'SVK', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{city} {postcode}\r\n{zone}\r\n{country}', 0, 1),
(190, 'Slovenia', 'SI', 'SVN', '', 0, 1),
(191, 'Solomon Islands', 'SB', 'SLB', '', 0, 1),
(192, 'Somalia', 'SO', 'SOM', '', 0, 1),
(193, 'South Africa', 'ZA', 'ZAF', '', 0, 1),
(194, 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS', '', 0, 1),
(195, 'Spain', 'ES', 'ESP', '', 0, 1),
(196, 'Sri Lanka', 'LK', 'LKA', '', 0, 1),
(197, 'St. Helena', 'SH', 'SHN', '', 0, 1),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', '', 0, 1),
(199, 'Sudan', 'SD', 'SDN', '', 0, 1),
(200, 'Suriname', 'SR', 'SUR', '', 0, 1),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', '', 0, 1),
(202, 'Swaziland', 'SZ', 'SWZ', '', 0, 1),
(203, 'Sweden', 'SE', 'SWE', '{company}\r\n{firstname} {lastname}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 1, 1),
(204, 'Switzerland', 'CH', 'CHE', '', 0, 1),
(205, 'Syrian Arab Republic', 'SY', 'SYR', '', 0, 1),
(206, 'Taiwan', 'TW', 'TWN', '', 0, 1),
(207, 'Tajikistan', 'TJ', 'TJK', '', 0, 1),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA', '', 0, 1),
(209, 'Thailand', 'TH', 'THA', '', 0, 1),
(210, 'Togo', 'TG', 'TGO', '', 0, 1),
(211, 'Tokelau', 'TK', 'TKL', '', 0, 1),
(212, 'Tonga', 'TO', 'TON', '', 0, 1),
(213, 'Trinidad and Tobago', 'TT', 'TTO', '', 0, 1),
(214, 'Tunisia', 'TN', 'TUN', '', 0, 1),
(215, 'Turkey', 'TR', 'TUR', '', 0, 1),
(216, 'Turkmenistan', 'TM', 'TKM', '', 0, 1),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', '', 0, 1),
(218, 'Tuvalu', 'TV', 'TUV', '', 0, 1),
(219, 'Uganda', 'UG', 'UGA', '', 0, 1),
(220, 'Ukraine', 'UA', 'UKR', '', 0, 1),
(221, 'United Arab Emirates', 'AE', 'ARE', '', 0, 1),
(222, 'United Kingdom', 'GB', 'GBR', '', 1, 1),
(223, 'United States', 'US', 'USA', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{city}, {zone} {postcode}\r\n{country}', 0, 1),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI', '', 0, 1),
(225, 'Uruguay', 'UY', 'URY', '', 0, 1),
(226, 'Uzbekistan', 'UZ', 'UZB', '', 0, 1),
(227, 'Vanuatu', 'VU', 'VUT', '', 0, 1),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT', '', 0, 1),
(229, 'Venezuela', 'VE', 'VEN', '', 0, 1),
(230, 'Viet Nam', 'VN', 'VNM', '', 0, 1),
(231, 'Virgin Islands (British)', 'VG', 'VGB', '', 0, 1),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', '', 0, 1),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', '', 0, 1),
(234, 'Western Sahara', 'EH', 'ESH', '', 0, 1),
(235, 'Yemen', 'YE', 'YEM', '', 0, 1),
(237, 'Democratic Republic of Congo', 'CD', 'COD', '', 0, 1),
(238, 'Zambia', 'ZM', 'ZMB', '', 0, 1),
(239, 'Zimbabwe', 'ZW', 'ZWE', '', 0, 1),
(240, 'Jersey', 'JE', 'JEY', '', 1, 1),
(241, 'Guernsey', 'GG', 'GGY', '', 1, 1),
(242, 'Montenegro', 'ME', 'MNE', '', 0, 1),
(243, 'Serbia', 'RS', 'SRB', '', 0, 1),
(244, 'Aaland Islands', 'AX', 'ALA', '', 0, 1),
(245, 'Bonaire, Sint Eustatius and Saba', 'BQ', 'BES', '', 0, 1),
(246, 'Curacao', 'CW', 'CUW', '', 0, 1),
(247, 'Palestinian Territory, Occupied', 'PS', 'PSE', '', 0, 1),
(248, 'South Sudan', 'SS', 'SSD', '', 0, 1),
(249, 'St. Barthelemy', 'BL', 'BLM', '', 0, 1),
(250, 'St. Martin (French part)', 'MF', 'MAF', '', 0, 1),
(251, 'Canary Islands', 'IC', 'ICA', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE IF NOT EXISTS `coupons` (
  `couponid` int(9) NOT NULL AUTO_INCREMENT,
  `coupon_title` varchar(128) CHARACTER SET utf8 NOT NULL,
  `coupon_type` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT 'percent',
  `coupon_code` varchar(64) CHARACTER SET utf8 NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `freeshipping` int(1) NOT NULL DEFAULT '0',
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `date_added` datetime NOT NULL,
  `limitperuser` int(9) DEFAULT NULL,
  `limituse` int(9) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`couponid`),
  UNIQUE KEY `coupon_code` (`coupon_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cronjobs`
--

CREATE TABLE IF NOT EXISTS `cronjobs` (
  `cronid` int(9) NOT NULL AUTO_INCREMENT,
  `timenumber` int(9) NOT NULL DEFAULT '0',
  `timetype` varchar(30) NOT NULL DEFAULT 'min',
  `timeinterval` int(9) NOT NULL DEFAULT '0',
  `last_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `jobdata` varchar(1000) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cronid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `currencyid` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `symbolLeft` varchar(50) NOT NULL,
  `symbolRight` varchar(50) NOT NULL,
  `dataValue` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`currencyid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`currencyid`, `title`, `code`, `symbolLeft`, `symbolRight`, `dataValue`, `status`) VALUES
(2, '"USD Dollars"', 'USD', '"$"', '""', '1.00000', 1),
(3, '"Viet Nam Dong"', 'VND', '""', '"VND"', '21370.00000', 1),
(4, '"Euro"', 'EUR', '""', '"::u20ac"', '0.83316', 1),
(5, '"British Pound"', 'GBP', '"::u00a3"', '""', '0.65242', 1),
(6, '"Indian Rupee"', 'INR', '""', '"INR"', '63.24500', 1),
(7, '"Australian Dollar"', 'AUD', '""', '"AUD"', '1.23556', 1);

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE IF NOT EXISTS `downloads` (
  `downloadid` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `remaining` int(9) NOT NULL DEFAULT '100',
  `date_added` datetime NOT NULL,
  `isreaded` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`downloadid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gift_vouchers`
--

CREATE TABLE IF NOT EXISTS `gift_vouchers` (
  `voucherid` int(9) NOT NULL AUTO_INCREMENT,
  `code` varchar(128) CHARACTER SET utf8 NOT NULL,
  `amount` double NOT NULL,
  `date_added` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`voucherid`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `layouts`
--

CREATE TABLE IF NOT EXISTS `layouts` (
  `layoutid` int(9) NOT NULL AUTO_INCREMENT,
  `nodeid` varchar(128) NOT NULL,
  `layoutname` varchar(64) NOT NULL,
  PRIMARY KEY (`layoutid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `layouts`
--

INSERT INTO `layouts` (`layoutid`, `nodeid`, `layoutname`) VALUES
(1, '', 'Account'),
(2, '', 'Category'),
(3, '', 'Home'),
(4, '', 'Pages'),
(5, '', 'Post'),
(6, '', 'Cart'),
(7, '', 'Search'),
(8, '', 'Shop'),
(9, '', 'Tag'),
(10, '', 'Contactus'),
(11, '', 'News'),
(12, '', 'Product');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE IF NOT EXISTS `manufacturers` (
  `manufacturerid` int(9) NOT NULL AUTO_INCREMENT,
  `manufacturer_title` varchar(128) CHARACTER SET utf8 NOT NULL,
  `friendly_url` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `manufacturer_image` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isreaded` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`manufacturerid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`manufacturerid`, `manufacturer_title`, `friendly_url`, `manufacturer_image`, `date_added`, `isreaded`, `status`) VALUES
(1, 'Apple', 'Apple', NULL, '2015-03-12 19:30:08', 0, 1),
(2, 'Samsung', 'Samsung', NULL, '2015-03-12 19:30:13', 0, 1),
(3, 'Sony', 'Sony', NULL, '2015-03-12 19:30:20', 0, 1),
(4, 'Microsoft', 'Microsoft', NULL, '2015-03-12 19:30:24', 0, 1),
(5, 'Panasonic', 'Panasonic', NULL, '2015-03-12 19:30:33', 0, 1),
(6, 'LG', 'LG', NULL, '2015-03-12 19:30:36', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `multidb`
--

CREATE TABLE IF NOT EXISTS `multidb` (
  `dbid` int(9) NOT NULL AUTO_INCREMENT,
  `dbtype` varchar(50) NOT NULL,
  `dbhost` varchar(90) NOT NULL,
  `dbport` varchar(30) NOT NULL,
  `dbuser` varchar(90) NOT NULL,
  `dbpassword` varchar(128) NOT NULL,
  `dbname` varchar(128) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`dbid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `orderid` int(9) NOT NULL AUTO_INCREMENT,
  `customerid` int(9) DEFAULT '0',
  `payment_firstname` varchar(32) CHARACTER SET utf8 NOT NULL,
  `payment_lastname` varchar(32) CHARACTER SET utf8 NOT NULL,
  `payment_company` varchar(32) CHARACTER SET utf8 NOT NULL,
  `payment_address_1` varchar(128) CHARACTER SET utf8 NOT NULL,
  `payment_address_2` varchar(128) CHARACTER SET utf8 NOT NULL,
  `payment_city` varchar(128) CHARACTER SET utf8 NOT NULL,
  `payment_postcode` varchar(10) CHARACTER SET utf8 NOT NULL,
  `payment_country` varchar(128) CHARACTER SET utf8 NOT NULL,
  `payment_method` varchar(128) CHARACTER SET utf8 NOT NULL,
  `payment_phone` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `payment_fax` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `payment_email` varchar(90) CHARACTER SET utf8 DEFAULT NULL,
  `shipping_firstname` varchar(32) CHARACTER SET utf8 NOT NULL,
  `shipping_lastname` varchar(32) CHARACTER SET utf8 NOT NULL,
  `shipping_company` varchar(32) CHARACTER SET utf8 NOT NULL,
  `shipping_address_1` varchar(128) CHARACTER SET utf8 NOT NULL,
  `shipping_address_2` varchar(128) CHARACTER SET utf8 NOT NULL,
  `shipping_city` varchar(128) CHARACTER SET utf8 NOT NULL,
  `shipping_postcode` varchar(10) CHARACTER SET utf8 NOT NULL,
  `shipping_country` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `shipping_method` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `shipping_phone` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `shipping_fax` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `tax_rate` double NOT NULL DEFAULT '0',
  `vat_rate` double NOT NULL DEFAULT '0',
  `total` double NOT NULL DEFAULT '0',
  `total_products` int(5) NOT NULL DEFAULT '0',
  `affiliate_id` int(9) NOT NULL DEFAULT '0',
  `commission` double NOT NULL DEFAULT '0',
  `ip` varchar(128) CHARACTER SET utf8 NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `isreaded` int(1) NOT NULL DEFAULT '0',
  `order_status` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`orderid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

CREATE TABLE IF NOT EXISTS `orders_products` (
  `orderid` int(9) NOT NULL,
  `productid` int(9) NOT NULL,
  `quantity` int(9) NOT NULL DEFAULT '1',
  `downloads` longtext,
  `price` double NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `pageid` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `content` longtext CHARACTER SET utf8,
  `keywords` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `page_type` varchar(50) NOT NULL DEFAULT 'normal',
  `friendly_url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `isreaded` int(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `allowcomment` int(1) NOT NULL DEFAULT '1',
  `views` int(9) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pageid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE IF NOT EXISTS `payment_methods` (
  `methodid` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `foldername` varchar(128) NOT NULL,
  `method_data` longtext,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`methodid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`methodid`, `title`, `foldername`, `method_data`, `status`) VALUES
(4, 'Cash on delivery', 'cashondelivery', '{"require_form_on_checkout":"","after_click_confirm_check_out":"","title":"Cash on delivery","foldername":"cashondelivery"}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

CREATE TABLE IF NOT EXISTS `plugins` (
  `foldername` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `foldername` (`foldername`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `plugins_meta`
--

CREATE TABLE IF NOT EXISTS `plugins_meta` (
  `metaid` int(9) NOT NULL AUTO_INCREMENT,
  `foldername` varchar(100) NOT NULL,
  `limit_number` int(2) NOT NULL DEFAULT '0',
  `func` varchar(100) NOT NULL,
  `path` varchar(255) NOT NULL,
  `zonename` varchar(255) NOT NULL,
  `layoutname` varchar(30) DEFAULT NULL,
  `layoutposition` int(1) NOT NULL DEFAULT '0',
  `img_width` varchar(5) NOT NULL DEFAULT '0',
  `img_height` varchar(5) NOT NULL DEFAULT '0',
  `pagename` varchar(50) DEFAULT NULL,
  `variablename` varchar(100) DEFAULT NULL,
  `child_menu` longtext,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`metaid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `postid` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `catid` int(9) NOT NULL,
  `userid` int(9) NOT NULL,
  `parentid` int(9) NOT NULL DEFAULT '0',
  `image` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sort_order` int(9) NOT NULL DEFAULT '0',
  `date_added` datetime DEFAULT NULL,
  `views` int(9) NOT NULL DEFAULT '0',
  `content` longtext CHARACTER SET utf8,
  `post_type` varchar(50) NOT NULL DEFAULT 'normal',
  `keywords` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `friendly_url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `pageid` int(9) NOT NULL DEFAULT '0',
  `is_featured` int(1) NOT NULL DEFAULT '0',
  `date_featured` datetime DEFAULT NULL,
  `rating` int(2) NOT NULL DEFAULT '5',
  `isreaded` int(1) NOT NULL DEFAULT '0',
  `allowcomment` int(1) NOT NULL DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`postid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postid`, `title`, `catid`, `userid`, `parentid`, `image`, `sort_order`, `date_added`, `views`, `content`, `post_type`, `keywords`, `friendly_url`, `pageid`, `is_featured`, `date_featured`, `rating`, `isreaded`, `allowcomment`, `status`) VALUES
(1, 'Lorem Ipsum is simply dummy text', 15, 1, 0, 'uploads/images/8976702431/post_2.jpg', 1, '2015-03-16 05:35:00', 0, '[p][p][p][p][b]Lorem Ipsum[/b]&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.[/p][/p][/p][/p][/p]\r\n', 'normal', '', 'Lorem_Ipsum_is_simply_dummy_text', 0, 0, NULL, 5, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_meta`
--

CREATE TABLE IF NOT EXISTS `post_meta` (
  `metaid` int(9) NOT NULL AUTO_INCREMENT,
  `postid` int(9) NOT NULL,
  `metaname` varchar(150) NOT NULL,
  `metatext` longtext,
  `metaint` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`metaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

CREATE TABLE IF NOT EXISTS `post_tags` (
  `tagid` int(9) NOT NULL AUTO_INCREMENT,
  `tag_title` varchar(128) NOT NULL,
  `postid` int(9) NOT NULL,
  PRIMARY KEY (`tagid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `post_tags`
--

INSERT INTO `post_tags` (`tagid`, `tag_title`, `postid`) VALUES
(31, 'test theme demo', 1),
(32, 'test', 1),
(33, 'test theme', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `productid` int(9) NOT NULL AUTO_INCREMENT,
  `sku` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `upc` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `model` varchar(32) CHARACTER SET utf8 NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `quantity` int(9) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `content` longtext CHARACTER SET utf8,
  `attributes` longtext,
  `friendly_url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `points` int(9) NOT NULL DEFAULT '0',
  `customerid` int(9) DEFAULT '0',
  `is_featured` int(1) NOT NULL DEFAULT '0',
  `date_featured` datetime DEFAULT NULL,
  `is_shipping` int(1) NOT NULL DEFAULT '1',
  `manufacturerid` int(9) NOT NULL DEFAULT '0',
  `minimum` int(9) NOT NULL DEFAULT '0',
  `sort_order` int(9) NOT NULL DEFAULT '0',
  `viewed` int(9) NOT NULL DEFAULT '0',
  `keywords` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `date_discount` date DEFAULT NULL,
  `date_enddiscount` date DEFAULT NULL,
  `date_available` date NOT NULL,
  `price_discount` double NOT NULL DEFAULT '0',
  `options_command` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `quantity_discount` int(9) NOT NULL DEFAULT '0',
  `rating` int(2) NOT NULL DEFAULT '5',
  `isreaded` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`productid`),
  UNIQUE KEY `productid` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products_categories`
--

CREATE TABLE IF NOT EXISTS `products_categories` (
  `productid` int(9) NOT NULL,
  `catid` int(9) NOT NULL,
  KEY `productid` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products_downloads`
--

CREATE TABLE IF NOT EXISTS `products_downloads` (
  `productid` int(9) NOT NULL,
  `downloadid` int(9) NOT NULL,
  KEY `productid` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products_images`
--

CREATE TABLE IF NOT EXISTS `products_images` (
  `productid` int(9) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(9) NOT NULL DEFAULT '0',
  KEY `productid` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products_pages`
--

CREATE TABLE IF NOT EXISTS `products_pages` (
  `productid` int(9) NOT NULL,
  `pageid` int(9) NOT NULL,
  KEY `productid` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products_tags`
--

CREATE TABLE IF NOT EXISTS `products_tags` (
  `tagid` int(9) NOT NULL AUTO_INCREMENT,
  `tag_title` varchar(255) NOT NULL,
  `productid` int(9) NOT NULL,
  PRIMARY KEY (`tagid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `request_payments`
--

CREATE TABLE IF NOT EXISTS `request_payments` (
  `requestid` int(9) NOT NULL AUTO_INCREMENT,
  `userid` int(9) NOT NULL,
  `total_request` double NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `comments` longtext,
  PRIMARY KEY (`requestid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `reviewid` int(9) NOT NULL AUTO_INCREMENT,
  `userid` int(9) NOT NULL,
  `review_content` longtext CHARACTER SET utf8 NOT NULL,
  `date_added` datetime NOT NULL,
  `rating` int(1) NOT NULL DEFAULT '0',
  `isreaded` int(1) NOT NULL DEFAULT '0',
  `status` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT 'pending',
  `productid` int(9) NOT NULL,
  `parentid` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`reviewid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tax_rates`
--

CREATE TABLE IF NOT EXISTS `tax_rates` (
  `taxid` int(9) NOT NULL AUTO_INCREMENT,
  `tax_title` varchar(128) NOT NULL,
  `tax_rate` double NOT NULL DEFAULT '0',
  `tax_type` varchar(30) NOT NULL DEFAULT 'percent',
  `country_short` varchar(100) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`taxid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tax_rates`
--

INSERT INTO `tax_rates` (`taxid`, `tax_title`, `tax_rate`, `tax_type`, `country_short`, `date_added`, `status`) VALUES
(3, 'Free shipping', 0, 'fixedamount', 'worldwide', '2015-03-03 13:19:26', 0),
(4, 'USA Shipping', 50, 'fixedamount', 'US', '2015-03-03 13:19:26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `usergroups`
--

CREATE TABLE IF NOT EXISTS `usergroups` (
  `groupid` int(9) NOT NULL AUTO_INCREMENT,
  `group_title` varchar(255) NOT NULL,
  `groupdata` longtext,
  PRIMARY KEY (`groupid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `usergroups`
--

INSERT INTO `usergroups` (`groupid`, `group_title`, `groupdata`) VALUES
(1, 'Administrator', '{"can_view_post":"1","can_manage_post":"1","can_manage_comment":"1","can_addnew_post":"1","can_editowner_post":"1","can_editall_post":"1","can_deleteowner_post":"1","can_delete_post":"1","can_setstatus_post":"1","can_setfeatured_post":"1","default_post_status":"0","can_manage_category":"1","can_addnew_category":"1","can_edit_category":"1","can_delete_category":"1","can_manage_page":"1","can_addnew_page":"1","can_edit_page":"1","can_delete_page":"1","can_manage_users":"1","can_addnew_users":"1","can_edit_users":"1","can_delete_users":"1","can_manage_usergroups":"1","can_addnew_usergroups":"1","can_edit_usergroups":"1","can_delete_usergroups":"1","can_manage_appearance":"1","can_use_filemanager":"1","can_manage_plugins":"1","can_manage_settings":"1"}'),
(2, 'Member', '{"can_view_post":"1","can_manage_post":"1","can_addnew_post":"1","can_editowner_post":"1","can_deleteowner_post":"1","can_add_product":"1","can_edit_all_product":"1","can_delete_all_product":"1","enable_affiliate":"1","can_manage_review":"1","can_manage_voucher":"1","can_manage_coupon":"1"}'),
(3, 'Post Reviewer', '{"can_view_post":"1","can_manage_post":"1","can_manage_comment":"1","can_addnew_post":"1","can_editowner_post":"1","can_editall_post":"1","can_deleteowner_post":"1","can_setstatus_post":"1","default_post_status":"0","can_addnew_category":"1","can_edit_category":"1","can_delete_category":"1","can_addnew_page":"1","can_edit_page":"1","can_delete_page":"1","can_addnew_users":"1","can_edit_users":"1","can_delete_users":"1","can_addnew_usergroups":"1"}'),
(4, 'Super Member', '{"can_view_post":"1","can_manage_post":"1","can_manage_comment":"1","can_addnew_post":"1","can_editowner_post":"1","can_editall_post":"1","can_deleteowner_post":"1","can_delete_post":"1","can_setstatus_post":"1","can_setfeatured_post":"1","default_post_status":"0","can_manage_category":"1","can_addnew_category":"1","can_edit_category":"1","can_delete_category":"1","can_manage_page":"1","can_addnew_page":"1","can_edit_page":"1","can_delete_page":"1","can_addnew_users":"1","can_edit_users":"1","can_delete_users":"1","can_addnew_usergroups":"1"}'),
(5, 'Banned Member', '{"can_manage_comment":"1","can_addnew_post":"1","can_editowner_post":"1","can_editall_post":"1","can_deleteowner_post":"1","can_delete_post":"1","can_setstatus_post":"1","can_setfeatured_post":"1","can_addnew_category":"1","can_edit_category":"1","can_delete_category":"1","can_addnew_page":"1","can_edit_page":"1","can_delete_page":"1","can_addnew_users":"1","can_edit_users":"1","can_delete_users":"1","can_addnew_usergroups":"1"}'),
(6, 'Plugins & Theme Manager', '{"can_view_post":"1","can_manage_comment":"1","can_addnew_post":"1","can_editowner_post":"1","can_editall_post":"1","can_deleteowner_post":"1","can_delete_post":"1","can_setstatus_post":"1","can_setfeatured_post":"1","default_post_status":"0","can_addnew_category":"1","can_edit_category":"1","can_delete_category":"1","can_addnew_page":"1","can_edit_page":"1","can_delete_page":"1","can_addnew_users":"1","can_edit_users":"1","can_delete_users":"1","can_addnew_usergroups":"1","can_manage_appearance":"1","can_use_filemanager":"1","can_manage_plugins":"1"}'),
(7, 'Setting Manager', '{"can_view_post":"1","can_manage_comment":"1","can_addnew_post":"1","can_editowner_post":"1","can_editall_post":"1","can_deleteowner_post":"1","can_delete_post":"1","can_setstatus_post":"1","can_setfeatured_post":"1","default_post_status":"0","can_addnew_category":"1","can_edit_category":"1","can_delete_category":"1","can_addnew_page":"1","can_edit_page":"1","can_delete_page":"1","can_addnew_users":"1","can_edit_users":"1","can_delete_users":"1","can_addnew_usergroups":"1","can_manage_settings":"1"}'),
(8, 'Pending Member', '{"can_view_post":"1","can_manage_comment":"1","can_addnew_post":"1","can_editowner_post":"1","can_editall_post":"1","can_deleteowner_post":"1","can_delete_post":"1","can_setstatus_post":"1","can_setfeatured_post":"1","default_post_status":"0","can_addnew_category":"1","can_edit_category":"1","can_delete_category":"1","can_addnew_page":"1","can_edit_page":"1","can_delete_page":"1","can_addnew_users":"1","can_edit_users":"1","can_delete_users":"1","can_addnew_usergroups":"1"}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(9) NOT NULL AUTO_INCREMENT,
  `groupid` int(9) NOT NULL DEFAULT '0',
  `firstname` varchar(32) CHARACTER SET utf8 NOT NULL,
  `lastname` varchar(32) CHARACTER SET utf8 NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(96) NOT NULL,
  `password` varchar(128) NOT NULL,
  `balance` double NOT NULL DEFAULT '0',
  `ip` varchar(64) NOT NULL,
  `verify_code` varchar(255) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_admin` int(1) NOT NULL DEFAULT '0',
  `is_affiliate` int(1) NOT NULL DEFAULT '1',
  `expires_date` datetime DEFAULT NULL,
  `approved` int(1) NOT NULL DEFAULT '1',
  `isreaded` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `groupid`, `firstname`, `lastname`, `image`, `email`, `password`, `balance`, `ip`, `verify_code`, `date_added`, `is_admin`, `is_affiliate`, `expires_date`, `approved`, `isreaded`, `status`) VALUES
(1, 1, 'Jamessss', 'Browns', NULL, 'safeservicejt@gmail.com', 'c514c91e4ed341f263e458d44b3bb0a7', 0, '127.0.0.1', NULL, '2014-11-01 00:00:00', 1, 1, NULL, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_meta`
--

CREATE TABLE IF NOT EXISTS `users_meta` (
  `metaid` int(9) NOT NULL AUTO_INCREMENT,
  `userid` int(9) NOT NULL,
  `metaname` varchar(150) NOT NULL,
  `metatext` longtext,
  `metaint` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`metaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
