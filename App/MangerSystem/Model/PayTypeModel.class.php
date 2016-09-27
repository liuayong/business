<?php

namespace MangerSystem\Model;

use Common\Components\Pinyin;

/**
 * {类型}模型
 */
class PayTypeModel extends CommonModel {

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


}
