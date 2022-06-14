-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: synergy
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `api_key`
--

DROP TABLE IF EXISTS `api_key`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_key` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api_key` varchar(75) DEFAULT NULL,
  `description` varchar(75) DEFAULT NULL,
  `key_status` enum('ACTIVE','NOT_ACTIVE') DEFAULT NULL,
  `platform` varchar(30) DEFAULT NULL,
  `version_detail` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_key`
--

LOCK TABLES `api_key` WRITE;
/*!40000 ALTER TABLE `api_key` DISABLE KEYS */;
INSERT INTO `api_key` VALUES (1,'0000','Synergy Website','ACTIVE',NULL,NULL,'2021-02-19 13:00:00','2021-02-19 13:00:00');
/*!40000 ALTER TABLE `api_key` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buy_part`
--

DROP TABLE IF EXISTS `buy_part`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buy_part` (
  `IDBUYPART` varchar(40) NOT NULL,
  `FAKTUR` varchar(60) NOT NULL DEFAULT '',
  `SUPPLIER` varchar(40) NOT NULL,
  `CABANG` varchar(6) NOT NULL,
  `TOTPAY` int(11) NOT NULL DEFAULT 0,
  `STATTRX` int(5) NOT NULL DEFAULT 0,
  `DCREA` datetime NOT NULL DEFAULT current_timestamp(),
  `CREABY` varchar(40) NOT NULL,
  PRIMARY KEY (`IDBUYPART`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buy_part`
--

LOCK TABLES `buy_part` WRITE;
/*!40000 ALTER TABLE `buy_part` DISABLE KEYS */;
INSERT INTO `buy_part` VALUES ('00001/BUY/22/06/00001','1','COBA','00001',50000,1,'2022-06-14 16:17:46','SYNERGY');
/*!40000 ALTER TABLE `buy_part` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cabang`
--

DROP TABLE IF EXISTS `cabang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cabang` (
  `CABANG` varchar(8) NOT NULL,
  `NAMA` varchar(40) NOT NULL,
  `ALAMAT` text NOT NULL,
  `PHONE` varchar(30) NOT NULL,
  `INIT` varchar(10) NOT NULL,
  `isActive` int(2) NOT NULL DEFAULT 1,
  PRIMARY KEY (`CABANG`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cabang`
--

LOCK TABLES `cabang` WRITE;
/*!40000 ALTER TABLE `cabang` DISABLE KEYS */;
INSERT INTO `cabang` VALUES ('00001','SYNERGY SURABAYA','Surabaya, Jawa Timur, Indonesia','031 - 123 4567','QTYSYN',1);
/*!40000 ALTER TABLE `cabang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'Synergy Website','Surabaya','081213186','2021-02-19 13:00:00','2021-02-19 13:00:00'),(2,'ILHAM','SURABAYA','0813147121',NULL,NULL),(3,'ILHAM','SURABAYA','0813147121',NULL,NULL);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dtl_part_beli`
--

DROP TABLE IF EXISTS `dtl_part_beli`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dtl_part_beli` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IDBUYPART` varchar(30) NOT NULL,
  `CABANG` varchar(8) NOT NULL,
  `PARTNUM` varchar(30) NOT NULL,
  `PARTDESC` varchar(50) NOT NULL,
  `QTY` int(10) NOT NULL,
  `HARGA` int(11) NOT NULL,
  `DCREA` datetime NOT NULL DEFAULT current_timestamp(),
  `CREABY` varchar(40) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `dtl_part_beli_IDBUYPART_PARTNUM_idx` (`IDBUYPART`,`PARTNUM`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=38692 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dtl_part_beli`
--

LOCK TABLES `dtl_part_beli` WRITE;
/*!40000 ALTER TABLE `dtl_part_beli` DISABLE KEYS */;
INSERT INTO `dtl_part_beli` VALUES (38690,'00001/BUY/22/06/00001','00001','00001SYN901','OLI TOP ONE',1,50000,'2022-06-14 16:22:37','SYNERGY');
/*!40000 ALTER TABLE `dtl_part_beli` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dtl_part_jual`
--

DROP TABLE IF EXISTS `dtl_part_jual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dtl_part_jual` (
  `IDHIST` varchar(40) NOT NULL,
  `IDTRANSPART` varchar(40) NOT NULL DEFAULT '',
  `CABANG` varchar(8) NOT NULL,
  `NOPOL` varchar(20) NOT NULL,
  `DATE` datetime NOT NULL DEFAULT current_timestamp(),
  `PARTNUM` varchar(30) NOT NULL,
  `PARTDESC` varchar(45) NOT NULL,
  `PRICE` int(8) NOT NULL DEFAULT 0,
  `DISCOUNT` int(8) NOT NULL DEFAULT 0,
  `DISC_RP` int(8) NOT NULL DEFAULT 0,
  `QTY` int(11) NOT NULL,
  `TOTPAYPART` int(11) NOT NULL,
  `KMSERVICE` int(11) NOT NULL,
  `VPAYMENT` varchar(5) NOT NULL DEFAULT 'K',
  `VPLNACT` varchar(5) NOT NULL DEFAULT 'P',
  `CREABY` varchar(100) NOT NULL,
  PRIMARY KEY (`IDHIST`),
  UNIQUE KEY `dtl_part_jual_IDTRANSPART_NOPOL_PARTNUM_idx` (`IDTRANSPART`,`NOPOL`,`PARTNUM`,`PRICE`,`QTY`,`TOTPAYPART`) USING BTREE,
  KEY `dtl_part_jual_NOPOL_idx` (`NOPOL`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dtl_part_jual`
--

LOCK TABLES `dtl_part_jual` WRITE;
/*!40000 ALTER TABLE `dtl_part_jual` DISABLE KEYS */;
INSERT INTO `dtl_part_jual` VALUES ('00001/SO/22/06/00001-00001MGP901','00001/SO/22/06/00001','00001','','2022-06-14 15:45:40','00001MGP901','OLI TOP ONE',50000,0,0,1,50000,0,'K','P','SYNERGY'),('00001/SO/22/06/00002-00001SYN901','00001/SO/22/06/00002','00001','','2022-06-14 16:47:58','00001SYN901','OLI TOP ONE',50000,0,0,1,50000,0,'K','P','SYNERGY');
/*!40000 ALTER TABLE `dtl_part_jual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `CABANG` varchar(8) NOT NULL,
  `USERNAME` varchar(30) NOT NULL,
  `PASSWORD` varchar(40) NOT NULL,
  `NAME` varchar(40) NOT NULL,
  `PHONUM` varchar(30) NOT NULL DEFAULT '',
  `ROLE_ID` int(5) NOT NULL DEFAULT 2,
  `DCREA` datetime NOT NULL DEFAULT current_timestamp(),
  `CREABY` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
INSERT INTO `member` VALUES ('00001','00001','6ad14ba9986e3615423dfca256d04e3f ','SYNERGY SO','031 - 123 45678',1,'2018-07-05 20:37:39','ADMINISTRATOR'),('00001','00002','6ad14ba9986e3615423dfca256d04e3f ','SYNERGY PO','031 - 123 45678',2,'2018-07-05 20:37:39','ADMINISTRATOR'),('00001','00000','6ad14ba9986e3615423dfca256d04e3f ','SYNERGY SO','031 - 123 45678',0,'2018-07-05 20:37:39','ADMINISTRATOR');
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `part`
--

DROP TABLE IF EXISTS `part`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `part` (
  `VPARTNUM` varchar(20) NOT NULL,
  `VPARTDESC` varchar(60) NOT NULL,
  `MHETPART` int(10) unsigned DEFAULT NULL,
  `QTYSYN` int(10) NOT NULL DEFAULT 0,
  `DCREA` datetime DEFAULT current_timestamp(),
  `DMODI` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `VCREABY` varchar(60) DEFAULT NULL,
  `VMODIBY` varchar(60) DEFAULT NULL,
  `SHOW` int(10) DEFAULT 1,
  PRIMARY KEY (`VPARTNUM`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `part`
--

LOCK TABLES `part` WRITE;
/*!40000 ALTER TABLE `part` DISABLE KEYS */;
INSERT INTO `part` VALUES ('00001SYN901','OLI TOP ONE',50000,4,'2022-06-14 14:39:24','2022-06-14 16:47:58',NULL,NULL,1),('00002SYN901','BULB HEADLIGHT',200000,0,'2022-06-14 15:29:28','2022-06-14 16:17:12','00001',NULL,1);
/*!40000 ALTER TABLE `part` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier` (
  `IDSUPPLIER` varchar(20) NOT NULL,
  `SUPPLIER` varchar(60) NOT NULL,
  `ALAMAT` varchar(60) DEFAULT NULL,
  `PHONE` varchar(60) NOT NULL DEFAULT '0',
  `DCREA` datetime DEFAULT current_timestamp(),
  `VCREABY` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`IDSUPPLIER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier`
--

LOCK TABLES `supplier` WRITE;
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` VALUES ('00001SUP001','EKA JAYA','SURABAYA','81216371','2022-06-14 14:39:24',NULL),('00002SUP001','ABADI SEJAHTERA','SURABAYA','81216371','2022-06-14 15:29:28','00001');
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_part`
--

DROP TABLE IF EXISTS `trans_part`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_part` (
  `IDTRANSPART` varchar(40) NOT NULL,
  `TYPE` varchar(5) NOT NULL DEFAULT 'NSC',
  `IDCUST` varchar(40) NOT NULL DEFAULT 'REGULER',
  `BUYERNAME` varchar(40) NOT NULL,
  `CABANG` varchar(8) NOT NULL,
  `TOTPAY` int(11) NOT NULL,
  `STATTRX` int(5) NOT NULL,
  `DCREA` datetime NOT NULL DEFAULT current_timestamp(),
  `CREABY` varchar(100) NOT NULL,
  PRIMARY KEY (`IDTRANSPART`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_part`
--

LOCK TABLES `trans_part` WRITE;
/*!40000 ALTER TABLE `trans_part` DISABLE KEYS */;
INSERT INTO `trans_part` VALUES ('00001/SO/22/06/00001','SO','1','ILHAM','00001',50000,1,'2022-06-14 15:45:36','SYNERGY'),('00001/SO/22/06/00002','SO','2','ILHAM','00001',50000,1,'2022-06-14 16:47:06','SYNERGY');
/*!40000 ALTER TABLE `trans_part` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-14 17:13:33
