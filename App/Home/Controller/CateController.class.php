<?php

namespace Home\Controller;



/**
 * 前台栏目控制器
 */
class CateController extends BaseController {

    protected function _initialize() {
	parent::_initialize();
	#layout(FALSE);
    }
     /**
     * 获取当前栏目下的文章
     */
    public function index($id) {
        $cate_id = I('id', 0, 'intval');
	$where = array('cate_id'=> $id) ;
	
        $CateModel = D('MangerSystem/Cate');
        $cateInfo = $CateModel->getCateBasicInfoById($cate_id);
        
        
        // 是否查找该栏目子栏目下的文章
        // 获得本栏目及其子栏目
        if(C('is_get_childcate_contents')) {
            $cate_ids = $CateModel->getChildsId($cate_id);
            $cate_ids[] = $cate_id ; 
            $where = array('cate_id'=> ['in', $cate_ids]);
        }
        
        $blog_list_html = $this->blogList($where);
        
        $this->assign('cateInfo', $cateInfo);
        $this->assign('blog_list_html', $blog_list_html);
        $template = 'cate_ajax_list' ;
        $layout = false ;
        
        
        // 在不是AJAX请求的情况下 展示整个页面, 可能有布局 layout = true 
        if(!IS_AJAX) {
            $layout = true ;
            
            $template = 'index' ;
            // 统计信息
            $statistics_html = $this->statistics() ;
            // 博客列表
            // 最新日志
            $new_post_html = $this->newPost();
            // 最新评论
            $new_comment_html = $this->newComment() ;
            // 标签云
            $left_tags_html = $this->leftTag() ;
            // 归档日志
            $left_archive_html = $this->leftArchive();

            $this->assign('statistics_html', $statistics_html);
            $this->assign('new_post_html', $new_post_html);
            $this->assign('new_comment_html', $new_comment_html);
            $this->assign('left_tags_html', $left_tags_html);
            $this->assign('left_archive_html', $left_archive_html);
        }
	$this->display($template, false);
    }
    

    /**
     * ztree树状结构
     * @param type $pid
     */
    public function ztree($pid = 0) {
	$pid = I('pid', 0, 'intval');
	#C('show_page_trace', fasle);
	
	// 使用缓存
	$key = 'catelist-'.$pid ;
	// 开发阶段不使用缓存
	if (APP_DEBUG || !$data = S($key)) {
	   
	    $CateModel = D('MangerSystem/Cate');

	    $parentKey = $CateModel->parent_id;
	    $field = [$CateModel->getPk() => 'id', $parentKey => 'pid', 'cate_name' => 'name', 'cate_name_alias' => 'alias'];
	    $data = $CateModel->field($field)->where([$parentKey => $pid])->getAll();
	    $data = self::addColumn($data);
	    APP_DEBUG || S($key, $data);
	}
       echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    // 给二维数组添加数据
    protected function addColumn(array $handelData) {
        $cateModel = D('MangerSystem/Cate');
        foreach ($handelData as $k => $v) {
            $handelData[$k]['isParent'] = !$cateModel->isLeaf($v[$cateModel->getPk()]);
        }
        return $handelData;
    }
    
}
