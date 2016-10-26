<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
header("Content-Type: text/html; charset=utf-8");


// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', FALSE);
define('APP_NAME','App');

// 定义应用目录
define('APP_PATH','./'. APP_NAME .'/');

$domain = $_SERVER['REQUEST_SCHEME']. '://' . $_SERVER['SERVER_NAME'] . ':'. $_SERVER['SERVER_PORT'] ;

define('DOMAIN', $domain);


define('UP_DIR_NAME', 'Uploads');
$host = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$host = $host === '/' ? $host : $host . '/';

define('HOST_URL', $host) ;	// 项目路径
define('IMG_URL',  HOST_URL . UP_DIR_NAME .'/');
define('FACE_URL', HOST_URL . 'avatar/' );



// 不限制速度
set_time_limit(0);


// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';


// 考虑自定义标签可以加载多个编辑器
// TagLib
// var_dump(C('TAGLIB_BUILD_IN'));
