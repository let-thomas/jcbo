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
-- Table structure for table `bodovani`
--

DROP TABLE IF EXISTS `bodovani`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bodovani` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typ_zavodu_id` smallint(6) NOT NULL,
  `misto` smallint(6) NOT NULL DEFAULT '0',
  `bodu` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_b` (`typ_zavodu_id`,`misto`),
  CONSTRAINT `fk_zt_b` FOREIGN KEY (`typ_zavodu_id`) REFERENCES `typ_zavodu` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bodovani`
--

LOCK TABLES `bodovani` WRITE;
/*!40000 ALTER TABLE `bodovani` DISABLE KEYS */;
INSERT INTO `bodovani` VALUES (1,5,1,7),(2,5,2,5),(3,5,3,4),(4,3,1,50),(5,3,2,40),(6,3,3,35),(7,3,4,30),(8,3,5,30),(9,3,6,25),(10,3,7,25),(11,3,9,20),(12,4,1,20),(13,4,2,15),(14,4,3,10),(15,4,4,7),(16,4,5,7),(17,4,6,5),(18,4,7,5),(19,2,1,100),(20,2,2,80),(21,2,3,70),(22,2,5,60),(23,2,7,50),(24,2,9,40),(25,12,1,4),(26,12,2,3),(27,12,3,2),(28,11,1,6),(29,11,2,5),(30,11,3,3),(31,8,1,10),(32,8,2,7),(33,8,3,5),(34,8,4,3),(35,8,5,3),(36,8,6,2),(37,8,7,2),(38,7,1,35),(39,7,2,30),(40,7,3,25),(41,7,5,20),(42,7,7,15),(43,7,9,10),(44,6,1,50),(45,6,2,40),(46,6,3,35),(47,6,5,30),(48,6,7,25),(49,6,9,20),(64,9,1,10),(65,9,2,7),(66,9,3,5),(67,9,4,3),(68,9,5,3),(69,9,6,2),(70,9,7,2),(71,10,1,6),(72,10,2,5),(73,10,3,3);
/*!40000 ALTER TABLE `bodovani` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-14 12:02:52
