<?php

namespace MangerSystem\Model;

/**
 * 属性模型
 */
class AttrModel extends CommonModel {

    protected $_validate = [
    ];

    /**
     * 添加方法
     */
    public function _add() {

	$data = $this->data;
	$data['create_time'] = time() ;
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

    // 删除数据前的回调方法
    protected function _before_delete($options) {
	
    }

    // 删除成功后的回调方法
    protected function _after_delete($data, $options) {
	
    }

    // 插入数据前的回调方法
    protected function _before_insert(&$data, $options) {
	
    }

    // 插入成功后的回调方法
    protected function _after_insert($data, $options) {
	
    }

    // 查询成功后的回调方法
    protected function _after_select(&$resultSet, $options) {
	
    }

    // 更新数据前的回调方法
    protected function _before_update(&$data, $options) {
	
    }

    // 更新成功后的回调方法
    protected function _after_update($data, $options) {
	
    }

}
