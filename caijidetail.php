<?php

// file caijidetail.php


header("Content-type: text/html; charset=utf-8");
include 'phpQuery.php';

// 使用phpQuery进行列表页的采集

$url = 'http://www.thinkphp.cn/document/116.html';    // 目标地址



$document = phpQuery::newDocumentFile($url);
$listSelector = 'div.main' ; 
$item =  pq($listSelector);
// 列表页 有一个 elements的参数, array, 存储多个匹配的内容， 每个元素是 DOMElement


var_dump(pq('')->find('.box .t-head h2')->text());
var_dump(pq($document)->find('.box .t-head h2')->text());

$rules = array(
	'title' => ['.box .t-head h2', 'text'], // 标题
	'pageviews' => ['.box .t-foot span:first', 'text'], // 浏览量
	'pubtime' => ['.box .t-foot span:eq(1)', 'text'], // 浏览量
	'cate' => ['.box .t-foot span:eq(2)', 'text'], // 分类
	'tags' => ['.box .t-foot span:eq(3)', 'text'], // tag标签
	'content' => ['.box .detail-bd .art-cnt', 'html'], // 内容
	'favorite' => ['.sidebar #collect_count', 'text'], // 收藏数
	'support' => ['.sidebar .count-item .support_num', 'text'], // 点赞数
	'reply' => ['.sidebar .review-count', 'text'], // 评论
	'uid' => ['#editbtn_user_id', 'value'], // 用户id
    );
echo 'title: '.  $title = pq('.box .t-head h2')->text() .'<br />';
echo 'title: '.  $title = $item->find('.box .t-head h2')->text() .'<br />';
echo 'pageviews: '.  $pageviews = $item->find('.box .t-foot span:first')->text() .'<br />';
echo 'favorite: '.  $favorite = $item->find('.sidebar #collect_count')->text() .'<br />';
echo 'support: '.  $support = $item->find('.sidebar .count-item .support_num')->text() .'<br />';
echo 'reply: '.  $reply = $item->find('.sidebar .review-count')->text() .'<br />';

