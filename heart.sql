-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: heart
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
-- Table structure for table `heart_admin_logs`
--

DROP TABLE IF EXISTS `heart_admin_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `heart_admin_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL DEFAULT '0',
  `moudel` varchar(100) NOT NULL DEFAULT '' COMMENT '目录',
  `controller` varchar(100) NOT NULL DEFAULT '' COMMENT '控制器',
  `action` varchar(100) NOT NULL DEFAULT '' COMMENT '方法',
  `message` varchar(200) DEFAULT '',
  `content` text,
  `action_user` varchar(100) DEFAULT '',
  `createtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2752 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `heart_admin_logs`
--

LOCK TABLES `heart_admin_logs` WRITE;
/*!40000 ALTER TABLE `heart_admin_logs` DISABLE KEYS */;
INSERT INTO `heart_admin_logs` VALUES (2679,'127.0.0.1','admin','index','check_login','登录操作','{\"username\":\"admin\"}','admin',1460518739),(2680,'127.0.0.1','admin','index','check_login','登录操作','{\"username\":\"admin\"}','admin',1460518741),(2681,'127.0.0.1','admin','index','check_login','登录操作','{\"username\":\"root\"}','root',1460518745),(2682,'127.0.0.1','admin','index','check_login','登录操作','{\"username\":\"root\"}','root',1460518748),(2683,'127.0.0.1','admin','index','check_login','登陆状态:日常记录','{\"username\":\"test\"}','test',1460519229),(2684,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460519232),(2685,'127.0.0.1','admin','index','check_login','登陆:日常记录','{\"username\":\"12312\"}','12312',1460519296),(2686,'127.0.0.1','admin','index','check_login','登陆:日常记录','{\"username\":\"12312\"}','12312',1460519298),(2687,'127.0.0.1','admin','index','check_login','登陆:日常记录','{\"username\":\"12312\"}','12312',1460519299),(2688,'127.0.0.1','admin','index','check_login','登陆:日常记录','{\"username\":\"12312\"}','12312',1460519299),(2689,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460519302),(2690,'127.0.0.1','admin','index','check_login','登陆:日常记录','{\"username\":\"fsdfds\"}','fsdfds',1460519451),(2691,'127.0.0.1','admin','index','check_login','登陆:日常记录','{\"username\":\"fsdfds\"}','fsdfds',1460519703),(2692,'127.0.0.1','admin','index','check_login','登陆:日常记录','{\"username\":\"root\"}','root',1460519707),(2693,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460519709),(2694,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460521399),(2695,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460521479),(2696,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460521561),(2697,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460521723),(2698,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460523452),(2699,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460528038),(2700,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460528356),(2701,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460638376),(2702,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460638769),(2703,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460638779),(2704,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460639676),(2705,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460642394),(2706,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460642524),(2707,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460642807),(2708,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460686287),(2709,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460686396),(2710,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460686409),(2711,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460686870),(2712,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460687154),(2713,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460687396),(2714,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460687405),(2715,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460687565),(2716,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460687592),(2717,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460687602),(2718,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460687888),(2719,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460687897),(2720,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460687917),(2721,'127.0.0.1','admin','index','check_login','登陆状态','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460689128),(2722,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460689130),(2723,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460689157),(2724,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460704595),(2725,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460707354),(2726,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460707370),(2727,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460707399),(2728,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460707732),(2729,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460707775),(2730,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460707806),(2731,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460713389),(2732,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460713416),(2733,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460713426),(2734,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460713513),(2735,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460713524),(2736,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460713547),(2737,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460713560),(2738,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460714898),(2739,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"zhuangtingting\"}','zhuangtingting',1460714936),(2740,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460715082),(2741,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460952442),(2742,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460973451),(2743,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1460975940),(2744,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1461052587),(2745,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1461149041),(2746,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1461294886),(2747,'127.0.0.1','admin','index','check_login','登陆状态','{\"username\":\"root\"}','root',1461639756),(2748,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1461639759),(2749,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1462262546),(2750,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1462346404),(2751,'127.0.0.1','admin','index','check_login','登录成功','{\"username\":\"root\"}','root',1462788618);
/*!40000 ALTER TABLE `heart_admin_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `heart_admin_menu`
--

DROP TABLE IF EXISTS `heart_admin_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `heart_admin_menu` (
  `menuid` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(4) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT 'åå­—',
  `model` varchar(100) NOT NULL,
  `controller` varchar(100) NOT NULL COMMENT 'æŽ§åˆ¶å™¨_æ–‡ä»¶å',
  `action` varchar(100) NOT NULL COMMENT 'æ–¹æ³•',
  `param` varchar(100) DEFAULT '' COMMENT 'å‚æ•°',
  `display` int(2) NOT NULL DEFAULT '1' COMMENT '1=æ˜¾ç¤º 0=ä¸æ˜¾ç¤º',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT 'æŽ’åº',
  `createtime` int(11) NOT NULL DEFAULT '0',
  `updatetime` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL,
  PRIMARY KEY (`menuid`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='èœå•åˆ—è¡¨';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `heart_admin_menu`
--

LOCK TABLES `heart_admin_menu` WRITE;
/*!40000 ALTER TABLE `heart_admin_menu` DISABLE KEYS */;
INSERT INTO `heart_admin_menu` VALUES (7,0,'我的面板','none','none','none','type=1&flag=open',1,1,1481440285,1481440285,'appicons/1.png'),(8,0,'系统设置','none','none','none','',1,2,1481440255,1481440255,'appicons/2.png'),(9,8,'管理员管理','admin','user','index','',1,2,1481377551,1481377551,''),(10,8,'后台菜单管理','admin','menu','index','type=1&flag=open',1,1,1481380134,1481380134,''),(11,7,'面板1','admin','admin','mianban1','',1,0,1481380534,1481380534,''),(12,7,'面板2','none','none','none','',1,0,1481377835,1481377835,''),(13,7,'面板3','none','none','none','',1,0,1481377941,1481377941,''),(14,8,'角色管理','admin','role','index','',1,0,1481388513,1481388513,''),(15,14,'修改','admin','role','edit','',1,0,1481436695,1481436695,''),(16,14,'添加','admin','role','add','',1,0,1481390811,1481390811,''),(17,14,'删除','admin','role','del','',1,0,1481390863,1481390863,''),(18,0,'后台首页','admin','index','cms','',0,0,1481436041,1481436041,''),(19,0,'版权首页','admin','index','right','',0,0,1481436397,1481436397,''),(20,10,'添加','admin','menu','add','',1,0,1481436905,1481436905,''),(21,10,'修改','admin','menu','edit','',1,0,1481436922,1481436922,''),(22,10,'删除','admin','menu','del','',1,0,1481436948,1481436948,''),(23,9,'添加','admin','user','add','',1,0,1481437024,1481437024,''),(24,9,'修改','admin','user','edit','',1,0,1481437045,1481437045,''),(25,9,'删除','admin','user','del','',1,0,1481437060,1481437060,''),(26,0,'专题管理','none','none','none','',1,3,1481440340,1481440340,'appicons/5.png'),(27,10,'排序','admin','menu','sort','',1,0,1481437425,1481437425,''),(28,26,'专题管理','admin','spacial','index','',1,0,1481441227,1481441227,''),(29,28,'添加','admin','spacial','add','',1,0,1481441542,1481441542,''),(30,28,'修改','admin','spacial','edit','',1,0,1481441562,1481441562,''),(31,28,'删除','admin','spacial','del','',1,0,1481441599,1481441599,''),(32,28,'上传附件','admin','attachment','upload_dialog','',1,0,1481464197,1481464197,''),(33,28,'H5上传','admin','attachment','h5upload','',1,0,1481518602,1481518602,''),(34,28,'可视化编辑','admin','spacial','view','',1,0,1481686258,1481686258,''),(35,26,'数据模块','admin','spacial_data','index','',1,0,1481737282,1481737282,''),(37,26,'数据模型','admin','spacial_data_model','index','',1,0,1481787220,1481787220,''),(38,37,'添加模型','admin','spacial_data_model','add','',1,0,1481860322,1481860322,''),(39,37,'修改模型','admin','spacial_data_model','edit','',1,0,1481860350,1481860350,''),(40,37,'删除模型','admin','spacial_data_model','del','',1,0,1481860378,1481860378,''),(41,37,'字段列表','admin','spacial_data_model','index_field','',1,0,1481860466,1481860466,''),(42,37,'添加字段','admin','spacial_data_model','add_field','',1,0,1481860488,1481860488,''),(43,37,'修改字段','admin','spacial_data_model','edit_field','',1,0,1481860507,1481860507,''),(44,37,'删除字段','admin','spacial_data_model','del_field','',1,0,1481881419,1481881419,''),(45,28,'数据管理','admin','spacial_data','index','',1,0,1481885560,1481885560,''),(46,28,'编辑模板','admin','spacial_tpl','view','',1,0,1481907592,1481907592,''),(47,28,'碎片管理','admin','spacial_block','index','',1,0,1481993607,1481993607,''),(48,47,'添加碎片','admin','spacial_block','add','',1,0,1481994175,1481994175,''),(49,47,'修改碎片','admin','spacial_block','edit','',1,0,1481994200,1481994200,''),(50,47,'删除碎片','admin','spacial_block','del','',1,0,1481994227,1481994227,'');
/*!40000 ALTER TABLE `heart_admin_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `heart_admin_role`
--

DROP TABLE IF EXISTS `heart_admin_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `heart_admin_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `description` varchar(150) NOT NULL,
  `list` text NOT NULL,
  `createtime` int(11) NOT NULL DEFAULT '0',
  `updatetime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='åˆ†ç»„';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `heart_admin_role`
--

LOCK TABLES `heart_admin_role` WRITE;
/*!40000 ALTER TABLE `heart_admin_role` DISABLE KEYS */;
INSERT INTO `heart_admin_role` VALUES (1,'后台管理员','后台管理员','18,19,7,11,12,13,8,14,15,16,17,10,27,22,21,20,9,25,24,23,26,37,38,39,40,41,44,43,42,35,28,34,33,32,31,30,47,50,49,48,46,29',1481994272,1481994272),(2,'审核人','','19,18,8,10,9,25,23',1481437224,1481437224),(3,'运营','运营','8,14,17,16,15,10,9,7,13,12,11',1481429844,1481429844),(4,'编辑','编辑','',1481429824,1481429824);
/*!40000 ALTER TABLE `heart_admin_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `heart_admin_spacial`
--

DROP TABLE IF EXISTS `heart_admin_spacial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `heart_admin_spacial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'ä¸“é¢˜åå­—',
  `description` text NOT NULL,
  `createtime` int(11) NOT NULL DEFAULT '0',
  `updatetime` int(11) NOT NULL DEFAULT '0',
  `files` varchar(50) NOT NULL COMMENT 'æ–‡ä»¶ä¿¡æ¯',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT 'çŠ¶æ€',
  `cover` varchar(200) NOT NULL DEFAULT '' COMMENT 'ä¸“é¢˜å°é¢',
  `zip` varchar(200) NOT NULL DEFAULT '' COMMENT 'ZIPåŽ‹ç¼©åŒ…',
  `directory` varchar(200) NOT NULL COMMENT 'ä¸“é¢˜ç›®å½•',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='ä¸“é¢˜';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `heart_admin_spacial`
--

LOCK TABLES `heart_admin_spacial` WRITE;
/*!40000 ALTER TABLE `heart_admin_spacial` DISABLE KEYS */;
INSERT INTO `heart_admin_spacial` VALUES (50,'一个页面专题','',1481989740,1481989740,'index.html',0,'','20161217/o_1b46plri816if18n5hdo1t7810s3a.zip','yangguangchuchuang'),(51,'多文件专题','',1481990353,1481990353,'a.html,b.html,index.html',0,'','20161217/o_1b46q8iv31tcnh6nk07sqbn81a.zip','yangguangchuchuang_duowenjian');
/*!40000 ALTER TABLE `heart_admin_spacial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `heart_admin_spacial_block`
--

DROP TABLE IF EXISTS `heart_admin_spacial_block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `heart_admin_spacial_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL DEFAULT '0' COMMENT 'ä¸“é¢˜ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT 'blocké”®å€¼',
  `content` text NOT NULL COMMENT 'åŒºå—å†…å®¹ï¼Œä¾‹å¦‚HTMLæ¨¡æ¿ç­‰',
  `createtime` int(11) NOT NULL DEFAULT '0',
  `updatetime` int(11) NOT NULL DEFAULT '0',
  `type` int(2) NOT NULL DEFAULT '0' COMMENT '0=ä»£ç å—-ç¼–è¾‘å™¨ 1=ä»£ç å—-æ–‡æœ¬æ¡† 2=æ•°æ®åˆ—è¡¨',
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT 'æ¨¡åž‹ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `heart_admin_spacial_block`
--

LOCK TABLES `heart_admin_spacial_block` WRITE;
/*!40000 ALTER TABLE `heart_admin_spacial_block` DISABLE KEYS */;
INSERT INTO `heart_admin_spacial_block` VALUES (20,50,'title','我换一下标题如何',1482061815,1482061815,1,0),(21,50,'nav_daohang','<ul class=\"ab_topnav list-paddingleft-2\" style=\"margin-left:50px;\"><li><p><a href=\"#\">芭乐首页123</a></p></li><li><p><a href=\"#\">影视312</a></p></li><li><p><a href=\"#\">节目</a></p></li><li><p><a href=\"#\">芭乐拍</a></p></li></ul>',1482062136,1482062136,0,0),(18,50,'数据列表','数据列表数据列表',1482061318,1482061318,2,1),(17,50,'代码快文本框','代码快 文本框代码快 文本框',1482061265,1482061265,1,1),(16,50,'代码快编辑器','<p>代码快编辑器代码快编辑器代码快编辑器</p>',1482061245,1482061245,0,1),(22,50,'nav_daohang1','<ul class=\"ab_topnav\" style=\"margin-left:50px;\">\r\n<li><a href=\"#\">芭乐首页</a></li>\r\n<li><a href=\"#\">影视</a></li>\r\n<li><a href=\"#\">节目</a></li>\r\n<li class=\"an4\"><a href=\"#\">芭乐拍</a></li>\r\n</ul>',1482068229,1482068229,1,0);
/*!40000 ALTER TABLE `heart_admin_spacial_block` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `heart_admin_spacial_model`
--

DROP TABLE IF EXISTS `heart_admin_spacial_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `heart_admin_spacial_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT 'æ¨¡åž‹åç§°',
  `description` text NOT NULL COMMENT 'æ¨¡åž‹ç®€ä»‹',
  `type` int(2) NOT NULL COMMENT 'æ¨¡åž‹ç±»åˆ«',
  `createtime` int(11) NOT NULL DEFAULT '0',
  `updatetime` int(11) NOT NULL DEFAULT '0',
  `field` text NOT NULL COMMENT 'å­—æ®µJSONåˆ—è¡¨',
  `sid` int(11) NOT NULL DEFAULT '0' COMMENT 'æ‰€å±žä¸“é¢˜',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `heart_admin_spacial_model`
--

LOCK TABLES `heart_admin_spacial_model` WRITE;
/*!40000 ALTER TABLE `heart_admin_spacial_model` DISABLE KEYS */;
INSERT INTO `heart_admin_spacial_model` VALUES (1,'推荐模型11','推荐模型1',0,1481816526,1481899896,'[{\"type\":\"editor\",\"field_name\":\"a_1111\",\"name\":\"%E5%AD%97%E6%AE%B5%E5%88%AB%E5%90%8D123sfds\",\"description\":\"%E5%AD%97%E6%AE%B5%E7%AE%80%E4%BB%8B%E5%AD%97%E6%AE%B5%E7%AE%80%E4%BB%8B\",\"updatetime\":\"1481882102\",\"createtime\":\"1481882102\"},{\"type\":\"datetime\",\"field_name\":\"a55511\",\"name\":\"%E5%AD%97%E6%AE%B5%E5%88%AB%E5%90%8D123rew11\",\"description\":\"%E5%AD%97%E6%AE%B5%E7%AE%80%E4%BB%8Brewrew11\",\"updatetime\":\"1481883262\",\"createtime\":\"1481883262\"}]',0),(3,'专题111','专题1321312',0,1481901124,1481901124,'',0),(8,'列表推荐-1','',0,1481990524,1481990524,'',50),(9,'列表推荐-2','',0,1482001504,1482001504,'',50),(10,'列表推荐-3','',0,1482001518,1482001518,'',50);
/*!40000 ALTER TABLE `heart_admin_spacial_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `heart_admin_users`
--

DROP TABLE IF EXISTS `heart_admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `heart_admin_users` (
  `uid` int(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `encrypt` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `truename` varchar(100) NOT NULL COMMENT 'çœŸå®žå§“å',
  `createtime` int(11) NOT NULL DEFAULT '0',
  `updatetime` int(11) NOT NULL DEFAULT '0',
  `groupid` int(2) NOT NULL DEFAULT '0',
  `islock` int(1) NOT NULL DEFAULT '0' COMMENT 'æ˜¯å¦æ¿€æ´» 0=æœªæ¿€æ´» 1=æ¿€æ´»',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `heart_admin_users`
--

LOCK TABLES `heart_admin_users` WRITE;
/*!40000 ALTER TABLE `heart_admin_users` DISABLE KEYS */;
INSERT INTO `heart_admin_users` VALUES (1,'root','f78d50c5ba89898c30b9a1b38dc74a9a','neGgXM','15501100090@163.com','zhangliang',1481313310,1481431294,1,0),(20,'zhangliang','bf1fbebdedeb281bfba6871f81f9d50c','pBJ4sD','','',1481429791,1481434331,2,0);
/*!40000 ALTER TABLE `heart_admin_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-18 13:41:05
