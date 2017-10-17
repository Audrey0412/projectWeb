-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Mar 17 Octobre 2017 à 16:01
-- Version du serveur :  5.5.42
-- Version de PHP :  7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `shoes_it`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `message` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `comment`
--

INSERT INTO `comment` (`id`, `id_user`, `message`) VALUES
(11, 31, 'test'),
(13, 22, 'test2345');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `orders`
--

INSERT INTO `orders` (`id`, `id_user`, `total_price`, `date`) VALUES
(1, 22, 1150, '2017-09-17 14:20:14'),
(2, 32, 810, '2017-09-18 10:59:15'),
(3, 32, 710, '2017-09-18 10:59:47'),
(5, 22, 1150, '2017-09-18 13:39:16'),
(6, 22, 1150, '2017-09-18 13:40:28'),
(7, 22, 710, '2017-09-20 11:59:25'),
(8, 22, 710, '2017-10-02 13:13:25'),
(9, 31, 1120, '2017-10-02 16:06:31'),
(10, 22, 780, '2017-10-03 14:09:47'),
(11, 22, 340, '2017-10-03 15:20:54'),
(12, 22, 1150, '2017-10-05 11:30:54'),
(13, 22, 1150, '2017-10-05 14:34:12'),
(14, 22, 1150, '2017-10-05 14:34:37'),
(15, 22, 700, '2017-10-05 14:39:51'),
(16, 22, 2390, '2017-10-05 15:43:56'),
(17, 22, 1150, '2017-10-09 18:47:21');

-- --------------------------------------------------------

--
-- Structure de la table `orders_line`
--

CREATE TABLE `orders_line` (
  `id` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `orders_line`
--

INSERT INTO `orders_line` (`id`, `id_order`, `id_product`, `quantity`, `price`) VALUES
(1, 1, 3, 1, 710),
(2, 1, 2, 1, 440),
(3, 2, 16, 1, 100),
(4, 2, 3, 1, 710),
(5, 3, 3, 3, 710),
(7, 5, 6, 1, 370),
(8, 5, 4, 1, 780),
(9, 6, 2, 1, 440),
(10, 6, 3, 1, 710),
(11, 7, 3, 1, 710),
(12, 8, 3, 1, 710),
(13, 9, 4, 2, 780),
(14, 9, 1, 1, 340),
(15, 10, 1, 1, 340),
(16, 10, 2, 1, 440),
(17, 11, 1, 2, 340),
(18, 12, 6, 1, 370),
(19, 12, 4, 2, 780),
(20, 13, 3, 1, 710),
(21, 13, 2, 1, 440),
(22, 14, 4, 1, 780),
(23, 14, 6, 1, 370),
(24, 15, 16, 1, 100),
(25, 15, 17, 1, 600),
(26, 16, 16, 1, 100),
(27, 16, 6, 1, 370),
(28, 16, 5, 1, 620),
(29, 16, 4, 1, 780),
(30, 16, 8, 1, 150),
(31, 16, 7, 1, 370),
(32, 17, 2, 1, 440),
(33, 17, 1, 1, 340),
(34, 17, 3, 1, 710),
(35, 17, 2, 1, 440);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `brand` varchar(20) NOT NULL,
  `image` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `brand`, `image`) VALUES
(1, 'Linda', '340', 'Jana Shoes', 'linda.jpg'),
(2, 'Carmen', '440', 'Roxy', 'carmen.jpg'),
(3, 'Taylor', '710', 'Converse', 'taylor.jpg'),
(4, 'Chuck', '780', 'Converse', 'chuck.jpg'),
(5, 'Ctas', '620', 'Converse', 'ctas.jpg'),
(6, 'Tennis', '370', 'Bensimon', 'tennis.jpg'),
(7, 'Lacets', '370', 'Bensimon', 'lacets.jpg'),
(8, 'Soley', '150', 'Nike', 'soley.jpg'),
(9, 'Sautoir', '1100', 'Georgia Rose', 'sautoir.jpg'),
(10, 'Noiris', '590', 'Nike', 'noiris.jpg'),
(11, 'Monkey', '210', 'Quiksilver', 'monkey.jpg'),
(12, 'Nelson', '2300', 'Geox', 'nelson.jpg'),
(13, 'Mariza', '1150', 'TBS', 'mariza.jpg'),
(14, 'Come', '1670', 'TBS', 'come.jpg'),
(15, 'Molokai', '200', 'Quiksilver', 'molokai.jpg'),
(16, 'Telma', '100', 'Roxy', 'telma.jpg'),
(17, 'Flapy', '600', 'TBS', 'flapy.jpg'),
(18, 'Trio', '160', 'Jana Shoes', 'trio.jpg'),
(19, 'Cortez', '1000', 'Nike', 'cortez.jpg'),
(20, 'Arza', '350', 'Geox', 'arza.jpg'),
(21, 'Camilla', '300', 'Jana Shoes', 'camilla.jpg'),
(22, 'Flora', '500', 'TBS', 'flora.jpg'),
(23, 'Paul', '450', 'Bensimon', 'paul.jpg'),
(24, 'Jamy', '700', 'Georgia Rose', 'jamy.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `gender` varchar(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `type`
--

INSERT INTO `type` (`id`, `name`, `gender`) VALUES
(1, 'Ballet Pumps', 'W'),
(2, 'Flip Flops', 'W'),
(3, 'Flip Flops', 'M'),
(4, 'Flip Flops', 'K'),
(5, 'Trainers', 'W'),
(6, 'Trainers', 'M'),
(7, 'Trainers', 'K'),
(8, 'Business', 'M'),
(9, 'Summer Boots', 'K');

-- --------------------------------------------------------

--
-- Structure de la table `type_product`
--

CREATE TABLE `type_product` (
  `id` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `id_type` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `type_product`
--

INSERT INTO `type_product` (`id`, `id_product`, `id_type`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 5),
(4, 3, 6),
(5, 4, 5),
(6, 4, 6),
(7, 5, 5),
(8, 6, 5),
(9, 6, 6),
(10, 7, 5),
(11, 8, 2),
(12, 8, 3),
(13, 9, 1),
(14, 10, 6),
(15, 11, 3),
(16, 12, 8),
(17, 13, 1),
(18, 14, 8),
(19, 15, 4),
(20, 15, 3),
(21, 16, 2),
(22, 16, 4),
(23, 17, 4),
(24, 18, 4),
(25, 19, 7),
(26, 20, 7),
(27, 21, 9),
(28, 22, 9),
(29, 23, 9),
(30, 24, 9);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` text NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `firstname`, `lastname`, `email`, `password`, `admin`) VALUES
(22, 'Audrey', 'Audrey', 'Lavillat', 'audreylavillat@hotmail.com', '$2a$10$1nOEk0GyV473ViFruBvVw.hDFQHn4Qudmdk9snYig7Ys.CDJiiu.K', 1),
(31, 'Bastien', 'Bastien', 'Robert', 'bastien.robert@gmail.com', '$2a$10$c2Tyh0nJb98m8fDM2c/jvOzt.u.ylM4aEMMkf/oTfg7lxp1OtuQXG', 0),
(32, 'Arsene', 'Antoine', 'Toraille', 'antoine.toraille@live.fr', '$2a$10$TQRfjDSsAGXc8271CRn7keeJhYeHNhrNNOgMjJquwj4Eefq3Pq1De', 0);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders_line`
--
ALTER TABLE `orders_line`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_product`
--
ALTER TABLE `type_product`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `orders_line`
--
ALTER TABLE `orders_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `type_product`
--
ALTER TABLE `type_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;