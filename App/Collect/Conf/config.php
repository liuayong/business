<?php
return array(

    'LAYOUT_ON'  =>  true,
    'LAYOUT_NAME' => 'collect_layout',
    
    
    'COLLECT_PAGE' => '#PAGE#',	    // 采集的页码标识符号
    
    // 定义资源文件的目录
    'TMPL_PARSE_STRING' =>array(
        '__PUBLIC__' => $GLOBALS['host'] . APP_NAME . '/' . MODULE_NAME . '/View/Public' // 资源地址
    ),
);
