/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Base de datos: `university`
--
CREATE DATABASE `university` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `course` (
  `CourseID` varchar(6) NOT NULL,
  `course` char(10) DEFAULT NULL,
  `credit` int(1) DEFAULT NULL,
  PRIMARY KEY (`CourseID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES ('IoT101','IoT',2),('IoT102','SQL',3),('IoT103','Networking',3),('IoT104','JAVA',1),('IoT105','BigData',3);
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `department` (
  `DeptID` varchar(7) NOT NULL,
  `dname` char(20) DEFAULT NULL,
  PRIMARY KEY (`DeptID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES ('D-01','PCS'),('D-02','Maths'),('D-03','Zoology'),('D-04','Chemistry'),('D-05','Mechanical');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `employee` (
  `EmpID` varchar(7) NOT NULL,
  `ename` char(20) DEFAULT NULL,
  `spec` char(10) DEFAULT NULL,
  `FacID` varchar(7) NOT NULL,
  `DeptID` varchar(7) NOT NULL,
  PRIMARY KEY (`EmpID`,`FacID`,`DeptID`),
  KEY `FacID` (`FacID`),
  KEY `DeptID` (`DeptID`),
  CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`FacID`) REFERENCES `faculty` (`FacID`),
  CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`DeptID`) REFERENCES `department` (`DeptID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES ('E-01','RAM','JAVA','F-01','D-01'),('E-02','SHYAM','Big Data','F-02','D-02'),('E-03','PARIMAL','Networking','F-03','D-03'),('E-04','Prem','SQL','F-04','D-04'),('E-05','Sagar','IoT','F-05','D-05');
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enroll`
--

DROP TABLE IF EXISTS `enroll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `enroll` (
  `RollNo` varchar(7) DEFAULT NULL,
  `CourseID` varchar(6) DEFAULT NULL,
  `marks` int(3) DEFAULT NULL,
  KEY `RollNo` (`RollNo`),
  KEY `CourseID` (`CourseID`),
  CONSTRAINT `enroll_ibfk_1` FOREIGN KEY (`RollNo`) REFERENCES `student` (`RollNo`),
  CONSTRAINT `enroll_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `course` (`CourseID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enroll`
--

LOCK TABLES `enroll` WRITE;
/*!40000 ALTER TABLE `enroll` DISABLE KEYS */;
INSERT INTO `enroll` VALUES ('1703667','IoT101',70),('1703668','IoT102',110),('1703669','IoT103',120),('1703671','IoT104',90),('1703672','IoT105',150);
/*!40000 ALTER TABLE `enroll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faculty`
--

DROP TABLE IF EXISTS `faculty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `faculty` (
  `FacID` varchar(7) NOT NULL,
  `fname` char(20) DEFAULT NULL,
  PRIMARY KEY (`FacID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculty`
--

LOCK TABLES `faculty` WRITE;
/*!40000 ALTER TABLE `faculty` DISABLE KEYS */;
INSERT INTO `faculty` VALUES ('F-01','Science'),('F-02','Engineering'),('F-03','Technical'),('F-04','Commerce'),('F-05','SocialScience');
/*!40000 ALTER TABLE `faculty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mentor`
--

DROP TABLE IF EXISTS `mentor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `mentor` (
  `RollNo` varchar(7) NOT NULL,
  `FacID` varchar(7) NOT NULL,
  PRIMARY KEY (`RollNo`,`FacID`),
  KEY `FacID` (`FacID`),
  CONSTRAINT `mentor_ibfk_1` FOREIGN KEY (`RollNo`) REFERENCES `student` (`RollNo`),
  CONSTRAINT `mentor_ibfk_2` FOREIGN KEY (`FacID`) REFERENCES `faculty` (`FacID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mentor`
--

LOCK TABLES `mentor` WRITE;
/*!40000 ALTER TABLE `mentor` DISABLE KEYS */;
INSERT INTO `mentor` VALUES ('1703667','F-01'),('1703668','F-02'),('1703669','F-03'),('1703671','F-04'),('1703672','F-05');
/*!40000 ALTER TABLE `mentor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `student` (
  `RollNo` varchar(7) NOT NULL,
  `Name` char(50) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  PRIMARY KEY (`RollNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES ('1703667','Ankit Birla','Kasganj','2000-11-02'),('1703668','Ankit Singh','Agra','2000-01-04'),('1703669','Aman','Shamshabad','2000-08-20'),('1703671','Abhishek','Delhi','2000-04-18'),('1703672','Ayush','Bombay','2000-08-30');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teach`
--

DROP TABLE IF EXISTS `teach`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `teach` (
  `CourseID` varchar(6) NOT NULL,
  `FacID` varchar(7) NOT NULL,
  PRIMARY KEY (`CourseID`,`FacID`),
  KEY `FacID` (`FacID`),
  CONSTRAINT `teach_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `course` (`CourseID`),
  CONSTRAINT `teach_ibfk_2` FOREIGN KEY (`FacID`) REFERENCES `faculty` (`FacID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teach`
--

LOCK TABLES `teach` WRITE;
/*!40000 ALTER TABLE `teach` DISABLE KEYS */;
INSERT INTO `teach` VALUES ('IoT101','F-01'),('IoT102','F-02'),('IoT103','F-03'),('IoT104','F-04'),('IoT105','F-05');
/*!40000 ALTER TABLE `teach` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;



--
-- Base de datos: `student`
--
CREATE DATABASE `student` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE Student (

        STU_NUM char(6) NOT NULL,
        STU_SNAME varchar(15),
        STU_FNAME varchar(15),
        STU_INITIAL char(1),
        STU_STARTDATE date,
        COURSE_CODE char(3),
        PROJ_NUM int(2),
    PRIMARY KEY (STU_NUM)
);

INSERT INTO Student
VALUES ( '01', 'Snow' , 'John', 'E', DATE('05-Apr-2014', 'DD-Mon-YYYY'), '201', 6);

INSERT INTO Student
 VALUES ( '02', 'Stark' , 'Arya', 'C', DATE('12-Jul-2017', 'DD-Mon-YYYY'), '305', 11);





--
-- Base de datos: `exam`
--
CREATE DATABASE `exam` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `user_login`
(
 id       int NOT NULL AUTO_INCREMENT ,
 username varchar(45) NOT NULL ,
 password varchar(45) NOT NULL ,

PRIMARY KEY (`id`)
) AUTO_INCREMENT=1;

CREATE TABLE `user_account`
(
 `id`             int NOT NULL AUTO_INCREMENT ,
 `balance`        bigint NOT NULL ,
 `account_number` bigint NOT NULL ,
 `account_type`   tinyint NOT NULL ,
 `user_info_id`   int NOT NULL ,

PRIMARY KEY (`id`),
KEY `user_info_account` (`user_info_id`),
CONSTRAINT `user_info_has_account` FOREIGN KEY `user_info_account` (`user_info_id`) REFERENCES `user_info` (`id`)
) AUTO_INCREMENT=1;

CREATE TABLE `user_info`
(
 `id`               int NOT NULL AUTO_INCREMENT ,
 `firstname`        varchar(45) NOT NULL ,
 `lastname`         varchar(45) NOT NULL ,
 `address`          varchar(45) NOT NULL ,
 `cellphone_number` bigint NOT NULL ,
 `email`            varchar(45) NOT NULL ,
 `user_login_id`    int NOT NULL ,

PRIMARY KEY (`id`),
KEY `user_login_info` (`user_login_id`),
CONSTRAINT `user_login_has_info` FOREIGN KEY `user_login_info` (`user_login_id`) REFERENCES `user_login` (`id`)
) AUTO_INCREMENT=1;

CREATE TABLE `transactions` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `transaction_sender` BIGINT NOT NULL,
    `transaction_recipient` BIGINT NOT NULL,
    `user_account_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_account_transactions` (`user_account_id`),
    CONSTRAINT `user_account_has_transactions` FOREIGN KEY (`user_account_id`)
        REFERENCES `user_account` (`id`)
)  AUTO_INCREMENT=1;

SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
