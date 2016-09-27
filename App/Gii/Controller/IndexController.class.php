<?php

/**
 * Thinkphp 后台代码生成工具生成器
 * 表单项的种类
 * 	input, email, number, date, datetime, time,  unique, editor, textarea, select, image, mimage, file, mfile, radio, checkbox, none
 *
 * 验证规则(常见的验证规则), 一个表单可能有多种验证规则, 暂时不实现 (多个验证规则可以使用+进行分割)
 * require, email、url、 currency、  number,  >=10, <=3, max(10), min(5), [1, 3, 5], 
 * 表注释 [表单类型/验证类型] 表单label key:values(多个键值对使用逗号分隔开来)   含有冒号表示value值是键值对, 主要用于 select/radio/checkbox
 * eg:  [select/require]是否显示 input:文本输入, select:下拉选择,checkbox:多选,textarea:大段内容,radio:单选

 */

namespace Gii\Controller;

use Think\Controller;

class IndexController extends Controller {

    protected $moduleName = '';     // 模块名称名称 严格区分大小写
    protected $tpName = '';     // TP中的 模型名称
    protected $pk = '';      // 表主键
    protected $tableName = '';      // 选择的表名
    protected $tableComment = '';   // 表字段的注释内容
    protected $rulesType = 'fileType';      // 生成表单验证规则的依据, 默认是根据数据库字段类型生成验证规则 fileComment,fileType
    protected $showFields;     // 需要显示到列表页的字段
    protected $fullFields;     // 数据库中的所有字段的详细信息， 包括表单类型，验证，基础数据等
    protected $rulesForPHP = [];    // 生成的ThinkPHP的验证规则
    protected $rulesForJS = [];     // 生成的JS的验证规则, 可以选择一种 表单验证的js库
    protected $superControllerName = 'CommonController';   // 父级控制器
    protected $superModelName = 'CommonModel';      // 父级模型
    protected $resourceSrcDir = '';       // 模板资源的源目录
    protected $resourceDestDir = '';      // 模板资源的目标目录

    protected function _initialize() {
	C('SHOW_PAGE_TRACE', true);
	// 给资源目录赋值
	$this->resourceSrcDir = MODULE_PATH . 'Template/assets/';
	$this->resourceDestDir = './aaa/';
	
	
    }

    public function index() {

	if (IS_POST) {
	    $this->initData();      // 初始化数据
	    // 生成的选项， 是否生成控制器 模型 及其视图文件 index,add,upd
	    isset($_POST['createOptions']['controller']) && $this->createControler();       // 生成控制器
	    isset($_POST['createOptions']['model']) && $this->createModel();   // 生成模型
	    $this->createView();     // 生成视图
	} else {
	    $this->display();
	}
    }

    // 获得当前库下的所有表
    public function tables() {
	$prefixKey = 'tables_in_';
	$dbName = strtolower(C('DB_NAME'));
	$db = M();
	$tables = $db->query('show tables');

	$funName = 'array_column';
	if (function_exists($funName)) {
	    $tables = $funName($tables, $prefixKey . $dbName);
	} else {
	    $errMsg = '函数' . $funName . '不存在请自行定义!';
	    $this->error($errMsg);
	    exit($errMsg);
	}
	//  echo json_encode($tables) ;  // , JSON_UNESCAPED_UNICODE
	echo implode("\n", $tables);
    }

    // 选择表后， ajax显示表的字段
    public function fields() {
	$tableName = I('tName');
	if (empty($tableName)) {
	    return false;
	}
	$tpTableName = $this->tableName2TpName($tableName);
	$db = M($tpTableName);
	$pk = $db->getPk();
	$info = $db->query('show full columns FROM ' . $tableName);

	$funName = 'array_column';
	if (function_exists($funName)) {
	    $keyArr = $funName($info, 'field');
	    $valArr = $funName($info, 'comment');
	    $fields = array_combine($keyArr, $valArr);
	} else {
	    $errMsg = '函数' . $funName . '不存在请自行定义!';
	    $this->error($errMsg);
	    exit($errMsg);
	}

	unset($fields[$pk]);    // 去掉主键	 列表页主键一定有
	//echo json_encode($fields, JSON_UNESCAPED_UNICODE);
	$this->assign('fields', $fields);
	$this->display('ajaxFields');
    }

    /**
     * 根据表名获得对应的模型名, eg: tbl_post_tag -> PostTag
     * @param type $tableName
     * @return type
     */
    protected function tableName2TpName($tableName) {
	$prefix = C('DB_PREFIX');     // 表前缀
	$tpName = str_replace('#' . $prefix, '', '#' . $tableName);    // 替换表前缀
	$tpName = array_map('ucfirst', explode('_', $tpName));
	$tpName = implode('', $tpName);
	return $tpName;
    }

    /**
     * 生成控制器文件
     */
    protected function createControler() {
	$moduleName = $this->moduleName;
	$tpName = $this->tpName;
	$conLayer = C('DEFAULT_C_LAYER'); //  默认的控制器层名称

	/**	 * ************************* 生成控制器 ********************* */
	$cFileName = $tpName . $conLayer . '.class.php';      // 控制器文件名
	$fullPath = APP_PATH . $moduleName . '/' . $conLayer . '/' . $cFileName;   // 控制器目录名
	// $controllerPath = APP_PATH . $moduleName . '/'. $conLayer .'/' ;         // 控制器目录名
	$controllerPath = dirname($fullPath) . '/';  // 控制器目录名
	// 简单的判断父类是否存在
	$superFile = $controllerPath . $this->superControllerName . '.class.php';
	if (file_exists($superFile)) {
	    $useExpression = '';
	    $superControllerName = $this->superControllerName;
	} else {
	    $useExpression = 'use Think\Controller;';
	    $superControllerName = 'Controller';
	}


	is_dir($controllerPath) || mkdir($controllerPath, 0777, true);

	ob_start();     // 打开ob缓存区
	// 控制器所需要的模板文件
	$templateController = MODULE_PATH . 'Template/Controller.php';

	if (file_exists($templateController)) {
	    require $templateController;
	} else {
	    $errMsg = '控制器模板文件' . $templateController . '不存在, 请检查!';
	    $this->error($errMsg);
	}

	$content = ob_get_clean(); // 从缓冲区中取出解析之后的字符串
	$content && file_put_contents($fullPath, "<?php\r\n" . $content);
    }

    // 生成模型
    protected function createModel() {
	$moduleName = $this->moduleName;
	$tpName = $this->tpName;
	$modLayer = C('DEFAULT_M_LAYER'); //  默认的模型层名称
	// 获取验证的方法，2种, 根据数据字段的注释验证， 根据数据字段的类型 进行简单验证
	$rulesType = I('post.rulesType');
	$rulesType && $this->rulesType = $rulesType;


	$str = '';
	$rules = $this->generateRulesForPHP();

	$this->rulesForPHP = $rules; // 下面将规则进行处理后， 将$str 传递到 页面 Model.php
	array_map(function($elem) use(&$str) {
	    $str .= "\t" . $elem . "\n";
	}, $rules);


	/*	 * ************************* 生成模型 ********************* */
	$mFileName = $tpName . $modLayer . '.class.php';      // 模型文件名
	$fullPath = APP_PATH . $moduleName . '/' . $modLayer . '/' . $mFileName;
	$modelPath = dirname($fullPath) . '/';
	is_dir($modelPath) || mkdir($modelPath, 0777, true);

	// 简单的判断父类是否存在
	$superFile = $modelPath . $this->superModelName . '.class.php';
	if (file_exists($superFile)) {
	    $useExpression = '';
	    $superModelName = $this->superModelName;
	} else {
	    $useExpression = 'use Think\Model ;';
	    $superModelName = 'Model';
	}


	ob_start();
	$template = MODULE_PATH . 'Template/Model.php';
	if (file_exists($template)) {
	    require $template;
	} else {
	    $errMsg = '控制器模板文件' . $template . '不存在, 请检查!';
	    $this->error($errMsg);
	    exit($errMsg);
	}

	$content = ob_get_clean();
	$content && file_put_contents($fullPath, "<?php\r\n" . $content);
    }

    /**
     * 表单项的种类
     * 	input, email, number, date, datetime, time,  unique, editor, textarea, select, image, mimage, file, mfile, radio, checkbox, none

     * 验证规则(常见的验证规则), 一个表单可能有多种验证规则 
     * 	require, email、url、 currency、  number,  >=10, <=3, max(10), min(5), [1, 3, 5], unique
     *   
     * 根据注释中这是的规则生成表注释     fileComment require/unique/max(10) ...
     * 根据表的字段类型, 简单的生成注释   fileType  not null integer ...
     * // 生成PHP的表单验证规则
     */
    protected function generateRulesForPHP() {

	$rules = [];
	if ($this->rulesType == 'fileType') {
	    $rules = $this->getRulesByFileTypeForPHP();
	} else if ($this->rulesType == 'fileComment') {
	    $rules = $this->getRulesByCommentForPHP();
	}

	return $rules;
    }

    /**
     * 根据文件类型生成 验证规则
     * 生成JS的表单验证码规则, 目前根据的是jQuery-validate的验证规则
     * @return string
     */
    protected function generateRulesForJs() {

	$rules = [];

	if ($this->rulesType == 'fileType') {
	    $rules = $this->getRulesByFileTypeForJS();
	} else if ($this->rulesType == 'fileComment') {
	    $rules = $this->getRulesByCommentForJS();
	}
	return $rules;
    }

    /**
     * 根据表的注释，生成js的验证规则
     * @return 返回验证规则的数组
     */
    protected function getRulesByCommentForJS() {

	foreach ($this->fullFields as $field => $v) {
	    if ($v['key'] == 'PRI') {
		continue;
	    }
	    $comment = $v['label'] ? : $v['field'];

	    foreach ($v['rule'] as $k => $rule) {
		if ($rule == 'require') {
		    $rules['rules'][$v['field']]['required'] = true;
		    $rules['messages'][$v['field']]['required'] = $comment . "不能为空";
		}

		if ($rule == 'number') {
		    $rules['rules'][$v['field']]['number'] = true;
		    $rules['messages'][$v['field']]['number'] = $comment . "数据有误";
		}

		if ($rule == 'unique') {    // js的唯一性验证，需要调用ajax
		    $rules['rules'][$v['field']]['remote'] = "__CONTROLLER__/check" . ucfirst($v['field']);
		    $rules['messages'][$v['field']]['remote'] = $comment . "已经存在";
		}
	    }
	}

	return $rules;
    }

    /**
     * 根据表的字段类型，生成js的验证规则
     * @return 返回验证规则的数组
     */
    protected function getRulesByFileTypeForJS() {
	foreach ($this->fullFields as $field => $v) {
	    if ($v['key'] == 'PRI') {
		continue;
	    }

	    $comment = $v['comment'] ? : $v['field'];
	    if ($v['null'] == 'NO' && $v['default'] === '') {
		$rules['rules'][$v['field']]['required'] = true;
		$rules['messages'][$v['field']]['required'] = $comment . "不能为空";
	    }

	    // preg_match('/int\(\d+\)/', $aa, $match);
	    if (strpos($v['type'], 'int') !== false) {
		$rules['rules'][$v['field']]['number'] = true;
		$rules['messages'][$v['field']]['number'] = $comment . "数据有误";
	    }

	    if ($v['key'] == 'UNI') {
		$rules['rules'][$v['field']]['remote'] = "__CONTROLLER__/check" . ucfirst($v['field']);
		$rules['messages'][$v['field']]['remote'] = $comment . "已经存在";
	    }
	}

	return $rules;
    }

    /**
     * 根据表的字段类型，生成php的验证规则
     * @return 返回验证规则的数组
     */
    protected function getRulesByFileTypeForPHP() {
	// 生存PHP的表单验证规则
	foreach ($this->fullFields as $field => $v) {
	    if ($v['key'] == 'PRI') {
		continue;
	    }

	    $comment = $v['comment'] ? : $v['field'];
	    if ($v['null'] == 'NO' && $v['default'] === '') {
		$rules[] = "['" . $v['field'] . "', 'require', '" . $comment . "不能为空', self::EXISTS_VALIDATE ], ";
	    }

	    // preg_match('/int\(\d+\)/', $aa, $match);
	    if (strpos($v['type'], 'int') !== false) {
		$rules[] = "['" . $v['field'] . "', 'number', '" . $comment . "必须是数字', self::EXISTS_VALIDATE ], ";
	    }

	    if ($v['key'] == 'UNI') {
		$rules[] = "['" . $v['field'] . "', '', '" . $comment . "已经存在', self::EXISTS_VALIDATE, 'unique', 1], ";
	    }
	}

	return $rules;
    }

    /**
     * 根据表注释，生成php的验证规则
     * @return 返回验证规则的数组
     */
    protected function getRulesByCommentForPHP() {

	// 根据注释生成PHP的表单验证规则
	$rules = array();
	foreach ($this->fullFields as $field => $v) {
	    if ($v['key'] == 'PRI') {
		continue;
	    }
	    $comment = $v['label'] ? : $v['field'];

	    foreach ($v['rule'] as $k => $rule) {
		if ($rule == 'require') {
		    $rules[] = "['" . $v['field'] . "', 'require', '" . $comment . "不能为空', self::EXISTS_VALIDATE ], ";
		}

		if ($rule == 'number') {
		    $rules[] = "['" . $v['field'] . "', 'number', '" . $comment . "必须是数字', self::EXISTS_VALIDATE ], ";
		}

		if ($rule == 'unique') {
		    $rules[] = "['" . $v['field'] . "', '', '" . $comment . "已经存在', self::EXISTS_VALIDATE, 'unique', 1], ";
		}
	    }
	}

	return $rules;
    }

    /**
     * 对数据表中的每个字段进行分析
     * self::analyzeComment 对表字段的注释分析，得出 
     * formItem:表单类型, label:表单label说明, rule:该表单上的验证规则, value 表单的可选项的值, 比如radio/checkbox/select 需要的基础数据
     * sql 语句: SHOW FULL FIELDS FROM TABLENAME
     * keys 是每个字段的 字段名
     * 
     * @return type
     */
    protected function handleFullFields() {
	// 取出表中所有字段的信息
	$db = M($this->tpName);
	$fields = $db->query('SHOW FULL FIELDS FROM ' . $this->tableName);

	$keys = array_column($fields, 'field');

	$fullFields = array_combine($keys, $fields);

	foreach ($fullFields as $field => $v) {
	    $fullFields[$field] = array_merge($v, $this->analyzeComment($v));
	}

	$this->fullFields = $fullFields;

	return $fullFields;
    }

    /**
     * 分析表的字段注释, 产生对应的表单 
     *  formItem : input/select 等 (没有设置 为空) 
     *  label 表单说明
     *  rule 表单的验证规则, 可以有多个规则, 数组
     *  value 表单的可选项的值, 比如radio/checkbox/select 需要的基础数据
     *  
     * @param array $fieldInfo
     * @return array (size=4)
     * 	   formItem' => string 'select' (length=6)
     * 	   label' => string '是否显示' (length=12)
     * 	   rule' => 
     * 	      array (size=0)
     * 	         empty
     * 	   value' => 
     * 	     array (size=5)
     * 	       'input' => string '文本输入' (length=12)
     * 	       'select' => string '下拉选择' (length=12)
     * 	       'checkbox' => string '多选' (length=6)
     * 	       'textarea' => string '大段内容' (length=12)
     * 	       'radio' => string '单选' (length=6)
     */
    protected function analyzeComment(array $fieldInfo) {

	// 对注释进行 规范性的处理
	$comment = strtolower(trim($fieldInfo['comment']));
	$comment = preg_replace('/\s+/', ' ', $comment);  // 连续多个空白字符变成一个
	$comment = preg_replace('/[\s]/', '', $comment);  // 将[]中的空格剔除
	$comment = str_replace(array('，', '：', '【', '】'), array(',', ':', '[', ']'), $comment); // 中英文符号的替换
	$comment = str_replace([', ', ': ', '[]'], [',', ':', ''], $comment);
	$arr = explode(' ', $comment);


	// 冒号表示value值是键值对 并只有一个元素时的特殊情况
	if (count($arr) <= 1 && preg_match('/[a-z\d]+:/i', $comment, $match)) {
	    $arr[0] = strstr($comment, $match[0], true);
	    $arr[1] = strstr($comment, $match[0]);
	}

	$label = $arr[0];

	// 匹配 【中括号】 中的 类型, 比如 none, select, 如果有匹配 说明设置了表单类型 
	preg_match('/\[([\/\+\(\),\d+\[\] \w]*)\]/', $label, $match);
	if ($match && $match[1]) {
	    $form = $match[1];
	    // 去掉所有的空格，便于分隔， 之前已经剔除了多余的空格了
	    $tmpArr = explode('/', str_replace(' ', '', $form));
	    $formItem = isset($tmpArr[0]) ? $tmpArr[0] : null;

	    // isset($tmpArr[1])代表存在验证规则, 多个验证规则，使用 + 分隔
	    $rule = isset($tmpArr[1]) ? explode('+', $tmpArr[1]) : null;

	    // 获得表单的label 数据 将中括号及其中括号中的 类型和验证规则 剔除
	    // eg: 将[select/require] 字符串剔除
	    $label = str_replace($match[0], '', $label);
	}


	$value = '';
	// 含有冒号表示value值是键值对, 主要用于 select/radio/checkbox, 其中多条键值对 使用逗号分隔
	if (isset($arr[1]) && strpos($arr[1], ':')) { // 含有冒号表示: select/radio 
	    $optionData = explode(',', $arr[1]);
	    foreach ($optionData as $k => $v) {
		$tmpArr = explode(':', $v);
		$value[$tmpArr[0]] = $tmpArr[1];
	    }
	} else if (isset($arr[1])) {
	    $value = '';     // 普通的input 默认值 '' or $fieldInfo['default']
	}

	// 从中括号中获取 表单的类型 比如: input/select, 如果表注释没有设置类型 代表默认是input
	if (!isset($formItem)) {
	    $formItem = '';  // 没有设置表单类型的，可以默认设置为 input
	}

	if (!isset($rule)) {
	    $rule = [];
	}

	$var = [
	    'formItem' => $formItem,
	    'label' => $label? : $fieldInfo['field'],
	    'rule' => $rule, // 可以有多个验证规则，是一个数组
	    'value' => $value,
	];


	return $var;
    }

    /**
     * 获取表的注释
     * @param type $tableName
     * @return type
     */
    protected function getTableComment($tableName = null) {

	$tableName = $tableName ? $tableName : $this->tableName;

	$db = M($this->tpName);
	$this->pk = $db->getPk();

	$dbName = C('DB_NAME');

	// $tables = $db->execute('use information_schema');
	$sql = "SELECT TABLE_COMMENT as comment FROM `information_schema`.`TABLES` WHERE TABLE_SCHEMA='{$dbName}' and TABLE_NAME= '{$tableName}'";
	$data = $db->query($sql);

	return $data[0]['comment'] ? $data[0]['comment'] : $this->tableName;
    }

    /**
     * 检查用户传递过来的名称是否符合TP规范, 
     * php 中标识符的命名规范:  所谓标识符是指变量的名称, 函数与类的名称也是标识符。
     * 	    1) 标识符可以是任意长度的字母、数字、下划线，且不得以数字开头。
     * 	    2) PHP中标识符是区分大小写的，但函数名是个例外。
     * 	    3) 变量名可以与函数名相同。但应尽量避免。
     * 	    4) 不能创建与已有函数同名的函数。
     * 	    // 暂定: 模块名称只能是纯字母
     * @param type $moduleName
     * @return type
     */
    protected function checkModuleName($moduleName) {
	$int = preg_match('/^[a-z]+$/i', $moduleName, $match);
	return (bool) $int;
    }

    /**
     * 判断模型的文件夹是否存在， 必须大小写匹配, 命名空间中有使用模块名，区分大小写
     * @param type $modelName
     */
    protected function moduleFolderNameisExists($moduleName) {
	$path = APP_PATH . $moduleName;
	if (file_exists($path)) {
	    $ret = PHP_OS == 'WINNT' ? basename(realpath($path)) === basename($path) : true;
	    return $ret;
	}
	return false;
    }

    /**
     * 初始化数据的方法, 为该类的属性设置相应的数据
     */
    protected function initData() {

	// moduleName 模型名称，严格区分大小写
	$moduleName = I('post.mName');

	if (!$this->checkModuleName($moduleName)) {
	    $errMsg = '模块名称<span style="color:red">' . $moduleName . '</span>不合法！';
	    $this->error($errMsg);
	}

	if (!$this->moduleFolderNameisExists($moduleName)) {
	    $errMsg = '目录<span style="color:red">' . APP_PATH . $moduleName . '</span>不存在, 注意区分大小写！';
	    $this->error($errMsg, '', 30);
	}

	// 表名
	$tableName = I('post.tName');

	// 表名对应 TP中的模型名称
	$tpName = $this->tableName2TpName($tableName);


	/**
	  // 表注释在 information_schema 库的 TABLES 表中TABLE_COMMENT 字段里
	  --查询某一张表的
	  use information_schema;
	  select * from TABLES where TABLE_SCHEMA='DBNAME' and TABLE_NAME= 'TABLENAME';
	 * 
	  // 或者使用：show table status
	  TP模型名 -> 获得表名 -> 主键  -> 表注释
	 */
	$this->moduleName = $moduleName;    // 模块名称
	$this->tpName = $tpName;
	$this->tableName = $tableName;
	$this->tableComment = $this->getTableComment();
	$this->fullFields = $this->handleFullFields();


	// showFields 需要显示到列表页的字段 (一般不会将所有的字段显示在列表页)
	$showFields[$this->pk] = '主键ID'; // 添加主键
	$showFields = array_merge($showFields, I('post.showFields'));
	$this->showFields = $showFields;
    }

    // 生成视图文件 
    protected function createView() {
	$moduleName = $this->moduleName;
	$tpName = $this->tpName;
	$viewLayer = C('DEFAULT_V_LAYER'); //  默认的视图层名称

	isset($_POST['createOptions']['add']) && $this->createSpecificView('add');
	isset($_POST['createOptions']['upd']) && $this->createSpecificView('upd');
	isset($_POST['createOptions']['index']) && $this->createSpecificView('index');

	return;
    }

    // 生成指定的文件名
    protected function createSpecificView($name) {
	$moduleName = $this->moduleName;
	$tpName = $this->tpName;
	$fields = $this->showFields; // 字段名
	$viewLayer = C('DEFAULT_V_LAYER'); //  默认的视图层名称

	/*	 * ************************* 生成视图文件   ********************** */
	$viweSuffix = C('TMPL_TEMPLATE_SUFFIX');    // 默认模板文件后缀
	$fileDepr = C('TMPL_FILE_DEPR');     // 模板文件CONTROLLER_NAME与ACTION_NAME之间的分割符

	if ($name == 'add' || $name == 'upd') {      // 添加/修改需要进行JS的表单验证
	    $rules = $this->generateRulesForJs();
	    #$this->rulesForJS = $jsValicate ;

	    if ($name == 'add') {
		$jsValicate = jsonFormat($rules);
	    }
	    if ($name == 'upd') {
		$jsValicate = json_encode($rules, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	    }
	}

	// 生成视图
	$fullPath = APP_PATH . $moduleName . '/View/' . $tpName . $fileDepr . $name . $viweSuffix;
	$dir = dirname($fullPath);
	is_dir($dir) || mkdir($dir, 0777, true);
	ob_start();
	$template = MODULE_PATH . 'Template/' . $name . '.php';
	if (file_exists($template)) {
	    print_r($template);
	    require $template;
	} else {
	    $errMsg = $name . '视图模板文件' . $template . '不存在, 请检查!';
	    $this->error($errMsg);
	    exit($errMsg);
	}
	$content = ob_get_clean();

	if ($content) {
	    // 匹配目标路径
	    $cssHrefArray = self::matchCssLink($content);
	    $jsSrcArray  = self::matchJsSrcScript($content);
	    
	    // 推送资源文件
	    self::pushFiles($cssHrefArray, $this->resourceDestDir);
	    self::pushFiles($jsSrcArray, $this->resourceDestDir);
	}
	$content && file_
	isset($_POST['createOptions']['add']) && $this->createSpecificView('add');
	isset($_POST['createOptions']['upd']) && $this->createSpecificView('upd');
	isset($_POST['createOptions']['index']) && $this->createSpecificView('index');

	return;
    }

    // 生成指定的文件名
    protected function createSpecificView($name) {
	$moduleName = $this->moduleName;
	$tpName = $this->tpName;
	$fields = $this->showFields; // 字段名
	$viewLayer = C('DEFAULT_V_LAYER'); //  默认的视图层名称

	/*	 * ************************* 生成视图文件   ********************** */
	$viweSuffix = C('TMPL_TEMPLATE_SUFFIX');    // 默认模板文件后缀
	$fileDepr = C('TMPL_FILE_DEPR');     // 模板文件CONTROLLER_NAME与ACTION_NAME之间的分割符

	if ($name == 'add' || $name == 'upd') {      // 添加/修改需要进行JS的表单验证
	    $rules = $this->generateRulesForJs();
	    #$this->rulesForJS = $jsValicate ;

	    if ($name == 'add') {
		$jsValicate = jsonFormat($rules);
	    }
	    if ($name == 'upd') {
		$jsValicate = json_encode($rules, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	    }
	}

	// 生成视图
	$fullPath = APP_PATH . $moduleName . '/View/' . $tpName . $fileDepr . $name . $viweSuffix;
	$dir = dirname($fullPath);
	is_dir($dir) || mkdir($dir, 0777, true);
	ob_start();
	$template = MODULE_PATH . 'Template/' . $name . '.php';
	if (file_exists($template)) {
	    print_r($template);
	    require $template;
	} else {
	    $errMsg = $name . '视图模板文件' . $template . '不存在, 请检查!';
	    $this->error($errMsg);
	    exit($errMsg);
	}
	$content = ob_get_clean();
put_contents($fullPath, $content);
    }

    /**
     * 将原文件推送文件到目标文件夹
     * @param  $srcs string | array
     * @param type $dest
     * @return boolean
     */
    protected function pushFiles($srcs, $dest) {
	$dir = $this->resourceSrcDir;
	if (is_array($srcs)) {
	    foreach ($srcs as $src) {
		$srcFile = $dir . $src;
		$destFile = $dest . $src;
		$this->copyFile($srcFile, $destFile);
	    }
	} elseif (is_string($srcs)) {
	    $srcFile = $dir . $srcs;
	    $destFile = $dest . $srcs;
	    $this->copyFile($srcFile, $destFile);
	}
    }

    /**
     * 拷贝文件到指定的目录， 保持目录结构一致
     * @param type $srcFile  源文件
     * @param type $destFile 目标文件
     * @return boolean
     */
    protected function copyFile($srcFile, $destFile) {

	if (!file_exists_case($srcFile)) {
	    echo '<h1>源文件 <span style="color:red;">' . $srcFile . '</span>不存在 on line ' . __LINE__ . '</h1>';
	    return false;
	} else {
	    // 对目标文件做处理
	    $dirname = dirname($destFile) . '/';
	    $basename = basename($destFile);
	    is_dir($dirname) || mkdir($dirname, 0777, true);

	    // 文件不存在就进行推送
	    if (!file_exists_case($destFile)) {
		copy($srcFile, $destFile);
	    }
	    return true;
	}
    }

    /**
     * 判断一个文件/文件夹是否存在， 区分大小写
     * @param type $path
     * @return boolean
     */
    protected function file_exists_case($path) {
	if (file_exists($path)) {
	    $ret = PHP_OS == 'WINNT' ? basename(realpath($path)) === basename($path) : true;
	    return $ret;
	}
	return false;
    }

    /**
     * 查找两个字符串之间的字符串, 非贪婪匹配
     */
    protected  function getBetweenStr($str, $startStr = '', $endStr = '') {

	$findStartPos = strpos($str, $startStr);
	if ($findStartPos === FALSE) {
	    return false;
	}
	$startStrLen = strlen($startStr);
	$startX = $findStartPos + $startStrLen;
	$findEndPos = strpos($str, $endStr, $startX);

	if ($findEndPos === FALSE) {
	    return false;
	}

	$len = $findEndPos - $startX;
	$retStr = substr($str, $startX, $len);

	return $retStr;
    }

    /**
     * 匹配css的link标签的href属性
     * @param type $content 网页的html字符串
     * @return type
     */
    protected function matchCssLink($content) {
	$pattern = '/<link(.*?)>/is';   // s包括换行符, i不区分大小写
	$cssHrefArray = array();

	$int = preg_match_all($pattern, $content, $match);

	if ($int) {  // 
	    foreach ($match[0] as $k => $v) {
		$href = $this->getBetweenStr($v, 'href="', '"');
		$href && $cssHrefArray[] = str_replace('__PUBLIC__/', '', $href);
	    }
	}

	return $cssHrefArray;
    }


    /**
     * 匹配js文件的src属性
     * @param type $content 网页的html字符串
     * @return type
     */
    protected  function matchJsSrcScript($content) {
	$pattern = '/<script[^>]*?>(.*?)<\/script>/is';   // s包括换行符, i不区分大小写
	$jsSrcArray = array();

	$int = preg_match_all($pattern, $content, $match);
	if ($int) {
	    foreach ($match[0] as $k => $v) {
		$src = $this->getBetweenStr($v, 'src="', '"');
		$src && $jsSrcArray[] = str_replace('__PUBLIC__/', '', $src);
	    }
	}
	return $jsSrcArray;
    }
}
