<?php
namespace MangerSystem\Model;
 

/**
 * {类型}模型
 */
class NewsModel extends CommonModel  {
    
    
     protected $_validate = [
        // array(field,rule,message,condition,type,when,params) 
     ];

     /**
     * 带搜索的查询
     * @param array $where 查询条件
     * @param array $type  all|page|list
     */
    public function search($type='all') {
	
        $field = '*';
        if (isset($this->options['field'])) {
            $field = $this->options['field'];
            unset($this->options['field']);
        }
	
	$where = [];
        if (isset($this->options['where'])) {
            $where = $this->options['where'];
            unset($this->options['where']);
        }
	
	$order = [];
	if (isset($this->options['order'])) {
            $order = $this->options['order'];
            unset($this->options['order']);
        }
	
	$limit = '' ;
	if (isset($this->options['limit'])) {
            $limit = $this->options['limit'];
            unset($this->options['limit']);
        }
	
	
        $deleteField = C('softDelField');   // 软删除字段
        if ($deleteField && !isset($where[$deleteField]) && in_array($deleteField, $this->getDbFields())) {
            $where[$deleteField] = 0;
        }

	// 搜索查询
        // $name = I('name');
        // $name && $where['type_name'] = ['like', "%$name%"];
	
	
	
	if($type == 'all' || $type == 'page') {
	    $pageSize = C('pagesize');
	    $pageSize = $pageSize ? : 10;
	    $totalRecord = $this->where($where)->count();
	    $Page = new \Think\Page($totalRecord, $pageSize);
	    $limit = $Page->firstRow . ',' . $Page->listRows ;
	}
	
        $list = $this->field($field)->where($where)->order($order)->limit($limit)->select();
	
	if($type == 'all') {
	    $data = ['list'=> $list, 'page'=> $Page] ;
	} else if($type == 'page') {
	    $data = $Page ;
	} else if($type == 'list') {
	    $data = $list;
	}

        return $data ;
    }
    

    /**
     * 添加方法
     */
    public function _add() {

        $dbFields = $this->getDbFields();
        $addTimeField = 'create_time';
        $addTimename = 'create_admin_name';

        if (in_array($addTimeField, $dbFields)) {
            $this->data[$addTimeField] = time();
        }
        if (in_array($addTimename, $dbFields)) {
            $this->data[$addTimename] = session('uname');
        }
		
        return parent::add();
    }

    /**
     * 修改方法
     */
    public function _save() {
        $data = $this->data;

        $this->data = $data;
        $dbFields = $this->getDbFields();
        $updTimeField = 'update_time';
        $updTimename = 'update_admin_name';

        if (in_array($updTimeField, $dbFields)) {
            $this->data[$updTimeField] = time();
        }
        if (in_array($updTimename, $dbFields)) {
            $this->data[$updTimename] = session('uname');
        }
	
		
        return parent::save();
    }

    /**
     * 删除方法 硬删除， delete语句
     * 可以支持删除一条记录或者多条记录, 多条记录传递一个id值组成的一维数组
     */
    public function _delete($ids) {
        $pk = $this->pk;
        if (is_array($ids)) {               // 批量放入删除
            $where[$pk] = ['in', $ids];
        } else if (is_numeric($ids)) {     // 单个删除
            $where[$pk] = $ids;
        }
        return $this->where($where)->delete();
    }

    /**
     * 软删除功能: 即加入回收站
     * 可以支持删除一条记录或者多条记录, 多条记录传递一个id值组成的一维数组
     */
    public function toTrash($ids) {
        $deleteField = C('softDelField');

        // 判断是否有软删除的字段, 有的话进行软删除, 没有的话直接进行硬删除
        if (in_array($deleteField, $this->getDbFields())) {
            return $this->setSingleField($ids, $deleteField, 1);
        } else {
            exit('没有软删除的字段 无法进行软删除');       // 可以选择直接进行硬删除
        }
    }

    // 还原回收站, 一次可以操作一条/多条记录
    public function toRestore($ids) {
        $deleteField = C('softDelField');

        // 判断是否有软删除的字段, 有的话进行软删除, 没有的话直接进行硬删除
        if (in_array($deleteField, $this->getDbFields())) {
            return $this->setSingleField($ids, $deleteField, 0);
        } else {
            exit('没有软删除的字段 无法进行还原');       // 可以选择直接进行硬删除
        }
    }

    /**
     * 设置单个字段的值, 可以操作一条/多条数据 【根据ID修改操作】
     * @param type $ids         id值
     * @param type $fieldName   字段名
     * @param type $val         字段值
     * @return type
     */
    public function setSingleField($ids, $fieldName, $val) {

        $pk = $this->pk;
        if (is_array($ids)) {               // 多条ID记录, 数组
            $where[$pk] = ['in', $ids];
        } else if (is_numeric($ids)) {     // 单条ID记录
            $where[$pk] = $ids;
        }
        $ret =  $this->where($where)->setField($fieldName, $val);
        return $ret ;
    }

}