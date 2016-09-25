<?php

namespace Common\Components;

// 各种插件的接口
class PluginsInterface {

    // 上传文件
    public static function upload($fileKey = null, array $config = []) {
        C('show_PAGE_TRACE', false);

        $defaulConfig['maxSize'] = 5 * 1000 * 1000;                  // 设置上传图片的大小
        $defaulConfig['exts'] = array('jpg', 'gif', 'png', 'jpeg');  // 设置附件上传类型

        $config = array_merge($defaulConfig, $config);      // 合并配置项

        $upload = new \Think\Upload($config);
        $info = $upload->upload();

        if ($fileKey === null) {
            $fileKeys = array_keys($_FILES);
            $fileKey = current($fileKeys);
        }

        if ($info) {
            $imgPath = $info[$fileKey]['savepath'] . $info[$fileKey]['savename'];
            $imgFullPath = __ROOT__ . '/Uploads/' . $imgPath;
            $data = ['code' => 0, 'msg' => '上传成功', 'imgFullPath' => $imgFullPath, 'imgPath' => $imgPath];
        } else {
            $error = $upload->getError();
            $data = ['code' => -1, 'msg' => $error, 'imgPath' => null];
        }
        return $data;
    }

}
