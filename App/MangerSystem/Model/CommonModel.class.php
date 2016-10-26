<?php

namespace MangerSystem\Model;

use Think\Model;

/**
 * 后台的公共模型
 */
class CommonModel extends Model {

    /**
     * 带搜索的查询, 带有分页的搜索
     * @param array $where 查询条件
     * @param array $type  all|page|list
     */
    public function search() {
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
        
        // 搜索查询 多字段查询, 需要对很多的字段进行比较 获取数据表的字段
        // $name = I('name');
        // $name && $where['type_name'] = ['like', "%$name%"];
        
        // 分页功能
        $pageSize = C('pagesize');
        $pageSize = $pageSize ? : 10;
        
        $totalRecord = $this->where($where)->count();
        $Page = new \Think\Page($totalRecord, $pageSize);
        $limit = $Page->firstRow . ',' . $Page->listRows;
        $show       = $Page->show();// 分页显示输出
        
        $list = $this->field($field)->where($where)->order($order)->limit($limit)->select();
        
        return array('data'=> $list, 'page'=>$show);
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
        if (is_array($ids)) { // 多条ID记录, 数组
            $where[$pk] = ['in', $ids];
        } else if (is_numeric($ids)) {     // 单条ID记录
            $where[$pk] = $ids;
        }
        $ret = $this->where($where)->setField($fieldName, $val);
        return $ret;
    }

    /**
     * // 是否是超级管理员
     * 判断当前登录的管理员是否是超级管理员
     */
    public function isSuperAdmin() {
        return true;
        $ids = C('superadmin');
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        $currAdminId = session('uid');
        return in_array($currAdminId, $ids);
    }

    /**
     * 通过主键id来获取单条记录
     */
    public function getById($id) {

        extract($this->handleOptions());

        // todo 逻辑上的考虑 移交给公共的方法
        // 逻辑上的考虑1：考虑软删除的情况
        $deleteField = C('softDelField');   // 软删除字段
        if ($deleteField && !isset($where[$deleteField]) && in_array($deleteField, $this->getDbFields())) {
            $where[$deleteField] = 0;   // 0 代表没删除
        }
        // 逻辑上的考虑2 ：略

        return $this->field($field)->where($where)->order($order)->find($id);
    }

    /**
     * 获取多条记录, 二维数组
     * @param type $params
     * @return type
     */
    public function getAll( array $params = array()) {

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

        return $list;
    }

    /**
     * 返回有主键，和名称 组成的数组， 不要使用limit限制条数
     * 
     */
    public function getDropList($title = 'title') {
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

        $list = $this->where($where)->order($order)->getField($this->pk . ',' . $title, true);

        // $list[0] = '未选择'.$title ;

        return $list;
    }

    /**
     * 业务逻辑上的处理
     * @param array $options
     */
    protected function handleLogic(array $options = array()) {
        
    }

    /**
     * 处理Model中的查询表达式参数 options
     * @param array $options
     * @return data  array()
     */
    protected function handleOptions(array $options = array()) {
        $options = array_merge($this->options, $options);

        $data = array();
        $data['field'] = isset($options['field']) ? $options['field'] : array();
        $data['where'] = isset($options['where']) ? $options['where'] : array();
        $data['order'] = isset($options['order']) ? $options['order'] : array();
        $data['limit'] = isset($options['limit']) ? $options['limit'] : 0; // 0表示不限制条数 没有limit语句
        
        /*
         if(isset($options['limit'])) {
            #$data['limit'] = isset($options['limit']) ? $options['limit'] : C('pagesize'); // 默认条数
            $data['limit'] = $options['limit'] ; 
        }
        */
        
        $this->options = array();
        return $data;
    }

    /**
     * 当个文件上传
     * @param type $fileKey, 对应文件域的 name
     * @param array $config  上传的配置
     * @return type
     */
    public function upload($fileKey = null, array $config = []) {
        C('show_PAGE_TRACE', false);

        $defaulConfig['maxSize'] = 5 * 1000 * 1000;    // 设置上传图片的大小
        $defaulConfig['exts'] = array('jpg', 'gif', 'png', 'jpeg');  // 设置附件上传类型

        $config = array_merge($defaulConfig, $config);      // 合并配置项

        $upload = new \Think\Upload($config);
        $info = $upload->upload();

        if ($fileKey === null) {
            $fileKeys = array_keys($_FILES);
            $fileKey = current($fileKeys);
        }

        if ($info) {
            $imgPath = $info[$fileKey]['savepath'] . $info[$fileKey]['savename'];
            $imgFullPath = __ROOT__ . '/Uploads/' . $imgPath;
            $data = ['code' => 0, 'msg' => '上传成功', 'imgFullPath' => $imgFullPath, 'imgPath' => $imgPath];
        } else {
            $error = $upload->getError();
            $data = ['code' => -1, 'msg' => $error, 'imgPath' => null];
        }

        return $data;
    }

    /**
     * 软删除功能: 即加入回收站
     * 可以支持删除一条记录或者多条记录, 多条记录传递一个id值组成的一维数组
     */
    public function toTrash($ids) {
        $deleteField = C('softDelField') ? : 'is_deleted';

        // 判断是否有软删除的字段, 有的话进行软删除, 没有的话直接进行硬删除
        if (in_array($deleteField, $this->getDbFields())) {
            return $this->setSingleField($ids, $deleteField, 1);
        } else {
            $this->error = '软删除字段' . $deleteField . '不存在， 请检查';
            return false;
            exit('没有软删除的字段 无法进行软删除');       // 可以选择直接进行硬删除
        }
    }

    /**
     * 修改方法
     */
    public function _save() {
        $data = $this->data;

        return parent::save($data);
    }

    /**
     * 更新数据前的回调方法
     */
    protected function _before_update(&$data, $options) {
        // $this->data 

        $dbFields = $this->getDbFields();
        $softDeleteTimeField = 'soft_delete_time';
        $deleteTimeField = 'delete_time';
        $updTimeField = 'update_time';

        if (in_array(strtolower(ACTION_NAME), ['upd'])) {   // strcasecmp ( ACTION_NAME ,  'upd' ) ==  0
            in_array($updTimeField, $dbFields) && $data[$updTimeField] = time();
        }
        if (in_array(strtolower(ACTION_NAME), ['totrash'])) {
            in_array($deleteTimeField, $dbFields) && $data[$deleteTimeField] = time();
            in_array($softDeleteTimeField, $dbFields) && $data[$softDeleteTimeField] = time();
        }
    }
    

    // 插入数据前的回调方法
    protected function _before_insert(&$data, $options) {

        $dbFields = $this->getDbFields();
        $addTimeField = 'create_time';
        in_array($addTimeField, $dbFields) && $data[$addTimeField] = time();
    }

    /**
     * 添加方法
     */
    public function _add() {

        $data = $this->data;

        return parent::add($data);
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
     * 删除方法 硬删除， delete语句
     * 可以支持删除一条记录或者多条记录, 多条记录传递一个id值组成的一维数组
     */
    public function _delete($ids) {

        $pk = $this->pk;
        if (is_array($ids)) { // 批量放入删除
            $where[$pk] = ['in', $ids];
        } else if (is_numeric($ids)) {     // 单个删除
            $where[$pk] = $ids;
        }
        return $this->where($where)->delete();
    }

}
