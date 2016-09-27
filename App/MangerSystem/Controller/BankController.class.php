<?php

namespace MangerSystem\Controller;

use Common\Components\UploadTool;
use Common\Components\ImageTool;

/**
 * 后台栏目表控制器
 */
class BankController extends CommonController {

    protected $model;

    protected function _initialize() {
	parent::_initialize();
    }

    /**
     * 栏目表列表
     */
    public function index() {
	$BankModel = D('Bank');
	$data = $BankModel->getAll();
	
	// 查询对应的支付平台的映射
	$payData = D('PayType')->getDropList('pay_name');

	$this->assign('data', $data);
	$this->assign('payData', $payData);
	$this->display();
    }

    /**
     * 栏目表列表 回收站
     */
    public function trashList() {
	$this->display();
    }
    

    /**
     * 从回收站还原操作
     */
    public function restore() {
	$id = I('id', 0, 'intval');
	$BankModel = D('Bank');
	$ret = $BankModel->toRestore($id);
	if ($ret) {
	    $this->success("还原记录成功");
	} else {
	    $this->error("还原记录失败: " . $BankModel->getError());
	}
    }

    /**
     * 添加栏目表
     */
    public function add() {
	$id = I('get.id', 0, 'intval');

	$BankModel = D('Bank');
	if (IS_POST) {
	    if ($postData = $BankModel->create(I('post.Bank'))) {

		// 处理栏目的 唯一标识
		if (empty($postData['name_alias'])) {
		    $postData['name_alias'] = getLetters($postData['bank_name']);
		}

		$BankModel->data($postData);

		if ($ret = $BankModel->_add()) {
		    //S(C('cateCacheKey'), null); // 删除缓存

		    $retData = ['code' => 0, 'msg' => '添加成功', 'class' => 'ok', 'return_url' => U('index')];
		} else {
		    $errMsg = '添加失败: ' . $BankModel->getError();
		    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $BankModel->getDbError();
		    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
		}
	    } else {
		$errMsg = '添加失败: ' . $BankModel->getError();
		$errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $BankModel->getDbError();
		$retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
	    }

	    echo json_encode($retData, JSON_UNESCAPED_UNICODE);
	    exit;
	} else {
	    $this->paylist = D('PayType')->getDropList('pay_name');     // 支付平台列表
	    $this->display();
	}
    }

    /**
     * 修改栏目表
     */
    public function upd() {
	$id = I('id', 0, 'intval');
	$BankModel = D('Bank');
	if (IS_POST) {
	    if ($postData = $BankModel->create(I('post.Bank'))) {

		// 处理栏目的 唯一标识
		if (empty($postData['name_alias'])) {
		    $postData['name_alias'] = getLetters($postData['bank_name']);
		}

		$BankModel->data($postData);

		if ($ret = $BankModel->_save()) {
		    //S(C('cateCacheKey'), null); // 删除缓存
		    $retData = ['code' => 0, 'msg' => '修改成功', 'class' => 'ok', 'return_url' => U('index')];
		} else {
		    $errMsg = '修改失败: ' . $BankModel->getError();
		    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $BankModel->getDbError();
		    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
		}
	    } else {
		$errMsg = '修改失败: ' . $BankModel->getError();
		$errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $BankModel->getDbError();
		$retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
	    }
	    echo json_encode($retData, JSON_UNESCAPED_UNICODE);
	    exit;
	} else {
	    $this->data = $BankModel->find($id);
	    $this->paylist = D('PayType')->getDropList('pay_name');
	    $this->display();
	}
    }

    /**
     * 硬删除, 只有超级才有硬删除的权限
     */
    public function del() {
	$id = I('id', 0, 'intval');
	$BankModel = D('Bank');
	if (!$BankModel->isSuperAdmin()) {
	    $this->error('只有超级才有删除的权限');
	    return false;
	}

	$ret = $BankModel->_delete($id);
	if ($ret) {
	    $this->success("删除记录成功");
	} else {

	    $this->error("删除记录失败: " . $AdminModel->getError());
	}
    }

    /**
     * 软删除 【单/多条记录】
     * @param type $id
     */
    public function toTrash($id) {
	$id = I('id', 0, 'intval');

	$BankModel = D('Bank');
	$ret = $BankModel->toTrash($id);
	if ($ret) {
	    $this->success("删除记录成功");
	} else {
	    $this->error("删除记录失败: " . $BankModel->getError());
	}
    }

    /**
     * 排序操作
     */
    public function sort() {
	$postData = I('post.sort_order', 0, 'intval');
	$model = M('Bank');
	$pk = $model->getPk();
	foreach ($postData as $id => $sort) {
	    $model->where([$pk => $id])->setField(['sort_order' => $sort]);
	}
	$this->success('排序成功', U('index'), 0);
    }

}
