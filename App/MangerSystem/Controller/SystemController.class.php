<?php

namespace MangerSystem\Controller;

/**
 * 系统后台管理
 */
class SystemController extends \Think\Controller {

    protected  $map = array();
    
    protected function _initialize() {
	$this->map = $data = array(
	    'input' => '普通文本框',
	    'number' => '数字框',
	    'emali' => '邮箱地址',
	    'url' => 'url地址',
	    'password' => '密码框',
	    'unique' => '唯一约束',
	    'date' => '日期',
	    'datetime' => '日期时间',
	    'radio' => '单选',
	    'checkbox' => '多选',
	    'select' => '下拉列表',
	    'textarea' => '普通文本域',
	    'editor' => '编辑器',
	    'image' => '单图上传',
	    'mimage' => '组图上传',
	    'file' => '单文件上传',
	    'mfile' => '多文件上传',
	);
    }

        /**
     * 表列表
     */
    public function index() {
	$tablePrefix = C('DB_PREFIX');
	$sql = 'SHOW TABLE STATUS LIKE "' . $tablePrefix . '%"';
	$tablesInfo = M()->query($sql);    // 查看当前项目中的表

	$this->assign('data', $tablesInfo);
	$this->display();
    }

    /**
     * 配置每张表
     * @param type $id  表名
     */
    public function config($id) {
	$tableName = I('get.id');

	$db = M();
	// 判断表是否在数据库中存在
	$sql = "show table status  where  Name = '{$tableName}'";
	$tableInfo = $db->query($sql);
	if (empty($tableInfo)) {
	    $errMsg = '表名' . $tableName . '不存在！';
	    $this->error($errMsg);
	}

	$comment = isset($tableInfo[0]['comment']) && $tableInfo[0]['comment'] ? $tableInfo[0]['comment'] : $tableName;

	$sql = 'show full columns FROM `' . $tableName . '`';
	$info = $db->query('show full columns FROM ' . $tableName);

	$data = $this->map ; 

	$this->assign('select', $data);
	$this->assign('data', $info);
	$this->assign('comment', $comment);
	$this->assign('tableName', $tableName);
	$this->display();
    }

    /**
     * 为字段设置数据类型
     */
    public function setDataType() {
	$tableName = I('tablename');
	$fieldName = I('fieldname');



	$this->assign('tableName', $tableName);
	$this->assign('fieldName', $fieldName);
	$this->assign('data', $data);
	$this->display();
    }

    /**
     * 为字段批量设置数据类型
     */
    public function batch() {
	$tableName = I('tablename');
	$nowtime = time();
	$formtype = I('post.formtype');

	/*
	  $dataList = array();
	  foreach(I('post.field') as $k=>$v) {
	  $dataList[] = array(
	  'field' => $v,
	  'table' => $tableName,
	  'formtype' => $formtype[$k],
	  'create_time' => $nowtime
	  );
	  }
	  M('tableFields')->addAll($dataList);
	 */

	$dbtableFields = M('tableFields');
	$pk = $dbtableFields->getPk();
	$db = M();

	foreach (I('post.field') as $k => $v) {
	    $where = array('table' => $tableName, 'field' => $v);
	    $ret = $dbtableFields->where($where)->find();
	    $data = array(
		'field' => $v,
		'table' => $tableName,
		'formtype' => $formtype[$k],
	    );
	    
	    // 存在就修改，不存在就添加
	    if ($ret) {
		$data[$pk] = $ret[$pk];
		$ret = $dbtableFields->save($data);
	    } else {
		$data['create_time'] = $nowtime;
		$dbtableFields->add($data);
	    }
	}
	$this->success('设置数据类型成功', '', 33333);
    }

}
