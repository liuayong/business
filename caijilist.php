<?php

// file caijilist.php 


header("Content-type: text/html; charset=utf-8");
include 'phpQuery.php';

// 使用phpQuery进行列表页的采集

$url = 'http://www.thinkphp.cn/document/index/p/1.html';    // 目标地址



phpQuery::newDocumentFile($url);
$listSelector = 'div.extend .art-list li' ; 
$listSelector = 'ul.art-list > li.cf' ; 
$list_item =  pq($listSelector);
// 列表页 有一个 elements的参数, array, 存储多个匹配的内容， 每个元素是 DOMElement

//div.related-info span:last-child

foreach ($list_item as $key=> $item) {
    echo "key: " . $key . "　　　";
    echo "url: " . pq($item)->find('div.fl a')->html() . "<br />";
    echo "标题: " . pq($item)->find('div.fl a')->text() . "　　　";
    echo "发布时间: " . pq($item)->find('div.related-info span:last-child')->text() . "　　　";
    echo "页面浏览量: " . pq($item)->find('div.related-info span.ri-4')->text() . "　　　";
    echo "链接: " . pq($item)->find('div.fl a')->attr('href') . "<br /><br />";
}



