<?php

/**
 * Description of QueryList
 * 采集类, 基于phpQuery
 * @author liuayong
 */

namespace Common\Components;

class QueryList {

    private $pageUrl;  // 采集的页面地址
    private $rules = array(); // 采集明细数组， title ,url, 作者, 阅读数 ....
    public $jsonArr = array(); // 采集生成的列表
    private $scope;  // 查询范围
    private $pagetype;  // 采集页面类型
    private $htmlDocument;  // 整个html文档

    /*     * *********************************************
     * 参数: 页面地址 选择器数组 块选择器
     * 【选择器数组】说明：格式array("名称"=>array("选择器","类型"),.......)
     * 【类型】说明：值 "text" ,"html" ,"属性" 
     * 【块选择器】：指 先按照规则 选出 几个大块 ，然后再分别再在块里面 进行相关的选择
     * *********************************************** 
     */

    public function __construct($pageUrl, array $rules = array(), $scope = '', $pagetype = 'detail') {
	$this->pageUrl = $pageUrl;
	$this->rules = $rules;
	$this->scope = $scope;
	$this->pagetype = $pagetype;

	$this->getPageContent($pageUrl);

	if ($rules) {
	    $this->rules = $rules;
	    $this->scope = $scope;
	    if ($pagetype == 'detail') {
		$this->getDetailPage();
	    }
	    if ($pagetype == 'list') {
		$this->getListPage();
	    }
	}
    }

    /**
     * 通过url来获取页面内容
     */
    protected function getUrlContent($url) {
	//为了能获取https://
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$html = curl_exec($ch);
	curl_close($ch);
	return $html;
    }

    /**
     * 通过url来获取页面内容
     */
    protected function getPageContent($url) {
	$html = $this->getUrlContent($url);
	while (!$html) { //while 循环保证采集无误
	    sleep(3);
	    $html = $this->getUrlContent($url);
	}
	$this->htmlDocument = $html;
    }

    public function setQuery(array $rules = array(), $scope = '') {
	$this->jsonArr = array();
	$this->rules = $rules;
	$this->scope = $scope;
	$this->getList();
    }

    /**
     * 使用phpQuery 在列表页进行采集
     */
    private function getListPage() {
	#require_cache (__DIR__ . '/phpQuery.class.php');
	require_cache('./phpQuery.php');
	$doument = \phpQuery::newDocumentHTML($this->htmlDocument);

	$retData = array();  // 返回的数据， 数组
	if (!empty($this->scope)) {
	    $list_items = pq($doument)->find($this->scope);
	    foreach ($list_items as $index => $item) {
		foreach ($this->rules as $key => $rule) {
		    $one = pq($item)->find($rule[0]);
		    switch ($rule[1]) {
			case 'text':
			    $retData[$index][$key] = trim(pq($one)->text());
			    break;
			case 'html':
			    $retData[$index][$key] = trim(pq($one)->html());
			    break;
			default:  // 获取属性
			    $retData[$index][$key] = pq($one)->attr($rule[1]);
			    break;
		    }
		}
		//重置数组指针
		reset($this->rules);
	    }
	} else {
	    foreach ($this->rules as $key => $rule) {
		$one = pq($doument)->find($rule[0]);
		switch ($rule[1]) {
		    case 'text':
			$retData[$index][$key] = trim(pq($one)->text());
			break;
		    case 'html':
			$retData[$index][$key] = trim(pq($one)->html());
			break;
		    default:  // 获取属性
			$retData[$index][$key] = pq($one)->attr($rule[1]);
			break;
		}
	    }
	}
	$this->jsonArr = $retData;
    }

    /**
     * 对内容页进行采集
     */
    private function getDetailPage() {
	require_cache('./phpQuery.php');
	$doument = \phpQuery::newDocumentHTML($this->htmlDocument);

	// 判断 容器是否存在
	$this->scope && $scopeDOM = pq($this->scope);
	$item = $this->scope && $scopeDOM->elements ? $scopeDOM : pq($doument);
	$retData = array( );
	foreach ($this->rules as $key => $rule) {
	    $one = $item->find($rule[0]);
	    switch ($rule[1]) {
		case 'text':
		    $retData[$index][$key] = trim(pq($one)->text());
		    break;
		case 'html':
		    $retData[$index][$key] = trim(pq($one)->html());
		    break;
		default:  // 获取属性
		    $retData[$index][$key] = pq($one)->attr($rule[1]);
		    break;
	    }
	}
	$this->jsonArr = $retData;
    }

    /**
     *  组装采集的内容
     * @return type
     */
    public function buildContent() {
	if ($this->pagetype == 'detail') {
	    $data = $this->buliddetail();
	}
	if ($this->pagetype == 'list') {
	    $data = $this->bulidlist();
	}
	return $data;
    }

    /**
     * 组装内容页的数据
     */
    protected function buliddetail() {
	$doc = \phpQuery::newDocument("<div class='collect></div>");
	
		
	/*
	 <dl>
   <dt>计算机</dt>
   <dd>用来计算的仪器 ... ...</dd>
   <dt>显示器</dt>
   <dd>以视觉方式显示信息的装置 ... ...</dd>
</dl>
	 * 
	 */
    }

    /**
     * 组装列表页的数据
     * @return type
     */
    protected function bulidlist() {
	$doc = \phpQuery::newDocument("<div class='collect></div>");

	$table = '<table class="hovertable">';
	$table .= '<tr class="head">';
	foreach ($this->rules as $k => $v) {
	    $table .= "<th>{$k}</th>";
	}
	$table .= '</tr>';

	foreach ($this->jsonArr as $k => $v) {
	    $table .= '<tr class="item">';
	    foreach ($this->rules as $kk => $vv) {
		$table .= "<td>{$v[$kk]}</td>";
	    }
	    $table .= '</tr>';
	}
	$table .= '</table>';
	
	var_dump($this->rules);
	var_dump($this->jsonArr);

	$doc["div"]->append($table);

	return $doc;
    }

    public function getJSON() {
	return json_encode($this->jsonArr);
    }

}

?>
