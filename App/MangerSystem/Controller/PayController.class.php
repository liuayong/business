<?php

namespace MangerSystem\Controller;

use Common\Components\UploadTool;
use Common\Components\ImageTool;

/**
 * 后台栏目表控制器
 */
class PayController extends CommonController {

    /**
     * 栏目表列表
     */
    public function index() {
        $PayTypeModel = D('PayType');
        $this->data = $PayTypeModel->getAll();
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
        $PayTypeModel = D('PayType');
        $ret = $PayTypeModel->toRestore($id);
        if ($ret) {
            $this->success("还原记录成功");
        } else {
            $this->error("还原记录失败: " . $PayTypeModel->getError());
        }
    }

    /**
     * 添加栏目表
     */
    public function add() {
        $id = I('get.id', 0, 'intval');

        $PayTypeModel = D('PayType');
        if (IS_POST) {
            if ($postData = $PayTypeModel->create(I('post.PayType'))) {

                // 处理栏目的 唯一标识
                if (empty($postData['pay_code'])) {
                    $postData['pay_code'] = getLetters($postData['pay_code']);
                }
                $PayTypeModel->data($postData);

                if ($ret = $PayTypeModel->_add()) {
                    $retData = ['code' => 0, 'msg' => '添加成功', 'class' => 'ok', 'return_url' => U('index')];
                } else {
                    $errMsg = '添加失败: ' . $PayTypeModel->getError();
                    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $PayTypeModel->getDbError();
                    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
                }
            } else {
                $errMsg = '添加失败: ' . $PayTypeModel->getError();
                $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $PayTypeModel->getDbError();
                $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
            }

            echo json_encode($retData, JSON_UNESCAPED_UNICODE);
            exit;
        } else {

            $this->display();
        }
    }

    /**
     * 修改栏目表
     */
    public function upd() {
        $id = I('id', 0, 'intval');
        $PayTypeModel = D('PayType');
        if (IS_POST) {
            if ($postData = $PayTypeModel->create(I('post.PayType'))) {

                // 处理 唯一标识
                if (empty($postData['pay_code'])) {
                    $postData['pay_code'] = getLetters($postData['pay_code']);
                }
                $PayTypeModel->data($postData);

                if ($ret = $PayTypeModel->_save()) {
                    $retData = ['code' => 0, 'msg' => '修改成功', 'class' => 'ok', 'return_url' => U('index')];
                } else {
                    $errMsg = '修改失败: ' . $PayTypeModel->getError();
                    $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $PayTypeModel->getDbError();
                    $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
                }
            } else {
                $errMsg = '修改失败: ' . $PayTypeModel->getError();
                $errMsg = APP_DEBUG ? $errMsg : $errMsg . ', ' . $PayTypeModel->getDbError();
                $retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
            }

            echo json_encode($retData, JSON_UNESCAPED_UNICODE);
            exit;
        } else {
            $this->data = $PayTypeModel->find($id);
            $this->display();
        }
    }

    /**
     * 硬删除, 只有超级才有硬删除的权限
     */
    public function del() {
        $id = I('id', 0, 'intval');
        $PayTypeModel = D('PayType');
        if (!$PayTypeModel->isSuperAdmin()) {
            $this->error('只有超级才有删除的权限');
            return false;
        }

        $ret = $PayTypeModel->_delete($id);
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

        $PayTypeModel = D('PayType');
        $ret = $PayTypeModel->toTrash($id);
        if ($ret) {
            $this->success("删除记录成功");
        } else {
            $this->error("删除记录失败: " . $PayTypeModel->getError());
        }
    }

    /**
     * 排序操作
     */
    public function sort() {
        $postData = I('post.sort_order', 0, 'intval');
        $model = M('PayType');
        $pk = $model->getPk();
        foreach ($postData as $id => $sort) {
            $model->where([$pk => $id])->setField(['sort_order' => $sort]);
        }
        $this->success('排序成功', U('index'), 0);
    }

}

