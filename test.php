<?php


$arr = array (
0 =>
 array (
'attr_id' => '25',
 'attr_name' => 'tag',
 'attr_val' => '斯蒂芬是否方法',
 ),
 1 =>
 array (
'attr_id' => '26',
 'attr_name' => 'area',
 'attr_val' => 'american',
 ),
 2 =>
 array (
'attr_id' => '27',
 'attr_name' => 'sex',
 'attr_val' => '0',
 ),
 '3b' =>
 array (
'attr_id' => '28',
 'attr_name' => 'hobby',
 'attr_val' => 'volleyball',
 ),
 'ad' =>
 array (
'attr_id' => '29',
 'attr_name' => 'intro',
 'attr_val' => '标识：intro 说明: 介绍的说明 ',
 ),
 );

 var_dump($arr);
 var_dump($vals = array_values($arr));
 var_dump($keys = array_keys($arr));
 
 $arr = array_combine($keys, $vals);
 var_dump($arr);
 
 
 