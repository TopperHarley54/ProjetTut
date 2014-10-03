-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 03 Octobre 2014 à 20:25
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `projet2`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id_article` int(5) NOT NULL AUTO_INCREMENT,
  `code_barre` varchar(50) DEFAULT NULL,
  `nom_article` varchar(50) DEFAULT NULL,
  `prix` double(5,2) DEFAULT NULL,
  `prix_promo` double(5,2) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `taille_dispo` varchar(100) DEFAULT NULL,
  `couleur` varchar(50) DEFAULT NULL,
  `datedebut` date DEFAULT NULL,
  `datefin` date DEFAULT NULL,
  `id_magasin` int(5) DEFAULT NULL,
  `id_client` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_article`),
  KEY `id_client` (`id_client`),
  KEY `id_magasin` (`id_magasin`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Contenu de la table `article`
--

INSERT INTO `article` (`id_article`, `code_barre`, `nom_article`, `prix`, `prix_promo`, `description`, `photo`, `taille_dispo`, `couleur`, `datedebut`, `datefin`, `id_magasin`, `id_client`) VALUES
(33, 'non', 'le jean', 20.00, 15.00, 'le jean a la mode', 'image/1.jpg', '42', 'jaune', NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int(5) NOT NULL AUTO_INCREMENT,
  `login_client` varchar(50) DEFAULT NULL,
  `mdp_client` varchar(32) DEFAULT NULL,
  `nom_client` varchar(50) DEFAULT NULL,
  `prenom_client` varchar(50) DEFAULT NULL,
  `mail_client` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`id_client`, `login_client`, `mdp_client`, `nom_client`, `prenom_client`, `mail_client`) VALUES
(1, 'test', '1234', 'st', 'te', 'te.st@chaussure.com');

-- --------------------------------------------------------

--
-- Structure de la table `commercant`
--

CREATE TABLE IF NOT EXISTS `commercant` (
  `id_commercant` int(5) NOT NULL AUTO_INCREMENT,
  `login_commercant` varchar(100) DEFAULT NULL,
  `mdp_commercant` varchar(32) DEFAULT NULL,
  `nom_commercant` varchar(100) DEFAULT NULL,
  `prenom_commercant` varchar(100) DEFAULT NULL,
  `mail_commercant` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_commercant`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `commercant`
--

INSERT INTO `commercant` (`id_commercant`, `login_commercant`, `mdp_commercant`, `nom_commercant`, `prenom_commercant`, `mail_commercant`) VALUES
(1, 'Billyjeans', '1234', 'Jeans', 'Billy', 'Billy.jeans@chaussure.fr'),
(2, 'patron', '1234', 'ron', 'pat', 'pat.ron@pat.com');

-- --------------------------------------------------------

--
-- Structure de la table `compteur`
--

CREATE TABLE IF NOT EXISTS `compteur` (
  `nbimage` int(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nbimage`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `compteur`
--

INSERT INTO `compteur` (`nbimage`) VALUES
(1);

-- --------------------------------------------------------

--
-- Structure de la table `magasin`
--

CREATE TABLE IF NOT EXISTS `magasin` (
  `id_magasin` int(5) NOT NULL AUTO_INCREMENT,
  `nom_magasin` varchar(100) DEFAULT NULL,
  `numero` int(5) DEFAULT NULL,
  `rue` varchar(100) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `codepostal` varchar(5) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `tel_magasin` int(10) DEFAULT NULL,
  `id_commercant` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_magasin`),
  KEY `id_commercant` (`id_commercant`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `magasin`
--

INSERT INTO `magasin` (`id_magasin`, `nom_magasin`, `numero`, `rue`, `ville`, `codepostal`, `description`, `tel_magasin`, `id_commercant`) VALUES
(1, 'jeans en folie', 10, 'rue de la poire', 'nancy', '54100', 'le magasin', 303030303, 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_3` FOREIGN KEY (`id_magasin`) REFERENCES `magasin` (`id_magasin`),
  ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Contraintes pour la table `magasin`
--
ALTER TABLE `magasin`
  ADD CONSTRAINT `magasin_ibfk_1` FOREIGN KEY (`id_commercant`) REFERENCES `commercant` (`id_commercant`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
