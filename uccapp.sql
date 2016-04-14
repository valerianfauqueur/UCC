-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 14 Avril 2016 à 18:51
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `uccapp`
--

-- --------------------------------------------------------

--
-- Structure de la table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `screen_name` varchar(100) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `oauth_token` varchar(100) NOT NULL,
  `oauth_secret` varchar(100) NOT NULL,
  `access_level` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `accounts`
--

INSERT INTO `accounts` (`ID`, `name`, `screen_name`, `picture`, `oauth_token`, `oauth_secret`, `access_level`) VALUES
(1, 'Tsukunay', 'Tsukunay', 'http://pbs.twimg.com/profile_images/378800000182573702/73e0c83ffeff4eeda36939bbae083832_normal.png', '1613016751-4lvFAS2y3iVxDD9T0NzVAshDvCV0hBmFRiQNYNV', 'UTaNiIl8IoTvr9hMQtlgfn7W4MWD6hSZLCMQpInbals3w', 1),
(2, 'THHHHHHH ldlldldl', 'Lyozza', 'http://abs.twimg.com/sticky/default_profile_images/default_profile_2_normal.png', '2373748855-2we2fNPH0zr4aMnIefiNSuvNt0n8r5JsisOLOHM', 'GVtM6dx6wr1iW18kKB3WmQf7dIX1BiY8Ci4uCmcuLMxxI', 0);

-- --------------------------------------------------------

--
-- Structure de la table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `hexa` varchar(8) NOT NULL,
  `content` varchar(140) NOT NULL,
  `answer_number` int(11) NOT NULL,
  `vote` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `answers`
--

INSERT INTO `answers` (`ID`, `hexa`, `content`, `answer_number`, `vote`) VALUES
(1, 'f8b6494', 'Disney', 1, 0),
(2, 'f8b6494', 'Robots', 2, 0),
(3, '7689244', 'Disney', 1, 0),
(4, '7689244', 'Robots', 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `hexa` varchar(8) NOT NULL,
  `content` varchar(140) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `questions`
--

INSERT INTO `questions` (`ID`, `hexa`, `content`) VALUES
(1, 'f8b6494', 'What will be the next championship theme ?'),
(2, '7689244', 'What will be the next championship theme ?');

-- --------------------------------------------------------

--
-- Structure de la table `survey`
--

CREATE TABLE IF NOT EXISTS `survey` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `hexa` varchar(8) NOT NULL,
  `name` varchar(140) NOT NULL,
  `total_vote` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `survey`
--

INSERT INTO `survey` (`ID`, `hexa`, `name`, `total_vote`) VALUES
(1, 'f8b6494', 'A test survey', 0),
(2, '7689244', 'A test survey', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
