<?php

namespace MangerSystem\Model;

class RoleModel extends CommonModel {

//  ['name', '', '用户名已经存在', self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH],
    protected $_validate = [
        ['role_name', 'require', '角色名不能为空'],
      //['role_name', '', '角色名已经存在', self::MUST_VALIDATE, 'unique', self::MODEL_BOTH],
      //['pri_ids', 'require', '请给角色至少分配一个权限', self::MUST_VALIDATE, ]
    ];

    /**
     * 增加的方法
     */
    public function _add() {
        $this->handlePriIds($this->data);
        $ret = parent::add();
        return $ret;
    }

    /**
     * 删除方法, 可以批量删除
     * @param $ida string or array
     */
    public function _delete($ids) {
        // 字符串形式传递过来
        if (is_array($ids)) {
            $ids = implode(',', $ids);
        }
        $ret = parent::delete($ids);
        return $ret;
    }

    /**
     * 修改方法
     */
    public function _save() {
        $this->handlePriIds($this->data);
        $ret = parent::save();
        return $ret;
    }

    public function lst(array $where) {
        $data = $this->where($where)->select();
        return $data;
    }

    /**
     * 预处理操作, 处理pri_ids字段
     * @param type $data
     */
    protected function handlePriIds(&$data) {
        if (isset($data['pri_ids'])) {
            $data['pri_ids'] = implode(',', $data['pri_ids']);
        } else {
            $data['pri_ids'] = '';
        }
    }

    /**
     * 获得所有的角色
     */
    public function getRoles(array $where = []) {
        $roles = $this->where($where)->getField("{$this->pk},role_name");
        return $roles;
    }

}

