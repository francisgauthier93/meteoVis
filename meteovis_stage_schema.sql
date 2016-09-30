-- MySQL dump 10.13  Distrib 5.1.60, for redhat-linux-gnu (x86_64)
--
-- Host: www-labs.iro.umontreal.ca    Database: wwwrali_meteovis_stage
-- ------------------------------------------------------
-- Server version	5.5.43

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
-- Table structure for table `tb_accumulation`
--

DROP TABLE IF EXISTS `tb_accumulation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_accumulation` (
  `accumulation_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `update_id` bigint(20) unsigned DEFAULT NULL,
  `accumulation_start_date` datetime DEFAULT NULL,
  `accumulation_end_date` datetime DEFAULT NULL,
  `accumulation_minimum_amount` double DEFAULT NULL,
  `accumulation_maximum_amount` double DEFAULT NULL,
  `accumulation_minimum_total` double DEFAULT NULL,
  `accumulation_maximum_total` double DEFAULT NULL,
  `accumulation_type` varchar(50) DEFAULT NULL,
  `accumulation_unit` varchar(20) DEFAULT NULL,
  `accumulation_status` tinyint(4) NOT NULL DEFAULT '0',
  `location_id` bigint(20) unsigned DEFAULT NULL,
  `accumulation_storing_date` datetime DEFAULT NULL,
  PRIMARY KEY (`accumulation_id`),
  KEY `accumulation_accumulation_status_idx` (`accumulation_status`),
  KEY `index_update_id` (`update_id`),
  KEY `index_location_id` (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2635682 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_air_temperature`
--

DROP TABLE IF EXISTS `tb_air_temperature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_air_temperature` (
  `air_temperature_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `update_id` bigint(20) unsigned DEFAULT NULL,
  `air_temperature_start_date` datetime DEFAULT NULL,
  `air_temperature_end_date` datetime DEFAULT NULL,
  `air_temperature_minimum_value` double DEFAULT NULL,
  `air_temperature_maximum_value` double DEFAULT NULL,
  `air_temperature_unit` varchar(20) DEFAULT NULL,
  `air_temperature_storing_date` datetime DEFAULT NULL,
  `air_temperature_status` tinyint(4) NOT NULL DEFAULT '0',
  `location_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`air_temperature_id`),
  KEY `air_temperature_air_temperature_status_idx` (`air_temperature_status`),
  KEY `index_update_id` (`update_id`),
  KEY `index_location_id` (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=52040943 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_city`
--

DROP TABLE IF EXISTS `tb_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_city` (
  `city_id` int(11) NOT NULL DEFAULT '0',
  `city_name_en` varchar(150) DEFAULT NULL,
  `city_name_fr` varchar(150) DEFAULT NULL,
  `city_code` varchar(20) DEFAULT NULL,
  `city_latitude` double DEFAULT NULL,
  `city_longitude` double DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `city_storing_date` datetime DEFAULT NULL,
  `city_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`city_id`),
  UNIQUE KEY `city_code` (`city_code`),
  KEY `tb_city_location_id_idx` (`location_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_cloud_cover`
--

DROP TABLE IF EXISTS `tb_cloud_cover`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_cloud_cover` (
  `cloud_cover_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `update_id` bigint(20) unsigned DEFAULT NULL,
  `cloud_cover_start_date` datetime DEFAULT NULL,
  `cloud_cover_end_date` datetime DEFAULT NULL,
  `cloud_cover_value` smallint(6) DEFAULT NULL,
  `cloud_cover_unit` varchar(20) DEFAULT NULL,
  `cloud_cover_storing_date` datetime DEFAULT NULL,
  `cloud_cover_status` tinyint(4) NOT NULL DEFAULT '0',
  `location_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`cloud_cover_id`),
  KEY `cloud_cover_cloud_cover_status_idx` (`cloud_cover_status`),
  KEY `index_update_id` (`update_id`),
  KEY `index_location_id` (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=50548060 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_country`
--

DROP TABLE IF EXISTS `tb_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name_en` varchar(150) DEFAULT NULL,
  `country_name_fr` varchar(150) DEFAULT NULL,
  `country_code` varchar(10) DEFAULT NULL,
  `country_storing_date` datetime DEFAULT NULL,
  `country_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`country_id`),
  UNIQUE KEY `country_name_en` (`country_name_en`),
  UNIQUE KEY `country_name_fr` (`country_name_fr`),
  UNIQUE KEY `country_code` (`country_code`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_location`
--

DROP TABLE IF EXISTS `tb_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_location` (
  `location_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_name_en` varchar(150) NOT NULL DEFAULT '',
  `location_name_fr` varchar(150) NOT NULL DEFAULT '',
  `location_latitude` double DEFAULT NULL,
  `location_longitude` double DEFAULT NULL,
  `location_region_abbr` varchar(10) DEFAULT NULL,
  `location_time_zone_fr` varchar(50) DEFAULT NULL,
  `location_time_zone_en` varchar(50) DEFAULT NULL,
  `location_code` varchar(10) NOT NULL DEFAULT '',
  `location_storing_date` datetime DEFAULT NULL,
  `location_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`location_id`),
  UNIQUE KEY `location_code` (`location_code`),
  KEY `index_status` (`location_status`)
) ENGINE=MyISAM AUTO_INCREMENT=555 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_precipitation`
--

DROP TABLE IF EXISTS `tb_precipitation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_precipitation` (
  `precipitation_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `update_id` bigint(20) unsigned DEFAULT NULL,
  `precipitation_start_date` datetime DEFAULT NULL,
  `precipitation_end_date` datetime DEFAULT NULL,
  `precipitation_type` varchar(50) DEFAULT NULL,
  `precipitation_frequency` varchar(50) DEFAULT NULL,
  `precipitation_probability` double DEFAULT NULL,
  `precipitation_probability_unit` varchar(20) DEFAULT NULL,
  `precipitation_storing_date` datetime DEFAULT NULL,
  `precipitation_status` tinyint(4) NOT NULL DEFAULT '0',
  `precipitation_intensity` varchar(50) DEFAULT NULL,
  `location_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`precipitation_id`),
  KEY `precipitation_precipitation_status_idx` (`precipitation_status`),
  KEY `index_update_id` (`update_id`),
  KEY `index_location_id` (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1384923 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_province`
--

DROP TABLE IF EXISTS `tb_province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_province` (
  `province_id` int(11) NOT NULL AUTO_INCREMENT,
  `province_name_en` varchar(150) NOT NULL DEFAULT '',
  `province_name_fr` varchar(150) NOT NULL DEFAULT '',
  `province_code` varchar(10) NOT NULL DEFAULT '',
  `province_storing_date` datetime DEFAULT NULL,
  `province_status` tinyint(4) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`province_id`),
  UNIQUE KEY `province_name_en` (`province_name_en`),
  UNIQUE KEY `province_name_fr` (`province_name_fr`),
  UNIQUE KEY `province_code` (`province_code`),
  KEY `tb_province_region_id_idx` (`region_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_region`
--

DROP TABLE IF EXISTS `tb_region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_region` (
  `region_id` int(11) NOT NULL AUTO_INCREMENT,
  `region_name_en` varchar(150) NOT NULL DEFAULT '',
  `region_name_fr` varchar(150) NOT NULL DEFAULT '',
  `region_code` varchar(10) NOT NULL DEFAULT '',
  `region_storing_date` datetime DEFAULT NULL,
  `region_status` tinyint(4) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`region_id`),
  UNIQUE KEY `region_name_en` (`region_name_en`),
  UNIQUE KEY `region_name_fr` (`region_name_fr`),
  UNIQUE KEY `region_code` (`region_code`),
  KEY `tb_region_country_id_idx` (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_update`
--

DROP TABLE IF EXISTS `tb_update`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_update` (
  `update_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` bigint(20) unsigned DEFAULT NULL,
  `update_type` varchar(50) DEFAULT NULL,
  `update_valid_start_date` datetime DEFAULT NULL,
  `update_valid_end_date` datetime DEFAULT NULL,
  `update_creation_date` datetime DEFAULT NULL,
  `update_storing_date` datetime DEFAULT NULL,
  `update_status` tinyint(4) NOT NULL DEFAULT '0',
  `update_url` text,
  PRIMARY KEY (`update_id`),
  KEY `update_location_id_idx` (`location_id`),
  KEY `update_update_status_idx` (`update_status`)
) ENGINE=MyISAM AUTO_INCREMENT=757256 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_warning`
--

DROP TABLE IF EXISTS `tb_warning`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_warning` (
  `warning_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `update_id` bigint(20) unsigned DEFAULT NULL,
  `warning_start_date` datetime DEFAULT NULL,
  `warning_end_date` datetime DEFAULT NULL,
  `warning_code` varchar(50) DEFAULT NULL,
  `warning_type` varchar(50) DEFAULT NULL,
  `warning_description` text,
  `warning_state` varchar(50) DEFAULT NULL,
  `warning_storing_date` datetime DEFAULT NULL,
  `warning_status` tinyint(4) NOT NULL DEFAULT '0',
  `location_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`warning_id`),
  KEY `warning_update_id_idx` (`update_id`),
  KEY `warning_warning_status_idx` (`warning_status`),
  KEY `index_location_id` (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25939 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_wind`
--

DROP TABLE IF EXISTS `tb_wind`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_wind` (
  `wind_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `update_id` bigint(20) unsigned DEFAULT NULL,
  `wind_start_date` datetime DEFAULT NULL,
  `wind_end_date` datetime DEFAULT NULL,
  `wind_minimum_speed` double DEFAULT NULL,
  `wind_maximum_speed` double DEFAULT NULL,
  `wind_unit` varchar(20) DEFAULT NULL,
  `wind_direction` varchar(50) DEFAULT NULL,
  `wind_storing_date` datetime DEFAULT NULL,
  `wind_status` tinyint(4) NOT NULL DEFAULT '0',
  `location_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`wind_id`),
  KEY `wind_update_id_idx` (`update_id`),
  KEY `wind_wind_status_idx` (`wind_status`),
  KEY `index_location_id` (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5355847 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-07-17 22:03:11
