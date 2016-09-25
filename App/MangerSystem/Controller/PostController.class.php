<?php

namespace MangerSystem\Controller;

use Common\Components\UploadTool;
use Common\Components\ImageTool;


/**
 * 后台内容管理控制器
 */
class PostController extends CommonController {

    /**
     * 内容列表
     * 多条件搜索, 分页
     */
    public function index() {
        $PostModel = D('Post');
        $searchRet = $PostModel->search();

        $CateModel = D('Cate');
        $field = ['id', 'cate_name', 'parent_id'];
        $tree = $CateModel->field($field)->getTreeList();

        // 查询cateData 出栏目id 对应的栏目名称
        $cateData = $CateModel->getField('id,cate_name', true);

        $this->assign($searchRet);
        $this->assign('cateData', $cateData);
        $this->assign('tree', $tree);
        $this->display();
    }

    /**
     * @param type $id
     */
    public function view($id = 0) {
//	echo '<h1>待做显示内容: 没有模板</h1>';
        $this->display('Public/uploadify');
    }

    /**
     * 内容列表 回收站
     */
    public function trashList() {
        $PostModel = D('Post');
        $deleteField = C('softDelField');
        $data = $PostModel->search([$deleteField => 1]);
        $this->assign($data);
        $this->display();
    }

    /**
     * 从回收站还原操作
     */
    public function restore() {
        $id = I('id', 0, 'intval');
        $PostModel = D('Post');
        $ret = $PostModel->toRestore($id);
        if ($ret) {
            $this->success("还原记录成功");
        } else {
            $this->error("还原记录失败: " . $PostModel->getError());
        }
    }

    /*
     * // 处理商品相册，并入库
     * 
     */
    protected function handleGallary($post_id = 0, array $data = array(), $type='insert') {
        $uid = session(getSessionUidKey());

        if (empty($data)) {
            $data = I('post.imageList');
        }
        $upDir = './' . UP_DIR_NAME . '/';
        $var = array();
        foreach ((array) $data['file'] as $key => $row) {
            if ($row) {
                $fullPath = $upDir . $row;

                $var[$key]['post_id'] = $post_id;
                $var[$key]['user_id'] = $uid;
                $var[$key]['attach_id'] = $data['fileId'][$key];
                $var[$key]['img_original'] = $row;
                
                if(!file_exists($fullPath)) { continue; }
                // 后台的图片处理操作
                $thumbConfig = array('thumbPrefix' => 'thumb_', 'thumbSize' => array(100, 100), 'thumbType' => 2);
                $thumbInfo = ImageTool::thumb($fullPath, $thumbConfig);

                $midConfig = array('thumbPrefix' => 'mid_', 'thumbSize' => array(400, 400), 'thumbType' => 2);
                $midInfo = ImageTool::thumb($fullPath, $midConfig);

                $zoomConfig = array('thumbPrefix' => 'mid_', 'thumbSize' => array(800, 800), 'thumbType' => 2);
                $zoomInfo = ImageTool::thumb($fullPath, $zoomConfig);

                $var[$key]['img_thumb'] = $thumbInfo['savePath'];
                $var[$key]['img_post'] = $midInfo['savePath'];
                $var[$key]['img_zoom'] = $zoomInfo['savePath'];
                $var[$key]['create_time'] = time();
            }
        }
        $galleryModel = M('post_gallary') ;
        // 修改操作
        if($type != 'insert') { // 插入 $type == 'insert'
            $galleryModel->where(['post_id'=>$post_id])->delete() ;
        } 
        
        $var && $galleryModel->addAll($var);
    }

    /**
     * 添加内容
     */
    public function add() {

        $PostModel = D('Post');
        if (IS_POST) {
	    
            if ($postData = $PostModel->create(I('post.Post'))) {

                if (!empty($_FILES)) {                  // 含有文件上传
                    reset($_FILES);
                    $key = key($_FILES);
                    $savepath = strtolower(CONTROLLER_NAME) . '/';
                }
                $fileInfo = UploadTool::upload($_FILES[$key], array('savePath' => $savepath));
                if ($fileInfo['code'] == 0) {
                    // 生成多张缩略图
                    $thumbConfig = array('thumbPrefix' => 'thumb_', 'thumbSize' => array(100, 100), 'thumbType' => 2);
                    $thumbInfo = ImageTool::thumb($fileInfo['fullPath'], $thumbConfig);

                    $midConfig = array('thumbPrefix' => 'mid_', 'thumbSize' => array(400, 400), 'thumbType' => 2);
                    $midInfo = ImageTool::thumb($fileInfo['fullPath'], $midConfig);

                    $zoomConfig = array('thumbPrefix' => 'mid_', 'thumbSize' => array(800, 800), 'thumbType' => 2);
                    $zoomInfo = ImageTool::thumb($fileInfo['fullPath'], $zoomConfig);

                    $postData['img_original'] = $fileInfo['savepath'];
                    $postData['img_thumb'] = $thumbInfo['savePath'];
                    $postData['img_post'] = $midInfo['savePath'];
                    $postData['img_zoom'] = $zoomInfo['savePath'];
                } else {       // 上传文件失败, 是否需要阻止程序的继续执行
                    $errMsg = $fileInfo['msg'];
                    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
                    echo json_encode($retData, JSON_UNESCAPED_UNICODE);
                    exit;
                }

                $PostModel->data($postData);

                $gallaryData = I('post.imageList');

                if ($ret = $PostModel->_add()) {
                    
                    // 处理标签
                    D('PostTag')->build( 'create', $postData['tags'],  $ret, $postData['cate_id'] );
                    
                    // 处理组图
                    $this->handleGallary($ret, $gallaryData, 'insert');
                    $retData = ['code' => 0, 'msg' => '添加成功', 'class' => 'ok', 'return_url' => U('index')];
                } else {
                    $errMsg = '添加失败: ' . $PostModel->getError();
                    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $PostModel->getDbError();
                    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
                }
            } else {
                $errMsg = '添加失败: ' . $PostModel->getError();
                $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $PostModel->getDbError();
                $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
            }
            echo json_encode($retData, JSON_UNESCAPED_UNICODE);
        } else {
            $CateModel = D('Cate');
            $field = ['id', 'cate_name', 'parent_id'];
            $tree = $CateModel->field($field)->getTreeList();

            $SpecialModel = D('Special');
            $where = ['status_is' => 'Y', 'is_deleted'=>0];
            $specialData = $SpecialModel->where($where)->getField('special_id,special_name', true);

            $this->assign('tree', $tree);
            $this->assign('specialData', $specialData);
            $this->display();
        }
    }

    /**
     * 硬删除, 只有超级才有硬删除的权限
     */
    public function del($id) {
        $id = I('id', 0, 'intval');
        $PostModel = D('Post');
        if (!$PostModel->isSuperAdmin()) {
            $this->error('只有超级才有删除的权限');
            return false;
        }

        $ret = $PostModel->_delete($id);
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

        $PostModel = D('Post');
        $ret = $PostModel->toTrash($id);
        if ($ret) {
            $this->success("删除记录成功");
        } else {
            $this->error("删除记录失败: " . $PostModel->getError());
        }
    }

    /**
     * 修改内容
     */
    public function upd() {

        $id = I('id', 0, 'intval');
        $PostModel = D('Post');
        if (IS_POST) {
            if ($postData = $PostModel->create(I('post.Post'))) {
                if (!empty($_FILES)) {                  // 含有文件上传
                    reset($_FILES);
                    $key = key($_FILES);
                    $savepath = strtolower(CONTROLLER_NAME) . '/';
                }
                // 没有文件上传 UPLOAD_ERR_NO_FILE ， 保留原来的文件, 是否添加一个删除按钮 ？？
                if ($_FILES[$key]['error'] == UPLOAD_ERR_OK) {

                    $fileInfo = UploadTool::upload($_FILES[$key], array('savePath' => $savepath));

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

                $PostModel->data($postData);
                $gallaryData = I('post.imageList');
            
                
                if ($ret = $PostModel->_save() !== FALSE) {
                    
                    $pkVal = $postData[$PostModel->getPk()] ;
                     // 处理标签
                     D('PostTag')->build( 'update', $postData['tags'],  $pkVal, $postData['cate_id'] );
                    
                    // 处理组图
                    $this->handleGallary($pkVal, $gallaryData, 'update');
                    $retData = ['code' => 0, 'msg' => '修改成功', 'class' => 'ok', 'return_url' => U('index')];
                } else {
                    $errMsg = '修改失败: ' . $PostModel->getError();
                    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $PostModel->getDbError();
                    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
                }
            } else {
                $errMsg = '修改失败: ' . $PostModel->getError();
                $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $PostModel->getDbError();
                $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
            }
            echo json_encode($retData, JSON_UNESCAPED_UNICODE);
            return ;
        } else {
            $data = $PostModel->find($id);
           
            $CateModel = D('Cate');
            $field = ['id', 'cate_name', 'parent_id'];
            $tree = $CateModel->field($field)->getTreeList();

            $SpecialModel = D('Special');
            $where = ['status_is' => 'Y', 'is_deleted'=>0];
            $specialData = $SpecialModel->where($where)->getField('special_id,special_name', true);
	    
	    
	    
            $this->assign('data', $data);
            $this->assign('tree', $tree);
            $this->assign('specialData', $specialData);
            $this->imgList = $this->showImgList($data['post_id']);
            
            $this->display();
        }
    }

    /**
     *  组图的列表 
     * @param type $cid 组图所属内容页
     * @return type
     */
    protected function showImgList($cid) {
        $gallary = M('post_gallary')->field('gallary_id, attach_id, img_original')->where(['post_id' => $cid])->select();
        $this->assign('gallary', $gallary);
        $imgList = $this->fetch('imgList');
        return $imgList;
    }

    /**
     * 排序操作
     */
    public function sort() {
        $postData = I('post.sort_order', 0, 'intval');
        $model = M('Post');
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
    
    /**
     * ajax 获取栏目的额外字段
     */
    public function ajaxAttr($cate_id=0) {
	
	if(IS_POST) {
	    $cate_id = I('post.cate_id', 0, 'intval');
	    $post_id = I('post.post_id', 0, 'intval');

	    $where = ['cate_id' => $cate_id];
	    // 获取属性生成动态的表单的数据
	    $field = ['attr_id', 'attr_name', 'attr_name_alias', 'tips', 'attr_type', 'data_default'];
	    $attrData = D('Attr')->field($field)->where($where)->getAll() ;

	    $attrVal = array( );
	    if($post_id) {	// 修改操作, 修改post的时候需要显示原有的扩展属性
		$attrVal = M('attrVal')->where(['post_id'=>$post_id])->getField('attr_id,attr_val', true);
	    }

	    if ($attrData) {
		$this->assign('attrData', $attrData);
		$this->assign('attrVal', $attrVal);
		$this->display('ajaxAttr');
	    } else {
		$msg = '该栏目下没有额外的属性';
		echo $msg ;
	    }
	}
    }
}

