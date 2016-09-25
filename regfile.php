<?php

$path = 'D:\Projects\business\App\Gii\Template\add.php';

$content = file_get_contents($path);

$pattern1 = '/<link(.*?)>/is';   // s包括换行符, i不区分大小写
$int = preg_match_all($pattern1, $content, $match);

var_dump($int);
var_dump($match);


echo '<hr />';
if ($int) {  // 
    foreach ($match[0] as $k => $v) {
	$src = getBetweenStr($v, 'href="', '"');
	if ($src) {
	    $cssHrefArray[] = str_replace('__PUBLIC__/', '', $src);
	}
    }
}

var_dump($cssHrefArray);
var_dump($cssHrefArray = matchCssLink($content));
var_dump($jsSrcArray = matchJsSrcScript($content));



$dest = './aaaa/';
pushFiles($jsSrcArray, $dest);

/**
 * 将原文件推送文件到目标文件夹
 * @param  $srcs string | array
 * @param type $dest
 * @return boolean
 */
function pushFiles($srcs, $dest) {
    $dir = 'D:\Projects\business\App\Gii\Template\assets/';

    if (is_array($srcs)) {
	foreach ($srcs as $src) {
	    $srcFile = $dir . $src;
	    $destFile = $dest . $src;
	    copyFile($srcFile, $destFile);
	}
    } elseif (is_string($srcs)) {
	$srcFile = $dir . $srcs;
	$destFile = $dest . $srcs;
	copyFile($srcFile, $destFile);
    }
}

/**
 * 拷贝文件到指定的目录， 保持目录结构一致
 * @param type $srcFile  源文件
 * @param type $destFile 目标文件
 * @return boolean
 */
function copyFile($srcFile, $destFile) {

    if (!file_exists_case($srcFile)) {
	echo '<h1>源文件 <span style="color:red;">' . $srcFile . '</span>不存在 on line ' . __LINE__ . '</h1>';
	return false;
    } else {
	// 对目标文件做处理
	$dirname = dirname($destFile) . '/';
	$basename = basename($destFile);
	is_dir($dirname) || mkdir($dirname, 0777, true);

	// 文件不存在就进行推送
	if (!file_exists_case($destFile)) {
	    copy($srcFile, $destFile);
	}
	return true;
    }
}



/**
 * 判断一个文件/文件夹是否存在， 区分大小写
 * @param type $path
 * @return boolean
 */
function file_exists_case($path) {
    if (file_exists($path)) {
	$ret = PHP_OS == 'WINNT' ? basename(realpath($path)) === basename($path) : true;
	return $ret;
    }
    return false;
}

/**
 * 查找两个字符串之间的字符串, 非贪婪匹配
 */
function getBetweenStr($str, $startStr = '', $endStr = '') {

    $findStartPos = strpos($str, $startStr);
    if ($findStartPos === FALSE) {
	return false;
    }
    $startStrLen = strlen($startStr);
    $startX = $findStartPos + $startStrLen;
    $findEndPos = strpos($str, $endStr, $startX);

    if ($findEndPos === FALSE) {
	return false;
    }

    $len = $findEndPos - $startX;
    $retStr = substr($str, $startX, $len);

    return $retStr;
}

/**
 * 匹配css的link标签的href属性
 * @param type $content 网页的html字符串
 * @return type
 */
function matchCssLink($content) {
    $pattern = '/<link(.*?)>/is';   // s包括换行符, i不区分大小写
    $cssHrefArray = array();

    $int = preg_match_all($pattern, $content, $match);

    if ($int) {  // 
	foreach ($match[0] as $k => $v) {
	    $href = getBetweenStr($v, 'href="', '"');
	    $href && $cssHrefArray[] = str_replace('__PUBLIC__/', '', $href);
	}
    }

    return $cssHrefArray;
}

/**
 * 匹配css的style标签
 */
function matchCssStyle() {
    
}

/**
 * 匹配js文件的src属性
 * @param type $content 网页的html字符串
 * @return type
 */
function matchJsSrcScript($content) {
    $pattern = '/<script[^>]*?>(.*?)<\/script>/is';   // s包括换行符, i不区分大小写
    $jsSrcArray = array();

    $int = preg_match_all($pattern, $content, $match);
    if ($int) {
	foreach ($match[0] as $k => $v) {
	    $src = getBetweenStr($v, 'src="', '"');
	    $src && $jsSrcArray[] = str_replace('__PUBLIC__/', '', $src);
	}
    }
    return $jsSrcArray;
}



/**
 * 匹配js内容
 */
function matchJsScript() {
    
}

echo $content;






