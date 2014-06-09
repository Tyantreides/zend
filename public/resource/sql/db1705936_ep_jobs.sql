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
-- Table structure for table `ep_jobs`
--

DROP TABLE IF EXISTS `ep_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ep_jobs` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `classid` int(5) NOT NULL,
  `jobname` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `jobshortname` varchar(5) COLLATE latin1_german1_ci NOT NULL,
  `role` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ep_jobs`
--

LOCK TABLES `ep_jobs` WRITE;
/*!40000 ALTER TABLE `ep_jobs` DISABLE KEYS */;
INSERT INTO `ep_jobs` VALUES (1,1,'Paladin','PLD',1),(2,2,'Krieger','KRG',1),(3,3,'Barde','BRD',2),(4,4,'Mönch','MNK',3),(5,5,'Dragoon','DRG',3),(6,6,'Weissmagier','WHM',4),(7,7,'Scholar','SCH',4),(8,7,'Beschwörer','SMN',2),(9,8,'Schwarzmagier','BLM',2);
/*!40000 ALTER TABLE `ep_jobs` ENABLE KEYS */;
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
