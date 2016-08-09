-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: zf2_training
-- ------------------------------------------------------
-- Server version	5.5.49-0ubuntu0.14.04.1-log

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
-- Table structure for table `tblEmployeeData`
--

DROP TABLE IF EXISTS `tblEmployeeData`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblEmployeeData` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empId` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `empEmail` varchar(100) NOT NULL,
  `empRole` varchar(50) NOT NULL,
  `dateCreated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblEmployeeData`
--

LOCK TABLES `tblEmployeeData` WRITE;
/*!40000 ALTER TABLE `tblEmployeeData` DISABLE KEYS */;
INSERT INTO `tblEmployeeData` VALUES (6,'mohit1','48418969a4071bf494272463b4e6b324','mohit@osscube.com','SE','2016-08-05 07:11:05'),(7,'mohit2','48418969a4071bf494272463b4e6b324','mohit1@osscube.com','SSE','2016-08-05 07:11:24'),(8,'mohit3','48418969a4071bf494272463b4e6b324','mohit3@osscube.com','PM','2016-08-05 07:11:45'),(10,'mohit4','48418969a4071bf494272463b4e6b324','mohit4@osscube.com','SSE','2016-08-08 07:05:24'),(11,'mohit5','48418969a4071bf494272463b4e6b324','mohit5@osscube.com','SE','2016-08-08 07:07:00'),(12,'mohit6','48418969a4071bf494272463b4e6b324','mohit6@osscube.com','TL','2016-08-08 07:09:54'),(13,'mohit7','48418969a4071bf494272463b4e6b324','mohit7@osscube.com','TL','2016-08-08 07:23:38'),(14,'mohit8','48418969a4071bf494272463b4e6b324','mohit8@osscube.com','SSE','2016-08-08 07:30:21');
/*!40000 ALTER TABLE `tblEmployeeData` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'zf2_training'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-08 15:30:57
