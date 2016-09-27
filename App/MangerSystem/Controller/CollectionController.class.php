<?php

namespace MangerSystem\Controller;


/**
 * 收集程序
 */
class CollectionController extends CommonController {

    
    public function index() {
	$AdminModel = D('Admin');
	$list = $AdminModel->select();
	$this->assign('list', $list);
	$this->display();
    }

    /**
     * 后台用户表列表
     */
    public function index2() {
	$AdminModel = D('Admin');
	$data = $AdminModel->search();
	$this->assign('data', $data);
	$this->display();
    }

    /**
     * 后台用户表列表 回收站
     */
    public function trashList() {
	$AdminModel = D('Admin');
	$deleteField = C('softDelField');
	$data = $AdminModel->search([$deleteField => 1]);
	$this->assign($data);
	$this->display();
    }

    /**
     * 从回收站还原操作
     */
    public function restore() {
	$id = I('id', 0, 'intval');
	$AdminModel = D('Admin');
	$ret = $AdminModel->toRestore($id);
	if ($ret) {
	    $this->success("还原记录成功");
	} else {
	    $this->error("还原记录失败: " . $AdminModel->getError());
	}
    }

    /**
     * 添加用户表     
     */
    public function add() {
	if (IS_POST) {
	    $Model = D('Admin');
	    #var_dump(I('post.Admin'));
	    if ($Model->create(I('post.Admin'))) {
		if ($Model->_add()) {
		    // $this->success('添加成功!');
		    $retData = ['code'=>0, 'msg'=>'添加成功', 'return_url'=>U('index')];
		} else {
		    $errMsg =  '添加失败: ' . $Model->getError(); 
		    // $this->error($errMsg);
		    $retData = ['code'=>1, 'msg'=>$errMsg];
		}
	    } else {
		$errMsg =  '添加失败2: ' . $Model->getError(); 
		// $this->error($errMsg);
		$retData = ['code'=>1, 'msg'=>$errMsg];
	    }
	    
	    //  Object { info="添加失败2: 用户名不能为空",  status=0,  url=""}
	    echo json_encode($retData);
	    
	} else {

	    $this->display();
	}
    }

    /**
     * 硬删除, 只有超级才有硬删除的权限
     */
    public function del() {
	$id = I('id', 0, 'intval');
	$Model = D('Admin');
	if (false && !$Model->isSuperAdmin()) {
	    $this->error('只有超级才有删除的权限');
	    return false;
	}

	$ret = $Model->_delete($id);
	if ($ret) {
	    $this->success("删除记录成功");
	} else {

	    $this->error("删除记录失败: " . $AdminModel->getError());
	}
    }

    /**
     * 硬删除, 只有超级才有硬删除的权限
     */
    public function del2() {

	$id = I('id', 0, 'intval');
	$Model = D('Admin');
	if (!$Model->isSuperAdmin()) {
	    $this->error('只有超级才有删除的权限');
	    return false;
	}

	$ret = $Model->_delete($id);
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

	$AdminModel = D('Admin');
	$ret = $AdminModel->toTrash($id);
	if ($ret) {
	    $this->success("删除记录成功");
	} else {
	    $this->error("删除记录失败: " . $AdminModel->getError());
	}
    }

    /**
     * 修改后台用户表     */
    public function upd2() {
	$id = I('id', 0, 'intval');
	$Model = D('Admin');
	if (IS_POST) {
	    if ($Model->create()) {
		if (($ret = $Model->_save()) !== FALSE) {
		    $this->success('修改成功', U('index'));
		} else {
		    $errorInfo = $Model->getError() . (APP_DEBUG ? ', ' . $Model->getLastSql() : '' );
		    $this->error('修改失败: ' . $errorInfo);
		}
	    } else {
		$this->error('修改失败: ' . $Model->getError());
	    }
	} else {
	    $data = $Model->field($this->fields)->where($this->where)->find($id);
	    $this->data = $data;
	    $this->roles = D('Role')->getRoles();
	    $this->display($template);
	}
    }

    /**
     * 修改后台用户表     */
    public function upd() {
	$id = I('id', 0, 'intval');
	$Model = D('Admin');
	if (IS_POST) {
	    if ($Model->create(I('post.Admin'))) {
		if (($ret = $Model->_save()) !== FALSE) {
		    // $this->success('修改成功', U('index'));
		    $retData = ['code'=>0, 'msg'=>'添加成功', 'return_url'=>U('index')];
		} else {
		    $errorInfo = '修改失败: ' . $Model->getError() . (APP_DEBUG ? ', ' . $Model->getLastSql() : '' );
		    //$this->error( $errorInfo);
		    $retData = ['code'=>1, 'msg'=>$errorInfo, 'return_url'=>''];
		}
	    } else {
		$errorInfo = '修改失败2: ' . $Model->getError() ;
		//$this->error( $errorInfo);
		$retData = ['code'=>1, 'msg'=> $errorInfo, 'return_url'=>''];
	    }
	    echo json_encode($retData);
	} else {
	    # $data = $Model->field($this->fields)->where($this->where)->find($id);
	    $data = $Model->find($id);
	    $this->data = $data;
	    $this->display();
	}
    }
    
    public function checkUnique() {
	if (IS_AJAX) {
	    $data = I('post.Admin');
	    $map = [
		'username' => '用户名',
		'nickname' => '昵称'
	    ];

	    $val = reset($data);
	    $key = key($data);

	    $res = M('Admin')->where($data)->count();

	    if ($res > 1) {
		$retData = ['code' => 1, 'msg' => $map[$key] . '已经存在, 请重新输入！'];
	    } else {
		$retData = ['code' => 0, 'msg' => ''];
	    }

	    echo json_encode($retData);
	}
    }
    
     public function checkUnique2() {
	if (IS_AJAX) {
	    $data = I('post.Admin');
	    $map = [
		'username' => '用户名',
		'nickname' => '昵称'
	    ];

	    $val = reset($data);
	    $key = key($data);

	    $res = M('Admin')->where($data)->count();

	    if ($res) {
		$retData = ['code' => 1, 'msg' => $map[$key] . '已经存在, 请重新输入！'];
	    } else {
		$retData = ['code' => 0, 'msg' => ''];
	    }

	    echo json_encode($retData);
	}
    }
    
    public function test() {
        $this->display() ;
    }

}
