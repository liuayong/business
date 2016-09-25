<?php

namespace Home\Controller;



/**
 * 前台栏目控制器
 */
class CateController extends BaseController {

    protected function _initialize() {
	
    }
     /**
     * 获取当前栏目下的文章
     */
    public function index($id) {
        $cate_id = I('get.id', 0, 'intval');
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
        
	// 统计信息
        $statistics_html = $this->statistics() ;
        // 博客列表
        $blog_list_html = $this->blogList($where);
        // 最新日志
        $new_post_html = $this->newPost();
        // 最新评论
        $new_comment_html = $this->newComment() ;
        // 标签云
        $left_tags_html = $this->leftTag() ;
        // 归档日志
        $left_archive_html = $this->leftArchive();
        
        
        $this->assign('cateInfo', $cateInfo);
        $this->assign('blog_list_html', $blog_list_html);
        $this->assign('statistics_html', $statistics_html);
        $this->assign('new_post_html', $new_post_html);
        $this->assign('new_comment_html', $new_comment_html);
        $this->assign('left_tags_html', $left_tags_html);
        $this->assign('left_archive_html', $left_archive_html);
	
	$this->display();
    }
    
    /**
     * 获取当前栏目下的文章
     */
    public function index2($id) {
        // 分类id
        $cate_id = I('get.id', 0, 'intval');
        
        $PostView = D('PostView');
        $Post = M('Post');
        
        // 获得本栏目及其子栏目
        $CateModel = D('MangerSystem/Cate');
        $cate_ids = $CateModel->getChildsId($cate_id);
        $cate_ids[] = $cate_id ; 
        

        // 发布博文的时候，一定需要选择分类
        $where = ['is_deleted' => 0, 'status_is' => 'Y', 'cate_id'=> array('in', $cate_ids)];
        $count = $Post->where($where)->count();

        // 列表的几种显示方式： 纯标题列表(normal)  图文列表(pic)  简介列表(intro)
        $mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : 'normal';
        if ($mode == 'intro') {
            $template = 'intro';
            $pageSize = 2;
        } else if ($mode == 'pic') {
            $template = 'pic';
        } else {    // 纯标题列表
            $pageSize = 2;
            $template = 'normal';
        }

        // 博文分页
        $Page = new \Think\Page($count, $pageSize);
        $Page->setConfig("header", "篇日志");
        $Page->setConfig("prev", "上一页");
        $Page->setConfig("next", "下一页");
        $Page->setConfig("theme", '共 %TOTAL_ROW% %HEADER% %NOW_PAGE%/%TOTAL_PAGE% 页 %UP_PAGE%  %LINK_PAGE%  %DOWN_PAGE% %END%');

        // field 必须在视图模型中中的viewFields, 否则查询所有
        $list = $PostView->limit($Page->firstRow . ',' . $Page->listRows)->where($where)->select();
        $pagelist = $Page->show();

        $this->assign('list', $list);
        $list = $this->fetch($template);



        // 左侧栏目
        /* $Cate = M("Category");
          $cateList = $Cate->select();
          $this->assign("category", $cateList);
         */
        $CateModel = D('MangerSystem/Cate');
        $topData = $CateModel->getTopData();

        // 统计数据
        $where = 'status_is = "Y"';
        $sql = 'select sum(reply_count) as reply_count , sum(view_count) view_count, count(post_id) post_count , min(create_time) begin_time from '
                . $Post->getTableName() . ' where ' . $where;

        $data = $Post->query($sql);

        # $stat = array();
        # $stat["beginTime"] = $Blog->min('cTime');
        # $stat["blogCount"] = $Blog->where("status=1")->count();
        # $stat["readCount"] = $Blog->where("status=1")->sum("readCount");
        # $stat["commentCount"] = $Blog->where("status=1")->sum("commentCount");
        # $this->assign($stat);
        // 分配数据
        $this->assign('data', $data[0]);
        $this->assign('topCateData', $topData);
        $this->assign('mode', $mode);
        $this->assign('list', $list);
        $this->assign('page', $pagelist);


        $this->display();
    }
}
