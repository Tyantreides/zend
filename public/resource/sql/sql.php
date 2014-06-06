<?php


//-- phpMyAdmin SQL Dump
//-- version 4.0.5
//-- http://www.phpmyadmin.net
//--
//-- Host: rdbms
//-- Erstellungszeit: 06. Jun 2014 um 12:06
//-- Server Version: 5.5.31-log
//-- PHP-Version: 5.3.27
//
//SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
//SET time_zone = "+00:00";
//
//
///*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
///*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
///*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
///*!40101 SET NAMES utf8 */;
//
//--
//-- Datenbank: `DB1705936`
//--
//
//-- --------------------------------------------------------
//
//--
//-- Tabellenstruktur für Tabelle `ep_activities`
//--
//
//CREATE TABLE IF NOT EXISTS `ep_activities` (
//`id` int(11) NOT NULL,
//  `titel` varchar(255) COLLATE latin1_german1_ci NOT NULL,
//  `membercount` int(2) NOT NULL,
//  `beschreibung` text COLLATE latin1_german1_ci NOT NULL
//) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
//
//-- --------------------------------------------------------
//
//--
//-- Tabellenstruktur für Tabelle `ep_classes`
//--
//
//CREATE TABLE IF NOT EXISTS `ep_classes` (
//`id` int(5) NOT NULL AUTO_INCREMENT,
//  `classname` varchar(255) COLLATE latin1_german1_ci NOT NULL,
//  `classshortname` varchar(5) COLLATE latin1_german1_ci NOT NULL,
//  `role` int(3) NOT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=6 ;
//
//--
//-- Daten für Tabelle `ep_classes`
//--
//
//INSERT INTO `ep_classes` (`id`, `classname`, `classshortname`, `role`) VALUES
//(1, 'Gladiator', 'GLD', 1),
//(2, 'Marodeur', 'MRD', 1),
//(3, 'Waldläufer', 'WLD', 2),
//(4, 'Faustkämpfer', 'FST', 3),
//(5, 'Pikenier', 'PIK', 3);
//
//-- --------------------------------------------------------
//
//--
//-- Tabellenstruktur für Tabelle `ep_events`
//--
//
//CREATE TABLE IF NOT EXISTS `ep_events` (
//`id` int(11) NOT NULL AUTO_INCREMENT,
//  `titel` varchar(255) COLLATE latin1_german1_ci NOT NULL,
//  `beschreibung` text COLLATE latin1_german1_ci NOT NULL,
//  `datetime` datetime NOT NULL,
//  `status` int(2) NOT NULL,
//  `activityid` int(11) NOT NULL,
//  `invited` varchar(255) COLLATE latin1_german1_ci NOT NULL,
//  `accepted` varchar(255) COLLATE latin1_german1_ci NOT NULL,
//  `declined` varchar(255) COLLATE latin1_german1_ci NOT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=2 ;
//
//--
//-- Daten für Tabelle `ep_events`
//--
//
//INSERT INTO `ep_events` (`id`, `titel`, `beschreibung`, `datetime`, `status`, `activityid`, `invited`, `accepted`, `declined`) VALUES
//(1, 'Testevent', 'dies ist ein Test', '2014-06-05 00:00:00', 0, 0, '', '', '');
//
//-- --------------------------------------------------------
//
//--
//-- Tabellenstruktur für Tabelle `ep_jobs`
//--
//
//CREATE TABLE IF NOT EXISTS `ep_jobs` (
//`id` int(5) NOT NULL AUTO_INCREMENT,
//  `classid` int(5) NOT NULL,
//  `jobname` varchar(255) COLLATE latin1_german1_ci NOT NULL,
//  `jobshortname` varchar(5) COLLATE latin1_german1_ci NOT NULL,
//  `role` int(2) NOT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=1 ;
//
//-- --------------------------------------------------------
//
//--
//-- Tabellenstruktur für Tabelle `ep_players`
//--
//
//CREATE TABLE IF NOT EXISTS `ep_players` (
//`id` int(3) NOT NULL AUTO_INCREMENT,
//  `charname` varchar(255) COLLATE latin1_german1_ci NOT NULL,
//  `name` varchar(255) COLLATE latin1_german1_ci NOT NULL,
//  `classes` varchar(255) COLLATE latin1_german1_ci NOT NULL,
//  `jobs` varchar(255) COLLATE latin1_german1_ci NOT NULL,
//  `lodestoneid` bigint(10) NOT NULL,
//  `misc` varchar(255) COLLATE latin1_german1_ci NOT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=2 ;
//
//--
//-- Daten für Tabelle `ep_players`
//--
//
//INSERT INTO `ep_players` (`id`, `charname`, `name`, `classes`, `jobs`, `lodestoneid`, `misc`) VALUES
//(1, 'Tyantreides Caitsith', 'Chris', '{"classes":{1:94,2:90,3:76}}', '{"jobs":{1:94,2:90,3:76}}', 2271502, '');
//
//-- --------------------------------------------------------
//
//--
//-- Tabellenstruktur für Tabelle `ep_roles`
//--
//
//CREATE TABLE IF NOT EXISTS `ep_roles` (
//`id` int(5) NOT NULL AUTO_INCREMENT,
//  `rolename` varchar(255) COLLATE latin1_german1_ci NOT NULL,
//  `roleshortname` varchar(6) COLLATE latin1_german1_ci NOT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=6 ;
//
//--
//-- Daten für Tabelle `ep_roles`
//--
//
//INSERT INTO `ep_roles` (`id`, `rolename`, `roleshortname`) VALUES
//(1, 'Tank', 'Tank'),
//(2, 'Schaden (Fernkämpfer)', 'RDD'),
//(3, 'Schaden (Nahkämpfer)', 'MeDD'),
//(4, 'Heiler', 'Heal'),
//(5, 'Schaden (Magisch)', 'MaDD');
//
///*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
///*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
///*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;