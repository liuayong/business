<?php
namespace MangerSystem\Model;
use Think\Verify;

/**
 * {类型}模型
 */
class MsgModel extends CommonModel {


     protected $_validate = [
	 
        // array(field,rule,message,condition,type,when,params) 
        ['title', 'require', '标题不能为空', self::EXISTS_VALIDATE ], 
        ['tid', 'require', '必须要选择一个发送人', self::EXISTS_VALIDATE ], 
        ['content', 'require', '信息内容不能为空', self::EXISTS_VALIDATE ], 
    ];
     
     
     
}