-- Adminer 4.8.1 MySQL 5.5.5-10.3.11-MariaDB-1:10.3.11+maria~bionic dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `commande`;
CREATE TABLE `commande` (
  `id` varchar(128) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `livraison` datetime NOT NULL,
  `nom` varchar(128) NOT NULL,
  `mail` varchar(256) NOT NULL,
  `montant` decimal(8,2) DEFAULT NULL,
  `token` varchar(128) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(128) NOT NULL,
  `libelle` varchar(128) DEFAULT NULL,
  `tarif` decimal(8,2) DEFAULT NULL,
  `quantite` int(11) DEFAULT 1,
  `command_id` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `paiement`;
CREATE TABLE `paiement` (
  `commande_id` varchar(64) NOT NULL,
  `reference` varchar(64) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `montant_paiement` decimal(8,2) NOT NULL,
  `mode_paiement` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2022-01-11 10:08:58
