<?php

namespace MangerSystem\Controller;

use Common\Components\UploadTool;
use Common\Components\ImageTool;

/**
 * 后台专题管理控制器
 */
class SpecialController extends CommonController {

    /**
     * 专题列表
     */
    public function index() {
        
        $SpecialModel = D('Special');
        $field = ['special_id', 'special_name', 'name_alias', 'create_time', 'status_is', 'sort_order'];
        $data = $SpecialModel ->getAll();
        $this->assign('data', $data);
        $this->display();
    }
 
    
    /**
     * 专题列表 回收站
     */
    public function trashList() {
        $SpecialModel = D('Special');
        $deleteField = C('softDelField');
        $data = $SpecialModel->search([$deleteField => 1]);
        $this->assign($data);
        $this->display();
    }
    
    /**
     * 从回收站还原操作
     */
    public function restore() {
        $id = I('id', 0, 'intval');
        $SpecialModel = D('Special');
        $ret = $SpecialModel->toRestore($id);
        if ($ret) {
            $this->success("还原记录成功");
        } else {
            $this->error("还原记录失败: " . $SpecialModel->getError());
        }
    }

   /**
     * 添加专题
     */
    public function add() {

        $SpecialModel = D('Special');
                
        if (IS_POST) {
    
            if ($postData = $SpecialModel->create(I('post.Special'))) {

                $fileInfo = UploadTool::upload($_FILES['img_original'], array('savePath' => 'special/'));

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

                $SpecialModel->data($postData);

                if ($ret = $SpecialModel->_add()) {

                    $retData = ['code' => 0, 'msg' => '添加成功', 'class' => 'ok', 'return_url' => U('index')];
                } else {
                    $errMsg = '添加失败: ' . $SpecialModel->getError();
                    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $SpecialModel->getDbError();
                    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
                }
            } else {
                $errMsg = '添加失败: ' . $SpecialModel->getError();
                $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $SpecialModel->getDbError();
                $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
            }
            echo json_encode($retData, JSON_UNESCAPED_UNICODE);
            exit;
        } else {
            $this->display();
        }
    }

    /**
     * 硬删除, 只有超级才有硬删除的权限
     */
    public function del() {
        $id = I('id', 0, 'intval');
        $SpecialModel = D('Special');
        if (!$SpecialModel->isSuperAdmin()) {
            $this->error('只有超级才有删除的权限');
            return false;
        }

        $ret = $SpecialModel->_delete($id);
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

        $SpecialModel = D('Special');
        $ret = $SpecialModel->toTrash($id);
        if ($ret) {
            $this->success("删除记录成功");
        } else {
            $this->error("删除记录失败: " . $SpecialModel->getError());
        }
    }
    
    

    /**
     * 修改专题
     */
    public function upd() {
        $id = I('id', 0, 'intval');
        $SpecialModel = D('Special');
        if (IS_POST) {
            if ($postData = $SpecialModel->create(I('post.Special'))) {
      
                // 没有文件上传 UPLOAD_ERR_NO_FILE ， 保留原来的文件, 是否添加一个删除按钮 ？？
                if($_FILES['img_original']['error'] == UPLOAD_ERR_OK ) {
                    
                    $fileInfo = UploadTool::upload($_FILES['img_original'], array('savePath' => 'special/'));
                    
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
                
                $SpecialModel->data($postData);

                if ($ret = $SpecialModel->_save()  !== FALSE ) {

                    $retData = ['code' => 0, 'msg' => '修改成功', 'class' => 'ok', 'return_url' => U('index')];
                } else {
                    $errMsg = '修改失败: ' . $SpecialModel->getError();
                    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $SpecialModel->getDbError();
                    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
                }
            } else {
                $errMsg = '修改失败: ' . $SpecialModel->getError();
                $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $SpecialModel->getDbError();
                $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
            }
            echo json_encode($retData, JSON_UNESCAPED_UNICODE);
            exit;
        } else {
            $data = $SpecialModel->find($id);
            $this->data = $data;
            $this->display();
        }
    }

    
    /**
     * 排序操作
     */
    public function sort() {
        $postData = I('post.sort_order', 0, 'intval');
        $model = M('Special');
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

