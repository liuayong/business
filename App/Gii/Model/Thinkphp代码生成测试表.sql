/**
 * Thinkphp 后台代码生成工具生成器
     * 表单项的种类
     * 	input, email, number, date, datetime, time,  unique, editor, textarea, select, image, mimage, file, mfile, radio, checkbox, none
     *
     * 验证规则(常见的验证规则), 一个表单可能有多种验证规则, 暂时不实现 (多个验证规则可以使用+进行分割)
     * require, email、url、 currency、  number,  >=10, <=3, max(10), min(5), [1, 3, 5], 
     * 表注释 [表单类型/验证类型] 表单label key:values(多个键值对使用逗号分隔开来)  
     * eg:  [select/require]是否显示 input:文本输入, select:下拉选择,checkbox:多选,textarea:大段内容,radio:单选

 */
 
 
DROP TABLE IF EXISTS `hl_admin`;
CREATE TABLE `hl_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `reg_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `last_login_ip` varchar(25) NOT NULL DEFAULT '' COMMENT '上次登录IP',
  `login_count` smallint(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态, 0:激活, 1:禁用',
  `remark` text COMMENT '备注说明',
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='后台用户表';


DROP TABLE IF EXISTS `hl_cate`;
CREATE TABLE `hl_cate` (
  `cate_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
  `cate_name` varchar(50) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `name_alias` varchar(50) NOT NULL DEFAULT '' COMMENT '栏目别名',
  `name_id` varchar(50) NOT NULL DEFAULT '' COMMENT '栏目唯一标识符',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '[select]父级栏目ID',
  `cate_pic` varchar(200) NOT NULL DEFAULT '' COMMENT '[image]栏目展示图',
  `display_type` tinyint(3) unsigned NOT NULL DEFAULT '2' COMMENT '[select]类型 2:列表页,1:单页',
  `auth` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '[select]访问权限 1:游客, 2:普通会员, 3:VIP会员',
  `link_url` varchar(200) NOT NULL DEFAULT '' COMMENT '跳转地址',
  `abstract` text COMMENT '[textarea]摘要',
  `content` text COMMENT '[editor]详细介绍',
  `template_list` varchar(100) NOT NULL DEFAULT '' COMMENT '列表模板',
  `template_page` varchar(100) NOT NULL DEFAULT '' COMMENT '单页模板',
  `template_show` varchar(100) NOT NULL DEFAULT '' COMMENT '内容页模板',
  `seo_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo关键字',
  `seo_description` varchar(500) NOT NULL DEFAULT '' COMMENT 'seo描述',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '[none]是否删除, 只有超级管理员才能继续硬删除 0:没有删除, 1:已经删除',
  `is_show` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '[select]是否显示 1: 显示, 0:隐藏',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[none]录入时间',
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COMMENT='栏目表' ; 



DROP TABLE IF EXISTS `hl_jobs`;
CREATE TABLE `hl_jobs` (
  `job_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '[none]职位ID',
  `job_name` varchar(50) NOT NULL DEFAULT '' COMMENT '职位名称',
  `job_abstract` text NOT NULL COMMENT '[editor]职位简介',
  `job_info` text NOT NULL COMMENT '[editor]职位详细介绍',
   `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '[none]是否删除, 只有超级管理员才能继续硬删除 0:没有删除, 1:已经删除',
  `is_show` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '[select]是否显示 1: 显示, 0:隐藏',
  `template` varchar(200) NOT NULL DEFAULT '' COMMENT '模板',
  `seo_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo关键字',
  `seo_description` varchar(500) NOT NULL DEFAULT '' COMMENT 'seo描述',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `pub_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COMMENT='职位招聘表';





DROP TABLE IF EXISTS `hl_nav`;
CREATE TABLE `hl_nav` (
  `nav_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '[none]导航id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '导航名称',
  `nav_icon` varchar(200) NOT NULL DEFAULT '' COMMENT '[image]导航图标',
  `nav_pic` varchar(200) NOT NULL DEFAULT '' COMMENT '[image]导航显示图',
  `redirect_url` varchar(200) NOT NULL DEFAULT '' COMMENT '跳转地址',
  `show_list_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '[select]首页是否显示列表 0:不显示, 1:显示',
  `display_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '[select]类型 1:单页, 2:列表页',
  `template_list` varchar(100) NOT NULL DEFAULT '' COMMENT '列表模板',
  `template_page` varchar(100) NOT NULL DEFAULT '' COMMENT '单页模板',
  `template_show` varchar(100) NOT NULL DEFAULT '' COMMENT '内容页模板',
  `seo_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo关键字',
  `seo_description` varchar(500) NOT NULL DEFAULT '' COMMENT 'seo描述',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[none]录入时间',
  `nav_url` varchar(200) NOT NULL DEFAULT '' COMMENT '[none]导航地址',
 `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '[none]是否删除, 只有超级管理员才能继续硬删除 0:没有删除, 1:已经删除',
  `is_show` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '[select]是否显示 1: 显示, 0:隐藏',
  PRIMARY KEY (`nav_id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COMMENT='导航表';



DROP TABLE IF EXISTS `hl_news`;
CREATE TABLE `hl_news` (
  `news_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '新闻ID',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '新闻标题',
  `title_id` varchar(100) NOT NULL DEFAULT '' COMMENT '标题唯一标识符',
  `source` varchar(100) NOT NULL DEFAULT '' COMMENT '来源',
  `source_url` varchar(200) NOT NULL DEFAULT '' COMMENT '来源地址',
  `cate_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '[select]所属栏目',
  `show_img` varchar(200) NOT NULL DEFAULT '' COMMENT '[image]封面图片',
  `view_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `abstract` text COMMENT '[textarea]新闻摘要',
  `content` text COMMENT '[editor]新闻内容',
  `template` varchar(200) NOT NULL DEFAULT '' COMMENT '模板',
   `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '[none]是否删除, 只有超级管理员才能继续硬删除 0:没有删除, 1:已经删除',
  `is_show` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '[select]是否显示 1: 显示, 0:隐藏',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `seo_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo关键字',
  `seo_description` varchar(500) NOT NULL DEFAULT '' COMMENT 'seo描述',
  `pub_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[date]发布时间',
  `pub_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[none]发布用户ID',
  `pub_uname` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[none]发布用户名',
  `auth` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '[select]访问权限 1:游客, 2:普通会员, 3:VIP会员',
   recommend varchar(200) not null default '' comment '[select]推荐 '':不推荐, 0:首页',
   `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[none]录入时间',
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='新闻表';
alter table hl_news add column tag varchar(200) not null default '' comment '内容标签' after sort_order ;


DROP TABLE IF EXISTS `hl_partner`;
CREATE TABLE `hl_partner` (
  `partner_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '[none]职位ID',
  `partner_name` varchar(50) NOT NULL DEFAULT '' COMMENT '伙伴名称',
  `partner_logo` varchar(200) NOT NULL DEFAULT '' COMMENT '[image]logo图',
  `web_site` varchar(200) NOT NULL DEFAULT '' COMMENT '官网地址',
  `partner_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '[select]类型: 0:业务伙伴, 1:业务合作, 2:学术支持',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `show_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '[select]显示状态 1:显示, 0:隐藏',
  PRIMARY KEY (`partner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='合作伙伴表';
 
CREATE TABLE `hl_banner` (
  `banner_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '[none]主键ID',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '[input/require]广告名称',
  `title_id` varchar(100) NOT NULL DEFAULT '' COMMENT '[input/require]广告标识',
  `link_url` varchar(200) NOT NULL DEFAULT '' COMMENT '链接地址',
  `img_url` varchar(200) NOT NULL DEFAULT '' COMMENT '图片远程地址',
  `banner_img` varchar(200) NOT NULL DEFAULT '' COMMENT '[image]banner图',
  `width` varchar(20) NOT NULL DEFAULT '' COMMENT '图宽',
  `height` varchar(20) NOT NULL DEFAULT '' COMMENT '图高',
  `intro` varchar(1000) NOT NULL DEFAULT '' COMMENT '[textarea]说明',
  `click` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击数',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '[none]是否删除, 只有超级管理员才能继续硬删除 0:没有删除, 1:已经删除 ',
  `is_show` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '[select]是否显示 1:显示, 0:隐藏',
  `start_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[date]开始时间',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[date]结束时间',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[none]创建时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[none]软删除时间',
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='首页banner图' ;


--　推荐表
DROP TABLE IF EXISTS `hl_recommend`;
CREATE TABLE  hl_recommend (
   `recommend_id` int(10) unsigned NOT NULL AUTO_INCREMENT  COMMENT '主键ID',
    pos_id smallint(5) unsigned NOT NULL comment '推荐位置 0:首页',
    aid int(10) unsigned NOT NULL default 0  comment '推荐的文章',
    PRIMARY KEY (`recommend_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='推荐表' ;



-- 活动相关
DROP TABLE IF EXISTS `hl_activity`;
CREATE TABLE `hl_activity` (
  `active_id` smallint(10) unsigned NOT NULL AUTO_INCREMENT comment '[none]主键ID',
  `aname` varchar(200) NOT NULL DEFAULT '' COMMENT   '[input]活动名称',
  `picurl` varchar(200) NOT NULL DEFAULT '' COMMENT '[image]活动封面图',
  `expirydate` int(10) NOT NULL DEFAULT '0' COMMENT  '[none]报名截止日期',
  `adate` varchar(50) NOT NULL DEFAULT '0' COMMENT   '[none]活动日期',
  `apartner` varchar(200) NOT NULL DEFAULT '' COMMENT '[none]活动对象',
  `address` varchar(200) NOT NULL DEFAULT '' COMMENT '[none]活动地点',
  `description` text NOT NULL COMMENT '[textarea]活动简介',
  `content` text COMMENT '[editor]活动详细介绍',
   pic varchar(200) not null default '' comment '[mimage]活动组图',
  `pubtime` int(10) NOT NULL DEFAULT '0' COMMENT '[none]发布时间',
  `notes` text COMMENT '[none]活动备注(外部不可见)',
  `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '[none]是否删除, 只有超级管理员才能继续硬删除 0:没有删除, 1:已经删除 ',
   `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_show` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '[select]是否显示 1:显示, 0:隐藏',
  `is_recommend` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '[select]推荐 0:不推荐, 1:推荐',
  PRIMARY KEY (`active_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='活动表';


-- 活动图片
DROP TABLE IF EXISTS `hl_activityimage`;
CREATE TABLE `hl_activityimage` (
  `aimg_id` int(10) unsigned NOT NULL AUTO_INCREMENT  ,
  `pic` varchar(500) not null default '' comment '图片路径',
  `title` varchar(200) not null default '' comment '',
  `active_id` smallint(10) unsigned NOT NULL default 0 comment '活动ID',
  PRIMARY KEY (`aimg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 Comment '活动图片' ;


-- 言论集锦表
DROP TABLE IF EXISTS `hl_activityspeech`;
CREATE TABLE `hl_activityspeech` (
  `speech_id` int(10) unsigned NOT NULL AUTO_INCREMENT  ,
  `speech_title` varchar(200) not null default '' comment '[input/require]标题',
  `speech_pic` varchar(500) not null default '' comment '图片路径',
   `speech_content` text COMMENT '[textarea]言论内容',
  `active_id` smallint(10) unsigned NOT NULL default 0 comment '活动ID',
    `is_show` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '[select]是否显示 1:显示, 0:隐藏',
    `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`speech_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8  comment '活动言论集锦';



-- 扩展字段管理表/ 属性
DROP TABLE IF EXISTS `hl_attr`;
CREATE TABLE `hl_attr` (
  `attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(50) NOT NULL COMMENT '属性名称',
  `attr_name_alias` char(50) NOT NULL DEFAULT '' COMMENT '属性别名',
  `cate_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '[select]所属栏目',
  `tips` varchar(255) NOT NULL DEFAULT '' COMMENT '属性概要说明',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `attr_type` varchar(200)  NOT NULL DEFAULT 'input' COMMENT '[select]是否显示 input:文本输入, select:下拉选择,checkbox:多选,textarea:大段内容,radio:单选',
  `data_default` text COMMENT '[textarea]属性默认数据',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '[none]录入时间',
  PRIMARY KEY (`attr_id`)
)  ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8   COMMENT='属性表';


-- 属性内容表格
CREATE TABLE `hl_attr_val` (
  `attr_val_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '内容编号',
  `attr_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '属性编号',
  `attr_name` varchar(60) NOT NULL DEFAULT '' COMMENT '属性名称',
  `attr_val` text COMMENT '属性内容',
  PRIMARY KEY (`attr_val_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='属性内容';


alter table hl_attr_val add constraint fk_column_id foreign key(attr_name) references hl_attr ( attr_name_alias)
on delete cascade on update cascade;
