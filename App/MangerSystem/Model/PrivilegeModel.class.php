<?php

namespace MangerSystem\Model;

use Common\Components\Tree2;

/**
 * 管理员模型
 */
class PrivilegeModel extends CommonModel {

    /**
     * 自动验证
     * array(field,rule,message,condition,type,when,params)
     */
    protected $_validate = [
        ['name', 'require', '权限名称不能为空', self::MUST_VALIDATE],
        ['name', '', '权限名称已经存在', self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH],
//      ['name', '1,12', '权限名称不能超过30个字符', self::EXISTS_VALIDATE, 'length'],
        ['module_name', 'isReasonableName', '', 2, 'callback', 3, [['fieldName' => 'module_name', 'fieldLabel' => '模块名']]],
        ['controller_name', 'isReasonableName', '', 2, 'callback', 3, [['fieldName' => 'controller_name', 'fieldLabel' => '控制器名']]],
        ['action_name', 'isReasonableName', '', 2, 'callback', 3, [['fieldName' => 'action_name', 'fieldLabel' => '方法名']]],
    ];

    protected function isReasonableName($name, $fieldOptions) {
        if ($name[0] >= '0' && $name[0] <= '9') {
            $errMsg = $fieldOptions['fieldLabel'] . '不能以数字开头';
            $this->error = $errMsg;
            return false;
        }
        if (preg_match('/^[a-z0-9_]+$/i', $name) == 0) {
            $errMsg = $fieldOptions['fieldLabel'] . '只能包含字母数字和下划线';
            $this->error = $errMsg;
            return false;
        }
        $maxLen = 30;
        if (strlen($name) > $maxLen) {
            $errMsg = $fieldOptions['fieldLabel'] . "长度不能超过{$maxLen}位";
            $this->error = $errMsg;
            return false;
        }
        return true;
    }

    /**
     * 此方法是私有方法, 不能直接被访问
     * @return $level integer
     */
    private function figureLevel() {
        $data = $this->data;        // 接收数据对象
        if ($data['parent_id'] == 0) {
            $data['level'] = 1;
        } else {
            // $level = $this->field('level')->find($this->parent_id);
            $level = $this->where([$this->pk => $this->parent_id])->getField(level);
            $data['level'] = $level + 1;
        }
        return $data['level'];
    }

    /**
     * 添加方法 
     */
    public function _add() {
        $data = $this->data;        // 接收数据对象
        $data['level'] = $this->figureLevel();
        $ret = parent::add($data);
        return $ret;
    }
    
    /**
     * 修改方法
     */
    public function _save() {
        $data = $this->data;
        // $data['level'] = $this->figureLevel();  // 把level的计算放在钩子函数中去
        $ret = parent::save($data);
        return $ret ;
    }
    
    /**
     * 删除方法, 可以批量删除
     * @param $ida string or array
     */
    public function  _delete($ids) {
        // 字符串形式传递过来
        if (is_scalar($ids)) {
            $ids = explode(',', $ids);
        } 
        foreach ($ids as $id) {
            if(!$this->isLeaf($id)) {
                $this->error = '主键ID为'.$id.'的记录下面还有子权限, 不能直接删除!'; 
                return false ;
            }
        }
        $ret = parent::delete(implode(',', $ids));
        return $ret ;
    }
    
    /**
     *  查询方法, 返回的是一个二维数组
     */
    public function getTreeList() {
        // $fields = ['id', 'name', 'parent_id'] ;
        $all = $this->select();
        $treeList = Tree2::getTree($all);
        return $treeList;
    }
    
    /**
     * 查询方法， 返回的是一个多维数组
     */
    public function getTreeList2(array $where= []) {
        // order(['sort'=>'desc']) 怎么传递过来
        $all = $this->where($where)->order(['sort'=>'desc'])->select();
        $all = Tree2::unLimitForLevel($all);
        return $all;
    }
    /**
     * 根据主键判断是否属于叶子节点
     * @param type $id
     * @return boolean 
     */
    public function isLeaf($id) {
        $count = $this->where(['parent_id' => $id])->count($this->pk, 'ok');
        return ! $count ;
    }
    
    /**
     * 获得某个特定节点的子孙树的id
     * @param $id integer/array
     * @return ids array
     */
    protected function _getChildsId($id) {
         $all = $this->field('id, parent_id')->select();
         $cIds = Tree2::getChildsId($all, $id);
         return $cIds ;
    }
    
    /**
     * @param array $ids  获得所有的子ids
     * @return array 
     */
    public  function getChildsId ($ids) {
        $childIds = [];
        if(is_numeric($ids)) {
            $childIds = $this->_getChildsId($ids) ;
        } else if(is_array($ids)) {
            foreach ($ids as $k => $id) {
                $childIds = array_merge($childIds, $this->getChildsId($id));
            }
            $childIds = array_unique($childIds);
        }
        return $childIds ;
    }
    
    protected function _before_update(&$data, $options) {
        parent::_before_update($data, $options);
        
        $id = $options['where'][$this->pk];
        $ids = $this->getChildsId($id);
        $ids[] = $id ;
        
        if(in_array($data['parent_id'], $ids)) {
            $this->error = '所选择的上级分类不能是当前分类或者当前分类的下级分类!';
            return false ;
        }
        $data['level'] = $this->figureLevel();
        return true ;
    }
    
    
    protected function _after_select(&$resultSet, $options) {
        array_walk($resultSet, function (&$v, $k) {
            $v['module_name'] == '' && $v['module_name'] = 'null';
            $v['controller_name'] == '' && $v['controller_name'] = 'null';
            $v['action_name'] == '' && $v['action_name'] = 'null';
        });
    }
    
}


