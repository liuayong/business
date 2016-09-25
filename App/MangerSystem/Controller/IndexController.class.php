<?php

namespace MangerSystem\Controller;

/**
 * 后台首页
 * Class LoginController
 * @package MangerSystem\Controller
 */
class IndexController extends CommonController {

    public function index() {
	$this->display();
    }
    
    // 系统首页
    public function home() {
        echo "<h1>系统首页</h1>";
    }
    
    /**
     * 朋友圈   读取用户列表
     */
    public function users() {
//        phpinfo();
//        return ;
	$uid = session(getSessionUidKey());

	$follow = M('follow');
	$adminModel = D('Admin');

	// 我的粉丝 (关注我的)  'fid' => $uid
	$fenIds = $follow->where(array('fid' => $uid))->getField('uid', true);
	$fen = $adminModel->getUsers((array) $fenIds);

	// 我的关注 myAttention 'uid' => $uid
	$myAttentionIds = $follow->where(array('uid' => $uid))->getField('fid', true);
	$myAttention = $adminModel->getUsers((array) $myAttentionIds);

	// 推荐的朋友  此时没有权重 随机10人
	$cids = (array) $myAttentionIds;
	array_push($cids, $uid);
	$recommend = $adminModel->where(array('admin_id' => array('not in', $cids)))->limit(10)->select();


	$this->assign('fen', (array) $fen);
	$this->assign('myAttention', (array) $myAttention);
	$this->assign('recommend', (array) $recommend);
	$this->assign('cids', $cids);

	$this->display();
    }
    
    public function thumb() {
	$uid = session(getSessionUidKey());
	$thumb = D("Admin")->where(['admin_id' => $uid])->getField('thumb');
	$this->assign('thumb', $thumb);
	$this->display();
    }

    /**
     * 上传图像
     */
    public function upload() {

	$defaulConfig = [
	    'maxSize' => 1 * 1000 * 1000, // 设置上传图片的大小
	    'exts' => array('jpg', 'gif', 'png', 'jpeg'), // 设置附件上传类型 
	    'rootPath' => './avatar/', //保存根路径
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
	    $imgFullUrl = FACE_URL . $imgPath;
	    $imgFullPath = $defaulConfig['rootPath'] . $imgPath;

	    $ret['imgFullUrl'] = $imgFullUrl;
	    $ret['imgFullPath'] = $imgFullPath;
	    $ret['imgPath'] = $imgPath;
	    $ret['status'] = 1;
	    $ret['message'] = 'success';
	} else {
	    $error = $upload->getError();
	    $ret['message'] = $error;
	    $ret['status'] = 0;
	}
	echo json_encode($ret);
    }

    /**
     * 剪切图像,覆盖之前的图片
     */
    public function cutpic() {

	$startX = I('post.x', 0, 'intval');
	$startY = I('post.y', 0, 'intval');
	$width = I('post.w', 0, 'intval');
	$height = I('post.h', 0, 'intval');
	$filePath = I('post.path');
	$file = I('post.f');
	// $filePath = getFilePath($file);

	$image = new \Think\Image();
	$image->open($file);

	$res = $image->crop($width, $height, $startX, $startY)->save($file);

	$data = [
	    'status' => 1,
	    'data' => FACE_URL . $filePath . '?f=' . uniqid(),
	    'info' => '裁剪图像成功'
	];

	// 更新用户图像
	$uid = session(getSessionUidKey());
	D('Admin')->where(['admin_id' => $uid])->save(['thumb' => $filePath]);

	echo json_encode($data);
    }

    

    /**
     * 关注好友 follow 添加一条记录
     * @param type $id
     */
    public function follow($id) {
	$fid = (int) $id;
	$follow = M('follow');
	$uid = session(getSessionUidKey());

	$data = ['uid' => $uid, 'fid' => $fid];
	$res = $follow->where($data)->find();

	if ($res == null) {
	    $follow->add($data);
	    session('followOk', '关注成功!');
	} else if (is_array($res)) {
	    session('followError', '已经关注了, 不能重复关注! ');
	}
	$this->redirect('Index/users');
    }

    /**
     * @取消关注
     */
    public function nofollow($id) {
	$fid = (int) $id;
	$uid = session(getSessionUidKey());
	$follow = M('follow');
	$data = ['uid' => $uid, 'fid' => $fid];
	//检查是否已经关注了
	$res = $follow->where($data)->find();

	if ($res) {
	    $follow->where($data)->delete();
	    echo $follow->_sql();
	    session('followOk', '取消关注成功! ');
	} else {
	    session('followError', '取消关注失败' . M('follow')->getError() . ' ! ');
	}
	$this->redirect('Index/users');
    }

    /**
     * @后台退出页面
     */
    public function logout() {
	//return $this->goHome();
	session(null);     // 删除所有session
	return $this->redirect('Login/index');
    }

    // 我的消息 好友发送给我的
    public function myReceive() {
	$uid = session(getSessionUidKey());
	$where = ['tid' => $uid];
	$order = 'send_time desc';
	
	$Msg = M('msg');
	
	$pageSize = 1;
	$count = $Msg->where($where)->count(); // 查询满足要求的总记录数
	$Page = new \Think\Page($count, $pageSize); // 实例化分页类 传入总记录数和每页显示的记录数(25)
	$Page->setConfig('prev', '«');
	$Page->setConfig('next', '»');
	$Page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
	$pagelist = $Page->show(); // 分页显示输出

	$prefix = C('DB_PREFIX') ;
	
	#$list = $Msg->where($where)->order($order)->limit($Page->firstRow . ',' . $Page->listRows)->select();
	# "SELECT * FROM {$prefix}.`msg` WHERE `fid` = 1 ORDER BY send_time desc LIMIT 0,6"

	$field = [$prefix.'msg.*', $prefix.'admin.nickname' => 'nickname'];
	$list = $Msg->field($field)->join('LEFT join  __ADMIN__  ON __ADMIN__.admin_id = __MSG__.fid')
			->where($where)->order($order)->limit($Page->firstRow . ',' . $Page->listRows)->select();

	// $Model = M('User');
	//$Model->alias('a')->join('__DEPT__ b ON b.user_id= a.id')->select();


	$this->assign('list', $list);     // 赋值数据集
	$this->assign('page', $pagelist);    // 赋值分页输出

	$this->display();
    }

    // 我的发送
    public function mySend() {
	$Msg = M('Msg');
	
	$uid = session(getSessionUidKey());
	$where = ['fid' => $uid ];
	$order = ['send_time'=>'DESC'];
	
	$pageSize = 6;
	$count = $Msg->where($where)->count(); // 查询满足要求的总记录数
	$Page = new \Think\Page($count, $pageSize); // 实例化分页类 传入总记录数和每页显示的记录数(25)
	$Page->setConfig('prev', '«');
	$Page->setConfig('next', '»');
	$Page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
	$pagelist = $Page->show(); // 分页显示输出
	
	$prefix = C('DB_PREFIX');
	$list = $Msg->field("{$prefix}msg.*, {$prefix}admin.nickname")->join('LEFT JOIN __ADMIN__ ON __MSG__.tid = __ADMIN__.admin_id')->
		where($where)->order($order)->limit($Page->firstRow . ',' . $Page->listRows)->select();
	
	
	$this->assign('list', $list);     // 赋值数据集
	$this->assign('page', $pagelist);    // 赋值分页输出
	
	$this->display();
    }

    // 发送消息
    public function sendMsg() {
	$uid = session(getSessionUidKey());

	if (IS_POST) {
	    $Msg = D('Msg');
	    $postData = I('post.Msg');
	    if ($Msg->create($postData)) {
		$res = $Msg->add($postData);
		$data = array(
		    'code' => 0,
		    'insert_id' => $res,
		    'msg' => '发送成功',
		    'return_url' => U('mysend'), // 我的发送列表页
		);
	    } else {
		$data = array(
		    'code' => 1,
		    'msg' => $Msg->getError(),
		);
	    }
	    echo json_encode($data);
	    exit;
	} else {
	    $fenIds = M('follow')->where(['fid' => $uid])->getField('uid', true);
	    $select = M('Admin')->where(['admin_id' => ['in', $fenIds]])->getField('admin_id,nickname');
	    $this->select = $select;
	    $this->display();
	}
    }

    /**
     * @read read mesage
     */
    public function read($id) {

	$mid = (int) $id;
	$Msg = M('msg');
	$Admin = D('Admin');

	// 此处没有使用连接查询
	$message = $Msg->find($mid);
	$from = $Admin->getUserById($message['fid'], 'nickname');
	$from && $from = $from['nickname'];

	$to = $Admin->getUserById($message['tid'], 'nickname');
	$to && $to = $to['nickname'];

	$message['from'] = $from;
	$message['to'] = $to;

	// 设置为已读
	if ($message && $message['status'] == 0) {
	    $Msg->save(['status' => 1, 'id' => $mid]);
	    $num = session('msg');
	    $num > 0 && session('msg', --$num);
	}
	$this->message = $message;
	$this->display();
    }

    // 回复消息
    public function reply() {
	if (IS_AJAX) {
	    $data = I('post.Msg');
	    $data['send_time'] = time();

	    if (M('Msg')->add($data)) {
		$arr['status'] = 1;
	    } else {
		$arr['status'] = 0;
	    }
	    echo json_encode($arr);
	}
    }

    public function pull() {
	if (IS_AJAX) {
	    $arr = array();
	    $uid = session(getSessionUidKey());
	    $num = session('msg');
	    $where = ['tid' => $uid, 'status' => 0]; // 未读消息
	    $msgNum = M('msg')->where($where)->count();
	    if ($msgNum != $num) {
		session('msg', $msgNum);
		$arr['msgnum'] = $msgNum;
		$arr['status'] = 1;
	    } else {
		$arr['status'] = 0;
	    }
	    echo json_encode($arr);
	}
    }
}
