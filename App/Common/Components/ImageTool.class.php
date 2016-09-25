<?php

namespace Common\Components;

use Think\Image;

class ImageTool {

    // 判断是相对路径还是绝对路径
    protected function getPathType($fileFullPath) {
        // 第二个字符是：或者第一个字符是 /
        return $fileFullPath[1] == ':' || $fileFullPath[0] == '/';
    }

    // 拆分不同层级的目录
    protected static function splitDirectory($filePath, $level = 1) {
        # $filePath = str_replace('\\', '/', $filePath);
        $arr = explode('/', $filePath);
        if (count($arr) <= 1) {
            return current($arr);
        }
        $retPath = '';

        $firstDir = array_shift($arr);
        if ($firstDir != '.') {
            $retPath = $fileDir;
            $level--;
        }

        for ($i = 0; $i < $level; $i++) {
            $retPath .= array_shift($arr) . '/';
        }
        $otherPath = implode('/', $arr);

        return [$retPath, $otherPath];
    }

    public static function getFileInfo($fileFullPath) {
        $fielInfo = array();
        $fileInfo['name'] = basename($fileFullPath);     // 文件名
        $fileInfo['apath'] = realpath($fileFullPath);      // 绝对路径
        $fileInfo['rpath'] = dirname($fileFullPath) . '/' . $fileInfo['name'];      // 相对路径
        #$fileInfo['mtime'] = filemtime($fileFullPath);
        #$fileInfo['atime'] = fileatime($fileFullPath);
        return $fileInfo;
    }

    /**
     * 生成缩略图
     * @param [type]  $fileFields [description]
     * @return [type]             [description]
     */
    public static function thumb($fileFullPath, array $params = array()) {
        
        $thumbStatus = isset($params['thumbStatus']) ? $params['thumbStatus'] : C('thumbStatus');                  // 状态
        $thumbPrefix = isset($params['thumbPrefix']) ? $params['thumbPrefix'] : C('thumbPrefix');                  // 前缀
        $thumbSize = isset($params['thumbSize']) ? $params['thumbSize'] : C('thumbSize');                          // 尺寸
        // $thumbMaxWidth =  isset($params['thumbMaxWidth']) ? $params['thumbMaxWidth'] : C('thumbMaxWidth');      // 最大宽度
        // $thumbMaxHeight =  isset($params['thumbMaxHeight']) ? $params['thumbMaxHeight'] : C('thumbMaxHeight');  // 最大高度
        $thumbType = isset($params['thumbType']) ? $params['thumbType'] : C('thumbType');                          // 缩略类型
        $image = new Image();
        $image->open($fileFullPath);

        $fileInfo = self::getFileInfo($fileFullPath);
        $name = $thumbPrefix . $fileInfo['name'];
        $fullPath = dirname($fileInfo['rpath']) . '/' . $name;
        $splitDirInfo = self::splitDirectory($fullPath);
        
        $savePath = isset($splitDirInfo[1]) ? $splitDirInfo[1] : '不存在';
        
        $image->thumb($thumbSize[0], $thumbSize[1], $thumbType)->save($fullPath);
        
        $retDataThumb = ['urlPath' => IMG_URL. $savePath, 'fullPath' => $fullPath, 
            'name' => $name, 'savePath' => $savePath];
        
        // $data  = $retDataThumb ;
        if(0 || C('waterStatus')) {  // 开启了水印
            $data['ori'] = $retDataThumb ;
            
            $waterFile = './Uploads/water.png' ;
            $waterConfig = array('waterRemoveOrigin'=> true, 'waterFile' => $waterFile, 'waterPosition'=>1 ); 
            $retDataWater = self::water($image, array_merge($retDataThumb, $waterConfig));   // 原始图片
            $data['water'] = $retDataWater ;
        }
        
        if(0 || C('cropStatus')) {   // 开启裁剪功能
            $data['ori'] = $retDataThumb ;
            $cropConfig = array('cropWidth'=> 100, 'cropHeight'=> 100, 'cropStartX' => 0, 'cropStartY'=> 0); 
            $retDataCrop = self::crop($image, array_merge($retDataThumb, $cropConfig));   // 原始图片
            $data['crop'] = $retDataCrop ;
        }
        return isset($data) ? $data : $retDataThumb  ;
    }

    
    /**
     * @param $image obj:打开的图像对象， string: 图像的全路径
     * 给图像添加水印
     * 开启水印，图像应该替换
     */
    public static function water($image, array $params = array()) {
        #$waterStatus = isset($params['waterStatus']) ? $params['waterStatus'] : C('waterStatus');                          // 状态
        $waterFile = isset($params['waterFile']) ? $params['waterFile'] : C('waterFile');                                   // 水印文件
        $waterRemoveOrigin = isset($params['waterRemoveOrigin']) ? $params['waterRemoveOrigin'] : C('waterRemoveOrigin');  // 是否覆盖
        $waterPosition = isset($params['waterPosition']) ? $params['waterPosition'] : C('waterPosition');                  // 水印位置
        $waterAlpha = isset($params['waterAlpha']) ? $params['waterAlpha'] : C('waterAlpha');                              // 透明度
        
        if($waterRemoveOrigin) {        // 覆盖
            $image->water($waterFile, $waterPosition)->save($params['fullPath']);
            $retData =  [
                        'urlPath' => ltrim($params['fullPath'], '.'), 'fullPath' => $params['fullPath'], 
                        'name' => $params['name'], 'savePath' => $params['savePath']
                    ];
        } else {
            $waterPrefix = 'water_';
            
            $fileInfo = self::getFileInfo($params['fullPath']);
            $name = $waterPrefix . $fileInfo['name'];
            $fullPath = $fileInfo['rpath'] . $name;
            $splitDirInfo = self::splitDirectory($fullPath);
            $savePath = isset($splitDirInfo[1]) ? $splitDirInfo[1] : '不存在';
            
            $image->water($waterFile)->save($fullPath);
            
            $retData = ['urlPath' => ltrim($fullPath, '.'), 'fullPath' => $fullPath, 'name' => $name, 'savePath' => $savePath];
        }
        return $retData ;
    }

    
    /**
     * 图像裁剪
     */
    public static function crop($image, array $params = array()) {
        
         #$cropStatus = isset($params['cropStatus']) ? $params['cropStatus'] : C('cropStatus');                          // 状态
        $cropRemoveOrigin = isset($params['cropRemoveOrigin']) ? $params['cropRemoveOrigin'] : C('cropRemoveOrigin');    // 是否覆盖
        $cropWidth = isset($params['cropWidth']) ? $params['cropWidth'] : C('cropWidth');                                // 裁剪区域的宽度
        $cropHeight = isset($params['cropHeight']) ? $params['cropHeight'] : C('cropHeight');                            // 裁剪区域的高度
        $cropStartX = isset($params['cropStartX']) ? $params['cropStartX'] : C('cropStartX');                            // 裁剪区域的X坐标
        $cropStartY = isset($params['cropStartY']) ? $params['cropStartY'] : C('cropStartY');                            // 裁剪区域的Y坐标
        
        
        if($cropRemoveOrigin) {        // 覆盖
            $image->crop($cropWidth, $cropHeight, $cropStartX, $cropStartY)->save($params['fullPath']);
            $retData =  [
                        'urlPath' => ltrim($params['fullPath'], '.'), 'fullPath' => $params['fullPath'], 
                        'name' => $params['name'], 'savePath' => $params['savePath']
                    ];
        } else {
            $cropPrefix = 'crop_';
            
            $fileInfo = self::getFileInfo($params['fullPath']);
            $name = $cropPrefix . $fileInfo['name'];
            $fullPath = $fileInfo['rpath'] . $name;
            $splitDirInfo = self::splitDirectory($fullPath);
            $savePath = isset($splitDirInfo[1]) ? $splitDirInfo[1] : '不存在';
            
            $image->crop($cropWidth, $cropHeight, $cropStartX, $cropStartY)->save($fullPath);
            
            $retData = ['urlPath' => ltrim($fullPath, '.'), 'fullPath' => $fullPath, 'name' => $name, 'savePath' => $savePath];
        }
        return $retData ;
    }

}
