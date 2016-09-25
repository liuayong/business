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
);