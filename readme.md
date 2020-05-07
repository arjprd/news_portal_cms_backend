
# News Portal Backend

## 1. Installation Instruction

- ### For Windows:
  - Install Wamp or Xamp
  - Create the Database sppecified below
  - Clone the project into the root directory and point the request to root of the project

## 2. Database Strucure

- ### For news_portal_temp

```
-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 07, 2020 at 12:28 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `news_portal_temp`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_verification`
--

DROP TABLE IF EXISTS `email_verification`;
CREATE TABLE IF NOT EXISTS `email_verification` (
  `email_id` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `hash` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `lastupdated` int(11) NOT NULL,
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mobile_verification`
--

DROP TABLE IF EXISTS `mobile_verification`;
CREATE TABLE IF NOT EXISTS `mobile_verification` (
  `mobile` varchar(255) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `lastupdated` int(11) NOT NULL,
  PRIMARY KEY (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

DROP TABLE IF EXISTS `signup`;
CREATE TABLE IF NOT EXISTS `signup` (
  `email_id` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `mobile` varchar(20) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `name` text NOT NULL,
  `password` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `pin` varchar(20) NOT NULL,
  `country` text NOT NULL,
  `state` text NOT NULL,
  `city` text NOT NULL,
  `street` text NOT NULL,
  `lastupdated` int(11) NOT NULL,
  PRIMARY KEY (`email_id`),
  UNIQUE KEY `Phone` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

```

- ### For news_portal_temp

```

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 07, 2020 at 12:37 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `news_portal_backbone`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

DROP TABLE IF EXISTS `user_account`;
CREATE TABLE IF NOT EXISTS `user_account` (
  `email_id` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `mobile` varchar(20) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `mobile_verified` varchar(1) NOT NULL DEFAULT 'n',
  `name` text NOT NULL,
  `password` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `pin` varchar(20) NOT NULL,
  `country` text NOT NULL,
  `state` text NOT NULL,
  `city` text NOT NULL,
  `street` text NOT NULL,
  `status` varchar(1) NOT NULL,
  PRIMARY KEY (`email_id`),
  UNIQUE KEY `Phone` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;


```

## 3. Framework in use
1. Codeigniter 3
