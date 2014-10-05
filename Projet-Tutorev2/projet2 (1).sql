-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 02 Octobre 2014 à 14:06
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
  PRIMARY KEY (`id_article`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `article`
--

INSERT INTO `article` (`id_article`, `code_barre`, `nom_article`, `prix`, `prix_promo`, `description`, `photo`, `taille_dispo`, `couleur`, `datedebut`, `datefin`) VALUES
(1, NULL, 'test', 20.00, 25.00, 'LE jean a la mode', 'image/1', 'L XL', 'Jaune', '2014-05-12', '2014-12-24');

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
(1, 'test', '1234', 'te', 'st', 'te.st@couillon.com');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `liste`
--

CREATE TABLE IF NOT EXISTS `liste` (
  `id_client` int(5) NOT NULL DEFAULT '0',
  `id_article` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_client`,`id_article`),
  KEY `id_article` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `liste`
--

INSERT INTO `liste` (`id_client`, `id_article`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `magasin`
--

CREATE TABLE IF NOT EXISTS `magasin` (
  `id_magasin` int(5) NOT NULL AUTO_INCREMENT,
  `nom_magasin` varchar(100) DEFAULT NULL,
  `numero` int(5) DEFAULT NULL,
  `rue` int(100) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `codepostal` int(5) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `tel_magasin` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_magasin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `liste`
--
ALTER TABLE `liste`
  ADD CONSTRAINT `liste_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `liste_ibfk_2` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
