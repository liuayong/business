<?php

namespace MangerSystem\Model;

use Common\Components\Pinyin;

/**
 * {类型}模型
 */
class PostModel extends CommonModel {

    protected $_validate = [
	// array(field,rule,message,condition,type,when,params) 
	// array(field, url,'错误提示',self::VALUE_VALIDATE, callback, self:MODEL_BOTH , params) 
	['title', 'require', '内容名称不能为空', self::MODEL_BOTH],
	['title_alias', '', '内容的唯一标识名必须是唯一的', self::MUST_VALIDATE, 'unique', self::MODEL_INSERT],
    ];

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
	// 查询分类 catalogId
	$catalogId = I('catalogId', 0, 'intval');
	if ($catalogId) {
	    $catalogIds = D('Cate')->getSons($catalogId); // 获取子类
	    array_push($catalogIds, $catalogId);
	    $where['cate_id'] = ['in', $catalogIds];
	}

	// 查询标题
	$title = I('title', '', 'trim');
	$title && $where['title'] = ['like', "%$title%"];

	// 查询别名
	$titleAlias = I('titleAlias', '', 'trim');
	$titleAlias && $where['title_alias'] = ['like', "%$titleAlias%"];

	// 分页功能
	$pageSize = C('pagesize');
	$pageSize = $pageSize ? : 10;
	//$pageSize = 1;  // 临时设置
	$totalRecord = $this->where($where)->count();
	$Page = new \Think\Page($totalRecord, $pageSize);
	$limit = $Page->firstRow . ',' . $Page->listRows;
	$show = $Page->show(); // 分页显示输出

	$list = $this->field($field)->where($where)->order($order)->limit($limit)->select();


	return array('data' => $list, 'page' => $show);
    }

    /*
     * 标题样式格式化
     * 目前标题支持3种样式
     */

    public function titleStyle($style) {
	$text = '';
	// 加粗
	if ($style['bold'] == 'Y') {
	    $text .='font-weight:bold;';
	    $serialize['bold'] = 'Y';
	}
	// 下划线
	if ($style['underline'] == 'Y') {
	    $text .='text-decoration:underline;';
	    $serialize['underline'] = 'Y';
	}
	// 颜色
	if (!empty($style['color'])) {
	    $text .='color:#' . $style['color'] . ';';
	    $serialize['color'] = $style['color'];
	}
	return array('text' => $text, 'serialize' => empty($serialize) ? '' : serialize($serialize));
    }

    /*
     * 标题样式恢复
     * 目前标题支持3种样式
     */

    public function titleStyleRestore($serialize, $scope = 'bold') {
	$unserialize = unserialize($serialize);
	if ($unserialize['bold'] == 'Y' && $scope == 'bold')
	    return 'Y';
	if ($unserialize['underline'] == 'Y' && $scope == 'underline')
	    return 'Y';
	if ($unserialize['color'] && $scope == 'color')
	    return $unserialize['color'];
    }

    /**
     * 添加方法
     */
    public function _add() {
	$data = $this->data;
	// my_copy('./UploadsTemp/' . $data['cate_pic'], './Uploads/', true);
	// $data['content'] = str_replace('images/', '/Public/Home/images/', $data['content']);
	// 处理标题的样式 
	$styleFormat = $this->titleStyle(I('post.style'));
	$data['title_style'] = $styleFormat['text'];
	$data['title_style_serialize'] = $styleFormat['serialize'];

	// $data['tags'] = $this->formatTags(I('post.tags'));      // 格式化，标签
	// 
	// 处理内容的 唯一标识, 根据标题名称生成
	if (empty($data['title_alias'])) {
	    $data['title_alias'] = getLetters($data['title']);
	}

	$this->data = $data;
	return parent::_add();
    }

    // 插入数据前的回调方法
    protected function _before_insert(&$data, $options) {
	
    }

    // 插入成功后的回调方法
    protected function _after_insert($data,$options) {
	$vals = I('post.attr');
	$pk = $this->getPk();
	$post_id = $data[$pk];
	
	// 组装datalist
	foreach ($vals as $k => $v) {
	    // checkbox可能是数组
	    if (isset($v['attr_val']) && is_array($v['attr_val'])) {
		$vals[$k]['attr_val'] = implode(',', $v['attr_val']);
	    }
	    $vals[$k]['post_id'] = $post_id;
	}
	
	M('attrVal')->addAll($vals);
	return true;
    }

    // 删除成功后的回调方法
    protected function _after_delete($data, $options) {
	
    }

    // 更新成功后的回调方法
    protected function _after_update($data, $options) {
	$vals = I('post.attr');
	
	$pk = $this->getPk();
	$post_id = $data[$pk];
	
	// 先删除, 再添加
	M('attrVal')->where(['post_id'=>$post_id])->delete();
	
	if($vals) {
		// 组装datalist
		foreach ($vals as $k => $v) {
		    // checkbox可能是数组
		    if (isset($v['attr_val']) && is_array($v['attr_val'])) {
			$vals[$k]['attr_val'] = implode(',', $v['attr_val']);
		    }
		    $vals[$k]['post_id'] = $post_id;
		}
		M('attrVal')->addAll($vals);
	}
	
	return true ;
    }
    
    

    /**
     * 修改方法
     */
    public function _save() {
	$data = $this->data;

	/*
	  // my_copy('./UploadsTemp/' . $data['cate_pic'], './Uploads/', true);
	  // 删除原来的图片(原始图和缩略图)
	  $pk = $this->pk;
	  $row = $this->field(['cate_pic'])->find($data[$pk]);
	  if ($row['cate_pic'] != $data['cate_pic']) {
	  $srcImg = './Uploads/' . $row['cate_pic'];
	  @unlink($srcImg);
	  }
	 */

	
	$styleFormat = $this->titleStyle(I('post.style'));
	$data['title_style'] = $styleFormat['text'];
	$data['title_style_serialize'] = $styleFormat['serialize'];

	// 处理内容的 唯一标识, 根据标题名称生成
	if (empty($data['title_alias'])) {
	    $data['title_alias'] = getLetters($data['title']);
	}


	$this->data = $data;
	return parent::_save();
    }

    /**
     * 设置栏目的英文名称
     */
    protected function setCateEName() {
	$data = $this->data;
	$data['name_en'] = getLetters($data['name_zh']);
	$this->data = $data;
    }

    /**
     * 根据栏目名称 获取某个栏目下的 几篇文章
     */
    public function getCateNews($name, $cnt = 1, &$url) {
	$where = ['cate_name' => $name, 'cate_id' => $name, '_logic' => 'OR'];
	$cate_id = $this->where($where)->getField('cate_id');

	$where = ['cate_id' => $cate_id];

	$field = ['news_id', 'title', 'title_id', 'show_img', 'tag'];
	$data = D('News')->field($field)->where($where)->order(['sort_order' => 'desc'])->limit($cnt)->select();

	$url = U('/Home/Cate/index', ['id' => $cate_id]);
	return $data;
    }

    // 计算栏目的URL
    protected function calcCateUrl(&$data) { // 传值 或者 像upImg 传递状态
	// 计算栏目跳转的urL
	if (trim($data['redirect_url']) == '') {
	    if ($data[$this->parent_id] == 0) { // 对于顶级栏目的处理, 顶级栏目没有模板, 访问第一个子级栏目
		$sons = $this->getSons($data[$this->getPk()]);
		if ($sons) {
		    $data['cate_url'] = U('Home/Cate/index', ['id' => $sons[0]]);
		} else {
		    $data['cate_url'] = '';    // U('Home/Cate/index', ['id' => $data['cate_id']])
		}
	    } else {

		$data['cate_url'] = '';
	    }
	} else if (strpos($data['redirect_url'], 'http://') === 0 || strpos($data['redirect_url'], 'https://') === 0) {
	    $data['cate_url'] = $data['redirect_url'];
	} else {
	    // 加载静态页
	}
	return true;
    }
    
    
    /**
     * 增加页面浏览量, 通过主键进行修改操作
     * 页面浏览量字段 view_count
     */
    public  function addViews($pkVal, $inc = 1) {
        $filed = 'view_count' ;
        $pk = $this->getPk();
        $this->where([$pk => $pkVal])->setInc($filed, $inc);
    }
    
    /**
     * 增加页面回复数量, 通过主键进行修改操作
     * 回复数量字段 reply_count
     */
    public  function addComments($pkVal, $inc = 1) {
        $filed = 'reply_count' ;
        $pk = $this->getPk();
        $this->where([$pk => $pkVal])->setInc($filed, $inc);
        #file_put_contents('d:\m.php', $this->_sql(). PHP_EOL, FILE_APPEND);
    }

}
