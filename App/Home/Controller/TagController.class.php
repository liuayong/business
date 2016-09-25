<?php

namespace Home\Controller;

/**
 * 前台标签控制器
 */
class TagController extends BaseController {

    protected function _initialize() {
	
    }

    /**
     * 获取所有的标签 , 按照data_count排序
     */
    public function index() {

	$tags = $this->getAllTags();

	// 统计信息
	$statistics_html = $this->statistics();
	// 最新日志
	$new_post_html = $this->newPost();
	// 最新评论
	$new_comment_html = $this->newComment();
	// 标签云
	$left_tags_html = $this->leftTag();
	// 归档日志
	$left_archive_html = $this->leftArchive();


	$this->assign('statistics_html', $statistics_html);
	$this->assign('new_post_html', $new_post_html);
	$this->assign('new_comment_html', $new_comment_html);
	$this->assign('left_tags_html', $left_tags_html);
	$this->assign('left_archive_html', $left_archive_html);

	$this->assign('tags', $tags);
	$this->display();
    }
    
    /**
     * 获取标签下的文章
     */
    public function post($name) {
	$tagName = I('get.name', '', 'urldecode');
	$where = array('tag_name' => $tagName);
	$ids = M('PostTag')->where($where)->getField('post_id', true);
	$count = count($ids);       // 博文数量
        
	$whereCondition['post_id'] = ['in', $ids];
		
	// 统计信息
        $statistics_html = $this->statistics() ;
        // 博客列表
        $blog_list_html = $this->blogList($whereCondition);
        // 最新日志
        $new_post_html = $this->newPost();
        // 最新评论
        $new_comment_html = $this->newComment() ;
        // 标签云
        $left_tags_html = $this->leftTag() ;
        // 归档日志
        $left_archive_html = $this->leftArchive();
        
        $this->assign('blog_list_html', $blog_list_html);
        $this->assign('statistics_html', $statistics_html);
        $this->assign('new_post_html', $new_post_html);
        $this->assign('new_comment_html', $new_comment_html);
        $this->assign('left_tags_html', $left_tags_html);
        $this->assign('left_archive_html', $left_archive_html);
        $this->assign('tagName', $tagName);
	
	$this->display();
    }
    /**
     * 获取标签下的文章
     */
    public function post2($name) {
	$tagName = I('get.name', '', 'urldecode');
	$where = array('tag_name' => $tagName);
	$ids = M('PostTag')->where($where)->getField('post_id', true);
	$count = count($ids);       // 博文数量

	$PostView = D('PostView');
	$where = ['is_deleted' => 0, 'status_is' => 'Y'];
	$where['post_id'] = ['in', $ids];

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
	$Page->setConfig("theme", '共 %TOTAL_ROW% %HEADER% %NOW_PAGE%/%TOTAL_PAGE% 页 %UP_PAGE%  %LINK_PAGE%  %DOWN_PAGE%');

	// field 必须在视图模型中中的viewFields, 否则查询所有
	$list = $PostView->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->select();
	$pagelist = $Page->show();

	$this->assign('list', $list);
	$list = $this->fetch('post/' . $template);
    }

}
