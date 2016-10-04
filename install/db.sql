-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2016 at 07:57 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `2016_project_noblesscms`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `userid` int(9) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `phone` varchar(155) DEFAULT NULL,
  `address_1` varchar(255) DEFAULT NULL,
  `address_2` varchar(255) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zipcode` varchar(30) DEFAULT NULL,
  `countrycode` varchar(20) DEFAULT NULL,
  `countryname` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`userid`, `firstname`, `lastname`, `phone`, `address_1`, `address_2`, `city`, `state`, `zipcode`, `countrycode`, `countryname`) VALUES
(7, 'Admin', 'System', NULL, 'sad', 'sad', 'asdasd', 'sd', '10001', 'Vietnam', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `friendly_url` varchar(255) DEFAULT NULL,
  `parentid` int(9) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'publish',
  `image` varchar(255) DEFAULT NULL,
  `views` int(9) NOT NULL DEFAULT '0',
  `page_title` varchar(255) NOT NULL,
  `descriptions` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `sort_order` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `friendly_url`, `parentid`, `date_added`, `status`, `image`, `views`, `page_title`, `descriptions`, `keywords`, `sort_order`) VALUES
(9, 'Tests', 'Test-9', 0, '2016-09-12 03:59:49', 'publish', NULL, 0, 'Test', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE IF NOT EXISTS `contactus` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(64) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `content` longtext CHARACTER SET utf8 NOT NULL,
  `date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=252 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `iso_code_2`, `iso_code_3`) VALUES
(1, 'Afghanistan', 'AF', 'AFG'),
(2, 'Albania', 'AL', 'ALB'),
(3, 'Algeria', 'DZ', 'DZA'),
(4, 'American Samoa', 'AS', 'ASM'),
(5, 'Andorra', 'AD', 'AND'),
(6, 'Angola', 'AO', 'AGO'),
(7, 'Anguilla', 'AI', 'AIA'),
(8, 'Antarctica', 'AQ', 'ATA'),
(9, 'Antigua and Barbuda', 'AG', 'ATG'),
(10, 'Argentina', 'AR', 'ARG'),
(11, 'Armenia', 'AM', 'ARM'),
(12, 'Aruba', 'AW', 'ABW'),
(13, 'Australia', 'AU', 'AUS'),
(14, 'Austria', 'AT', 'AUT'),
(15, 'Azerbaijan', 'AZ', 'AZE'),
(16, 'Bahamas', 'BS', 'BHS'),
(17, 'Bahrain', 'BH', 'BHR'),
(18, 'Bangladesh', 'BD', 'BGD'),
(19, 'Barbados', 'BB', 'BRB'),
(20, 'Belarus', 'BY', 'BLR'),
(21, 'Belgium', 'BE', 'BEL'),
(22, 'Belize', 'BZ', 'BLZ'),
(23, 'Benin', 'BJ', 'BEN'),
(24, 'Bermuda', 'BM', 'BMU'),
(25, 'Bhutan', 'BT', 'BTN'),
(26, 'Bolivia', 'BO', 'BOL'),
(27, 'Bosnia and Herzegovina', 'BA', 'BIH'),
(28, 'Botswana', 'BW', 'BWA'),
(29, 'Bouvet Island', 'BV', 'BVT'),
(30, 'Brazil', 'BR', 'BRA'),
(31, 'British Indian Ocean Territory', 'IO', 'IOT'),
(32, 'Brunei Darussalam', 'BN', 'BRN'),
(33, 'Bulgaria', 'BG', 'BGR'),
(34, 'Burkina Faso', 'BF', 'BFA'),
(35, 'Burundi', 'BI', 'BDI'),
(36, 'Cambodia', 'KH', 'KHM'),
(37, 'Cameroon', 'CM', 'CMR'),
(38, 'Canada', 'CA', 'CAN'),
(39, 'Cape Verde', 'CV', 'CPV'),
(40, 'Cayman Islands', 'KY', 'CYM'),
(41, 'Central African Republic', 'CF', 'CAF'),
(42, 'Chad', 'TD', 'TCD'),
(43, 'Chile', 'CL', 'CHL'),
(44, 'China', 'CN', 'CHN'),
(45, 'Christmas Island', 'CX', 'CXR'),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK'),
(47, 'Colombia', 'CO', 'COL'),
(48, 'Comoros', 'KM', 'COM'),
(49, 'Congo', 'CG', 'COG'),
(50, 'Cook Islands', 'CK', 'COK'),
(51, 'Costa Rica', 'CR', 'CRI'),
(52, 'Cote D''Ivoire', 'CI', 'CIV'),
(53, 'Croatia', 'HR', 'HRV'),
(54, 'Cuba', 'CU', 'CUB'),
(55, 'Cyprus', 'CY', 'CYP'),
(56, 'Czech Republic', 'CZ', 'CZE'),
(57, 'Denmark', 'DK', 'DNK'),
(58, 'Djibouti', 'DJ', 'DJI'),
(59, 'Dominica', 'DM', 'DMA'),
(60, 'Dominican Republic', 'DO', 'DOM'),
(61, 'East Timor', 'TL', 'TLS'),
(62, 'Ecuador', 'EC', 'ECU'),
(63, 'Egypt', 'EG', 'EGY'),
(64, 'El Salvador', 'SV', 'SLV'),
(65, 'Equatorial Guinea', 'GQ', 'GNQ'),
(66, 'Eritrea', 'ER', 'ERI'),
(67, 'Estonia', 'EE', 'EST'),
(68, 'Ethiopia', 'ET', 'ETH'),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK'),
(70, 'Faroe Islands', 'FO', 'FRO'),
(71, 'Fiji', 'FJ', 'FJI'),
(72, 'Finland', 'FI', 'FIN'),
(74, 'France, Metropolitan', 'FR', 'FRA'),
(75, 'French Guiana', 'GF', 'GUF'),
(76, 'French Polynesia', 'PF', 'PYF'),
(77, 'French Southern Territories', 'TF', 'ATF'),
(78, 'Gabon', 'GA', 'GAB'),
(79, 'Gambia', 'GM', 'GMB'),
(80, 'Georgia', 'GE', 'GEO'),
(81, 'Germany', 'DE', 'DEU'),
(82, 'Ghana', 'GH', 'GHA'),
(83, 'Gibraltar', 'GI', 'GIB'),
(84, 'Greece', 'GR', 'GRC'),
(85, 'Greenland', 'GL', 'GRL'),
(86, 'Grenada', 'GD', 'GRD'),
(87, 'Guadeloupe', 'GP', 'GLP'),
(88, 'Guam', 'GU', 'GUM'),
(89, 'Guatemala', 'GT', 'GTM'),
(90, 'Guinea', 'GN', 'GIN'),
(91, 'Guinea-Bissau', 'GW', 'GNB'),
(92, 'Guyana', 'GY', 'GUY'),
(93, 'Haiti', 'HT', 'HTI'),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD'),
(95, 'Honduras', 'HN', 'HND'),
(96, 'Hong Kong', 'HK', 'HKG'),
(97, 'Hungary', 'HU', 'HUN'),
(98, 'Iceland', 'IS', 'ISL'),
(99, 'India', 'IN', 'IND'),
(100, 'Indonesia', 'ID', 'IDN'),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN'),
(102, 'Iraq', 'IQ', 'IRQ'),
(103, 'Ireland', 'IE', 'IRL'),
(104, 'Israel', 'IL', 'ISR'),
(105, 'Italy', 'IT', 'ITA'),
(106, 'Jamaica', 'JM', 'JAM'),
(107, 'Japan', 'JP', 'JPN'),
(108, 'Jordan', 'JO', 'JOR'),
(109, 'Kazakhstan', 'KZ', 'KAZ'),
(110, 'Kenya', 'KE', 'KEN'),
(111, 'Kiribati', 'KI', 'KIR'),
(112, 'North Korea', 'KP', 'PRK'),
(113, 'Korea, Republic of', 'KR', 'KOR'),
(114, 'Kuwait', 'KW', 'KWT'),
(115, 'Kyrgyzstan', 'KG', 'KGZ'),
(116, 'Lao People''s Democratic Republic', 'LA', 'LAO'),
(117, 'Latvia', 'LV', 'LVA'),
(118, 'Lebanon', 'LB', 'LBN'),
(119, 'Lesotho', 'LS', 'LSO'),
(120, 'Liberia', 'LR', 'LBR'),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY'),
(122, 'Liechtenstein', 'LI', 'LIE'),
(123, 'Lithuania', 'LT', 'LTU'),
(124, 'Luxembourg', 'LU', 'LUX'),
(125, 'Macau', 'MO', 'MAC'),
(126, 'FYROM', 'MK', 'MKD'),
(127, 'Madagascar', 'MG', 'MDG'),
(128, 'Malawi', 'MW', 'MWI'),
(129, 'Malaysia', 'MY', 'MYS'),
(130, 'Maldives', 'MV', 'MDV'),
(131, 'Mali', 'ML', 'MLI'),
(132, 'Malta', 'MT', 'MLT'),
(133, 'Marshall Islands', 'MH', 'MHL'),
(134, 'Martinique', 'MQ', 'MTQ'),
(135, 'Mauritania', 'MR', 'MRT'),
(136, 'Mauritius', 'MU', 'MUS'),
(137, 'Mayotte', 'YT', 'MYT'),
(138, 'Mexico', 'MX', 'MEX'),
(139, 'Micronesia, Federated States of', 'FM', 'FSM'),
(140, 'Moldova, Republic of', 'MD', 'MDA'),
(141, 'Monaco', 'MC', 'MCO'),
(142, 'Mongolia', 'MN', 'MNG'),
(143, 'Montserrat', 'MS', 'MSR'),
(144, 'Morocco', 'MA', 'MAR'),
(145, 'Mozambique', 'MZ', 'MOZ'),
(146, 'Myanmar', 'MM', 'MMR'),
(147, 'Namibia', 'NA', 'NAM'),
(148, 'Nauru', 'NR', 'NRU'),
(149, 'Nepal', 'NP', 'NPL'),
(150, 'Netherlands', 'NL', 'NLD'),
(151, 'Netherlands Antilles', 'AN', 'ANT'),
(152, 'New Caledonia', 'NC', 'NCL'),
(153, 'New Zealand', 'NZ', 'NZL'),
(154, 'Nicaragua', 'NI', 'NIC'),
(155, 'Niger', 'NE', 'NER'),
(156, 'Nigeria', 'NG', 'NGA'),
(157, 'Niue', 'NU', 'NIU'),
(158, 'Norfolk Island', 'NF', 'NFK'),
(159, 'Northern Mariana Islands', 'MP', 'MNP'),
(160, 'Norway', 'NO', 'NOR'),
(161, 'Oman', 'OM', 'OMN'),
(162, 'Pakistan', 'PK', 'PAK'),
(163, 'Palau', 'PW', 'PLW'),
(164, 'Panama', 'PA', 'PAN'),
(165, 'Papua New Guinea', 'PG', 'PNG'),
(166, 'Paraguay', 'PY', 'PRY'),
(167, 'Peru', 'PE', 'PER'),
(168, 'Philippines', 'PH', 'PHL'),
(169, 'Pitcairn', 'PN', 'PCN'),
(170, 'Poland', 'PL', 'POL'),
(171, 'Portugal', 'PT', 'PRT'),
(172, 'Puerto Rico', 'PR', 'PRI'),
(173, 'Qatar', 'QA', 'QAT'),
(174, 'Reunion', 'RE', 'REU'),
(175, 'Romania', 'RO', 'ROM'),
(176, 'Russian Federation', 'RU', 'RUS'),
(177, 'Rwanda', 'RW', 'RWA'),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA'),
(179, 'Saint Lucia', 'LC', 'LCA'),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT'),
(181, 'Samoa', 'WS', 'WSM'),
(182, 'San Marino', 'SM', 'SMR'),
(183, 'Sao Tome and Principe', 'ST', 'STP'),
(184, 'Saudi Arabia', 'SA', 'SAU'),
(185, 'Senegal', 'SN', 'SEN'),
(186, 'Seychelles', 'SC', 'SYC'),
(187, 'Sierra Leone', 'SL', 'SLE'),
(188, 'Singapore', 'SG', 'SGP'),
(189, 'Slovak Republic', 'SK', 'SVK'),
(190, 'Slovenia', 'SI', 'SVN'),
(191, 'Solomon Islands', 'SB', 'SLB'),
(192, 'Somalia', 'SO', 'SOM'),
(193, 'South Africa', 'ZA', 'ZAF'),
(194, 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS'),
(195, 'Spain', 'ES', 'ESP'),
(196, 'Sri Lanka', 'LK', 'LKA'),
(197, 'St. Helena', 'SH', 'SHN'),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM'),
(199, 'Sudan', 'SD', 'SDN'),
(200, 'Suriname', 'SR', 'SUR'),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM'),
(202, 'Swaziland', 'SZ', 'SWZ'),
(203, 'Sweden', 'SE', 'SWE'),
(204, 'Switzerland', 'CH', 'CHE'),
(205, 'Syrian Arab Republic', 'SY', 'SYR'),
(206, 'Taiwan', 'TW', 'TWN'),
(207, 'Tajikistan', 'TJ', 'TJK'),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA'),
(209, 'Thailand', 'TH', 'THA'),
(210, 'Togo', 'TG', 'TGO'),
(211, 'Tokelau', 'TK', 'TKL'),
(212, 'Tonga', 'TO', 'TON'),
(213, 'Trinidad and Tobago', 'TT', 'TTO'),
(214, 'Tunisia', 'TN', 'TUN'),
(215, 'Turkey', 'TR', 'TUR'),
(216, 'Turkmenistan', 'TM', 'TKM'),
(217, 'Turks and Caicos Islands', 'TC', 'TCA'),
(218, 'Tuvalu', 'TV', 'TUV'),
(219, 'Uganda', 'UG', 'UGA'),
(220, 'Ukraine', 'UA', 'UKR'),
(221, 'United Arab Emirates', 'AE', 'ARE'),
(222, 'United Kingdom', 'GB', 'GBR'),
(223, 'United States', 'US', 'USA'),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI'),
(225, 'Uruguay', 'UY', 'URY'),
(226, 'Uzbekistan', 'UZ', 'UZB'),
(227, 'Vanuatu', 'VU', 'VUT'),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT'),
(229, 'Venezuela', 'VE', 'VEN'),
(230, 'Viet Nam', 'VN', 'VNM'),
(231, 'Virgin Islands (British)', 'VG', 'VGB'),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR'),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF'),
(234, 'Western Sahara', 'EH', 'ESH'),
(235, 'Yemen', 'YE', 'YEM'),
(237, 'Democratic Republic of Congo', 'CD', 'COD'),
(238, 'Zambia', 'ZM', 'ZMB'),
(239, 'Zimbabwe', 'ZW', 'ZWE'),
(240, 'Jersey', 'JE', 'JEY'),
(241, 'Guernsey', 'GG', 'GGY'),
(242, 'Montenegro', 'ME', 'MNE'),
(243, 'Serbia', 'RS', 'SRB'),
(244, 'Aaland Islands', 'AX', 'ALA'),
(245, 'Bonaire, Sint Eustatius and Saba', 'BQ', 'BES'),
(246, 'Curacao', 'CW', 'CUW'),
(247, 'Palestinian Territory, Occupied', 'PS', 'PSE'),
(248, 'South Sudan', 'SS', 'SSD'),
(249, 'St. Barthelemy', 'BL', 'BLM'),
(250, 'St. Martin (French part)', 'MF', 'MAF'),
(251, 'Canary Islands', 'IC', 'ICA');

-- --------------------------------------------------------

--
-- Table structure for table `cronjobs`
--

CREATE TABLE IF NOT EXISTS `cronjobs` (
  `cronid` int(9) NOT NULL AUTO_INCREMENT,
  `timenumber` int(9) NOT NULL DEFAULT '0',
  `timetype` varchar(30) NOT NULL DEFAULT 'min',
  `timeinterval` int(9) NOT NULL DEFAULT '0',
  `last_update` datetime DEFAULT NULL,
  `jobdata` varchar(1000) NOT NULL,
  `date_added` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cronid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `content` longtext,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `parentid` int(9) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `sort_order` int(9) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'publish',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `parentid`, `title`, `image`, `url`, `sort_order`, `date_added`, `status`) VALUES
(1, 0, 'Home', NULL, '/', 1, '2016-09-12 07:59:41', 'unpublish');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `date_added` datetime NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `userid` int(9) NOT NULL,
  `title` varchar(255) NOT NULL,
  `friendly_url` varchar(255) DEFAULT NULL,
  `date_added` datetime NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'publish',
  `content` longtext,
  `page_title` varchar(255) NOT NULL,
  `descriptions` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'page',
  `allowcomment` int(1) NOT NULL DEFAULT '1',
  `views` int(9) DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `userid`, `title`, `friendly_url`, `date_added`, `status`, `content`, `page_title`, `descriptions`, `keywords`, `type`, `allowcomment`, `views`, `image`) VALUES
(2, 7, 'Test pagess', 'Test-page-2', '2016-09-12 05:58:27', '1', '<p>Test pageTest pageTest pageTest pageTest page</p>\r\n', 'Test page', '', '', 'normal', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pluginmetas`
--

CREATE TABLE IF NOT EXISTS `pluginmetas` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `foldername` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `zonename` varchar(255) NOT NULL,
  `sort_order` int(9) NOT NULL DEFAULT '0',
  `type` varchar(30) NOT NULL DEFAULT 'function',
  `funcname` varchar(155) DEFAULT NULL,
  `classname` varchar(155) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `foldername` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `userid` int(9) NOT NULL,
  `title` varchar(255) NOT NULL,
  `friendly_url` varchar(255) DEFAULT NULL,
  `catid` int(9) NOT NULL,
  `content` longtext,
  `image` varchar(255) DEFAULT NULL,
  `category_data` longtext,
  `images_data` longtext,
  `tag_data` longtext,
  `page_title` varchar(255) NOT NULL,
  `descriptions` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `views` int(9) NOT NULL DEFAULT '0',
  `type` varchar(50) NOT NULL DEFAULT 'post',
  `status` varchar(30) NOT NULL DEFAULT 'publish',
  `date_added` datetime NOT NULL,
  `likes` int(9) NOT NULL DEFAULT '0',
  `shares` int(9) NOT NULL DEFAULT '0',
  `allowcomment` int(1) NOT NULL DEFAULT '1',
  `is_featured` int(1) NOT NULL DEFAULT '0',
  `date_featured` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `userid`, `title`, `friendly_url`, `catid`, `content`, `image`, `category_data`, `images_data`, `tag_data`, `page_title`, `descriptions`, `keywords`, `views`, `type`, `status`, `date_added`, `likes`, `shares`, `allowcomment`, `is_featured`, `date_featured`) VALUES
(7, 7, 'Test post', 'Test-post-7', 9, '<p>Test postTest postTest postTest postTest postTest postTest postTest postTest post</p>\r\n', NULL, 'a:13:{s:2:"id";s:1:"9";s:5:"title";s:5:"Tests";s:12:"friendly_url";s:6:"Test-9";s:8:"parentid";s:1:"0";s:10:"date_added";s:19:"2016-09-12 03:59:49";s:6:"status";s:7:"publish";s:5:"image";N;s:5:"views";s:1:"0";s:10:"page_title";s:4:"Test";s:12:"descriptions";s:0:"";s:8:"keywords";s:0:"";s:10:"sort_order";s:1:"0";s:3:"url";s:48:"http://test.vn/project/2015/noblessecmsv3/Test-9";}', NULL, 'a:2:{i:0;a:5:{s:2:"id";s:2:"24";s:6:"postid";s:1:"7";s:5:"title";s:4:"post";s:12:"friendly_url";s:4:"post";s:3:"url";s:55:"http://test.vn/project/2015/noblessecmsv3/tag/post.html";}i:1;a:5:{s:2:"id";s:2:"23";s:6:"postid";s:1:"7";s:5:"title";s:3:"tag";s:12:"friendly_url";s:3:"tag";s:3:"url";s:54:"http://test.vn/project/2015/noblessecmsv3/tag/tag.html";}}', '', '', '', 0, 'normal', 'publish', '2016-09-12 07:05:52', 0, 0, 1, 0, NULL),
(8, 7, 'Test post', 'Test-post-8', 9, '<p>Test postTest postTest postTest postTest postTest postTest postTest postTest post</p>\r\n', NULL, 'a:13:{s:2:"id";s:1:"9";s:5:"title";s:5:"Tests";s:12:"friendly_url";s:6:"Test-9";s:8:"parentid";s:1:"0";s:10:"date_added";s:19:"2016-09-12 03:59:49";s:6:"status";s:7:"publish";s:5:"image";N;s:5:"views";s:1:"0";s:10:"page_title";s:4:"Test";s:12:"descriptions";s:0:"";s:8:"keywords";s:0:"";s:10:"sort_order";s:1:"0";s:3:"url";s:48:"http://test.vn/project/2015/noblessecmsv3/Test-9";}', NULL, 'a:2:{i:0;a:5:{s:2:"id";s:2:"26";s:6:"postid";s:1:"8";s:5:"title";s:4:"post";s:12:"friendly_url";s:4:"post";s:3:"url";s:55:"http://test.vn/project/2015/noblessecmsv3/tag/post.html";}i:1;a:5:{s:2:"id";s:2:"25";s:6:"postid";s:1:"8";s:5:"title";s:3:"tag";s:12:"friendly_url";s:3:"tag";s:3:"url";s:54:"http://test.vn/project/2015/noblessecmsv3/tag/tag.html";}}', 'Test post', '', '', 0, 'normal', 'publish', '2016-09-12 07:07:45', 0, 0, 1, 0, NULL),
(9, 7, 'Test post kdfdsss', 'Test-post-kdfd-9', 9, '<p>Test post kdfdTest post kdfdTest post kdfdTest post kdfdTest post kdfd</p>\r\n', 'uploads/files/wmroyeQyTu/Test-post-kdfd.jpg', 'a:13:{s:2:"id";s:1:"9";s:5:"title";s:5:"Tests";s:12:"friendly_url";s:6:"Test-9";s:8:"parentid";s:1:"0";s:10:"date_added";s:19:"2016-09-12 03:59:49";s:6:"status";s:7:"publish";s:5:"image";N;s:5:"views";s:1:"0";s:10:"page_title";s:4:"Test";s:12:"descriptions";s:0:"";s:8:"keywords";s:0:"";s:10:"sort_order";s:1:"0";s:3:"url";s:48:"http://test.vn/project/2015/noblessecmsv3/Test-9";}', NULL, 'a:3:{i:0;a:5:{s:2:"id";s:2:"34";s:6:"postid";s:1:"9";s:5:"title";s:4:"post";s:12:"friendly_url";s:4:"post";s:3:"url";s:55:"http://test.vn/project/2015/noblessecmsv3/tag/post.html";}i:1;a:5:{s:2:"id";s:2:"33";s:6:"postid";s:1:"9";s:5:"title";s:3:"tag";s:12:"friendly_url";s:3:"tag";s:3:"url";s:54:"http://test.vn/project/2015/noblessecmsv3/tag/tag.html";}i:2;a:5:{s:2:"id";s:2:"32";s:6:"postid";s:1:"9";s:5:"title";s:4:"test";s:12:"friendly_url";s:4:"test";s:3:"url";s:55:"http://test.vn/project/2015/noblessecmsv3/tag/test.html";}}', 'Test post kdfd', '', '', 25, 'normal', 'publish', '2016-09-12 07:11:30', 0, 0, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_images`
--

CREATE TABLE IF NOT EXISTS `post_images` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `postid` int(9) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

CREATE TABLE IF NOT EXISTS `post_tags` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `postid` int(9) NOT NULL,
  `title` varchar(255) NOT NULL,
  `friendly_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `post_tags`
--

INSERT INTO `post_tags` (`id`, `postid`, `title`, `friendly_url`) VALUES
(23, 7, 'tag', 'tag'),
(24, 7, 'post', 'post'),
(25, 8, 'tag', 'tag'),
(26, 8, 'post', 'post'),
(32, 9, 'test', 'test'),
(33, 9, 'tag', 'tag'),
(34, 9, 'post', 'post');

-- --------------------------------------------------------

--
-- Table structure for table `redirects`
--

CREATE TABLE IF NOT EXISTS `redirects` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `from_url` varchar(255) NOT NULL,
  `to_url` varchar(255) DEFAULT NULL,
  `date_added` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `redirects`
--

INSERT INTO `redirects` (`id`, `from_url`, `to_url`, `date_added`, `status`) VALUES
(2, '/post/Test-post-kdfd-9.html', 'http://1news.top/admincp/redirects', '2016-09-12 07:11:30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usergroups`
--

CREATE TABLE IF NOT EXISTS `usergroups` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `permissions` longtext,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `usergroups`
--

INSERT INTO `usergroups` (`id`, `title`, `permissions`, `date_added`) VALUES
(1, 'Administrator', 'can_view_admincp:yes\r\ncan_view_usercp:yes\r\ncan_view_homepage:yes\r\ncan_view_post:yes\r\ncan_insert_comment:yes\r\ncan_manage_post:yes\r\ncan_addnew_post:yes\r\ncan_edit_post:yes\r\ncan_remove_post:yes\r\ncan_manage_link:yes\r\ncan_addnew_link:yes\r\ncan_edit_link:yes\r\ncan_remove_link:yes\r\ncan_addnew_category:yes\r\ncan_edit_category:yes\r\ncan_remove_category:yes\r\ncan_addnew_redirect:yes\r\ncan_edit_redirect:yes\r\ncan_remove_redirect:yes\r\ncan_manage_contactus:yes\r\ncan_remove_contactus:yes\r\ncan_addnew_page:yes\r\ncan_edit_page:yes\r\ncan_remove_page:yes\r\ncan_addnew_user:yes\r\ncan_edit_user:yes\r\ncan_remove_user:yes\r\ncan_edit_user_group:yes\r\ncan_addnew_usergroup:yes\r\ncan_edit_usergroup:yes\r\ncan_remove_usergroup:yes\r\ncan_setting_system:yes\r\ncan_manage_plugins:yes\r\ncan_manage_themes:yes\r\ncan_activate_theme:yes\r\ncan_edit_theme:yes\r\ncan_setting_theme:yes\r\ncan_control_theme:yes\r\ncan_import_theme:yes\r\ncan_install_plugin:yes\r\ncan_run_plugin:yes\r\ncan_setting_plugin:yes\r\ncan_uninstall_plugin:yes\r\ncan_activate_plugin:yes\r\ncan_deactivate_plugin:yes\r\ncan_import_plugin:yes\r\ncan_manage_category:yes\r\ncan_manage_user:yes\r\ncan_manage_usergroup:yes\r\ncan_remove_owner_post:yes\r\ndefault_new_post_status:1\r\nshow_category_manager:yes\r\nshow_post_manager:yes\r\nshow_comment_manager:yes\r\nshow_page_manager:yes\r\nshow_link_manager:yes\r\nshow_user_manager:yes\r\nshow_usergroup_manager:yes\r\nshow_contact_manager:yes\r\nshow_theme_manager:yes\r\nshow_plugin_manager:yes\r\nshow_setting_manager:yes\r\nshow_all_post:yes\r\ncan_remove_all_post:yes\r\ncan_change_password:yes\r\ncan_change_profile:yes\r\ncan_setting_mail:yes\r\ncan_update_system:yes\r\ncan_clear_cache:yes\r\ndefault_free_point_eachday:0\r\ncan_control_plugin:yes\r\nis_fastecommerce_owner:yes\r\ncan_addnew_product:yes\r\ncan_update_product:yes\r\ncan_remove_product:yes\r\ncan_addnew_hotspt:yes', '2016-09-11 13:22:36'),
(2, 'Member', 'can_view_admincp:yes\r\ncan_view_usercp:yes\r\ncan_view_homepage:yes\r\ncan_view_post:yes\r\ncan_insert_comment:yes\r\ncan_manage_post:no\r\ncan_addnew_post:yes\r\ncan_edit_post:yes\r\ncan_remove_post:yes\r\ncan_manage_link:no\r\ncan_addnew_link:yes\r\ncan_edit_link:no\r\ncan_remove_link:no\r\ncan_addnew_category:no\r\ncan_edit_category:no\r\ncan_remove_category:no\r\ncan_addnew_redirect:no\r\ncan_edit_redirect:no\r\ncan_remove_redirect:no\r\ncan_manage_contactus:no\r\ncan_remove_contactus:no\r\ncan_addnew_page:no\r\ncan_edit_page:no\r\ncan_remove_page:no\r\ncan_addnew_user:no\r\ncan_edit_user:no\r\ncan_remove_user:no\r\ncan_edit_user_group:no\r\ncan_addnew_usergroup:no\r\ncan_edit_usergroup:no\r\ncan_remove_usergroup:no\r\ncan_setting_system:no\r\ncan_manage_plugins:no\r\ncan_manage_themes:no\r\ncan_activate_theme:no\r\ncan_import_theme:no\r\ncan_edit_theme:no\r\ncan_setting_theme:no\r\ncan_control_theme:no\r\ncan_install_plugin:no\r\ncan_run_plugin:yes\r\ncan_setting_plugin:yes\r\ncan_uninstall_plugin:no\r\ncan_activate_plugin:no\r\ncan_deactivate_plugin:no\r\ncan_import_plugin:no\r\ncan_manage_category:no\r\ncan_manage_user:no\r\ncan_manage_usergroup:no\r\ncan_login_to_admincp:yes\r\ncan_login_to_usercp:yes\r\ncan_remove_owner_post:yes\r\ndefault_new_post_status:0\r\nshow_category_manager:no\r\nshow_post_manager:no\r\nshow_comment_manager:no\r\nshow_page_manager:no\r\nshow_link_manager:no\r\nshow_user_manager:no\r\nshow_usergroup_manager:no\r\nshow_contact_manager:no\r\nshow_theme_manager:no\r\nshow_plugin_manager:no\r\nshow_setting_manager:no\r\nshow_all_post:no\r\ncan_remove_all_post:no\r\ndefault_free_point_eachday:0\r\ncan_change_profile:yes\r\ncan_control_plugin:yes\r\nis_fastecommerce_owner:no\r\ncan_addnew_product:yes\r\ncan_update_product:no\r\ncan_remove_product:no\r\ncan_addnew_hotspt:yes\r\n', '2016-09-11 13:23:07'),
(3, 'Banned Member', 'can_view_admincp:no\r\ncan_view_usercp:no\r\ncan_view_homepage:yes\r\ncan_view_post:yes\r\ncan_insert_comment:no\r\ncan_manage_post:no\r\ncan_addnew_post:no\r\ncan_edit_post:no\r\ncan_remove_post:no\r\ncan_manage_link:no\r\ncan_addnew_link:yes\r\ncan_edit_link:no\r\ncan_remove_link:no\r\ncan_addnew_category:no\r\ncan_edit_category:no\r\ncan_remove_category:no\r\ncan_addnew_redirect:no\r\ncan_edit_redirect:no\r\ncan_remove_redirect:no\r\ncan_manage_contactus:no\r\ncan_remove_contactus:no\r\ncan_addnew_page:no\r\ncan_edit_page:no\r\ncan_remove_page:no\r\ncan_addnew_user:no\r\ncan_edit_user:no\r\ncan_remove_user:no\r\ncan_edit_user_group:no\r\ncan_addnew_usergroup:no\r\ncan_edit_usergroup:no\r\ncan_remove_usergroup:no\r\ncan_setting_system:no\r\ncan_manage_plugins:no\r\ncan_manage_themes:no\r\ncan_import_theme:no\r\ncan_manage_category:no\r\ncan_manage_user:no\r\ncan_manage_usergroup:no\r\ncan_login_to_admincp:no\r\ncan_login_to_usercp:no\r\ncan_remove_owner_post:no\r\ndefault_new_post_status:0\r\nshow_category_manager:no\r\nshow_post_manager:no\r\nshow_comment_manager:no\r\nshow_page_manager:no\r\nshow_link_manager:no\r\nshow_user_manager:no\r\nshow_usergroup_manager:no\r\nshow_contact_manager:no\r\nshow_theme_manager:no\r\nshow_plugin_manager:no\r\nshow_setting_manager:no\r\nshow_all_post:no\r\ndefault_free_point_eachday:0\r\ncan_activate_plugin:no\r\ncan_uninstall_plugin:no\r\ncan_deactivate_plugin:no\r\ncan_install_plugin:no\r\ncan_import_plugin:no\r\ncan_change_profile:yes\r\ncan_control_plugin:yes\r\nis_fastecommerce_owner:no\r\ncan_addnew_product:yes\r\ncan_update_product:no\r\ncan_remove_product:no\r\ncan_addnew_hotspt:yes\r\n', '2016-09-11 13:23:17'),
(4, 'Pending Member', 'can_view_admincp:no\r\ncan_view_usercp:no\r\ncan_view_homepage:yes\r\ncan_view_post:yes\r\ncan_insert_comment:no\r\ncan_manage_post:no\r\ncan_addnew_post:no\r\ncan_edit_post:no\r\ncan_remove_post:no\r\ncan_manage_link:no\r\ncan_addnew_link:yes\r\ncan_edit_link:no\r\ncan_remove_link:no\r\ncan_addnew_category:no\r\ncan_edit_category:no\r\ncan_remove_category:no\r\ncan_addnew_redirect:no\r\ncan_edit_redirect:no\r\ncan_remove_redirect:no\r\ncan_manage_contactus:no\r\ncan_remove_contactus:no\r\ncan_addnew_page:no\r\ncan_edit_page:no\r\ncan_remove_page:no\r\ncan_addnew_user:no\r\ncan_edit_user:no\r\ncan_remove_user:no\r\ncan_edit_user_group:no\r\ncan_addnew_usergroup:no\r\ncan_edit_usergroup:no\r\ncan_remove_usergroup:no\r\ncan_setting_system:no\r\ncan_manage_plugins:no\r\ncan_manage_themes:no\r\ncan_activate_theme:no\r\ncan_edit_theme:no\r\ncan_setting_theme:no\r\ncan_control_theme:no\r\ncan_install_plugin:no\r\ncan_run_plugin:no\r\ncan_setting_plugin:no\r\ncan_uninstall_plugin:no\r\ncan_activate_plugin:no\r\ncan_deactivate_plugin:no\r\ncan_import_plugin:no\r\ncan_manage_category:no\r\ncan_manage_user:no\r\ncan_manage_usergroup:no\r\ncan_login_to_admincp:no\r\ncan_login_to_usercp:no\r\ncan_remove_owner_post:no\r\ndefault_new_post_status:0\r\nshow_category_manager:no\r\nshow_post_manager:no\r\nshow_comment_manager:no\r\nshow_page_manager:no\r\nshow_link_manager:no\r\nshow_user_manager:no\r\nshow_usergroup_manager:no\r\nshow_contact_manager:no\r\nshow_theme_manager:no\r\nshow_plugin_manager:no\r\nshow_setting_manager:no\r\ndefault_free_point_eachday:0\r\ncan_import_theme:no\r\ncan_change_profile:yes\r\ncan_control_plugin:yes\r\nis_fastecommerce_owner:no\r\ncan_addnew_product:yes\r\ncan_update_product:no\r\ncan_remove_product:no\r\ncan_addnew_hotspt:yes\r\n', '2016-09-11 13:23:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `date_added` datetime NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `groupid` int(9) NOT NULL,
  `verify_code` varchar(155) DEFAULT '',
  `forgot_date` datetime DEFAULT NULL,
  `verify_forgot` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `date_added`, `username`, `email`, `image`, `password`, `groupid`, `verify_code`, `forgot_date`, `verify_forgot`) VALUES
(7, '2016-09-11 17:50:24', 'admin', 'admin@gmail.com', NULL, 'lyh6SOlawcU=', 1, '', NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
