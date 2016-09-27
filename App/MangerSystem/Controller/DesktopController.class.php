<?php

namespace MangerSystem\Controller;

use Common\Components\UploadTool;
use Common\Components\ImageTool;

/**
 * 后台桌面管理控制器
 */
class DesktopController extends CommonController {

    /**
     * 初始化方法
     */
    protected function _initialize() {

        parent::_initialize();
    }

    protected function getRootPath() {
        $host = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $host = $host === '/' ? $host : $host . '/';

        $documentRoot = $_SERVER['DOCUMENT_ROOT'] ?: $_SERVER['CONTEXT_DOCUMENT_ROOT'] ;

        return $documentRoot . $host ;
    }

    /**
     * 桌面列表
     */
    public function index() {

        $DesktopModel = $this->model ? : D('Desktop');
        $data = $DesktopModel->getAll();
        #var_dump($DesktopModel->limit(2)->putInitData());
        
        $this->assign('data', $data);
        $this->display();
    }
    
    

    /**
     * 桌面列表 回收站
     */
    public function trashList() {
        $DesktopModel = D('Desktop');
        $deleteField = C('softDelField');
        $data = $DesktopModel->search([$deleteField => 1]);
        $this->assign($data);
        $this->display();
    }

    /**
     * 从回收站还原操作
     */
    public function restore() {
        $id = I('id', 0, 'intval');
        $DesktopModel = D('Desktop');
        $ret = $DesktopModel->toRestore($id);
        if ($ret) {
            $this->success("还原记录成功");
        } else {
            $this->error("还原记录失败: " . $DesktopModel->getError());
        }
    }

    /**
     * 添加桌面
     */
    public function add() {

        $DesktopModel = D('Desktop');
        if (IS_POST) {

            if ($postData = $DesktopModel->create(I('post.Desktop'))) {

                if (!empty($_FILES)) {                  // 含有文件上传
                    reset($_FILES);
                    $key = key($_FILES);
                }
                
                $savepath = strtolower(CONTROLLER_NAME) . '/';
                $fileInfo = UploadTool::upload($_FILES[$key], array('savePath' => $savepath));
                if ($fileInfo['code'] == 0) {
                    $thumbInfo = ImageTool::thumb($fileInfo['fullPath'], array('thumbPrefix' => 'thumb_', 'thumbSize' => array(100, 100), 'thumbType' => 2));
                    $postData['original_icon'] = $fileInfo['savepath'];
                    $postData['thumb_icon'] =  $thumbInfo['savePath'];
                } else {       // 上传文件失败
                    $errMsg = $fileInfo['msg'];
                    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
                    echo json_encode($retData, JSON_UNESCAPED_UNICODE);
                    exit;
                }
                
                $DesktopModel->data($postData);
                if ($ret = $DesktopModel->_add()) {
                    $retData = ['code' => 0, 'msg' => '添加成功', 'class' => 'ok', 'return_url' => U('index')];
                } else {
                    $errMsg = '添加失败: ' . $DesktopModel->getError();
                    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $DesktopModel->getDbError();
                    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
                }
            } else {
                $errMsg = '添加失败: ' . $DesktopModel->getError();
                $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $DesktopModel->getDbError();
                $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
            }
            echo json_encode($retData, JSON_UNESCAPED_UNICODE);
            return;
        } else {
            $this->display();
        }
    }

    /**
     * 硬删除, 只有超级才有硬删除的权限
     */
    public function del() {
        $id = I('id', 0, 'intval');
        $DesktopModel = D('Desktop');
        if (!$DesktopModel->isSuperAdmin()) {
            $this->error('只有超级才有删除的权限');
            return false;
        }

        $ret = $DesktopModel->_delete($id);
        if ($ret) {
            $this->success("删除记录成功");
        } else {

            $this->error("删除记录失败: " . $AdminModel->getError());
        }
    }


    /**
     * 修改桌面
     */
    public function upd() {
        $id = I('id', 0, 'intval');
        $DesktopModel = D('Desktop');
        if (IS_POST) {
            if ($postData = $DesktopModel->create(I('post.Desktop'))) {
                
               if (!empty($_FILES)) {                  // 含有文件上传
                    reset($_FILES);
                    $key = key($_FILES);
                    $savepath = strtolower(CONTROLLER_NAME) . '/';
                }
                
                // 没有文件上传 UPLOAD_ERR_NO_FILE ， 保留原来的文件, 是否添加一个删除按钮 ？？
                if ($_FILES[$key]['error'] == UPLOAD_ERR_OK) {
                    $fileInfo = UploadTool::upload($_FILES[$key], array('savePath' => $savepath));

                    if ($fileInfo['code'] == 0) {
                        $thumbInfo = ImageTool::thumb($fileInfo['fullPath'], array('thumbPrefix' => 'thumb_', 'thumbSize' => array(100, 100), 'thumbType' => 2));
                        $postData['original_icon'] = $fileInfo['savepath'];
                        $postData['thumb_icon'] =  $thumbInfo['savePath'];
                        
                    } else {       // 上传文件失败
                        $errMsg = $fileInfo['msg'];
                        $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
                        echo json_encode($retData, JSON_UNESCAPED_UNICODE);
                        exit;
                    }
                }

                $DesktopModel->data($postData);

                if ($ret = $DesktopModel->_save() !== FALSE) {

                    $retData = ['code' => 0, 'msg' => '修改成功', 'class' => 'ok', 'return_url' => U('index')];
                } else {
                    $errMsg = '修改失败: ' . $DesktopModel->getError();
                    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $DesktopModel->getDbError();
                    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
                }
            } else {
                $errMsg = '修改失败: ' . $DesktopModel->getError();
                $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $DesktopModel->getDbError();
                $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
            }
            echo json_encode($retData, JSON_UNESCAPED_UNICODE);
            return ;
        } else {
            $data = $DesktopModel->find($id);
            $this->data = $data;
            $this->display();
        }
    }

    /**
     * 排序操作
     */
    public function sort() {
        $postData = I('post.sort_order', 0, 'intval');
        $model = M('Desktop');
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

