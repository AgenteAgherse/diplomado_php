CREATE DATABASE  IF NOT EXISTS `proyecto_final` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `proyecto_final`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: proyecto_final
-- ------------------------------------------------------
-- Server version	8.0.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `actividades`
--

DROP TABLE IF EXISTS `actividades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `actividades` (
  `Id_actividad` int NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(255) NOT NULL,
  `Fecha_inicio` date NOT NULL,
  `Fecha_final` date NOT NULL,
  `Id_proyecto` int NOT NULL,
  `Responsable` int DEFAULT NULL,
  `Estado` varchar(50) NOT NULL,
  `Presupuesto` decimal(10,2) NOT NULL,
  PRIMARY KEY (`Id_actividad`),
  KEY `Id_proyecto` (`Id_proyecto`),
  CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`Id_proyecto`) REFERENCES `proyectos` (`Id_proyecto`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividades`
--

LOCK TABLES `actividades` WRITE;
/*!40000 ALTER TABLE `actividades` DISABLE KEYS */;
INSERT INTO `actividades` VALUES (4,'Generación de Peticiones HTTP','2024-05-29','2024-06-07',5,8,'Finalizado',12000.00),(5,'Generación de una API REST con PHP y Vue','2024-05-28','2024-05-28',5,8,'Finalizado',12000.00),(6,'Ninguna','2000-05-27','2024-05-27',6,8,'Finalizado',12000.00),(7,'Procesamiento de bases de datos con MySQL','2024-05-29','2024-05-30',5,8,'Finalizado',21000.00),(8,'Actividad 1','2024-06-06','2024-05-07',7,8,'Finalizado',120000.00),(9,'nueva','2025-05-10','2025-05-10',7,8,'Finalizado',320000.00),(10,'1230931','2025-05-05','2025-05-05',8,8,'Finalizado',210000.00),(11,'Generación de Geografía','2024-05-05','2024-12-12',8,8,'En Curso',210000.00),(12,'Análisis de huesos','2024-06-01','2025-06-08',8,8,'Proximamente',120000.00),(13,'Creación De Una API REST','2024-05-14','2024-06-06',10,14,'Finalizado',320000.00),(14,'Uso de Sesiones Con PHP','2024-06-06','2024-12-12',10,14,'Finalizado',500000.00),(15,'Nueva Actividad','2024-06-06','2024-06-06',11,14,'Finalizado',120000.00);
/*!40000 ALTER TABLE `actividades` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `actividades_BEFORE_INSERT` BEFORE INSERT ON `actividades` FOR EACH ROW BEGIN
	SET @responsable = 0;
    SELECT Responsable INTO @responsable FROM proyecto_final.proyectos WHERE Id_proyecto = new.id_proyecto;
    SET new.Responsable = @responsable;
    
    IF new.fecha_inicio <= CURDATE() THEN
		IF new.fecha_final >= CURDATE() THEN
			SET new.estado = 'En Curso';
		else
			SET new.estado = 'No cumplido';
		END IF;
	ELSE
		SET new.estado = 'Proximamente';
	END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `personas`
--

DROP TABLE IF EXISTS `personas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personas` (
  `Id_persona` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Apellidos` varchar(100) NOT NULL,
  `Direccion` varchar(255) NOT NULL,
  `Telefono` varchar(20) NOT NULL,
  `Sexo` varchar(10) NOT NULL,
  `Fecha_nacimiento` date NOT NULL,
  `Profesion` varchar(100) NOT NULL,
  `identificacion` varchar(12) NOT NULL,
  `email` text,
  `password` text,
  PRIMARY KEY (`Id_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personas`
--

LOCK TABLES `personas` WRITE;
/*!40000 ALTER TABLE `personas` DISABLE KEYS */;
INSERT INTO `personas` VALUES (8,'Agustín','Hernández','Calle 50#14D-91','3012733067','masculino','2001-01-13','Estudiante','1003405011','agus.hdez2011@gmail.com','e51385acd8e9c8275aa0bfb68abbc53b69b32198'),(13,'Juan','Lozano','Calle 1#1-1','3000000','masculino','2000-01-01','Profesor','10',NULL,NULL),(14,'Agustín','Hernández','Calle 50#15-92','3023600696','masculino','2001-01-13','Desarrollador','10','ahernandez@gmail.com','8c31b65bdecdc9f18b695d7318186fd1feed690d'),(15,'Andrés','Cépeda','Calle 1#1-1','301239102','masculino','1985-01-01','Músico','101010',NULL,NULL);
/*!40000 ALTER TABLE `personas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyectos`
--

DROP TABLE IF EXISTS `proyectos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proyectos` (
  `Id_proyecto` int NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(255) NOT NULL,
  `Fecha_inicio` date NOT NULL,
  `Fecha_entrega` date NOT NULL,
  `Valor` decimal(10,2) NOT NULL,
  `Lugar` varchar(255) NOT NULL,
  `Responsable` varchar(255) NOT NULL,
  `Estado` varchar(50) DEFAULT NULL,
  `titulo` text NOT NULL,
  PRIMARY KEY (`Id_proyecto`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectos`
--

LOCK TABLES `proyectos` WRITE;
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT INTO `proyectos` VALUES (5,'Primera Descripción','2024-05-26','2024-08-01',3000000.00,'Montería','8','Finalizado','Primer Título'),(6,'Primera Descripción','2024-05-28','2024-08-01',3000000.00,'Montería','8','Finalizado','Primer Título'),(7,'Primera Descripción','2024-05-28','2024-08-01',3000000.00,'Montería','8','Finalizado','Tercer Título'),(8,'Descripción 4','2001-01-13','2025-12-12',1200000.00,'Montería','8','En Curso','Titulo 4'),(9,'Proyecto Demorado','2024-05-25','2024-05-26',200000.00,'Montería','8','No cumplido','Proyecto Demorado'),(10,'Segundo Módulo de Diplomado con PHP','2024-05-01','2024-06-06',320000.00,'Montería','14','Finalizado','Proyecto Diplomado'),(11,'Proyecto 2','2024-05-19','2024-05-27',450000.00,'Virtual','14','No cumplido','Proyecto 2');
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `proyectos_BEFORE_INSERT` BEFORE INSERT ON `proyectos` FOR EACH ROW BEGIN
IF new.fecha_inicio <= CURDATE() THEN
	IF new.fecha_entrega >= CURDATE() THEN
		SET new.estado = 'En Curso';
	else
		SET new.estado = 'No cumplido';
    END IF;
ELSE
	SET new.estado = 'Proximamente';
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `recursos`
--

DROP TABLE IF EXISTS `recursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recursos` (
  `Id_recurso` int NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(255) NOT NULL,
  `Valor` decimal(10,2) NOT NULL,
  `Unidad_de_medida` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_recurso`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recursos`
--

LOCK TABLES `recursos` WRITE;
/*!40000 ALTER TABLE `recursos` DISABLE KEYS */;
INSERT INTO `recursos` VALUES (1,'Botella Agua',2500.00,'lt'),(2,'Carne Asada',25000.00,'gr'),(3,'Cable HDMI',15000.00,'1m');
/*!40000 ALTER TABLE `recursos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tareas`
--

DROP TABLE IF EXISTS `tareas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tareas` (
  `Id_tarea` int NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(255) NOT NULL,
  `Fecha_inicio` date NOT NULL,
  `Fecha_final` date NOT NULL,
  `Id_actividad` int NOT NULL,
  `Estado` varchar(50) NOT NULL,
  `Presupuesto` decimal(10,2) NOT NULL,
  PRIMARY KEY (`Id_tarea`),
  KEY `Id_actividad` (`Id_actividad`),
  CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`Id_actividad`) REFERENCES `actividades` (`Id_actividad`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tareas`
--

LOCK TABLES `tareas` WRITE;
/*!40000 ALTER TABLE `tareas` DISABLE KEYS */;
INSERT INTO `tareas` VALUES (1,'Nueva Tarea','2024-05-28','2024-05-29',5,'En Curso',4.00),(2,'Tarea 2','2024-05-28','2024-05-08',4,'Finalizado',120000.00),(3,'Tarea 3','2021-05-29','2024-05-29',4,'En Curso',210000.00),(4,'Tarea 1','2024-05-30','2024-05-30',7,'Finalizado',21000.00),(5,'Generación de Tarea 1','2024-05-29','2024-05-30',8,'En Curso',120005.00),(6,'nUEVA','2025-01-01','2025-01-10',9,'Proximamente',120000.00),(7,'12390','2025-01-01','2025-01-01',9,'Proximamente',91000.00),(8,'Otra Tarea','2025-05-05','2025-05-05',10,'Proximamente',21001.00),(9,'Búsqueda de huesos','2024-05-01','2024-12-30',11,'En Curso',30000.00),(10,'Uso de Ácidos','2024-07-07','2024-07-08',12,'Proximamente',21000.00),(11,'Actividad Entregable bd','2024-06-06','2024-07-07',14,'Proximamente',25000.00),(12,'Nueva','2024-06-06','2024-06-06',15,'Proximamente',2100.00),(13,'Cambiano Cambirnao','2024-02-02','2024-02-02',15,'No cumplido',2100.00);
/*!40000 ALTER TABLE `tareas` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tareas_BEFORE_INSERT` BEFORE INSERT ON `tareas` FOR EACH ROW BEGIN
IF new.fecha_inicio <= CURDATE() THEN
	IF new.fecha_final >= CURDATE() THEN
		SET new.estado = 'En Curso';
	else
		SET new.estado = 'No cumplido';
    END IF;
ELSE
	SET new.estado = 'Proximamente';
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tareaxpersona`
--

DROP TABLE IF EXISTS `tareaxpersona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tareaxpersona` (
  `Id_tarea` int NOT NULL,
  `Id_persona` int NOT NULL,
  `Duracion` decimal(10,2) NOT NULL,
  PRIMARY KEY (`Id_tarea`,`Id_persona`),
  KEY `Id_persona` (`Id_persona`),
  CONSTRAINT `tareaxpersona_ibfk_1` FOREIGN KEY (`Id_tarea`) REFERENCES `tareas` (`Id_tarea`),
  CONSTRAINT `tareaxpersona_ibfk_2` FOREIGN KEY (`Id_persona`) REFERENCES `personas` (`Id_persona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tareaxpersona`
--

LOCK TABLES `tareaxpersona` WRITE;
/*!40000 ALTER TABLE `tareaxpersona` DISABLE KEYS */;
INSERT INTO `tareaxpersona` VALUES (9,13,4.00),(10,13,3.00),(11,15,3.00),(12,13,3.00),(13,13,6.00);
/*!40000 ALTER TABLE `tareaxpersona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tareaxrecurso`
--

DROP TABLE IF EXISTS `tareaxrecurso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tareaxrecurso` (
  `Id_tarea` int NOT NULL,
  `Id_recurso` int NOT NULL,
  `Cantidad` decimal(10,2) NOT NULL,
  PRIMARY KEY (`Id_tarea`,`Id_recurso`),
  KEY `Id_recurso` (`Id_recurso`),
  CONSTRAINT `tareaxrecurso_ibfk_1` FOREIGN KEY (`Id_tarea`) REFERENCES `tareas` (`Id_tarea`),
  CONSTRAINT `tareaxrecurso_ibfk_2` FOREIGN KEY (`Id_recurso`) REFERENCES `recursos` (`Id_recurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tareaxrecurso`
--

LOCK TABLES `tareaxrecurso` WRITE;
/*!40000 ALTER TABLE `tareaxrecurso` DISABLE KEYS */;
INSERT INTO `tareaxrecurso` VALUES (9,1,15.00),(10,1,12.00),(11,1,3.00),(13,1,12.00);
/*!40000 ALTER TABLE `tareaxrecurso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'proyecto_final'
--
/*!50106 SET @save_time_zone= @@TIME_ZONE */ ;
/*!50106 DROP EVENT IF EXISTS `actualizar_estados` */;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8mb4 */ ;;
/*!50003 SET character_set_results = utf8mb4 */ ;;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`root`@`localhost`*/ /*!50106 EVENT `actualizar_estados` ON SCHEDULE EVERY 1 DAY STARTS '2024-05-27 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL actualizar_estado_proyecto() */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
/*!50106 DROP EVENT IF EXISTS `actualizar_estados_actividades` */;;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8mb4 */ ;;
/*!50003 SET character_set_results = utf8mb4 */ ;;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`root`@`localhost`*/ /*!50106 EVENT `actualizar_estados_actividades` ON SCHEDULE EVERY 1 DAY STARTS '2024-05-27 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL actualizar_estado_actividad() */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
/*!50106 DROP EVENT IF EXISTS `actualizar_estados_tareas` */;;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8mb4 */ ;;
/*!50003 SET character_set_results = utf8mb4 */ ;;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`root`@`localhost`*/ /*!50106 EVENT `actualizar_estados_tareas` ON SCHEDULE EVERY 1 DAY STARTS '2024-05-27 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL actualizar_estado_tarea() */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
DELIMITER ;
/*!50106 SET TIME_ZONE= @save_time_zone */ ;

--
-- Dumping routines for database 'proyecto_final'
--
/*!50003 DROP PROCEDURE IF EXISTS `actualizar_estado_actividad` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_estado_actividad`()
BEGIN
	UPDATE actividades SET estado = 'No Cumplido' WHERE estado = 'En Curso' AND fecha_final < CURDATE();
	UPDATE actividades SET estado = 'En Curso' WHERE estado = 'Proximamente' AND fecha_inicio = CURDATE();
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `actualizar_estado_proyecto` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_estado_proyecto`()
BEGIN
 UPDATE proyectos SET estado = 'No Cumplido' WHERE estado = 'En Curso' AND fecha_entrega < CURDATE();
 UPDATE proyectos SET estado = 'En Curso' WHERE estado = 'Proximamente' AND fecha_inicio = CURDATE();
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `actualizar_estado_tarea` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_estado_tarea`()
BEGIN
	UPDATE tareas SET estado = 'No Cumplido' WHERE estado = 'En Curso' AND fecha_final < CURDATE();
	UPDATE tareas SET estado = 'En Curso' WHERE estado = 'Proximamente' AND fecha_inicio = CURDATE();
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `presupuesto_gastado` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `presupuesto_gastado`(IN proyecto INT)
BEGIN
	SELECT SUM(gastado) AS gastado FROM actividades
		JOIN (SELECT id_actividad, SUM(presupuesto) AS gastado FROM tareas GROUP BY id_actividad) as gastado
		ON gastado.id_actividad = actividades.id_actividad
	WHERE id_proyecto = proyecto; # Presupuesto del Proyecto Gastado
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `progreso_actividad` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `progreso_actividad`(IN proyecto INT)
BEGIN
	SELECT finalizados/total*100 AS progreso FROM (SELECT 
	(SELECT COUNT(*) FROM actividades WHERE id_proyecto = proyecto AND estado = 'Finalizado') AS finalizados,
    (SELECT COUNT(*) FROM actividades WHERE id_proyecto = proyecto) AS total) AS datos; # porcentaje de progreso
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-29 12:08:37
