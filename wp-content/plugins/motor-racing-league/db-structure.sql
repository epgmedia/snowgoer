-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 16, 2009 at 07:34 AM
-- Server version: 5.0.67
-- PHP Version: 5.2.6-2ubuntu4.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wordpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_motorracingleague_championship`
--

CREATE TABLE IF NOT EXISTS `wp_motorracingleague_championship` (
  `id` int(11) NOT NULL auto_increment,
  `season` varchar(32) NOT NULL,
  `description` varchar(256) NOT NULL,
  `num_predictions` int(11) NOT NULL,
  `calculator` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `season` (`season`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_motorracingleague_entry`
--

CREATE TABLE IF NOT EXISTS `wp_motorracingleague_entry` (
  `id` int(11) NOT NULL auto_increment,
  `player_name` varchar(64) NOT NULL,
  `email` varchar(256) NOT NULL,
  `race_id` int(11) NOT NULL,
  `when` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `points` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `player` (`player_name`,`race_id`),
  KEY `race_fk` (`race_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=474 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_motorracingleague_participant`
--

CREATE TABLE IF NOT EXISTS `wp_motorracingleague_participant` (
  `id` int(11) NOT NULL auto_increment,
  `shortcode` varchar(8) NOT NULL,
  `name` varchar(64) NOT NULL,
  `championship_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unq_shortcode` (`shortcode`,`championship_id`),
  UNIQUE KEY `unq_name` (`name`,`championship_id`),
  KEY `championship_fk2` (`championship_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_motorracingleague_prediction`
--

CREATE TABLE IF NOT EXISTS `wp_motorracingleague_prediction` (
  `id` int(11) NOT NULL auto_increment,
  `entry_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `entry_id` (`entry_id`,`participant_id`,`position`),
  KEY `entry_id_2` (`entry_id`),
  KEY `participant_id` (`participant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=129 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_motorracingleague_race`
--

CREATE TABLE IF NOT EXISTS `wp_motorracingleague_race` (
  `id` int(11) NOT NULL auto_increment,
  `circuit` varchar(64) NOT NULL,
  `championship_id` int(11) NOT NULL,
  `race_start` datetime NOT NULL,
  `entry_by` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `circuit` (`circuit`,`championship_id`,`race_start`),
  KEY `championship_fk` (`championship_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1013 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_motorracingleague_result`
--

CREATE TABLE IF NOT EXISTS `wp_motorracingleague_result` (
  `id` int(11) NOT NULL auto_increment,
  `race_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `race_id` (`race_id`,`participant_id`,`position`),
  KEY `participant` (`participant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wp_motorracingleague_entry`
--
ALTER TABLE `wp_motorracingleague_entry`
  ADD CONSTRAINT `wp_motorracingleague_entry_ibfk_5` FOREIGN KEY (`race_id`) REFERENCES `wp_motorracingleague_race` (`id`);

--
-- Constraints for table `wp_motorracingleague_participant`
--
ALTER TABLE `wp_motorracingleague_participant`
  ADD CONSTRAINT `wp_motorracingleague_participant_ibfk_1` FOREIGN KEY (`championship_id`) REFERENCES `wp_motorracingleague_championship` (`id`);

--
-- Constraints for table `wp_motorracingleague_prediction`
--
ALTER TABLE `wp_motorracingleague_prediction`
  ADD CONSTRAINT `wp_motorracingleague_prediction_ibfk_2` FOREIGN KEY (`participant_id`) REFERENCES `wp_motorracingleague_participant` (`id`),
  ADD CONSTRAINT `wp_motorracingleague_prediction_ibfk_1` FOREIGN KEY (`entry_id`) REFERENCES `wp_motorracingleague_entry` (`id`);

--
-- Constraints for table `wp_motorracingleague_race`
--
ALTER TABLE `wp_motorracingleague_race`
  ADD CONSTRAINT `wp_motorracingleague_race_ibfk_1` FOREIGN KEY (`championship_id`) REFERENCES `wp_motorracingleague_championship` (`id`);

--
-- Constraints for table `wp_motorracingleague_result`
--
ALTER TABLE `wp_motorracingleague_result`
  ADD CONSTRAINT `wp_motorracingleague_result_ibfk_1` FOREIGN KEY (`race_id`) REFERENCES `wp_motorracingleague_race` (`id`),
  ADD CONSTRAINT `wp_motorracingleague_result_ibfk_2` FOREIGN KEY (`participant_id`) REFERENCES `wp_motorracingleague_participant` (`id`);
