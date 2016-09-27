<?php

namespace Home\Controller;

/**
 * 前台用户控制器
 */
class UserController extends BaseController {
    
    // 一个映射关系
    protected $map = array(
        'tel' => 'user_tel',
        'username' => 'username',
        'email' => 'user_email',
    );

    protected function _initialize() {
	parent::_initialize();
    }

    /**
     * 前台用户登录
     */
    public function login() {
        if (IS_POST) {
            $UserModel = D('MangerSystem/User');
            $post = I('post.');
            if (!$this->check_verify($post['code'])) {
                #$this->error('验证码不正确');
            }
            $type = I('post.type');
            if (array_key_exists($post['type'], $this->map)) {
                $key = $this->map[$post['type']];
                $post[$key] = $post['user_id'];
            }
            $post = $UserModel->create($post);
            $UserModel->data($post);
            if ($UserModel->login() === TRUE) {
                $this->success('登录成功');
            } else {
                $errMsg = $UserModel->getError();
                $this->error('登录失败: ' . $errMsg);
            }
        } else {
            if($this->isLogin()){
                $this->redirect('Post/index');
            }
            $this->display();
        }
    }

    /**
     * 前台用户注册
     */
    public function register() {
        if (IS_POST) {
            $UserModel = D('MangerSystem/User');
            $post = I('post.');
            if (!$this->check_verify($post['code'])) {
               #$this->error('验证码不正确');
            }
            $type = I('post.type');
            if (array_key_exists($post['type'], $this->map)) {
                $key = $this->map[$post['type']];
                $post[$key] = $post['user_id'];
            }

            $UserModel->data($post);
            $data = $UserModel->create($post);
            if ($UserModel->_add()) {
               $UserModel->login($data);
            } else {
                $errMsg = $UserModel->getError();
                $this->error('注册失败: ' . $errMsg);
            }
        } else {
            if($this->isLogin()){
                $this->redirect('Post/index');
            }
            $this->display();
        }
    }

    /**
     * 判断用户是否唯一，  用户名， 手机号， 邮箱地址
     */
    public function checkUser() {
        if (IS_POST) {
            $map = $this->map;
            $type = I('post.type');
            $account = I('post.account');
            $where = [$map[$type] => $account];
            if (M('User')->where($where)->find()) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

}