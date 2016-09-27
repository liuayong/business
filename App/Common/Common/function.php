<?php

/**
 * 自定义获得用户名所对应的session键值策略
 */
function getSessionUnameKey() {
    $sessionUname = C('sessionUname');
    $sessionUname = $sessionUname ? : 'uname';
    return $sessionUname;
}

/**
 * 自定义获得用户ID所对应的session键值策略
 */
function getSessionUidKey() {
    $sessionUid = C('sessionUid');
    $sessionUid = $sessionUid ? : 'uid';
    return $sessionUid;
}

function getLetters($srcStr) {

    $retStr = '';

    // 单字节字符
    if (mb_strlen($srcStr, 'utf-8') == strlen($srcStr)) {
	$retStr = $srcStr;
    } else if (mb_strlen($srcStr, 'utf-8') * 3 == strlen($srcStr)) {  // utf-8下的中文
	$retStr = \Common\Components\Pinyin::letter($srcStr, ['delimiter' => '']);
    } else {
	$arr = preg_split('//u', $srcStr);
	foreach ($arr as $v) {
	    if ($v != '') {
		$py = \Common\Components\Pinyin::trans($v, ['accent' => false]);
		$retStr .= $py[0];
	    }
	}
    }
    return strtolower($retStr);
}

/**
 * 显示访问权限
 */
function showLevels($level) {
    $map = [
	'1' => ['color' => '#999', 'label' => '游客'],
	'2' => ['color' => 'green', 'label' => '普通会员'],
	'3' => ['color' => 'red', 'label' => '超级会员']
    ];
    $htmlTag = '<font color="' . $map[$level]['color'] . '">' . $map[$level]['label'] . '</font>';

    return $htmlTag;
}

/**
 * 获得文件的相对路径  
 */
function getFilePath($fullPath) {

    $fullPath = str_replace('\\', '/', $fullPath);

    $arr = explode('/', $fullPath);
    array_shift($arr);

    return implode('/', $arr);
}

/**
 * 去掉字符串中的所有空格, 
 * @param type $str
 * @return type
 */
function trimall($str) {   //   全角空格可以能删除
    return str_replace(array(" ", "　", "\t", "\n", "\r"), '', $str);
}

/**
 * 单文件上传的时候判断，是否有文件上传
 * @return boolean true:有上传的文件， false:没有上传的文件
 */
function hasUploadFile() {
    reset($_FILES);
    $key = key($_FILES);
    return $_FILES[$key]['error'] != UPLOAD_ERR_NO_FILE;
}

/**
 * 获得该项目的根本目录, 考虑了子目录的情况
 * @return type
 */
function getRootPath() {
    $host = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $host = $host === '/' ? $host : $host . '/';

    $documentRoot = $_SERVER['DOCUMENT_ROOT'] ? : $_SERVER['CONTEXT_DOCUMENT_ROOT'];

    return $documentRoot . $host;
}

/**
 * 格式化单位
 */
function byteFormat($size, $dec = 2) {
    $a = array("B", "KB", "MB", "GB", "TB", "PB");
    $pos = 0;
    while ($size >= 1024) {
	$size /= 1024;
	$pos ++;
    }
    return round($size, $dec) . " " . $a[$pos];
}

/*
 * 标题样式恢复
 */

function titleStyleRestore($serialize, $scope = 'bold') {
    $unserialize = unserialize($serialize);
    if (isset($unserialize['bold']) && $unserialize['bold'] == 'Y' && $scope == 'bold')
	return 'Y';
    if (isset($unserialize['underline']) && $unserialize['underline'] == 'Y' && $scope == 'underline')
	return 'Y';
    if (isset($unserialize['color']) && $unserialize['color'] && $scope == 'color')
	return $unserialize['color'];
    return FALSE;
}

/**
 * 下拉框，单选按钮 自动选择
 *
 * @param $string 输入字符
 * @param $param  条件
 * @param $type   类型
 *            selected checked
 * @return string
 */
function selected($string, $param = 1, $type = 'select') {
    $true = false;
    if (empty($string))
	return '';
    if (is_array($param)) {
	$true = in_array($string, $param);
    } elseif ($string == $param) {
	$true = true;
    }
    if ($true)
	$return = $type == 'select' ? 'selected="selected"' : 'checked="checked"';
    else
	$return = '';
    echo $return;
}

/* * *************************************************  *********************************** */

/**
  +----------------------------------------------------------
 * UBB 解析
  +----------------------------------------------------------
 * @return string
  +----------------------------------------------------------
 */
function ubb($Text) {
    $Text = trim($Text);
    //$Text=htmlspecialchars($Text);
    //$Text=ereg_replace("\n","<br>",$Text);
    $Text = preg_replace("/\\t/is", "  ", $Text);
    $Text = preg_replace("/\[hr\]/is", "<hr>", $Text);
    $Text = preg_replace("/\[separator\]/is", "<br/>", $Text);
    $Text = preg_replace("/\[h1\](.+?)\[\/h1\]/is", "<h1>\\1</h1>", $Text);
    $Text = preg_replace("/\[h2\](.+?)\[\/h2\]/is", "<h2>\\1</h2>", $Text);
    $Text = preg_replace("/\[h3\](.+?)\[\/h3\]/is", "<h3>\\1</h3>", $Text);
    $Text = preg_replace("/\[h4\](.+?)\[\/h4\]/is", "<h4>\\1</h4>", $Text);
    $Text = preg_replace("/\[h5\](.+?)\[\/h5\]/is", "<h5>\\1</h5>", $Text);
    $Text = preg_replace("/\[h6\](.+?)\[\/h6\]/is", "<h6>\\1</h6>", $Text);
    $Text = preg_replace("/\[center\](.+?)\[\/center\]/is", "<center>\\1</center>", $Text);
    //$Text=preg_replace("/\[url=([^\[]*)\](.+?)\[\/url\]/is","<a href=\\1 target='_blank'>\\2</a>",$Text);
    $Text = preg_replace("/\[url\](.+?)\[\/url\]/is", "<a href=\"\\1\" target='_blank'>\\1</a>", $Text);
    $Text = preg_replace("/\[url=(http:\/\/.+?)\](.+?)\[\/url\]/is", "<a href='\\1' target='_blank'>\\2</a>", $Text);
    $Text = preg_replace("/\[url=(.+?)\](.+?)\[\/url\]/is", "<a href=\\1>\\2</a>", $Text);
    $Text = preg_replace("/\[img\](.+?)\[\/img\]/is", "<img src=\\1>", $Text);
    $Text = preg_replace("/\[img\s(.+?)\](.+?)\[\/img\]/is", "<img \\1 src=\\2>", $Text);
    $Text = preg_replace("/\[color=(.+?)\](.+?)\[\/color\]/is", "<font color=\\1>\\2</font>", $Text);
    $Text = preg_replace("/\[colorTxt\](.+?)\[\/colorTxt\]/eis", "color_txt('\\1')", $Text);
    $Text = preg_replace("/\[style=(.+?)\](.+?)\[\/style\]/is", "<div class='\\1'>\\2</div>", $Text);
    $Text = preg_replace("/\[size=(.+?)\](.+?)\[\/size\]/is", "<font size=\\1>\\2</font>", $Text);
    $Text = preg_replace("/\[sup\](.+?)\[\/sup\]/is", "<sup>\\1</sup>", $Text);
    $Text = preg_replace("/\[sub\](.+?)\[\/sub\]/is", "<sub>\\1</sub>", $Text);
    $Text = preg_replace("/\[pre\](.+?)\[\/pre\]/is", "<pre>\\1</pre>", $Text);
    $Text = preg_replace("/\[emot\](.+?)\[\/emot\]/eis", "emot('\\1')", $Text);
    $Text = preg_replace("/\[email\](.+?)\[\/email\]/is", "<a href='mailto:\\1'>\\1</a>", $Text);
    $Text = preg_replace("/\[i\](.+?)\[\/i\]/is", "<i>\\1</i>", $Text);
    $Text = preg_replace("/\[u\](.+?)\[\/u\]/is", "<u>\\1</u>", $Text);
    $Text = preg_replace("/\[b\](.+?)\[\/b\]/is", "<b>\\1</b>", $Text);
    $Text = preg_replace("/\[quote\](.+?)\[\/quote\]/is", "<blockquote>引用:<div style='border:1px solid silver;background:#EFFFDF;color:#393939;padding:5px' >\\1</div></blockquote>", $Text);
    $Text = preg_replace("/\[code\](.+?)\[\/code\]/eis", "highlight_code('\\1')", $Text);
    $Text = preg_replace("/\[php\](.+?)\[\/php\]/eis", "highlight_code('\\1')", $Text);
    $Text = preg_replace("/\[sig\](.+?)\[\/sig\]/is", "<div style='text-align: left; color: darkgreen; margin-left: 5%'><br><br>--------------------------<br>\\1<br>--------------------------</div>", $Text);
    return $Text;
}

function toDate($time, $format = 'Y年m月d日 H:i:s') {
    if (empty($time)) {
	return '';
    }
    $format = str_replace('#', ':', $format);
    return date($format, $time);
}

// 输出标签
function showTags($tags) {
    return $tags;
}

/**
 * 构造HTML标签的属性字符串
 */
function buildHtmlAttr(array $params = array()) {
    $html = ' ';

    foreach ($params as $k => $v) {
	$html .= " $k=\"$v\" ";
    }
    return $html;
}

/**
 * 解析动态表单的数据
 * @param type $str
 * @return type
 */
function parseFormItems($str) {
    $data = [
	'input' => '文本输入',
	'select' => '下拉选择',
	'checkbox' => '多选',
	'radio' => '单选',
	'textarea' => '大段内容',
    ];


    $delimiter1 = "\n";
    $delimiter2 = "=>";
    $str = htmlspecialchars_decode($str);
    $arr = explode($delimiter1, $str);
    $data = [];
    foreach ($arr as $v) {
	list($key, $value) = explode($delimiter2, $v);
	$data[$key] = $value;
    }
    return $data;
}

/**
 * 输出一个下拉列表
 * @param array $sourceDatas, 一位数组, key => val
 * @param type $val,  一个option的值
 * @param array $options, html 参数
 * @return string
 */
function showSelect(array $sourceDatas = array(), $val = '', array $options = array()) {

    // ['prompt' => ' 请选择 ']
    $promptHtml = '';
    // 有提示项
    if (isset($options['prompt']) && $options['prompt']) {
	$promptHtml = '<option value="">' . $options['prompt'] . '</option>';
	unset($options['prompt']);
    }

    $htmlAttr = buildHtmlAttr($options);

    $selectHtml = '<select' . $htmlAttr . '>' . $promptHtml;

    foreach ($sourceDatas as $k => $v) {
	$selected = ($k == $val) ? 'selected ="selected"' : '';
	$selectHtml .= "<option {$selected} value=\"{$k}\">{$v}</option>";
    }
    $selectHtml .= '</select>';

    return $selectHtml;
}

/**
 * 输出一个checkbox列表
 * @param array $sourceDatas, 一位数组, key => val
 * @param type $val,  一个option的值, val可能是字符串也可能是 array(multiple|checkbox)
 * @param array $options, html 参数
 * @return string
 */
function showCheckBox(array $sourceDatas = array(), $val = '', array $options = array()) {
    $htmlAttr = buildHtmlAttr($options);

    $checkBoxHtml = '';
    foreach ($sourceDatas as $k => $v) {
	$checked = ($k == $val || in_array($k, $val)) ? 'checked ="checked"' : '';
	$checkBoxHtml .= "<label class='checkboxLabel'><input value='{$k}' {$checked} type=\"checkbox\" {$htmlAttr}/>{$v}</label>";
    }
    return $checkBoxHtml;
}

/**
 * 输出一个radio列表
 * @param array $sourceDatas, 一位数组, key => val
 * @param type $val,  一个option的值
 * @param array $options, html 参数
 * @return string
 */
function showRadio(array $sourceDatas = array(), $val = '', array $options = array()) {
    $htmlAttr = buildHtmlAttr($options);

    $radioHtml = '';
    foreach ($sourceDatas as $k => $v) {
	$checked = ($k == $val || in_array($k, (array) $val) ) ? 'checked ="checked"' : '';
	$radioHtml .= "<label class='radioLabel'><input value='{$k}' {$checked} type=\"radio\" {$htmlAttr}/>{$v}</label>";
    }
    return $radioHtml;
}

/**
 * 输出一个input框
 * @param type $val
 * @param array $options
 */
function showInput($val = '', array $options = array()) {
    $htmlAttr = buildHtmlAttr($options);
    $inputHtml = "<input value='{$val}'  type=\"text\" {$htmlAttr}/> ";
    return $inputHtml;
}

/**
 * 输出一个textarea文本域
 * @param type $val
 * @param array $options
 */
function showTextArea($val = '', array $options = array()) {
    $htmlAttr = buildHtmlAttr($options);
    $textareaHtml = "<textarea {$htmlAttr}>{$val}</textarea>";
    return $textareaHtml;
}

/**
 * 解析where表达式
 * @param type $where
 * @return type
 */
function parseWhere($where) {
    $whereStr = '';
    if (is_string($where)) {
	// 直接使用字符串条件
	$whereStr = $where;
    } else { // 使用数组表达式
	$operate = isset($where['_logic']) ? strtoupper($where['_logic']) : '';
	
	if (in_array($operate, array('AND', 'OR', 'XOR'))) {
	    // 定义逻辑运算规则 例如 OR XOR AND NOT
	    $operate = ' ' . $operate . ' ';
	    unset($where['_logic']);
	} else {
	    // 默认进行 AND 运算
	    $operate = ' AND ';
	}
	foreach ($where as $key => $val) {

	    if (is_scalar($val)) {
		$whereStr .= "`{$key}` = '{$val}'";
	    } else if (is_array($val)) {
		
	    }

	    $whereStr .= $operate;
	}
	$whereStr = substr($whereStr, 0, -strlen($operate));
    }
    return empty($whereStr) ? '' : ' WHERE ' . $whereStr;
}


/**
 * 通过内容来获取摘要 255个单词
 * @param type $content
 * @param type $len
 * @return type
 */
function getIntro($content, $len = 255) {
    $strlen = mb_strlen($content, 'utf-8');
    if($strlen > $len) {
	return mb_substr($content, 0, $len) . '<span style="color:green;"> ...</span>' ;
    } else {
	return $content ;
    }
}

/*

function rand_color() {
    return 'rgb('.mt_rand(0, 255).', '. mt_rand(0, 255).', '.mt_rand(0, 255).')';
}
 */

/**
 * 标签获取标题的大小
 * @param $count 标签出现的次数
 * @return string
 */
function getTitleSize($count) {
  $size = (ceil($count / 10) +  11) . 'px';
    return $size;
}

/**
 * 标签获取随机颜色
 * @return type
 */
function rand_color() {
    $color = '#';
    for($i=0; $i<3 ; ++$i) {
        $rand = mt_rand(0, 255);
        $color .= sprintf('%02X', $rand);
    }
    return $color ;
}

/**
 * 通过内容来获取摘要 255个单词
 * @param type $content
 * @param type $len
 * @return type
 */
function getShortContent($content, $len = 255) {
     // //  将OUTPUT_CHARSET 改为 DEFAULT_CHARSET
     $strlen = mb_strlen($content, 'utf-8');
    if($strlen > $len) {
	return mb_substr($content, 0, $len, 'utf-8') . '<span style="color:green;"> ...</span>' ;
    } else {
	return $content ;
    }
}


/**
 * 有好的显示时间
 * @param type $time
 */
function friendlyShowTime($time) {
    return date("m-d H:i", $time);
}