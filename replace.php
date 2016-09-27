<?php

$file = 'D:\Projects\business\App\Home\View\Ucenter\recharge.html';
$file = 'D:\Projects\business\App\Home\View\Index\index.html';

if (file_exists($file)) {
    $content = file_get_contents($file);

    #$search = ['css', 'js', 'images'];
    #$content = str_replace('="' . $v, '="__STATIC__/' . $v, $content);
    $search = ['__STATIC__/css/', '__STATIC__/js/', '__STATIC__/images/'];
    
    foreach ($search as $v) {
	#$content = str_replace('="' . $v, '="__STATIC__/' . $v, $content);
	$content = str_replace($v,  $v.'desktop/', $content);
    }

    file_put_contents($file, $content);
    echo 'done...';
    
} else {

    exit("<h1>文件" + $file + "不存在!</h1>");
}
