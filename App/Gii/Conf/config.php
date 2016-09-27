<?php

return array(
    'DB_TYPE' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_USER' => 'root',
    'DB_PWD' => '123123',
    'DB_PORT' => '3306',
    'DB_CHARSET' => 'utf8',
    'SHOW_PAGE_TRACE' => FALSE,
    'TMPL_PARSE_STRING' => array(
	'__PUBLIC__' => __ROOT__ . '/' . APP_NAME . '/' . MODULE_NAME . '/Public', // gii 自己的资源目录
    )
);





