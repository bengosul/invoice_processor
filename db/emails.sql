-- MySQL dump 10.16  Distrib 10.1.24-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: emails
-- ------------------------------------------------------
-- Server version	10.1.24-MariaDB

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
-- Current Database: `emails`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `emails` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `emails`;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'ADC');
INSERT INTO `accounts` VALUES (2,'TSN');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logins`
--

DROP TABLE IF EXISTS `logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `passhash` varchar(300) NOT NULL,
  `salt2` varchar(50) NOT NULL,
  `imap_pass_enc` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logins`
--

LOCK TABLES `logins` WRITE;
/*!40000 ALTER TABLE `logins` DISABLE KEYS */;
/*!40000 ALTER TABLE `logins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `match_config`
--

DROP TABLE IF EXISTS `match_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `match_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `partner` varchar(30) NOT NULL,
  `config_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `atttype` varchar(5) NOT NULL,
  `inv_no_str` varchar(50) NOT NULL,
  `inv_no_col_offset` int(11) NOT NULL,
  `inv_no_row_offset` int(11) NOT NULL,
  `inv_date_str` varchar(50) NOT NULL,
  `inv_date_col_offset` int(11) NOT NULL,
  `inv_date_row_offset` int(11) NOT NULL,
  `inv_date_format` varchar(20) NOT NULL,
  UNIQUE KEY `idx` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `match_config`
--

LOCK TABLES `match_config` WRITE;
/*!40000 ALTER TABLE `match_config` DISABLE KEYS */;
INSERT INTO `match_config` VALUES (1,'1','test1x','testinvoice2@gmail.com','','txt','apa',0,0,'invoice date',0,0,'');
INSERT INTO `match_config` VALUES (17,'male','sdfd','','','','',0,0,'',0,0,'');
INSERT INTO `match_config` VALUES (19,'2','cucu','','','','',0,0,'',0,0,'');
/*!40000 ALTER TABLE `match_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `missing_partner`
--

DROP TABLE IF EXISTS `missing_partner`;
/*!50001 DROP VIEW IF EXISTS `missing_partner`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `missing_partner` (
  `id` tinyint NOT NULL,
  `subject` tinyint NOT NULL,
  `received` tinyint NOT NULL,
  `processed` tinyint NOT NULL,
  `attachments` tinyint NOT NULL,
  `partner` tinyint NOT NULL,
  `from_address` tinyint NOT NULL,
  `parsed` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `processed_attachments`
--

DROP TABLE IF EXISTS `processed_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `processed_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_email` int(11) NOT NULL,
  `id_attachment` int(11) NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `invoice_date` date NOT NULL,
  `invoice_amount` decimal(9,2) NOT NULL,
  `invoice_number` varchar(30) NOT NULL,
  `fn` varchar(100) NOT NULL,
  `extension` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IX_EMAIL_ATTACH` (`id_email`,`id_attachment`),
  KEY `id_email` (`id_email`),
  CONSTRAINT `FK_IDEMAIL` FOREIGN KEY (`id_email`) REFERENCES `processed_emails` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `processed_attachments`
--

LOCK TABLES `processed_attachments` WRITE;
/*!40000 ALTER TABLE `processed_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `processed_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `processed_emails`
--

DROP TABLE IF EXISTS `processed_emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `processed_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(100) NOT NULL,
  `received` datetime NOT NULL,
  `processed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `attachments` int(11) NOT NULL,
  `partner` varchar(20) NOT NULL,
  `from_address` varchar(100) NOT NULL,
  `parsed` datetime NOT NULL,
  UNIQUE KEY `idindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `processed_emails`
--

LOCK TABLES `processed_emails` WRITE;
/*!40000 ALTER TABLE `processed_emails` DISABLE KEYS */;
INSERT INTO `processed_emails` VALUES (114,'1An email sent from PHP3','2017-04-01 15:51:18','2017-06-21 22:13:37',1,'test','testinvoice2@gmail.com','2017-06-21 23:57:29');
INSERT INTO `processed_emails` VALUES (115,'2Trei sfaturi pentru a profita la maximum de Gmail','2017-01-13 20:44:39','2017-06-21 22:13:37',0,'','mail-noreply@google.com','0000-00-00 00:00:00');
INSERT INTO `processed_emails` VALUES (116,'3OrganizeazÄƒ-te mai bine cu ajutorul cÄƒsuÈ›ei Gmail','2017-01-13 20:44:40','2017-06-21 22:13:37',0,'','mail-noreply@google.com','0000-00-00 00:00:00');
INSERT INTO `processed_emails` VALUES (117,'4Cele mai bune funcÈ›ii Gmail, oriunde te-ai afla','2017-01-13 20:44:39','2017-06-21 22:13:37',0,'','mail-noreply@google.com','0000-00-00 00:00:00');
INSERT INTO `processed_emails` VALUES (121,'8An email sent from PHP3','2017-05-20 20:59:48','2017-06-21 22:13:38',1,'test','testinvoice2@gmail.com','2017-06-21 23:56:14');
INSERT INTO `processed_emails` VALUES (122,'9An email sent from PHP3 queued','2017-05-21 13:56:01','2017-06-21 22:13:38',1,'test','testinvoice2@gmail.com','0000-00-00 00:00:00');
INSERT INTO `processed_emails` VALUES (123,'10An email sent from PHP3 queued','2017-05-21 13:56:04','2017-06-21 22:13:38',1,'test','testinvoice2@gmail.com','0000-00-00 00:00:00');
INSERT INTO `processed_emails` VALUES (124,'11An email sent from PHP3 queued','2017-05-21 13:59:11','2017-06-21 22:13:38',1,'test','testinvoice2@gmail.com','0000-00-00 00:00:00');
INSERT INTO `processed_emails` VALUES (125,'12An email sent from PHP3 queued','2017-05-21 14:23:01','2017-06-21 22:13:38',0,'','testinvoice2@gmail.com','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `processed_emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_config`
--

DROP TABLE IF EXISTS `server_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `IMAP_HOST` varchar(50) NOT NULL,
  `IMAP_PORT` int(11) NOT NULL,
  `IMAP_USER` varchar(50) NOT NULL,
  `IMAP_PASS_ENCR` varchar(300) NOT NULL,
  `id_login` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_loginid` (`id_login`),
  CONSTRAINT `fk_loginid` FOREIGN KEY (`id_login`) REFERENCES `logins` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_config`
--

LOCK TABLES `server_config` WRITE;
/*!40000 ALTER TABLE `server_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `server_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Current Database: `emails`
--

USE `emails`;

--
-- Final view structure for view `missing_partner`
--

/*!50001 DROP TABLE IF EXISTS `missing_partner`*/;
/*!50001 DROP VIEW IF EXISTS `missing_partner`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `missing_partner` AS select `e`.`id` AS `id`,`e`.`subject` AS `subject`,`e`.`received` AS `received`,`e`.`processed` AS `processed`,`e`.`attachments` AS `attachments`,`e`.`partner` AS `partner`,`e`.`from_address` AS `from_address`,`e`.`parsed` AS `parsed` from (`processed_emails` `e` left join `processed_attachments` `a` on((`e`.`id` = `a`.`id_email`))) where ((`e`.`attachments` > 0) and (`e`.`parsed` > 0) and isnull(`a`.`id_email`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-05 22:39:20
