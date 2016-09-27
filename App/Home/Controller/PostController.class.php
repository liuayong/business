<?php

namespace Home\Controller;

class PostController extends BaseController {

    protected function _initialize() {
        parent::_initialize();
    }

    /**
     * 首页博文
     */
    public function index() {
        // 统计信息
        $statistics_html = $this->statistics() ;
        // 博客列表
        $blog_list_html = $this->blogList();
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
	
	/**
        #parent::theme('add')->display();
        #$this->display();
        # **********************************************************#
	* 
        $template = '';
        if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX']) {//判断pjax请求
            layout(false);
            #$template = 'ajax_list';
        }
	layout(true);	// 开启模板布局
	
        $this->display($template);
	*/
	$this->display();
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

    
    /**
     * 获取上一篇内容
     * @param type $id
     */
    protected function prevPost($id) {
        $prevData = $this->onePost($id);
        return $prevData;
    }

    /**
     * 获取下一篇内容
     * @param type $id
     */
    protected function nextPost($id) {
        $nextData = $this->onePost($id);
        return $nextData;
    }

    /**
     * 获得某一篇文章 根据ID
     */
    protected function onePost($id) {
        $filed = ['post_id', 'title'];
        $where = [];
        return M('Post')->where($where)->find($id);
    }

    
    
    /**
     * 显示一篇博文的具体内容
     */
    public function view($id) {
	
        $id = I('id', 0, 'intval');
	$Post = D("MangerSystem/Post");

        // 上一篇
        $prevId = $Post->where('post_id < ' . $id)->max('post_id');
        $prevData = $this->prevPost($prevId);


        // 下一篇
        $nextId = $Post->where('post_id > ' . $id)->min('post_id');
        $nextData = $this->nextPost($nextId);

	// 统计信息
        $statistics_html = $this->statistics() ;
	// 最新日志
        $new_post_html = $this->newPost();
        // 最新评论
        $new_comment_html = $this->newComment() ;
        // 标签云
        $left_tags_html = $this->leftTag() ;
        // 归档日志
        $left_archive_html = $this->leftArchive();
        
	

        // 查询cateData 出栏目id 对应的栏目名称
        $CateModel = D('MangerSystem/Cate');
        $cateData = M('Cate')->getField('id,cate_name', true);

        $field = ['post_id', 'title', 'cate_id', 'create_time', 'tags', 'content', 'view_count', 'reply_count'];
        $post = $Post->field($field)->find($id);

        // 该文章的评论
        $comment_list_html = $this->getCommentList($id);
        
	// 根据文章id修改阅读数
	$Post -> addViews($id);
	
		
        $this->assign('prevData', $prevData);
        $this->assign('nextData', $nextData);
        $this->assign('cateData', $cateData);
        $this->assign('post', $post);
	
        $this->assign('statistics_html', $statistics_html);
	$this->assign('new_post_html', $new_post_html);
        $this->assign('new_comment_html', $new_comment_html);
        $this->assign('left_tags_html', $left_tags_html);
        $this->assign('left_archive_html', $left_archive_html);
        $this->assign('comment_list_html', $comment_list_html);
	

        $this->display();
    }


    /**
     * 后置操作
     * @param type $post_id
     */
    public function _after_view() {
	
//        $Post = D("MangerSystem/Post");
//        $Post -> addViews();
    }

    public function _before_add() {
        $verify = build_verify(8);
        $_SESSION['attach_verify'] = $verify;
        $this->assign('verify', $verify);
    }

    

    public function page($param) {
        
    }

    /**
     * 评论
     */
    public function comment() {
        if (IS_POST) {
            $CommentModel = D('MangerSystem/Comment');
            
            // 判断验证码是否正确
            if(C('is_verify_code')) {
                 if( !$this->check_verify( I('post.verify') )) {
                     $this->error("验证码不正确!");
                 }
            }
            
            if ($comment = $CommentModel->create(I('post.'))) {
                $ret = $CommentModel->_add();
                if ($ret) {
                    // 更新评论数
                    D("MangerSystem/Post")->addComments($comment['post_id']);
		    
		    // 首页最新评论的缓存默认是10条
		    $key = 'newcomment-10';
		    S($key, null);  // 删除缓存
		    
                    // 返回客户端数据
                    $comment["content"] = trim($comment["content"]);
                    $comment["id"] = $list;
                    $data = [
                        'status' => 1,
                        'info' => '评论成功',
                        'data' => $comment,
                    ];
                    $this->ajaxReturn($data);
                } else {
                    $this->error("评论失败!");
                }
            } else {
                $this->error($CommentModel->getError());
            }
        }
    }
    
    /**
     * 某个归档下的博文
     */
    public function archive() {
	
	$year =  $_REQUEST['year'];
	$month =  $_REQUEST['month'];
	
	$begin_time = mktime(0, 0, 0, $month, 1, $year) ;  // 本月1号
	$end_time = mktime(0, 0, 0, $month+1, 1, $year) ;  // 下月1号
	
	// 条件使用 and 连接
	$where['create_time'] = array(array('egt', $begin_time), array('lt', $end_time));
	
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
        
        $this->assign('blog_list_html', $blog_list_html);
        $this->assign('statistics_html', $statistics_html);
        $this->assign('new_post_html', $new_post_html);
        $this->assign('new_comment_html', $new_comment_html);
        $this->assign('left_tags_html', $left_tags_html);
        $this->assign('left_archive_html', $left_archive_html);
        $this->assign('date', $year.'年' .$month .'月');
	
	$this->display();
	
    }
    

}
