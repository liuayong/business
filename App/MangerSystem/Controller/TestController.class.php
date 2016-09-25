<?php

namespace MangerSystem\Controller;

use Think\Controller;

class TestController extends Controller {
    protected function _initialize() {
        C('SHOW_PAGE_TRACE', false);
    }
    /**
     *  // 单文件上传的测试
     *  测试TP提供的单文件上传功能
     */
    public function index() {
        
        if(IS_POST) {
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     123145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            // 上传文件 
            $info   =   $upload->upload();
            
           # var_dump($info);
            
            
            /*
            # $info   =   $upload->uploadOne($_FILES['myfile']);
             success:
                $info = array (size=9)
                  'name' => string '编号：M0902A.jpg' (length=19)
                  'type' => string 'image/jpeg' (length=10)
                  'size' => int 211370
                  'key' => int 0
                  'ext' => string 'jpg' (length=3)
                  'md5' => string '918ce4838c048d551853ba556a2316ce' (length=32)
                  'sha1' => string '049f682662ee4dae3b06ceaf88a2934fcd9433d6' (length=40)
                  'savename' => string '57ca58f3ca648.jpg' (length=17)
                  'savepath' => string '2016-09-03/' (length=11)
             * 
             * 
             fail ：
             * $info = false
               $upload->getError();  上传文件后缀不允许
             * 
             * 
             */
            
            /*
            #$info   =   $upload->upload();
             success:
                $info =  array (size=1)
                  'myfile' => 
                    array (size=9)
                      'name' => string 'Chrysanthemum.jpg' (length=17)
                      'type' => string 'image/jpeg' (length=10)
                      'size' => int 879394
                      'key' => string 'myfile' (length=6)
                      'ext' => string 'jpg' (length=3)
                      'md5' => string '076e3caed758a1c18c91a0e9cae3368f' (length=32)
                      'sha1' => string 'f5f8ad26819a471318d24631fa5055036712a87e' (length=40)
                      'savename' => string '57ca57a6c3438.jpg' (length=17)
                      'savepath' => string '2016-09-03/' (length=11)
             * 
             * 
             fail ：
             * $info = false ,
             * $upload->getError();  上传文件大小不符
             * 
             */
            
            if(!$info) {// 上传错误提示错误信息
                // $this->error($upload->getError());
                echo $upload->getError();
            }else{// 上传成功
                // $this->success('上传成功！');
                echo '上传成功';
            } 
            
        } else {
           $this->display(); 
        }
    }
    
    public function basicExecute() {
        $this->display();
    }
    
    /**
     * 测试 上传组图的组件 
     */
    public function upload() {
        $this->display();
    }
    
    
    /**
     * 测试弹出对话框 Zebra_Dialog
     */
    public function dialog() {
        $this->display();
    }
}
