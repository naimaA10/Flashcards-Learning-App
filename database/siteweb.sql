-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  sam. 09 mai 2020 à 17:39
-- Version du serveur :  5.7.17
-- Version de PHP :  7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `siteweb`
--
CREATE DATABASE IF NOT EXISTS `siteweb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `siteweb`;

-- --------------------------------------------------------

--
-- Structure de la table `cartes`
--

DROP TABLE IF EXISTS `cartes`;
CREATE TABLE `cartes` (
  `idCarte` int(11) NOT NULL,
  `idTas` int(11) NOT NULL,
  `question` text NOT NULL,
  `reponse` text NOT NULL,
  `niveau` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `cartes`
--

INSERT INTO `cartes` (`idCarte`, `idTas`, `question`, `reponse`, `niveau`) VALUES
(1, 1, 'Quelle est la capital de l\'Australie?', 'Canberra', 3),
(2, 1, 'Quelle est la capitale de la France?', 'Paris', 1),
(3, 1, 'Quelle est la capitale de la Turquie?', 'Ankara', 2),
(4, 1, 'Quelle est la capitale du Cambodge?', 'Phnom Penh', 4),
(5, 2, 'Quel pays est le plus peupl&eacute; d\'Afrique?', 'Nigeria', 2),
(6, 3, 'Quand a lieu la premi&egrave;re guerre mondiale?', '1939-1945', 1),
(7, 3, 'Quand a lieu la guerre du Vietnam ?', '1 novembre 1955 &ndash; 30 avril 1975', 2),
(8, 4, 'Qui a peint la  Joconde?', 'L&eacute;onard de Vinci', 1),
(9, 4, 'Que repr&eacute;sente l\'oeuvre Guernica?', 'Le bombardement de la ville Guernica', 2);

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

DROP TABLE IF EXISTS `historique`;
CREATE TABLE `historique` (
  `idHist` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idTas` int(11) NOT NULL,
  `date_cliquee` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `historique`
--

INSERT INTO `historique` (`idHist`, `idUser`, `idTas`, `date_cliquee`) VALUES
(1, 2, 1, '2020-05-09 17:13:30'),
(2, 3, 3, '2020-05-09 17:26:58'),
(3, 1, 4, '2020-05-09 17:32:09'),
(4, 1, 3, '2020-05-09 17:35:52');

-- --------------------------------------------------------

--
-- Structure de la table `recuperation`
--

DROP TABLE IF EXISTS `recuperation`;
CREATE TABLE `recuperation` (
  `idRecup` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `tas`
--

DROP TABLE IF EXISTS `deck`;
CREATE TABLE `deck` (
  `idTas` int(11) NOT NULL,
  `idUnite` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `createur` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tas`
--

INSERT INTO `deck` (`idTas`, `idUnite`, `titre`, `createur`) VALUES
(1, 1, 'Capitale', 'Joueur1'),
(2, 1, 'Pays', 'Joueur2'),
(3, 2, 'Guerre', 'Joueur2'),
(4, 3, 'Tableau', 'Joueur2');

-- --------------------------------------------------------

--
-- Structure de la table `unite`
--

DROP TABLE IF EXISTS `unites`;
CREATE TABLE `unites` (
  `idUnite` int(11) NOT NULL,
  `nom` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `unite`
--

INSERT INTO `unites` (`idUnite`, `nom`) VALUES
(1, 'G&eacute;ographie'),
(2, 'Histoire'),
(3, 'Arts');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `password`, `photo`) VALUES
(1, 'Administrateur', 'admin@gmail.com', 'ab4f63f9ac65152575886860dde480a1', 'default.png'),
(2, 'Joueur1', 'joueur1@gmail.com', 'ab4f63f9ac65152575886860dde480a1', 'default.png'),
(3, 'Joueur2', 'joueur2@gmail.com', 'ab4f63f9ac65152575886860dde480a1', 'default.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cartes`
--
ALTER TABLE `cartes`
  ADD PRIMARY KEY (`idCarte`);

--
-- Index pour la table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`idHist`);

--
-- Index pour la table `recuperation`
--
ALTER TABLE `recuperation`
  ADD PRIMARY KEY (`idRecup`);

--
-- Index pour la table `tas`
--
ALTER TABLE `deck`
  ADD PRIMARY KEY (`idTas`);

--
-- Index pour la table `unite`
--
ALTER TABLE `unites`
  ADD PRIMARY KEY (`idUnite`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cartes`
--
ALTER TABLE `cartes`
  MODIFY `idCarte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `historique`
--
ALTER TABLE `historique`
  MODIFY `idHist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `recuperation`
--
ALTER TABLE `recuperation`
  MODIFY `idRecup` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `deck`
--
ALTER TABLE `deck`
  MODIFY `idTas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `unite`
--
ALTER TABLE `unites`
  MODIFY `idUnite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
