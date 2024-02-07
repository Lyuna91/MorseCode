-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 23 Décembre 2023 à 23:25
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `morsecode`
--

-- --------------------------------------------------------

--
-- Structure de la table `code_q`
--

CREATE TABLE IF NOT EXISTS `code_q` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original` varchar(5) NOT NULL,
  `morse` varchar(50) NOT NULL,
  `information` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `code_q`
--

INSERT INTO `code_q` (`id`, `original`, `morse`, `information`) VALUES
(1, 'SOS', '... --- ...', 'SOS is the Morse code interpretation of the distress and immediate assistance signal signed at the Berlin Convention on November 3, 1906.'),
(2, 'PRB', '.--. .-. -...', 'A code that means "Do you wish to communicate with my station using the International Signals Code" or "I wish to communicate with your station using the International Signals Code".'),
(3, 'QAB', '--.- .- -...', 'A code meaning "What is your destination?" or "My destination is...".'),
(4, 'QRO', '--.- .-. ---', 'A code that mean "Should I increase the transmitting power?" Or	"Increase the transmitting power.".');

-- --------------------------------------------------------

--
-- Structure de la table `letter`
--

CREATE TABLE IF NOT EXISTS `letter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original` varchar(10) NOT NULL,
  `morse` varchar(10) NOT NULL,
  `difficulty` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Contenu de la table `letter`
--

INSERT INTO `letter` (`id`, `original`, `morse`, `difficulty`) VALUES
(1, 'A', '.-', 2),
(2, 'B', '-...', 4),
(3, 'C', '-.-.', 4),
(4, 'D', '-..', 3),
(5, 'E', '.', 1),
(6, 'F', '..-.', 4),
(7, 'G', '--.', 3),
(8, 'H', '....', 4),
(9, 'I', '..', 2),
(10, 'J', '.---', 4),
(11, 'K', '-.-', 3),
(12, 'L', '.-..', 4),
(13, 'M', '--', 2),
(14, 'N', '-.', 2),
(15, 'O', '---', 3),
(16, 'P', '.--.', 4),
(17, 'Q', '--.-', 4),
(18, 'R', '.-.', 3),
(19, 'S', '...', 3),
(20, 'T', '-', 1),
(21, 'U', '..-', 3),
(22, 'V', '...-', 4),
(23, 'W', '.--', 3),
(24, 'X', '-..-', 4),
(25, 'Y', '-.--', 4),
(26, 'Z', '--..', 4),
(27, '1', '.----', 5),
(28, '2', '..---', 5),
(29, '3', '...--', 5),
(30, '4', '....-', 5),
(31, '5', '.....', 5),
(32, '6', '-....', 5),
(33, '7', '--...', 5),
(34, '8', '---..', 5),
(35, '9', '----.', 5),
(36, '0', '-----', 5);

-- --------------------------------------------------------

--
-- Structure de la table `sentence`
--

CREATE TABLE IF NOT EXISTS `sentence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original` text NOT NULL,
  `morse` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `sentence`
--

INSERT INTO `sentence` (`id`, `original`, `morse`) VALUES
(1, 'VOUS AVEZ CREER QUELQUE CHOSE DE MAUVAIS', '...- --- ..- ...  .- -... . --..  -.-. .-. . . .-.  --.- ..- . .-.. --.- ..- .  -.-. .... --- ... .  -.. .  -- .- ..- ...- .- .. ...'),
(2, 'VERT FORET', '...- . .-. -   ..-. --- .-. . -'),
(3, 'GET UP', '--. . - ..- .--.'),
(4, 'MY EGO IN THIS SHOW', '-- -.--   . --. ---   .. -.   - ... .. ...   ... .... --- .--');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` int(11) NOT NULL,
  `experience` int(11) NOT NULL,
  `objective` int(11) NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id_user`, `username`, `email`, `password`, `level`, `experience`, `objective`, `admin`) VALUES
(4, 'admin', 'admin@lacatholille.fr', 'CRlYh4nbPiZNU', 3, 540, 1300, 1),
(7, 'carlos', 'carlos.okinda@lacatholille.fr', 'CRyVSSACmdRhU', 3, 660, 1700, 0),
(9, 'bruh', 'paola.laurency@gmail.com', 'CReJeU.qE/Xbo', 3, 1280, 1700, 0);

-- --------------------------------------------------------

--
-- Structure de la table `word`
--

CREATE TABLE IF NOT EXISTS `word` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original` varchar(50) NOT NULL,
  `morse` varchar(50) NOT NULL,
  `difficulty` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `word`
--

INSERT INTO `word` (`id`, `original`, `morse`, `difficulty`) VALUES
(1, 'CARLOS', '-.-. .- .-. .-.. --- ...', 6),
(2, 'EMMA', '. -- -- .-', 4),
(3, 'RHADE', '.-. .... .- -.. .', 5),
(5, 'VERT', '...- . .-. -', 4),
(6, 'ROUGE', '.-. --- ..- --. .', 5),
(7, 'HELLO', '.... . .-.. .-.. ---', 5),
(8, 'WORLD', '.-- --- .-. .-.. -..', 5),
(11, 'JAUNE', '.--- .- ..- -. .', 5),
(12, 'ORANGE', '--- .-. .- -. --. .', 6),
(13, 'FBTG', '..-. -... - --.', 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
