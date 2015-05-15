-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 15, 2015 at 05:45 PM
-- Server version: 5.5.34-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nova_vbackup`
--

-- --------------------------------------------------------

--
-- Table structure for table `FoodDetail`
--

CREATE TABLE IF NOT EXISTS `FoodDetail` (
  `foodId` int(11) NOT NULL AUTO_INCREMENT,
  `foodTitle` varchar(300) NOT NULL,
  `foodIngredient` text NOT NULL,
  PRIMARY KEY (`foodId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `FoodDetail`
--

INSERT INTO `FoodDetail` (`foodId`, `foodTitle`, `foodIngredient`) VALUES
(1, 'test', '5,6'),
(3, 'fest', '4,7');

-- --------------------------------------------------------

--
-- Table structure for table `Ingredients`
--

CREATE TABLE IF NOT EXISTS `Ingredients` (
  `ingredientId` int(11) NOT NULL AUTO_INCREMENT,
  `ingredientName` varchar(200) NOT NULL,
  PRIMARY KEY (`ingredientId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `Ingredients`
--

INSERT INTO `Ingredients` (`ingredientId`, `ingredientName`) VALUES
(4, 'testing'),
(5, 'test'),
(6, 'test123'),
(7, 'test234'),
(11, 'sdfsdfsfasdfasdfasdfasdfasdf'),
(12, 'ererewrwer'),
(13, 'erwerwerwerwer');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
