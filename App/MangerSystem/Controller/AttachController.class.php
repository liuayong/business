<?php

namespace MangerSystem\Controller;


/**
 * 后台附件管理控制器
 */
class AttachController extends CommonController {

    /**
     * 附件列表
     * 多条件搜索, 分页
     */
    public function index() {
        $AttachModel = D('Attach');
        $searchRet = $AttachModel->search();

         $this->assign($searchRet);
        $this->display();
    }

    /**
     * 硬删除, 只有超级才有硬删除的权限
     */
    public function del2() {
        $id = I('id', 0, 'intval');
        $AttachModel = D('Attach');
        if (!$AttachModel->isSuperAdmin()) {
            $this->error('只有超级才有删除的权限');
            return false;
        }

        $ret = $AttachModel->_delete($id);
        if ($ret) {
            $this->success("删除记录成功", '', 35);
        } else {
            $this->error("删除记录失败: " . $AttachModel->getError(), '', 333);
        }
    }

    /**
     * 软删除 【单/多条记录】
     * @param type $id
     */
    public function toTrash($id) {
        $id = I('id', 0, 'intval');

        $AttachModel = D('Attach');
        $ret = $AttachModel->toTrash($id);
        if ($ret) {
            $this->success("删除记录成功");
        } else {
            $this->error("删除记录失败: " . $AttachModel->getError());
        }
    }

}

