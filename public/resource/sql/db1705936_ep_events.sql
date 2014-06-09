CREATE DATABASE  IF NOT EXISTS `db1705936` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db1705936`;
-- MySQL dump 10.13  Distrib 5.6.11, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: db1705936
-- ------------------------------------------------------
-- Server version	5.6.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ep_events`
--

DROP TABLE IF EXISTS `ep_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ep_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titel` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `beschreibung` text COLLATE latin1_german1_ci NOT NULL,
  `datetime` datetime NOT NULL,
  `status` int(2) NOT NULL,
  `activityid` int(11) NOT NULL,
  `invited` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `accepted` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `declined` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ep_events`
--

LOCK TABLES `ep_events` WRITE;
/*!40000 ALTER TABLE `ep_events` DISABLE KEYS */;
INSERT INTO `ep_events` VALUES (1,'Testevent','dies ist e','2014-06-05 00:00:00',0,0,'','',''),(2,'zumloeschen','loeschtest','0000-00-00 00:00:00',0,0,'','','');
/*!40000 ALTER TABLE `ep_events` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-06-10  1:13:47
