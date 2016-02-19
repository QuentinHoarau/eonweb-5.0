-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: eonweb
-- ------------------------------------------------------
-- Server version	5.1.73

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
-- Table structure for table `auth_settings`
--

DROP TABLE IF EXISTS `auth_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_settings` (
  `auth_type` tinyint(1) NOT NULL DEFAULT '0',
  `ldap_ip` varchar(255) DEFAULT NULL,
  `ldap_port` int(11) DEFAULT NULL,
  `ldap_search` varchar(255) DEFAULT NULL,
  `ldap_user` varchar(255) DEFAULT NULL,
  `ldap_password` varchar(255) DEFAULT NULL,
  `ldap_rdn` varchar(255) DEFAULT NULL,
  `ldap_filter` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`auth_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_settings`
--

LOCK TABLES `auth_settings` WRITE;
/*!40000 ALTER TABLE `auth_settings` DISABLE KEYS */;
INSERT INTO `auth_settings` VALUES (0,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `auth_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groupright`
--

DROP TABLE IF EXISTS `groupright`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groupright` (
  `group_id` int(11) NOT NULL,
  `tab_1` enum('0','1') NOT NULL DEFAULT '0',
  `tab_2` enum('0','1') NOT NULL DEFAULT '0',
  `tab_3` enum('0','1') NOT NULL DEFAULT '0',
  `tab_4` enum('0','1') NOT NULL DEFAULT '0',
  `tab_5` enum('0','1') NOT NULL DEFAULT '0',
  `tab_6` enum('0','1') NOT NULL DEFAULT '0',
  `tab_7` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groupright`
--

LOCK TABLES `groupright` WRITE;
/*!40000 ALTER TABLE `groupright` DISABLE KEYS */;
INSERT INTO `groupright` VALUES (1,'1','1','1','1','1','1','1');
/*!40000 ALTER TABLE `groupright` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `group_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `group_descr` text,
  `group_dn` varchar(255) DEFAULT NULL,
  `group_type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`group_id`,`group_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'admins','Administrator group',NULL,NULL);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ldap_groups_extended`
--

DROP TABLE IF EXISTS `ldap_groups_extended`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldap_groups_extended` (
  `dn` varchar(255) NOT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `checked` smallint(6) NOT NULL,
  PRIMARY KEY (`dn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldap_groups_extended`
--

LOCK TABLES `ldap_groups_extended` WRITE;
/*!40000 ALTER TABLE `ldap_groups_extended` DISABLE KEYS */;
/*!40000 ALTER TABLE `ldap_groups_extended` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ldap_users`
--

DROP TABLE IF EXISTS `ldap_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldap_users` (
  `dn` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  PRIMARY KEY (`dn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldap_users`
--

LOCK TABLES `ldap_users` WRITE;
/*!40000 ALTER TABLE `ldap_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `ldap_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ldap_users_extended`
--

DROP TABLE IF EXISTS `ldap_users_extended`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldap_users_extended` (
  `dn` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `checked` smallint(6) NOT NULL,
  PRIMARY KEY (`dn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldap_users_extended`
--

LOCK TABLES `ldap_users_extended` WRITE;
/*!40000 ALTER TABLE `ldap_users_extended` DISABLE KEYS */;
/*!40000 ALTER TABLE `ldap_users_extended` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_link`
--

DROP TABLE IF EXISTS `menu_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_subtab` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` text,
  `target` varchar(255) NOT NULL,
  `nb_order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_subtab` (`id_subtab`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Liens menus eonweb';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_link`
--

LOCK TABLES `menu_link` WRITE;
/*!40000 ALTER TABLE `menu_link` DISABLE KEYS */;
INSERT INTO `menu_link` VALUES (1,1,'menu.link.eyesofnetwork','/module/home_about/','main',1),(2,1,'menu.link.website','http://www.eyesofnetwork.com','_blank',2),(3,2,'menu.link.centos','http://www.centos.org/','_blank',1),(4,2,'menu.link.ged','http://generic-ed.sourceforge.net/','_blank',2),(5,2,'menu.link.thruk','http://www.thruk.org/','_blank',3),(6,2,'menu.link.nagios','http://www.nagios.org/','_blank',4),(7,2,'menu.link.nagiosbp','http://bp-addon.monitoringexchange.org/','_blank',5),(8,2,'menu.link.cacti','http://www.cacti.net/','_blank',6),(9,2,'menu.link.snmptt','http://www.snmptt.org/','_blank',7),(10,2,'menu.link.nagvis','http://www.nagvis.org/','_blank',8),(11,2,'menu.link.weathermap','http://www.network-weathermap.com/','_blank',9),(12,2,'menu.link.pnp4nagios','http://www.pnp4nagios.org/','_blank',10),(13,2,'menu.link.glpi','http://www.glpi-project.org/','_blank',11),(14,2,'menu.link.ocsinventory_ng','http://www.ocsinventory-ng.org/','_blank',12),(15,2,'menu.link.fusion_inventory','http://fusioninventory.org/','_blank',13),(16,3,'menu.link.dashboard','/module/monitoring_view/','main',1),(17,3,'menu.link.technical_table','/thruk/cgi-bin/tac.cgi','main',2),(18,3,'menu.link.panorama','/thruk/cgi-bin/panorama.cgi','_blank',3),(19,3,'menu.link.execution','/thruk/cgi-bin/extinfo.cgi?type=4','main',4),(20,3,'menu.link.problems','/thruk/cgi-bin/status.cgi?style=combined&amp;hst_s0_hoststatustypes=4&amp;hst_s0_servicestatustypes=31&amp;hst_s0_hostprops=10&amp;hst_s0_serviceprops=0&amp;svc_s0_hoststatustypes=3&amp;svc_s0_servicestatustypes=28&amp;svc_s0_hostprops=10&amp;svc_s0_serviceprops=10&amp;svc_s0_hostprop=2&amp;svc_s0_hostprop=8&amp;title=All+Unhandled+Problems','main',5),(21,4,'menu.link.thruk','/thruk/cgi-bin/statusmap.cgi','main',1),(22,4,'menu.link.nagvis','/nagvis','main',2),(23,4,'menu.link.network','/cacti/plugins/weathermap/weathermap-cacti-plugin.php?action=','_blank',3),(24,5,'menu.link.active_events','/module/monitoring_ged/ged.php?q=active','main',1),(25,5,'menu.link.history_events','/module/monitoring_ged/ged.php?q=history','main',2),(26,5,'menu.link.equipment_view','/thruk/cgi-bin/status.cgi?hostgroup=all&amp;style=hostdetail','main',3),(27,5,'menu.link.service_view','/thruk/cgi-bin/status.cgi?host=all','main',4),(28,5,'menu.link.equipment_group','/thruk/cgi-bin/status.cgi?hostgroup=all&amp;style=summary','main',5),(29,5,'menu.link.service_group','/thruk/cgi-bin/status.cgi?servicegroup=all&amp;style=summary','main',6),(30,5,'menu.link.application_view','/nagiosbp/cgi-bin/nagios-bp.cgi','main',7),(31,5,'menu.link.impact_view','/nagiosbp/cgi-bin/nagios-bp.cgi?mode=bi','main',8),(32,6,'menu.link.equipment_incident','/thruk/cgi-bin/status.cgi?hostgroup=all&amp;style=hostdetail&amp;hoststatustypes=12','main',1),(33,6,'menu.link.service_incident','/thruk/cgi-bin/status.cgi?host=all&amp;servicestatustypes=28','main',2),(34,6,'menu.link.planned_downtime','/thruk/cgi-bin/extinfo.cgi?type=6','main',3),(35,6,'menu.link.recurring_planned_downtime','/thruk/cgi-bin/extinfo.cgi?type=6&amp;recurring','main',4),(36,7,'menu.link.cacti','/cacti/graph_view.php','_blank',1),(37,7,'menu.link.pnp4nagios','/pnp4nagios/','_blank',2),(38,8,'menu.link.per_equipment','/module/capacity_per_device/','main',1),(39,8,'menu.link.per_metric','/module/capacity_per_label/','main',2),(40,9,'menu.link.equipments','/module/tool_all/index_hostlist.php','main',1),(41,9,'menu.link.external','/module/tool_all/index_hostname.php','main',2),(42,10,'menu.link.nagios','/thruk/cgi-bin/showlog.cgi','main',1),(43,10,'menu.link.system','/cacti/plugins/syslog/syslog.php','_blank',2),(44,11,'menu.link.park_management','/module/index.php?module=glpi&amp;link=/glpi/index.php','_blank',1),(45,11,'menu.link.inventory','/module/index.php?module=ocsinventory-reports&amp;link=/ocsreports','_blank',2),(46,12,'menu.link.volume_of_incidents','/module/report_event/','main',1),(47,12,'menu.link.technical_sla','/module/report_event/index.php?type=sla','main',2),(48,13,'menu.link.availabilities','/thruk/cgi-bin/avail.cgi','main',1),(49,13,'menu.link.trends','/thruk/cgi-bin/trends.cgi','main',2),(50,13,'menu.link.summary','/thruk/cgi-bin/summary.cgi','main',3),(51,13,'menu.link.reporting','/thruk/cgi-bin/reports2.cgi','main',4),(52,14,'menu.link.performances','/module/report_performance/','main',1),(53,15,'menu.link.ssh_access','/module/tool_remoteacces/index_ssh.php','main',1),(54,15,'menu.link.snmpwalk','/module/tool_all/index_snmpwalk.php','main',2),(55,16,'menu.link.auth','/module/admin_auth/','main',1),(56,16,'menu.link.groups','/module/admin_group','main',2),(57,16,'menu.link.users','/module/admin_user','main',3),(58,16,'menu.link.process','/module/admin_process','main',4),(59,16,'menu.link.snmp','/module/admin_files/index.php?file=snmpconf','main',5),(60,16,'menu.link.snmptrapd','/module/admin_files/index.php?file=snmptrapconf','main',6),(61,16,'menu.link.saves','/module/admin_files/index.php?file=backupconf','main',7),(62,16,'menu.link.logs','/module/admin_logs/index.php','main',8),(63,17,'menu.link.conf','/lilac/index.php','main',1),(64,17,'menu.link.equipments','/lilac/hosts.php','main',2),(65,17,'menu.link.models','/lilac/templates.php','main',3),(66,17,'menu.link.app','/module/admin_bp/index.php','main',4),(67,17,'menu.link.planned_downtime','/module/admin_files/index.php?file=nagiosdowntime','main',5),(68,17,'menu.link.notif','/module/admin_files/index.php?file=notification','main',6),(69,17,'menu.link.csv_deployment','/module/admin_import_device/','main',7),(70,17,'menu.link.sync_cacti','/module/admin_device/','main',8),(71,17,'menu.link.apply_conf','/lilac/export.php','main',9),(72,17,'menu.link.nagios_reports','/module/admin_conf/','main',10),(73,18,'menu.link.conf','/module/admin_files/index.php?file=gedcfg','main',1),(74,18,'menu.link.storage','/module/admin_files/index.php?file=gedhdb','main',2),(75,18,'menu.link.relay','/module/admin_files/index.php?file=gedtcfg','main',3),(76,18,'menu.link.client','/module/admin_files/index.php?file=gedqcfg','main',4),(77,19,'menu.link.nagvis','/nagvis','main',1),(78,19,'menu.link.weathermap','/cacti/plugins/weathermap/weathermap-cacti-plugin-mgmt.php','_blank',2),(79,20,'menu.link.thruk','/thruk/index.html','_blank',1),(80,20,'menu.link.cacti','/cacti','_blank',2),(81,21,'menu.link.install','http://www.eyesofnetwork.com/?page_id=495','_blank',1),(82,21,'menu.link.exploit','http://www.eyesofnetwork.com/?page_id=495','_blank',2),(83,22,'menu.link.centos','http://wiki.centos.org/Documentation','_blank',1),(84,22,'menu.link.ged','http://generic-ed.sourceforge.net','_blank',2),(85,22,'menu.link.thruk','/thruk/documentation.html','_blank',3),(86,22,'menu.link.nagios','http://library.nagios.com/library/products/nagioscore/manuals/','_blank',4),(87,22,'menu.link.nagiosbp','http://bp-addon.monitoringexchange.org/doc/','_blank',5),(88,22,'menu.link.cacti','http://www.cacti.net/downloads/docs/html/','_blank',6),(89,22,'menu.link.snmptt','http://snmptt.sourceforge.net/docs/snmptt.shtml','_blank',7),(90,22,'menu.link.nagvis','http://www.nagvis.org/doc','_blank',8),(91,22,'menu.link.weathermap','/cacti/plugins/weathermap/docs/','_blank',9),(92,22,'menu.link.pnp4nagios','http://docs.pnp4nagios.org/fr/pnp-0.6/start','_blank',10),(93,22,'menu.link.glpi','http://www.glpi-project.org/wiki/doku.php','_blank',11),(94,22,'menu.link.ocsinventory_ng','http://wiki.ocsinventory-ng.org/','_blank',12),(95,22,'menu.link.fusion_inventory','http://fusioninventory.org/documentation/','_blank',13);
/*!40000 ALTER TABLE `menu_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_subtab`
--

DROP TABLE IF EXISTS `menu_subtab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_subtab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tab` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nb_order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tab` (`id_tab`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Sous menus eonweb';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_subtab`
--

LOCK TABLES `menu_subtab` WRITE;
/*!40000 ALTER TABLE `menu_subtab` DISABLE KEYS */;
INSERT INTO `menu_subtab` VALUES (1,1,'menu.subtab.about',1),(2,1,'menu.subtab.components',2),(3,2,'menu.subtab.global_views',1),(4,2,'menu.subtab.maps',2),(5,2,'menu.subtab.events',3),(6,2,'menu.subtab.incidents',4),(7,3,'menu.subtab.graphical_views',1),(8,3,'menu.subtab.cacti_performance',2),(9,4,'menu.subtab.tools',1),(10,4,'menu.subtab.logs',2),(11,4,'menu.subtab.configuration',3),(12,5,'menu.subtab.events',1),(13,5,'menu.subtab.availability',2),(14,5,'menu.subtab.capacity',3),(15,6,'menu.subtab.local_access',1),(16,6,'menu.subtab.generality',2),(17,6,'menu.subtab.nagios',3),(18,6,'menu.subtab.ged',4),(19,6,'menu.subtab.maps',5),(20,6,'menu.subtab.external_links',6),(21,7,'menu.subtab.eyesofnetwork',1),(22,7,'menu.subtab.components',2);
/*!40000 ALTER TABLE `menu_subtab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_tab`
--

DROP TABLE IF EXISTS `menu_tab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_tab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nb_order` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Menus eonweb';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_tab`
--

LOCK TABLES `menu_tab` WRITE;
/*!40000 ALTER TABLE `menu_tab` DISABLE KEYS */;
INSERT INTO `menu_tab` VALUES (1,'menu.tab.project',1,'fa fa-question-circle'),(2,'menu.tab.dispo',2,'fa fa-sitemap'),(3,'menu.tab.capacity',3,'fa fa-dashboard'),(4,'menu.tab.prod',4,'fa fa-gears'),(5,'menu.tab.report',5,'fa fa-bar-chart-o'),(6,'menu.tab.admin',6,'fa fa-wrench'),(7,'menu.tab.help',7,'fa fa-book');
/*!40000 ALTER TABLE `menu_tab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_passwd` varchar(255) NOT NULL,
  `user_descr` varchar(255) DEFAULT NULL,
  `user_type` tinyint(1) NOT NULL,
  `user_location` varchar(255) DEFAULT NULL,
  `user_limitation` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`,`user_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'admin','21232f297a57a5a743894a0e4a801fc3','default user',0,'',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-18 15:27:48
