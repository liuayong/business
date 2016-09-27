<?php

namespace Home\Controller;

use Think\Controller;

class UcenterController extends CommonController {
    
     protected function _initialize() {
	parent::_initialize();
    }

    public function index() {
	
    }

    // 我要充值 
    public function recharge() {

	if (IS_POST) {
	    $rechargeAmount = I('post.rchgnumInpt');
	    // 获得支持的银行列表
	    $banklist = D('MangerSystem/Bank')->getBanksByAmount($rechargeAmount);

	    $this->rechargeAmount = $rechargeAmount;
	    $this->banklist = $banklist;
	    $this->display('recharge2');
	} else {
	    $this->display();
	}
    }

    /**
     * 显示可以选择的银行列表
     */
    public function rechargeNext() {
	$rechargeAmount = I('post.rechargeAmount');
	$bank_id = I('post.bank_id');
	$data = D('MangerSystem/Bank')->getById($bank_id);

	// 查询对应的支付平台的映射
	$payData = D('MangerSystem/PayType')->getDropList('pay_name');

	echo '<strong>您好 xxx ,</strong> 您的充值金额是: ' . $rechargeAmount . "<br />";
	echo '您选择的银行是: ' . $data['bank_name'] . "<br />";
	echo '银行code是: ' . $data['bank_code'] . "<br />";
	echo '银行限额是: ' . $data['bank_amount'] . "<br />";
	echo '支付平台是: ' . $payData[$data['pay_type']] . "<br />";
	echo '<img src="' . IMG_URL . $data['bank_logo'] . '" />';
    }

    public function test() {
	$data = D('MangerSystem/Bank')->getBanksByAmount(50000);
    }

}
