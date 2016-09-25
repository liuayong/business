<?php

// 代理 解决ajax不能跨域的问题

header("Content-Type:text/html; charset=utf-8");



$url = 'http://gc.ditu.aliyun.com/geocoding?a=%E8%8B%8F%E5%B7%9E%E5%B8%82';
$url = 'http://html.my/business/index.php/MangerSystem/Cate/ztree';


if(isset($_POST['pid'])) {
	$url .= '?pid='.intval($_POST['pid']);
}

$content = Http::httpGet($url) ;

//echo $content ;
//var_dump($content );

$content=  file_get_contents($url) ;
//var_dump($content );


// 问题1:
// 对于有登陆验证的情况  效果和 Http::httpGet的效果 不太相同 。。。。 
//$content=  file_get_contents($url) ;
//echo $content;

// 问题2:
// 对于有trace 和没有trace 的情况也不一样

echo $content ;

exit;





#var_dump( Http::httpPost($url, array()) );


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
		var_dump($url);

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
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);


        // 加上这个表示执行curl_exec是把输出作为防止, 不会输出到浏览器
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $out_put = curl_exec($ch);

		var_dump($out_put);

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
            //'Host : www.lagou.com', 
        );
		return $headers ;
    }

    // 伪造ip
    protected static function createRandomIp() {
        $ip = '192.168.' . mt_rand(0, 255) . '.' . mt_rand(0, 255);
        $ip = mt_rand(1, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255);

        return $ip;
    }

}


