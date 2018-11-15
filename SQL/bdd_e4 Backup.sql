-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 25 oct. 2018 à 14:12
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bdd_e4`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `ID` int(255) NOT NULL AUTO_INCREMENT COMMENT 'id article',
  `titre` varchar(80) COLLATE utf8_bin NOT NULL COMMENT 'Titre des articles',
  `contenu` varchar(6000) COLLATE utf8_bin NOT NULL COMMENT 'Contenu des articles',
  `lien` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Liens des différentes images',
  `pseudo` varchar(50) COLLATE utf8_bin NOT NULL COMMENT 'Pseudo des utilisateurs',
  `current_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Le temps',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table des articles';

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`ID`, `titre`, `contenu`, `lien`, `pseudo`, `current_datetime`) VALUES
(11, 'Sans, the funny skeleton', 'Megalovania overwhelming sound intensifies', 'https://vignette.wikia.nocookie.net/undertale/images/4/44/Sansanimated.gif/revision/latest/scale-to-width-down/118?cb=20160223004602', 'Nerodin', '2018-09-04 13:22:18'),
(12, 'Papyrus', 'Nyhehehe', 'https://vignette.wikia.nocookie.net/undertale/images/2/21/Papyrus1.PNG/revision/latest/scale-to-width-down/148?cb=20170116153320', 'Nerodin', '2018-09-04 13:26:12'),
(13, 'Toriel', 'dat beautiful mama', 'https://vignette.wikia.nocookie.net/undertale/images/0/01/Toriel.png/revision/latest?cb=20151013235609', 'Nerodin', '2018-09-04 13:52:53'),
(16, 'Asriel Dreemurr', 'Asriel Dreemurr, you\'r fill with determination and ready to fight him.\r\nBe careful my child, time has come to defeat him.', 'https://vignette.wikia.nocookie.net/undertale/images/0/04/Asrielfinalform.gif/revision/latest/scale-to-width-down/350?cb=20151125200260', 'Nerodin', '2018-09-20 14:49:02'),
(17, 'Muffet Onee-chama', 'Let\'s dance with some sweet spidey <3', 'https://vignette.wikia.nocookie.net/undertale/images/f/fd/Muffet.gif/revision/latest?cb=20151209030641', 'Nerodin', '2018-10-04 14:18:01'),
(18, 'Undertale Wallpaper', 'Trying something with a wallpaper', 'http://getwallpapers.com/wallpaper/full/9/b/1/6280.jpg', 'Nerodin', '2018-10-04 14:27:51'),
(19, 'A dark castle in a lone island', 'Let\'s take a moment to appreciate the castle while we can...', 'http://images6.fanpop.com/image/photos/39500000/Undertale-Wallpaper-undertale-39583196-1920-1080.png', 'Nerodin', '2018-10-04 14:39:37'),
(20, 'Doggo', 'The <i>Doggo</i> is trying italic Html in article.\r\nNow he\'s <b>bold</>\r\n<u>But he can set a line too ....</u>', 'http://images6.fanpop.com/image/photos/40700000/The-Annoying-Dog-adsorbed-the-Wallpaper-undertale-40729327-500-281.png', 'Nerodin', '2018-10-04 14:43:56'),
(21, 'A story about a goat', 'Toriel trying to fight Frisk.<br>\r\nFrisk is filled with determination<br><br>\r\n<b>Frisk is now able to dodge everything !</b><br><br>\r\n<i><b><u>Let\'s be honest, you though u had a chance to win ? </u></b></i>', 'http://7wallpapers.net/wp-content/uploads/20_Undertale.jpg', 'Nerodin', '2018-10-04 14:46:54'),
(22, 'Filled with every soul', 'Check the current time to know if the css is done...', 'https://i.ytimg.com/vi/6Aoj3HWFU-g/maxresdefault.jpg', 'Nerodin', '2018-10-04 14:52:48'),
(23, 'Undertale', '<h2><b>Undertale</b></h2><br /><br />\r\n\r\n<u>Undertale</u> (stylized as UNDERTALE and formerly UnderTale) is a role-playing game developed independently by Toby Fox with additional art by Temmie Chang in the Game Maker: Studio engine. It was released for Microsoft Windows and Mac OS X on September 15, 2015, for Linux on July 17, 2016, for PlayStation 4 and PlayStation Vita on August 15, 2017, and for Nintendo Switch on September 2018. The game has been met with overwhelmingly positive reviews.<br/><br/>\r\n\r\nThere\'s also a special collector\'s edition sold exclusively on Fangamer, which includes the game\'s soundtrack and a music box locket, among other things. <br /><br />\r\n\r\n<h5>Wooooo Master piece</h5>', 'https://vignette.wikia.nocookie.net/central/images/8/86/Misc-Undertale_Kickstarter.png/revision/latest?cb=20180211235707', 'Nerodin', '2018-10-23 13:51:57'),
(25, '', '', '', 'Nerodin', '2018-10-25 10:58:15');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `ID` int(255) NOT NULL AUTO_INCREMENT COMMENT 'ID du commentaire',
  `contenu` varchar(6000) COLLATE utf8_bin NOT NULL COMMENT 'Contenu commentaire',
  `pseudo` varchar(50) COLLATE utf8_bin NOT NULL COMMENT 'Pseudo des utilisateurs',
  `current_datetime_comment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date du commentaire',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table des commentaire';

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`ID`, `contenu`, `pseudo`, `current_datetime_comment`) VALUES
(8, 'Toriel est vraiment gentille !', 'Nerodin', '2018-09-04 15:05:02'),
(9, 'Papyrus est rusé !', 'Nerodin', '2018-09-04 15:05:13'),
(10, 'Amagad Asriel is too good ma friend', 'Nerodin', '2018-10-04 11:03:37'),
(11, 'Test', 'Nerodin', '2018-10-25 13:49:22');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `ID` int(50) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `motdepasse` varchar(100) NOT NULL,
  `role` varchar(10) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ID`, `email`, `pseudo`, `motdepasse`, `role`) VALUES
(1, 'marvin.salmas@gmail.com', 'Frozen', '123', 'admin'),
(29, '', '', 'd41d8cd98f00b204e9800998ecf8427e', ''),
(30, 'jesuisunemail@gmail.com', 'monpseudo', 'monmotdepasse', 'user'),
(31, 'bruno.retraite@gmail.com', 'Brubru', '1234', 'user'),
(28, 'jesuisbob@gmail.com', 'Bob le rigolo', 'boblerigolo', 'user'),
(27, 'bobo@gmail.com', 'bobo', 'bobo01', 'user'),
(25, 'bob@gmail.com', 'Bob', 'bob123', 'user'),
(26, 'antoinegualbert@gmail.com', 'Nerodin', 'jesuisunmdp', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
