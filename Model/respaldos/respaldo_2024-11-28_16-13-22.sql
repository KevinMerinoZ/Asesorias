-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: dbasesorias
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
-- Table structure for table `alumno`
--

DROP TABLE IF EXISTS `alumno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumno` (
  `matricula` varchar(11) NOT NULL COMMENT 'Este atributo almacena la matricula del usuario',
  `contrasenia` varchar(45) NOT NULL COMMENT 'Este atributo almacena la contrasenia del usuario',
  `nombre` varchar(45) NOT NULL COMMENT 'Este atributo almacena el nombre o los nombres del usuario',
  `apellidoP` varchar(45) NOT NULL COMMENT 'Este atributo almacena el apellido paterno del usuario',
  `apellidoM` varchar(45) NOT NULL COMMENT 'Este atributo almacena el apellido materlo del usuario',
  `genero` varchar(15) NOT NULL COMMENT 'Este atributo almacena el genero del usuario',
  `carrera` varchar(6) NOT NULL COMMENT 'Este atributo almacena la carrera que cursa el alumno.',
  `grado` int(11) NOT NULL COMMENT 'Este atributo almacena el grado en el que se encuentra el alumno.',
  `grupo` char(1) NOT NULL COMMENT 'Este atributo almacena el grupo en el que se encuentra el alumno.',
  `existencia` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`matricula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumno`
--

LOCK TABLES `alumno` WRITE;
/*!40000 ALTER TABLE `alumno` DISABLE KEYS */;
INSERT INTO `alumno` VALUES ('ajjo654321','AJJO654321','Juana','Arzate','Buena Vista','Femenino','ITI',7,'B',1),('APJO221234','apjo221234','Jacqueline','Avilez','Perez','Femenino','ITI',7,'D',1),('ggco123456','GGCO221851','Carlos','Guerrero','Garcia','Masculino','ITI',4,'C',1),('ldlo345678','LDLO345678','Luis','Diaz','Lopez','Masculino','ITI',8,'E',1),('mcko221851','MCKO221851','Kevin Joel','Merino','Castillo','Masculino','ITI',7,'D',1),('rpdo987654','RPDO987654','Lizeth','Perez','Dominguez','Femenino','ITI',6,'A',0);
/*!40000 ALTER TABLE `alumno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asignatura`
--

DROP TABLE IF EXISTS `asignatura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asignatura` (
  `idAsignatura` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Este atributo almacena el identificador de la asignatura',
  `nombre` varchar(45) NOT NULL COMMENT 'Este atributo almacena el nombre de la asignatura.',
  `siglas` varchar(5) NOT NULL COMMENT 'Este atributo almacena las siglas de abreviaci?n de la asignatura',
  `descripcion` text NOT NULL COMMENT 'Este atributo almacena la descripcion de la asignatura.',
  `existencia` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idAsignatura`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asignatura`
--

LOCK TABLES `asignatura` WRITE;
/*!40000 ALTER TABLE `asignatura` DISABLE KEYS */;
INSERT INTO `asignatura` VALUES (1,'Ingles','ING','Asignatura de ingles',1),(2,'Programacion','PRG','Asignatura de Programacion',1),(3,'Matematicas','MTA','Asignatura de Matematicas',1),(4,'Fisica','FIS','Asignatura de Fisica',1),(5,'Quimica','QUI','Asignatura de Quimica',1),(6,'Historia','HIS','Asignatura de Historia',1),(7,'Biologia','BIO','Asignatura de Biologia',1),(8,'Literatura','LIT','Asignatura de Literatura',1),(9,'Geografia','GEO','Asignatura de Geografia',1),(10,'Etica','ETI','Asignatura de Etica',1),(11,'Educacion Fisica','EDF','Asignatura de Educacion Fisica',1),(12,'Ingeniería de requisitos','IR','Asignatura de Ingenieriaequisitos',0),(13,'Liderazgo ','LE','Asignatura de liderazgo de equipos',0),(14,'Liderazgo de equipos','LE','Asignatura de Liderazgo',0),(15,'','','',0),(16,'','','',0),(17,'Liderazgo de equipos','L','aa',0),(18,'Ingles','ING','aaaa',0),(19,'Ingles','ING','a',0);
/*!40000 ALTER TABLE `asignatura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cita`
--

DROP TABLE IF EXISTS `cita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cita` (
  `idCita` int(11) NOT NULL AUTO_INCREMENT,
  `tema` varchar(100) NOT NULL COMMENT 'Este atributo almacena el tema del que el alumno quiere tratar en la asesoria.',
  `detalles` text NOT NULL COMMENT 'Este atributo almacena algunos detalles que el alumno quiera comentarle al profesor.',
  `fechaEnvio` date NOT NULL COMMENT 'Este atributo almacena la fecha en la que se envia la cita al profesor.',
  `fechaEstado` date DEFAULT NULL COMMENT 'Este atributo almacena la fecha en la que la cita es aceptada o rechazada por el profesor.',
  `estado` varchar(10) NOT NULL COMMENT 'Este atributo almacena si la cita esta Pendiente, Aceptada o Rechazada.',
  `existencia` tinyint(4) NOT NULL DEFAULT 1,
  `ProfesorAsignatura_Profesor_matricula` varchar(11) NOT NULL COMMENT 'Este atributo almacena el identificador del profesor al que va diriga la cita.',
  `ProfesorAsignatura_Asignatura_idAsignatura` int(11) NOT NULL COMMENT 'Este atributo almacena la asignatura que el profesor va a atender en la cita.',
  `Nota_idNota` int(11) DEFAULT NULL,
  `Alumno_matricula` varchar(11) NOT NULL,
  PRIMARY KEY (`idCita`),
  KEY `fk_Cita_ProfesorAsignatura1` (`ProfesorAsignatura_Profesor_matricula`,`ProfesorAsignatura_Asignatura_idAsignatura`),
  KEY `fk_Cita_Alumno1` (`Alumno_matricula`),
  KEY `fk_Cita_Nota1` (`Nota_idNota`),
  CONSTRAINT `fk_Cita_Alumno1` FOREIGN KEY (`Alumno_matricula`) REFERENCES `alumno` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cita_Nota1` FOREIGN KEY (`Nota_idNota`) REFERENCES `nota` (`idNota`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cita_ProfesorAsignatura1` FOREIGN KEY (`ProfesorAsignatura_Profesor_matricula`, `ProfesorAsignatura_Asignatura_idAsignatura`) REFERENCES `profesorasignatura` (`Profesor_matricula`, `Asignatura_idAsignatura`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cita`
--

LOCK TABLES `cita` WRITE;
/*!40000 ALTER TABLE `cita` DISABLE KEYS */;
INSERT INTO `cita` VALUES (1,'Algebra','ver el tema de algebra','2024-09-24','2024-09-25','Aceptado',1,'juva567890',2,NULL,'mcko221851'),(2,'Programacion basica','Resolver ejercicios de logica y sintaxis','2024-08-15','2024-09-16','Aceptado',1,'mcjo123456',3,NULL,'ggco123456'),(3,'Historia','Estudiar el periodo de la Revolucion','2024-09-20','2024-09-22','Aceptado',1,'frma345678',4,NULL,'ajjo654321'),(4,'Quimica organica','Entender estructuras de compuestos','2024-10-01','2024-10-02','Aceptado',1,'aglo234567',5,NULL,'rpdo987654'),(5,'Fisica','Resolver problemas de cinematica','2024-10-05','2024-10-06','Pendiente',1,'mapi456789',6,NULL,'ldlo345678'),(6,'Biologia','Estudiar genetica basica','2024-06-10','2024-06-11','Aceptado',1,'clro678901',7,NULL,'mcko221851'),(7,'Educacion Fisica','Planificar una rutina de ejercicio','2024-10-12','2024-10-13','Pendiente',1,'juva567890',8,NULL,'ggco123456'),(8,'Literatura','Analizar un poema contemporaneo','2024-04-15','2024-04-16','Aceptado',1,'mcjo123456',9,NULL,'ajjo654321'),(9,'Geografia','Comprender la tectonica de placas','2024-03-20','2024-03-21','Aceptado',1,'aglo234567',10,NULL,'rpdo987654'),(10,'Matematicas','Resolver problemas de algebra lineal','2024-01-25','2024-01-26','Rechazado',1,'frma345678',4,NULL,'ldlo345678'),(11,'Biologia','Algebra basica','2024-06-20','2024-06-21','Aceptado',1,'clro678901',7,NULL,'ldlo345678'),(12,'Biologia','Biologia basica','2024-07-20','2024-07-21','Aceptado',1,'clro678901',7,NULL,'rpdo987654'),(13,'Algebra','ver el tema de algebra','2024-11-24','2024-11-25','Aceptado',0,'juva567890',2,NULL,'mcko221851'),(14,'Liderazgo de equipos','Introducir al tema de Liderazgo ','2024-11-26',NULL,'Pendiente',0,'aglo234567',10,NULL,'mcko221851'),(15,'AA','AA','2024-11-26','2024-11-26','Aceptar',0,'pcfo123456',2,NULL,'mcko221851'),(16,'Q','Q','2024-11-26','2024-11-26','Rechazado',0,'pcfo123456',2,NULL,'mcko221851'),(17,'S','S','2024-11-26','2024-11-26','Aceptado',0,'pcfo123456',2,NULL,'mcko221851'),(18,'O','P','2024-11-26','2024-11-26','Aceptada',0,'pcfo123456',2,NULL,'mcko221851'),(19,'mateEE','a','2024-11-26','2024-11-26','Rechazada',0,'pcfo123456',2,NULL,'mcko221851'),(20,'Quimicaa','A','2024-11-26',NULL,'Pendiente',0,'pcfo123456',2,NULL,'mcko221851'),(21,'POO','introducir al tema','2024-11-26','2024-11-26','Aceptada',1,'pcfo123456',2,14,'mcko221851'),(22,'estructura de datos','ver tema','2024-11-26','2024-11-26','Rechazada',0,'pcfo123456',2,NULL,'mcko221851'),(23,'estructura de datos','asasaass','2024-11-27','0000-00-00','Pendiente',0,'pcfo123456',2,NULL,'mcko221851');
/*!40000 ALTER TABLE `cita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directivo`
--

DROP TABLE IF EXISTS `directivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directivo` (
  `matricula` varchar(11) NOT NULL COMMENT 'Este atributo almacena la matricula del usuario',
  `contrasenia` varchar(45) NOT NULL COMMENT 'Este atributo almacena la contrasenia del usuario',
  `nombre` varchar(45) NOT NULL COMMENT 'Este atributo almacena el nombre o los nombres del usuario',
  `apellidoP` varchar(45) NOT NULL COMMENT 'Este atributo almacena el apellido paterno del usuario',
  `apellidoM` varchar(45) NOT NULL COMMENT 'Este atributo almacena el apellido materlo del usuario',
  `genero` varchar(15) NOT NULL COMMENT 'Este atributo almacena el genero del usuario',
  `departamento` varchar(150) NOT NULL COMMENT 'Este atributo almacena el departamento del que est? a cargo el directivo',
  `noProfesores` int(11) NOT NULL COMMENT 'Este atributo almacena la cantidad de profesores que el directivo tiene a cargo\\\\\\\\n',
  `existencia` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`matricula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directivo`
--

LOCK TABLES `directivo` WRITE;
/*!40000 ALTER TABLE `directivo` DISABLE KEYS */;
INSERT INTO `directivo` VALUES ('a','a','a','a','a','Femenino','1',2,1),('b','a','a','a','a','Femenino','1',2,1),('gblo654321','GBLO654321','Luis Miguel','Gallego','Basteri','Masculino','Departamento de ITI',1,1),('z','a','a','a','a','Femenino','1',2,1);
/*!40000 ALTER TABLE `directivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disponibilidad`
--

DROP TABLE IF EXISTS `disponibilidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disponibilidad` (
  `idDisponibilidad` int(11) NOT NULL AUTO_INCREMENT,
  `periodo` varchar(45) NOT NULL COMMENT 'Este atributo almacena el periodo en el que se encuentra la disponibilidad.',
  `Lunes` varchar(45) NOT NULL COMMENT 'Este atributo almacena el rango de horas en las que estara disponible el profesor el dia lunes.',
  `martes` varchar(45) NOT NULL COMMENT 'Este atributo almacena el rango de horas en las que estara disponible el profesor el dia martes.',
  `miercoles` varchar(45) NOT NULL COMMENT 'Este atributo almacena el rango de horas en las que estara disponible el profesor el dia miercoles.',
  `jueves` varchar(45) NOT NULL COMMENT 'Este atributo almacena el rango de horas en las que estara disponible el profesor el dia jueves.',
  `viernes` varchar(45) NOT NULL COMMENT 'Este atributo almacena el rango de horas en las que estara disponible el profesor el dia viernes.',
  `existencia` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idDisponibilidad`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disponibilidad`
--

LOCK TABLES `disponibilidad` WRITE;
/*!40000 ALTER TABLE `disponibilidad` DISABLE KEYS */;
INSERT INTO `disponibilidad` VALUES (1,'Otono','10:00-14:00','13:00-18:00','12:00-20:00','15:00-17:00','10:00-14:00',1),(2,'Primavera','10:00-11:00','10:00-15:00','10:00-15:00','10:00-15:00','10:00-15:00',1),(3,'Otoño','10:00-11:00','10:00-15:00','10:00-15:00','10:00-15:00','10:00-15:00',1),(4,'Invierno','10:00-12:00','10:00-15:00','10:00-15:00','10:00-15:00','10:00-15:00',0);
/*!40000 ALTER TABLE `disponibilidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formato`
--

DROP TABLE IF EXISTS `formato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formato` (
  `idFormato` int(11) NOT NULL AUTO_INCREMENT,
  `archivo` varchar(150) NOT NULL COMMENT 'Este atributo almacena el url de donde se encuentra el archivo del formato.',
  `fechaModificacion` date NOT NULL COMMENT 'Este atributo almacena la fecha en la que se le realizo una modificaci?n.',
  `fechaCreacion` date NOT NULL COMMENT 'Este atributo almacena la fecha en la que se creo el archivo del formato.',
  `Profesor_matricula` varchar(11) NOT NULL COMMENT 'Este atributo almacena el identificador del profesor que realizo alguna accion para el formato.',
  `existencia` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idFormato`),
  KEY `fk_Formato_Profesor1` (`Profesor_matricula`),
  CONSTRAINT `fk_Formato_Profesor1` FOREIGN KEY (`Profesor_matricula`) REFERENCES `profesor` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formato`
--

LOCK TABLES `formato` WRITE;
/*!40000 ALTER TABLE `formato` DISABLE KEYS */;
/*!40000 ALTER TABLE `formato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materialcompartido`
--

DROP TABLE IF EXISTS `materialcompartido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materialcompartido` (
  `idmaterialCompartido` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL COMMENT 'Este atributo almacena el titulo del material compartido.',
  `archivo` varchar(150) NOT NULL COMMENT 'Este atributo almacena la url del archivo en el sistema web.',
  `comentario` text NOT NULL COMMENT 'Este atributo almacena la descripcion del material compartido',
  `existencia` tinyint(4) NOT NULL DEFAULT 1,
  `TipoMaterial_idmaterial` int(11) NOT NULL COMMENT 'Este atributo almacena el identificador del tipo de material al que corresponde el material compartido.',
  `Cita_idCita` int(11) NOT NULL,
  PRIMARY KEY (`idmaterialCompartido`),
  KEY `fk_materialCompartido_TipoMaterial1` (`TipoMaterial_idmaterial`),
  KEY `fk_materialCompartido_Cita1` (`Cita_idCita`),
  CONSTRAINT `fk_materialCompartido_Cita1` FOREIGN KEY (`Cita_idCita`) REFERENCES `cita` (`idCita`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_materialCompartido_TipoMaterial1` FOREIGN KEY (`TipoMaterial_idmaterial`) REFERENCES `tipomaterial` (`idmaterial`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materialcompartido`
--

LOCK TABLES `materialcompartido` WRITE;
/*!40000 ALTER TABLE `materialcompartido` DISABLE KEYS */;
/*!40000 ALTER TABLE `materialcompartido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nota`
--

DROP TABLE IF EXISTS `nota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nota` (
  `idNota` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL COMMENT 'Este atributo almacena el titulo de la nota',
  `cuerpo` text NOT NULL COMMENT 'Este atributo almacena el cuerpo de la nota.',
  `fechaCreacion` date NOT NULL COMMENT 'Este atributo almacena la fecha en la que fue creada la nota.',
  `horaInicio` time NOT NULL,
  `horaFin` time DEFAULT NULL,
  `calificacionP1` double NOT NULL,
  `calificacionP2` double DEFAULT NULL,
  `existencia` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idNota`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nota`
--

LOCK TABLES `nota` WRITE;
/*!40000 ALTER TABLE `nota` DISABLE KEYS */;
INSERT INTO `nota` VALUES (1,'Nota de la asesoría con Kevin','Repasar ejercicios','2024-11-27','10:10:00','00:00:00',8,NULL,1),(2,'Nota de la asesoría con Kevin','Repasar ejercicios','2024-11-27','10:10:00','00:00:00',8,NULL,1),(3,'Nota de la asesoría con Kevin','Repasar ejercicios','2024-11-27','10:10:00','00:00:00',8,NULL,1),(4,'Nota de la asesoría con Kevin','Repasar ejercicios','2024-11-27','10:10:00','00:00:00',8,NULL,1),(5,'Nota de la asesoría con Kevin','Repasar ejercicios','2024-11-27','10:10:00','00:00:00',8,NULL,1),(6,'Nota de la asesoría con Kevin','Repasar ejercicios','2024-11-27','10:10:00','00:00:00',8,NULL,1),(7,'Nota de la asesoría con Kevin','Repasar ejercicios','2024-11-27','10:10:00','00:00:00',8,NULL,1),(8,'Nota de la asesoría con Kevin','Repasar ejercicios','2024-11-27','10:10:00','00:00:00',8,NULL,1),(9,'Nota de la asesoría con Kevin','Repasar ejercicios','2024-11-27','10:10:00','00:00:00',8,NULL,1),(10,'Nota de la asesoría con Kevin','Repasar ejercicios','2024-11-27','10:10:00','00:00:00',8,NULL,1),(11,'Nota de la asesoría con Kevin','Repasar ejercicios','2024-11-27','10:10:00','00:00:00',8,NULL,1),(14,'Nota de la asesoría 1','Repasar ejercicios','2024-11-26','10:10:00','00:00:00',10,NULL,1),(15,'Nota de la asesoría 1','Repasar ejercicios','0000-00-00','00:20:24','10:10:00',9,NULL,1);
/*!40000 ALTER TABLE `nota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesor`
--

DROP TABLE IF EXISTS `profesor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profesor` (
  `matricula` varchar(11) NOT NULL COMMENT 'Este atributo almacena la matricula del usuario',
  `contrasenia` varchar(45) NOT NULL COMMENT 'Este atributo almacena la contrasenia del usuario',
  `nombre` varchar(45) NOT NULL COMMENT 'Este atributo almacena el nombre o los nombres del usuario',
  `apellidoP` varchar(45) NOT NULL COMMENT 'Este atributo almacena el apellido paterno del usuario',
  `apellidoM` varchar(45) NOT NULL COMMENT 'Este atributo almacena el apellido materlo del usuario',
  `genero` varchar(15) NOT NULL COMMENT 'Este atributo almacena el genero del usuario',
  `nivelEducativo` varchar(45) NOT NULL COMMENT 'Este atributo almacena el nivel educativo del profesor',
  `especialidad` varchar(85) NOT NULL COMMENT 'Este atributo almacena en que se especializa el profesor',
  `estudiantesAtendidos` int(11) NOT NULL COMMENT 'Este atributo almacena la cantidad de alumnos que ha atendido en asesorias',
  `existencia` tinyint(4) NOT NULL DEFAULT 1,
  `Disponibilidad_idDisponibilidad` int(11) DEFAULT NULL,
  `Directivo_matricula` varchar(11) NOT NULL,
  PRIMARY KEY (`matricula`),
  KEY `fk_Profesor_Directivo1` (`Directivo_matricula`),
  KEY `fk_Profesor_Disponibilidad1` (`Disponibilidad_idDisponibilidad`),
  CONSTRAINT `fk_Profesor_Directivo1` FOREIGN KEY (`Directivo_matricula`) REFERENCES `directivo` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Profesor_Disponibilidad1` FOREIGN KEY (`Disponibilidad_idDisponibilidad`) REFERENCES `disponibilidad` (`idDisponibilidad`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesor`
--

LOCK TABLES `profesor` WRITE;
/*!40000 ALTER TABLE `profesor` DISABLE KEYS */;
INSERT INTO `profesor` VALUES ('aglo234567','aglo234567','Ana','Gonzalez','Lopez','Femenino','Maestria','Fisica aplicada',0,1,1,'gblo654321'),('clro678901','clro678901','Claudia','Rodriguez','Orozco','Femenino','Doctorado','Biologia molecular',0,1,1,'gblo654321'),('frma345678','frma345678','Francisco','Martinez','Alvarado','Masculino','Doctorado','Ingenieria de software',0,1,1,'gblo654321'),('juva567890','juva567890','Juan','Valdez','Arriaga','Masculino','Maestria','Ciencias computacionales',0,1,1,'gblo654321'),('mapi456789','mapi456789','Maria','Perez','Ibarra','Femenino','Licenciatura','Quimica analitica',0,1,1,'gblo654321'),('mcjo123456','mcjo123456','Jose','Martinez','Calderon','Masculino','Doctorado','Matematicas avanzadas',0,1,1,'gblo654321'),('pcfo123456','pcfo123456','Frida Lourdes','Perez','Colin','Femenino','Doctorado','Desarrollo de software',0,1,NULL,'gblo654321');
/*!40000 ALTER TABLE `profesor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesorasignatura`
--

DROP TABLE IF EXISTS `profesorasignatura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profesorasignatura` (
  `Profesor_matricula` varchar(11) NOT NULL,
  `Asignatura_idAsignatura` int(11) NOT NULL,
  `existencia` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Profesor_matricula`,`Asignatura_idAsignatura`),
  KEY `fk_Profesor_has_Asignatura_Asignatura1` (`Asignatura_idAsignatura`),
  CONSTRAINT `fk_Profesor_has_Asignatura_Asignatura1` FOREIGN KEY (`Asignatura_idAsignatura`) REFERENCES `asignatura` (`idAsignatura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Profesor_has_Asignatura_Profesor1` FOREIGN KEY (`Profesor_matricula`) REFERENCES `profesor` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesorasignatura`
--

LOCK TABLES `profesorasignatura` WRITE;
/*!40000 ALTER TABLE `profesorasignatura` DISABLE KEYS */;
INSERT INTO `profesorasignatura` VALUES ('aglo234567',5,1),('aglo234567',10,1),('clro678901',7,1),('frma345678',4,1),('juva567890',2,1),('juva567890',3,1),('juva567890',8,1),('mapi456789',6,1),('mcjo123456',3,1),('mcjo123456',9,1),('pcfo123456',2,1);
/*!40000 ALTER TABLE `profesorasignatura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipomaterial`
--

DROP TABLE IF EXISTS `tipomaterial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipomaterial` (
  `idmaterial` int(11) NOT NULL AUTO_INCREMENT,
  `extension` varchar(5) NOT NULL COMMENT 'Este atributo almacena la extension del tipo de material.',
  `descripcion` text NOT NULL COMMENT 'Este atributo almacena la descripcion del tipo de material',
  `categoria` varchar(80) NOT NULL COMMENT 'Este atributo almacena el nombre del tipo de material',
  `existencia` tinyint(4) NOT NULL DEFAULT 1,
  `Profesor_matricula` varchar(11) NOT NULL,
  PRIMARY KEY (`idmaterial`),
  KEY `fk_TipoMaterial_Profesor1` (`Profesor_matricula`),
  CONSTRAINT `fk_TipoMaterial_Profesor1` FOREIGN KEY (`Profesor_matricula`) REFERENCES `profesor` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipomaterial`
--

LOCK TABLES `tipomaterial` WRITE;
/*!40000 ALTER TABLE `tipomaterial` DISABLE KEYS */;
INSERT INTO `tipomaterial` VALUES (1,'.pdf','documentos pdf','diccionario',1,'pcfo123456'),(2,'.docx','documentos word','diccionario',1,'pcfo123456'),(3,'.docx','reportes word','reporte',1,'pcfo123456');
/*!40000 ALTER TABLE `tipomaterial` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-28  9:13:22
