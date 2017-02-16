-- MySQL dump 10.15  Distrib 10.0.29-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.0.29-MariaDB-0+deb8u1

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
-- Table structure for table `typ_zavodu`
--

DROP TABLE IF EXISTS `typ_zavodu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typ_zavodu` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(32) NOT NULL,
  `vaha` decimal(4,2) NOT NULL DEFAULT '1.00',
  `comment` varchar(100) DEFAULT NULL,
  `typ` smallint(6) DEFAULT NULL COMMENT '#1=mistrovsky, 2=nemistrovsky, 3=druzstva, 9=turnajpripravek',
  `sortorder` smallint(6) DEFAULT '9',
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_zt` (`nazev`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typ_zavodu`
--

LOCK TABLES `typ_zavodu` WRITE;
/*!40000 ALTER TABLE `typ_zavodu` DISABLE KEYS */;
INSERT INTO `typ_zavodu` VALUES (1,'Turnaj Pripravek',1.00,'',9,99),(2,'mistrovství sveta',1.00,'',1,11),(3,'mistrovství evropy',1.00,'',1,10),(4,'mistrovství ČR',1.00,'',1,9),(5,'mistrovství kraje',1.00,'???',1,8),(6,'EYOF',1.00,'Evropský olympijský festival mládeže = ME?',2,7),(7,'turnaj EJU',1.00,'',2,6),(8,'Přebor PČR, kvalifikace PCR/MCR',1.00,'',2,5),(9,'Mezinárodní turnaj (>3země)',1.00,'bodovani dtto id 8',2,4),(10,'ostatní turnaje ČSJu',1.00,'bodovani dtto id 11',2,3),(11,'krajské a oblastní turnaje',1.00,'přebor kraje, mezin/VC, přebor spojenych oblasti',2,2),(12,'MalaCena, ostatní',1.00,'',2,1),(13,'Liga (EXL, 1L, ML, DL)',1.00,'soutěž družstev',3,20);
/*!40000 ALTER TABLE `typ_zavodu` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-14 12:16:03
