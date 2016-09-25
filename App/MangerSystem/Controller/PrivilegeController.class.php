<?php

namespace MangerSystem\Controller;

class PrivilegeController extends CommonController {

    /**
     * 权限列表
     */
    public function index() {
        $PrivilegeModel = D('Privilege');
        $this->treeList = $PrivilegeModel->getTreeList();
        $this->display();
    }

    /**
     * 添加权限
     */
    public function add() {
        $PrivilegeModel = D('Privilege');
        if (IS_POST) {
            if ($PrivilegeModel->create()) {
                if ($PrivilegeModel->_add()) {
                    $this->success('添加权限成功', '', 10);
                } else {
                    $this->error("添加权限失败: " . $PrivilegeModel->getError());
                }
            } else {
                $this->error("添加权限失败: " . $PrivilegeModel->getError());
            }
        } else {
            $this->treeList = $PrivilegeModel->getTreeList();
            $this->display();
        }
    }

    /**
     * 修改权限
     */
    public function upd($id) {
        $PrivilegeModel = D('Privilege');
        if (IS_POST) {
            if ($PrivilegeModel->create()) {
                if ($PrivilegeModel->_save() !== FALSE) {
                    $this->success('修改权限成功');
                } else {
                    $this->error("修改权限失败: " . $PrivilegeModel->getError());
                }
            } else {
                $this->error("修改权限失败: " . $PrivilegeModel->getError());
            }
        } else {
            $this->treeList = $PrivilegeModel->getTreeList();
            $this->data = $PrivilegeModel->find($id);
            $this->data || E('页面不存在, (｡•ˇ‸ˇ•｡)');
            $this->display();
        }
    }

    /**
     * 删除权限
     */
    public function del($id) {
        $PrivilegeModel = D('Privilege');
        $pk = $PrivilegeModel->getPk();
        
        $ret = $PrivilegeModel->_delete([$pk => $id]);
        if ($ret) {
            $this->success('删除权限成功!');
        } else {
            $this->error("删除权限失败: " . $PrivilegeModel->getError());
        }
        
        // bbbb 不是末级分类或者此分类下还存在有商品,您不能删除!
        // ccccccc 不是末级分类或者此分类下还存在有商品,您不能删除!
    }

    /**
     * 批量删除权限
     */
    public function bdel() {
        
    }

    
    /**
     * 排序操作
     */
    public function sort() {
        $postData = I('post.sort', 0, 'intval');
        $model = M('Privilege');
        $pk = $model -> getPk() ;
        foreach($postData as $id => $sort) {
            $model->where([$pk => $id])->setField(['sort' => $sort]);
        }
        $this->success('排序成功', U('index'), 0);
    }

}

