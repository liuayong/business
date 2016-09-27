<?php

namespace MangerSystem\Model;

/**
 * {类型}模型
 */
class AttachModel extends CommonModel {

    
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
        // 查询标题
         $real_name = I('real_name', '', 'trim');
         $real_name && $where['real_name'] = ['like', "%$real_name%"];
        
         // 查询别名
         $save_path = I('save_path', '', 'trim');
         $save_path && $where['save_path'] = ['like', "%$save_path%"];
        
        // 分页功能
        $pageSize = C('pagesize');
        $pageSize = $pageSize ? : 10;
        //$pageSize = 1;  // 临时设置
        $totalRecord = $this->where($where)->count();
        $Page = new \Think\Page($totalRecord, $pageSize);
        $limit = $Page->firstRow . ',' . $Page->listRows;
        $show       = $Page->show();// 分页显示输出
        
        $list = $this->field($field)->where($where)->order($order)->limit($limit)->select();
        
        
        return array('data'=> $list, 'page'=>$show);
    }
    
    /**
     * 删除方法 硬删除， delete语句
     * 可以支持删除一条记录或者多条记录, 多条记录传递一个id值组成的一维数组
     */
    public function _delete($ids) {

        $pk = $this->pk;
        if (is_array($ids)) {		    // 批量放入删除
            $where[$pk] = ['in', $ids];
	    foreach ($ids as $id) {
		$file = $this->where([$pk=>$id])->getField('save_path');
		file_exists($file) && unlink(UP_DIR_NAME . '/' . $file); 
	    }
        } else if (is_numeric($ids)) {     // 单个删除
            $where[$pk] = $ids;
	    $file = $this->where([$pk=>$ids])->getField('save_path');
	    $file = UP_DIR_NAME . '/' . $file ;
	    file_exists($file) && unlink($file); 
        }
        return $this->where($where)->delete();
    }

}
