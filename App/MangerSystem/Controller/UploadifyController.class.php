<?php

namespace MangerSystem\Controller;

use Common\Components\UploadTool;

/**
 * Uploadify 多文件上传控件
 */
class UploadifyController extends CommonController {

    protected function _initialize() {
        C('SHOW_PAGE_TRACE', false);
    }
    
    
    /**
     * 显示Uploadify的上传组件
     */
    public function index() {
        $this->display("Public/uploadify");
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
            $file = UploadTool::upload($_FILES[$key], array('savePath' => 'gallary/'));

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

        # $gid = I('post.gid', 0, 'intval');
        # $gid && $ret = M('post_gallary')->where(['gallary_id'=>$gid])->delete() ;

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
