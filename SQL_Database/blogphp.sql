-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 01 mars 2024 à 09:50
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blogphp`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Art'),
(2, 'Politique'),
(3, 'Faits divers'),
(4, 'Informatique'),
(5, 'Sciences'),
(6, 'Nature'),
(7, 'Littérature'),
(8, 'Cinéma');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `content` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comment_User_FK` (`user_id`),
  KEY `comment_Post0_FK` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `created_at`, `updated_at`, `content`, `user_id`, `post_id`) VALUES
(1, "2024-02-01", "2024-02-02", "testContent", 1, 1),
(2, "2024-02-01", "2024-02-02", "Super article, j'ai adoré !", 3, 8),
(3, "2024-02-01", "2024-02-02", "Vivement la suite !", 6, 4),
(4, "2024-02-01", "2024-02-02", "Merci pour le partage !", 2, 7),
(5, "2024-02-01", "2024-02-02", "Très intéressant, je recommande !", 5, 3),
(6, "2024-02-01", "2024-02-02", "Bravo pour cet article !", 4, 6),
(7, "2024-02-01", "2024-02-02", "Je ne suis pas d'accord avec certaines idées.", 8, 2),
(8, "2024-02-01", "2024-02-02", "C'est e'actement ce que je cherchais.", 1, 1),
(9, "2024-02-01", "2024-02-02", "Je vais partager ça avec mes amis !", 7, 5),
(10, "2024-02-01", "2024-02-02", "Je suis impressionné par la qualité de l'écriture.", 3, 8),
(11, "2024-02-01", "2024-02-02", "Cette information est très utile, merci !", 6, 4),
(12, "2024-02-01", "2024-02-02", "J'attends avec impatience la suite.", 2, 7),
(13, "2024-02-01", "2024-02-02", "Je recommande cet article à tout le monde !", 5, 3);

-- --------------------------------------------------------

--
-- Structure de la table `contactForm`
--

DROP TABLE IF EXISTS `contactForm`;
CREATE TABLE IF NOT EXISTS `contactForm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `send_at` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contactForm`
--

INSERT INTO `contactForm` (`id`, `email`, `firstname`, `lastname`, `message`, `send_at`) VALUES
(1, 'testContact@testcontact.fr', 'aurelien', 'demblans', 'bonjour je voudrais vous contacter', '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `chapo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `content` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `category_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Post_Category_FK` (`category_id`),
  KEY `Post_User0_FK` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `chapo`, `content`, `created_at`, `updated_at`, `category_id`, `user_id`) VALUES
(1, 'testPost', 'testChapo', 'TestContent', '2024-02-02', '2024-02-02', 1, 2),
(2, '4337aPost', 'Lorem ipsum', 'lapin', '2024-02-02', '2024-02-02', 1, 2),
(3, '20229Post', 'Dolor sit amet', 'chaise', '2024-02-02', '2024-02-02', 7, 5),
(4, '408a6Post', 'Consectetur adipiscing', 'maison', '2024-02-02', '2024-02-02', 4, 3),
(5, '3bec5Post', 'Sed do eiusmod', 'chat', '2024-02-02', '2024-02-02', 3, 7),
(6, 'd7a1ePost', 'Tempor incididunt', 'chien', '2024-02-02', '2024-02-02', 6, 4),
(7, '5835dPost', 'Ut labore et dolore', 'oiseau', '2024-02-02', '2024-02-02', 2, 8),
(8, 'f58d4Post', 'Magna aliqua', 'poisson', '2024-02-02', '2024-02-02', 5, 6);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `pseudo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `logo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `pseudo`, `password`, `logo`, `firstname`, `lastname`, `role`) VALUES
(1, 'test@test.com', 'PseudoTest', '1234', '', 'FirstNameTest', 'lastNameTest', 'admin'),
(2, 'alice.smith@example.com', 'AliceSmith', 'mdp1234', '', 'Alice', 'Smith', 'subscriber'),
(3, 'john.doe@example.com', 'JohnDoe', 'mdp5678', '', 'John', 'Doe', 'subscriber'),
(4, 'emily.jones@example.com', 'EmilyJones', 'mdp9012', '', 'Emily', 'Jones', 'subscriber'),
(5, 'michael.brown@example.com', 'MichaelBrown', 'mdp3456', '', 'Alice', 'Brown', 'subscriber'),
(6, 'sarah.wilson@example.com', 'SarahWilson', 'mdp7890', '', 'Sarah', 'Wilson', 'subscriber'),
(7, 'david.johnson@example.com', 'DavidJohnson', 'mdp2345', '', 'David', 'Johnson', 'admin'),
(8, 'lisa.miller@example.com', 'LisaMiller', 'mdp6789', '', 'Lisa', 'Miller', 'admin');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_Post0_FK` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_User_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `Post_Category_FK` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Post_User0_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
