<?php

namespace MangerSystem\Controller;

class RoleController extends CommonController {

    /**
     * 角色列表
     */
    public function index() {
        $RoleModel = D('Role');
        $this->data = $RoleModel->lst();
        $this->display();
    }
    
    /**
     * 添加角色
     */
    public function add() {
        $RoleModel = D('Role');
        if (IS_POST) {
            if ($RoleModel->create()) {
               
                if ($RoleModel->_add()) {
                    $this->success('添加角色成功');
                } else {
                    $this->error("添加角色失败: " . $RoleModel->getError());
                }
            } else {
                $this->error("添加角色失败: " . $RoleModel->getError());
            }
        } else {
            $PrivilegeModel = D('Privilege');
            $this->actionList = $PrivilegeModel->getTreeList2() ;
            $this->display();
        }
    }

    /**
     * 修改角色
     */
    public function upd($id) {
        $RoleModel = D('Role');
        if (IS_POST) {
            if ($RoleModel->create()) {
                if ($RoleModel->_save() !== FALSE ) {
                    $this->success('修改角色成功');
                } else {
                    $this->error("修改角色失败: " . $RoleModel->getError());
                }
            } else {
                $this->error("修改角色失败: " . $RoleModel->getError());
            }
        } else {
            $data = $RoleModel->find($id);
            $data || E('页面不存在, (｡•ˇ‸ˇ•｡)');
            $this->pri_ids = explode(',',$data['pri_ids']); 
            $this->data = $data; 
            
	    
            # 权限的数据
            $PrivilegeModel = D('Privilege');
            $this->actionList = $PrivilegeModel->getTreeList2() ;
          
            $this->display();
        }
    }

    /**
     * 删除角色
     */
    public function del($id) {
        $RoleModel = D('Role');
        $pk = $RoleModel->getPk();

        $ret = $RoleModel->_delete([$pk => $id]);
        if ($ret) {
            $this->success('删除角色成功!');
        } else {
            $this->error("删除角色失败: " . $RoleModel->getError());
        }
    }

    /**
     * 批量删除角色
     */
    public function bdel() {
        $role_ids = I('post.role_id');
        $RoleModel = D('Role');
        $ret = $RoleModel->_delete($role_ids);
        if($ret) {
            $this->success('批量删除角色成功!');
        } else {
            $this->error('批量删除角色失败: '. $RoleModel->getError());
        }
    }

}

