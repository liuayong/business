<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller {
    
    protected function _initialize() {
	C('layout_on', false);	    // 不使用布局
    }
    
    public function index() {
	$this->display();
    }

}
