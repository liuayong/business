<?php

namespace MangerSystem\Controller;

class WebsiteController extends CommonController {

    protected $model;

    /**
     * 初始化方法
     */
    protected function _initialize() {
	$host = $GLOBALS['host'];
	$urlPath = $host . 'App/' . MODULE_NAME . '/View/' . CONTROLLER_NAME . '/static/'; // 资源地址
	defined('NAV') || define('NAV', $urlPath);

	$this->model = new \MangerSystem\Model\NavCateModel('', 'nav_');
    }

    /**
     * 全部的网址列表
     */
	
    public function index() {
	$model = new \MangerSystem\Model\WebSiteModel();
	
	$this->display('website');
    }

    /**
     *  导航表后台列表页
     */
    public function showlist() {
	$data = $this->model->getTreeList();
	$this->assign('data', $data);
	$this->display();
    }

    /**
     *  添加导航
     */

    /**
     * 添加栏目表
     */
    public function add() {
	$id = I('get.id', 0, 'intval');

	$CateModel = $this->model;
	if (IS_POST) {
	    if ($postData = $CateModel->create(I('post.Cate'))) {

		$CateModel->data($postData);

		if ($ret = $CateModel->_add()) {
		    $retData = ['code' => 0, 'msg' => '添加分类成功', 'class' => 'ok', 'return_url' => U('index')];
		} else {
		    $errMsg = '添加失败: ' . $CateModel->getError();
		    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $CateModel->getDbError();
		    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
		}
	    } else {
		$errMsg = '添加失败: ' . $CateModel->getError();
		$errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $CateModel->getDbError();
		$retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
	    }
	    echo json_encode($retData, JSON_UNESCAPED_UNICODE);
	    exit;
	} else {
	    $field = [$CateModel->getPk(), 'cate_name', 'parent_id'];
	    $tree = $CateModel->field($field)->getTreeList();
	    $this->tree = $tree;
	    $this->my_id = $id;
	    $this->display();
	}
    }

    /**
     * 修改后台用户表     */
    public function upd() {
	$id = I('id', 0, 'intval');
	$Model = $this->model;
	if (IS_POST) {
	    if ($Model->create(I('post.Cate'))) {
		if (($ret = $Model->_save()) !== FALSE) {
		    $retData = ['code' => 0, 'msg' => '添加成功', 'return_url' => U('index')];
		} else {
		    $errorInfo = '修改失败: ' . $Model->getError() . (APP_DEBUG ? ', ' . $Model->getLastSql() : '' );
		    $retData = ['code' => 1, 'msg' => $errorInfo, 'return_url' => ''];
		}
	    } else {
		$errorInfo = '修改失败: ' . $Model->getError();
		$retData = ['code' => 1, 'msg' => $errorInfo, 'return_url' => ''];
	    }
	    echo json_encode($retData);
	} else {
	    $data = $Model->find($id);
	    $this->data = $data;
	    $this->tree = $Model->getTreeList();
	    $this->display();
	}
    }

    /**
     * 批量操作
     *
     */
    public function batch() {
	if (IS_POST) {
	    $command = I('post.command');
	    $ids = I('post.id');
	    switch ($command) {
		case 'trash' :
		    $this->toTrash($ids);
		    break;
		case 'sortOrder':
		    foreach ((array) I('post.sort_order') as $id => $val) {
			$oneData = $this->model->find($id);
			if ($oneData) {
			    #$this->model->sort_order = $val;
			    #$this->model->pk = $id;
			    $data = [$this->model->getPk() => $id, 'sort_order' => $val];
			    $ret = $this->model->save($data);
			}
		    }
		    break;
		case 'toshow' :
		    $this->recycle($ids);
		    break;
		case 'unshow' :
		    var_dump($ids);
		    $this->forbid($ids);
		    break;
		default:
		    #throw new CHttpException(404, '错误的操作类型:' . $command);
		    $this->error('错误的操作类型:' . $command);
		    break;
	    }
	    $this->success('操作成功', '', 3);
	} else {
	    $this->error('无法访问该页');
	}
    }

    /**
     * 硬删除, 只有超级才有硬删除的权限
     */
    public function del() {
	$id = I('id', 0, 'intval');
	$Model = D('Nav');
	if (false && !$Model->isSuperNav()) {
	    $this->error('只有超级才有删除的权限');
	    return false;
	}

	$ret = $Model->_delete($id);
	if ($ret) {
	    $this->success("删除记录成功");
	} else {

	    $this->error("删除记录失败: " . $cateModel->getError());
	}
    }

    /**
     * 软删除 【单/多条记录】
     * @param type $id
     */
    public function toTrash($id) {
	$id = I('id', 0, 'intval');

	$cateModel = $this->model;
	$ret = $cateModel->toTrash($id);
	if ($ret) {
	    $this->success("删除记录成功");
	} else {
	    $this->error("删除记录失败: " . $cateModel->getError());
	}
    }

    /**
     * 后台用户表列表 回收站
     */
    public function trashList() {
	$cateModel = $this->model;
	$deleteField = C('softDelField');
	$data = $cateModel->search([$deleteField => 1]);
	$this->assign($data);
	$this->display();
    }

    /**
     * 从回收站还原操作
     */
    public function restore() {
	$id = I('id', 0, 'intval');
	$cateModel = $this->model;
	$ret = $cateModel->toRestore($id);
	if ($ret) {
	    $this->success("还原记录成功");
	} else {
	    $this->error("还原记录失败: " . $cateModel->getError());
	}
    }
    
    
    /**
     * 全部的网址列表
     */
    public function website() {
	$model = new \MangerSystem\Model\WebSiteModel('', 'nav_');
	var_dump($model);
	$this->display();
    }

}
