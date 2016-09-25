<?php

/**
 * eg1: http://www.cnblogs.com/in-loading/archive/2012/04/11/2442697.html
 * eg2: http://www.helloweba.com/view-blog-133.html
 * eg3 https://github.com/TobiaszCudnik/phpquery
 */
header("Content-type: text/html; charset=utf-8");
include 'phpQuery.php';


$file = 'lagou_index.htm';
phpQuery::newDocumentFile('./gather/' . $file);

/*

// var_dump(count(pq('.mainNavs .menu_box .menu_sub dt'))); // 37

$cateData = array();
$allSon = array();
foreach (pq('.mainNavs .menu_box .menu_sub dt') as $key => $dt) {
    $a = pq($dt)->find('a');

    //    var_dump($a->attr('data-lg-tj-no'));
    //    var_dump($a->attr('href'));
    //    var_dump($a->html());

    $cateData[$key]['cate_no'] = $a->attr('data-lg-tj-no');
    $cateData[$key]['href'] = $a->attr('href');
    $cateData[$key]['cate_name'] = $a->html();
    $cateData[$key]['cate_pinyin'] = basename($cateData[$key]['href']);


    foreach (pq($dt)->parents('dl')->find('dd a') as $key2 => $subAtag) {
        $subAtag = pq($subAtag);
        $sonData[$key2]['cate_no'] = $subAtag->attr('data-lg-tj-no');
        $sonData[$key2]['href'] = $subAtag->attr('href');
        $sonData[$key2]['cate_name'] = $subAtag->html();
        $sonData[$key2]['cate_pinyin'] = basename($sonData[$key2]['href']);
        $allSon[] = $sonData;
    }

    $cateData[$key]['child'] = $sonData;
    $sonData = array();
}

var_dump(count($allSon));
*/

$homeRecommend = array() ;  // 首页推荐
$topCate = array() ;	    // 顶部栏目

$cateData = array();
$allSon = array();
$sonData = array();

$first_cate_key = 8;
$pk1 = 50 ;
$pk2 = 300 ;

foreach (pq('.mainNavs .menu_box') as $k => $menu_box) {

     $one = trim(pq($menu_box)->find('.menu_main h2')->text());	//   顶部栏目
     $topCate[$first_cate_key++] = $one ;
     
     foreach (pq($menu_box)->find('.job_hopping a') as $recommend) {
	 $homeRecommend[$one][] = pq($recommend)->text() ;
     }
     
    foreach (pq($menu_box)->find('.menu_sub dl') as $key => $dl) {
    
        $dtCate = pq($dl)->find('dt a');
	
        $href = $dtCate->attr('href');
        $cateData[$k][$key]['id'] = $pk1++  ;	    // 主键ID
        $cateData[$k][$key]['parent_id'] = $first_cate_key  ;	    // 父id
        $cateData[$k][$key]['cate_no'] = $dtCate->attr('data-lg-tj-no');
        $cateData[$k][$key]['href'] = $href ;
        $cateData[$k][$key]['cate_name'] = $dtCate->html();
        $cateData[$k][$key]['cate_name_alias'] = basename(urldecode($href));
	
	
	
        foreach (pq($dl)->find('dd a') as $key2 => $dd) {
            $ddCate = pq($dd);
            $href = $ddCate->attr('href');
	    $cate_name = $ddCate->html() ;
            $sonData[$key2]['id'] = $pk2++;
            $sonData[$key2]['parent_id'] = $pk1 ;
            $sonData[$key2]['cate_no'] = $ddCate->attr('data-lg-tj-no');
            $sonData[$key2]['href'] = $href;
            $sonData[$key2]['cate_name'] = $cate_name;
            $sonData[$key2]['cate_pinyin'] = basename(urldecode($href));
	    
	    // 第3级栏目是否有推荐
	    if( in_array($cate_name, $homeRecommend[$one])) {
		$sonData[$key2]['home_recommand'] = 1;
	    }
	
            $allSon[] = $sonData;
        }
        $cateData[$k][$key]['child'] = $sonData;
        $sonData = array();
        #file_put_contents('d:\m.php', var_export($cateData, true). "\r\n\r\n======================\r\n", FILE_APPEND);
    }
}

var_dump($topCate);


