<?php
namespace MangerSystem\Model;
use Common\Components\Helpers ;
use Think\Verify;

/**
 * {类型}模型
 */
class AdminModel extends CommonModel {

    const USER_ACCOUNT_ERROR = -1 ;		// 用户名输入错误
    const USER_PWD_ERROR = -2 ;		// 用户密码输入错误
    const USER_FORBIDDEN = -3; // 用户已经禁用

     protected $_validate = [
        // array(field,rule,message,condition,type,when,params) 
        ['username', 'require', '用户名不能为空', self::EXISTS_VALIDATE ], 
        ['username', '', '用户名已经存在-model', self::EXISTS_VALIDATE, 'unique', self::MODEL_INSERT],
        ['nickname', '', '昵称已经存在-model', self::EXISTS_VALIDATE, 'unique', self::MODEL_INSERT],
        ['status', 'number', '状态数据有误', self::EXISTS_VALIDATE ],
	 
	#['password', '4,15', '密码长度必须4-15位', self::MUST_VALIDATE, 'length', self::MODEL_INSERT],
        #['repassword', 'password', '密码和确认密码不一致', self::EXISTS_VALIDATE, 'confirm'],
        ['verify','require','验证码必须', self::EXISTS_VALIDATE, 'regex', 4 ],
        ['verify','check_verify','验证码不正确', self::EXISTS_VALIDATE, 'callback', 4 ],
    ];

    /**
     * 添加方法
     */
    public function _add() {
        $data = $this->data ;
	
	empty(trim($data['password']))  && $data['password'] = C("pwd");
        $data['password'] = Helpers::encrypt($data['password']);
        $data['reg_time'] = strtotime($data['reg_time']);
        $this->data = $data ;
        return parent::add();
    }

    /**
     * 修改方法
     */
    public function _save() {
        $data = $this->data;
        
        $dbFields = $this->getDbFields();
        $updTimeField = 'update_time';
        $updTimename = 'update_admin_name';

        if (in_array($updTimeField, $dbFields)) {
            $this->data[$updTimeField] = time();
        }
        if (in_array($updTimename, $dbFields)) {
            $this->data[$updTimename] = session('uname');
        }
	
	$data['reg_time'] = strtotime($data['reg_time']);
	
	
	//  密码不填表示不修改密码
        if ($data['password'] == '') {
            unset($data['password']);
        } else {
//            
//	    $sqlData = $this->field(['password'])->find($data[$this->pk]);
//	 
//            // 原始密码必须正确
//            if (Helpers::encrypt($data['password']) != $sqlData['password']) {
//                $this->error = '原始密码不正确';
//                return FALSE;
//            }
//	    
//            /***********************  对新密码的验证 **************************** */
//            // 新密码不能和原始密码相同
//            if ($_POST['newpassword'] == $data['password']) {
//                $this->error = '新密码不能和原始密码相同';
//                return FALSE;
//            }
//            // 密码长度的验证
//            $len = mb_strlen($_POST['newpassword']);
//            $lenCondition = $len >= 4 && $len <= 15;
//            if (!$lenCondition) {
//                $this->error = '新密码的长度必须4-15位';
//                return FALSE;
//            }
//            // 新密码必须和确认密码一致
//            if ($_POST['newpassword'] != $_POST['renewpassword']) {
//                $this->error = '密码和确认密码不一致';
//                return FALSE;
//            }
//	    
//            // 设置新的密码
//            $data['password'] = Helpers::encrypt($_POST['newpassword']);
	    
	    
            $data['password'] = Helpers::encrypt($data['password']);
        }
	
	$this->data = $data;
	
        return parent::save();
    }

   

    /**
     * 设置单个字段的值, 可以操作一条/多条数据 【根据ID修改操作】
     * @param type $ids         id值
     * @param type $fieldName   字段名
     * @param type $val         字段值
     * @return type
     */
    public function setSingleField($ids, $fieldName, $val) {

        $pk = $this->pk;
        if (is_array($ids)) {               // 多条ID记录, 数组
            $where[$pk] = ['in', $ids];
        } else if (is_numeric($ids)) {     // 单条ID记录
            $where[$pk] = $ids;
        }
        $ret =  $this->where($where)->setField($fieldName, $val);
        return $ret ;
    }



    /**
     * 检验验证码是否正确
     * @param unknown $code 用户输入的验证码字符串
     * @param string $id
     */
    public function check_verify($code, $id='') {
        $Verify = new Verify(['reset' =>  false]);
        return $Verify->check($code, $id);
    }

    /**
     * 验证登录方法
     * 
     */
    public function login() {
        $username = $this->username;
        $password = $this->password;

        $fields = [$this->pk, 'username', 'nickname', 'thumb', 'password', 'status', 'last_login_time', 'role_id','last_login_ip', 'login_count'] ;
        $user = $this->field($fields)->where(['username' => $this->username])->find();

        if(!$user) {
            return self::USER_ACCOUNT_ERROR ;
        } elseif ($user['password'] !== Helpers::encrypt($password) ) {
            return self::USER_PWD_ERROR ;
        } else if($user['status'] == 0){
            return self::USER_FORBIDDEN;
        } else  {

            $sessionUid   = getSessionUidKey();
            $sessionUname = getSessionUnameKey();

            // 设置登录标识 session
            session($sessionUid,    $user[$this->pk]);
            session($sessionUname,  $user['username']);
            session('nickname',  $user['nickname']);
            session('thumb',  $user['thumb']);
            session('login_ip',     $user['last_login_ip']);
            session('login_time',   $user['last_login_time']);
	    C('useRoleAuth') && $this->setPriToSession($user['role_id']);        // 将权限信息存入到session中
	    
            // 登录成功后弹窗 上一次登录时间 上一次登录IP 保存在cookie中
            cookie('login_ip', $user['last_login_ip'],  1000);
            cookie('login_time', date('Y-m-d H:i:s', $user['last_login_time']), 1000);

            // 是否记住登录，保存COOKIE 保存到cookie中的数据需要加密
            if(isset($_POST['remember']) && $_POST['remember'] ) {
                cookie('uname', $user['username'], 3600 * 24 * 30);	// 默认保存30天
                cookie('upass', encode($password) , 3600 * 24 * 30);	// 默认保存30天
            }

            // 修改上一次登录时间和ip(地址)
            $data = [
                $this->pk => $user[$this->pk],
                'last_login_ip' => get_client_ip(),
                'last_login_time' => time(),
		'login_count' => $user['login_count'] + 1
            ];
	    
            parent::save($data);
	    

            return TRUE ;
        }
    }
    
    
    /**
     * 将权限信息放到session中去
     */
    protected function setPriToSession($role_id) {
        $RoleModel = M('Role');
        $pri_ids = M('Role')->where(['role_id' => $role_id])->getField('pri_ids');
        // $RoleModel->field('pri_ids')->find($role_id);  $RoleModel->pri_ids ;
	
        $priModel = M('Privilege');
        if ($pri_ids === '*') {
            // 超级管理员, '*' 代表超级管理员拥有所有权限
            session('privilege', '*');
        } else {
            // 根据权限的ID，取出权限对应的信息
            $fields = ['module_name', 'controller_name', 'action_name'];
            // $priData = $priModel->field($fields)->select($pri_ids);
	    // $User->getField('id,nickname,email',':');
	    
	    $pk = $priModel->getPk();
	    $where = $pk . ' in ( '. $pri_ids . ')';
	    $priData = $priModel->field($fields)->where($where)->getField($pk .',module_name,controller_name,action_name', ":");
	    
	    session('privilege', $priData);
            session('pri_ids', $pri_ids);
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