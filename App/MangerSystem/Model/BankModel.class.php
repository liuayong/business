<?php

namespace MangerSystem\Model;

use Common\Components\Pinyin;

/**
 * {类型}模型
 */
class BankModel extends CommonModel {

    protected $_validate = [
            // array(field,rule,message,condition,type,when,params) 
            // array(field, url,'错误提示',self::VALUE_VALIDATE, callback, self:MODEL_BOTH , params) 
    ];

    /**
     * 添加方法
     */
    public function _add() {
        $data = $this->data;

        $this->data = $data;
        return parent::_add();
    }

    /**
     * 修改方法
     */
    public function _save() {
        $data = $this->data;

        $this->data = $data;
        return parent::_save();
    }
    
    /**
     * 根据金额获取所支持的银行列表
     * @param type $amout
     */
    public function getBanksByAmount($amout = 0) {
	
	/*
	$where['bank_amount'] = ['egt', $amout];
	$where['status_is']  = 'Y';
	$where['is_deleted'] = 0 ;
	
	$sort_order = ['sort_order' => 'desc'];
	$data = $this->where($where)->select();
	
	// mysql中是可行的
	// SELECT * FROM `tbl_bank` WHERE `bank_amount` >= 50000 AND `status_is` = 'Y' AND `is_deleted` = 0 ' group by bank_name ;
	*/
	// D('MangerSystem/PayType')->getDropList('sort_order')
	
    	$sql = 'select * from (select b.id , b.bank_name, b.bank_code, b.bank_logo, b.bank_amount, b.pay_type,  b.sort_order,
                    p.sort_order sort2, p.pay_name , p.pay_code 
                    from tbl_bank b left join  tbl_pay_type p 
                    on  b.pay_type = p.id  
                    where b.is_deleted = 0 and p.is_deleted=0 and b.status_is = "Y" AND p.status_is="Y"  AND bank_amount >= '.  $amout .'
                    order by b.sort_order DESC, p.sort_order DESC) as ordertable 
                    group by bank_name  order by sort_order DESC, sort2 DESC 
                ';
        
        $data = $this->query($sql) ;	
    	return $data ;
    }
}
