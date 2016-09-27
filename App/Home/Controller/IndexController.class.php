<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller {
    
    protected function _initialize() {
	parent::_initialize();
    }
    
    public function index() {
	$this->display();
    }

}
