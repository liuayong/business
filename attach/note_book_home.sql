-- MySQL dump 10.13  Distrib 5.1.49, for Win32 (ia32)
--
-- Host: localhost    Database: note_book
-- ------------------------------------------------------
-- Server version	5.1.49-community

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
-- Current Database: `note_book`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `note_book` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `note_book`;

--
-- Table structure for table `tbl_admin`
--

DROP TABLE IF EXISTS `tbl_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `thumb` varchar(225) NOT NULL DEFAULT '' COMMENT '图像地址',
  `role_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '[select]角色ID',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱地址',
  `reg_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `last_login_ip` varchar(25) NOT NULL DEFAULT '' COMMENT '上次登录IP',
  `login_count` smallint(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态, 1:激活, 0:禁用',
  `remark` text COMMENT '备注说明',
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='后台用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_admin`
--

LOCK TABLES `tbl_admin` WRITE;
/*!40000 ALTER TABLE `tbl_admin` DISABLE KEYS */;
INSERT INTO `tbl_admin` VALUES (1,'admin','0C909A141F1F2C0A1CB602B0B2D7D050','管理员','2016-09-01/57c7943bd09aa.jpg',0,'admin@admin.com',0,1473198390,'127.0.0.1',10,1,NULL),(2,'lisi','FF9041128F5AE17404CEC64729D2DC36','李四','face.jpg',0,'lisi@126.com',0,0,'',0,1,NULL),(3,'aman','89567C7661B2C380E9AD7D9659C441A3','曹阿瞒','face.jpg',0,'zfeig@126.com',0,0,'',0,0,NULL),(4,'baidu','0DC2FE433EC0B6E14DCEE9E7DBB5B3CF','百度','face.jpg',0,'baidu@126.com',0,0,'',0,1,NULL),(5,'xiaoq','7E9530E70AEBF7530A6BF23273B7D7EB','小强','face.jpg',0,'xiaoq@126.com',0,0,'',0,1,NULL),(6,'cong','281813F2A06D80DD078DB47112BFF8DE','聪哥','face.jpg',0,'cong@126.com',0,0,'',0,1,NULL),(7,'admin2','E054F90719313DA598422263CFBE7FDF','你好','',0,'',1473728700,0,'',0,0,NULL);
/*!40000 ALTER TABLE `tbl_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_admin2`
--

DROP TABLE IF EXISTS `tbl_admin2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_admin2` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `thumb` varchar(225) NOT NULL DEFAULT '' COMMENT '图像地址',
  `role_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '[select]角色ID',
  `reg_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `last_login_ip` varchar(25) NOT NULL DEFAULT '' COMMENT '上次登录IP',
  `login_count` smallint(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态, 1:激活, 0:禁用',
  `remark` text COMMENT '备注说明',
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='后台用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_admin2`
--

LOCK TABLES `tbl_admin2` WRITE;
/*!40000 ALTER TABLE `tbl_admin2` DISABLE KEYS */;
INSERT INTO `tbl_admin2` VALUES (1,'admin','0B77520F93DE693BDAB0060746E38165','','',1,1451546400,1472549145,'127.0.0.1',0,1,'sfsdfsdf'),(2,'honline','0B77520F93DE693BDAB0060746E38165','','',8,1457678929,1458035703,'0.0.0.0',0,1,'sdfsdf1'),(3,'liuayong','0B77520F93DE693BDAB0060746E38165','','',9,1458035911,1458105922,'192.168.11.72',0,1,'123123');
/*!40000 ALTER TABLE `tbl_admin2` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `tbl_attach`
--

DROP TABLE IF EXISTS `tbl_attach`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_attach` (
  `attach_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户名',
  `scope` enum('content','image') NOT NULL DEFAULT 'content' COMMENT '模块',
  `real_name` varchar(100) NOT NULL DEFAULT '' COMMENT '原始文件名称',
  `save_name` varchar(100) NOT NULL DEFAULT '' COMMENT '保存文件名不带路径',
  `save_path` varchar(200) NOT NULL DEFAULT '' COMMENT '保存路径',
  `thumb_path` varchar(200) NOT NULL DEFAULT '' COMMENT '缩略图',
  `hash` char(32) NOT NULL DEFAULT '' COMMENT 'hash',
  `file_ext` char(5) NOT NULL DEFAULT 'jpg' COMMENT '扩展名称',
  `file_mime` varchar(50) NOT NULL DEFAULT '' COMMENT '文件头信息',
  `file_size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `down_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `access` varchar(255) NOT NULL DEFAULT '' COMMENT '权限控制',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  PRIMARY KEY (`attach_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='附件表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_attach`
--

LOCK TABLES `tbl_attach` WRITE;
/*!40000 ALTER TABLE `tbl_attach` DISABLE KEYS */;
INSERT INTO `tbl_attach` VALUES (28,1,'content','28115001561.jpg','57cc441f7c63c.jpg','post/2016-09-04/57cc441f7c63c.jpg','','','jpg','',133009,0,'',1473004575),(29,1,'content','28115001562.jpg','57cc441fab054.jpg','post/2016-09-04/57cc441fab054.jpg','','','jpg','',44282,0,'',1473004575),(30,1,'content','251244071210.jpg','57cc44200f424.jpg','post/2016-09-04/57cc44200f424.jpg','','','jpg','',61158,0,'',1473004576),(31,1,'content','251244071213.jpg','57cc44203e224.jpg','post/2016-09-04/57cc44203e224.jpg','','','jpg','',79692,0,'',1473004576),(32,1,'content','251244071210.jpg','57cc45359e91c.jpg','post/2016-09-05/57cc45359e91c.jpg','','','jpg','',61158,0,'',1473004853),(33,1,'content','Desert.jpg','57cc46b24b514.jpg','post/2016-09-05/57cc46b24b514.jpg','','','jpg','image/jpeg',845941,0,'',1473005234),(34,1,'content','28115001562.jpg','57cc46ebe1f3c.jpg','post/2016-09-05/57cc46ebe1f3c.jpg','','','jpg','application/octet-stream',44282,0,'',1473005291),(35,1,'content','251244071210.jpg','57cc46ec2ff94.jpg','post/2016-09-05/57cc46ec2ff94.jpg','','','jpg','application/octet-stream',61158,0,'',1473005292),(36,0,'content','28115001562.jpg','57cc9a86d76e0.jpg','post/2016-09-05/57cc9a86d76e0.jpg','','','jpg','application/octet-stream',44282,0,'',1473026694),(37,0,'content','251244071212.jpg','57cc9a9264708.jpg','post/2016-09-05/57cc9a9264708.jpg','','','jpg','application/octet-stream',97129,0,'',1473026706),(38,0,'content','251244071213.jpg','57cc9a92846c0.jpg','post/2016-09-05/57cc9a92846c0.jpg','','','jpg','application/octet-stream',79692,0,'',1473026706),(39,0,'content','28115001560.jpg','57cca53e1e078.jpg','post/2016-09-05/57cca53e1e078.jpg','','','jpg','application/octet-stream',132910,0,'',1473029438),(40,0,'content','251244071212.jpg','57cca61972038.jpg','post/2016-09-05/57cca61972038.jpg','','','jpg','application/octet-stream',97129,0,'',1473029657),(41,0,'content','251244071213.jpg','57cca6199d3a0.jpg','post/2016-09-05/57cca6199d3a0.jpg','','','jpg','application/octet-stream',79692,0,'',1473029657),(42,0,'content','28115001561.jpg','57ccac7534bc0.jpg','post/2016-09-05/57ccac7534bc0.jpg','','','jpg','application/octet-stream',133009,0,'',1473031285),(43,0,'content','28115001562.jpg','57ccac7575ad0.jpg','post/2016-09-05/57ccac7575ad0.jpg','','','jpg','application/octet-stream',44282,0,'',1473031285),(44,0,'content','251244071210.jpg','57ccac759eef8.jpg','post/2016-09-05/57ccac759eef8.jpg','','','jpg','application/octet-stream',61158,0,'',1473031285),(45,0,'content','251244071213.jpg','57ccac75cf080.jpg','post/2016-09-05/57ccac75cf080.jpg','','','jpg','application/octet-stream',79692,0,'',1473031285);
/*!40000 ALTER TABLE `tbl_attach` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_cate`
--

DROP TABLE IF EXISTS `tbl_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类',
  `cate_name` varchar(50) NOT NULL COMMENT '名称',
  `cate_name_second` varchar(50) DEFAULT '' COMMENT '副名称(别名)',
  `cate_name_alias` varchar(50) NOT NULL DEFAULT '' COMMENT '唯一标识',
  `content` text COMMENT '详细介绍',
  `seo_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo关键字',
  `seo_description` text COMMENT 'seo描述',
  `img_original` varchar(200) DEFAULT '' COMMENT '原始图片',
  `img_thumb` varchar(200) DEFAULT '' COMMENT '缩略图片',
  `page_size` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '每页显示数量',
  `menu_is` enum('Y','N') DEFAULT 'N' COMMENT '是否导航显示',
  `redirect_url` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转地址',
  `display_type` enum('page','list') NOT NULL DEFAULT 'list' COMMENT '显示方式',
  `template_list` varchar(50) NOT NULL DEFAULT '' COMMENT '列表模板',
  `template_page` varchar(50) NOT NULL DEFAULT '' COMMENT '单页模板',
  `template_show` varchar(50) NOT NULL DEFAULT '' COMMENT '内容页模板',
  `acl_browser` varchar(255) NOT NULL DEFAULT '' COMMENT '浏览权限',
  `acl_operate` varchar(255) NOT NULL DEFAULT '' COMMENT '操作权限',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '状态',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否软删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `soft_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cate_name_alias` (`cate_name_alias`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='分类表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cate`
--

LOCK TABLES `tbl_cate` WRITE;
/*!40000 ALTER TABLE `tbl_cate` DISABLE KEYS */;
INSERT INTO `tbl_cate` VALUES (7,0,'PHP课程','phpcourse','PHPkc','&lt;p&gt;phpCourse&lt;/p&gt;','phpCourse','phpCourse','phpCourse','special/2016-09-04/57cbc735cb070.jpg','special/2016-09-04/thumb_57cbc735cb070.jpg',0,'N','','list','list_text','list_page','show_post','','','Y',5,0,1472969714,0,0,0),(8,0,'陶明PHP学习之路','phpstudy','tmphpxxzl','&lt;p&gt;phpstudy&lt;/p&gt;','phpstudy','phpstudy','phpstudy','cate/2016-09-04/57cc34b066008.jpg','cate/2016-09-04/thumb_57cc34b066008.jpg',0,'N','','list','list_text','list_page','show_post','','','Y',11,0,1472969751,0,0,0),(9,8,'环境搭建','buildenv','hjdj','&lt;p&gt;buildenv&lt;/p&gt;','buildenv','buildenv','buildenv','special/2016-09-04/57cbc71af40b0.jpg','special/2016-09-04/thumb_57cbc71af40b0.jpg',0,'N','','list','list_text','list_page','show_post','','','Y',3,0,1472969786,0,0,0),(10,8,'快速人们','getstart','ksrm','    ','SEO标题：','SEO关键字：','SEO描述：','special/2016-09-04/57cbc6455de58.jpg','special/2016-09-04/thumb_57cbc6455de58.jpg',0,'N','','list','list_text','list_page','show_post','','','Y',0,0,1472972317,0,0,0),(11,8,'PHP变量','variable','phpbl','&lt;p&gt;PHP变量&lt;/p&gt;','PHP变量','PHP变量','PHP变量','','',0,'N','','list','list_text','list_page','show_post','','','Y',0,0,1472972481,0,0,0);
/*!40000 ALTER TABLE `tbl_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_follow`
--

DROP TABLE IF EXISTS `tbl_follow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_follow` (
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT 'uid主 uid关注fid',
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT 'fid客 uid关注fid'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户关系表';
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
-- Table structure for table `tbl_msg`
--

DROP TABLE IF EXISTS `tbl_msg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '发送人',
  `tid` int(11) NOT NULL DEFAULT '0' COMMENT '接受人',
  `title` varchar(225) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `send_time` int(11) NOT NULL DEFAULT '0' COMMENT '发送时间',
  `reply` int(1) NOT NULL DEFAULT '0' COMMENT '是否是回复',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_msg`
--

LOCK TABLES `tbl_msg` WRITE;
/*!40000 ALTER TABLE `tbl_msg` DISABLE KEYS */;
INSERT INTO `tbl_msg` VALUES (1,5,3,'请问下yii2的数据库如何操作','请问下yii2的数据库如何操作，具体是增删查改怎么处理',0,1422704588,0),(2,5,3,'我已经关乎你了','呵呵，我已经关注你了！我们成为好友！',0,1422704682,0),(3,5,3,'今天晚上看武媚娘大结局','今天晚上看武媚娘大结局可好？本周就播完了，下周播放活色生香',0,1422704951,0),(4,5,3,'你觉得laravel框架怎么样？','我最近已在看laravel,觉得他比yii2要灵活些？大家觉得怎么样？',0,1422705046,0),(5,1,3,'yii2数据关联操作','yii2数据关联操作与技术实践',0,1422782387,0),(6,3,1,'消息实时显示测试','消息实时显示测试消息实时显示测试消息实时显示测试消息实时显示测试消息实时显示测试消息实时显示测试',0,1422793408,0),(7,2,1,'韩流什么的弱爆了，华流才是最屌的','周董说过：韩流什么的弱爆了，华流才是最屌的，哎呦！不错哦！',0,1422793534,0),(8,4,1,'BAT三巨头抢占移动互联网','看BAT三巨头抢占移动互联网，入口很重要，占领入口大战一触即发，谁将是最后的王者，让我们拭目以待',0,1422793639,0),(9,5,1,'响应式网页设计最新框架','响应式网页设计最新框架越来越流行了，我们选择bootstrap来实现这样的效果',0,1422793741,0),(10,3,2,'php消息实时推送问题','如何有效解决php消息实施推送问题',0,1422844371,0),(11,2,3,'解决消息回复问题','如何有效解决解决消息回复问题',0,1422844620,1),(12,2,3,'习近平亲自主持起草军队政治规定','2014年12月30日，中共中央向全党全军转发《关于新形势下军队政治工作若干问题的决定》',0,1422847618,0),(15,3,5,'今天晚上看武媚娘大结局','非常不错的片子！下周播放活色生香 ，期待~',0,1422862139,1),(13,1,3,'公务员职级晋升条件出炉:正科满15年享副处待遇','公务员职级晋升条件出炉:正科满15年享副处待遇',0,1422849944,0),(14,2,3,'yii2数据关联操作2','yii2数据关联操作2',0,1422850149,0),(16,3,5,'你觉得laravel框架怎么样？','我用了下，laravel确实比yii要强大得多啊',0,1422862538,1),(17,5,3,'你觉得laravel框架怎么样？','应该是这样大，以后多多交流啊',0,1422862863,1),(19,2,1,'异步过程中出现的各种问题','yii2在异步过程中出现的各种问题，需要高手来解答啊！',0,1422863063,0),(20,1,2,'韩流什么的弱爆了，华流才是最屌的','大家都来支持华语流行音乐，华流才能更吊哦！',0,1422863139,1),(21,2,1,'中国对朝提供8万吨燃油 朝空军训练增加','中国对朝提供8万吨燃油 朝空军训练增加',0,1422863389,0),(22,1,2,'中国对朝提供8万吨燃油 朝空军训练增加','真的是伤不起，像这种独裁国家我们还喂白眼狼！',0,1422863469,1),(23,2,1,'中国对朝提供8万吨燃油 朝空军训练增加','是这样的，这样的独裁国家，我们竟然和他做朋友，真是耻辱吧',0,1422863557,1),(24,1,2,'中国对朝提供8万吨燃油 朝空军训练增加','可不是吗？不知道领导人咋想的？',0,1422863674,1),(25,1,5,'司机开车时徒手拔牙 致车辆失控冲下高速公路','司机开车时徒手拔牙 致车辆失控冲下高速公路,安全重要',0,1422863973,0),(26,5,1,'司机开车时徒手拔牙 致车辆失控冲下高速公路','司机开车一定要注意安全，不然就成了马路杀手',0,1422864162,1),(27,1,3,'非常简洁的后台管理系统模板下载','非常简洁的后台管理系统模板下载非常简洁的后台管理系统模板下载',0,1422865377,0),(28,1,3,'实时消息推送检测','实时消息推送检测实时消息推送检测',0,1422871016,0),(29,1,3,'实时消息推送检测2','实时消息推送检测实时消息推送检测2',0,1422871113,0),(30,1,3,'消息实时显示测试','你这傻逼',0,1458626522,1),(31,1,2,'异步过程中出现的各种问题','是的冯绍峰水电费水电费是',0,1458626622,1),(32,1,2,'韩流什么的弱爆了，华流才是最屌的','发发发',0,1458626648,1),(33,2,1,'异步过程中出现的各种问题','是的冯绍峰水电费水电费是22',0,1458626810,1),(35,1,2,'tolisi','sdfsdf',0,1458630731,0),(36,1,2,'tolisi','sdfsdf',0,1458630739,0),(37,2,1,'11111111','22222',0,1458632575,0),(38,2,1,'3','的',0,1458632743,0),(39,2,1,'tolisi','dddddddd',1,1458633351,1),(40,1,2,'tolisi','3333',0,1458633454,1),(41,0,0,'','sdfsdfsdf',0,0,0),(42,0,0,'','sdfsdfsdf',0,0,0),(43,0,0,'','sdfsdfsdf',0,0,0),(44,0,0,'','sdfsdfsdf',0,0,0),(45,0,2,'tolisi','sdfsdfsfsfd',0,0,0),(46,0,2,'tolisi','sdfsdf',0,0,0),(47,0,3,'sdsfs','sdfsfs',0,0,0),(48,0,3,'sdsfs','sdfsfs',0,0,0),(49,0,3,'sdsfs','sdfsfs',0,0,0),(50,0,3,'sdsfs','sdfsfs',0,0,0),(51,0,3,'sdsfs','sdfsfs',0,0,0);
/*!40000 ALTER TABLE `tbl_msg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_post`
--

DROP TABLE IF EXISTS `tbl_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_post` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `title_second` varchar(255) NOT NULL DEFAULT '' COMMENT '副标题',
  `title_alias` char(50) NOT NULL DEFAULT '' COMMENT '唯一标识符 ',
  `title_style` varchar(255) NOT NULL DEFAULT '' COMMENT '标题样式',
  `cate_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `special_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '专题编号',
  `intro` text COMMENT '摘要',
  `content` mediumtext NOT NULL COMMENT '内容',
  `copy_from` varchar(100) NOT NULL DEFAULT '' COMMENT '来源',
  `copy_url` varchar(255) NOT NULL DEFAULT '' COMMENT '来源url',
  `user_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '用户',
  `nickname` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `author` varchar(100) NOT NULL DEFAULT '' COMMENT '前台显示作者',
  `seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_description` text COMMENT 'SEO描述',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  `redirect_url` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转URL',
  `tags` varchar(255) NOT NULL DEFAULT '' COMMENT 'tags',
  `commend` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '是否推荐',
  `top_line` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '是否头条',
  `template` varchar(60) NOT NULL DEFAULT '' COMMENT '模板',
  `img_original` varchar(200) NOT NULL DEFAULT '' COMMENT '原始图',
  `img_post` varchar(200) NOT NULL DEFAULT '' COMMENT '详情页展示图400*400',
  `img_zoom` varchar(200) NOT NULL DEFAULT '' COMMENT '详情页放大镜图800*800',
  `img_thumb` varchar(200) NOT NULL DEFAULT '' COMMENT '缩略图100*100',
  `view_count` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '浏览次数',
  `favorite_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数量',
  `attention_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注次数',
  `reply_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '回复次数',
  `acl_browser` varchar(100) NOT NULL DEFAULT 'Y' COMMENT '浏览权限',
  `reply_allow` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '允许评论',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '内容状态',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否软删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `soft_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`post_id`),
  UNIQUE KEY `title_alias` (`title_alias`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='内容管理';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_post`
--

LOCK TABLES `tbl_post` WRITE;
/*!40000 ALTER TABLE `tbl_post` DISABLE KEYS */;
INSERT INTO `tbl_post` VALUES (21,'标题：','副标题：','bt','text-decoration:underline;color:#FFFFFF;',1,0,'','&lt;p&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; exit;&lt;br/&gt;&lt;br/&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; exit;&lt;br/&gt;&lt;br/&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; exit;&lt;br/&gt;&lt;br/&gt;&lt;/p&gt;','','',1,'','','SEO标题：','SEO描述：',' SEO关键字：','','','N','N','','post/2016-09-05/57ccaf2c222e0.jpg','post/2016-09-05/mid_57ccaf2c222e0.jpg','post/2016-09-05/mid_57ccaf2c222e0.jpg','post/2016-09-05/thumb_57ccaf2c222e0.jpg',1,0,0,0,'Y','Y','Y',0,0,1473031980,0,0,0);
/*!40000 ALTER TABLE `tbl_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_post_gallary`
--

DROP TABLE IF EXISTS `tbl_post_gallary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_post_gallary` (
  `gallary_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` varchar(100) NOT NULL DEFAULT '' COMMENT '内容ID',
  `attach_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '附件ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `img_original` varchar(200) NOT NULL DEFAULT '' COMMENT '原始图',
  `img_post` varchar(200) NOT NULL DEFAULT '' COMMENT '详情页展示图',
  `img_zoom` varchar(200) NOT NULL DEFAULT '' COMMENT '详情页放大镜图',
  `img_thumb` varchar(200) NOT NULL DEFAULT '' COMMENT '缩略图',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  PRIMARY KEY (`gallary_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='内容组图';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_post_gallary`
--

LOCK TABLES `tbl_post_gallary` WRITE;
/*!40000 ALTER TABLE `tbl_post_gallary` DISABLE KEYS */;
INSERT INTO `tbl_post_gallary` VALUES (28,'21',42,1,'post/2016-09-05/57ccac7534bc0.jpg','post/2016-09-05/mid_57ccac7534bc0.jpg','post/2016-09-05/mid_57ccac7534bc0.jpg','post/2016-09-05/thumb_57ccac7534bc0.jpg',1473031981),(29,'21',43,1,'post/2016-09-05/57ccac7575ad0.jpg','post/2016-09-05/mid_57ccac7575ad0.jpg','post/2016-09-05/mid_57ccac7575ad0.jpg','post/2016-09-05/thumb_57ccac7575ad0.jpg',1473031981),(30,'21',44,1,'post/2016-09-05/57ccac759eef8.jpg','post/2016-09-05/mid_57ccac759eef8.jpg','post/2016-09-05/mid_57ccac759eef8.jpg','post/2016-09-05/thumb_57ccac759eef8.jpg',1473031981),(31,'21',45,1,'post/2016-09-05/57ccac75cf080.jpg','post/2016-09-05/mid_57ccac75cf080.jpg','post/2016-09-05/mid_57ccac75cf080.jpg','post/2016-09-05/thumb_57ccac75cf080.jpg',1473031981);
/*!40000 ALTER TABLE `tbl_post_gallary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_special`
--

DROP TABLE IF EXISTS `tbl_special`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_special` (
  `special_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `special_name` varchar(255) NOT NULL DEFAULT '' COMMENT '专题名称',
  `name_alias` varchar(255) NOT NULL DEFAULT '' COMMENT '专题唯一标识',
  `content` text COMMENT '专题详细内容',
  `intro` mediumtext COMMENT '摘要描述',
  `img_original` varchar(100) DEFAULT '' COMMENT '原始图片',
  `img_thumb` varchar(100) DEFAULT '' COMMENT '缩略图片',
  `seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo关键字',
  `seo_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo描述',
  `template` varchar(50) NOT NULL DEFAULT '' COMMENT '模板',
  `view_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '状态',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否软删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '入库时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `soft_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`special_id`),
  UNIQUE KEY `name_alias` (`name_alias`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='专题';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_special`
--

LOCK TABLES `tbl_special` WRITE;
/*!40000 ALTER TABLE `tbl_special` DISABLE KEYS */;
INSERT INTO `tbl_special` VALUES (3,'php环境安装','install','&lt;p&gt;专题详细内容&lt;br/&gt;&lt;/p&gt;','摘要描述','special/2016-09-04/57cb66e19e1b0.jpg','special/2016-09-04/thumb_57cb66e19e1b0.jpg','SEO标题：','SEO关键字：','SEO描述：','摘要描述',0,'Y',0,0,1472947937,1472967137,1472967137,0),(4,'php变量操作','variables','&lt;p&gt;php变量操作&lt;/p&gt;','php变量操作','special/2016-09-04/57cb672f3dea0.jpg','special/2016-09-04/thumb_57cb672f3dea0.jpg','php变量','php变量','php变量','php变量操作',0,'Y',0,0,1472948015,1472968586,1472968586,0),(5,'php数据类型','datatype','&lt;p&gt;php数据类型&lt;/p&gt;','php数据类型','special/2016-09-04/57cb678ea4b28.jpg','special/2016-09-04/thumb_57cb678ea4b28.jpg','phpphp数据类型','php数据类型','php数据类型','',0,'Y',0,0,1472948110,0,0,0),(6,'ddfsdf2','sdfsdf','&lt;p&gt;sdfsdfsdfsdf&lt;br/&gt;&lt;/p&gt;','sdfsdf','special/2016-09-04/57cbb26c8b8d0.jpg','special/2016-09-04/thumb_57cbb26c8b8d0.jpg','','','','sdfsdf',0,'Y',3,0,1472967276,1472968129,1472968129,0),(7,'3223','2323','&lt;p&gt;234234234&lt;br/&gt;&lt;/p&gt;','234234234','special/2016-09-04/57cbb3fc7f968.jpg','special/2016-09-04/thumb_57cbb3fc7f968.jpg','SEO标题：','SEO关键字：','SEO描述：','',0,'N',0,1,1472967676,0,0,0);
/*!40000 ALTER TABLE `tbl_special` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-10 14:44:38
