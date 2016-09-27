<?php

namespace  Common\Components ;

class UpTool {
	protected $allowSize = 1;	// 单位是 MB
	protected $allowType = 'jpg,jpeg,png,gif';
	
	protected $errno = 0 ;			// 错误的代码
	protected $error = array(		// 存储上传反馈信息
		0 => '无错误',
		1 => '上传的文件超出了系统的设置',
		2 => '上传文件的大小超过了 HTML 表单允许的最大值',
		3 => '文件只有部分被上传',
		4 => '没有文件被上传',
		6 => '找不到临时文件夹',
		7 => '文件写入失败',
		8 => '文件后缀不符合要求',
		9 => '文件大小超出了文件上传类的限制范围',
		10 => '创建目录失败',
		11 => ' 移动文件时出错',
	);
	/**
	 * 判断是否符合上传的大小限制
	 * @param $size 上传文件的大小 单位 Byte
	 */
	protected function is_allowSize($size) {
		return $size - $this->allowSize * 102 * 1024 <=0 ;
	}
	
	/**
	 * 判断是否符合上传的类型限制
	 * @param $fileType 文件的类型
	 */
	protected function is_allowType($fileType) {
		$fileType = strtolower(ltrim($fileType, '.'));		// 去掉左边的"." // 不区分大小写
		$allowType = strtolower($this->allowType);			// 不区分大小写
		return in_array($fileType, explode(',', $allowType));	
	}

	/**
	 * 获取通过文件名来获得文件的后缀
	 * @param $filename 文件名
	 */
	protected function getExt($filename) {
		$tmp = explode('.', $filename);
		return end($tmp);
	} 
	
	protected function mk_dir() {
		$dir = ROOT . 'data/images/'. date('Y/md', time());
		if(is_dir($dir) || mkdir($dir, 0777, true)) {
			return $dir;
		} else {
			return false;	// 创建失败
		}
	}

	/** 
	 * 生成随机的文件名
	 * @parma $length 文件名的长度 默认是6个
	 */
	protected function rand_name($length = 6) {
		//$arr = array_merge(range(1,9));
		$str = 'abcdefghijkmnpqrstuvwxyz23456789';
		return substr(str_shuffle($str), 0, $length);
	}

	/**
	 * 对允许的类型开放公共的方法进行设置
	 * @param $exts 允许的后缀类型 多种后缀使用","分隔
	 */
	public function setExt($exts) {
		$exts = str_replace('.', '', $exts);   // 去掉所有的"."
		$this->allowType .= ',' . $exts;	
		var_dump($this->allowType);
	}
	/**
	 * 对允许的上传文件的大小开发公共方法进行设置
	 * @param $maxSize 上传文件大小的最大值 单位 MB
	 */ 
	public function setSize($maxSize) {
		$this->allowSize = $maxSize;
	}
	
	/**
	 * 获得错误信息
	 */
	public function getErr() {
		return $this->error[$this->errno];
	}
	
	/**
	 * 实现文件上传的功能
	 * @param  $key是表单中文件域的名称
	 */
	public function up($key) {
		
		// 表单域的名称不正确，直接报错
		if(!isset($_FILES[$key])) {
			return false;
		}

		$f = $_FILES[$key];

		
		// 检验文件上传是否成功
		if($f['error']) {
			$this->errno = $f['error'];
			return false;
		}

		// 获取上传文件的文件后缀
		$ext = $this->getExt($f['name']);
		
		// 检测后缀
		if(!$this->is_allowType($ext)) {
			$this->errno = 8;
			return false;
		}

		// 检测大小 
		if(!$this->is_allowSize($f['size'])) {
			$this->errno = 9;
			return false;
		}

		// 创建目录
		$dir = $this->mk_dir();
		if($dir == false) {
			$this->errno = 10;
			return false;
		}
		
		// 生成随机文件名
		$newname = $this->rand_name() . '.'. $ext;
		$dir = $dir . '/' . $newname;
		
		// 移动
		if(!move_uploaded_file($f['tmp_name'], $dir)) {
			$this->errno = 11;		// 移动文件时出错
			return false;
		}

		$dir = str_replace(ROOT, '', $dir);		// 只存储相对路径 便于移植
		return $dir;

	}

}
