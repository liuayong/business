<?php
namespace MangerSystem\Controller ;

use Think\Controller;
use Think\Verify;

/**
 * 后台登陆控制器
 * Class LoginController
 * @package MangerSystem\Controller
 */
class LoginController extends  Controller {

    protected function _initialize() {
	false && ipLimit();
    }
    
    
    public  function  index() {
        if(IS_POST) {
            $AdminModel = D('Admin');
            if($AdminModel->create('', 4)) {
                if(($loginRet = $AdminModel->login()) === TRUE ) {
                    $data = [ 'code' => 0, 'msg'  => '登录成功', 'data' => ''];
                } else if($loginRet == $AdminModel::USER_ACCOUNT_ERROR) {
                    $data = [ 'code' => 1, 'msg'  => '用户名不正确', 'data' => ''];
                } else if($loginRet == $AdminModel::USER_PWD_ERROR) {
                    $data = [ 'code' => 1, 'msg'  => '密码不正确', 'data' => ''];
                } else if($loginRet == $AdminModel::USER_FORBIDDEN) {
                    $data = [ 'code' => 1, 'msg'  => '用户已经失效,请联系管理员激活', 'data' => ''];
                } else {
                    $data = [ 'code' => 1, 'msg'  => '未知的错误,请联系管理员', 'data' => ''];
                }
            } else {
                $errorMsg = $AdminModel->getError();
                $data = [ 'code' => 1, 'msg'  => $errorMsg.' !!!' , 'data' =>''];
            }
            $this->ajaxReturn($data);
        } else {
	    $isLogin = session('?' . 'uid') && session('?' . 'uname');
	    $isLogin = $isLogin || $_COOKIE['auth'];
	    if($isLogin) 
		return $this->redirect ( 'Index/index' );
            $this->display();
        }
    }

    /**
     * 验证码
     */
    public function verify() {
        $Verify = new Verify([
            'length'	=> 4,
            'imageW'	=> 150,
            'imageH'	=> 38,
            'fontSize'	=> 18,
            'useNoise'    =>    false, // 关闭验证码杂点
        ]);
        $Verify->entry();
    }
    
    public function logout() {
	session(NULL);
	cookie('auth', null);
	S('menu-' . session('uid'), null);
	$this->redirect('Login/index');
    }
    
     // Uploadify 上传图片
    function upload2() {
	
	C('show_PAGE_TRACE', false);
	$defaulConfig = [
	    'maxSize' => 5 * 1000 * 1000, // 设置上传图片的大小
	    'exts' => array('jpg', 'gif', 'png', 'jpeg'), // 设置附件上传类型 
	    'rootPath' => './Uploads/', //保存根路径
	];

	$upload = new \Think\Upload($defaulConfig);
	$info = $upload->upload();

	if ($fileKey === null) {
	    $fileKeys = array_keys($_FILES);
	    $fileKey = current($fileKeys);
	}
	
	$ret = [] ;
	
	// 没有返回图片的大小(宽高)
	if ($info) {
	    $imgPath = $info[$fileKey]['savepath'] . $info[$fileKey]['savename'];
	    $imgFullPath = __ROOT__ . trim($defaulConfig['rootPath'], '.') . $imgPath;
	    
	    $ret['imgFullPath'] = $imgFullPath ;
	    $ret['imgPath'] = $imgPath ;
	    $ret['info'] = $info[$fileKey] ;
	    $ret['status'] = 1 ;
	} else {
	    $error = $upload->getError();
	    
	    $ret['data'] = null ;
	    $ret['info'] = $error ;
	    $ret['status'] = 0 ;
	}
	echo json_encode($ret);
    }
    
}