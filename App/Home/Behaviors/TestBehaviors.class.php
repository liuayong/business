<?php
namespace Home\Behaviors;


class TestBehaviors extends \Think\Behavior{
    
    
    //行为执行入口
    public function run(&$param){
	var_dump(func_get_args());
    }
    
//    public function action_begin() {
//        #file_put_contents('d:\m.php',  __FILE__ . __METHOD__ . "\r\n", FILE_APPEND) ;
//    }
}

