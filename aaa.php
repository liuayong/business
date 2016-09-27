<?php

/**
 * eg1: http://www.cnblogs.com/in-loading/archive/2012/04/11/2442697.html
 * eg2: http://www.helloweba.com/view-blog-133.html
 * eg3 https://github.com/TobiaszCudnik/phpquery
 */
header("Content-type: text/html; charset=utf-8");
include 'phpQuery.php';

/**
 * eg1
 * 

  phpQuery::newDocumentFile('http://job.blueidea.com');
  $companies = pq('#hotcoms .coms')->find('div');     // $companies phpQueryObject
  foreach ($companies as $company) {      // $company object(DOMElement)
  echo pq($company)->find('h3 a')->text() . "<br>";
  }
 * 
 */
/*
  phpQuery::newDocumentFile('http://news.sina.com.cn/china');
  echo pq("title")->text() ."<br />";
  $navs = pq('div.first-nav div.wrap a');
  foreach($navs as $nav) {
  $aTag = pq($nav) ;
  echo $aTag->text() . "&nbsp;&nbsp;&nbsp;";
  echo $aTag->attr('href') , "<br />";
  }
 */


/*
  phpQuery::newDocumentFile('http://www.helloweba.com/blog.html');
  $artlist = pq(".blog_li");
  foreach($artlist as $li){
  echo pq($li)->find('h2')->html()."<br />";
  }
 */

/*
  phpQuery::newDocumentFile('a.xml');
  foreach(  pq('contact > age') as $age) {
  var_dump(pq($age)->text());
  }
  echo pq('contact > age:eq(0)');
  echo pq('contact > age:first');
 */

/*
  $file = 'newhtml.html';
  $fileContent = file_get_contents($file);
  $doc = phpQuery::newDocumentHTML($fileContent);
  phpQuery::selectDocument($doc);

  $data = array();
  foreach(pq('a') as $t) {
  $href =  pq($t)->attr('href');
  //$href2 = $t->getAttribute('href');  // $href == $href2
  $data['href'][] = $href ;
  }

  foreach(pq('img ') as $t) {
  $data['img'][] = pq($t)->attr('src');
  }

  foreach(pq('.thumb .GameName') as $t) {
  $data['name'][] = pq($t)->text();
  }

 */



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

$cateData = array();
$allSon = array();
$sonData = array();

foreach (pq('.mainNavs .menu_box') as $k => $menu_box) {

    $topCate[] = trim(pq($menu_box)->find('.menu_main h2')->text());
        
    foreach (pq($menu_box)->find('.menu_sub dl') as $key => $dl) {
        
    
        $dtCate = pq($dl)->find('dt a');

        $href = $dtCate->attr('href');
        $cateData[$k][$key]['cate_no'] = $dtCate->attr('data-lg-tj-no');
        $cateData[$k][$key]['href'] = $href ;
        $cateData[$k][$key]['cate_name'] = $dtCate->html();
        $cateData[$k][$key]['cate_pinyin'] = basename(urldecode($href));

        foreach (pq($dl)->find('dd a') as $key2 => $dd) {
            $ddCate = pq($dd);
            $href = $ddCate->attr('href');
            $sonData[$key2]['cate_no'] = $ddCate->attr('data-lg-tj-no');
            $sonData[$key2]['href'] = $href;
            $sonData[$key2]['cate_name'] = $ddCate->html();
            $sonData[$key2]['cate_pinyin'] = basename(urldecode($href));
            $allSon[] = $sonData;
        }
        $cateData[$k][$key]['child'] = $sonData;
        $sonData = array();
        file_put_contents('d:\m.php', var_export($cateData, true). "\r\n\r\n======================\r\n", FILE_APPEND);
    }
}

//var_dump($topCate);
//var_dump($cateData);
//var_dump(count($allSon));

