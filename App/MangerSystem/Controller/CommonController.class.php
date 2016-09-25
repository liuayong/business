<?php

namespace MangerSystem\Controller;

use Think\Controller;
use Common\Components\UploadTool;

class CommonController extends Controller {

    protected $model;    // 当前模型
    protected $returnUrl;

    protected function _initialize() {

        false && $this->ipLimit();

        isset($_SERVER["HTTP_REFERER"]) && $this->returnUrl = $_SERVER["HTTP_REFERER"];

        $this->isLogin(true);
        // 验证码权限
        C('useRoleAuth') && $this->permissionValidation();

        // 寻找对应的模型
        $tables = array_column(M()->query("show tables"), 'tables_in_' . C('DB_NAME'));
        $prefix_len = strlen(C('DB_PREFIX'));
        $modelNames = array_map(function($v) use($prefix_len) {
                    return parse_name(substr($v, $prefix_len), 1);
                }, $tables);

        $modelName = ucfirst(strtolower(CONTROLLER_NAME));
        if (in_array($modelName, $modelNames)) {
            // 当前操作的模型
            $this->model = D(MODULE_NAME . '/' . $modelName);
        }
    }

    protected function ipLimit() {
        $allowIps = C('allowIps');
        $ip = get_client_ip();

        if (!in_array($ip, $allowIps) && MODULE_NAME == 'Admin') {
            E('页面出错');
        }
    }

    /**
     * 是否登录, 带有跳转功能
     * @param bool|false $isRdirect 未登录的情况, 是否跳转
     * @return bool
     */
    protected function isLogin($isRdirect = false) {

        $sessionUid = getSessionUidKey();
        $sessionUname = getSessionUnameKey();
        $isLogin = session('?' . $sessionUid) && session('?' . $sessionUname);


        if (!$isLogin) {
            if (isset($_COOKIE['auth']) && $_COOKIE['auth']) {
                $data = decode($_COOKIE['auth'], 'liuayong');
                list($username, $password) = explode('|:|', $data);
                $AdminModel = D('Admin/Admin');
                $AdminModel->username = $username;
                $AdminModel->password = $password;
                $ret = $AdminModel->login();
                if ($ret === TRUE)
                    return true;
            }

            session('return_url', $_SERVER['REQUEST_URI']);     // 设置返回的登录地址
            if ($isRdirect) {
                $this->redirect('Login/index');
            }

            return false;
        }
        return true;
    }

    /**
     * * id数据 通过传递参数 or 请求中获取
     * 状态禁用
     */
    public function forbid($ids = null) {
        if (CONTROLLER_NAME == 'Nav') {
            $Model = new \MangerSystem\Model\NavCateModel('', 'nav_');
        } else {
            $Model = D(CONTROLLER_NAME);
        }
        if (is_null($ids)) {
            $pkName = $Model->getPk();
            $pkName = isset($_REQUEST[$pkName]) ? $pkName : 'id';
            $pkVal = I($pkName);
        } else {
            $pkVal = $ids;
        }
        $ret = $Model->setSingleField($pkVal, 'status_is', 'N');
        if ($ret !== false) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败: ' . $this->error());
        }
    }

    /**
     * id数据 通过传递参数 or 请求中获取
     * 状态还原
     */
    public function recycle($ids = null) {

        if (CONTROLLER_NAME == 'Nav') {
            $Model = new \MangerSystem\Model\NavCateModel('', 'nav_');
        } else {
            $Model = D(CONTROLLER_NAME);
        }
        if (is_null($ids)) {
            $pkName = $Model->getPk();
            $pkName = isset($_REQUEST[$pkName]) ? $pkName : 'id';
            $pkVal = I($pkName);
        } else {
            $pkVal = $ids;
        }


        $ret = $Model->setSingleField($pkVal, 'status_is', 'Y');
        if ($ret !== false) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败: ' . $this->error());
        }
    }

    /**
     * 批量操作
     *
     */
    public function batch() {
        if (IS_POST) {
            $command = I('post.command');
            $filed = I('batchfield', 'id', 'trim');
            $ids = I('post.'.$filed);
            switch ($command) {
                case 'totrash' :
                    $this->toTrash($ids);
                    break;
                case 'sortOrder':
                    foreach ((array) I('post.sort_order') as $id => $val) {
                        $model = $this->model;
                        $oneData = $model->find($id);
                        if ($oneData) {
                            #$this->model->sort_order = $val;
                            #$this->model->pk = $id;
                            $data = [$model->getPk() => $id, 'sort_order' => $val];
                            $ret = $model->save($data);
                        }
                    }
                    break;
                case 'toshow' :
                    $this->recycle($ids);
                    break;
                case 'unshow' :
                    $this->forbid($ids);
                    break;
		case 'del' :
		    $this->del($ids);
                    break;
                default:
                    #throw new CHttpException(404, '错误的操作类型:' . $command);
                    $this->error('错误的操作类型:' . $command);
                    break;
            }
            $this->success('操作成功', '', 3);
        } else {
            $this->error('无法访问该页');
        }
    }

    /**
     * 软删除 【单/多条记录】
     * @param type $id
     */
    public function toTrash($id) {
        $id = I('id', 0, 'intval');

        $model = $this->model;
        $ret = $model->toTrash($id);
        if ($ret) {
            $this->success("删除记录成功");
        } else {
            $this->error("删除记录失败: " . $model->getError());
        }
    }
    
    /**
     * 硬删除, 只有超级才有硬删除的权限
     */
    public function del($id) {
        $id = I('id', 0, 'intval');
	var_dump(func_get_args());
	var_dump($id);
        $model = $this->model;
        if (!$model->isSuperAdmin()) {
            $this->error('只有超级才有删除的权限');
            return false;
        }

        $ret = $model->_delete($id);
        if ($ret) {
            $this->success("删除记录成功" );
        } else {
            $this->error("删除记录失败: " . $model->getError());
        }
    }

    /**
     * 操作成功和失败之后, 返回的URL
     */
    public function getReturnUrl() {
        if (empty($this->returnUrl)) {
            return '';
        } else {
            return $this->returnUrl;
        }
    }

    /**
     * ajax ,改变状态
     */
    public function changeStatus() {
        $id = I('id');
        $type = I('type');       // 需要修改的字段
        $value = !I('value');    // 状态值取反
        $name = I('name');       // 对应的模型名称

        $model = D($name);
        $pk = $model->getPk();

        // 受到影响的行数
        $res = $model->where("$pk = $id")->setField($type, $value);

        $retData['code'] = $res ? 0 : $res;
        $retData['message'] = $model->getError();
        $retData['content'] = '';

        echo json_encode($retData);
    }

    /**
     * 上传文件 
     */
    public function upload() {
//        $NavModel = D('Nav');
//        $data = $NavModel->upload();
//        echo json_encode($data);
        C('show_PAGE_TRACE', false);

        $data = upload();
        echo json_encode($data);

//        $data = \Common\Components\PluginsInterface::upload();
//        echo json_encode($data);
    }

    // Uploadify 上传图片
    function upload2() {

        C('show_PAGE_TRACE', false);
        $defaulConfig = [
            'maxSize' => 5 * 1000 * 1000, // 设置上传图片的大小
            'exts' => array('jpg', 'gif', 'png', 'jpeg'), // 设置附件上传类型 
            'rootPath' => './Uploads/', //保存根路径
        ];

        $upload = new \Think\Upload($defaulConfig);
        $info = $upload->upload();

        if ($fileKey === null) {
            $fileKeys = array_keys($_FILES);
            $fileKey = current($fileKeys);
        }

        $ret = [];

        // 没有返回图片的大小(宽高)
        if ($info) {
            $imgPath = $info[$fileKey]['savepath'] . $info[$fileKey]['savename'];
            $imgFullPath = __ROOT__ . trim($defaulConfig['rootPath'], '.') . $imgPath;

            $ret['imgFullPath'] = $imgFullPath;
            $ret['imgPath'] = $imgPath;
            $ret['info'] = $info[$fileKey];
            $ret['status'] = 1;
        } else {
            $error = $upload->getError();

            $ret['data'] = null;
            $ret['info'] = $error;
            $ret['status'] = 0;
        }
        echo json_encode($ret);
    }

    // ajax单文件上传， 需要借助ajaxFileUpload插件
    public function ajaxUploadFile() {
        C('show_PAGE_TRACE', false);
        // header('Content-type:text/json');  
        if (IS_POST) {
            $savepath = strtolower(CONTROLLER_NAME) . '/';
            if (!empty($_FILES)) {                  // 含有文件上传
                reset($_FILES);
                $key = key($_FILES);
            }
            $fileInfo = UploadTool::upload($_FILES[$key], array('savePath' => $savepath));
            echo json_encode($fileInfo);
        }
    }

    // Uploadify 删除图片
    public function delUpdImg() {
        /* 删除图片 */
        $t = urldecode(I('post.path'));
        $src = './Uploads/' . $t;
        @unlink($src);

        // 如果有缩略图需要删掉缩略图
        // @unlink(str_replace($str,'t_'.$str,$src));
    }

    public function test() {
        $this->display('News/test');
    }

    public function img() {
        $this->display('Login/test');
    }

    /**
     * 获取栏目的额外字段
     */
    public function ajaxAttr($cate_id) {

        $where = ['cate_id' => $cate_id];

        // $field = ['attr_id', 'attr_name', 'attr_name_alias', 'tips', 'attr_type', 'data_default'] ;
        // $data = D('Attr')->field($field)->where($where)->search('list') ;

        $data = getAllAttr($where);
        if ($data) {
            $this->data = $data;
            $this->display('Cate/ajaxAttr');
        } else {
            echo '';
        }
    }

    protected function isSuperAdmin($id = 0) {
        return C('superAdminId') == $id;
    }

    /**
     * 权限验证
     */
    protected function permissionValidation() {
        //MODULE_NAME, CONTROLLER_NAME, ACTION_NAME
        $priData = session('privilege');

        // 超级管理员
        if ($priData == '*' || $this->isSuperAdmin()) {
            return TRUE;
        }

        // ++++++++++++++++++++ 不是超级管理员, 需要验证权限 ++++++++++++++++++++ 
        // 跳过权限的验证，所有后台管理员都可以访问
        if (strtoupper(MODULE_NAME) == 'ADMIN' && strtoupper(CONTROLLER_NAME) == 'INDEX') {
            return TRUE;
        }

        $actions = ['index', 'add', 'upd', 'del'];
        if (!in_array(ACTION_NAME, $actions)) {
            return true;
        }


        // $cond1 = is_array($priData['module_name']) && in_array(MODULE_NAME, $priData['module_name']);
        // $cond2 = is_array($priData['controller_name']) && in_array(CONTROLLER_NAME, $priData['controller_name']);
        // $cond3 = is_array($priData['action_name']) && in_array(ACTION_NAME, $priData['action_name']);


        $now = MODULE_NAME . ':' . CONTROLLER_NAME . ':' . ACTION_NAME;
        if (in_array($now, $priData)) {
            return TRUE;
        } else {
            $this->error('没有权限访问');
            return FALSE;
        }
    }

    protected function changeShowStatus($status) {
        
    }
    
    
     
    /**
     * 自动获取关键词(调用第三方插件)
     */
    public function getKeyword() {
        $keywords = I('post.keywords','','trim');
        $words = \Common\Components\AutoKeywordTool::discuz($keywords);
        
        /*
         if($return  == 'empty'){
                $data['state'] = 'error';
                $data['message'] = '未成功获取';
            }else{
                $data['state'] = 'success';
                $data['message'] = '成功获取';
                $data['datas'] = $return;
            }
         */
        if(empty($words)) {
            $data['code'] = 1;
            $data['message'] = '未成功获取有效内容, 请您手动填写标签';
        } else {
            $data['code'] = 0;
            $data['message'] = '获取成功';
            $data['content'] = $words;
        }
        echo json_encode($data) ;
        return ;
    }
    

}
