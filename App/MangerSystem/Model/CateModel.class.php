<?php

namespace MangerSystem\Model;

use Common\Components\Pinyin;
use Common\Components\Tree;

/**
 * {类型}模型
 */
class CateModel extends CommonModel {

    public $parent_id = 'parent_id';   // 父id
    protected $_validate = [
        // array(field,rule,message,condition,type,when,params) 
        // array(field, url,'错误提示',self::VALUE_VALIDATE, callback, self:MODEL_BOTH , params) 
        /*
          ['name_zh', 'require', '栏目名称不能为空', self::EXISTS_VALIDATE],
          [$this->parent_id, 'number', '父级栏目ID数据有误', self::EXISTS_VALIDATE],
          ['is_deleted', 'number', '是否软删除数据有误', self::EXISTS_VALIDATE],
          ['auth', 'number', '权限设置有误', self::EXISTS_VALIDATE],
         * 
         */
        ['cate_name', 'require', '栏目名称不能为空', self::MODEL_BOTH],
            #array('name','','帐号名称已经存在！',0,'unique',1), 
            #create收集表单数据的时候就验证
            #['cate_name_alias', '', '栏目的唯一标识名必须是唯一的', self::MUST_VALIDATE, 'unique', self::MODEL_INSERT],
    ];

    /**
     * 获取多条记录, 二维数组
     * @param type $cnt,  限制的记录数 0:代表所有的记录数
     * @param type $params
     * @return type
     */
    public function getAll(array $params = array()) {

        extract($this->handleOptions());
      
        // todo 逻辑上的考虑 移交给公共的方法
        // 逻辑上的考虑1：考虑软删除的情况
        $deleteField = C('softDelField') ? : 'is_deleted';   // 软删除字段
        if ($deleteField && !isset($where[$deleteField]) && in_array($deleteField, $this->getDbFields())) {
            $where[$deleteField] = 0;   // 0 代表没删除
        }

        // 逻辑上的考虑2 ：略
        // todo 对sort_order排序字段的处理, 可以放在通用的业务逻辑当中
        // $all = $this->order(['sort_order' => 'desc'])->getAllData();
        $sortOrderField = C('sortOrderField') ? : 'sort_order';
        if (in_array($sortOrderField, $this->getDbFields())) {
            $order[$sortOrderField] = 'DESC';      // 默认降序排列
        }



        $list = $this->field($field)->where($where)->order($order)->limit($limit)->select();

        #// 增加一个字符是否是 叶子节点
        #foreach($list as $row) {   }


        return $list;
    }

    /**
     * 获得所有的叶子节点， 写一个sql语句， ？？
     */
    public function getAllLeafs() {
        var_dump($this->isLeaf(3));
        var_dump($this->_sql());
    }

    /**
     * 添加方法
     */
    public function _add() {
        $data = $this->data;

        $data['cate_name_second'] = strtolower($data['cate_name_second']);
        $data['cate_name_alias'] = getLetters($data['cate_name']);

        $this->data = $data;
        return parent::_add();
    }

    // 获取某个栏目
    public function getSons($id, $field = null) {

        if ($field === null) {
            $sons = $this->where([$this->parent_id => $id])->order(['sort_order' => 'desc'])->getField($this->pk, true);
        } else if (is_array($field)) {
            $sons = $this->where([$this->parent_id => $id])->order(['sort_order' => 'desc'])->getField(implode(',', $field));
        }
        return (array) $sons;
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
        $data['cate_name_second'] = strtolower($data['cate_name_second']);
        $data['cate_name_alias'] = getLetters($data['cate_name']);

        /*
          my_copy('./UploadsTemp/' . $data['cate_pic'], './Uploads/', true);


          // 删除原来的图片(原始图和缩略图)
          $pk = $this->pk ;
          $row = $this->field(['cate_pic'])->find($data[$pk]);
          if($row['cate_pic'] != $data['cate_pic']) {
          $srcImg	  = './Uploads/' . $row['cate_pic'] ;
          @unlink($srcImg);
          }
         */

        $this->data = $data;
        return parent::_save();
    }

    // 插入成功后的回调方法
    protected function _after_insert($data, $options) {
        
    }

    /**
     * 根据id获得栏目的基本信息
     * @param type $id
     * @param type $field 字段
     */
    public function getCateBasicInfoById($id, array $field = array()) {
        if (empty($field)) {
            $field = ['id', 'cate_name', 'cate_name_alias'];
        }
        $data = $this->field($field)->getById($id);
        return $data; 
    }

    /**
     * 获取顶级栏目列表
     * @return type
     */
    public function getTopData() {
        $topData = $this->where([$this->parent_id => 0])->getAllData();
        return $topData;
    }

    /**
     * 获取列表的所有数据
     * 树结构 主键ID和父级ID是必备的两个字段, 需检查
     */
    public function getAllData() {
        $fields = isset($this->options['field']) ? $this->options['field'] : '*';

        // 对字段做检查
        if (is_string($fields) && $fields != '*') {
            $fields = explode(',', trimall($fields));
        }
        if (is_array($fields) && array_search($this->parent_id, $fields) == FALSE) {
            $fields[] = $this->parent_id;
            $this->options['field'] = $fields;
        }

        return $list = self::getAll();
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
        $count = $this->where([$this->parent_id => $id])->count($this->pk);
        return !$count;
    }

    /**
     * 获得某个特定节点的子孙树的id
     * @param $id integer/array
     * @return ids array
     */
    public function getChildsId($id) {
        $field = [$this->pk, $this->parent_id];
        $all = $this->field($field)->getAll();
        $cIds = Tree::getChildsId2($all, $id);
        return $cIds;
    }

    
    /**
     * $ids 可以是一个数组
     * @param array $ids  获得所有的子ids(包括一条或者多条记录)
     * @return array
     */
    public function getChildsIdBAK($ids) {
        $childIds = [];
        if (is_numeric($ids)) {
            $childIds = $this->_getChildsId($ids);
        } else if (is_array($ids)) {
            foreach ($ids as $k => $id) {
                $childIds = array_merge($childIds, $this->getChildsId($id));
            }
            $childIds = array_unique($childIds);
        }
        return $childIds;
    }
    

    /**
     * 根据栏目名称 获取某个栏目下的 几篇文章
     */
    public function getCateNews($name, $cnt = 1, &$url) {
        $where = ['cate_name' => $name, 'cate_id' => $name, '_logic' => 'OR'];
        $cate_id = $this->where($where)->getField('cate_id');

        $where = ['cate_id' => $cate_id];

        $field = ['news_id', 'title', 'title_id', 'show_img', 'tag'];
        $data = D('News')->field($field)->where($where)->order(['sort_order' => 'desc'])->limit($cnt)->select();

        $url = U('/Home/Cate/index', ['id' => $cate_id]);
        return $data;
    }

    /**
     * prompt
     * 树状的下拉菜单
     */
    public function showTreeSelect($val = '', array $options = array()) {
        $field = ['id', 'cate_name', 'parent_id'];
        $tree = $this->field($field)->getTreeList();

        // ['prompt' => ' 请选择 ']
        $promptHtml = '';
        // 有提示项
        if (isset($options['prompt']) && $options['prompt']) {
            $promptHtml = '<option value="">' . $options['prompt'] . '</option>';
            unset($options['prompt']);
        }

        $htmlAttr = buildHtmlAttr($options);

        $selectHtml = '<select' . $htmlAttr . '>' . $promptHtml;

        foreach ($tree as $k => $v) {
            $selected = ($v['id'] == $val) ? 'selected ="selected"' : '';
            $selectHtml .= "<option {$selected} value=\"{$v['id']}\">{$v['preHtml']}{$v['cate_name']}</option>";
        }

        $selectHtml .= '</select>';

        return $selectHtml;
    }

    /**
     * 返回所有的可用栏目, 一维数组
     */
    public function getCateData() {
        $pk = $this->getPk();
        // todo 需要添加上条件...
        $cateData = $this->getField($pk . ',cate_name', true);
        #$cateData = D('Cate')->field('id,cate_name')->getAll();
        return $cateData;
    }

}
