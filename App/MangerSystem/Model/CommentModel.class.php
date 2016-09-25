<?php

namespace MangerSystem\Model;

/**
 * 评论模型
 */
class CommentModel extends CommonModel {

    
    // 自动验证
    protected $_validate = array(
        // array(field, url,'错误提示',self::VALUE_VALIDATE, callback, self:MODEL_BOTH , params) 
        array('nickname','require','用户名必须!', self::MUST_VALIDATE),
        array('email', 'email', '邮箱格式错误', self::EXISTS_VALIDATE),
        array('content','require','内容不能为空', self::EXISTS_VALIDATE),
    );


    // 自动完成
    protected $_auto = array(
        //  array(完成字段1,完成规则,[完成条件,附加规则]),
        array('create_time', 'time', self::MODEL_INSERT, 'function' ),
        array('client_ip', 'get_client_ip', self::MODEL_INSERT, 'function' ),
        array('agent', 'userAgent', self::MODEL_INSERT, 'callback' ),
    );
    
    
    /**
     * 获取当前请求头中 User-Agent
     * @return type
     */
    protected function userAgent() {
        return strval($_SERVER["HTTP_USER_AGENT"]);
    }

}
