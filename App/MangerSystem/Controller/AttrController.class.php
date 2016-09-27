<?php

namespace MangerSystem\Controller;

/**
 * 后台属性制器
 */
class AttrController extends CommonController {

    protected $model;

    protected function _initialize() {
	parent::_initialize();
    }

    /**
     * 属性列表
     */
    public function index() {
	$AttrModel = D('Attr');
	$data = $AttrModel->getAll();

	// 查询对应的栏目映射
	$cateData = D('Cate')->getCateData();
	
	$this->assign('data', $data);
	$this->assign('cateData', $cateData);
	$this->display();
    }

    
    /**
     * 属性列表 回收站
     */
    public function trashList() {
	$this->display();
    }

    
    /**
     * 从回收站还原操作
     */
    public function restore() {
	$id = I('id', 0, 'intval');
	$AttrModel = D('Attr');
	$ret = $AttrModel->toRestore($id);
	if ($ret) {
	    $this->success("还原记录成功");
	} else {
	    $this->error("还原记录失败: " . $AttrModel->getError());
	}
    }

    /**
     * 添加属性
     */
    public function add() {

	$AttrModel = D('Attr');
	if (IS_POST) {
	    
	    if ($postData = $AttrModel->create(I('post.Attr'))) {

		$AttrModel->data($postData);

		if ($ret = $AttrModel->_add()) {
		    $retData = ['code' => 0, 'msg' => '添加成功', 'class' => 'ok', 'return_url' => U('index')];
		} else {
		    $errMsg = '添加失败: ' . $AttrModel->getError();
		    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $AttrModel->getDbError();
		    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
		}
	    } else {
		$errMsg = '添加失败: ' . $AttrModel->getError();
		$errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $AttrModel->getDbError();
		$retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
	    }
	    echo json_encode($retData, JSON_UNESCAPED_UNICODE);
	    exit;
	} else {
	    
	    // 栏目的下拉列表
	    $cateSelect = D('Cate')->showTreeSelect('', ['prompt' => ' === 请选择 === ', 'name' => "Attr[cate_id]", 'id' => 'Attr_cate_id']);
	    $data = [
		'input' => '文本输入',
		'select' => '下拉选择',
		'checkbox' => '多选',
		'radio' => '单选',
		'textarea' => '大段内容',
	    ];
	    $typeSelectHtml = showSelect($data, '', array('id'=> 'Attr_attr_type', 'name'=>'Attr[attr_type]'));
	    $this->assign('cateSelect', $cateSelect);
	    $this->assign('typeSelectHtml', $typeSelectHtml);
	    $this->display();
	}
    }

    /**
     * 修改属性
     */
    public function upd() {
	$id = I('id', 0, 'intval');
	$AttrModel = D('Attr');
	if (IS_POST) {
	    if ($postData = $AttrModel->create(I('post.Attr'))) {

		// 处理栏目的 唯一标识
		if (empty($postData['name_alias'])) {
		    $postData['name_alias'] = getLetters($postData['bank_name']);
		}

		$AttrModel->data($postData);

		if ($ret = $AttrModel->_save()) {
		    //S(C('cateCacheKey'), null); // 删除缓存
		    $retData = ['code' => 0, 'msg' => '修改成功', 'class' => 'ok', 'return_url' => U('index')];
		} else {
		    $errMsg = '修改失败: ' . $AttrModel->getError();
		    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $AttrModel->getDbError();
		    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
		}
	    } else {
		$errMsg = '修改失败: ' . $AttrModel->getError();
		$errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $AttrModel->getDbError();
		$retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
	    }
	    echo json_encode($retData, JSON_UNESCAPED_UNICODE);
	    exit;
	} else {
	    $attrData = $AttrModel->find($id);
	    // 栏目的下拉列表
	    $cateSelect = D('Cate')->showTreeSelect($attrData['cate_id'], ['prompt' => ' === 请选择 === ', 'name' => "Attr[cate_id]", 'id' => 'Attr_cate_id']);
	    $data = [
		'input' => '文本输入',
		'select' => '下拉选择',
		'checkbox' => '多选',
		'radio' => '单选',
		'textarea' => '大段内容',
	    ];
	    
	    $typeSelectHtml = showSelect($data, $attrData['attr_type'], array('id'=> 'Attr_attr_type', 'name'=>'Attr[attr_type]'));
	    
	    $this->assign('cateSelect', $cateSelect);
	    $this->assign('typeSelectHtml', $typeSelectHtml);
	    $this->assign('attrData', $attrData);
	    $this->display();
	}
    }
    

    /**
     * 硬删除, 只有超级才有硬删除的权限
     */
    public function del() {
	$id = I('id', 0, 'intval');
	$AttrModel = D('Attr');
	if (!$AttrModel->isSuperAdmin()) {
	    $this->error('只有超级才有删除的权限');
	    return false;
	}

	$ret = $AttrModel->_delete($id);
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

	$AttrModel = D('Attr');
	$ret = $AttrModel->toTrash($id);
	if ($ret) {
	    $this->success("删除记录成功");
	} else {
	    $this->error("删除记录失败: " . $AttrModel->getError());
	}
    }

    /**
     * 排序操作
     */
    public function sort() {
	$postData = I('post.sort_order', 0, 'intval');
	$model = M('Attr');
	$pk = $model->getPk();
	foreach ($postData as $id => $sort) {
	    $model->where([$pk => $id])->setField(['sort_order' => $sort]);
	}
	$this->success('排序成功', U('index'), 0);
    }

}
