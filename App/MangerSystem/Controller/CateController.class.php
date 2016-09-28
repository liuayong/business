<?php

namespace MangerSystem\Controller;

use Common\Components\UploadTool;
use Common\Components\ImageTool;

/**
 * 后台栏目表控制器
 */
class CateController extends \Think\Controller {

    /**
     * 栏目表列表
     */
    public function index() {
	$CateModel = D('Cate');
	$field = ['id', 'cate_name', 'parent_id'];
	$data = $CateModel->getTreeList();
	$this->assign('data', $data);
	$this->display();
    }

    public function ztree($pid = 0) {
	C('Show_PAGE_TRACE', false);
	$CateModel = D('Cate');

	$parentKey = $CateModel->parent_id;
	$field = [$CateModel->getPk() => 'id', $parentKey => 'pid', 'cate_name' => 'name', 'cate_name_alias' => 'alias'];
	$data = $CateModel->field($field)->where([$parentKey => $pid])->getAll();
	$data = self::addColumn($data);
	echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    // 给二维数组添加数据
    protected function addColumn(array $handelData) {
	$cateModel = D('Cate');
	foreach ($handelData as $k => $v) {
	    $handelData[$k]['isParent'] = !$cateModel->isLeaf($v[$cateModel->getPk()]);
	}
	return $handelData;
    }

    /**
     * 栏目表列表 回收站
     */
    public function trashList() {
	$CateModel = D('Cate');
	$deleteField = C('softDelField');
	$data = $CateModel->search([$deleteField => 1]);
	$this->assign($data);
	$this->display();
    }

    /**
     * 从回收站还原操作
     */
    public function restore() {
	$id = I('id', 0, 'intval');
	$CateModel = D('Cate');
	$ret = $CateModel->toRestore($id);
	if ($ret) {
	    $this->success("还原记录成功");
	} else {
	    $this->error("还原记录失败: " . $CateModel->getError());
	}
    }

    /**
     * 添加栏目表
     */
    public function add() {
	$id = I('get.id', 0, 'intval');

	$CateModel = D('Cate');
	if (IS_POST) {
	    if ($postData = $CateModel->create(I('post.Cate'))) {
		// 额外的处理, 如果文件上传出错该怎么处理？？？ 是否不考虑上传文件的字段， 让其插入数据库,？
		$fileInfo = UploadTool::upload($_FILES['img_original'], array('savePath' => 'cate/'));

		if ($fileInfo['code'] == 0) {
		    $thumbInfo = ImageTool::thumb($fileInfo['fullPath'], array('thumbPrefix' => 'thumb_', 'thumbSize' => array(200, 200), 'thumbType' => 2));

		    $postData['attach_file'] = $fileInfo['savepath'];
		    $postData['attach_thumb'] = $thumbInfo['savePath'];
		} else {       // 上传文件失败
		    $errMsg = $fileInfo['msg'];
		    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
		    echo json_encode($retData, JSON_UNESCAPED_UNICODE);
		    exit;
		}

		// 处理栏目的 唯一标识
		if (empty($postData['cate_name_alias'])) {
		    $postData['cate_name_alias'] = getLetters($postData['cate_name']);
		}

		$CateModel->data($postData);

		if ($ret = $CateModel->_add()) {
		    //S(C('cateCacheKey'), null); // 删除缓存

		    $retData = ['code' => 0, 'msg' => '添加成功', 'class' => 'ok', 'return_url' => U('index')];
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
	    $field = ['id', 'cate_name', 'parent_id'];
	    $tree = $CateModel->field($field)->getTreeList();
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
	$CateModel = D('Cate');
	if (!$CateModel->isSuperAdmin()) {
	    $this->error('只有超级才有删除的权限');
	    return false;
	}

	$ret = $CateModel->_delete($id);
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

	$CateModel = D('Cate');
	$ret = $CateModel->toTrash($id);
	if ($ret) {
	    $this->success("删除记录成功");
	} else {
	    $this->error("删除记录失败: " . $CateModel->getError());
	}
    }

    /**
     * 修改栏目表
     */
    public function upd() {
	$id = I('id', 0, 'intval');
	$CateModel = D('Cate');
	if (IS_POST) {
	    if ($postData = $CateModel->create(I('post.Cate'))) {
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

		// 处理栏目的 唯一标识
		if (empty($postData['cate_name_alias'])) {
		    $postData['cate_name_alias'] = getLetters($postData['cate_name']);
		}

		$CateModel->data($postData);

		if ($ret = $CateModel->_save()) {
		    //S(C('cateCacheKey'), null); // 删除缓存
		    $retData = ['code' => 0, 'msg' => '添加成功', 'class' => 'ok', 'return_url' => U('index')];
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
	    $this->data = $CateModel->find($id);
	    $this->tree = $CateModel->getTreeList();
	    $this->display();
	}
    }

    /**
     * 排序操作
     */
    public function sort() {
	$postData = I('post.sort_order', 0, 'intval');
	$model = M('Cate');
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
