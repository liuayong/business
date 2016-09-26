
--  mysql 索引  http://w3note.com/web/58.html 
 
CREATE DATABASE /*!32312 IF NOT EXISTS*/ `bussiness` /*!40100 DEFAULT CHARACTER SET utf8 */;

/**
公共字段， sort_order:排序字段, status_is：显示状态， is_deleted 是否已经删除，
create_time,
update_time,
soft_delete_time,
delete_time

**/

`status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '状态',
`sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
`is_deleted` tinyint(3) unsigned not null default 0 COMMENT '是否软删除',
`create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '入库时间',
`update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
`soft_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时间',
`delete_time`  int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',

-- 必须要有的 字段
pagesize

USE `bussiness`;


--
--
-- 所支持的银行
DROP TABLE IF EXISTS `tbl_bank`;
CREATE TABLE `tbl_bank` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    bank_name varchar(20) not null default '' comment '银行名称',
    bank_code varchar(20) not null default '' comment '银行code',
   pay_type smallint(10) unsigned  not null default 0 comment '支付方式',
    `name_alias` varchar(50) NOT NULL DEFAULT '' COMMENT '银行拼音',
    bank_logo varchar(100) not null default '' comment '银行logo',
   bank_amount decimal(10, 2) not null default 0.00 comment '银行限额',
  `content` text COMMENT '详细介绍',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '状态',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  is_deleted tinyint(3) unsigned not null default 0 COMMENT '是否软删除',
  create_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  update_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  soft_delete_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时间',
  delete_time  int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='银行表' ;


DROP TABLE IF EXISTS `tbl_pay_type`;
CREATE TABLE `tbl_pay_type` (
    `id` smallint(10) unsigned NOT NULL AUTO_INCREMENT,
    `pay_name` varchar(50) NOT NULL COMMENT '第三方支付名称',
pay_code varchar(50) not null default '' comment '唯一标识',
    pay_logo varchar(100) not null default '' comment '第三方支付logo',
    `content` text COMMENT '简单介绍',
`status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '状态',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  is_deleted tinyint(3) unsigned not null default 0 COMMENT '是否软删除',
  create_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  update_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  soft_delete_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时间',
  delete_time  int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
PRIMARY KEY (`id`),
  UNIQUE KEY `pay_code` (`pay_code`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='支付方式表' ;


-- 菜单表
DROP TABLE IF EXISTS `tbl_menu`;
CREATE TABLE `tbl_menu` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `name_pinyin` varchar(50) DEFAULT '' COMMENT '拼音',
    module_name varchar(30) not null default '' comment '对应的模块名称',
    controller_name varchar(30) not null default '' comment '对应的控制器名称',
    action_name varchar(30) not null default '' comment '对应的方法名称',
  `intro` text COMMENT '基本介绍',
  `seo_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo关键字',
  `seo_description` text COMMENT 'seo描述',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '状态',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否软删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `soft_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`) 
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='菜单表';


-- 桌面表
DROP TABLE IF EXISTS `tbl_desktop`;
CREATE TABLE  tbl_desktop (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(50) not null default '' comment '名称',
  name_pinyin varchar(50) not null default '' comment '拼音',
    original_icon varchar(200) not null default '' comment '图标地址',
    thumb_icon varchar(200) not null default '' comment '图标地址',

    url varchar(200) not null default '' comment '跳转链接',
     width SMALLINT unsigned not null DEFAULT 0 comment '弹框宽度',
     height SMALLINT unsigned not null DEFAULT 0 comment '弹框高度',
     intro text COMMENT '简单介绍',
     `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '状态',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否软删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `soft_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='桌面表';


-- 更新随机时间
update tbl_post set  create_time =  floor(  rand() * (UNIX_TIMESTAMP() - UNIX_TIMESTAMP( DATE_SUB(now(), INTERVAL +490 DAY))) ) +   UNIX_TIMESTAMP( DATE_SUB(now(), INTERVAL +490 DAY))   ;
select  floor(  rand() * (UNIX_TIMESTAMP() - UNIX_TIMESTAMP( DATE_SUB(now(), INTERVAL +490 DAY))) ) +   UNIX_TIMESTAMP( DATE_SUB(now(), INTERVAL +490 DAY))   




DROP TABLE IF EXISTS `tbl_tags`;
-- 标签统计表
CREATE TABLE `tbl_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '分类',
  `module` varchar(50) not null default '' comment '模块',
  `tag_name` char(30) NOT NULL COMMENT 'tag名称',
  `data_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '数据总数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='标签统计';

DROP TABLE IF EXISTS `tbl_post_tag`;
-- 内容标签表
CREATE TABLE `tbl_post_tag` (
  `id` int(11)unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '分类',
   post_id  int(11) unsigned NOT NULL  default 0 comment '记录id',
   user_id int unsigned not null default 0 comment '用户Id',
  `tag_name` char(30) NOT NULL COMMENT 'tag名称',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='内容标签';


-- 系统表
create table `tbl_table_fields` (
   `id` int(11)unsigned NOT NULL AUTO_INCREMENT,
  `table` varchar(50)  not null default '' comment '表名',
  `field` varchar(50)  not null default '' comment '字段名称',
  `formtype`  varchar(50)  NOT NULL  default '' comment '表单类型',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  PRIMARY KEY (`id`) 
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='系统表';


-- 系统配置表 -- 维护基础表单数据
create table `tbl_config` (
  `id` int(11)unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50)  not null default '' comment '表单键',
  `val` varchar(50)  not null default '' comment '表单种类(值)',
`sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  PRIMARY KEY (`id`)   
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='系统配置表';



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


# 添加索引
ALTER TABLE tbl_cate ADD UNIQUE (cate_name_alias) ;
CREATE UNIQUE INDEX cate_name_alias ON tbl_cate (cate_name_alias)

# 删除索引
ALTER TABLE tbl_cate DROP INDEX cate_name_alias ;
DROP INDEX cate_name_alias ON tbl_cate




-- 分类导航表
DROP TABLE IF EXISTS `nav_cate`;
CREATE TABLE `nav_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类',
  `cate_name` varchar(50) NOT NULL COMMENT '名称',
  `content` text COMMENT '分类介绍',
  `icon_class` varchar(200) DEFAULT '' COMMENT '图标样式',
  `menu_is` enum('Y','N') DEFAULT 'N' COMMENT '是否导航显示',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '状态',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  is_deleted tinyint(3) unsigned not null default 0 COMMENT '是否软删除',
  create_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  update_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  soft_delete_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时间',
  delete_time  int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='分类导航表' ;

-- 网站导航表
DROP TABLE IF EXISTS `nav_website`;
CREATE TABLE `nav_website` (
  `website_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `website_name` varchar(50) NOT NULL COMMENT '名称',
  `website_url` varchar(250) NOT NULL COMMENT '网站名称',
  `cat_id` int(10) unsigned NOT NULL COMMENT '分类ID',
  `pcat_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '一级分类ID',
  `content` text COMMENT '网站介绍',
  `icon_class` varchar(200) DEFAULT '' COMMENT '图标样式',
  `menu_is` enum('Y','N') DEFAULT 'N' COMMENT '是否导航显示',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '状态',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  is_deleted tinyint(3) unsigned not null default 0 COMMENT '是否软删除',
  create_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  update_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  soft_delete_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时间',
  delete_time  int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`website_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='网站导航表' ;



-- 内容管理表
DROP TABLE IF EXISTS `tbl_post`;
 CREATE TABLE `tbl_post` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL default '' COMMENT '标题',
  `title_second` varchar(255) NOT NULL DEFAULT '' COMMENT '副标题',
  `title_alias` char(50) NOT NULL DEFAULT '' COMMENT '唯一标识符 ',
  `title_style` varchar(255) NOT NULL DEFAULT '' COMMENT '标题样式',
  `title_style_serialize` varchar(255) NOT NULL DEFAULT '' COMMENT '标题样式序列化',
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
  img_original varchar(200) not null default '' comment '原始图',
  img_post varchar(200) not null default '' comment '详情页展示图400*400',
  img_zoom varchar(200) not null default '' comment '详情页放大镜图800*800',
  img_thumb varchar(200) not null default '' comment '缩略图100*100',
  `view_count` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '浏览次数',
  `favorite_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数量',
  `attention_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注次数',
  `support_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点赞次数',
  `reply_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '回复次数',
  `acl_browser` varchar(100) NOT NULL DEFAULT 'Y' COMMENT '浏览权限',
  `reply_allow` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '允许评论',
  `status_is` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '内容状态',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_deleted` tinyint(3) unsigned not null default 0 COMMENT '是否软删除',
  create_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  update_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  soft_delete_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT '放入回收站时间',
  delete_time  int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`post_id`),
  UNIQUE KEY `title_alias` (`title_alias`) 
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='内容管理' ;

# 添加索引
ALTER TABLE tbl_post ADD UNIQUE (title_alias) ;
CREATE UNIQUE INDEX title_alias ON tbl_post (title_alias)

# 删除索引
ALTER TABLE tbl_post DROP INDEX title_alias ;
DROP INDEX title_alias ON tbl_post




-- 属性类型表
CREATE TABLE `tbl_attr` (
  `attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(50) NOT NULL COMMENT '属性名称',
  `attr_name_alias` char(50) NOT NULL DEFAULT '' COMMENT '属性别名',
  `cate_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属栏目',
  `tips` varchar(255) NOT NULL DEFAULT '' COMMENT '属性概要说明',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `attr_type` varchar(200) NOT NULL DEFAULT 'input' COMMENT 'input:文本输入, select:下拉选择,checkbox:多选,textarea:大段内容,radio:单选',
  `data_default` text COMMENT '[textarea]属性默认数据',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[none]录入时间',
  PRIMARY KEY (`attr_id`),
  UNIQUE KEY `attr_name_alias` (`attr_name_alias`) 
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='属性类型表';


-- 属性值表, 储存可变属性的值
DROP TABLE IF EXISTS `tbl_attr_val`;
 CREATE TABLE `tbl_attr_val` (
  `attr_val_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '内容编号',
  `attr_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '属性编号',
  `attr_name` varchar(60) NOT NULL DEFAULT '' COMMENT '属性名称',
  `attr_val` text COMMENT '属性内容',
  PRIMARY KEY (`attr_val_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='属性值表';



-- 添加自定义属性
INSERT  into tbl_attr  (attr_name, attr_name_alias , cate_id , tips, attr_type, data_default ) 
select attr_name, attr_name_alias , 9 , tips, attr_type, data_default from bagecms2.bage_attr;



-- 采集表
DROP TABLE IF EXISTS `tbl_collect`;
CREATE TABLE `tbl_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `web_site` varchar(255)  NOT NULL DEFAULT '' COMMENT '主网站地址',
  `web_name` varchar(50)  NOT NULL DEFAULT '' COMMENT '采集网站名称',
  `target` varchar(255)  NOT NULL DEFAULT '' COMMENT '采集目标url',
  `scope` varchar(255)   NOT NULL DEFAULT 'detail' COMMENT 'dom容器, 范围',
  `page_type` enum('detail','list')  NOT NULL DEFAULT 'detail' COMMENT '页面类型',
  `list_tag` varchar(255)  NOT NULL DEFAULT '' COMMENT 'dom容器',
  `start_page` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '采集首页页码',
  `end_page` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '采集尾页页码',
  `title` varchar(255)  NOT NULL DEFAULT '' COMMENT '标题',
  `url` varchar(255)  NOT NULL DEFAULT '' COMMENT '链接',
  `author` varchar(255)  NOT NULL DEFAULT '' COMMENT '作者',
   cate varchar(255) not null default '' comment '分类',
  `pubtime` varchar(255)  NOT NULL DEFAULT '' COMMENT '发布时间',
  `view_cnts` varchar(255)  NOT NULL DEFAULT '' COMMENT '访问量',
  `favorite_cnts` varchar(255)  NOT NULL DEFAULT '' COMMENT '收藏数',
  `support_cnts` varchar(255)  NOT NULL DEFAULT '' COMMENT '点赞数',
  `attention_cnts` varchar(255)  NOT NULL DEFAULT '' COMMENT '关注数',
  `reply_cnts` varchar(255)  NOT NULL DEFAULT '' COMMENT '回复数',
    intro varchar(255)  NOT NULL DEFAULT '' COMMENT '简介',
   `content` varchar(255)  NOT NULL DEFAULT '' COMMENT '内容',
    tags varchar(255)  NOT NULL DEFAULT '' COMMENT '标签',
  `list_order` varchar(255)  NOT NULL DEFAULT '' COMMENT '其他内容',
  `thumb_img` varchar(255)  NOT NULL DEFAULT '' COMMENT '内容缩略图',
  `is_down` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否下载图片',
  `allow_ext` varchar(255)  NOT NULL DEFAULT '' COMMENT '永许下载文件的后缀',
  `charset` varchar(10)  NOT NULL DEFAULT '' COMMENT '抓取页面编码',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='采集表';

-- 前台用户表
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '昵称',
  `user_tel` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `user_email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `regtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `loginip` char(20) NOT NULL DEFAULT '' COMMENT '登录IP',
  `lock` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0为没有锁定，1为锁定',
  `face` varchar(100) NOT NULL DEFAULT '' COMMENT '用户图像地址',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='前台用户表';

# 添加索引
ALTER TABLE tbl_user ADD UNIQUE (username) ;
CREATE UNIQUE INDEX username ON tbl_user (username)

# 删除索引
ALTER TABLE tbl_user DROP INDEX username ;
DROP INDEX username ON tbl_user













             