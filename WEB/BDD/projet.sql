-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 20 jan. 2022 à 14:54
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet`
--
CREATE DATABASE IF NOT EXISTS `appliprojetinterfiliere` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `appliprojetinterfiliere`;

-- --------------------------------------------------------

--
-- Structure de la table `office`
--

DROP TABLE IF EXISTS `office`;
CREATE TABLE `office` (
  `id_office` int(11) NOT NULL,
  `label` varchar(10) DEFAULT NULL,
  `id_utilisateur` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `office`
--

INSERT INTO `office` (`id_office`, `label`, `id_utilisateur`) VALUES
(1, '312', 8);

-- --------------------------------------------------------

--
-- Structure de la table `qrcode`
--

DROP TABLE IF EXISTS `qrcode`;
CREATE TABLE `qrcode` (
  `id_qrcode` int(11) NOT NULL,
  `path` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `qrcode`
--

INSERT INTO `qrcode` (`id_qrcode`, `path`) VALUES
(1, '/tmp/image.png');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int(3) NOT NULL,
  `first_name` varchar(15) NOT NULL,
  `second_name` varchar(15) NOT NULL,
  `password` varchar(30) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `first_name`, `second_name`, `password`, `is_admin`) VALUES
(1, 'admin', 'admin', 'admin', 1),
(8, 'John', 'Doe', 'motdepasse', 0),
(10, 'exemple', 'example', 'ouioui', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `office`
--
ALTER TABLE `office`
  ADD PRIMARY KEY (`id_office`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `qrcode`
--
ALTER TABLE `qrcode`
  ADD PRIMARY KEY (`id_qrcode`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `office`
--
ALTER TABLE `office`
  MODIFY `id_office` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `qrcode`
--
ALTER TABLE `qrcode`
  MODIFY `id_qrcode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `office`
--
ALTER TABLE `office`
  ADD CONSTRAINT `office_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
