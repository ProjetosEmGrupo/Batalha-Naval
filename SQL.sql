-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 09-Dez-2019 às 11:26
-- Versão do servidor: 5.7.26
-- versão do PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `ihc`
--
CREATE DATABASE IF NOT EXISTS `ihc` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ihc`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplines`
--

DROP TABLE IF EXISTS `disciplines`;
CREATE TABLE IF NOT EXISTS `disciplines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `disciplines`
--

INSERT INTO `disciplines` (`id`, `description`) VALUES
(1, 'Língua Portuguesa'),
(2, 'Matemática'),
(3, 'Literatura'),
(4, 'História'),
(5, 'Geografia'),
(6, 'Artes'),
(7, 'Inglês'),
(8, 'História'),
(9, 'Ed. Física'),
(10, 'Artes'),
(11, 'Química'),
(12, 'Física'),
(13, 'Biologia'),
(14, 'Filosofia'),
(15, 'Sociologia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `tests_id` int(11) NOT NULL,
  `pontuacao` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estrutura da tabela `group_users`
--

DROP TABLE IF EXISTS `group_users`;
CREATE TABLE IF NOT EXISTS `group_users` (
  `admin_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`admin_id`,`users_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estrutura da tabela `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(100) NOT NULL,
  `alt1` varchar(45) NOT NULL,
  `alt2` varchar(45) NOT NULL,
  `alt3` varchar(45) NOT NULL,
  `alt4` varchar(45) NOT NULL,
  `answer` varchar(45) NOT NULL,
  `users_id` int(11) NOT NULL,
  `schoolings_id` int(11) NOT NULL,
  `disciplines_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_id` (`users_id`),
  KEY `schoolings_id` (`schoolings_id`),
  KEY `disciplines_id` (`disciplines_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `question_tests`
--

DROP TABLE IF EXISTS `question_tests`;
CREATE TABLE IF NOT EXISTS `question_tests` (
  `questions_id` int(11) NOT NULL,
  `tests_id` int(11) NOT NULL,
  PRIMARY KEY (`questions_id`,`tests_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estrutura da tabela `schoolings`
--

DROP TABLE IF EXISTS `schoolings`;
CREATE TABLE IF NOT EXISTS `schoolings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `schoolings`
--

INSERT INTO `schoolings` (`id`, `description`) VALUES
(1, 'Fundamental'),
(2, 'Médio'),
(3, 'Superior'),
(4, 'Docente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tests`
--

DROP TABLE IF EXISTS `tests`;
CREATE TABLE IF NOT EXISTS `tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `schoolings_id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_id` (`users_id`),
  KEY `schoolings_id` (`schoolings_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `schoolings_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `schoolings_id` (`schoolings_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

