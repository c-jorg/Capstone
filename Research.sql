-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: Research
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities` (
  `activity_code` varchar(100) NOT NULL,
  `project_code` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `notes` mediumtext DEFAULT NULL,
  PRIMARY KEY (`activity_code`),
  KEY `Activities_Projects_FK` (`project_code`),
  CONSTRAINT `Activities_Projects_FK` FOREIGN KEY (`project_code`) REFERENCES `projects` (`project_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
INSERT INTO `activities` VALUES ('123','123',NULL,'test Activity','2026-01-01','2028-01-01',NULL),('ABC','ABC',NULL,'Test Activity','2024-01-01','2026-01-01',NULL);
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `entity_id` int(11) DEFAULT NULL,
  `project_code` varchar(100) DEFAULT NULL,
  KEY `Clients_Entities_FK` (`entity_id`),
  KEY `Clients_Projects_FK` (`project_code`),
  CONSTRAINT `Clients_Entities_FK` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`),
  CONSTRAINT `Clients_Projects_FK` FOREIGN KEY (`project_code`) REFERENCES `projects` (`project_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (5,'ABC'),(6,'123');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contractors`
--

DROP TABLE IF EXISTS `contractors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contractors` (
  `entity_id` int(11) NOT NULL,
  `activity_code` varchar(100) NOT NULL,
  `payment` decimal(10,0) DEFAULT NULL,
  `date_payed` date NOT NULL,
  PRIMARY KEY (`entity_id`,`activity_code`,`date_payed`),
  KEY `Contractors_Activities_FK` (`activity_code`),
  CONSTRAINT `Contractors_Activities_FK` FOREIGN KEY (`activity_code`) REFERENCES `activities` (`activity_code`),
  CONSTRAINT `Contractors_Entities_FK` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contractors`
--

LOCK TABLES `contractors` WRITE;
/*!40000 ALTER TABLE `contractors` DISABLE KEYS */;
INSERT INTO `contractors` VALUES (7,'ABC',10000,'2024-02-02');
/*!40000 ALTER TABLE `contractors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entities`
--

DROP TABLE IF EXISTS `entities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `salutation` varchar(10) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `category` enum('non-student','Undergraduate','Masters','PHD','Other') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entities`
--

LOCK TABLES `entities` WRITE;
/*!40000 ALTER TABLE `entities` DISABLE KEYS */;
INSERT INTO `entities` VALUES (1,'Jane','Doe','jdoe@gmail.com','MRS.',NULL,'non-student'),(2,'John','Doe','jodoe@gmail.com','DR.',NULL,'non-student'),(3,NULL,NULL,'funder1@gmail.com',NULL,'Science Company','non-student'),(4,NULL,NULL,'funder2@gmail.com',NULL,'Tech Company','non-student'),(5,NULL,NULL,'client1@gmail.com',NULL,'Science Client','non-student'),(6,NULL,NULL,'client2@gmail.com',NULL,'Tech Client','non-student'),(7,NULL,NULL,'contractor1@gmail.com',NULL,'Science Contractor','non-student'),(8,'Bob','Dob','dob@gmail.com','MR.',NULL,'Undergraduate'),(9,'Joe','Son','son@gmail.com',NULL,NULL,'Masters'),(10,'Sally','Person','sally@gmail.com','MS.',NULL,'PHD');
/*!40000 ALTER TABLE `entities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funders`
--

DROP TABLE IF EXISTS `funders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `funders` (
  `entity_id` int(11) DEFAULT NULL,
  `project_code` varchar(100) DEFAULT NULL,
  `funding_amt` decimal(10,0) DEFAULT NULL,
  `date_given` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  KEY `Funders_Entities_FK` (`entity_id`),
  KEY `Funders_Projects_FK` (`project_code`),
  CONSTRAINT `Funders_Entities_FK` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`),
  CONSTRAINT `Funders_Projects_FK` FOREIGN KEY (`project_code`) REFERENCES `projects` (`project_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funders`
--

LOCK TABLES `funders` WRITE;
/*!40000 ALTER TABLE `funders` DISABLE KEYS */;
INSERT INTO `funders` VALUES (3,'ABC',1000000,'2023-01-01','2025-01-01'),(4,'123',50000,'2026-01-01','2026-01-01');
/*!40000 ALTER TABLE `funders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(10000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (1,'test','letmein');
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `principal_researchers`
--

DROP TABLE IF EXISTS `principal_researchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `principal_researchers` (
  `entity_id` int(11) DEFAULT NULL,
  `activity_code` varchar(100) DEFAULT NULL,
  KEY `Principal_Researchers_Entities_FK` (`entity_id`),
  KEY `Principal_Researchers_Activities_FK` (`activity_code`),
  CONSTRAINT `Principal_Researchers_Activities_FK` FOREIGN KEY (`activity_code`) REFERENCES `activities` (`activity_code`),
  CONSTRAINT `Principal_Researchers_Entities_FK` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `principal_researchers`
--

LOCK TABLES `principal_researchers` WRITE;
/*!40000 ALTER TABLE `principal_researchers` DISABLE KEYS */;
/*!40000 ALTER TABLE `principal_researchers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_managers`
--

DROP TABLE IF EXISTS `project_managers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_managers` (
  `entity_id` int(11) DEFAULT NULL,
  `project_code` varchar(100) DEFAULT NULL,
  KEY `Project_Managers_Entities_FK` (`entity_id`),
  KEY `Project_Managers_Projects_FK` (`project_code`),
  CONSTRAINT `Project_Managers_Entities_FK` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`),
  CONSTRAINT `Project_Managers_Projects_FK` FOREIGN KEY (`project_code`) REFERENCES `projects` (`project_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_managers`
--

LOCK TABLES `project_managers` WRITE;
/*!40000 ALTER TABLE `project_managers` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_managers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `project_code` varchar(100) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `stage` enum('Ideation','Proposal in Progress','Awaiting Funding','In Progress','Completed - Not Signed Off','Completed - Signed Off') DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`project_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES ('123','project 2','test Projects','Awaiting Funding','Tech','2026-01-01','2028-01-01'),('ABC','projects 1','test Projects','In Progress','Science','2024-01-01','2026-01-01');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `researchers`
--

DROP TABLE IF EXISTS `researchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `researchers` (
  `entity_id` int(11) DEFAULT NULL,
  `activity_code` varchar(100) DEFAULT NULL,
  KEY `Researchers_Entities_FK` (`entity_id`),
  KEY `Researchers_Activities_FK` (`activity_code`),
  CONSTRAINT `Researchers_Activities_FK` FOREIGN KEY (`activity_code`) REFERENCES `activities` (`activity_code`),
  CONSTRAINT `Researchers_Entities_FK` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `researchers`
--

LOCK TABLES `researchers` WRITE;
/*!40000 ALTER TABLE `researchers` DISABLE KEYS */;
INSERT INTO `researchers` VALUES (8,'123'),(9,'123'),(9,'abc');
/*!40000 ALTER TABLE `researchers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-20 16:20:15
