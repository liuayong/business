<?php

namespace Up\Controller;

use Think\Controller;
use Common\Components\UploadTool;
use Common\Components\ImageTool;

class IndexController extends Controller {

    protected $map = array(
	'1' => 'onefile-normal',
	'2' => 'onefile-ajax',
	'3' => 'manyfile-ajax',
    );

    protected function _initialize() {
	C('show_PAGE_TRACE', false);
    }

    public function index() {
	$this->assign('map', $this->map);
	$this->display();
    }

    public function up() {
	$model = I('mode', 1, 'intval');
	$file = $this->map[$model];
	$this->display($file);
    }

    /**
     * 添加内容
     */
    public function post() {
	if (IS_POST) {

	    if (!empty($_FILES)) {    // 含有文件上传
		reset($_FILES);
		$key = key($_FILES);
		$savepath = strtolower(CONTROLLER_NAME) . '/';
	    }

	    $fileInfo = UploadTool::upload($_FILES[$key], array('savePath' => 'services/'));
	    $widths = I('post.width');
	    $heights = I('post.height');

	    if ($fileInfo['code'] == 0) {
		$fileInfo['domain'] = DOMAIN; // 域名

		$AttachModel = D('Attach');
		$data = [
		    'user_id' => intval($adminiUserId),
		    'file_ext' => $fileInfo['ext'],
		    'file_mime' => $fileInfo['mime'],
		    'file_size' => $fileInfo['size'],
		    'real_name' => $fileInfo['name'],
		    'scope' => 'content', // 分类, 属于内容是上传的文件
		    'save_path' => $fileInfo['savepath'], // 存放到数据库中的目录
		    'save_name' => $fileInfo['savename'],
		    'create_time' => time()
		];
		$AttachModel->add($data);

		// 需要生成缩略图
		if (isset($_POST['thumb']) && $_POST['thumb']) {
		    foreach ($widths as $k => $width) {
			$height = $heights[$k];
			if (is_numeric($width) && $width && is_numeric($height) && $height) {
			    // 生成多张缩略图
			    $thumbConfig = array('thumbPrefix' => 'thumb_' . $width . 'x' . $height . '_', 'thumbSize' => array($width, $height), 'thumbType' => 2);
			    $thumbInfo = ImageTool::thumb($fileInfo['fullPath'], $thumbConfig);
			    $key = $thumbConfig['thumbPrefix'];
			    $fileInfo[$key . 'UrlPath'] = $thumbInfo['urlPath'];
			}
		    }
		}
		echo json_encode($fileInfo, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	    } else {       // 上传文件失败, 是否需要阻止程序的继续执行
		$errMsg = $fileInfo['msg'];
		$retData = ['code' => 1, 'msg' => $errMsg, 'class' => 'error', 'return_url' => ''];
		echo json_encode($retData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	    }
	}
    }

    // ajax单文件上传， 需要借助ajaxFileUpload插件
    public function ajaxUploadFile() {

	// header('Content-type:text/json');  
	if (IS_POST) {
	    $savepath = strtolower(CONTROLLER_NAME) . '/';
	    if (!empty($_FILES)) {    // 含有文件上传
		reset($_FILES);
		$key = key($_FILES);
	    }
	    $fileInfo = UploadTool::upload($_FILES[$key], array('savePath' => 'services/'));
	    echo json_encode($fileInfo);
	}
    }

    // Uploadify 删除图片
    public function delUpdImg() {
	/* 删除图片 */
	$t = urldecode(I('post.path'));
	$src = './Uploads/' . $t;
	@unlink($src);

	// 如果有缩略图需要删掉缩略图
	// @unlink(str_replace($str,'t_'.$str,$src));
    }

    /**
     * 显示Uploadify的上传组件
     */
    public function uploadify() {
	$this->display();
    }

    /**
     * 处理上传的功能， 
     */
    public function basicExecute() {
	if (IS_POST) {
	    $adminiUserId = session(getSessionUidKey());
	    // 'imgFile' reset($_FILES); $key = key($_FILES);
	    reset($_FILES);
	    $key = key($_FILES);
	    $file = UploadTool::upload($_FILES[$key], array('savePath' => 'services/'));

	    // 判断是否开启 生成缩略图
	    if ($file['code'] == 0) {
		$AttachModel = D('Attach');
		$data = [
		    'user_id' => intval($adminiUserId),
		    'file_ext' => $file['ext'],
		    'file_mime' => $file['mime'],
		    'file_size' => $file['size'],
		    'real_name' => $file['name'],
		    'scope' => 'content', // 分类, 属于内容是上传的文件
		    'save_path' => $file['savepath'], // 存放到数据库中的目录
		    'save_name' => $file['savename'],
		    'create_time' => time()
		];

		if ($insert_id = $AttachModel->add($data)) {
		    $retData = array('state' => 'success', 'fileId' => $insert_id,
			'message' => '上传成功', 'file' => $file['savepath']);
		} else {
		    @unlink(UP_DIR_NAME . '/' . $file['savepath']); // 删除该上传文件
		    $retData = array('state' => 'error', 'message' => '上传错误: ' . $AttachModel->getError());
		}
		exit(json_encode($retData, JSON_UNESCAPED_UNICODE));
	    } else {
		exit(json_encode(array('state' => 'error', 'message' => '上传错误: ' . $file['msg']), JSON_UNESCAPED_UNICODE));
	    }
	}
    }

    /**
     * 删除上传的文件, (上传的文件已经入库， 需要从数据库中删除)
     */
    public function remove() {
	$imageId = I('post.imageId', 0, 'intval');
	$AttachModel = D('Attach');
	$attach = $AttachModel->field(['attach_id', 'save_path', 'thumb_path'])->find($imageId);

	if ($attach) {
	    // 删除磁盘上的文件
	    $fDir = './' . UP_DIR_NAME . '/';
	    file_exists($fDir . $attach['save_path']) && @unlink($fDir . $attach['save_path']);
	    file_exists($fDir . $attach['thumb_path']) && @unlink($fDir . $attach['thumb_path']);
	    $AttachModel->delete($imageId);
	    $var['code'] = 0;
	    $var['message'] = '删除成功';
	} else {
	    $var['code'] = 1;
	    $var['message'] = '失败：此图已经没有了';
	}
	exit(json_encode($var));
    }

}
