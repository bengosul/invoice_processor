create database if not exists emails;

-- MySQL dump 10.16  Distrib 10.1.22-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: emails
-- ------------------------------------------------------
-- Server version	10.1.22-MariaDB

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `match_config`
--

LOCK TABLES `match_config` WRITE;
/*!40000 ALTER TABLE `match_config` DISABLE KEYS */;
INSERT INTO `match_config` VALUES (1,'test','test1','testinvoice2@gmail.com','','txt','invoice number',0,0,'invoice date',0,0,''),(2,'MOI','','valentin.lihatchi@gmail.com','','','apa',0,0,'',0,0,'');
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
  `invoice_date` tinyint NOT NULL,
  `invoice_amount` tinyint NOT NULL,
  `invoice_number` tinyint NOT NULL,
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
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `invoice_date` date NOT NULL,
  `invoice_amount` decimal(9,2) NOT NULL,
  `invoice_number` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IX_EMAIL_ATTACH` (`id_email`,`id_attachment`),
  KEY `id_email` (`id_email`),
  CONSTRAINT `FK_IDEMAIL` FOREIGN KEY (`id_email`) REFERENCES `processed_emails` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `processed_attachments`
--

LOCK TABLES `processed_attachments` WRITE;
/*!40000 ALTER TABLE `processed_attachments` DISABLE KEYS */;
INSERT INTO `processed_attachments` VALUES (37,1,1,'2017-05-07 13:11:21','0000-00-00',0.00,': cac555'),(38,1,2,'2017-05-07 13:11:21','0000-00-00',0.00,''),(39,6,1,'2017-05-07 13:11:21','0000-00-00',0.00,'n, the Philippines, Brazil, Ne'),(40,7,1,'2017-05-07 13:11:21','0000-00-00',0.00,' minerala');
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
  `invoice_date` date NOT NULL,
  `invoice_amount` decimal(9,2) NOT NULL,
  `invoice_number` varchar(30) NOT NULL,
  `parsed` datetime NOT NULL,
  UNIQUE KEY `idindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `processed_emails`
--

LOCK TABLES `processed_emails` WRITE;
/*!40000 ALTER TABLE `processed_emails` DISABLE KEYS */;
INSERT INTO `processed_emails` VALUES (1,'1An email sent from PHP3','0000-00-00 00:00:00','0000-00-00 00:00:00',2,'test','testinvoice2@gmail.com','0000-00-00',0.00,'','2017-05-07 13:11:21'),(2,'2Cele mai bune funcÈ›ii Gmail, oriunde te-ai afla','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'','mail-noreply@google.com','0000-00-00',0.00,'','0000-00-00 00:00:00'),(3,'3OrganizeazÄƒ-te mai bine cu ajutorul cÄƒsuÈ›ei Gmail','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'','mail-noreply@google.com','0000-00-00',0.00,'','0000-00-00 00:00:00'),(4,'4Trei sfaturi pentru a profita la maximum de Gmail','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'','mail-noreply@google.com','0000-00-00',0.00,'','0000-00-00 00:00:00'),(5,'1testt','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'','valentin.lihatchi@gmail.com','0000-00-00',0.00,'','0000-00-00 00:00:00'),(6,'1locked pdf','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'MOI','valentin.lihatchi@gmail.com','0000-00-00',0.00,'','2017-05-07 13:11:21'),(7,'1protecteddoc','0000-00-00 00:00:00','2017-05-06 02:00:35',1,'MOI','valentin.lihatchi@gmail.com','0000-00-00',0.00,'','2017-05-07 13:11:21');
/*!40000 ALTER TABLE `processed_emails` ENABLE KEYS */;
UNLOCK TABLES;

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
/*!50001 VIEW `missing_partner` AS select `e`.`id` AS `id`,`e`.`subject` AS `subject`,`e`.`received` AS `received`,`e`.`processed` AS `processed`,`e`.`attachments` AS `attachments`,`e`.`partner` AS `partner`,`e`.`from_address` AS `from_address`,`e`.`invoice_date` AS `invoice_date`,`e`.`invoice_amount` AS `invoice_amount`,`e`.`invoice_number` AS `invoice_number`,`e`.`parsed` AS `parsed` from (`processed_emails` `e` left join `processed_attachments` `a` on((`e`.`id` = `a`.`id_email`))) where ((`e`.`attachments` > 0) and (`e`.`parsed` > 0) and isnull(`a`.`id_email`)) */;
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

-- Dump completed on 2017-05-24 15:53:34
