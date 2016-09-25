<?php

namespace MangerSystem\Model;

use Common\Components\Tree;

/**
 * 导航分类模型
 */
class NavCateModel extends CommonModel {
    
    //protected $tablePrefix = 'nav_'; 
    protected $tableName  = 'cate'; 
    
    //protected $trueTableName = 'nav_cate'; 
    //protected $dbName = 'note_book';
    
    
    protected  $parent_id = 'parent_id' ;   // 父id
    
    protected $_validate = [ 
        // array(field,rule,message,condition,type,when,params) 
        // array(field, url,'错误提示',self::VALUE_VALIDATE, callback, self:MODEL_BOTH , params) 
        ['cate_name','require', '栏目名称不能为空', self::MODEL_BOTH],
        
    ];
    
    
    /**
     * 添加方法
     */
    public function _add() {

        $data = $this->data;

    

        $this->data = $data;
        return parent::_add();
    }
    
    


 
    /**
     * 修改方法
     */
    public function _save() {
        $data = $this->data;

        
        // 选择有效的上级
        $ids = $this->getChildsId($data[$this->pk]);
        $ids[] = $data[$this->pk];
        if (in_array($data[$this->parent_id], $ids)) {
            $this->error = '所选择的上级分类不能是当前分类或者当前分类的子级分类!';
            return false;
        }


        $this->data = $data;
        return parent::_save();
    }

    
    /**
     * 获取列表的所有数据
     * 树结构 主键ID和父级ID是必备的两个字段, 需检查
     */
    protected function getAllData() {
        $fields = isset($this->options['field']) ? $this->options['field'] : '*' ;
        
        // 对字段做检查
        if(is_string($fields) && $fields != '*') {
            $fields = explode(',', trimall($fields));
        }
        if(is_array($fields) && array_search($this->parent_id, $fields) == FALSE) {
	    $fields[] = $this->parent_id;
            $this->options['field'] = $fields ;
	}
        
        return $list = parent::getAll();
    }

    
    /**
     *  查询方法, 返回的是一个二维数组, 用于列出树状结构
     * 
     */
    public function getTreeList($pid = 0 , $html = null) {
	// todo 对sort_order排序字段的处理, 可以放在通用的业务逻辑当中
        $all = $this->order(['sort_order' => 'desc'])->getAllData();
        
        // todo 对格式化输出 $html的考虑
        $treeList = Tree::getTree($all, $pid);
        return $treeList;
    }

    /**
     * 查询方法， 返回的是一个多维数组
     */
    public function getTreeList2($pid = 0 , array $where = []) {
        // order(['sort_order'=>'desc']) 怎么传递过来
	$where = array_merge($where, ['is_show' => 1]);
        $all = $this->where($where)->order(['sort_order' => 'desc'])->select();
        $all = Tree::unLimitForLevel($all, $pid);
        return $all;
    }

    /**
     * 根据主键判断是否属于叶子节点
     * @param type $id
     * @return boolean
     */
    public function isLeaf($id) {
        $count = $this->where([$this->parent_id => $id])->count($this->pk, 'ok');
        return !$count;
    }

    /**
     * 获得某个特定节点的子孙树的id
     * @param $id integer/array
     * @return ids array
     */
    protected function getChildsId($id) {
        $field = [$this->pk, $this->parent_id];
        $all = $this->field($field)->getAll();
        $cIds = Tree::getChildsId2($all, $id);
        return $cIds;
    }

}
