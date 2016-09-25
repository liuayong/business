<?php

namespace Common\Components;

define('PRIMARY_KEY', 'id');       
define('PARENT_ID', 'parent_id');  


/**
 * Description 树状结构的操作一个类
 * @author liuayong
 */
class Tree {

    /**
     * 组成二维数组(树状结构)
     * 递归的方法  array_mearge
     * 主要应用 前台页面左侧栏目导航，下拉列表选择分类,后台分类列表的显示
     */
    public static function getTree($list, $pid = 0, $html = '　　', $level = 0) {
	$tree = array();
	foreach ($list as $v) {
	    if ($v[PARENT_ID] == $pid) {  // pid是子类与父类关联的键 
		$v['levels'] = $level;
		$v['preHtml'] = str_repeat($html, $level);
		$tree[] = $v;
		$tree = array_merge($tree, self::getTree($list, $v[PRIMARY_KEY], $html, $level + 1));
	    }
	}
	return $tree;
    }

    /**
     * 组成二维数组(树状结构)
     * 递归的方法 static
     * 主要应用 前台页面左侧栏目导航，下拉列表选择分类,后台分类列表的显示
     */
    public static function getTree2($list, $pid = 0, $html = '　　', $level = 0) {
	static $tree = array();
	foreach ($list as $v) {
	    if ($v[PARENT_ID] == $pid) {  // pid是子类与父类关联的键 
		$v['level'] = $level;
		$v['preHtml'] = str_repeat($html, $level) . '┣─';
		$tree[] = $v;
		self::getTree2($list, $v[PRIMARY_KEY], $html, $level + 1);
	    }
	}
	return $tree;
    }

    /**
     * 组成二维数组(树状结构)
     * 迭代的方法
     * 主要应用 前台页面左侧栏目导航，下拉列表选择分类,后台分类列表的显示
     */
    public static function getTree3($list, $pid = 0, $html = '　　', $level = 0) {
	$task = array($pid);
	$i = 1;
	$data = array(); // 存储返回的结果

	while (!empty($task)) {
	    $has_child = false; // 是否有子集
	    foreach ($list as $k => $v) {
		if ($v[PARENT_ID] == $pid) {
		    $v['level'] = $level++;
		    $v['preHtml'] = str_repeat($html, $level) . '┣─';

		    array_push($task, $v[PRIMARY_KEY]); // 添加任务
		    $data[] = $v;     // 保存data数组

		    $pid = $v[PRIMARY_KEY];
		    $has_child = true;
		    unset($cates[$k]);
		}
	    }

	    // 没有孩子节点 回退任务数组, 从上一个节点往下迭代
	    if ($has_child == false) {
		array_pop($task);
		$pid = end($task);
		$level--;
	    }
	}

	return $data;
    }

    /**
     * 返回一个多维数组
     * 头部导航栏, 左侧多级导航栏
     */
    public static function unLimitForLevel($list, $pid = 0, $childName = 'child') {
	$tree = [];
	foreach ($list as $v) {
	    if ($v[PARENT_ID] == $pid) {

		// $tmp = self::unLimitForLevel($list, $childName , $v[PRIMARY_KEY]); 
		// $tmp && $v[$childName] = $tmp ;

		$v[$childName] = self::unLimitForLevel($list, $v[PRIMARY_KEY], $childName);

		$tree[] = $v;
	    }
	}
	return $tree;
    }

    /**
     * 获得家谱树 迭代的方法
     * @param type $list
     * @param type $id
     * @return 二维数组
     */
    public static function getFamilyTree($list, $id) {
	$data = [];
	foreach ($list as $k => $v) {
	    if ($v[PRIMARY_KEY] == $id) {
		$data[] = $v;
		unset($list[$k]);
		$data = array_merge(self::getFamilyTree($list, $v[PARENT_ID]), $data);
	    }
	}
	return $data;
    }

    /**
     * 获得家谱树 迭代的方法  包括自身
     * @param type $list
     * @param type $id
     * @return 二维数组
     */
    public static function getFamilyTree2($list, $id) {
	$data = [];

	while ($id) {
	    $flag = FALSE;
	    foreach ($list as $v) {
		if ($v[PRIMARY_KEY] == $id) {
		    $flag = TRUE;
		    array_unshift($data, $v);
		    $id = $v[PARENT_ID];
		    break;
		}
	    }
	    if (!$flag) {
		break;
	    }
	}
	return $data;
    }

    /**
     * 递归的方法获得父级及其祖先级id 包括自身
     * @param type $list
     * @param type $id
     * @return array
     */
    public static function getFamilyIds($list, $id) {
	$ids = [];
	while ($id) {
	    foreach ($list as $v) {
		if ($v[PRIMARY_KEY] == $id) {
		    array_unshift($ids, $id);
		    $id = $v[PARENT_ID];
		    break;
		}
	    }
	}
	return $ids;
    }

    /**
     * 子孙树的id (没有包含本身id)
     * 应用场景: 需要获得某个栏目下的商品, 你必须在该栏目和其子栏目进行查找
     */
    public static function getChildsId($list, $pid = 0) {
	$ids = array();
	$pids = array($pid);
	$flag = true;
	while ($flag) {
	    $levelids = array();
	    $flag = false;
	    foreach ($pids as $pid) {
		foreach ($list as $k => $v) {
		    if ($v[PARENT_ID] == $pid) {
			unset($list[$k]);
			$ids[] = $v[PRIMARY_KEY];
			$levelids[] = $v[PRIMARY_KEY];
			$flag = true;
		    }
		}
		$pids = $levelids;
	    }
	}
	return $ids;
    }

    /**
     * 子孙树的id (没有包含本身id)
     * 应用场景: 需要获得某个栏目下的商品, 你必须在该栏目和其子栏目进行查找
     */
    public static function getChildsId2($list, $pid = 0) {
	$ids = [];
	foreach ($list as $v) {
	    if ($v[PARENT_ID] == $pid) {
		$ids[] = $v[PRIMARY_KEY];
		$ids = array_merge($ids, self::getChildsId2($list, $v[PRIMARY_KEY]));
	    }
	}
	return $ids;
    }

}
