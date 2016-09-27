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

$url = 'http://www.lagou.com/';

//var_dump(get_headers ($url, 0));
//var_dump(get_headers ($url, 1));



phpQuery::newDocumentFile($url);
$cateData = array();
foreach (pq('.mainNavs .menu_box .menu_sub dt') as $cate1) {
    var_dump(pq($cate1)->attr('data-lg-tj-no'));
    $cateData['cate_no'] = pq($cate1)->attr('data-lg-tj-no');
    $cateData['href'] = pq($cate1)->attr('href');
    $cateData['cate_pinyin'] = basename($cateData['href']);
    
    // 父级 dl pq($cate1)->parent('dl')
}



class Http {

    // 执行http请求
    public static function httpGet($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // 解决https的情况
        if (strpos($url, 'https') === 0) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        }

        $headers = self::generateHeaders();
        //伪造来源ip
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //$session_id = 'PHPSESSID=' . $sessionVerify[$key]['session'];
        //curl_setopt($ch, CURLOPT_COOKIE, $session_id);
        // 加上这个表示执行curl_exec是把输出作为防止, 不会输出到浏览器
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $out_put = curl_exec($ch);


        if ($out_put === false) {
            echo "xiuxi\n";
            echo 'Curl error: ' . curl_error($ch);
            sleep(10);
        }
        curl_close($ch);
        return $out_put;
    }

    // 执行http请求
    public static function httpPost($url, $postData = array()) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // 解决https的情况
        if (strpos($url, 'https') === 0) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        }

        $headers = self::generateHeaders();
        //伪造来源ip
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //$session_id = 'PHPSESSID=' . $sessionVerify[$key]['session'];
        //curl_setopt($ch, CURLOPT_COOKIE, $session_id);
        // 提交post传参
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);


        // 加上这个表示执行curl_exec是把输出作为防止, 不会输出到浏览器
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $out_put = curl_exec($ch);


        if ($out_put === false) {
            echo "xiuxi\n";
            echo 'Curl error: ' . curl_error($ch);
            sleep(60 * 5);
        } else {
            // echo $out_put ;
        }

        //var_dump($ip, $phone);
        //var_dump($out_put);

        curl_close($ch);
        //usleep(20000);

        return $out_put;
    }

    /**
     * 模拟http请求头
     */
    protected static function generateHeaders() {

        $header_ip = self::createRandomIp();
        $headers = array(
            'CLIENT-IP:' . $header_ip,
            'X-FORWARDED-FOR:' . $header_ip,
            'X-Requested-With: XMLHttpRequest',
            'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0',
            'Host : www.lagou.com',
        );
    }

    // 伪造ip
    protected static function createRandomIp() {
        $ip = '192.168.' . mt_rand(0, 255) . '.' . mt_rand(0, 255);
        $ip = mt_rand(1, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255);

        return $ip;
    }

}