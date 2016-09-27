-- MySQL dump 10.13  Distrib 5.5.27, for Win32 (x86)
--
-- Host: localhost    Database: business
-- ------------------------------------------------------
-- Server version	5.5.40

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
-- Current Database: `business`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `business` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `business`;

--
-- Table structure for table `nav_cate`
--

DROP TABLE IF EXISTS `nav_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nav_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类',
  `cate_name` varchar(50) NOT NULL COMMENT '名称',
  `content` text COMMENT '分类介绍',
  `icon_class` varchar(200) DEFAULT '' COMMENT '图标样式',
  `menu_is` enum('Y','N') DEFAULT 'N' COMMENT '是否导航显示',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '状�?,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否软删�?,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `soft_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时�?,
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='分类导航�?;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nav_cate`
--

LOCK TABLES `nav_cate` WRITE;
/*!40000 ALTER TABLE `nav_cate` DISABLE KEYS */;
INSERT INTO `nav_cate` VALUES (7,0,'招聘�?,'在线招聘的网站或者app','','N','Y',0,0,1473143268,0,0,0),(8,7,'IT','it招聘','','N','Y',2,0,1473143299,0,0,0);
/*!40000 ALTER TABLE `nav_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nav_website`
--

DROP TABLE IF EXISTS `nav_website`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nav_website` (
  `website_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `website_name` varchar(50) NOT NULL COMMENT '名称',
  `website_url` varchar(250) NOT NULL COMMENT '网站名称',
  `cat_id` int(10) unsigned NOT NULL COMMENT '分类ID',
  `pcat_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '一级分类ID',
  `content` text COMMENT '网站介绍',
  `icon_class` varchar(200) DEFAULT '' COMMENT '图标样式',
  `menu_is` enum('Y','N') DEFAULT 'N' COMMENT '是否导航显示',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '状�?,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否软删�?,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `soft_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时�?,
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`website_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='网站导航�?;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nav_website`
--

LOCK TABLES `nav_website` WRITE;
/*!40000 ALTER TABLE `nav_website` DISABLE KEYS */;
/*!40000 ALTER TABLE `nav_website` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_admin`
--

DROP TABLE IF EXISTS `tbl_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户�?,
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `thumb` varchar(225) NOT NULL DEFAULT '' COMMENT '图像地址',
  `role_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '[select]角色ID',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱地址',
  `reg_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `last_login_ip` varchar(25) NOT NULL DEFAULT '' COMMENT '上次登录IP',
  `login_count` smallint(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状�? 1:激�? 0:禁用',
  `remark` text COMMENT '备注说明',
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='后台用户�?;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_admin`
--

LOCK TABLES `tbl_admin` WRITE;
/*!40000 ALTER TABLE `tbl_admin` DISABLE KEYS */;
INSERT INTO `tbl_admin` VALUES (1,'admin','0C909A141F1F2C0A1CB602B0B2D7D050','管理�?,'2016-09-01/57c7943bd09aa.jpg',0,'admin@admin.com',0,1474249664,'127.0.0.1',27,1,NULL),(2,'lisi','FF9041128F5AE17404CEC64729D2DC36','李四','face.jpg',0,'lisi@126.com',0,0,'',0,1,NULL),(3,'aman','89567C7661B2C380E9AD7D9659C441A3','曹阿�?,'face.jpg',0,'zfeig@126.com',0,0,'',0,0,NULL),(4,'baidu','0DC2FE433EC0B6E14DCEE9E7DBB5B3CF','百度','face.jpg',0,'baidu@126.com',0,0,'',0,1,NULL),(5,'xiaoq','7E9530E70AEBF7530A6BF23273B7D7EB','小强','face.jpg',0,'xiaoq@126.com',0,0,'',0,1,NULL),(6,'cong','281813F2A06D80DD078DB47112BFF8DE','聪哥','face.jpg',0,'cong@126.com',0,0,'',0,1,NULL),(7,'admin2','E054F90719313DA598422263CFBE7FDF','你好','',0,'',1473728700,0,'',0,0,NULL);
/*!40000 ALTER TABLE `tbl_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_attach`
--

DROP TABLE IF EXISTS `tbl_attach`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_attach` (
  `attach_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�û���',
  `scope` enum('content','image') NOT NULL DEFAULT 'content' COMMENT 'ģ��',
  `real_name` varchar(100) NOT NULL DEFAULT '' COMMENT 'ԭʼ�ļ�����',
  `save_name` varchar(100) NOT NULL DEFAULT '' COMMENT '�����ļ�������·��',
  `save_path` varchar(200) NOT NULL DEFAULT '' COMMENT '����·��',
  `thumb_path` varchar(200) NOT NULL DEFAULT '' COMMENT '����ͼ',
  `hash` char(32) NOT NULL DEFAULT '' COMMENT 'hash',
  `file_ext` char(5) NOT NULL DEFAULT 'jpg' COMMENT '��չ����',
  `file_mime` varchar(50) NOT NULL DEFAULT '' COMMENT '�ļ�ͷ��Ϣ',
  `file_size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�ļ���С',
  `down_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '���ش���',
  `access` varchar(255) NOT NULL DEFAULT '' COMMENT 'Ȩ�޿���',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�ϴ�ʱ��',
  PRIMARY KEY (`attach_id`)
) ENGINE=MyISAM AUTO_INCREMENT=261 DEFAULT CHARSET=utf8 COMMENT='������';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_attach`
--

LOCK TABLES `tbl_attach` WRITE;
/*!40000 ALTER TABLE `tbl_attach` DISABLE KEYS */;
INSERT INTO `tbl_attach` VALUES (200,0,'content','1895637.jpg','57d3fa376f66c.jpg','gallary/2016-09-10/57d3fa376f66c.jpg','','','jpg','application/octet-stream',126982,0,'',1473509943),(201,0,'content','1929818.jpg','57d3fa37b8a4c.jpg','gallary/2016-09-10/57d3fa37b8a4c.jpg','','','jpg','application/octet-stream',75174,0,'',1473509943),(202,0,'content','free-backgrounds-1.jpg','57d3fa381b2c4.jpg','gallary/2016-09-10/57d3fa381b2c4.jpg','','','jpg','application/octet-stream',85269,0,'',1473509944),(203,0,'content','free-backgrounds-4.jpg','57d3fa386890c.jpg','gallary/2016-09-10/57d3fa386890c.jpg','','','jpg','application/octet-stream',38820,0,'',1473509944),(204,0,'content','free-backgrounds-5.jpg','57d3fa38b4bcc.jpg','gallary/2016-09-10/57d3fa38b4bcc.jpg','','','jpg','application/octet-stream',51207,0,'',1473509944),(205,0,'content','free-backgrounds-7.jpg','57d3fa3922bdc.jpg','gallary/2016-09-10/57d3fa3922bdc.jpg','','','jpg','application/octet-stream',95046,0,'',1473509945),(206,0,'content','free-backgrounds-11.jpg','57d3fa398465c.jpg','gallary/2016-09-10/57d3fa398465c.jpg','','','jpg','application/octet-stream',46065,0,'',1473509945),(207,0,'content','free-backgrounds-14.jpg','57d3fa3a4cfa4.jpg','gallary/2016-09-10/57d3fa3a4cfa4.jpg','','','jpg','application/octet-stream',53688,0,'',1473509946),(208,0,'content','free-backgrounds-15.jpg','57d3fa3a9ccfc.jpg','gallary/2016-09-10/57d3fa3a9ccfc.jpg','','','jpg','application/octet-stream',74887,0,'',1473509946),(209,0,'content','free-backgrounds-16.jpg','57d3fa3aef934.jpg','gallary/2016-09-10/57d3fa3aef934.jpg','','','jpg','application/octet-stream',48061,0,'',1473509947),(210,0,'content','free-backgrounds-23.jpg','57d3fa3b87d0c.jpg','gallary/2016-09-10/57d3fa3b87d0c.jpg','','','jpg','application/octet-stream',57800,0,'',1473509947),(228,0,'content','free-backgrounds-11.jpg','57d4a422d0bd8.jpg','gallary/2016-09-11/57d4a422d0bd8.jpg','','','jpg','application/octet-stream',46065,0,'',1473553442),(225,0,'content','free-backgrounds-4.jpg','57d4a42175eb8.jpg','gallary/2016-09-11/57d4a42175eb8.jpg','','','jpg','application/octet-stream',38820,0,'',1473553441),(224,0,'content','free-backgrounds-1.jpg','57d4a421412f8.jpg','gallary/2016-09-11/57d4a421412f8.jpg','','','jpg','application/octet-stream',85269,0,'',1473553441),(223,0,'content','1929818.jpg','57d4a42102328.jpg','gallary/2016-09-11/57d4a42102328.jpg','','','jpg','application/octet-stream',75174,0,'',1473553441),(222,0,'content','1895637.jpg','57d4a420a8b38.jpg','gallary/2016-09-11/57d4a420a8b38.jpg','','','jpg','application/octet-stream',126982,0,'',1473553440),(216,0,'content','free-backgrounds-7.jpg','57d3fd5bc41e4.jpg','gallary/2016-09-10/57d3fd5bc41e4.jpg','','','jpg','application/octet-stream',95046,0,'',1473510747),(217,0,'content','free-backgrounds-11.jpg','57d3fd5db7e94.jpg','gallary/2016-09-10/57d3fd5db7e94.jpg','','','jpg','application/octet-stream',46065,0,'',1473510749),(218,0,'content','free-backgrounds-14.jpg','57d3fd5e377e4.jpg','gallary/2016-09-10/57d3fd5e377e4.jpg','','','jpg','application/octet-stream',53688,0,'',1473510750),(219,0,'content','free-backgrounds-15.jpg','57d3fd5ea693c.jpg','gallary/2016-09-10/57d3fd5ea693c.jpg','','','jpg','application/octet-stream',74887,0,'',1473510750),(226,0,'content','free-backgrounds-5.jpg','57d4a421b17d8.jpg','gallary/2016-09-11/57d4a421b17d8.jpg','','','jpg','application/octet-stream',51207,0,'',1473553441),(227,0,'content','free-backgrounds-7.jpg','57d4a422a6428.jpg','gallary/2016-09-11/57d4a422a6428.jpg','','','jpg','application/octet-stream',95046,0,'',1473553442),(229,0,'content','free-backgrounds-14.jpg','57d4a42327100.jpg','gallary/2016-09-11/57d4a42327100.jpg','','','jpg','application/octet-stream',53688,0,'',1473553443),(230,0,'content','free-backgrounds-15.jpg','57d4a4236a720.jpg','gallary/2016-09-11/57d4a4236a720.jpg','','','jpg','application/octet-stream',74887,0,'',1473553443),(231,0,'content','free-backgrounds-16.jpg','57d4a423b65f8.jpg','gallary/2016-09-11/57d4a423b65f8.jpg','','','jpg','application/octet-stream',48061,0,'',1473553443),(232,0,'content','free-backgrounds-23.jpg','57d4a423e9660.jpg','gallary/2016-09-11/57d4a423e9660.jpg','','','jpg','application/octet-stream',57800,0,'',1473553444),(233,0,'content','free-backgrounds-5.jpg','57d4a47202af8.jpg','gallary/2016-09-11/57d4a47202af8.jpg','','','jpg','application/octet-stream',51207,0,'',1473553522),(234,0,'content','free-backgrounds-7.jpg','57d4a4723c4d8.jpg','gallary/2016-09-11/57d4a4723c4d8.jpg','','','jpg','application/octet-stream',95046,0,'',1473553522),(235,0,'content','free-backgrounds-11.jpg','57d4a47279950.jpg','gallary/2016-09-11/57d4a47279950.jpg','','','jpg','application/octet-stream',46065,0,'',1473553522),(236,0,'content','free-backgrounds-14.jpg','57d4a472bbbe8.jpg','gallary/2016-09-11/57d4a472bbbe8.jpg','','','jpg','application/octet-stream',53688,0,'',1473553522),(237,0,'content','1895637.jpg','57d4a5d423668.jpg','gallary/2016-09-11/57d4a5d423668.jpg','','','jpg','application/octet-stream',126982,0,'',1473553876),(238,0,'content','1929818.jpg','57d4a5d45b4f0.jpg','gallary/2016-09-11/57d4a5d45b4f0.jpg','','','jpg','application/octet-stream',75174,0,'',1473553876),(239,0,'content','free-backgrounds-1.jpg','57d4a5d4927c0.jpg','gallary/2016-09-11/57d4a5d4927c0.jpg','','','jpg','application/octet-stream',85269,0,'',1473553876),(240,0,'content','free-backgrounds-4.jpg','57d4a5d4c8320.jpg','gallary/2016-09-11/57d4a5d4c8320.jpg','','','jpg','application/octet-stream',38820,0,'',1473553876),(241,0,'content','free-backgrounds-5.jpg','57d4a5d50e678.jpg','gallary/2016-09-11/57d4a5d50e678.jpg','','','jpg','application/octet-stream',51207,0,'',1473553877),(242,0,'content','free-backgrounds-7.jpg','57d4a5d548828.jpg','gallary/2016-09-11/57d4a5d548828.jpg','','','jpg','application/octet-stream',95046,0,'',1473553877),(243,0,'content','free-backgrounds-11.jpg','57d4a5d583590.jpg','gallary/2016-09-11/57d4a5d583590.jpg','','','jpg','application/octet-stream',46065,0,'',1473553877),(244,0,'content','free-backgrounds-14.jpg','57d4a5d61a5e0.jpg','gallary/2016-09-11/57d4a5d61a5e0.jpg','','','jpg','application/octet-stream',53688,0,'',1473553878),(245,0,'content','1895637.jpg','57d4b28906b6c.jpg','gallary/2016-09-11/57d4b28906b6c.jpg','','','jpg','application/octet-stream',126982,0,'',1473557129),(246,0,'content','1929818.jpg','57d4b2893da54.jpg','gallary/2016-09-11/57d4b2893da54.jpg','','','jpg','application/octet-stream',75174,0,'',1473557129),(247,0,'content','free-backgrounds-1.jpg','57d4b28970ea4.jpg','gallary/2016-09-11/57d4b28970ea4.jpg','','','jpg','application/octet-stream',85269,0,'',1473557129),(248,0,'content','free-backgrounds-4.jpg','57d4b289acbac.jpg','gallary/2016-09-11/57d4b289acbac.jpg','','','jpg','application/octet-stream',38820,0,'',1473557129),(260,0,'content','free-backgrounds-16.jpg','57df474e5815f.jpg','gallary/2016-09-19/57df474e5815f.jpg','','','jpg','image/jpeg',48061,0,'',1474250575);
/*!40000 ALTER TABLE `tbl_attach` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_attr`
--

DROP TABLE IF EXISTS `tbl_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_attr` (
  `attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(50) NOT NULL COMMENT '属性名�?,
  `attr_name_alias` char(50) NOT NULL DEFAULT '' COMMENT '[input/require+unique]属性别�?,
  `cate_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '[select]所属栏�?,
  `tips` varchar(255) NOT NULL DEFAULT '' COMMENT '属性概要说�?,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `attr_type` varchar(200) NOT NULL DEFAULT 'input' COMMENT '[select/ require]是否显示 input:文本输入, select:下拉选择,checkbox: 多�?textarea:大段内容,radio:单�?',
  `data_default` text COMMENT '[textarea]属性默认数�?,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[none]录入时间',
  PRIMARY KEY (`attr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='属性表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_attr`
--

LOCK TABLES `tbl_attr` WRITE;
/*!40000 ALTER TABLE `tbl_attr` DISABLE KEYS */;
INSERT INTO `tbl_attr` VALUES (15,'内容的标�?,'tag2',10,'文章内容的一个标�?,1,'input','这是个默认�?,1456383241),(17,'所属地�?,'area',11,'所属地�?,4,'select','1=&gt;中国\r\n2=&gt;美国',1456390017),(18,'tag水电�?,'tag',10,'胜多负少',0,'input','这是一个默认�?,1474183993),(19,'语言','language',10,'语言说明',0,'input','汉语',1474187262),(25,'tag水电�?,'tag',9,'胜多负少',0,'input','斯蒂芬是否方�?,0),(26,'所属地�?,'area',9,'所属地区的说明',0,'select','china=>中国\r\namerican=>美国\r\njapan=>日本\r\nitalian=>意大�?,0),(27,'性别','sex',9,'性别说明',0,'radio','0=>男\r\n1=>女\r\n2=>未知',0),(28,'爱好','hobby',9,'爱好的说�?,0,'checkbox','basketball=>篮球\r\nvolleyball=>排球\r\nrunning=>跑步\r\nsleepping=>睡觉\r\nlistenning=>听歌',0),(29,'介绍','intro',9,'介绍的说�?,0,'textarea','这里是介绍的neritnr内容',0);
/*!40000 ALTER TABLE `tbl_attr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_attr_val`
--

DROP TABLE IF EXISTS `tbl_attr_val`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_attr_val` (
  `attr_val_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '内容编号',
  `attr_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '属性编�?,
  `attr_name` varchar(60) NOT NULL DEFAULT '' COMMENT '属性名�?,
  `attr_val` text COMMENT '属性内�?,
  PRIMARY KEY (`attr_val_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='属性值表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_attr_val`
--

LOCK TABLES `tbl_attr_val` WRITE;
/*!40000 ALTER TABLE `tbl_attr_val` DISABLE KEYS */;
INSERT INTO `tbl_attr_val` VALUES (5,47,25,'tag','斯蒂芬是否方�?),(6,47,26,'area','american'),(7,47,27,'sex','0'),(8,47,28,'hobby','volleyball'),(9,47,29,'intro','标识：intro 说明: 介绍的说�?'),(29,50,29,'intro','11111111'),(28,50,28,'hobby','volleyball,listenning'),(27,50,27,'sex','2'),(26,50,26,'area','italian'),(25,50,25,'tag','111111');
/*!40000 ALTER TABLE `tbl_attr_val` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_bank`
--

DROP TABLE IF EXISTS `tbl_bank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_bank` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(20) NOT NULL DEFAULT '' COMMENT '银行名称',
  `bank_code` varchar(20) NOT NULL DEFAULT '' COMMENT '银行code',
  `pay_type` smallint(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式',
  `name_alias` varchar(50) NOT NULL DEFAULT '' COMMENT '银行拼音',
  `bank_logo` varchar(100) NOT NULL DEFAULT '' COMMENT '银行logo',
  `bank_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '银行限额',
  `content` text COMMENT '详细介绍',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '状�?,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否软删�?,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `soft_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时�?,
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='银行�?;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_bank`
--

LOCK TABLES `tbl_bank` WRITE;
/*!40000 ALTER TABLE `tbl_bank` DISABLE KEYS */;
INSERT INTO `tbl_bank` VALUES (7,'中国银行','1231',7,'zgyh','',80000.00,'234234234','Y',1,0,1473204914,1473206470,0,0),(8,'中国农业银行','3234',7,'zgnyyh','bank/2016-09-10/57d345f48b1c8.jpg',80000.00,'是打发士大夫','Y',0,0,1473463800,0,0,0);
/*!40000 ALTER TABLE `tbl_bank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_cate`
--

DROP TABLE IF EXISTS `tbl_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�ϼ�����',
  `cate_name` varchar(50) NOT NULL COMMENT '����',
  `cate_name_second` varchar(50) DEFAULT '' COMMENT '������(����)',
  `cate_name_alias` varchar(50) NOT NULL DEFAULT '' COMMENT 'Ψһ��ʶ',
  `content` text COMMENT '��ϸ����',
  `seo_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'seo����',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo�ؼ���',
  `seo_description` text COMMENT 'seo����',
  `img_original` varchar(200) DEFAULT '' COMMENT 'ԭʼͼƬ',
  `img_thumb` varchar(200) DEFAULT '' COMMENT '����ͼƬ',
  `page_size` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'ÿҳ��ʾ����',
  `menu_is` enum('Y','N') DEFAULT 'N' COMMENT '�Ƿ񵼺���ʾ',
  `redirect_url` varchar(255) NOT NULL DEFAULT '' COMMENT '��ת��ַ',
  `display_type` enum('page','list') NOT NULL DEFAULT 'list' COMMENT '��ʾ��ʽ',
  `template_list` varchar(50) NOT NULL DEFAULT '' COMMENT '�б�ģ��',
  `template_page` varchar(50) NOT NULL DEFAULT '' COMMENT '��ҳģ��',
  `template_show` varchar(50) NOT NULL DEFAULT '' COMMENT '����ҳģ��',
  `acl_browser` varchar(255) NOT NULL DEFAULT '' COMMENT '���Ȩ��',
  `acl_operate` varchar(255) NOT NULL DEFAULT '' COMMENT '����Ȩ��',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '״̬',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '����',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '�Ƿ���ɾ��',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '¼��ʱ��',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�ϴθ���ʱ��',
  `soft_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�������վʱ��',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ɾ��ʱ��',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cate_name_alias` (`cate_name_alias`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='�����';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cate`
--

LOCK TABLES `tbl_cate` WRITE;
/*!40000 ALTER TABLE `tbl_cate` DISABLE KEYS */;
INSERT INTO `tbl_cate` VALUES (7,0,'PHP课程','phpcourse','PHPkc','&lt;p&gt;phpCourse&lt;/p&gt;','phpCourse','phpCourse','phpCourse','special/2016-09-04/57cbc735cb070.jpg','special/2016-09-04/thumb_57cbc735cb070.jpg',0,'N','','list','list_text','list_page','show_post','','','Y',5,0,1472969714,0,0,0),(8,0,'陶明PHP学习之路','phpstudy','tmphpxxzl','&lt;p&gt;phpstudy&lt;/p&gt;','phpstudy','phpstudy','phpstudy','cate/2016-09-04/57cc34b066008.jpg','cate/2016-09-04/thumb_57cc34b066008.jpg',0,'N','','list','list_text','list_page','show_post','','','Y',11,0,1472969751,0,0,0),(9,8,'环境搭建','buildenv','hjdj','&lt;p&gt;buildenv&lt;/p&gt;','buildenv','buildenv','buildenv','special/2016-09-04/57cbc71af40b0.jpg','special/2016-09-04/thumb_57cbc71af40b0.jpg',0,'N','','list','list_text','list_page','show_post','','','Y',3,0,1472969786,0,0,0),(10,8,'快速人�?,'getstart','ksrm','    ','SEO标题�?,'SEO关键字：','SEO描述�?,'special/2016-09-04/57cbc6455de58.jpg','special/2016-09-04/thumb_57cbc6455de58.jpg',0,'N','','list','list_text','list_page','show_post','','','Y',0,0,1472972317,0,0,0),(11,8,'PHP变量','variable','phpbl','&lt;p&gt;PHP变量&lt;/p&gt;','PHP变量','PHP变量','PHP变量','','',0,'N','','list','list_text','list_page','show_post','','','Y',0,0,1472972481,0,0,0),(12,9,'Windows下的环境','','windowsxdhj','&lt;p&gt;Windows下的环境&lt;/p&gt;','','','','','',0,'N','','list','list_text','list_page','show_post','','','Y',0,0,1473649699,0,0,0),(13,9,'Linux下的环境','','linuxxdhj','&lt;p&gt;Linux下的环境&lt;/p&gt;','','','','','',0,'N','','list','list_text','list_page','show_post','','','Y',0,0,1473649729,0,0,0),(14,9,'mac下的环境','','macxdhj','&lt;p&gt;mac下的环境&lt;/p&gt;','','','','','',0,'N','','list','list_text','list_page','show_post','','','Y',0,0,1473649771,0,0,0),(15,12,'啊啊�?,'','aaa','&lt;p&gt;mac下的环境mac下的环境&lt;/p&gt;','','','','','',0,'N','','list','list_text','list_page','show_post','','','Y',0,0,1473649882,0,0,0),(16,15,'不不不不�?,'','bbbbb','  ','','','','','',0,'N','','list','list_text','list_page','show_post','','','Y',0,0,1473649895,0,0,0);
/*!40000 ALTER TABLE `tbl_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_channel`
--

DROP TABLE IF EXISTS `tbl_channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(20) NOT NULL DEFAULT '' COMMENT '银行名称',
  `bank_code` varchar(20) NOT NULL DEFAULT '' COMMENT '银行code',
  `name_alias` varchar(50) NOT NULL DEFAULT '' COMMENT '银行拼音',
  `bank_logo` varchar(100) NOT NULL DEFAULT '' COMMENT '银行logo',
  `pay_type` smallint(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式',
  `content` text COMMENT '详细介绍',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '状�?,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否软删�?,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `soft_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时�?,
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='银行�?;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_channel`
--

LOCK TABLES `tbl_channel` WRITE;
/*!40000 ALTER TABLE `tbl_channel` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_collect`
--

DROP TABLE IF EXISTS `tbl_collect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '网站路径',
  `name` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '采集项目名称',
  `url` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '采集页面url',
  `list_list` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '列表�?列表标识',
  `list_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '列表内页标题',
  `list_url` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '列表内页链接',
  `list_author` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '作�?,
  `list_date` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '时间',
  `list_hits` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '访问�?,
  `list_content` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '列表内页内容',
  `list_order` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '列表内页面其他内�?,
  `list_img` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '列表内容缩略�?,
  `isdown` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否下载图片',
  `downext` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '永许下载文件的后缀',
  `lasturl` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '最后抓取地址',
  `testurl` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '测试抓取地址',
  `charset` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '抓取页面编码',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='采集�?;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_collect`
--

LOCK TABLES `tbl_collect` WRITE;
/*!40000 ALTER TABLE `tbl_collect` DISABLE KEYS */;
INSERT INTO `tbl_collect` VALUES (2,'http://www.thinkphp.cn','thinkphp官网 - 教程','http://www.thinkphp.cn/document/index.html','ul.art-list &gt; li.cf','div.fl a','','div.sidebar div.promulgator div.name','div.related-info span:last-child','div.related-info span.ri-4','div.wrapper div.art-cnt','','',1,'','','','',1473728700,1474282369);
/*!40000 ALTER TABLE `tbl_collect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_config`
--

DROP TABLE IF EXISTS `tbl_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL DEFAULT '' COMMENT '表单�?,
  `val` varchar(50) NOT NULL DEFAULT '' COMMENT '表单种类(�?',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='系统配置�?;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_config`
--

LOCK TABLES `tbl_config` WRITE;
/*!40000 ALTER TABLE `tbl_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_desktop`
--

DROP TABLE IF EXISTS `tbl_desktop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_desktop` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '����',
  `name_pinyin` varchar(50) NOT NULL DEFAULT '' COMMENT 'ƴ��',
  `original_icon` varchar(200) NOT NULL DEFAULT '' COMMENT 'ͼ���ַ',
  `thumb_icon` varchar(200) NOT NULL DEFAULT '' COMMENT 'ͼ���ַ',
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT '��ת����',
  `width` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '�������',
  `height` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '����߶�',
  `intro` text COMMENT '�򵥽���',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '״̬',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '����',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '�Ƿ���ɾ��',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '¼��ʱ��',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�ϴθ���ʱ��',
  `soft_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�������վʱ��',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ɾ��ʱ��',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='�����';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_desktop`
--

LOCK TABLES `tbl_desktop` WRITE;
/*!40000 ALTER TABLE `tbl_desktop` DISABLE KEYS */;
INSERT INTO `tbl_desktop` VALUES (17,'qszxw','dhw23','desktop/2016-09-10/57d374fff2df0.jpg','desktop/2016-09-10/thumb_57d374fff2df0.jpg','http://qszxw.com/',1000,500,'导航的网�?....... \r\n好玩网站的学习和收集','Y',13,0,1473467415,1473475840,0,0),(27,'douban','dhw3','desktop/2016-09-10/57d3753199c28.jpg','desktop/2016-09-10/thumb_57d3753199c28.jpg','https://douban.fm',1000,500,'sdfsdfsdfsdf','Y',0,0,1473470477,1473475889,0,0),(26,'qq','dhw4','desktop/2016-09-10/57d3754b17250.jpg','desktop/2016-09-10/thumb_57d3754b17250.jpg','http://qq.com',1000,500,'khjkhjkhkj','Y',0,0,1473470037,1473475915,0,0),(24,'163网易','163wy','desktop/2016-09-10/57d3762685bd8.jpg','desktop/2016-09-10/thumb_57d3762685bd8.jpg','http://news.163.com/',1400,500,'sdfd ','Y',1,0,1473467756,1473476819,0,0),(25,'badu','dhw2','desktop/2016-09-10/57d37520cebd0.jpg','desktop/2016-09-10/thumb_57d37520cebd0.jpg','http://www.baidu.com',1000,500,'1123123123','Y',3,0,1473469267,1473475872,0,0);
/*!40000 ALTER TABLE `tbl_desktop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_follow`
--

DROP TABLE IF EXISTS `tbl_follow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_follow` (
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT 'uid�?uid关注fid',
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT 'fid�?uid关注fid'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户关系�?;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_follow`
--

LOCK TABLES `tbl_follow` WRITE;
/*!40000 ALTER TABLE `tbl_follow` DISABLE KEYS */;
INSERT INTO `tbl_follow` VALUES (3,2),(4,3),(2,1),(3,1),(3,5),(6,3),(6,4),(4,5),(5,2),(5,4),(5,6),(5,3),(2,3),(3,6),(4,1),(5,1),(1,5),(1,2),(2,4),(1,3),(1,4),(1,6);
/*!40000 ALTER TABLE `tbl_follow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_form`
--

DROP TABLE IF EXISTS `tbl_form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_form` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_form`
--

LOCK TABLES `tbl_form` WRITE;
/*!40000 ALTER TABLE `tbl_form` DISABLE KEYS */;
INSERT INTO `tbl_form` VALUES (1,'text1','text1',1351094268),(2,'text2','text2',1351094274),(3,'text3','text3',1351094281),(4,'text4','text4',1351094288),(5,'text5','text5',1351094295),(6,'text6','text6',1351094303),(7,'text7','text7',1351094311),(8,'text8','text8',1351094319),(9,'text9','text9',1351094332),(10,'text10','text10',1351094339),(11,'test11','11',1351175331),(12,'test12','12',1351175337),(13,'test13','12',1351175343),(14,'test14','14',1351175353),(15,'test15','15',1351175360);
/*!40000 ALTER TABLE `tbl_form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_menu`
--

DROP TABLE IF EXISTS `tbl_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_menu` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `name_pinyin` varchar(50) DEFAULT '' COMMENT '拼音',
  `module_name` varchar(30) NOT NULL DEFAULT '' COMMENT '对应的模块名�?,
  `controller_name` varchar(30) NOT NULL DEFAULT '' COMMENT '对应的控制器名称',
  `action_name` varchar(30) NOT NULL DEFAULT '' COMMENT '对应的方法名�?,
  `intro` text COMMENT '基本介绍',
  `seo_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo关键�?,
  `seo_description` text COMMENT 'seo描述',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '状�?,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否软删�?,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `soft_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时�?,
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='菜单�?;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_menu`
--

LOCK TABLES `tbl_menu` WRITE;
/*!40000 ALTER TABLE `tbl_menu` DISABLE KEYS */;
INSERT INTO `tbl_menu` VALUES (12,0,'菜单管理','cdgl','MangerSystem','Menu','index','管理后台系统的菜�?,'','',NULL,'Y',0,0,1473389715,0,0,0),(13,12,'所有菜�?,'sycd','MangerSystem','Menu','index','查看所有的菜单','','',NULL,'Y',0,0,1473392396,0,0,0),(14,12,'新增菜单','xzcd','MangerSystem','Menu','add','新增新的的菜�?,'','',NULL,'Y',0,0,1473392450,0,0,0);
/*!40000 ALTER TABLE `tbl_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_msg`
--

DROP TABLE IF EXISTS `tbl_msg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '发送人',
  `tid` int(11) NOT NULL DEFAULT '0' COMMENT '接受�?,
  `title` varchar(225) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状�?,
  `send_time` int(11) NOT NULL DEFAULT '0' COMMENT '发送时�?,
  `reply` int(1) NOT NULL DEFAULT '0' COMMENT '是否是回�?,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_msg`
--

LOCK TABLES `tbl_msg` WRITE;
/*!40000 ALTER TABLE `tbl_msg` DISABLE KEYS */;
INSERT INTO `tbl_msg` VALUES (1,5,3,'请问下yii2的数据库如何操作','请问下yii2的数据库如何操作，具体是增删查改怎么处理',0,1422704588,0),(2,5,3,'我已经关乎你�?,'呵呵，我已经关注你了！我们成为好友！',0,1422704682,0),(3,5,3,'今天晚上看武媚娘大结局','今天晚上看武媚娘大结局可好？本周就播完了，下周播放活色生香',0,1422704951,0),(4,5,3,'你觉得laravel框架怎么样？','我最近已在看laravel,觉得他比yii2要灵活些？大家觉得怎么样？',0,1422705046,0),(5,1,3,'yii2数据关联操作','yii2数据关联操作与技术实�?,0,1422782387,0),(6,3,1,'消息实时显示测试','消息实时显示测试消息实时显示测试消息实时显示测试消息实时显示测试消息实时显示测试消息实时显示测试',0,1422793408,0),(7,2,1,'韩流什么的弱爆了，华流才是最屌的','周董说过：韩流什么的弱爆了，华流才是最屌的，哎呦！不错哦！',0,1422793534,0),(8,4,1,'BAT三巨头抢占移动互联网','看BAT三巨头抢占移动互联网，入口很重要，占领入口大战一触即发，谁将是最后的王者，让我们拭目以�?,0,1422793639,0),(9,5,1,'响应式网页设计最新框�?,'响应式网页设计最新框架越来越流行了，我们选择bootstrap来实现这样的效果',0,1422793741,0),(10,3,2,'php消息实时推送问�?,'如何有效解决php消息实施推送问�?,0,1422844371,0),(11,2,3,'解决消息回复问题','如何有效解决解决消息回复问题',0,1422844620,1),(12,2,3,'习近平亲自主持起草军队政治规�?,'2014�?2�?0日，中共中央向全党全军转发《关于新形势下军队政治工作若干问题的决定�?,0,1422847618,0),(15,3,5,'今天晚上看武媚娘大结局','非常不错的片子！下周播放活色生香 ，期待~',0,1422862139,1),(13,1,3,'公务员职级晋升条件出�?正科�?5年享副处待遇','公务员职级晋升条件出�?正科�?5年享副处待遇',0,1422849944,0),(14,2,3,'yii2数据关联操作2','yii2数据关联操作2',0,1422850149,0),(16,3,5,'你觉得laravel框架怎么样？','我用了下，laravel确实比yii要强大得多啊',0,1422862538,1),(17,5,3,'你觉得laravel框架怎么样？','应该是这样大，以后多多交流啊',0,1422862863,1),(19,2,1,'异步过程中出现的各种问题','yii2在异步过程中出现的各种问题，需要高手来解答啊！',0,1422863063,0),(20,1,2,'韩流什么的弱爆了，华流才是最屌的','大家都来支持华语流行音乐，华流才能更吊哦�?,0,1422863139,1),(21,2,1,'中国对朝提供8万吨燃油 朝空军训练增�?,'中国对朝提供8万吨燃油 朝空军训练增�?,0,1422863389,0),(22,1,2,'中国对朝提供8万吨燃油 朝空军训练增�?,'真的是伤不起，像这种独裁国家我们还喂白眼狼！',0,1422863469,1),(23,2,1,'中国对朝提供8万吨燃油 朝空军训练增�?,'是这样的，这样的独裁国家，我们竟然和他做朋友，真是耻辱�?,0,1422863557,1),(24,1,2,'中国对朝提供8万吨燃油 朝空军训练增�?,'可不是吗？不知道领导人咋想的�?,0,1422863674,1),(25,1,5,'司机开车时徒手拔牙 致车辆失控冲下高速公�?,'司机开车时徒手拔牙 致车辆失控冲下高速公�?安全重要',0,1422863973,0),(26,5,1,'司机开车时徒手拔牙 致车辆失控冲下高速公�?,'司机开车一定要注意安全，不然就成了马路杀�?,0,1422864162,1),(27,1,3,'非常简洁的后台管理系统模板下载','非常简洁的后台管理系统模板下载非常简洁的后台管理系统模板下载',0,1422865377,0),(28,1,3,'实时消息推送检�?,'实时消息推送检测实时消息推送检�?,0,1422871016,0),(29,1,3,'实时消息推送检�?','实时消息推送检测实时消息推送检�?',0,1422871113,0),(30,1,3,'消息实时显示测试','你这傻�?,0,1458626522,1),(31,1,2,'异步过程中出现的各种问题','是的冯绍峰水电费水电费是',0,1458626622,1),(32,1,2,'韩流什么的弱爆了，华流才是最屌的','发发�?,0,1458626648,1),(33,2,1,'异步过程中出现的各种问题','是的冯绍峰水电费水电费是22',0,1458626810,1),(35,1,2,'tolisi','sdfsdf',0,1458630731,0),(36,1,2,'tolisi','sdfsdf',0,1458630739,0),(37,2,1,'11111111','22222',0,1458632575,0),(38,2,1,'3','�?,0,1458632743,0),(39,2,1,'tolisi','dddddddd',1,1458633351,1),(40,1,2,'tolisi','3333',0,1458633454,1),(41,0,0,'','sdfsdfsdf',0,0,0),(42,0,0,'','sdfsdfsdf',0,0,0),(43,0,0,'','sdfsdfsdf',0,0,0),(44,0,0,'','sdfsdfsdf',0,0,0),(45,0,2,'tolisi','sdfsdfsfsfd',0,0,0),(46,0,2,'tolisi','sdfsdf',0,0,0),(47,0,3,'sdsfs','sdfsfs',0,0,0),(48,0,3,'sdsfs','sdfsfs',0,0,0),(49,0,3,'sdsfs','sdfsfs',0,0,0),(50,0,3,'sdsfs','sdfsfs',0,0,0),(51,0,3,'sdsfs','sdfsfs',0,0,0);
/*!40000 ALTER TABLE `tbl_msg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_news`
--

DROP TABLE IF EXISTS `tbl_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_news` (
  `news_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '新闻ID',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '新闻标题',
  `title_id` varchar(100) NOT NULL DEFAULT '' COMMENT '标题唯一标识�?,
  `source` varchar(100) NOT NULL DEFAULT '' COMMENT '来源',
  `source_url` varchar(200) NOT NULL DEFAULT '' COMMENT '来源地址',
  `cate_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '[select]所属栏�?,
  `show_img` varchar(200) NOT NULL DEFAULT '' COMMENT '[image]封面图片',
  `view_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `abstract` text COMMENT '[textarea]新闻摘要',
  `content` text COMMENT '[editor]新闻内容',
  `template` varchar(200) NOT NULL DEFAULT '' COMMENT '模板',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '[none]是否删除, 只有超级管理员才能继续硬删除 0:没有删除, 1:已经删除',
  `is_show` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '[select]是否显示 1: 显示, 0:隐藏',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `tag` varchar(200) NOT NULL DEFAULT '' COMMENT '内容标签',
  `seo_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo关键�?,
  `seo_description` varchar(500) NOT NULL DEFAULT '' COMMENT 'seo描述',
  `pub_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[date]发布时间',
  `pub_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[none]发布用户ID',
  `pub_uname` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[none]发布用户�?,
  `auth` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '[select]访问权限 1:游客, 2:普通会�? 3:VIP会员',
  `recommend` varchar(200) NOT NULL DEFAULT '' COMMENT '[select]推荐 '':不推�? 0:首页',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[none]录入时间',
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='新闻�?;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_news`
--

LOCK TABLES `tbl_news` WRITE;
/*!40000 ALTER TABLE `tbl_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pay_type`
--

DROP TABLE IF EXISTS `tbl_pay_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pay_type` (
  `id` smallint(10) unsigned NOT NULL AUTO_INCREMENT,
  `pay_name` varchar(50) NOT NULL COMMENT '第三方支付名�?,
  `pay_code` varchar(50) NOT NULL DEFAULT '' COMMENT '唯一标识',
  `pay_logo` varchar(100) NOT NULL DEFAULT '' COMMENT '第三方支付logo',
  `content` text COMMENT '简单介�?,
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '状�?,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否软删�?,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `soft_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时�?,
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `pay_code` (`pay_code`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='支付方式�?;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pay_type`
--

LOCK TABLES `tbl_pay_type` WRITE;
/*!40000 ALTER TABLE `tbl_pay_type` DISABLE KEYS */;
INSERT INTO `tbl_pay_type` VALUES (7,'宝付','baofu','','宝付支付','Y',3,0,1473200339,1473203246,1473203378,1473203378),(8,'连连支付','lianlian','','连连支付','Y',0,0,1473203403,0,0,0);
/*!40000 ALTER TABLE `tbl_pay_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_post`
--

DROP TABLE IF EXISTS `tbl_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_post` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '����',
  `title_second` varchar(255) NOT NULL DEFAULT '' COMMENT '������',
  `title_alias` char(50) NOT NULL DEFAULT '' COMMENT 'Ψһ��ʶ�� ',
  `title_style` varchar(255) NOT NULL DEFAULT '' COMMENT '������ʽ',
  `title_style_serialize` varchar(255) NOT NULL COMMENT '标题样式序列�?,
  `cate_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '����ID',
  `special_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'ר����',
  `intro` text COMMENT 'ժҪ',
  `content` mediumtext NOT NULL COMMENT '����',
  `copy_from` varchar(100) NOT NULL DEFAULT '' COMMENT '��Դ',
  `copy_url` varchar(255) NOT NULL DEFAULT '' COMMENT '��Դurl',
  `user_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '�û�',
  `nickname` varchar(30) NOT NULL DEFAULT '' COMMENT '�û���',
  `author` varchar(100) NOT NULL DEFAULT '' COMMENT 'ǰ̨��ʾ����',
  `seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO����',
  `seo_description` text COMMENT 'SEO����',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO�ؼ���',
  `redirect_url` varchar(255) NOT NULL DEFAULT '' COMMENT '��תURL',
  `tags` varchar(255) NOT NULL DEFAULT '' COMMENT 'tags',
  `commend` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '�Ƿ��Ƽ�',
  `top_line` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '�Ƿ�ͷ��',
  `template` varchar(60) NOT NULL DEFAULT '' COMMENT 'ģ��',
  `img_original` varchar(200) NOT NULL DEFAULT '' COMMENT 'ԭʼͼ',
  `img_post` varchar(200) NOT NULL DEFAULT '' COMMENT '����ҳչʾͼ400*400',
  `img_zoom` varchar(200) NOT NULL DEFAULT '' COMMENT '����ҳ�Ŵ�ͼ800*800',
  `img_thumb` varchar(200) NOT NULL DEFAULT '' COMMENT '����ͼ100*100',
  `view_count` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '�������',
  `favorite_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�ղ�����',
  `attention_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '��ע����',
  `reply_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�ظ�����',
  `acl_browser` varchar(100) NOT NULL DEFAULT 'Y' COMMENT '���Ȩ��',
  `reply_allow` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '��������',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '����״̬',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '����',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '�Ƿ���ɾ��',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '¼��ʱ��',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�ϴθ���ʱ��',
  `soft_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�������վʱ��',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ɾ��ʱ��',
  PRIMARY KEY (`post_id`),
  UNIQUE KEY `title_alias` (`title_alias`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='���ݹ���';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_post`
--

LOCK TABLES `tbl_post` WRITE;
/*!40000 ALTER TABLE `tbl_post` DISABLE KEYS */;
INSERT INTO `tbl_post` VALUES (21,'士大夫似�?,'副标题：','4','color:#FFFFFF;','a:1:{s:5:\"color\";s:6:\"FFFFFF\";}',9,0,'','&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; exit;&lt;br/&gt;&lt;br/&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; exit;&lt;br/&gt;&lt;br/&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; exit;&lt;br/&gt;&lt;br/&gt;&lt;/p&gt;','','',1,'','','SEO标题�?,'SEO描述�?,'SEO关键字：','','Windows,中国大， 一个人','Y','N','','post/2016-09-05/57ccaf2c222e0.jpg','post/2016-09-05/mid_57ccaf2c222e0.jpg','post/2016-09-05/mid_57ccaf2c222e0.jpg','post/2016-09-05/thumb_57ccaf2c222e0.jpg',1,0,0,0,'Y','Y','Y',0,0,1473031980,1473578682,0,0),(22,'的士大夫','副标题：','bt','color:#FFFFFF;','a:1:{s:5:\"color\";s:6:\"FFFFFF\";}',9,3,'fdgdfg','&lt;p&gt;dfdfgdfg&lt;/p&gt;&lt;p&gt;dfgdf&lt;/p&gt;&lt;p&gt;g&lt;/p&gt;&lt;p&gt;dfgdfg&lt;/p&gt;&lt;p&gt;dfg&lt;/p&gt;&lt;p&gt;dfgd&lt;/p&gt;&lt;p&gt;dfg&lt;br/&gt;&lt;/p&gt;','','',1,'','','','','','','','N','N','','post/2016-09-10/57d3cde333b58.jpg','post/2016-09-10/mid_57d3cde333b58.jpg','post/2016-09-10/mid_57d3cde333b58.jpg','post/2016-09-10/thumb_57d3cde333b58.jpg',1,0,0,0,'Y','Y','Y',0,0,1473498596,1473664683,0,0),(23,'士大�?,'323','1','color:#FFFFFF;','',9,3,'','&lt;p&gt;sdfsdfsdf&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;as&lt;/p&gt;&lt;p&gt;das&lt;/p&gt;&lt;p&gt;d&lt;br/&gt;&lt;/p&gt;','','',1,'','','','','','','','N','N','','post/2016-09-10/57d3ce47eb8c0.jpg','post/2016-09-10/mid_57d3ce47eb8c0.jpg','post/2016-09-10/mid_57d3ce47eb8c0.jpg','post/2016-09-10/thumb_57d3ce47eb8c0.jpg',1,0,0,0,'Y','Y','Y',0,0,1473498696,0,0,0),(24,'sdfdfsdf','323','41','color:#FFFFFF;','',9,3,'','&lt;p&gt;sdfsdfsdf&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;as&lt;/p&gt;&lt;p&gt;das&lt;/p&gt;&lt;p&gt;d&lt;br/&gt;&lt;/p&gt;','','',1,'','','','','','','','N','N','','post/2016-09-10/57d3ce55dd248.jpg','post/2016-09-10/mid_57d3ce55dd248.jpg','post/2016-09-10/mid_57d3ce55dd248.jpg','post/2016-09-10/thumb_57d3ce55dd248.jpg',1,0,0,0,'Y','Y','Y',0,0,1473498710,0,0,0),(25,'士大夫似�?,'323','333','color:#FFFFFF;','',9,3,'','&lt;p&gt;sdfsdfsdf&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;as&lt;/p&gt;&lt;p&gt;das&lt;/p&gt;&lt;p&gt;d&lt;br/&gt;&lt;/p&gt;','','',1,'','','','','','','','N','N','','post/2016-09-10/57d3ce6bafbb8.jpg','post/2016-09-10/mid_57d3ce6bafbb8.jpg','post/2016-09-10/mid_57d3ce6bafbb8.jpg','post/2016-09-10/thumb_57d3ce6bafbb8.jpg',1,0,0,0,'Y','Y','Y',0,0,1473498732,0,0,0),(26,'士大夫似�?,'3233','12','color:#FFFFFF;','a:1:{s:5:\"color\";s:6:\"FFFFFF\";}',9,3,'','&lt;p&gt;sdfsdfsdf&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;as&lt;/p&gt;&lt;p&gt;das&lt;/p&gt;&lt;p&gt;d&lt;br/&gt;&lt;/p&gt;','','',1,'','','','','','','微软,helloword,ok','N','N','','post/2016-09-10/57d3ce8b3eb20.jpg','post/2016-09-10/mid_57d3ce8b3eb20.jpg','post/2016-09-10/mid_57d3ce8b3eb20.jpg','post/2016-09-10/thumb_57d3ce8b3eb20.jpg',1,0,0,0,'Y','Y','Y',0,0,1473498763,1473577039,0,0),(27,'tp文档','陆奥�?2','lax','font-weight:bold;text-decoration:underline;color:#FF9429;','a:3:{s:4:\"bold\";s:1:\"Y\";s:9:\"underline\";s:1:\"Y\";s:5:\"color\";s:6:\"FF9429\";}',9,3,'模板模板3222222','&lt;p style=&quot;margin-top: 0px !important; margin-right: 0px; margin-bottom: 14px; margin-left: 0px; padding: 0px; -webkit-tap-highlight-color: transparent; color: rgb(34, 34, 34); font-family: &amp;quot;Microsoft Yahei&amp;quot;, &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; line-height: 27.2px; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);&quot;&gt;如果要在模板中输出变量，必须在在控制器中把变量传递给模板，系统提供了assign方法对模板变量赋值，无论何种变量类型都统一使用assign赋值�?lt;/p&gt;&lt;pre style=&quot;margin: 0px 0px 14px; padding: 16px; -webkit-tap-highlight-color: transparent; overflow: auto; font-size: 13.6px; line-height: 1.45; border: 1px solid silver; border-radius: 3px; font-family: Consolas, &amp;quot;Liberation Mono&amp;quot;, Menlo, Courier, monospace; color: rgb(34, 34, 34); font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(247, 247, 247);&quot;&gt;$this-&amp;gt;assign(&amp;#39;name&amp;#39;,$value);//&amp;nbsp;下面的写法是等效�?this-&amp;gt;name&amp;nbsp;=&amp;nbsp;$value;&lt;/pre&gt;&lt;p style=&quot;margin: 0px 0px 14px; padding: 0px; -webkit-tap-highlight-color: transparent; color: rgb(34, 34, 34); font-family: &amp;quot;Microsoft Yahei&amp;quot;, &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; line-height: 27.2px; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);&quot;&gt;assign方法必须�?lt;code style=&quot;font-family: Consolas, &amp;quot;Liberation Mono&amp;quot;, Menlo, Courier, monospace; display: inline-block; border-radius: 4px; padding: 0px 0.4em; word-break: break-all; white-space: pre; line-height: 1.3; background-color: rgb(247, 247, 247);&quot;&gt;display和show方法&lt;/code&gt;之前调用，并且系统只会输出设定的变量，其它变量不会输出（系统变量例外），一定程度上保证了变量的安全性�?lt;/p&gt;&lt;blockquote class=&quot;default&quot; style=&quot;margin: 8px 0px; padding: 8px 16px; -webkit-tap-highlight-color: transparent; color: rgb(3, 130, 173); border-left: 5px solid rgb(208, 227, 240); font-family: &amp;quot;Microsoft Yahei&amp;quot;, &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; line-height: 27.2px; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(240, 247, 253);&quot;&gt;&lt;p style=&quot;margin: 0px; padding: 0px; -webkit-tap-highlight-color: transparent;&quot;&gt;系统变量可以通过特殊的标签输出，无需赋值模板变�?lt;/p&gt;&lt;/blockquote&gt;&lt;p style=&quot;margin: 0px 0px 14px; padding: 0px; -webkit-tap-highlight-color: transparent; color: rgb(34, 34, 34); font-family: &amp;quot;Microsoft Yahei&amp;quot;, &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; line-height: 27.2px; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);&quot;&gt;赋值后，就可以在模板文件中输出变量了，如果使用的是内置模板的话，就可以这样输出�?lt;span class=&quot;Apple-converted-space&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;code style=&quot;font-family: Consolas, &amp;quot;Liberation Mono&amp;quot;, Menlo, Courier, monospace; display: inline-block; border-radius: 4px; padding: 0px 0.4em; word-break: break-all; white-space: pre; line-height: 1.3; background-color: rgb(247, 247, 247);&quot;&gt;{$name}&lt;/code&gt;&lt;/p&gt;&lt;p style=&quot;margin: 0px 0px 14px; padding: 0px; -webkit-tap-highlight-color: transparent; color: rgb(34, 34, 34); font-family: &amp;quot;Microsoft Yahei&amp;quot;, &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; line-height: 27.2px; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);&quot;&gt;如果要同时输出多个模板变量，可以使用下面的方式：&lt;/p&gt;&lt;pre style=&quot;margin: 0px 0px 14px; padding: 16px; -webkit-tap-highlight-color: transparent; overflow: auto; font-size: 13.6px; line-height: 1.45; border: 1px solid silver; border-radius: 3px; font-family: Consolas, &amp;quot;Liberation Mono&amp;quot;, Menlo, Courier, monospace; color: rgb(34, 34, 34); font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(247, 247, 247);&quot;&gt;$array[&amp;#39;name&amp;#39;]&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;=&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;#39;thinkphp&amp;#39;;$array[&amp;#39;email&amp;#39;]&amp;nbsp;&amp;nbsp;&amp;nbsp;=&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;#39;liu21st@gmail.com&amp;#39;;$array[&amp;#39;phone&amp;#39;]&amp;nbsp;&amp;nbsp;&amp;nbsp;=&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;#39;12335678&amp;#39;;$this-&amp;gt;assign($array);&lt;/pre&gt;&lt;p style=&quot;margin: 0px 0px 14px; padding: 0px; -webkit-tap-highlight-color: transparent; color: rgb(34, 34, 34); font-family: &amp;quot;Microsoft Yahei&amp;quot;, &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; line-height: 27.2px; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);&quot;&gt;这样，就可以在模板文件中同时输出name、email和phone三个变量�?lt;/p&gt;&lt;p style=&quot;margin: 0px 0px 14px; padding: 0px; -webkit-tap-highlight-color: transparent; color: rgb(34, 34, 34); font-family: &amp;quot;Microsoft Yahei&amp;quot;, &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; line-height: 27.2px; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);&quot;&gt;模板变量的输出根据不同的模板引擎有不同的方法，我们在后面会专门讲解内置模板引擎的用法。如果你使用的是PHP本身作为模板引擎的话 ，就可以直接在模板文件里面输出了�?lt;span class=&quot;Apple-converted-space&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;code style=&quot;font-family: Consolas, &amp;quot;Liberation Mono&amp;quot;, Menlo, Courier, monospace; display: inline-block; border-radius: 4px; padding: 0px 0.4em; word-break: break-all; white-space: pre; line-height: 1.3; background-color: rgb(247, 247, 247);&quot;&gt;&amp;lt;?php echo $name.&amp;#39;[&amp;#39;.$email.&amp;#39;&amp;#39;.$phone.&amp;#39;]&amp;#39;;?&amp;gt;&lt;/code&gt;&lt;/p&gt;&lt;p style=&quot;margin: 0px 0px 14px; padding: 0px; -webkit-tap-highlight-color: transparent; color: rgb(34, 34, 34); font-family: &amp;quot;Microsoft Yahei&amp;quot;, &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; line-height: 27.2px; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);&quot;&gt;如果采用内置的模板引擎，可以使用�?lt;span class=&quot;Apple-converted-space&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;code style=&quot;font-family: Consolas, &amp;quot;Liberation Mono&amp;quot;, Menlo, Courier, monospace; display: inline-block; border-radius: 4px; padding: 0px 0.4em; word-break: break-all; white-space: pre; line-height: 1.3; background-color: rgb(247, 247, 247);&quot;&gt;{$name} [ {$email} {$phone} ]&lt;/code&gt;&lt;span class=&quot;Apple-converted-space&quot;&gt;&amp;nbsp;&lt;/span&gt;输出同样的内容�?lt;/p&gt;&lt;blockquote class=&quot;default&quot; style=&quot;margin: 8px 0px; padding: 8px 16px; -webkit-tap-highlight-color: transparent; color: rgb(3, 130, 173); border-left: 5px solid rgb(208, 227, 240); font-family: &amp;quot;Microsoft Yahei&amp;quot;, &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; line-height: 27.2px; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(240, 247, 253);&quot;&gt;&lt;p style=&quot;margin: 0px; padding: 0px; -webkit-tap-highlight-color: transparent;&quot;&gt;关于更多的模板标签使用，我们会在后面模板标签中详细讲解�?lt;/p&gt;&lt;/blockquote&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;','来源',' 网址 ',1,'','','标题1','描述3','关键�?',' 网址  网址 ','微软,打书,gooods','Y','Y','模板2','post/2016-09-10/57d40278e0aec.jpg','post/2016-09-10/mid_57d3ce9e4ae70.jpg','post/2016-09-10/mid_57d3ce9e4ae70.jpg','post/2016-09-10/thumb_57d40278e0aec.jpg',5,31,4,6,'Y','Y','Y',23,1,1473498782,1473579811,1473840118,1473840118),(28,'mdsf ','323','2','color:#FFFFFF;','',9,3,'','&lt;p&gt;sdfsdfsdf&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;as&lt;/p&gt;&lt;p&gt;das&lt;/p&gt;&lt;p&gt;d&lt;br/&gt;&lt;/p&gt;','','',1,'','','','','','','','N','N','','post/2016-09-10/57d3cead80db8.jpg','post/2016-09-10/mid_57d3cead80db8.jpg','post/2016-09-10/mid_57d3cead80db8.jpg','post/2016-09-10/thumb_57d3cead80db8.jpg',1,0,0,0,'Y','Y','Y',1,0,1473498798,0,0,0),(29,'上的房间�?,'323','3','color:#FFFFFF;','a:1:{s:5:\"color\";s:6:\"FFFFFF\";}',9,3,'','&lt;p&gt;sdfsdfsdf&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;as&lt;/p&gt;&lt;p&gt;das&lt;/p&gt;&lt;p&gt;d&lt;br/&gt;&lt;/p&gt;','','',1,'','','','','','','中国�?helloword,ok','N','N','','post/2016-09-10/57d3cebeeb0f0.jpg','post/2016-09-10/mid_57d3cebeeb0f0.jpg','post/2016-09-10/mid_57d3cebeeb0f0.jpg','post/2016-09-10/thumb_57d3cebeeb0f0.jpg',1,0,0,0,'Y','Y','Y',0,0,1473498815,1473578580,0,0),(30,'3fdf','323','33�?,'color:#FFFFFF;','a:1:{s:5:\"color\";s:6:\"FFFFFF\";}',10,3,'','&lt;p&gt;sdfsdfsdf&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;as&lt;/p&gt;&lt;p&gt;das&lt;/p&gt;&lt;p&gt;d&lt;br/&gt;&lt;/p&gt;','','',1,'','','','','','','微软,happy,打书','N','N','微软,happy,打书','post/2016-09-10/57d3cec982cf8.jpg','post/2016-09-10/mid_57d3cec982cf8.jpg','post/2016-09-10/mid_57d3cec982cf8.jpg','post/2016-09-10/thumb_57d3cec982cf8.jpg',1,0,0,0,'Y','Y','Y',0,0,1473498826,1473577905,0,0),(31,'标题�?,'323','123','color:#FFFFFF;','a:1:{s:5:\"color\";s:6:\"FFFFFF\";}',10,3,'','&lt;p&gt;sdfsdfsdf&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;as&lt;/p&gt;&lt;p&gt;das&lt;/p&gt;&lt;p&gt;d&lt;br/&gt;&lt;/p&gt;','','',1,'','','','','','','微软,helloword,ok，你好张师傅，共','N','N','','post/2016-09-10/57d3ced79f9e8.jpg','post/2016-09-10/mid_57d3ced79f9e8.jpg','post/2016-09-10/mid_57d3ced79f9e8.jpg','post/2016-09-10/thumb_57d3ced79f9e8.jpg',1,0,0,0,'Y','Y','Y',0,0,1473498840,1473578319,0,0),(32,'sdfhgrfhdfd','','hh','color:#FFFFFF;','',10,0,'','  ','','',1,'','','','','','','','N','N','','post/2016-09-10/57d3d21550078.jpg','post/2016-09-10/mid_57d3d21550078.jpg','post/2016-09-10/mid_57d3d21550078.jpg','post/2016-09-10/thumb_57d3d21550078.jpg',1,0,0,0,'Y','Y','Y',0,0,1473499669,0,0,0),(33,'sdfhgrfhdfd','','567','color:#FFFFFF;','',10,0,'','  ','','',1,'','','','','','','','N','N','','post/2016-09-10/57d3d222dc2a8.jpg','post/2016-09-10/mid_57d3d222dc2a8.jpg','post/2016-09-10/mid_57d3d222dc2a8.jpg','post/2016-09-10/thumb_57d3d222dc2a8.jpg',1,0,0,0,'Y','Y','Y',0,0,1473499683,0,0,0),(34,'sdfhgrfhdfd','','5676','color:#FFFFFF;','',10,0,'','  ','','',1,'','','','','','','','N','N','','post/2016-09-10/57d3d235eb4d8.jpg','post/2016-09-10/mid_57d3d235eb4d8.jpg','post/2016-09-10/mid_57d3d235eb4d8.jpg','post/2016-09-10/thumb_57d3d235eb4d8.jpg',1,0,0,0,'Y','Y','Y',0,0,1473499702,0,0,0),(35,'sdfhgrfhdfd','','97','color:#FFFFFF;','',10,0,'','  ','','',1,'','','','','','','','N','N','','post/2016-09-10/57d3d24071f70.jpg','post/2016-09-10/mid_57d3d24071f70.jpg','post/2016-09-10/mid_57d3d24071f70.jpg','post/2016-09-10/thumb_57d3d24071f70.jpg',1,0,0,0,'Y','Y','Y',0,0,1473499713,0,0,0),(36,'sdfhgrfhdfd','','9667','color:#FFFFFF;','',10,0,'','  ','','',1,'','','','','','','','N','N','','post/2016-09-10/57d3d249c1110.jpg','post/2016-09-10/mid_57d3d249c1110.jpg','post/2016-09-10/mid_57d3d249c1110.jpg','post/2016-09-10/thumb_57d3d249c1110.jpg',1,0,0,0,'Y','Y','Y',0,0,1473499722,0,0,0),(37,'sdfhgrfhdfd','','kkg','color:#FFFFFF;','',10,0,'','  ','','',1,'','','','','','','','N','N','','post/2016-09-10/57d3d250cb908.jpg','post/2016-09-10/mid_57d3d250cb908.jpg','post/2016-09-10/mid_57d3d250cb908.jpg','post/2016-09-10/thumb_57d3d250cb908.jpg',1,0,0,0,'Y','Y','Y',0,0,1473499729,0,0,0),(38,'sdfhgrfhdfd','','99','color:#FFFFFF;','',10,0,'','  ','','',1,'','','','','','','','N','N','','post/2016-09-10/57d3d2579f9e8.jpg','post/2016-09-10/mid_57d3d2579f9e8.jpg','post/2016-09-10/mid_57d3d2579f9e8.jpg','post/2016-09-10/thumb_57d3d2579f9e8.jpg',1,0,0,0,'Y','Y','Y',0,0,1473499736,0,0,0),(39,'sdfhgrfhdfd','','jmg','color:#FFFFFF;','',10,0,'','  ','','',1,'','','','','','','','N','N','','post/2016-09-10/57d3d25e6e0f0.jpg','post/2016-09-10/mid_57d3d25e6e0f0.jpg','post/2016-09-10/mid_57d3d25e6e0f0.jpg','post/2016-09-10/thumb_57d3d25e6e0f0.jpg',1,0,0,0,'Y','Y','Y',0,0,1473499743,0,0,0),(40,'中国是一个人，老师�?我我是刘阿勇','','wslayhyldbjnhm','font-weight:bold;text-decoration:underline;color:#CFFF5E;','a:3:{s:4:\"bold\";s:1:\"Y\";s:9:\"underline\";s:1:\"Y\";s:5:\"color\";s:6:\"CFFF5E\";}',11,3,'dddd','&lt;p&gt;ddddddd&lt;br/&gt;&lt;/p&gt;','','',1,'','','','','','','中国,一个人，中�?北京','Y','Y','','post/2016-09-11/57d4b28f19c1c.jpg','post/2016-09-10/mid_57d3d265a2cb0.jpg','post/2016-09-10/mid_57d3d265a2cb0.jpg','post/2016-09-11/thumb_57d4b28f19c1c.jpg',3,1,2,4,'Y','Y','Y',5,0,1473499750,1473575644,0,0),(42,'左足','','zz','color:#FFFFFF;','a:1:{s:5:\"color\";s:6:\"FFFFFF\";}',11,3,'333','&lt;p&gt;地对地导�?lt;br/&gt;&lt;/p&gt;','232','32323',1,'','','SEO标题�?,'\r\nSEO描述�?,'SEO关键字：','32','33','Y','Y','模板','post/2016-09-11/57d4a5dd21b10.jpg','post/2016-09-11/mid_57d4a5dd21b10.jpg','post/2016-09-11/mid_57d4a5dd21b10.jpg','post/2016-09-11/thumb_57d4a5dd21b10.jpg',3,1,2,4,'Y','Y','Y',5,0,1473553885,0,0,0),(50,'红岭周世平应邀参加朗迪峰会 互金大咖齐聚上海','332323','qwerdf','color:#FFFFFF;','a:1:{s:5:\"color\";s:6:\"FFFFFF\";}',9,0,'','      ','','',1,'','','','','','','','N','N','','post/2016-09-19/57df595bd7135.jpg','post/2016-09-19/mid_57df595bd7135.jpg','post/2016-09-19/mid_57df595bd7135.jpg','post/2016-09-19/thumb_57df595bd7135.jpg',1,0,0,0,'Y','Y','Y',0,0,0,1474265043,0,0);
/*!40000 ALTER TABLE `tbl_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_post_gallary`
--

DROP TABLE IF EXISTS `tbl_post_gallary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_post_gallary` (
  `gallary_id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` varchar(100) NOT NULL DEFAULT '' COMMENT '����ID',
  `attach_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '����ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�û�ID',
  `img_original` varchar(200) NOT NULL DEFAULT '' COMMENT 'ԭʼͼ',
  `img_post` varchar(200) NOT NULL DEFAULT '' COMMENT '����ҳչʾͼ',
  `img_zoom` varchar(200) NOT NULL DEFAULT '' COMMENT '����ҳ�Ŵ�ͼ',
  `img_thumb` varchar(200) NOT NULL DEFAULT '' COMMENT '����ͼ',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�ϴ�ʱ��',
  PRIMARY KEY (`gallary_id`)
) ENGINE=MyISAM AUTO_INCREMENT=249 DEFAULT CHARSET=utf8 COMMENT='������ͼ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_post_gallary`
--

LOCK TABLES `tbl_post_gallary` WRITE;
/*!40000 ALTER TABLE `tbl_post_gallary` DISABLE KEYS */;
INSERT INTO `tbl_post_gallary` VALUES (234,'21',45,1,'post/2016-09-05/57ccac75cf080.jpg','','','',0),(233,'21',44,1,'post/2016-09-05/57ccac759eef8.jpg','','','',0),(232,'21',43,1,'post/2016-09-05/57ccac7575ad0.jpg','','','',0),(231,'21',42,1,'post/2016-09-05/57ccac7534bc0.jpg','','','',0),(245,'44',260,1,'gallary/2016-09-19/57df474e5815f.jpg','gallary/2016-09-19/mid_57df474e5815f.jpg','gallary/2016-09-19/mid_57df474e5815f.jpg','gallary/2016-09-19/thumb_57df474e5815f.jpg',1474251092),(243,'22',122,1,'aa/2016-09-10/57d3cd583d798.jpg','','','',0),(244,'43',260,1,'gallary/2016-09-19/57df474e5815f.jpg','gallary/2016-09-19/mid_57df474e5815f.jpg','gallary/2016-09-19/mid_57df474e5815f.jpg','gallary/2016-09-19/thumb_57df474e5815f.jpg',1474250646),(241,'22',119,1,'aa/2016-09-10/57d3cd56c5b48.jpg','','','',0),(242,'22',120,1,'aa/2016-09-10/57d3cd57087f0.jpg','','','',0),(239,'22',117,1,'aa/2016-09-10/57d3cd564f0d8.jpg','','','',0),(240,'22',118,1,'aa/2016-09-10/57d3cd568f048.jpg','','','',0),(37,'23',123,1,'aa/2016-09-10/57d3ce4064c80.jpg','aa/2016-09-10/mid_57d3ce4064c80.jpg','aa/2016-09-10/mid_57d3ce4064c80.jpg','aa/2016-09-10/thumb_57d3ce4064c80.jpg',1473498697),(38,'23',124,1,'aa/2016-09-10/57d3ce4097130.jpg','aa/2016-09-10/mid_57d3ce4097130.jpg','aa/2016-09-10/mid_57d3ce4097130.jpg','aa/2016-09-10/thumb_57d3ce4097130.jpg',1473498698),(39,'23',125,1,'aa/2016-09-10/57d3ce40d70a0.jpg','aa/2016-09-10/mid_57d3ce40d70a0.jpg','aa/2016-09-10/mid_57d3ce40d70a0.jpg','aa/2016-09-10/thumb_57d3ce40d70a0.jpg',1473498699),(40,'24',123,1,'aa/2016-09-10/57d3ce4064c80.jpg','aa/2016-09-10/mid_57d3ce4064c80.jpg','aa/2016-09-10/mid_57d3ce4064c80.jpg','aa/2016-09-10/thumb_57d3ce4064c80.jpg',1473498711),(41,'24',124,1,'aa/2016-09-10/57d3ce4097130.jpg','aa/2016-09-10/mid_57d3ce4097130.jpg','aa/2016-09-10/mid_57d3ce4097130.jpg','aa/2016-09-10/thumb_57d3ce4097130.jpg',1473498712),(42,'24',125,1,'aa/2016-09-10/57d3ce40d70a0.jpg','aa/2016-09-10/mid_57d3ce40d70a0.jpg','aa/2016-09-10/mid_57d3ce40d70a0.jpg','aa/2016-09-10/thumb_57d3ce40d70a0.jpg',1473498713),(43,'25',123,1,'aa/2016-09-10/57d3ce4064c80.jpg','aa/2016-09-10/mid_57d3ce4064c80.jpg','aa/2016-09-10/mid_57d3ce4064c80.jpg','aa/2016-09-10/thumb_57d3ce4064c80.jpg',1473498733),(44,'25',124,1,'aa/2016-09-10/57d3ce4097130.jpg','aa/2016-09-10/mid_57d3ce4097130.jpg','aa/2016-09-10/mid_57d3ce4097130.jpg','aa/2016-09-10/thumb_57d3ce4097130.jpg',1473498734),(45,'25',125,1,'aa/2016-09-10/57d3ce40d70a0.jpg','aa/2016-09-10/mid_57d3ce40d70a0.jpg','aa/2016-09-10/mid_57d3ce40d70a0.jpg','aa/2016-09-10/thumb_57d3ce40d70a0.jpg',1473498735),(46,'26',123,1,'aa/2016-09-10/57d3ce4064c80.jpg','aa/2016-09-10/mid_57d3ce4064c80.jpg','aa/2016-09-10/mid_57d3ce4064c80.jpg','aa/2016-09-10/thumb_57d3ce4064c80.jpg',1473498764),(47,'26',124,1,'aa/2016-09-10/57d3ce4097130.jpg','aa/2016-09-10/mid_57d3ce4097130.jpg','aa/2016-09-10/mid_57d3ce4097130.jpg','aa/2016-09-10/thumb_57d3ce4097130.jpg',1473498766),(48,'26',125,1,'aa/2016-09-10/57d3ce40d70a0.jpg','aa/2016-09-10/mid_57d3ce40d70a0.jpg','aa/2016-09-10/mid_57d3ce40d70a0.jpg','aa/2016-09-10/thumb_57d3ce40d70a0.jpg',1473498766),(52,'28',123,1,'aa/2016-09-10/57d3ce4064c80.jpg','aa/2016-09-10/mid_57d3ce4064c80.jpg','aa/2016-09-10/mid_57d3ce4064c80.jpg','aa/2016-09-10/thumb_57d3ce4064c80.jpg',1473498799),(53,'28',124,1,'aa/2016-09-10/57d3ce4097130.jpg','aa/2016-09-10/mid_57d3ce4097130.jpg','aa/2016-09-10/mid_57d3ce4097130.jpg','aa/2016-09-10/thumb_57d3ce4097130.jpg',1473498800),(54,'28',125,1,'aa/2016-09-10/57d3ce40d70a0.jpg','aa/2016-09-10/mid_57d3ce40d70a0.jpg','aa/2016-09-10/mid_57d3ce40d70a0.jpg','aa/2016-09-10/thumb_57d3ce40d70a0.jpg',1473498801),(224,'29',123,1,'aa/2016-09-10/57d3ce4064c80.jpg','','','',0),(225,'29',124,1,'aa/2016-09-10/57d3ce4097130.jpg','','','',0),(226,'29',125,1,'aa/2016-09-10/57d3ce40d70a0.jpg','','','',0),(211,'30',125,1,'aa/2016-09-10/57d3ce40d70a0.jpg','','','',0),(210,'30',123,1,'aa/2016-09-10/57d3ce4064c80.jpg','','','',0),(209,'30',124,1,'aa/2016-09-10/57d3ce4097130.jpg','','','',0),(220,'31',125,1,'aa/2016-09-10/57d3ce40d70a0.jpg','','','',0),(219,'31',124,1,'aa/2016-09-10/57d3ce4097130.jpg','','','',0),(218,'31',123,1,'aa/2016-09-10/57d3ce4064c80.jpg','','','',0),(64,'1',184,1,'gallary/2016-09-10/57d3f57bb8664.jpg','gallary/2016-09-10/mid_57d3f57bb8664.jpg','gallary/2016-09-10/mid_57d3f57bb8664.jpg','gallary/2016-09-10/thumb_57d3f57bb8664.jpg',1473508745),(65,'1',185,1,'gallary/2016-09-10/57d3f57c164a4.jpg','gallary/2016-09-10/mid_57d3f57c164a4.jpg','gallary/2016-09-10/mid_57d3f57c164a4.jpg','gallary/2016-09-10/thumb_57d3f57c164a4.jpg',1473508746),(66,'1',186,1,'gallary/2016-09-10/57d3f57c6a07c.jpg','gallary/2016-09-10/mid_57d3f57c6a07c.jpg','gallary/2016-09-10/mid_57d3f57c6a07c.jpg','gallary/2016-09-10/thumb_57d3f57c6a07c.jpg',1473508747),(67,'1',187,1,'gallary/2016-09-10/57d3f57cb8664.jpg','gallary/2016-09-10/mid_57d3f57cb8664.jpg','gallary/2016-09-10/mid_57d3f57cb8664.jpg','gallary/2016-09-10/thumb_57d3f57cb8664.jpg',1473508748),(88,'',207,1,'gallary/2016-09-10/57d3fa3a4cfa4.jpg','gallary/2016-09-10/mid_57d3fa3a4cfa4.jpg','gallary/2016-09-10/mid_57d3fa3a4cfa4.jpg','gallary/2016-09-10/thumb_57d3fa3a4cfa4.jpg',1473510025),(87,'',206,1,'gallary/2016-09-10/57d3fa398465c.jpg','gallary/2016-09-10/mid_57d3fa398465c.jpg','gallary/2016-09-10/mid_57d3fa398465c.jpg','gallary/2016-09-10/thumb_57d3fa398465c.jpg',1473510024),(86,'',205,1,'gallary/2016-09-10/57d3fa3922bdc.jpg','gallary/2016-09-10/mid_57d3fa3922bdc.jpg','gallary/2016-09-10/mid_57d3fa3922bdc.jpg','gallary/2016-09-10/thumb_57d3fa3922bdc.jpg',1473510023),(85,'',204,1,'gallary/2016-09-10/57d3fa38b4bcc.jpg','gallary/2016-09-10/mid_57d3fa38b4bcc.jpg','gallary/2016-09-10/mid_57d3fa38b4bcc.jpg','gallary/2016-09-10/thumb_57d3fa38b4bcc.jpg',1473510022),(84,'',203,1,'gallary/2016-09-10/57d3fa386890c.jpg','gallary/2016-09-10/mid_57d3fa386890c.jpg','gallary/2016-09-10/mid_57d3fa386890c.jpg','gallary/2016-09-10/thumb_57d3fa386890c.jpg',1473510021),(83,'',202,1,'gallary/2016-09-10/57d3fa381b2c4.jpg','gallary/2016-09-10/mid_57d3fa381b2c4.jpg','gallary/2016-09-10/mid_57d3fa381b2c4.jpg','gallary/2016-09-10/thumb_57d3fa381b2c4.jpg',1473510020),(82,'',201,1,'gallary/2016-09-10/57d3fa37b8a4c.jpg','gallary/2016-09-10/mid_57d3fa37b8a4c.jpg','gallary/2016-09-10/mid_57d3fa37b8a4c.jpg','gallary/2016-09-10/thumb_57d3fa37b8a4c.jpg',1473510018),(81,'',200,1,'gallary/2016-09-10/57d3fa376f66c.jpg','gallary/2016-09-10/mid_57d3fa376f66c.jpg','gallary/2016-09-10/mid_57d3fa376f66c.jpg','gallary/2016-09-10/thumb_57d3fa376f66c.jpg',1473510018),(89,'',208,1,'gallary/2016-09-10/57d3fa3a9ccfc.jpg','gallary/2016-09-10/mid_57d3fa3a9ccfc.jpg','gallary/2016-09-10/mid_57d3fa3a9ccfc.jpg','gallary/2016-09-10/thumb_57d3fa3a9ccfc.jpg',1473510026),(90,'',209,1,'gallary/2016-09-10/57d3fa3aef934.jpg','gallary/2016-09-10/mid_57d3fa3aef934.jpg','gallary/2016-09-10/mid_57d3fa3aef934.jpg','gallary/2016-09-10/thumb_57d3fa3aef934.jpg',1473510027),(91,'',210,1,'gallary/2016-09-10/57d3fa3b87d0c.jpg','gallary/2016-09-10/mid_57d3fa3b87d0c.jpg','gallary/2016-09-10/mid_57d3fa3b87d0c.jpg','gallary/2016-09-10/thumb_57d3fa3b87d0c.jpg',1473510028),(132,'42',240,1,'gallary/2016-09-11/57d4a5d4c8320.jpg','gallary/2016-09-11/mid_57d4a5d4c8320.jpg','gallary/2016-09-11/mid_57d4a5d4c8320.jpg','gallary/2016-09-11/thumb_57d4a5d4c8320.jpg',1473553890),(131,'42',239,1,'gallary/2016-09-11/57d4a5d4927c0.jpg','gallary/2016-09-11/mid_57d4a5d4927c0.jpg','gallary/2016-09-11/mid_57d4a5d4927c0.jpg','gallary/2016-09-11/thumb_57d4a5d4927c0.jpg',1473553889),(130,'42',238,1,'gallary/2016-09-11/57d4a5d45b4f0.jpg','gallary/2016-09-11/mid_57d4a5d45b4f0.jpg','gallary/2016-09-11/mid_57d4a5d45b4f0.jpg','gallary/2016-09-11/thumb_57d4a5d45b4f0.jpg',1473553887),(235,'27',218,1,'gallary/2016-09-10/57d3fd5e377e4.jpg','gallary/2016-09-10/mid_57d3fd5e377e4.jpg','gallary/2016-09-10/mid_57d3fd5e377e4.jpg','gallary/2016-09-10/thumb_57d3fd5e377e4.jpg',1473579812),(129,'42',237,1,'gallary/2016-09-11/57d4a5d423668.jpg','gallary/2016-09-11/mid_57d4a5d423668.jpg','gallary/2016-09-11/mid_57d4a5d423668.jpg','gallary/2016-09-11/thumb_57d4a5d423668.jpg',1473553886),(238,'27',217,1,'gallary/2016-09-10/57d3fd5db7e94.jpg','gallary/2016-09-10/mid_57d3fd5db7e94.jpg','gallary/2016-09-10/mid_57d3fd5db7e94.jpg','gallary/2016-09-10/thumb_57d3fd5db7e94.jpg',1473579815),(237,'27',219,1,'gallary/2016-09-10/57d3fd5ea693c.jpg','gallary/2016-09-10/mid_57d3fd5ea693c.jpg','gallary/2016-09-10/mid_57d3fd5ea693c.jpg','gallary/2016-09-10/thumb_57d3fd5ea693c.jpg',1473579815),(236,'27',216,1,'gallary/2016-09-10/57d3fd5bc41e4.jpg','gallary/2016-09-10/mid_57d3fd5bc41e4.jpg','gallary/2016-09-10/mid_57d3fd5bc41e4.jpg','gallary/2016-09-10/thumb_57d3fd5bc41e4.jpg',1473579813),(133,'42',241,1,'gallary/2016-09-11/57d4a5d50e678.jpg','gallary/2016-09-11/mid_57d4a5d50e678.jpg','gallary/2016-09-11/mid_57d4a5d50e678.jpg','gallary/2016-09-11/thumb_57d4a5d50e678.jpg',1473553890),(134,'42',242,1,'gallary/2016-09-11/57d4a5d548828.jpg','gallary/2016-09-11/mid_57d4a5d548828.jpg','gallary/2016-09-11/mid_57d4a5d548828.jpg','gallary/2016-09-11/thumb_57d4a5d548828.jpg',1473553892),(135,'42',243,1,'gallary/2016-09-11/57d4a5d583590.jpg','gallary/2016-09-11/mid_57d4a5d583590.jpg','gallary/2016-09-11/mid_57d4a5d583590.jpg','gallary/2016-09-11/thumb_57d4a5d583590.jpg',1473553893),(183,'40',248,1,'gallary/2016-09-11/57d4b289acbac.jpg','gallary/2016-09-11/mid_57d4b289acbac.jpg','gallary/2016-09-11/mid_57d4b289acbac.jpg','gallary/2016-09-11/thumb_57d4b289acbac.jpg',1473575648),(182,'40',247,1,'gallary/2016-09-11/57d4b28970ea4.jpg','gallary/2016-09-11/mid_57d4b28970ea4.jpg','gallary/2016-09-11/mid_57d4b28970ea4.jpg','gallary/2016-09-11/thumb_57d4b28970ea4.jpg',1473575647),(181,'40',246,1,'gallary/2016-09-11/57d4b2893da54.jpg','gallary/2016-09-11/mid_57d4b2893da54.jpg','gallary/2016-09-11/mid_57d4b2893da54.jpg','gallary/2016-09-11/thumb_57d4b2893da54.jpg',1473575646),(180,'40',245,1,'gallary/2016-09-11/57d4b28906b6c.jpg','gallary/2016-09-11/mid_57d4b28906b6c.jpg','gallary/2016-09-11/mid_57d4b28906b6c.jpg','gallary/2016-09-11/thumb_57d4b28906b6c.jpg',1473575645),(246,'45',260,1,'gallary/2016-09-19/57df474e5815f.jpg','gallary/2016-09-19/mid_57df474e5815f.jpg','gallary/2016-09-19/mid_57df474e5815f.jpg','gallary/2016-09-19/thumb_57df474e5815f.jpg',1474254170),(247,'46',260,1,'gallary/2016-09-19/57df474e5815f.jpg','gallary/2016-09-19/mid_57df474e5815f.jpg','gallary/2016-09-19/mid_57df474e5815f.jpg','gallary/2016-09-19/thumb_57df474e5815f.jpg',1474254352),(248,'47',260,1,'gallary/2016-09-19/57df474e5815f.jpg','gallary/2016-09-19/mid_57df474e5815f.jpg','gallary/2016-09-19/mid_57df474e5815f.jpg','gallary/2016-09-19/thumb_57df474e5815f.jpg',1474254485);
/*!40000 ALTER TABLE `tbl_post_gallary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_post_tag`
--

DROP TABLE IF EXISTS `tbl_post_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_post_tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '����',
  `post_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '��¼id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�û�Id',
  `tag_name` char(30) NOT NULL COMMENT 'tag����',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '¼��ʱ��',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COMMENT='���ݱ�ǩ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_post_tag`
--

LOCK TABLES `tbl_post_tag` WRITE;
/*!40000 ALTER TABLE `tbl_post_tag` DISABLE KEYS */;
INSERT INTO `tbl_post_tag` VALUES (64,9,31,1,'微软',1473578068),(65,9,31,1,'helloword',1473578068),(66,9,31,1,'ok',1473578068),(67,9,31,1,'你好张师�?,1473578068),(68,9,31,1,'�?,1473578068),(69,9,29,1,'中国�?,1473578378),(70,9,29,1,'helloword',1473578378),(71,9,29,1,'ok',1473578378),(72,0,21,1,'Windows',1473578653),(73,0,21,1,'中国�?,1473578653),(74,0,21,1,'一个人',1473578653),(75,9,27,1,'微软',1473579811),(76,9,27,1,'打书',1473579811),(77,9,27,1,'gooods',1473579811);
/*!40000 ALTER TABLE `tbl_post_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_special`
--

DROP TABLE IF EXISTS `tbl_special`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_special` (
  `special_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `special_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'ר������',
  `name_alias` varchar(255) NOT NULL DEFAULT '' COMMENT 'ר��Ψһ��ʶ',
  `content` text COMMENT 'ר����ϸ����',
  `intro` mediumtext COMMENT 'ժҪ����',
  `img_original` varchar(100) DEFAULT '' COMMENT 'ԭʼͼƬ',
  `img_thumb` varchar(100) DEFAULT '' COMMENT '����ͼƬ',
  `seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo����',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo�ؼ���',
  `seo_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo����',
  `template` varchar(50) NOT NULL DEFAULT '' COMMENT 'ģ��',
  `view_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�������',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '״̬',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '����',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '�Ƿ���ɾ��',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '���ʱ��',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�ϴθ���ʱ��',
  `soft_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�������վʱ��',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ɾ��ʱ��',
  PRIMARY KEY (`special_id`),
  UNIQUE KEY `name_alias` (`name_alias`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='ר��';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_special`
--

LOCK TABLES `tbl_special` WRITE;
/*!40000 ALTER TABLE `tbl_special` DISABLE KEYS */;
INSERT INTO `tbl_special` VALUES (3,'php环境安装','install','&lt;p&gt;专题详细内容&lt;br/&gt;&lt;/p&gt;','摘要描述','special/2016-09-04/57cb66e19e1b0.jpg','special/2016-09-04/thumb_57cb66e19e1b0.jpg','SEO标题�?,'SEO关键字：','SEO描述�?,'摘要描述',0,'Y',0,0,1472947937,1472967137,1472967137,0),(4,'php变量操作','variables','&lt;p&gt;php变量操作&lt;/p&gt;','php变量操作','special/2016-09-04/57cb672f3dea0.jpg','special/2016-09-04/thumb_57cb672f3dea0.jpg','php变量','php变量','php变量','php变量操作',0,'Y',0,0,1472948015,1472968586,1472968586,0),(5,'php数据类型','datatype','&lt;p&gt;php数据类型&lt;/p&gt;','php数据类型','special/2016-09-04/57cb678ea4b28.jpg','special/2016-09-04/thumb_57cb678ea4b28.jpg','phpphp数据类型','php数据类型','php数据类型','',0,'Y',0,0,1472948110,0,0,0),(6,'ddfsdf2','sdfsdf','&lt;p&gt;sdfsdfsdfsdf&lt;br/&gt;&lt;/p&gt;','sdfsdf','special/2016-09-04/57cbb26c8b8d0.jpg','special/2016-09-04/thumb_57cbb26c8b8d0.jpg','','','','sdfsdf',0,'Y',3,1,1472967276,1472968129,1473562540,1473562540),(7,'3223','2323','&lt;p&gt;234234234&lt;br/&gt;&lt;/p&gt;','234234234','special/2016-09-04/57cbb3fc7f968.jpg','special/2016-09-04/thumb_57cbb3fc7f968.jpg','SEO标题�?,'SEO关键字：','SEO描述�?,'',0,'N',0,1,1472967676,0,0,0);
/*!40000 ALTER TABLE `tbl_special` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_table_fields`
--

DROP TABLE IF EXISTS `tbl_table_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_table_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `table` varchar(50) NOT NULL DEFAULT '' COMMENT '表名',
  `field` varchar(50) NOT NULL DEFAULT '' COMMENT '字段名称',
  `formtype` varchar(50) NOT NULL DEFAULT '' COMMENT '表单类型',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=utf8 COMMENT='系统�?;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_table_fields`
--

LOCK TABLES `tbl_table_fields` WRITE;
/*!40000 ALTER TABLE `tbl_table_fields` DISABLE KEYS */;
INSERT INTO `tbl_table_fields` VALUES (37,'tbl_admin','admin_id','',0,0),(38,'tbl_admin','username','input',0,0),(39,'tbl_admin','password','input',0,0),(40,'tbl_admin','nickname','number',0,0),(41,'tbl_admin','thumb','number',0,0),(42,'tbl_admin','role_id','emali',0,0),(43,'tbl_admin','email','',0,0),(44,'tbl_admin','reg_time','url',0,0),(45,'tbl_admin','last_login_time','image',0,0),(46,'tbl_admin','last_login_ip','image',0,0),(47,'tbl_admin','login_count','checkbox',0,0),(48,'tbl_admin','status','textarea',0,0),(49,'tbl_admin','remark','image',0,0),(50,'tbl_post','post_id','0',0,1473758247),(51,'tbl_post','title','input',0,1473758247),(52,'tbl_post','title_second','input',0,1473758247),(53,'tbl_post','title_alias','0',0,1473758247),(54,'tbl_post','title_style','0',0,1473758247),(55,'tbl_post','title_style_serialize','0',0,1473758247),(56,'tbl_post','cate_id','select',0,1473758247),(57,'tbl_post','special_id','select',0,1473758247),(58,'tbl_post','intro','textarea',0,1473758247),(59,'tbl_post','content','editor',0,1473758247),(60,'tbl_post','copy_from','0',0,1473758247),(61,'tbl_post','copy_url','0',0,1473758247),(62,'tbl_post','user_id','0',0,1473758247),(63,'tbl_post','nickname','0',0,1473758247),(64,'tbl_post','author','0',0,1473758247),(65,'tbl_post','seo_title','0',0,1473758247),(66,'tbl_post','seo_description','0',0,1473758247),(67,'tbl_post','seo_keywords','0',0,1473758247),(68,'tbl_post','redirect_url','0',0,1473758247),(69,'tbl_post','tags','input',0,1473758247),(70,'tbl_post','commend','select',0,1473758247),(71,'tbl_post','top_line','select',0,1473758247),(72,'tbl_post','template','0',0,1473758247),(73,'tbl_post','img_original','image',0,1473758247),(74,'tbl_post','img_post','0',0,1473758247),(75,'tbl_post','img_zoom','0',0,1473758247),(76,'tbl_post','img_thumb','0',0,1473758247),(77,'tbl_post','view_count','input',0,1473758247),(78,'tbl_post','favorite_count','input',0,1473758247),(79,'tbl_post','attention_count','input',0,1473758247),(80,'tbl_post','reply_count','input',0,1473758247),(81,'tbl_post','acl_browser','0',0,1473758247),(82,'tbl_post','reply_allow','select',0,1473758247),(83,'tbl_post','status_is','select',0,1473758247),(84,'tbl_post','sort_order','input',0,1473758247),(85,'tbl_post','is_deleted','0',0,1473758247),(86,'tbl_post','create_time','0',0,1473758247),(87,'tbl_post','update_time','0',0,1473758247),(88,'tbl_post','soft_delete_time','0',0,1473758247),(89,'tbl_post','delete_time','0',0,1473758247);
/*!40000 ALTER TABLE `tbl_table_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_tags`
--

DROP TABLE IF EXISTS `tbl_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '����',
  `module` varchar(50) NOT NULL DEFAULT '' COMMENT 'ģ��',
  `tag_name` char(30) NOT NULL COMMENT 'tag����',
  `data_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '��������',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '¼��ʱ��',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COMMENT='��ǩͳ��';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tags`
--

LOCK TABLES `tbl_tags` WRITE;
/*!40000 ALTER TABLE `tbl_tags` DISABLE KEYS */;
INSERT INTO `tbl_tags` VALUES (58,9,'post','微软',2,1473578068),(59,9,'post','helloword',2,1473578068),(60,9,'post','ok',2,1473578068),(61,9,'post','你好张师�?,1,1473578068),(62,9,'post','�?,1,1473578068),(63,9,'post','中国�?,2,1473578378),(64,0,'post','Windows',1,1473578653),(65,0,'post','一个人',1,1473578653),(66,9,'post','打书',1,1473579811),(67,9,'post','gooods',1,1473579811);
/*!40000 ALTER TABLE `tbl_tags` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-19 18:55:36
