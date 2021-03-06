-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 08 fév. 2022 à 16:38
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
-- Base de données : `appliprojetinterfiliere`
--
CREATE DATABASE IF NOT EXISTS `appliprojetinterfiliere` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `appliprojetinterfiliere`;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int(3) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `second_name` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `office` varchar(25) DEFAULT NULL COMMENT 'office of a user',
  `is_admin` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'boolean: is the user an adminstrator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `first_name`, `second_name`, `email`, `password`, `office`, `is_admin`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '$2y$10$XzjZPndFZZpHJP251jxPJuk9x5IgNaGfvhtXfUmeB0Q39Ba/cELz2', '112', 1),
(2, 'admin2', 'admin2', 'admin2@gmail.com', '$2y$10$AcMYIVGBzpfBA2rM.RnMbuYCaNyFyjaF.BMZTDSgDGYw45woK/yQq', '113', 1),
(3, 'admin3', 'admin3', 'admin3@gmail.com', '$2y$10$.DqiliyADPFsz//w4k1kyems4/rDwYv/WmLrBe2btaV7gT2nxs1BC', '118', 1),
(4, 'John', 'Doe', 'John.Doe@yahoo.fr', '$2y$10$lTAMdZMwE6gouu46V8E7Gexi72jOMqbifVW1tngIaqCVxBNO1qtSa', '212', 0),
(5, 'Theo', 'Iniest', 'Theo.Iniest@gmail.com', '$2y$10$ackuCSivfTmGqftS2fB7juuGZxTGfoYCGA2p9.6zv8Qdr0zw.ThFm', '218', 0),
(6, 'Claude', 'Amel', 'Claude.Amel@gmail.com', '$2y$10$q5A8izXkD7NWw5.3d3f/Eeu212Ex8OvlTOPITNyWG.Lc1VQD8qmba', '220', 0),
(7, 'Irène', 'Joliot', 'Irene.Joliot@yahoo.fr', '$2y$10$d3BWI2Ih.BqYyqfHMVUe7u7MEj6re.tpmyUE1y3DrqdH.CDqRNvcS', '221', 0);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;