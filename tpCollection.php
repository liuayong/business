<?php

/**
 * eg1: http://www.cnblogs.com/in-loading/archive/2012/04/11/2442697.html
 * eg2: http://www.helloweba.com/view-blog-133.html
 * eg3 https://github.com/TobiaszCudnik/phpquery
 */
header("Content-type: text/html; charset=utf-8");
include 'phpQuery.php';

/*
phpQuery::newDocumentFile('http://job.blueidea.com');
$companies = pq('#hotcoms .coms')->find('div');     // $companies phpQueryObject
foreach ($companies as $company) {      // $company object(DOMElement)
    echo pq($company)->find('h3 a')->text() . "<br>";
}
 * */


$detailUrl = 'http://www.thinkphp.cn/document/116.html';
phpQuery::newDocumentFile($detailUrl);
$item = pq('div.main');







