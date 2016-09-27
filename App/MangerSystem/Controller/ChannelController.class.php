<?php

namespace MangerSystem\Controller;

use Common\Components\UploadTool;
use Common\Components\ImageTool;

/**
 * 后台栏目表控制器
 */
class ChannelController extends CommonController {

    /**
     * 栏目表列表
     */
    public function index() {
	// $ChannelModel = D('Channel');
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
        $ChannelModel = D('Channel');
        $ret = $ChannelModel->toRestore($id);
        if ($ret) {
            $this->success("还原记录成功");
        } else {
            $this->error("还原记录失败: " . $ChannelModel->getError());
        }
    }

    /**
     * 添加栏目表
     */
    public function add() {
        $id = I('get.id', 0, 'intval'); 
        
        $ChannelModel = D('Channel');
        if (IS_POST) {
            if ($postData = $ChannelModel->create(I('post.Channel'))) {
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

                $ChannelModel->data($postData);

                if ($ret = $ChannelModel->_add()) {
                    //S(C('cateCacheKey'), null); // 删除缓存

                    $retData = ['code' => 0, 'msg' => '添加成功', 'class' => 'ok', 'return_url' => U('index')];
                } else {
                    $errMsg = '添加失败: ' . $ChannelModel->getError();
                    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $ChannelModel->getDbError();
                    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
                }
            } else {
                $errMsg = '添加失败: ' . $ChannelModel->getError();
                $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $ChannelModel->getDbError();
                $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
            }

            echo json_encode($retData, JSON_UNESCAPED_UNICODE);
            exit;
        } else {
            $field = ['id', 'cate_name', 'parent_id'];
            $tree = $ChannelModel->field($field)->getTreeList();
            $this->tree = $tree;
            $this->my_id = $id ;
            $this->display();
        }
    }

    /**
     * 硬删除, 只有超级才有硬删除的权限
     */
    public function del() {
        $id = I('id', 0, 'intval');
        $ChannelModel = D('Channel');
        if (!$ChannelModel->isSuperAdmin()) {
            $this->error('只有超级才有删除的权限');
            return false;
        }

        $ret = $ChannelModel->_delete($id);
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

        $ChannelModel = D('Channel');
        $ret = $ChannelModel->toTrash($id);
        if ($ret) {
            $this->success("删除记录成功");
        } else {
            $this->error("删除记录失败: " . $ChannelModel->getError());
        }
    }

    /**
     * 修改栏目表
     */
    public function upd() {
        $id = I('id', 0, 'intval');
        $ChannelModel = D('Channel');
        if (IS_POST) {
            if ($postData = $ChannelModel->create(I('post.Channel'))) {
                // 没有文件上传 UPLOAD_ERR_NO_FILE ， 保留原来的文件, 是否添加一个删除按钮 ？？
                if($_FILES['img_original']['error'] == UPLOAD_ERR_OK ) {
                    
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

                $ChannelModel->data($postData);

                if ($ret = $ChannelModel->_save()) {
                    //S(C('cateCacheKey'), null); // 删除缓存
                    $retData = ['code' => 0, 'msg' => '添加成功', 'class' => 'ok', 'return_url' => U('index')];
                } else {
                    $errMsg = '添加失败: ' . $ChannelModel->getError();
                    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $ChannelModel->getDbError();
                    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
                }
            } else {
                $errMsg = '添加失败: ' . $ChannelModel->getError();
                $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $ChannelModel->getDbError();
                $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
            }
            echo json_encode($retData, JSON_UNESCAPED_UNICODE);
            exit;
            
        } else {
            $this->data = $ChannelModel->find($id); 
            $this->tree = $ChannelModel->getTreeList();
            $this->display();
        }
    }

    /**
     * 排序操作
     */
    public function sort() {
        $postData = I('post.sort_order', 0, 'intval');
        $model = M('Channel');
        $pk = $model->getPk();
        foreach ($postData as $id => $sort) {
            $model->where([$pk => $id])->setField(['sort_order' => $sort]);
        }
        $this->success('排序成功', U('index'), 0);
    }

    
}

