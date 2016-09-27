<?php

namespace MangerSystem\Controller;

/**
 * 后台菜单表控制器
 */
class MenuController extends CommonController {

    /**
     * 菜单表列表
     */
    public function index() {
	$MenuModel = D('Menu');
	$field = ['id', 'name', 'parent_id'];
	$data = $MenuModel->getTreeList();
	$this->assign('data', $data);
	$this->display();
    }

    /**
     * 菜单表列表 回收站
     */
    public function trashList() {
	$MenuModel = D('Menu');
	$deleteField = C('softDelField');
	$data = $MenuModel->search([$deleteField => 1]);
	$this->assign($data);
	$this->display();
    }

    /**
     * 从回收站还原操作
     */
    public function restore() {
	$id = I('id', 0, 'intval');
	$MenuModel = D('Menu');
	$ret = $MenuModel->toRestore($id);
	if ($ret) {
	    $this->success("还原记录成功");
	} else {
	    $this->error("还原记录失败: " . $MenuModel->getError());
	}
    }

    /**
     * 添加菜单表
     */
    public function add() {
	$id = I('get.id', 0, 'intval');

	$MenuModel = D('Menu');
	if (IS_POST) {
	    if ($postData = $MenuModel->create(I('post.Menu'))) {
    		// 处理菜单的 唯一标识
		if (empty($postData['name_pinyin'])) {
		    $postData['name_pinyin'] = getLetters($postData['name']);
		}

		$MenuModel->data($postData);
		if ($ret = $MenuModel->_add()) {
		    //S(C('cateCacheKey'), null); // 删除缓存
		    $retData = ['code' => 0, 'msg' => '添加成功', 'class' => 'ok', 'return_url' => U('index')];
		} else {
		    $errMsg = '添加失败: ' . $MenuModel->getError();
		    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $MenuModel->getDbError();
		    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
		}
	    } else {
		$errMsg = '添加失败: ' . $MenuModel->getError();
		$errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $MenuModel->getDbError();
		$retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
	    }
	    echo json_encode($retData, JSON_UNESCAPED_UNICODE);
	    exit;
	} else {
	    $field = ['id', 'name', 'parent_id'];
	    $tree = $MenuModel->field($field)->getTreeList();
	    $this->tree = $tree;
	    $this->my_id = $id;
	    $this->display();
	}
    }

    /**
     * 硬删除, 只有超级才有硬删除的权限
     */
    public function del() {
	$id = I('id', 0, 'intval');
	$MenuModel = D('Menu');
	if (!$MenuModel->isSuperAdmin()) {
	    $this->error('只有超级才有删除的权限');
	    return false;
	}

	$ret = $MenuModel->_delete($id);
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

	$MenuModel = D('Menu');
	$ret = $MenuModel->toTrash($id);
	if ($ret) {
	    $this->success("删除记录成功");
	} else {
	    $this->error("删除记录失败: " . $MenuModel->getError());
	}
    }

    /**
     * 修改菜单表
     */
    public function upd() {
	$id = I('id', 0, 'intval');
	$MenuModel = D('Menu');
	if (IS_POST) {
	    if ($postData = $MenuModel->create(I('post.Menu'))) {
		// 没有文件上传 UPLOAD_ERR_NO_FILE ， 保留原来的文件, 是否添加一个删除按钮 ？？
		if ($_FILES['img_original']['error'] == UPLOAD_ERR_OK) {

		    $fileInfo = UploadTool::upload($_FILES['img_original'], array('savePath' => 'cate/'));

		    if ($fileInfo['code'] == 0) {
			$thumbInfo = ImageTool::thumb($fileInfo['fullPath'], array('thumbPrefix' => 'thumb_', 'thumbSize' => array(171, 113), 'thumbType' => 2));

			$postData['img_original'] = $fileInfo['savepath'];
			$postData['img_thumb'] = $thumbInfo['savePath'];
		    } else {       // 上传文件失败
			$errMsg = $fileInfo['msg'];
			$retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
			echo json_encode($retData, JSON_UNESCAPED_UNICODE);
			exit;
		    }
		}

		// 处理菜单的 唯一标识
		if (empty($postData['name_pinyin'])) {
		    $postData['name_pinyin'] = getLetters($postData['name']);
		}

		$MenuModel->data($postData);

		if ($ret = $MenuModel->_save()) {
		    //S(C('cateCacheKey'), null); // 删除缓存
		    $retData = ['code' => 0, 'msg' => '添加成功', 'class' => 'ok', 'return_url' => U('index')];
		} else {
		    $errMsg = '添加失败: ' . $MenuModel->getError();
		    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $MenuModel->getDbError();
		    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
		}
	    } else {
		$errMsg = '添加失败: ' . $MenuModel->getError();
		$errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $MenuModel->getDbError();
		$retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
	    }
	    echo json_encode($retData, JSON_UNESCAPED_UNICODE);
	    exit;
	} else {
	    $this->data = $MenuModel->find($id);
	    $this->tree = $MenuModel->getTreeList();
	    $this->display();
	}
    }

    /**
     * 排序操作
     */
    public function sort() {
	$postData = I('post.sort_order', 0, 'intval');
	$model = M('Menu');
	$pk = $model->getPk();
	foreach ($postData as $id => $sort) {
	    $model->where([$pk => $id])->setField(['sort_order' => $sort]);
	}
	$this->success('排序成功', U('index'), 0);
    }

    /**
     * 上传文件
     */
    public function upload() {

	$data = upload();
	echo json_encode($data);

//        $data = \Common\Components\PluginsInterface::upload();
//        echo json_encode($data);
    }

}
