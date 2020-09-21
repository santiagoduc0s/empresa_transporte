-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: localhost    Database: proyecto_php
-- ------------------------------------------------------
-- Server version	5.7.17-log

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
-- Table structure for table `encargado`
--

DROP TABLE IF EXISTS `encargado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `encargado` (
  `cedula_encargado` varchar(45) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `foto` varchar(45) DEFAULT NULL,
  `pin` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cedula_encargado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encargado`
--

LOCK TABLES `encargado` WRITE;
/*!40000 ALTER TABLE `encargado` DISABLE KEYS */;
INSERT INTO `encargado` VALUES ('55555555','maria','molinari','mmolina543@gmail.com',NULL,'e10adc3949ba59abbe56e057f20f883e');
/*!40000 ALTER TABLE `encargado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paquete`
--

DROP TABLE IF EXISTS `paquete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paquete` (
  `codigo` varchar(45) NOT NULL,
  `direccion_remitente` varchar(45) DEFAULT NULL,
  `direccion_envio` varchar(45) DEFAULT NULL,
  `fragil` varchar(45) DEFAULT NULL,
  `pedecedero` varchar(45) DEFAULT NULL,
  `fecha_estimada_entrega` date DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `estado_paquete` varchar(45) DEFAULT NULL,
  `fecha_hora_asignacion` datetime DEFAULT NULL,
  `ci_transportista` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_paquete_transportista_idx` (`ci_transportista`),
  CONSTRAINT `fk_paquete_transportista` FOREIGN KEY (`ci_transportista`) REFERENCES `transportista` (`cedula_transportista`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paquete`
--

LOCK TABLES `paquete` WRITE;
/*!40000 ALTER TABLE `paquete` DISABLE KEYS */;
INSERT INTO `paquete` VALUES ('0000000000000001','yajuoo 1246','mapenta 6539','no','no','2020-07-05','2020-07-01','entregado','2020-06-28 00:00:00','11111119'),('0000000000000002','jajaja 765','jijiji 7653','si','si','2020-07-07','2020-07-02','entregado','2020-06-29 00:00:00','11111119'),('0000000000000003','junin 65','la mancha 945','no','si','2020-06-15','2020-06-16','entregado','2020-06-13 12:30:00','11111119'),('0000000000000004','ytui 76','hbhtc 6553','no','no','2020-07-16','2020-07-02','entregado','2020-07-02 03:29:35','11111119'),('0000000000000005','lknl 876','bjyhb 7654','no','no','2020-07-05','2020-07-03','entregado','2020-07-02 03:37:38','11111119'),('0000000000000006','xde 432','erytu 987','si','no','2020-08-09','2020-07-03','entregado','2020-07-03 02:50:06','11111119'),('0000000000000007','mamamia','la momia','si','no','2020-07-11','2020-07-11','entregado','2020-07-11 16:32:58','40788375'),('0000000000000008','maluma beibi 1276','arjona 9832','no','no',NULL,NULL,'sin asignar',NULL,NULL),('0000000000000009','shakira 564','bad bunny 657','si','si','2020-07-30','2020-07-03','entregado','2020-07-03 21:04:07','11111119'),('0000000000000010','tu vieja 865','tu mama 987','no','no',NULL,NULL,'sin asignar',NULL,NULL),('0695f023a8aaa728','albhwdb 2341','jdncknew 4345','no','no','2020-07-31','2020-07-06','entregado','2020-07-06 14:51:08','12312332'),('0715f0365656abc3','noasn 829','kjsed 899','si','no',NULL,NULL,'sin asignar',NULL,NULL),('1115f0765f6c83c9','jhib 332','jnk 32','no','no','2020-07-10','2020-07-09','entregado','2020-07-09 18:59:40','51799876'),('1625f03db462047b','jnksdfbnjfv','wedwdwe','no','no','2020-07-07','2020-07-07','entregado','2020-07-07 00:19:20','51799876'),('1645effba521bb56','bbbbbb','bbbbb','no','si',NULL,NULL,'sin asignar',NULL,NULL),('1875effbfab98ac5','wakawaka 765','ameno 654','no','no','2020-07-29','2020-07-06','entregado','2020-07-06 14:50:43','12312332'),('3345f08a45a4e298','maluma 9999','kjnk 9897','si','si',NULL,NULL,'sin asignar',NULL,NULL),('3615effcffc791d8','iiiiiiiiiii','lllllll','si','si','2020-07-05','2020-07-05','entregado','2020-07-05 19:10:56','11111199'),('4125f07e6248f8d6','jndckejn 43','jndkcfndfj9 09','no','no','2020-07-24',NULL,'en transito','2020-07-10 14:23:15','51799876'),('4695f0107f5c0aea','malasangre 763','uxiwund 897','no','no','2020-07-30','2020-07-05','entregado','2020-07-05 19:11:12','11111199'),('5615f03654d81a96','Manhv 329','Jjcdie 7790','no','no','2020-07-11','2020-07-09','entregado','2020-07-09 22:19:08','51799876'),('6315f03657bc3db3','jsked 88','jndej 990','no','no',NULL,NULL,'sin asignar',NULL,NULL),('6385effba677629f','holis a','holis b','no','no','2020-07-30',NULL,'en transito','2020-07-05 19:11:31','11111199'),('7305effba2729a20','aaaaa','aaaaaa','si','si',NULL,NULL,'sin asignar',NULL,NULL),('7335f0a1288ac85b','wedwe 3434','aaaa 7462','si','no',NULL,NULL,'sin asignar',NULL,NULL),('7915f0107e75dbaa','yokec 735','valdomir 32','si','no',NULL,NULL,'sin asignar',NULL,NULL),('8915f08a6a256dc6','a','a','no','no',NULL,NULL,'sin asignar',NULL,NULL),('9485effe9f1b93dd','tu vieja 098','pappa lelele 382','si','si','2020-07-05',NULL,'en transito','2020-07-04 23:11:31','84374958'),('9995f036572057c4','kndine 82793','jeejjw 9299','no','no','2020-07-10','2020-07-10','entregado','2020-07-09 22:22:31','51799876');
/*!40000 ALTER TABLE `paquete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transportista`
--

DROP TABLE IF EXISTS `transportista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transportista` (
  `cedula_transportista` varchar(45) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `pin` varchar(45) DEFAULT NULL,
  `foto` varchar(300) DEFAULT NULL,
  `estado_transportista` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cedula_transportista`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transportista`
--

LOCK TABLES `transportista` WRITE;
/*!40000 ALTER TABLE `transportista` DISABLE KEYS */;
INSERT INTO `transportista` VALUES ('11111119','pablo','alborán','madrid 1365','093476123','e10adc3949ba59abbe56e057f20f883e','../../fotoTransportista/GJ18P55F1_14122.jpg','disponible'),('11111199','arnold','schwarzenegger','miami 13829','097326123','e10adc3949ba59abbe56e057f20f883e','../../fotoTransportista/descarga (2)7.jpg','no disponible'),('12121213','angela','merkel','munich 17598','435667421','e10adc3949ba59abbe56e057f20f883e','../../fotoTransportista/descarga (7).jpg','disponible'),('12312332','luis','lacalle pou','la tahona 14','093453254','e10adc3949ba59abbe56e057f20f883e','../../fotoTransportista/3268506w380.jpg','disponible'),('19191919','rafael','nadal','roland garros 3492','098635238','e10adc3949ba59abbe56e057f20f883e','../../fotoTransportista/descarga (4).jpg','disponible'),('40788375','gabriel','molina','av. agraciada 8759','093654654','e10adc3949ba59abbe56e057f20f883e','../../fotoTransportista/pp.jpg','disponible'),('43637361','noemi','batista','altos del palermo 546','092345123','e10adc3949ba59abbe56e057f20f883e','../../fotoTransportista/59933127_10219304801878575_1879756599610834944_o.jpg','disponible'),('50877306','martin','banega','lascano 234','094567235','e10adc3949ba59abbe56e057f20f883e','../../fotoTransportista/pp (1).jpg','disponible'),('51799876','santiago','ducos','solano garcia 2668','092987432','e10adc3949ba59abbe56e057f20f883e','../../fotoTransportista/Yo.jpg','no disponible'),('54545454','hannah','montana','zack y cody 7548','096758218','e10adc3949ba59abbe56e057f20f883e','../../fotoTransportista/rs_1024x818-161027110450-1024.hannah-montana.102716.jpg','disponible'),('65656565','marcelo','tinelli','bailado por un sueño 8370','098372483','e10adc3949ba59abbe56e057f20f883e','../../fotoTransportista/descarga (5).jpg','disponible'),('84374958','carolina','cosse','centro 1999','093728238','e10adc3949ba59abbe56e057f20f883e','../../fotoTransportista/descarga (6).jpg','no disponible'),('93939393','selena ','gómez','justin beber 7620','092354237','e10adc3949ba59abbe56e057f20f883e','../../fotoTransportista/selena-gomez.jpeg','disponible'),('98989898','harry','potter','colegio hogwarts 837','+59893845842','e10adc3949ba59abbe56e057f20f883e','../../fotoTransportista/descarga.jpg','disponible');
/*!40000 ALTER TABLE `transportista` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-11 16:36:11
