<?php

$config = array(
    'DB_TYPE' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'business',
    'DB_USER' => 'root',
    'DB_PWD' => '123123',
    'DB_PORT' => '3306',
    'DB_PREFIX' => 'tbl_',
    'DB_CHARSET' => 'utf8',
    'pagesize' => 10,
    'template_list' => 'list_text', // 列表模板
    'template_page' => 'list_page', // 单页模板
    'template_detail' => 'show_detail', // 内容页模板
    //'MULTI_MODULE'          =>  true, // 是否允许多模块 如果为false 则必须设置 DEFAULT_MODULE
    'MODULE_ALLOW_LIST' => ['Home', 'MangerSystem', 'Navigation', 'Gii', 'Order', 'Up', 'Collect', 'Cms'],
    'cateCacheKey' => 'cateData', // 栏目数据缓存的key
    'DEFAULT_MODULE' => 'Home', // 默认模块
    'URL_CASE_INSENSITIVE' => false, // url 区分大小写
    'URL_MODEL' => 1,
    'TMPL_PARSE_STRING' => array(
	'__STATIC__' => __ROOT__ . '/static', // 前台站点公共目录
	'__PUBLIC__' => __ROOT__ . '/public', // 后台站点公共目录
    ),
    'SHOW_PAGE_TRACE' => true,
);

// 运行状态的配置
$run_time = array(
    'SHOW_RUN_TIME' => true, // 运行时间显示
    'SHOW_ADV_TIME' => true, // 显示详细的运行时间
    'SHOW_DB_TIMES' => true, // 显示数据库查询和写入次数
    'SHOW_CACHE_TIMES' => true, // 显示缓存操作次数
    'SHOW_USE_MEM' => true, // 显示内存开销
    'SHOW_LOAD_FILE' => true, // 显示加载文件数
    'SHOW_FUN_TIMES' => true, // 显示函数调用次数  
);


if(APP_DEBUG) {
    return array_merge($run_time, $config);
} else {
    return $config;
}

