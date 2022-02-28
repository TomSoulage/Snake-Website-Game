-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 08, 2019 at 08:27 PM
-- Server version: 5.5.60
-- PHP Version: 5.4.45-0+deb7u14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `2018_p0_cpi02_soulagetom`
--

-- --------------------------------------------------------

--
-- Table structure for table `ban`
--

CREATE TABLE IF NOT EXISTS `ban` (
  `adressemail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ban`
--

INSERT INTO `ban` (`adressemail`) VALUES
('zaza@gmail.com\r\n'),
('nop@gmail.com\r\n'),
('hey@gmail.com'),
('gourou@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `idMessage` int(11) NOT NULL AUTO_INCREMENT,
  `idMembre` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`idMessage`),
  KEY `idMembre_2` (`idMembre`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=311 ;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`idMessage`, `idMembre`, `message`, `date`) VALUES
(297, 92, 'bonjour ', '2019-06-08 19:19:49'),
(298, 92, 'il y a des cobras experimentés pour me donner des conseils ?', '2019-06-08 19:20:29'),
(299, 88, 'oui', '2019-06-08 19:22:34'),
(300, 88, 'mange bien les diamants ', '2019-06-08 19:22:47'),
(301, 88, 'cela donne 3 points!!!', '2019-06-08 19:23:02'),
(302, 103, 'Attention aux bombes, bande de nuls!!', '2019-06-08 19:28:36'),
(303, 88, 'oh dany je te signal au admin ', '2019-06-08 19:29:24'),
(304, 92, 'je le signale et merci du conseil', '2019-06-08 19:30:08'),
(305, 92, 'je vais avoir le record bientot prepare toi skillsimba  ', '2019-06-08 19:30:36'),
(306, 88, 'Bonne chance alors ', '2019-06-08 19:31:01'),
(308, 95, 'hey', '2019-06-08 19:48:59'),
(309, 91, 'Ce jeu est super!', '2019-06-08 19:49:21'),
(310, 91, 'J''espÃ¨re battre mon record....', '2019-06-08 20:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `signalement`
--

CREATE TABLE IF NOT EXISTS `signalement` (
  `idSignalement` int(11) NOT NULL AUTO_INCREMENT,
  `idMessage` int(11) NOT NULL,
  `idJoueurAyantSignale` int(11) NOT NULL,
  `idJoueurSignale` int(11) NOT NULL,
  PRIMARY KEY (`idSignalement`),
  KEY `idMessage` (`idMessage`),
  KEY `idJoueurAyantSignale` (`idJoueurAyantSignale`),
  KEY `idJoueurSignale` (`idJoueurSignale`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

--
-- Dumping data for table `signalement`
--

INSERT INTO `signalement` (`idSignalement`, `idMessage`, `idJoueurAyantSignale`, `idJoueurSignale`) VALUES
(88, 302, 104, 103);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(30) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `email` varchar(30) DEFAULT '',
  `mdp` varchar(255) DEFAULT '',
  `sexe` varchar(20) DEFAULT '',
  `score` int(11) DEFAULT '0',
  `niveau` int(11) NOT NULL DEFAULT '1',
  `pieces` int(11) NOT NULL DEFAULT '0',
  `statut` varchar(6) NOT NULL,
  `nbsignalement` int(11) NOT NULL,
  `map` varchar(255) NOT NULL DEFAULT 'background.jpeg',
  `couleur` varchar(7) NOT NULL DEFAULT '#805500',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=112 ;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `pseudo`, `nom`, `prenom`, `email`, `mdp`, `sexe`, `score`, `niveau`, `pieces`, `statut`, `nbsignalement`, `map`, `couleur`) VALUES
(88, 'skillsimba', 'Peytavy', 'Kilian', 'peytavykil@eisti.eu', 'd94d2f17698659bdd6fe6fa914ffcc0e2cf47249', 'homme', 37, 3, 657, 'joueur', 3, 'fond/background2.jpg', '#805500'),
(89, 'jpp', 'Dingley', 'Jesse', 'jesse.dingley@gmail.com', 'b3c1a97b23a0f653d015b45777185993ca3d54c5', 'homme', 17, 1, 34, 'joueur', 0, 'background.jpeg', '#805500'),
(90, 'Thierry', 'Henry', 'Thierry', 'kingofsnake@gmail.com', '1c9059170910835368500990479a5cf828444d34', 'homme', 0, 0, 0, 'joueur', 0, 'background.jpeg', '#805500'),
(91, 'Jerome', 'Philippe ', 'Jerome', 'jerome@gmail.com', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', 'homme', 21, 2, 65, 'joueur', 7, 'fond/background.jpeg', '#805500'),
(92, 'Edriks', 'Edricks', 'Bution', 'lol@lol.lol', '22738395c6e813cbc959e7ea45c0cae3eba15533', 'homme', 11, 1, 36, 'joueur', 0, 'background.jpeg', '#805500'),
(95, 'Maxou', 'Adda', 'Maxime', 'maxime@jeu.fr', '1acc295174379ec718e1123290d06dcd8d68feb6', 'homme', 12, 1, 35, 'joueur', 0, 'background.jpeg', '#805500'),
(100, 'aze', 'aaa', 'aazaza', 'aaa@gmail.com', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', 'homme', 19, 1, 76, 'admin', 0, 'fond/background3.jpeg', '#805500'),
(101, 'Mathis', 'Gourc', 'Mathis', 'mathisgourc@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'homme', 27, 2, 105, 'joueur', 0, 'firstimage.jpg', '#3342ff'),
(103, 'DanyFantome', 'Atangana', 'Daniel', 'petitdany@tropfort.fr', 'c47f02b0ba64006f43904a2097a9c8d9d08463af', 'homme', 0, 0, 0, 'joueur', 1, 'background.jpeg', '#805500'),
(104, 'Tom', 'Soulage', 'Tom', 'soulagetom@eisti.eu', '96835dd8bfa718bd6447ccc87af89ae1675daeca', 'homme', 6, 0, 7, 'admin', 0, 'background.jpeg', '#805500');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `signalement`
--
ALTER TABLE `signalement`
  ADD CONSTRAINT `signalement_ibfk_1` FOREIGN KEY (`idMessage`) REFERENCES `chat` (`idMessage`) ON DELETE CASCADE,
  ADD CONSTRAINT `signalement_ibfk_2` FOREIGN KEY (`idJoueurAyantSignale`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `signalement_ibfk_3` FOREIGN KEY (`idJoueurSignale`) REFERENCES `chat` (`idMembre`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
