<?php

namespace Collect\Controller;

use Common\Components\QueryList;
use Think\Controller;

class IndexController extends Controller {

    /**
     * 采集项目(网站)列表
     */
    public function index() {

	$CollectModel = D('Collect');
	$filed = ['id', 'web_name', 'web_site', 'is_down', 'charset', 'create_time', 'update_time'];
	$volist = $CollectModel->field($filed)->select();

	$this->assign('volist', $volist);
	$this->display();
    }

    /**
     * 添加一个采集项目
     */
    public function add() {
	if (IS_POST) {
	    $CollectModel = D('Collect');
	    $postData = $CollectModel->create(I('post.'));
	    if ($ret = $CollectModel->add()) {
		$this->success('添加采集项目成功', U('index'), 3);
	    } else {
		$this->error('添加采集项目失败: ' . $CollectModel->getError(), '', 3);
	    }
	} else {
	    $this->display();
	}
    }

    /**
     * 编辑采集项目
     */
    public function edit($id) {
	$id = I('get.id', 0, 'intval');
	$CollectModel = D('MangerSystem/Collect');
	if (IS_POST) {
	    $postData = $CollectModel->create(I('post.'));
	    if ($ret = $CollectModel->save()) {
		$this->success('修改采集项目成功', U('index'), 3);
	    } else {
		$this->error('修改采集项目失败: ' . $CollectModel->getError(), '', 3);
	    }
	} else {
	    $data = $CollectModel->find($id);
	    $this->assign('data', $data);
	    $this->display();
	}
    }

    /**
     * 生成QueryList需要的参数
     * @return array
     */
    protected function genarateQueryListArgs() {
	$CollectModel = D('MangerSystem/Collect');

	// 获取采集信息
	$collect = $CollectModel->find($id);

	if ($collect['charset'] == '') {
	    header("Content-type: text/html; charset=utf-8");
	} else {
	    header("Content-type: text/html; charset=" . $collect['charset']);
	}

	$url = $collect['target'];     // 采集页面的地址

	$rules = array(
	    "title" => array($collect['title'], "text"),
	    "url" => array($collect['url'], "href"),
	    "author" => array($collect['author'], "value"),
	    "cate" => array($collect['cate'], "text"),
	    "view_cnts" => array($collect['view_cnts'], "text"),
	    "favorite_cnts" => array($collect['favorite_cnts'], "text"),
	    "attention_cnts" => array($collect['attention_cnts'], "text"),
	    "reply_cnts" => array($collect['reply_cnts'], "text"),
	    "intro" => array($collect['intro'], "text"),
	    "content" => array($collect['content'], "text"),
	    "tags" => array($collect['tags'], "text"),
	);

	return array(
	    'site' => $collect['web_site'],
	    'url' => $collect['target'], // 采集页面的地址,
	    'scope' => $collect['scope'],
	    'pagetype' => $collect['page_type'],
	    'start_page' => $collect['start_page'],
	    'end_page' => $collect['end_page'],
	    'rules' => $rules,
	);
    }

    /**
     * 测试采集效果, 对于ajax的渲染的内容，无法从页面上获取
     */
    public function runtest() {

	$detailUrl = $site . $v['url'];     // 是否以http开头, https 开头
	$detailUrl = 'http://www.thinkphp.cn/document/116.html';
	$content = file_get_contents($detailUrl);
	#echo $content ;
	// 采集规则
	$rules = array(
	    'title' => ['.main .box .t-head h2', 'text'], // 标题
	    'pageviews' => ['.main .box .t-foot span:fist', 'text'], // 浏览量
	    'pubtime' => ['.main .box .t-foot span:eq(1)', 'text'], // 浏览量
	    'cate' => ['.main .box .t-foot span:eq(2)', 'text'], // 分类
	    'tags' => ['.main .box .t-foot span:eq(3)', 'text'], // tag标签
	    'content' => ['.main .box .detail-bd .art-cnt', 'html'], // 内容
	    'favorite' => ['.sidebar #collect_count', 'text'], // 收藏数
	    'support' => ['.sidebar .count-item .support_num', 'text'], // 点赞数
	    'uid' => ['#editbtn_user_id', 'value'], // 用户id
	);

	$scope = 'div.main';
	$queryList = new QueryList($detailUrl, $rules, $scope, $pagetype);
	$items = $queryList->jsonArr;

	var_dump($items);
    }

    /**
     * 采集功能
     * @param type $id
     */
    public function collect2($id) {
	$id = I('get.id', 0, 'intval');

	// 使用缓存
	$key = 'QueryListArgs';
	if (!$args = F($key)) {
	    $args = $this->genarateQueryListArgs();
	    F($key, $args);
	}
	extract($args);

	$pageKey = '_page';
	//采用session记录采集到哪个页面
	if (!isset($_SESSION[$pageKey])) {
	    $_SESSION[$pageKey] = $start_page;
	} else {
	    $_SESSION[$pageKey] = ++$_SESSION[$pageKey];
	}
	$url = str_replace(C('COLLECT_PAGE'), $_SESSION[$pageKey], $url);

	echo '<h3>正在采集第' . $_SESSION[$pageKey] . '页中的数据 链接地址为:: ' . $url . '</h3>';
	echo '<h3>3秒后继续自动执行下一个页面 ••• </h3>';

	$queryList = new QueryList($url, $rules, $scope, $pagetype);
	$list = $queryList->jsonArr;
	var_dump($list);

	#var_dump(array_slice($list, 0, 3));
	// 列表页的采集
	$doc = $queryList->buildContent();

	$this->assign('doc', $doc);

	$this->display('list_collect'); // 采集的列表页面

	if ($_SESSION[$pageKey] >= $end_page) {
	    unset($_SESSION[$pageKey]);
	    $this->success('恭喜您, 已采集完页面', U('index'), 5);
	    exit;
	}
	#echo '<script>setTimeout(function () {window.location.reload();},3000);</script>';
    }

    /**
     * 采集详情页
     */
    public function detail() {
	set_time_limit(0); // 程序执行时间不设限

	require_cache('./phpQuery.php');

	$start_page = 1;
	$end_page = 2500;

	$pageKey = '_page';
	//采用session记录采集到哪个页面
	if (!isset($_SESSION[$pageKey])) {
	    $_SESSION[$pageKey] = $start_page;
	} else {
	    $_SESSION[$pageKey] = ++$_SESSION[$pageKey];
	}
	
	$url = 'http://www.thinkphp.cn/code/' . C('COLLECT_PAGE') . '.html';
	$url = str_replace(C('COLLECT_PAGE'), $_SESSION[$pageKey], $url);

	echo '<h3>正在采集第' . $_SESSION[$pageKey] . '页中的数据 链接地址为:: ' . $url . '</h3>';
	echo '<h3>3秒后继续自动执行下一个页面 ••• </h3>';

	$document = \phpQuery::newDocumentFile($url);
	$listSelector = 'div.main';
	$item = pq($listSelector);

	// 采集规则
	$rules = array(
	    'title' => ['.box .t-head h2', 'text'], // 标题
	    'view_count' => ['.box .t-foot span:first', 'text'], // 浏览量
	    'create_time' => ['.box .t-foot span:eq(1)', 'text'], // 时间
	    'cate_id' => ['.box .t-foot span:eq(2)', 'text'], // 分类
	    'tags' => ['.box .t-foot span:eq(3)', 'text'], // tag标签
	    'content' => ['.box .detail-bd .art-cnt', 'html'], // 内容
	    'favorite_count' => ['.sidebar #collect_count', 'text'], // 收藏数
	    'reply_count' => ['.sidebar .review-count', 'text'], // 评论数
	    'support_count' => ['.sidebar .count-item .support_num', 'text'], // 点赞数
	    'user_id' => ['#editbtn_user_id', 'value'], // 用户id
	);

	$retData = array();
	if ($item->elements) {
	    $index = 0;
	    foreach ($rules as $key => $rule) {
		$one = pq($item)->find($rule[0]);
		switch ($rule[1]) {
		    case 'text':
			$retData[$key] = trim($one->text());
			break;
		    case 'html':
			$retData[$key] = trim($one->html());
			break;
		    default:  // 获取属性
			$retData[$key] = $one->attr($rule[1]);
			break;
		}


		// 过滤操作
		if ($key == 'view_count') {
		    $retData[$key] = mb_substr($retData[$index][$key], 3);
		}

		if ($key == 'create_time') {
		    $retData[$key] = strtotime(mb_substr($retData[$index][$key], 5));
		}

		if ($key == 'cate_id') {
		    if (mt_rand(1, 1000) >= 600) {
			$retData[$key] = 567; // 567
		    } else {
			$retData[$key] = mt_rand(10, 567); // 567
		    }
		}

		$index++;
	    }
	}

	// 有采集到数据
	if ($retData) {
	    // 入库
	    #D('MangerSystem/Post')->_add($retData);
	    #var_dump(D('MangerSystem/Post')->_sql());
	    M('Post')->add($retData);
	}

	if ($_SESSION[$pageKey] >= $end_page) {
	    unset($_SESSION[$pageKey]);
	    $this->success('恭喜您, 已采集完页面', U('index'), 5);
	    exit;
	}

	if ($_SESSION[$pageKey] % 100 == 0) {
	    sleep(5);
	}

	echo '<script>setTimeout(function () {window.location.reload();},2000);</script>';
    }
    
    /**
     * 采集详情页
     */
    public function detail2() {
	set_time_limit(0); // 程序执行时间不设限

	require_cache('./phpQuery.php');

	$start_page = 1;
	$end_page = 42128;

	$pageKey = '_page2';
	//采用session记录采集到哪个页面
	if (!isset($_SESSION[$pageKey])) {
	    $_SESSION[$pageKey] = $start_page;
	} else {
	    $_SESSION[$pageKey] = ++$_SESSION[$pageKey];
	}
	$url = 'http://www.thinkphp.cn/topic/' . C('COLLECT_PAGE') . '.html';
	$url = str_replace(C('COLLECT_PAGE'), $_SESSION[$pageKey], $url);

	echo '<h3>正在采集第' . $_SESSION[$pageKey] . '页中的数据 链接地址为:: ' . $url . '</h3>';
	echo '<h3>3秒后继续自动执行下一个页面 ••• </h3>';

	$document = \phpQuery::newDocumentFile($url);
	$listSelector = 'div.main';
	$item = pq($listSelector);

	// 采集规则
	$rules = array(
	    'title' => ['.box .t-head h2', 'text'], // 标题
	    'view_count' => ['.box .t-foot span:first', 'text'], // 浏览量
	    'create_time' => ['.box .t-foot span:eq(1)', 'text'], // 时间
	    'cate_id' => ['.box .t-foot span:eq(2)', 'text'], // 分类
	    'tags' => ['.box .t-foot span:eq(3)', 'text'], // tag标签
	    'content' => ['.box .detail-bd .art-cnt', 'html'], // 内容
	    'favorite_count' => ['.sidebar #collect_count', 'text'], // 收藏数
	    'reply_count' => ['.sidebar .review-count', 'text'], // 评论数
	    'support_count' => ['.sidebar .count-item .support_num', 'text'], // 点赞数
	    'user_id' => ['#editbtn_user_id', 'value'], // 用户id
	);

	$retData = array();
	if ($item->elements) {
	    $index = 0;
	    foreach ($rules as $key => $rule) {
		$one = pq($item)->find($rule[0]);
		switch ($rule[1]) {
		    case 'text':
			$retData[$key] = trim($one->text());
			break;
		    case 'html':
			$retData[$key] = trim($one->html());
			break;
		    default:  // 获取属性
			$retData[$key] = $one->attr($rule[1]);
			break;
		}


		// 过滤操作
		if ($key == 'view_count') {
		    $retData[$key] = mb_substr($retData[$index][$key], 3);
		}

		if ($key == 'create_time') {
		    $retData[$key] = strtotime(mb_substr($retData[$index][$key], 5));
		}

		if ($key == 'cate_id') {
		    if (mt_rand(1, 1000) >= 600) {
			$retData[$key] = 567; // 567
		    } else {
			$retData[$key] = mt_rand(10, 567); // 567
		    }
		}

		$index++;
	    }
	}

	// 有采集到数据
	if ($retData) {
	    // 入库
	    #D('MangerSystem/Post')->_add($retData);
	    #var_dump(D('MangerSystem/Post')->_sql());
	    M('Post')->add($retData);
	}

	if ($_SESSION[$pageKey] >= $end_page) {
	    unset($_SESSION[$pageKey]);
	    $this->success('恭喜您, 已采集完页面', U('index'), 5);
	    exit;
	}

	if ($_SESSION[$pageKey] % 100 == 0) {
	    sleep(5);
	}

	echo '<script>setTimeout(function () {window.location.reload();},2000);</script>';
    }

    
    
    public function cateGather() {
	
	require_cache('./phpQuery.php');

	$file = 'lagou_index.htm';
	\phpQuery::newDocumentFile('./gather/' . $file);

	$homeRecommend = array();  // 首页推荐
	$topCate = array();     // 顶部栏目

	$cateData = array();
	$allSon = array();
	$sonData = array();

	$first_cate_key = 8;
	$pk1 = 50;
	$pk2 = 300;

	foreach (pq('.mainNavs .menu_box') as $k => $menu_box) {

	    $one = trim(pq($menu_box)->find('.menu_main h2')->text()); //   顶部栏目
	    $topCate[$first_cate_key] = $one;

	    foreach (pq($menu_box)->find('.job_hopping a') as $recommend) {
		$homeRecommend[$one][] = pq($recommend)->text();
	    }

	    foreach (pq($menu_box)->find('.menu_sub dl') as $key => $dl) {

		$dtCate = pq($dl)->find('dt a');

		$href = $dtCate->attr('href');
		$cateData[$k][$key]['id'] = $pk1;     // 主键ID
		$cateData[$k][$key]['parent_id'] = $first_cate_key;     // 父id
		$cateData[$k][$key]['cate_no'] = $dtCate->attr('data-lg-tj-no');
		$cateData[$k][$key]['href'] = $href;
		$cateData[$k][$key]['cate_name'] = $dtCate->html();
		$cateData[$k][$key]['cate_name_alias'] = basename(urldecode($href));



		foreach (pq($dl)->find('dd a') as $key2 => $dd) {
		    $ddCate = pq($dd);
		    $href = $ddCate->attr('href');
		    $cate_name = $ddCate->html();
		    $sonData[$key2]['id'] = $pk2;
		    $sonData[$key2]['parent_id'] = $pk1;
		    $sonData[$key2]['cate_no'] = $ddCate->attr('data-lg-tj-no');
		    $sonData[$key2]['href'] = $href;
		    $sonData[$key2]['cate_name'] = $cate_name;
		    $sonData[$key2]['cate_name_alias'] = basename(urldecode($href));

		    // 第3级栏目是否有推荐
		    if (in_array($cate_name, $homeRecommend[$one])) {
			$sonData[$key2]['home_recommand'] = 1;
		    } else {
			$sonData[$key2]['home_recommand'] = 0;
		    }

		    $allSon[] = $sonData;
		    $pk2 ++ ;
		}
		$cateData[$k][$key]['child'] = $sonData;
		$sonData = array();
		
		$pk1++ ;
		
	    }
	    
	    $first_cate_key++ ;
	}
	
	$data = ['topCate' => $topCate, 'cateData'=> $cateData] ;
	
	return $data ;
    }


    /**
     * 采集分类
     */
    public function cate() {
	header("Content-type: text/html; charset=utf-8");
	set_time_limit(0); // 程序执行时间不设限
	
	// 使用缓存
	$key = 'cateGather';
	if (!$data = F($key)) {
	    $data = $this->cateGather();
	    F($key, $data);
	}
	extract($data);
	
	$cateModel = M('Cate');

	$topCateData = array();
	foreach ($topCate as $id => $cate_name) {
	    $topCateData[] = array(
		'id' => $id,
		'cate_name' => $cate_name,
	    );
	}
	
	$ret = $cateModel->addAll($topCateData);

	$secondLevelData = array();
	foreach ($cateData as $k1 => $arr1) {

	    foreach ($arr1 as $k2 => $arr2) {
		$secondLevelItem = array(
		    'id' => $arr2['id'],
		    'parent_id' => $arr2['parent_id'],
		    'cate_name' => $arr2['cate_name'],
		    'href' => $arr2['href'],
		    'cate_no' => $arr2['cate_no'],
		    'cate_name_alias' => $arr2['cate_name_alias'],
		);

		$secondLevelData[] = $secondLevelItem;
		$cateModel->add($secondLevelItem); // 循环添加二级分类数据
		$secondLevelItem = array();

		// 三级分类
		if (isset($arr2['child']) && $arr2['child']) {
		    
		    // 直接添加到数据库
		    $cateModel->addAll($arr2['child']); // 循环添加三级分类数据
		}
	    }
	}
    }

    // runCollect()
    // 把采集到的数据, 插入到数据库
    protected function insertDb() {
	
    }

}
