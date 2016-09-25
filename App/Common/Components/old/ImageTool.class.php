<?php

namespace  Common\old\Components ;

// 图片处理类 (水印，缩略图，验证码等功能 )
class ImageTool {
	public static $error_info = '默认的';		//	记录错误信息

	/**
	 * 获得图像的信息
	 * @param $image 传递过来的图像文件
	 * @return mixed bool(失败时,false)/array(成功时, array图像的信息)
	 */
	public static function imageInfo($image)  {
		if(!file_exists($image)) {
			self::$error_info = $image. ' 图像文件不存在!';
			return false;
		}
		$img_arr = @getimagesize($image);	// Notice: getimagesize(): Read error! 
		if($img_arr == false) {
			self::$error_info = $image. ' 不是有效的图像文件!';
			return false;
		}
		
		$img_info = array();
		$img_info['width'] = $img_arr[0];
		$img_info['height'] = $img_arr[1];
		$img_info['ext'] = ltrim(strrchr($img_arr['mime'], '/'), '/');

		return $img_info;
	}
	
	/**
	 * 给目标图片上添加水印
	 * @param $dst  目标图像的文件路径 背景图
	 * @param $src  源图像文件路径 水印图
	 * @param $save 保存水印图的路径
	 * @param $pos  打水印的位置(1: 左上角, 2:右上角 ...)
	 * @param $alpha 透明度, 打水印图的透明度
	 * @return bool true:添加水印成功 false:添加水印失败
	 */
	public static function water($dst, $src, $save=null, $pos=2, $alpha=50) {
		if(!file_exists($dst) || !file_exists($src)) {
			self::$error_info = '目标图片或者水印图片文件不存在!';
			return false;
		}
		
		$dst_info = self::imageInfo($dst);		// 目标图片信息
		$d_w = $dst_info['width'];				// 目标图片宽度
		$d_h = $dst_info['height'];				// 目标图片高度
		$d_create_func = "imagecreatefrom". $dst_info['ext'];		// 根据扩展名选择创建目标图片画布的函数 
		

		$src_info = self::imageInfo($src);		// 水印图片信息
		$s_h = $src_info['height'];				// 水印图片高度
		$s_w = $src_info['width'];				// 水印图片宽度
		$s_create_func = "imagecreatefrom".$src_info['ext'];		// 根据扩展名选择创建水印图片画布的函数 

		if($s_w > $d_w || $s_h > $d_h) {
			self::$error_info = '水印图片的尺寸不能超过目标图片的尺寸';
			return false;
		}

		if(!function_exists($s_create_func) || !function_exists($d_create_func) ) {
			self::$error_info = "该图片类型($s_create_func / $d_create_func)创建画布的函数不存在!";
			return false;
		}
		
		/*********** 开始生产水印图片 : imagecopymerge *************/
		$dst_img = $d_create_func($dst);	// 生成目标图片和水印图片的画布
		$src_img = $s_create_func($src);
		
		switch($pos)	// 根据$pos参数 确定生产水印图片的位置
		{
			case 1: // 左上角
				$d_posx = 0;
				$d_posy = 0;
			break;
			case 2: // 右上角
				$d_posx = $d_w - $s_w;
				$d_posy = 0;
			break;
			case 3: // 右下角
				$d_posx = $d_w - $s_w;
				$d_posy = $d_h - $s_h;
			break;
			case 4: // 左下角
				$d_posx = 0;
				$d_posy = $d_h - $s_h;
			break;
		}
		
		// 画图
		imagecopymerge($dst_img, $src_img, $d_posx, $d_posy, 0, 0, $s_w, $s_h, $alpha);	

		// 保存目标图片
		if(!$save) {	// 没有传递路径 那么就将添加水印后的目标图片替换掉原始的目标图片
			$save = $dst;
			unlink($dst);
		}
		$save_func = "image" . $dst_info['ext'];
		$save_func($dst_img, $save);

		// 销毁图片资源
		imagedestroy($dst_img);
		imagedestroy($src_img);

		return true;
	}
	
	/**
	 * 生成相应的缩略图
	 * @param $src    源图片
	 * @param $save   缩略图的路径
	 * @param $width  缩略图的宽度
	 * @param $height 缩略图的高度
	 * @return bool ture: 成功生成缩略图 false:未能生成缩略图
	 * 注意: 我们是需要等比例缩放, 两边留白, 保证缩略图不变形 
	 *       所以必须使用宽或高中较小的比例 
	 */
	public static function thumb($src, $save=null, $width=200, $height=200) {
		if(!file_exists($src)) {
			self::$error_info = '图片文件'.$src.'不存在!';
			return false;
		}
		$src_info = self::imageInfo($src);
		$s_w = $src_info['width'];				// 源图片 宽度
		$s_h = $src_info['height'];				// 源图片 高度
		$s_create_func = 'imagecreatefrom' . $src_info['ext'];	// 根据扩展名生成选择创建源图片画布的函数

		// 计算缩放比例
		$calc = min($width / $s_w, $height / $s_h);

		/*********** 生成缩略图 : imagecopyresampled *************/
		// 创建画布
		$thu_img = imagecreatetruecolor($width, $height);
		$src_img = $s_create_func($src);

		// 分配颜色 留白
		$white = imagecolorallocate($thu_img, 255, 255, 255);

		// 进行白色的填充
		imagefill($thu_img, 0, 0, $white);

		// 生成缩略图
		
		// 根据比例计算缩略图的图片大小 
		$d_w = (int)($s_w * $calc);
		$d_h = (int)($s_h * $calc);

		// 根据比例计算出缩略图的位置
		$thu_x = (int)( ($width -  $s_w * $calc) / 2 );
		$thu_y = (int)( ($height - $s_h * $calc) / 2 );

		imagecopyresampled($thu_img, $src_img, $thu_x, $thu_y, 0, 0, $d_w, $d_h, $s_w, $s_h);
		
		// 输出缩略图 
		if(!$save) {		// 没有指定路径就将源图片替换
			$save = $src;
			unlink($src);
		}
		$save_func = 'image' .  $src_info['ext'];
		$save_func($thu_img, $save);

		// 销毁图片资源
		imagedestroy($thu_img);
		imagedestroy($src_img);

		return true;
	}
	
	
	/**
	 * 产生验证码
	 * $param $width 验证码图片的宽度
	 * $param $width 验证码图片的高度
	 * $param $border 验证码图片的是否需要边框
	 * return string 返回验证码的码值 需要保存在session个中
	 */ 
	public static function captcha($width = 60, $height = 25, $border=true) {
		// 生成画布
		$img = imagecreatetruecolor($width, $height);

		// 分配颜色
		$gray = imagecolorallocate($img, 200, 200,200);	// 浅灰色背景
		// 随机线条颜色
		$line1 = imagecolorallocate($img, mt_rand(0,20), mt_rand(0,255), mt_rand(0,255));
		$line2 = imagecolorallocate($img, mt_rand(0,30), mt_rand(0,255), mt_rand(0,255));
		$line3 = imagecolorallocate($img, mt_rand(0,40), mt_rand(0,255), mt_rand(0,255));

		// 准备码值	
		$str = "abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ123456789";		
		$str_code = substr(str_shuffle($str), 0, 4);
		
		//session_start();	// 开启session, 将验证码码值写入到session中
		//$_SESSION['code'] = $str_code;

		/*********** 准备画图  *****************/
		// 灰色背景填充 imagefill
		imagefill($img, 0, 0, $gray);	
	
		// 根据条件选择是否 绘制黑色边框
		if($border == true) {
			$black = imagecolorallocate($img, 0,0,0);
			imagerectangle($img, 0, 0, $width-1, $height-1, $black);
		}


		// 随机画干扰线 imageline
		imageline($img, mt_rand(2, 10), mt_rand(3, $height-3), mt_rand($width-8, $width-2), mt_rand(3, $height-3), $line1);
		imageline($img, mt_rand(2, 10), mt_rand(3, $height-3), mt_rand($width-8, $width-2), mt_rand(3, $height-3), $line2);
		imageline($img, mt_rand(2, 10), mt_rand(3, $height-3), mt_rand($width-8, $width-2), mt_rand(3, $height-3), $line3);

		// 随机打雪花进行干扰 imagestring
		for($i=0; $i<50; $i++) {
			$color = imagecolorallocate($img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
			imagestring($img, 5, mt_rand(5, $width-10), mt_rand(0, $height-15), "*", $color);
		}
		
		// 写上验证码 imgagestring
		$color = imagecolorallocate($img, mt_rand(0, 125), mt_rand(0, 125), mt_rand(0,125));
		imagestring($img, 5, 12, 3, $str_code, $color);
	
		/************  输出图片 ****************/
		header('Content-Type: image/png');
		imagepng($img);

		/********** 销毁图像资源 **************/
		imagedestroy($img);

		return $str_code;
	}

}
