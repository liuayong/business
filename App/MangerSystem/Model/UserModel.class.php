<?php
namespace MangerSystem\Model;
use Common\Components\Helpers ;
use Think\Verify;

/**
 * {类型}模型
 */
class UserModel extends CommonModel {

    const USER_ACCOUNT_ERROR = -1 ;		// 用户名输入错误
    const USER_PWD_ERROR = -2 ;		// 用户密码输入错误
    const USER_FORBIDDEN = -3; // 用户已经禁用

     protected $_validate = [
        // array(field,rule,message,condition,type,when,params) 
        
    ];

    /**
     * 添加方法
     */
    public function _add() {
        $data = $this->data ;
        $data['password'] = Helpers::encrypt($data['password'], 'qiantai_user');
        $data['reg_time'] = time();
        $this->data = $data ;
        return parent::add();
    }

 

    /**
     * 验证登录方法
     * 
     */
    public function login(array $data = array()) {
        
        if(empty($data)) {
            $data  = $this->data ;
        }
        // 临时记录密码
        $password = $data['password'];
        unset($data['password']);
        
        $fields = [$this->pk, 'username', 'nickname', 'password', 'lock', 'login_time' ,'login_ip' ] ;
        $user = $this->field($fields)->where($data)->find();
        if(!$user) {
            return self::USER_ACCOUNT_ERROR ;
        } elseif ($user['password'] !== Helpers::encrypt($password, 'qiantai_user') ) {
            return self::USER_PWD_ERROR ;
        } else if($user['lock'] == 1){
            return self::USER_FORBIDDEN;
        } else  {

            $sessionUid   = getSessionUidKey();
            $sessionUname = getSessionUnameKey();

            // 设置登录标识 session
            session($sessionUid,    $user[$this->pk]);
            session($sessionUname,  $user['username']);
            session('nickname',  $user['nickname']);
            session('thumb',  $user['thumb']);
            session('login_ip',     $user['login_ip']);
            session('login_time',   $user['login_time']);
	    
            // 登录成功后弹窗 上一次登录时间 上一次登录IP 保存在cookie中
            cookie('login_ip', $user['login_ip'],  1000);
            cookie('login_time', date('Y-m-d H:i:s', $user['login_time']), 1000);

            // 是否记住登录，保存COOKIE 保存到cookie中的数据需要加密
            if(isset($_POST['remember']) && $_POST['remember'] ) {
                cookie('uname', $user['username'], 3600 * 24 * 30);	// 默认保存30天
                cookie('upass', encode($password) , 3600 * 24 * 30);	// 默认保存30天
            }

            // 修改上一次登录时间和ip(地址)
            $data = [
                $this->pk => $user[$this->pk],
                'login_ip' => get_client_ip(),
                'login_time' => time(),
            ];
	    
            return TRUE ;
        }
    }
    
    
    public function getUsers(array $ids = array()){
	$field = '*' ;
	$ret = array() ;
	if(!empty($ids)) 
	    $ret = $this->field($field)->where(array('admin_id'=>array('in', $ids)))->select();
	return $ret ;
    } 
    
    public function getUserById($id, $fields='*') {
	return $this->field($fields)->find($id);
    }
}