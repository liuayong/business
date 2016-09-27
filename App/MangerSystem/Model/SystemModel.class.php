<?php

namespace MangerSystem\Model;

use Common\Components\Pinyin;
use Common\Components\Tree;

/**
 * {类型}模型
 */
class SystemModel extends CommonModel {

    protected $parent_id = 'parent_id';   // 父id
    protected $_validate = [
	// array(field,rule,message,condition,type,when,params) 
	// array(field, url,'错误提示',self::VALUE_VALIDATE, callback, self:MODEL_BOTH , params) 
	/*
	  ['name_zh', 'require', '菜单名称不能为空', self::EXISTS_VALIDATE],
	  [$this->parent_id, 'number', '父级菜单ID数据有误', self::EXISTS_VALIDATE],
	  ['is_deleted', 'number', '是否软删除数据有误', self::EXISTS_VALIDATE],
	  ['auth', 'number', '权限设置有误', self::EXISTS_VALIDATE],
	 * 
	 */
	['name', 'require', '菜单名称不能为空', self::MODEL_BOTH],
	#array('name','','帐号名称已经存在！',0,'unique',1), 
	['name', '', '权限名称已经存在', self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH],
	['name', '1,30', '权限名称不能超过30个字符', self::EXISTS_VALIDATE, 'length'],
	['module_name', 'isReasonableName', '', 2, 'callback', 3, [['fieldName' => 'module_name', 'fieldLabel' => '模块名']]],
	['controller_name', 'isReasonableName', '', 2, 'callback', 3, [['fieldName' => 'controller_name', 'fieldLabel' => '控制器名']]],
	['action_name', 'isReasonableName', '', 2, 'callback', 3, [['fieldName' => 'action_name', 'fieldLabel' => '方法名']]],
    ];

    /**
     * 合法的标识符
     */
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
     * 添加方法
     */
    public function _add() {

	$data = $this->data;

	$this->data = $data;
	return parent::_add();
    }

    // 获取某个菜单
    public function getSons($id, $field = null) {

	if ($field === null) {
	    $sons = $this->where([$this->parent_id => $id])->order(['sort_order' => 'desc'])->getField($this->pk, true);
	} else if (is_array($field)) {
	    $sons = $this->where([$this->parent_id => $id])->order(['sort_order' => 'desc'])->getField(implode(',', $field));
	}
	return $sons;
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

    // 插入成功后的回调方法
    protected function _after_insert($data, $options) {
	
    }

    // 计算菜单的URL
    protected function calcMenuUrl(&$data) { // 传值 或者 像upImg 传递状态
	// 计算菜单跳转的urL
	if (trim($data['redirect_url']) == '') {
	    if ($data[$this->parent_id] == 0) { // 对于顶级菜单的处理, 顶级菜单没有模板, 访问第一个子级菜单
		$sons = $this->getSons($data[$this->getPk()]);
		if ($sons) {
		    $data['cate_url'] = U('Home/Menu/index', ['id' => $sons[0]]);
		} else {
		    $data['cate_url'] = '';    // U('Home/Menu/index', ['id' => $data['cate_id']])
		}
	    } else {

		$data['cate_url'] = '';
	    }
	} else if (strpos($data['redirect_url'], 'http://') === 0 || strpos($data['redirect_url'], 'https://') === 0) {
	    $data['cate_url'] = $data['redirect_url'];
	} else {
	    // 加载静态页
	}
	return true;
    }

    /**
     * 设置菜单的英文名称
     */
    protected function setMenuEName() {
	$data = $this->data;
	$data['name_en'] = getLetters($data['name_zh']);
	$this->data = $data;
    }

    /**
     * 获取列表的所有数据
     * 树结构 主键ID和父级ID是必备的两个字段, 需检查
     */
    protected function getAllData() {
	$fields = isset($this->options['field']) ? $this->options['field'] : '*';

	// 对字段做检查
	if (is_string($fields) && $fields != '*') {
	    $fields = explode(',', trimall($fields));
	}
	if (is_array($fields) && array_search($this->parent_id, $fields) == FALSE) {
	    $fields[] = $this->parent_id;
	    $this->options['field'] = $fields;
	}

	return $list = parent::getAll();
    }

    /**
     *  查询方法, 返回的是一个二维数组, 用于列出树状结构
     * 
     */
    public function getTreeList($pid = 0, $html = null) {
	// todo 对sort_order排序字段的处理, 可以放在通用的业务逻辑当中
	$all = $this->order(['sort_order' => 'desc'])->getAllData();

	// todo 对格式化输出 $html的考虑
	$treeList = Tree::getTree($all, $pid);
	return $treeList;
    }

    /**
     * 查询方法， 返回的是一个多维数组
     */
    public function getTreeList2($pid = 0, array $where = []) {
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
