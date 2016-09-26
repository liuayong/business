<?php

namespace Home\Controller;

use Think\Controller;

class BaseController extends Controller {

    protected function _initialize() {
        #tag('action_init'); // 添加action_init 标签
	
	// \Think\Hook::listen('标签名');
	// 或者
	// tag('标签名'[,参数]);
    }

    /**
     * 测试函数
     */
    public function test() {
        
    }

    /**
     * 判断是否登录
     * @return type
     */
    public function isLogin() {
        $sessionUid = getSessionUidKey();
        $sessionUname = getSessionUnameKey();

        return session('?' . $sessionUid) && session('?' . $sessionUname);
    }

    /**
     * // 左边布局
     */
    public function leftbar() {
        // 左侧栏目
        $CateModel = D('MangerSystem/Cate');
        $topData = $CateModel->getTopData();    // 顶级栏目
        $this->assign('topCateData', $topData);
    }

    /*
     * 日志分类
     */

    public function leftCate() {
        // 左侧栏目
        $CateModel = D('MangerSystem/Cate');
        $topData = $CateModel->getTopData();    // 顶级栏目

        return $topData;
    }

    /**
     * 统计数据
     */
    public function statistics() {
        $Post = M('Post');

        // 统计数据
        $where = ['status_is' => 'Y', 'is_deleted' => 0];
        $whereCondition = parseWhere($where);

        $sql = 'select sum(reply_count) as reply_count , sum(view_count) view_count, count(post_id) post_count , min(create_time) begin_time from '
                . $Post->getTableName() . $whereCondition;

        $data = $Post->query($sql);
        $statistics_data = isset($data[0]) ? $data[0] : [];
        $this->assign('_statistics_data', $statistics_data);   // 分配数据
        $statistics_html = $this->fetch('common/statistics');
        return $statistics_html;
    }

    /**
     * 最新的N条日志
     * @param type $limit
     */
    public function newPost($limit = 10) {
        $field = ['post_id', 'title', 'view_count', 'reply_count'];
        $order = ['create_time' => 'DESC'];
        $new_post_data = D("MangerSystem/Post")->field($field)->order($order)->limit($limit)->getAll();
        $this->assign('_new_post_data', $new_post_data);
        $new_post_html = $this->fetch('common/newPost');
        return $new_post_html;
    }

    /**
     * 最新的N条评论
     * @param type $limit
     */
    public function newComment($limit = 10) {
        $field = ['comment_id', 'post_id', 'nickname', 'content', 'email'];
        $order = ['create_time' => 'DESC'];
        $new_comment = D("MangerSystem/Comment")->field($field)->order($order)->limit($limit)->getAll();
        $this->assign('_new_comment', $new_comment);
        $new_comment_html = $this->fetch('common/newComment');
        return $new_comment_html;
    }

    /**
     * 获取谋篇文章下的评论列表
     * @param type $aid
     */
    public function getCommentList($aid = 0) {

        $commentModel = D("MangerSystem/Comment");
        $field = ['comment_id', 'post_id', 'nickname', 'content', 'email', 'create_time'];
        $order = ['create_time' => 'DESC'];
        $where = ['post_id' => $aid];

        $count = $commentModel->where($where)->count('comment_id');

        $pageSize = 8;      // 每页8条评论
        // 评论分页
        $Page = new \Think\Page($count, $pageSize);

        $Page->setConfig("header", "条评论");
        $Page->setConfig("prev", C("page.prev"));
        $Page->setConfig("next", C("page.next"));
        $Page->setConfig("theme", C("page.theme"));

        $limit = $Page->firstRow . ',' . $Page->listRows;
        $comments_list = $commentModel->field($field)->where($where)->order($order)->limit($limit)->getAll();
        $pagelist = $Page->show();

        $this->assign('_comments_list', $comments_list);
        $this->assign('pagelist', $pagelist);
        $comment_list = $this->fetch('common/comment_list');
        return $comment_list;
    }

    /**
     * 日志归档
     */
    public function leftArchive() {
        $Post = M('Post');
        $step = '-1 month';     // 跨度
        $terminate = '-1 year'; // 结尾往后跨一年

        $where = ['is_deleted' => 0, 'status_is' => 'Y'];
        $pubtime = $Post->where($where)->max('create_time');

        $terminate_time = strtotime($terminate);        // 结束时间
        $months = array();
        while ($pubtime >= $terminate_time) {
            $info = getdate($pubtime);
            $months[] = array(
                'year' => $info['year'],
                'month' => $info['mon'],
                'timestamp' => $pubtime,
            );
            $pubtime = strtotime($step, $pubtime);
        }

        $this->assign('_archive_months', $months);
        $left_archive_html = $this->fetch('common/leftArchive');
        return $left_archive_html;
    }

    /**
     * 标签云
     */
    public function leftTag() {
        $tags = $this->getAllTags();
        $this->assign('_left_tags', $tags);
        $left_tags_html = $this->fetch('common/leftTag');
        return $left_tags_html;
    }

    /**
     * 获得所有的标签, 按照data_count排序
     */
    protected function getAllTags() {
        $tags = M('Tags')->field('id, tag_name, data_count')->order(['data_count' => 'DESC'])->select();
        return $tags;
    }

    /**
     * 获得博客列表
     */
    public function blogList(array $whereCondtion = array()) {
        $PostView = D('PostView');
        $Post = M('Post');

        // 发布博文的时候，一定需要选择分类
        $where = ['is_deleted' => 0, 'status_is' => 'Y'];
        $where = array_merge($where, $whereCondtion);


        $count = $Post->where($where)->count();

        // 列表的几种显示方式： 纯标题列表(normal)  图文列表(pic)  简介列表(intro)
        $mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : 'normal';
        $pageConfig = array('intro' => 12, 'pic' => 10, 'normal' => 20);
        $pageSize = isset($pageConfig[$mode]) ? $pageConfig[$mode] : 5;  // C('page_size');
        // 博文分页
        $Page = new \Think\Page($count, $pageSize);
        $Page->setConfig("header", C("page.header"));
        $Page->setConfig("prev", C("page.prev"));
        $Page->setConfig("next", C("page.next"));
        $Page->setConfig("theme", C("page.theme"));
	
	$order = ['sort_order'=> 'DESC', 'post_id'=> 'ASC'];

        // field 必须在视图模型中中的viewFields, 否则查询所有
        $blog_list = $PostView->where($where)->order($order)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $pagelist = $Page->show();

        $this->assign('_cnt', $count);
        $this->assign('mode', $mode);               // 列表模式
        $this->assign('_blog_list', $blog_list);     // 博文数据 
        $this->assign('pagelist', $pagelist);       // 分页字符串
        $blog_list = $this->fetch('common/blogList');
        return $blog_list;
    }

    /**
     * // 检测输入的验证码是否正确，$code为用户输入的验证码字符串
     */
    protected function check_verify($code, $id = '') {
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

    /**
     * 生成验证码
     */
    public function verify() {
        $Verify = new \Think\Verify();
        $Verify->fontSize = 14;
        $Verify->length = 4;
        #$Verify->imageW   = 50;
        #$Verify->imageH   = 22;
        # $Verify->useZh = true;  // 没有中文字体
        $Verify->useNoise = false;
        $Verify->reset = false;
        $Verify->entry();
    }

}
