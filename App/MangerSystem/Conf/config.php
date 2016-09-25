<?php

$host = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

return array(
    'pwd' => 'liuayong', // 后台管理员初始密码
    'SHOW_PAGE_TRACE' => true,
    'superAdminId' => '1', // 超级管理员的ID，超级管理员拥有所有权限
    'useRoleAuth' => false, // 是否使用角色权限验证
    
    
    
     // 重写后台站点公共目录 __STATIC__  和 __PUBLIC__ 都一样 /public
    'TMPL_PARSE_STRING' => array_merge(C('TMPL_PARSE_STRING'), array(
        '__STATIC__' => __ROOT__ . '/public',
    )),
);
