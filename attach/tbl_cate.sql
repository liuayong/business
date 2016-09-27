/*
Navicat MySQL Data Transfer

Source Server         : 本地连接
Source Server Version : 50149
Source Host           : localhost:3306
Source Database       : business

Target Server Type    : MYSQL
Target Server Version : 50149
File Encoding         : 65001

Date: 2016-09-28 05:45:21
*/

SET FOREIGN_KEY_CHECKS=0;


DROP TABLE IF EXISTS `tbl_cate`;
CREATE TABLE `tbl_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类',
  `cate_name` varchar(50) NOT NULL default '' COMMENT '名称',
  `cate_name_second` varchar(50) DEFAULT '' COMMENT '副名称(别名)',
  `cate_name_alias` varchar(50) NOT NULL DEFAULT '' COMMENT '唯一标识',
  `content` text COMMENT '详细介绍',
  `seo_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo关键字',
  `seo_description` text COMMENT 'seo描述',
  `img_original` varchar(200) DEFAULT '' COMMENT '原始图片',
  `img_thumb` varchar(200) DEFAULT '' COMMENT '缩略图片',
  `page_size` smallint unsigned NOT NULL DEFAULT '0' COMMENT '每页显示数量',
  `menu_is` enum('Y','N') DEFAULT 'N' COMMENT '是否导航显示',
   home_recommand tinyint(3) unsigned not null default 0 comment '首页推荐',
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




-- ----------------------------
-- Records of tbl_cate
-- ----------------------------
INSERT INTO `tbl_cate` VALUES ('2', '0', 'PHP课程', 'phpcourse', 'PHPkc', '&lt;p&gt;phpCourse&lt;/p&gt;', 'phpCourse', 'phpCourse', 'phpCourse', 'special/2016-09-04/57cbc735cb070.jpg', 'special/2016-09-04/thumb_57cbc735cb070.jpg', '0', 'N', '', 'list', 'list_text', 'list_page', 'show_post', '', '', 'Y', '5', '0', '1472969714', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('1', '0', '陶明PHP学习之路', 'phpstudy', 'tmphpxxzl', '&lt;p&gt;phpstudy&lt;/p&gt;', 'phpstudy', 'phpstudy', 'phpstudy', 'cate/2016-09-04/57cc34b066008.jpg', 'cate/2016-09-04/thumb_57cc34b066008.jpg', '0', 'N', '', 'list', 'list_text', 'list_page', 'show_post', '', '', 'Y', '11', '0', '1472969751', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('3', '1', '环境搭建', 'buildenv', 'hjdj', '&lt;p&gt;buildenv&lt;/p&gt;', 'buildenv', 'buildenv', 'buildenv', 'special/2016-09-04/57cbc71af40b0.jpg', 'special/2016-09-04/thumb_57cbc71af40b0.jpg', '0', 'N', '', 'list', 'list_text', 'list_page', 'show_post', '', '', 'Y', '3', '0', '1472969786', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('4', '1', '快速人们', 'getstart', 'ksrm', '    ', 'SEO标题：', 'SEO关键字：', 'SEO描述：', 'special/2016-09-04/57cbc6455de58.jpg', 'special/2016-09-04/thumb_57cbc6455de58.jpg', '0', 'N', '', 'list', 'list_text', 'list_page', 'show_post', '', '', 'Y', '0', '0', '1472972317', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('5', '1', 'PHP变量', 'variable', 'phpbl', '&lt;p&gt;PHP变量&lt;/p&gt;', 'PHP变量', 'PHP变量', 'PHP变量', '', '', '0', 'N', '', 'list', 'list_text', 'list_page', 'show_post', '', '', 'Y', '0', '0', '1472972481', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('6', '0', 'poor', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('8', '0', '技术', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('9', '0', '产品', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('10', '0', '设计', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('11', '0', '运营', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('12', '0', '市场与销售', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('13', '0', '职能', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('14', '0', '金融', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('50', '8', '后端开发', '', 'houduankaifa', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('300', '50', 'Java', '', 'Java', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('301', '50', 'Python', '', 'Python', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('302', '50', 'PHP', '', 'PHP', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('303', '50', '.NET', '', '.NET', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('304', '50', 'C#', '', 'C#', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('305', '50', 'C++', '', 'C++', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('306', '50', 'C', '', 'C', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('307', '50', 'VB', '', 'VB', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('308', '50', 'Delphi', '', 'Delphi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('309', '50', 'Perl', '', 'Perl', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('310', '50', 'Ruby', '', 'Ruby', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('311', '50', 'Hadoop', '', 'Hadoop', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('312', '50', 'Node.js', '', 'Node.js', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('313', '50', '数据挖掘', '', 'shujuwajue', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('314', '50', '自然语言处理', '', 'ziranyuyanchuli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('315', '50', '搜索算法', '', 'sousuosuanfa', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('316', '50', '精准推荐', '', 'jingzhuntuijian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('317', '50', '全栈工程师', '', 'quanzhangongchengshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('318', '50', 'Go', '', 'go', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('319', '50', 'ASP', '', 'asp', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('320', '50', 'Shell', '', 'shell', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('321', '50', '后端开发其它', '', 'houduankaifaqita', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('51', '8', '移动开发', '', 'yidongkaifa', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('322', '51', 'HTML5', '', 'HTML5', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('323', '51', 'Android', '', 'Android', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('324', '51', 'iOS', '', 'iOS', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('325', '51', 'WP', '', 'WP', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('326', '51', '移动开发其它', '', 'yidongkaifaqita', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('52', '8', '前端开发', '', 'qianduankaifa', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('327', '52', 'web前端', '', 'webqianduan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('328', '52', 'Flash', '', 'Flash', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('329', '52', 'html5', '', 'html51', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('330', '52', 'JavaScript', '', 'JavaScript', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('331', '52', 'U3D', '', 'U3D', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('332', '52', 'COCOS2D-X', '', 'COCOS2D-X', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('333', '52', '前端开发其它', '', 'qianduankaifaqita', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('53', '8', '测试', '', 'ceshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('334', '53', '测试工程师', '', 'ceshigongchengshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('335', '53', '自动化测试', '', 'zidonghuaceshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('336', '53', '功能测试', '', 'gongnengceshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('337', '53', '性能测试', '', 'xingnengceshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('338', '53', '测试开发', '', 'ceshikaifa', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('339', '53', '游戏测试', '', 'youxiceshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('340', '53', '白盒测试', '', 'baiheceshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('341', '53', '灰盒测试', '', 'huiheceshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('342', '53', '黑盒测试', '', 'heiheceshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('343', '53', '手机测试', '', 'shoujiceshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('344', '53', '硬件测试', '', 'yingjianceshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('345', '53', '测试经理', '', 'ceshijingli2', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('346', '53', '测试其它', '', 'ceshiqita', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('54', '8', '运维', '', 'yunwei', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('347', '54', '运维工程师', '', 'yunweigongchengshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('348', '54', '运维开发工程师', '', 'yunweikaifagongchengshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('349', '54', '网络工程师', '', 'wangluogongchengshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('350', '54', '系统工程师', '', 'xitonggongchengshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('351', '54', 'IT支持', '', 'ITzhichi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('352', '54', 'IDC', '', 'idc', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('353', '54', 'CDN', '', 'cdn', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('354', '54', 'F5', '', 'f5', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('355', '54', '系统管理员', '', 'xitongguanliyuan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('356', '54', '病毒分析', '', 'bingdufenxi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('357', '54', 'WEB安全', '', 'webanquan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('358', '54', '网络安全', '', 'wangluoanquan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('359', '54', '系统安全', '', 'xitonganquan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('360', '54', '运维经理', '', 'yunweijingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('361', '54', '运维其它', '', 'yunweiqita', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('55', '8', 'DBA', '', 'DBA', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('362', '55', 'MySQL', '', 'MySQL', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('363', '55', 'SQLServer', '', 'SQLServer', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('364', '55', 'Oracle', '', 'Oracle', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('365', '55', 'DB2', '', 'DB2', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('366', '55', 'MongoDB', '', 'MongoDB', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('367', '55', 'ETL', '', 'etl', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('368', '55', 'Hive', '', 'hive', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('369', '55', '数据仓库', '', 'shujucangku', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('370', '55', 'DBA其它', '', 'dbaqita', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('56', '8', '高端职位', '', 'gaoduanjishuzhiwei', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('371', '56', '技术经理', '', 'jishujingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('372', '56', '技术总监', '', 'jishuzongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('373', '56', '架构师', '', 'jiagoushi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('374', '56', 'CTO', '', 'CTO', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('375', '56', '运维总监', '', 'yunweizongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('376', '56', '技术合伙人', '', 'jishuhehuoren', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('377', '56', '项目总监', '', 'xiangmuzongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('378', '56', '测试总监', '', 'ceshizongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('379', '56', '安全专家', '', 'anquanzhuanjia', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('380', '56', '高端技术职位其它', '', 'gaoduanjishuzhiweiqita', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('57', '8', '项目管理', '', 'xiangmuguanli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('381', '57', '项目经理', '', 'xiangmujingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('382', '57', '项目助理', '', 'xiangmuzhuli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('58', '8', '硬件开发', '', 'yingjiankaifa2', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('383', '58', '硬件', '', 'yingjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('384', '58', '嵌入式', '', 'qianrushi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('385', '58', '自动化', '', 'zidonghua', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('386', '58', '单片机', '', 'danpianji', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('387', '58', '电路设计', '', 'dianlusheji', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('388', '58', '驱动开发', '', 'qudongkaifa', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('389', '58', '系统集成', '', 'xitongjicheng', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('390', '58', 'FPGA开发', '', 'fpgakaifa', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('391', '58', 'DSP开发', '', 'dspkaifa', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('392', '58', 'ARM开发', '', 'armkaifa', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('393', '58', 'PCB工艺', '', 'pcbgongyi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('394', '58', '模具设计', '', 'mujusheji', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('395', '58', '热传导', '', 'rechuandao', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('396', '58', '材料工程师', '', 'cailiaogongchengshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('397', '58', '精益工程师', '', 'jingyigongchengshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('398', '58', '射频工程师', '', 'shepingongchengshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('399', '58', '硬件开发其它', '', 'yingjiankaifaqita', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('59', '8', '企业软件', '', 'qiyeruanjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('400', '59', '实施工程师', '', 'shishigongchengshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('401', '59', '售前工程师', '', 'shouqiangongchengshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('402', '59', '售后工程师', '', 'shouhougongchengshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('403', '59', 'BI工程师', '', 'bigongchengshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('404', '59', '企业软件其它', '', 'qiyeruanjianqita', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('60', '9', '产品经理', '', 'chanpinjingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('405', '60', '产品经理', '', 'chanpinjingli1', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('406', '60', '网页产品经理', '', 'wangyechanpinjingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('407', '60', '移动产品经理', '', 'yidongchanpinjingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('408', '60', '产品助理', '', 'chanpinzhuli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('409', '60', '数据产品经理', '', 'shujuchanpinjingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('410', '60', '电商产品经理', '', 'dianshangchanpinjingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('411', '60', '游戏策划', '', 'youxicehua', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('412', '60', '产品实习生', '', 'chanpinshixisheng', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('61', '9', '产品设计师', '', 'chanpinshejishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('413', '61', '网页产品设计师', '', 'wangyechanpinshejishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('414', '61', '无线产品设计师', '', 'wuxianchanpinshejishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('62', '9', '高端职位', '', 'gaoduanchanpinzhiwei', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('415', '62', '产品部经理', '', 'chanpinbujingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('416', '62', '产品总监', '', 'chanpinzongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('417', '62', '游戏制作人', '', 'youxizhizuoren', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('63', '10', '视觉设计', '', 'shijuesheji', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('418', '63', '网页设计师', '', 'wangyeshejishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('419', '63', 'Flash设计师', '', 'Flashshejishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('420', '63', 'APP设计师', '', 'APPshejishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('421', '63', 'UI设计师', '', 'UIshejishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('422', '63', '平面设计师', '', 'pingmianshejishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('423', '63', '美术设计师（2D/3D）', '', 'meishushejishi（2D3D）', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('424', '63', '广告设计师', '', 'guanggaoshejishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('425', '63', '多媒体设计师', '', 'duomeitishejishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('426', '63', '原画师', '', 'yuanhuashi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('427', '63', '游戏特效', '', 'youxitexiao', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('428', '63', '游戏界面设计师', '', 'youxijiemianshejishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('429', '63', '视觉设计师', '', 'shijueshejishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('430', '63', '游戏场景', '', 'youxichangjing', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('431', '63', '游戏角色', '', 'youxijiaose', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('432', '63', '游戏动作', '', 'youxidongzuo', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('64', '10', '用户研究', '', 'yonghuyanjiu', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('433', '64', '数据分析师', '', 'shujufenxishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('434', '64', '用户研究员', '', 'yonghuyanjiuyuan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('435', '64', '游戏数值策划', '', 'youxishuzhicehua', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('65', '10', '高端职位', '', 'gaoduanshejizhiwei', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('436', '65', '设计经理/主管', '', 'shejijinglizhuguan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('437', '65', '设计总监', '', 'shejizongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('438', '65', '视觉设计经理/主管', '', 'shijueshejijinglizhuguan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('439', '65', '视觉设计总监', '', 'shijueshejizongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('440', '65', '交互设计经理/主管', '', 'jiaohushejijinglizhuguan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('441', '65', '交互设计总监', '', 'jiaohushejizongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('442', '65', '用户研究经理/主管', '', 'yonghuyanjiujinglizhuguan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('443', '65', '用户研究总监', '', 'yonghuyanjiuzongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('66', '10', '交互设计', '', 'jiaohusheji', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('444', '66', '网页交互设计师', '', 'wangyejiaohushejishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('445', '66', '交互设计师', '', 'jiaohushejishi1', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('446', '66', '无线交互设计师', '', 'wuxianjiaohushejishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('447', '66', '硬件交互设计师', '', 'yingjianjiaohushejishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('67', '11', '运营', '', 'yunying1', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('448', '67', '内容运营', '', 'neirongyunying', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('449', '67', '产品运营', '', 'chanpinyunying', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('450', '67', '数据运营', '', 'shujuyunying', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('451', '67', '用户运营', '', 'yonghuyunying', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('452', '67', '活动运营', '', 'huodongyunying', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('453', '67', '商家运营', '', 'shangjiayunying', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('454', '67', '品类运营', '', 'pinleiyunying', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('455', '67', '游戏运营', '', 'youxiyunying', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('456', '67', '网络推广', '', 'wangluotuiguang', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('457', '67', '运营专员', '', 'yunyingzhuanyuan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('458', '67', '网店运营', '', 'wangdianyunying', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('459', '67', '新媒体运营', '', 'xinmeitiyunying', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('460', '67', '海外运营', '', 'haiwaiyunying', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('461', '67', '运营经理', '', 'yunyingjingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('68', '11', '编辑', '', 'bianji', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('462', '68', '副主编', '', 'fuzhubian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('463', '68', '内容编辑', '', 'neirongbianji', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('464', '68', '文案策划', '', 'wenancehua', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('465', '68', '记者', '', 'jizhe', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('69', '11', '客服', '', 'kefu', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('466', '69', '售前咨询', '', 'shouqianzixun', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('467', '69', '售后客服', '', 'shouhoukefu', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('468', '69', '淘宝客服', '', 'taobaokefu', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('469', '69', '客服经理', '', 'kefujingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('70', '11', '高端职位', '', 'gaoduanyunyingzhiwei', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('470', '70', '主编', '', 'zhubian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('471', '70', '运营总监', '', 'yunyingzongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('472', '70', 'COO', '', 'COO', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('473', '70', '客服总监', '', 'kefuzongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('71', '12', '市场/营销', '', 'shichangyingxiao', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('474', '71', '市场策划', '', 'shichangcehua', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('475', '71', '市场顾问', '', 'shichangguwen', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('476', '71', '市场营销', '', 'shichangyingxiao1', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('477', '71', '市场推广', '', 'shichangtuiguang', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('478', '71', 'SEO', '', 'SEO', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('479', '71', 'SEM', '', 'SEM', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('480', '71', '商务渠道', '', 'shangwuqudao', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('481', '71', '商业数据分析', '', 'shangyeshujufenxi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('482', '71', '活动策划', '', 'huodongcehua', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('483', '71', '网络营销', '', 'wangluoyingxiao', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('484', '71', '海外市场', '', 'haiwaishichang', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('485', '71', '政府关系', '', 'zhengfuguanxi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('72', '12', '公关', '', 'gongguan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('486', '72', '媒介经理', '', 'meijiejingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('487', '72', '广告协调', '', 'guanggaoxiediao', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('488', '72', '品牌公关', '', 'pinpaigongguan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('73', '12', '销售', '', 'xiaoshou', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('489', '73', '销售专员', '', 'xiaoshouzhuanyuan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('490', '73', '销售经理', '', 'xiaoshoujingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('491', '73', '客户代表', '', 'kehudaibiao', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('492', '73', '大客户代表', '', 'dakehudaibiao', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('493', '73', 'BD经理', '', 'BDjingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('494', '73', '商务渠道', '', 'shangwuqudao1', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('495', '73', '渠道销售', '', 'qudaoxiaoshou', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('496', '73', '代理商销售', '', 'dailishangxiaoshou', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('497', '73', '销售助理', '', 'xiaoshouzhuli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('498', '73', '电话销售', '', 'dianhuaxiaoshou', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('499', '73', '销售顾问', '', 'xiaoshouguwen', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('500', '73', '商品经理', '', 'shangpinzhuli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('74', '12', '高端职位', '', 'gaoduanshichangzhiwei', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('501', '74', '市场总监', '', 'shichangzongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('502', '74', '销售总监', '', 'xiaoshouzongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('503', '74', '商务总监', '', 'shangwuzongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('504', '74', 'CMO', '', 'CMO', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('505', '74', '公关总监', '', 'gongguanzongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('506', '74', '采购总监', '', 'caigouzongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('507', '74', '投资总监', '', 'touzizongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('75', '12', '供应链', '', 'gongyinglian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('508', '75', '物流', '', 'wuliu', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('509', '75', '仓储', '', 'cangchu', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('76', '12', '采购', '', 'caigou', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('510', '76', '采购专员', '', 'caigouzhuanyuan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('511', '76', '采购经理', '', 'caigoujingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('512', '76', '商品经理', '', 'shangpinjingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('77', '12', '投资', '', 'touzi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('513', '77', '分析师', '', 'fenxishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('514', '77', '投资顾问', '', 'touziguwen', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('515', '77', '投资经理', '', 'touzijingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('78', '13', '人力资源', '', 'renliziyuan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('516', '78', '人事/HR', '', 'renshiHR', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('517', '78', '培训经理', '', 'peixunjingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('518', '78', '薪资福利经理', '', 'xinzifulijingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('519', '78', '绩效考核经理', '', 'jixiaokaohejingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('520', '78', '人力资源', '', 'renliziyuan1', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('521', '78', '招聘', '', 'zhaopin', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('522', '78', 'HRBP', '', 'HRBP', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('523', '78', '员工关系', '', 'yuangongguanxi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('79', '13', '行政', '', 'xingzheng', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('524', '79', '助理', '', 'zhuli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('525', '79', '前台', '', 'qiantai', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('526', '79', '行政', '', 'xingzheng1', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('527', '79', '总助', '', 'zongzhu', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('528', '79', '文秘', '', 'wenmi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('80', '13', '财务', '', 'caiwu', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('529', '80', '会计', '', 'kuaiji', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('530', '80', '出纳', '', 'chuna', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('531', '80', '财务', '', 'caiwu1', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('532', '80', '结算', '', 'jiesuan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('533', '80', '税务', '', 'shuiwu', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('534', '80', '审计', '', 'shenji', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('535', '80', '风控', '', 'fengkong', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('81', '13', '高端职位', '', 'gaoduanzhinengzhiwei', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('536', '81', '行政总监/经理', '', 'xingzhengzongjianjingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('537', '81', '财务总监/经理', '', 'caiwuzongjianjingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('538', '81', 'HRD/HRM', '', 'HRDHRM', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('539', '81', 'CFO', '', 'CFO', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('540', '81', 'CEO', '', 'ceo', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('82', '13', '法务', '', 'fawu', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('541', '82', '法务', '', 'fawu2', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('542', '82', '律师', '', 'lvshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('543', '82', '专利', '', 'zhuanli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('83', '14', '投融资', '', 'tourongzi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('544', '83', '投资经理', '', 'jinrongtouzijingli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('545', '83', '分析师', '', 'jinrongfenxishi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('546', '83', '投资助理', '', 'touzizhuli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('547', '83', '融资', '', 'rongzi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('548', '83', '并购', '', 'binggou', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('549', '83', '行业研究', '', 'hangyeyanjiu', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('550', '83', '投资者关系', '', 'touzizheguanxi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('551', '83', '资产管理', '', 'zichanguanli', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('552', '83', '理财顾问', '', 'licaiguwen', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('553', '83', '交易员', '', 'jiaoyiyuan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('84', '14', '风控', '', 'jinrongfengkong', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('554', '84', '风控', '', 'jinrong3fengkong', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('555', '84', '资信评估', '', 'zixinpinggu', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('556', '84', '合规稽查', '', 'heguijicha', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('557', '84', '律师', '', 'jinronglvshi', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('85', '14', '审计税务', '', 'shuiwushenji', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('558', '85', '审计', '', 'jinrongshenji', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('559', '85', '法务', '', 'jinrongfawu', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('560', '85', '会计', '', 'jinrongkuaiji', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('561', '85', '清算', '', 'jinrongqingsuan', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('86', '14', '高端职位', '', 'gaoduanjinrongzhiwei', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('562', '86', '投资总监', '', 'jinrongtouzizongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('563', '86', '融资总监', '', 'rongzizongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('564', '86', '并购总监', '', 'binggouzongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('565', '86', '风控总监', '', 'fengxiankongzhizongjian', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('566', '86', '副总裁', '', 'zongcaifuzongcai', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('571', '0', '电脑/网络', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('572', '0', '手机/数码', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('573', '0', '生活', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('574', '0', '游戏', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('575', '0', '体育/运动', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('576', '0', '娱乐明星', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('577', '0', '休闲爱好', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('578', '0', '文化/艺术', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('579', '0', '社会民生', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('580', '0', '教育/科学', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('581', '0', '健康/医疗', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('582', '0', '商业/理财', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('583', '0', '情感/家庭', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('585', '571', '电脑知识', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('586', '571', '互联网', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('587', '571', '操作系统', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('588', '571', '软件', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('589', '571', '硬件', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('590', '571', '编程开发', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('591', '571', '电脑安全', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('592', '571', '资源分享', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('593', '571', '笔记本电脑', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('594', '572', '手机/通讯', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('595', '572', '平板', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('596', '572', 'MP3/MP4', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('597', '572', '手机品牌', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('598', '572', '其他数码', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('599', '572', '手机系统', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('600', '572', '照相机/摄像机', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('601', '572', '数码品牌', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('602', '573', '购物时尚', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('603', '573', '美容塑身', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('604', '573', '美食', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('605', '573', '生活知识', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('606', '573', '品牌服装', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('607', '573', '出行旅游', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('608', '573', '交通', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('609', '573', '购车保养', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('610', '573', '购房置业', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('611', '573', '房屋装饰', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('612', '573', '风水', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('613', '573', '家电用品', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('614', '573', '烹饪', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('615', '574', '网游', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('616', '574', '单机游戏', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('617', '574', '网页游戏', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('618', '574', '盛大游戏', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('619', '574', '网易', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('620', '574', '九城游戏', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('621', '574', '腾讯游戏', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('622', '574', '完美游戏', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('623', '574', '久游游戏', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('624', '574', '巨人游戏', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('625', '574', '金山游戏', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('626', '574', '网龙游戏', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('627', '574', '电视游戏', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('628', '575', '足球', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('629', '575', '篮球', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('630', '575', '体育明星', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('631', '575', '综合赛事', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('632', '575', '田径', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('633', '575', '跳水游泳', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('634', '575', '小球运动', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('635', '575', '赛车赛事', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('636', '575', '强身健体', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('637', '575', '运动品牌', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('638', '576', '电影电视', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('639', '576', '明星', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('640', '576', '音乐', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('641', '576', '动漫', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('642', '576', '星座', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('643', '577', '摄影摄像', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('644', '577', '收藏', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('645', '577', '宠物', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('646', '577', '脑筋急转弯', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('647', '577', '谜语', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('648', '577', '幽默搞笑', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('649', '577', '起名', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('650', '577', '园艺艺术', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('651', '577', '花鸟鱼虫', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('652', '577', '茶艺', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('653', '578', '国内外文学', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('654', '578', '美术', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('655', '578', '舞蹈', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('656', '578', '散文/小说', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('657', '578', '图书音像', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('658', '578', '器乐/声乐', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('659', '578', '小品相声', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('660', '578', '戏剧戏曲', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('661', '579', '时事政治', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('662', '579', '舆论', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('663', '579', '就业/职场', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('664', '579', '历史话题', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('665', '579', '军事国防', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('666', '579', '节日假期', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('667', '579', '民族风情', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('668', '579', '法律知识', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('669', '579', '宗教', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('670', '579', '礼仪', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('671', '580', '学习辅助', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('672', '580', '考研/考证', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('673', '580', '外语', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('674', '580', '菁菁校园', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('675', '580', '人文学', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('676', '580', '理工学', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('677', '580', '公务员', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('678', '580', '留学/出国', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('679', '581', '健康知识', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('680', '581', '孕育/家教', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('681', '581', '内科', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('682', '581', '心理健康', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('683', '581', '外科', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('684', '581', '妇产科', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('685', '581', '儿科', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('686', '581', '皮肤科', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('687', '581', '五官科', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('688', '581', '男科', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('689', '581', '美容整形', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('690', '581', '中医', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('691', '581', '药品', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('692', '581', '心血管科', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('693', '581', '传染科', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('694', '581', '其它疾病', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('695', '581', '健康体检', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('696', '581', '医院', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('697', '582', '创业', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('698', '582', '企业管理', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('699', '582', '财务税务', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('700', '582', '银行', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('701', '582', '股票', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('702', '582', '金融/期货', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('703', '582', '基金债券', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('704', '582', '保险', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('705', '582', '贸易', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('706', '582', '外贸', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('707', '582', '商务文书', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('708', '582', '国民经济', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('709', '582', '个人理财', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('710', '583', '恋爱', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('711', '583', '朋友', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('712', '583', '婚嫁', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('713', '583', '两性', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('714', '583', '家庭', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('715', '583', '孩子教育', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('751', '585', '电脑配置', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('752', '585', '电脑日常维护', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('754', '586', '新浪', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('755', '586', '腾讯', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('756', '587', 'Windows XP', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('757', '587', 'windows 7', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('758', '587', 'Windows Vista', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('759', '587', 'Windows 8', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('760', '588', '办公软件', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('761', '588', '网络软件', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('762', '588', '图像处理', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('763', '588', '系统软件', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('764', '588', '多媒体软件', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('765', '589', '硬盘', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('766', '589', '显示设备', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('767', '589', 'CPU', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('768', '589', '显卡', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('769', '589', '内存', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('770', '589', '主板', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('771', '589', '键盘/鼠标', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('772', '590', 'HTML', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('773', '590', 'DIV+CSS', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('774', '590', 'JavaScript', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('775', '590', 'jQuery', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('776', '590', 'PHP', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('777', '590', 'MySQL', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('778', '590', 'Linux', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('779', '590', 'Objective-C', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('780', '590', 'Java', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('781', '590', 'C/C++', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('782', '571', '网络防火墙', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('783', '0', '刘阿勇测试分类', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('786', '586', '上网问题', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('787', '585', '电脑配置', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('788', '585', '电脑配置', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('789', '585', '电脑配置', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '1', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('790', '783', 'sdfsdf', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '23', '0', '0', '0', '0', '0');
INSERT INTO `tbl_cate` VALUES ('791', '0', '测试', '', '', null, '', '', null, '', '', '0', 'N', '', 'list', '', '', '', '', '', 'Y', '2', '0', '0', '0', '0', '0');
