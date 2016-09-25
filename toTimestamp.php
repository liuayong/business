<?php

$txt = '浏览：12798';




$patterns = "/\d+/"; //第一种
//$patterns = "/\d/";  //第二种
$strs = "left:0px;top:202px;width:90px;height:30px";
preg_match_all($patterns, $strs, $arr);
var_dump($arr);

function a($str) {
    return preg_match('/([0-9]{8})/', $str, $match) ? $match[1] : 0;
}

$a = "时代发123生的12345678发生的";

var_dump(a($a));

function findNum($str) {
    $str = trim($str);
    if (preg_match('|(\d+)|', $str, $match)) {
	return $match[1];
    }
    return 0 ;
}

var_dump(findNum($a));
var_dump(findNum($txt));


