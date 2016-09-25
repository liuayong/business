<?php

namespace Common\Components;

class UploadTool  {

    /**
     * 单个文件上传
     * @param $fileFields
     * @param $thumb
     * @param $thumbSize
     * @param $allowExts
     * @param $maxSize
     * @param $savePath
     * @return unknown
     */
    private function _saveRule($params = array('rule' => 'default', 'format' => 'Ymd')) {
        $path = '';
        switch ($params['rule']) {
            case 'custom':
                $path .= $params['string'] . '/';
                break;
            case 'user':
                isset($params['userPath']) && $path .= $params['userPath'] . '/';
                isset($params['userId']) && $path .= $params['userId'] . '/';
                isset($params['format']) && $path .= date($params['format']) . '/';
                break;
            default:
                $paths = isset($params['format']) ? date($params['format']) . '/' : date('Ym') . '/';
                $path .= $paths;
                break;
        }
        return 'uploads/' . $path;
    }

    /**
     *  获取允许大小  单位 Byte
     * //上传的文件大小限制 (0-不做限制)
     * @return type int byte
     */
    protected static function getAllowSize($size = null) {
        $phpMaxSize = (int) ini_get('upload_max_filesize') * 1024 * 1024;
        $framewrorkMaxSize = C('upload_max_filesize');
        $allowMaxSize = ($size === null) ? min($phpMaxSize, $framewrorkMaxSize) : min($phpMaxSize, $size);
        return $allowMaxSize;
    }

    /**
     * 获取允许的文件类型
     * @return type
     */
    protected static function getAllowExts($exts) {
        if (is_string($exts)) {
            $exts = trimall($exts);
        }
    }

    /**
     * 单个文件上传
     * @param [type]  $fileFields [description]
     * @return [type] array         [description]
     */
    static public function upload($fileFields, array $params = array()) {

        $upload = new \Think\Upload(); // 实例化上传类

        // 设置上传文件大小  纯数字  Byte 上传的文件大小限制 (0-不做限制)
        $maxSize = isset($params['maxSize']) ? $params['maxSize'] : null;
        $upload->maxSize = self::getAllowSize($maxSize);

        // 设置上传文件类型  最终转换为数组, 空数组表示不限制文件的类型 文件类型不带.
        $upload->allowExts = isset($params['allowExts']) ? $params['allowExts'] : C('allowExts');

        // 设置文件上传的父目录  为空表示不设置, 不为空表示设置父目录, 则必须以'/'结尾,表示目录
        #$upload->savePath = self::_saveRule($params['saveRule']);
        $upload->savePath = isset($params['savePath']) ? $params['savePath'] : C('savePath');

        // 设置上传的根目录, 目录必须以'/'结尾
        $upload->rootPath = './Uploads/';
        
        
        // 上传单个文件
        $file = $upload->uploadOne($fileFields);
  
        if (!is_array($file)) {
            $errMsg = $upload->getError();
            $retUpData = ['code' => 1, 'msg'=> $errMsg];
            
        } else {
            $retUpData = array(
                'name' => $file['name'], 
                'ext' => $file['ext'], 
                'mime' => $file['type'], 
                'size' => $file['size'], 
                'beautifySize' => self::byteFormat($file['size']), 
                'savename' =>$file['savename'], 
            ) ;
            $retUpData['code'] = 0;     // 状态码
            $retUpData['savepath'] =  $file['savepath']. $retUpData['savename'];   // 数据所存放路径 cate/2015-09-03/57ca679d0ca58.jpg
            $retUpData['fullPath'] = $upload->rootPath . $retUpData['savepath'];   // 全路径
            $retUpData['urlPath'] = IMG_URL . $retUpData['savepath'] ;  // web访问路径
            $retUpData['msg'] =  '上传成功!';
        }
        
        return $retUpData; 
    }

    /**
     * 多文件上传
     *
     * @param boolean $thumb [description]
     * @return [type]         [description]
     */
    public static function uploads($params = false) {
       exit('<h1>暂时不支持多文件上传</h1>');
    }

     /**
     * 格式化单位
     */
     public static function byteFormat( $size, $dec = 2 ) {
        $a = array ( "B" , "KB" , "MB" , "GB" , "TB" , "PB" );
        $pos = 0;
        while ( $size >= 1024 ) {
            $size /= 1024;
            $pos ++;
        }
        return round( $size, $dec ) . " " . $a[$pos];
    }
}
