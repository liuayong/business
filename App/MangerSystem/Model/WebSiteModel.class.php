<?php

namespace MangerSystem\Model;

/**
 * {类型}模型
 */
class WebSiteModel extends CommonModel {

    protected $tablePrefix = 'nav_'; 
    protected $tableName = 'website';
    protected $_validate = [
	// array(field,rule,message,condition,type,when,params) 
	['website_name', 'require', '网站名称不能为空', self::EXISTS_VALIDATE],
	['website_url', 'url', '不是合法的url链接', self::EXISTS_VALIDATE],
	['cat_id', 'require', '必须选择分类', self::EXISTS_VALIDATE],
	['pcat_id', 'require', '必须选择分类', self::EXISTS_VALIDATE],
	['content', 'require', '网站介绍不能为空', self::EXISTS_VALIDATE],
    ];
    
    
    
    

}
