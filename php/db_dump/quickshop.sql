-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 27, 2014 at 05:28 PM
-- Server version: 5.5.34-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quickshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `Amazon`
--

CREATE TABLE IF NOT EXISTS `Amazon` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Comment` text NOT NULL,
  `score` float NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Amazon`
--

INSERT INTO `Amazon` (`Id`, `Comment`, `score`) VALUES
(1, 'Very poor service!', -0.571105),
(3, 'I completely hate it!', -0.527261),
(4, 'Bad!', -0.599951),
(5, 'Worst ever...', -0.574229);

-- --------------------------------------------------------

--
-- Table structure for table `Flipkart`
--

CREATE TABLE IF NOT EXISTS `Flipkart` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Comment` text NOT NULL,
  `score` float NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `Flipkart`
--

INSERT INTO `Flipkart` (`Id`, `Comment`, `score`) VALUES
(5, 'Great!', 0.166457),
(16, 'awesome!', 0.212825),
(19, 'I love it!', 0.140475);

-- --------------------------------------------------------

--
-- Table structure for table `Snapdeal`
--

CREATE TABLE IF NOT EXISTS `Snapdeal` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Comment` text NOT NULL,
  `score` float NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Snapdeal`
--

INSERT INTO `Snapdeal` (`Id`, `Comment`, `score`) VALUES
(1, 'Late Service!', 0),
(2, 'Average quality.', 0.054832);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
