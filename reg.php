<?php

$str = '[input  /  require +	unique]属性别名';

$ret = preg_replace('[\s+]', '', $str);


var_dump($str);
var_dump($ret);

echo '<hr />';

$comment = '[input/require + unique]属性别名' ;
$ret = preg_replace('/[\s]/', '', $str);

var_dump($str);
var_dump($ret);
