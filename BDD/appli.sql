-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 18 nov. 2021 à 13:34
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `appliprojetinterfiliere`
--
CREATE DATABASE IF NOT EXISTS `appliprojetinterfiliere` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `appliprojetinterfiliere`;

-- --------------------------------------------------------

--
-- Structure de la table `bureau`
--

CREATE TABLE IF NOT EXISTS `bureau` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `bureau`
--

INSERT INTO `bureau` (`Id`, `label`) VALUES
(1, '312');

-- --------------------------------------------------------

--
-- Structure de la table `qrcode`
--

CREATE TABLE IF NOT EXISTS `qrcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valeur` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `qrcode`
--

INSERT INTO `qrcode` (`id`, `valeur`) VALUES
(1, 'valeur1');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `Id` int(3) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(15) NOT NULL,
  `second_name` varchar(15) NOT NULL,
  `password` varchar(30) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`Id`, `first_name`, `second_name`, `password`, `is_admin`) VALUES
(1, 'admin', 'admin', 'admin', 1),
(8, 'John', 'Doe', 'motdepasse', 0),
(10, 'exemple', 'example', 'ouioui', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
