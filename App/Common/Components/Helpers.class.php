<?php
namespace Common\Components ;

class Helpers {

    /**
     * 本项目中的后台管理员加密算法
     */
    public static function  encrypt($passwd, $salt= '') {
        return strtoupper(md5(md5($passwd). $salt));
    }

    /**
     * php异或加密解密算法的实现
     */
    static public function  xor_enc($str, $key=null) {
        empty($key) && $key = C('COOKIE_KEY') ?: 'liuayong';
        $crytxt = '';
        $keylen = strlen ( $key );
        for($i = 0; $i < strlen ( $str ); $i ++) {
            $k = $i % $keylen;
            $crytxt .= $str [$i] ^ $key [$k];
        }
        return $crytxt;
    }

    /**
     * 随机字符串  字母数字的组合
     * @return string
     */
    static public  function randString() {
        return substr(uniqid(), 3, 6);
    }

    /**
     * 随机纯数字字符串
     * @return string
     */
    static public  function randNumber() {
        return mt_rand(100000, 999999);
    }



}