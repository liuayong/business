<?php

$url = 'https://my.oschina.net/syc2013/blog/359640';
$url = 'http://www.163.com/';
$fileContent = file_get_contents($url);

$wcharset = preg_match("/<meta.+?charset=[^\w]?([-\w]+)/i", $fileContent, $temp) ? strtolower($temp[1]) : "";
var_dump($temp);
$wtitle = preg_match("/<title>(.*)<\/title>/isU", $fileContent, $temp) ? $temp[1] : "";
var_dump($temp);

var_dump($wcharset, $wtitle);

function getPageCharset() {
    $wcharset = preg_match("/<meta.+?charset=[^\w]?([-\w]+)/i", $fileContent, $temp) ? strtolower($temp[1]) : "";
    return $wcharset ;
}

function getPageTitle() {
    $wtitle = preg_match("/<title>(.*)<\/title>/isU", $fileContent, $temp) ? $temp[1] : "";
    return $wtitle;
}
