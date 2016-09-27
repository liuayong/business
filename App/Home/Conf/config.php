<?php

//var_dump(MODULE_NAME, CONTROLLER_NAME, ACTION_NAME);
return array(
// 重写前台站点公共目录 __STATIC__  和 __PUBLIC__ 都一样 /static
    'TMPL_PARSE_STRING' => array_merge(C('TMPL_PARSE_STRING'), array(
        '__PUBLIC__' => __ROOT__ . '/static',
    )),
    
    
    // 前台分页样式的配置
    'PAGE' => array(
        "header" => "篇文章",
        "prev" => "上一页",
        "next" => "下一页",
        "theme" => '共 %TOTAL_ROW% %HEADER% %NOW_PAGE%/%TOTAL_PAGE% 页 %UP_PAGE%  %LINK_PAGE%  %DOWN_PAGE%',
    ),
    
    'URL_PATHINFO_DEPR' => '/',
    
    // 是否获得子栏目下的内容
    'is_get_childcate_contents' => false ,
    
    // 是否开启验证码
    'is_verify_code' => true,   
    
     // 主题
    'DEFAULT_THEME' => 'very',
    'TMPL_DETECT_THEME' => true,
    'THEME_LIST' => 'default,very', // 支持的模板主题项
    // 'VAR_TEMPLATE'          =>  't',    // 默认模板切换变量
    
    
    // 全局配置模板布局
    'LAYOUT_ON'=>true,
    'LAYOUT_NAME'=>'layout',
    
    
    
    // 全局静态缓存
    'HTML_CACHE_ON' => false, // 开启静态缓存
    'HTML_CACHE_TIME' => 600, // 全局静态缓存有效期（秒）
    'HTML_FILE_SUFFIX' => '.html', // 设置静态缓存文件后缀
    'HTML_CACHE_RULES' => array(// 定义静态缓存规则
	//'*' => array('{$_SERVER.REQUEST_URI|md5}'),
	'*' =>array('{:controller}_{:action}_{id}_{p}_'.$_GET[C("VAR_TEMPLATE")], 60)
    ),
    
    /*
    // 缓存的配置
    'close_cache' => true,   // 不使用缓存，开发阶段
    'cate_key' => 'catelist',
    'newPost_key' => 'newPost',
    'newComment_key' => 'newComment',
    'tagslist_key' => 'tagslist',
    'tagslist_key' => 'tagslist',
    'archivelist_key' => 'archivelist',
    */
    
);