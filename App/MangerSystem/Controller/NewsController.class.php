<?php
namespace MangerSystem\Controller ;
 

/**
 * 后台新闻表控制器
 */
class NewsController extends CommonController {

    /**
     * 新闻表列表
     */
    public function index() {
        $NewsModel = D('News');
        $data = $NewsModel->search();
        $this->assign('data',$data);
        $this->display();
    }
    
     /**
      * 新闻表列表 回收站
      */
    public function trashList() {
        $NewsModel = D('News');
        $deleteField = C('softDelField');
        $data = $NewsModel->search([$deleteField => 1]);
        $this->assign($data);
        $this->display();
    }

    /**
     * 从回收站还原操作
     */
    public function restore () {
        $id = I('id', 0, 'intval');
        $NewsModel = D('News');
        $ret = $NewsModel->toRestore($id);
        if ($ret) {
            $this->success("还原记录成功");
        } else {
            $this->error("还原记录失败: " . $NewsModel->getError());
        }
    }
    
    /**
     * 添加新闻表 
     */
    public function add() {
       if (IS_POST) {
            $Model = D('News');
            if ($Model->create()) {
                if ($Model->_add()) {
                    $this->success('添加成功!');
                } else {
                    $this->error('添加失败: ' . $Model->getError());
                }
            } else {
                $this->error('添加失败: ' . $Model->getError());
            }
        } else {
            $this->display();
        }
    }

    /**
     * 硬删除, 只有超级才有硬删除的权限
     */
     public function del() {
         $id = I('id', 0, 'intval');
        $Model = D('News');
        if(!$Model->isSuperAdmin()) {
            $this->error('只有超级才有删除的权限');
            return false ;
        }
        
        $ret = $Model->_delete($id);
        if ($ret) {
            $this->success("删除记录成功");
        } else {
            
            $this->error("删除记录失败: " . $AdminModel->getError());
        }
    }

    /**
     * 软删除 【单/多条记录】
     * @param type $id
     */
    public function toTrash($id) {
        $id = I('id', 0, 'intval');
        
        $NewsModel = D('News');
        $ret = $NewsModel->toTrash($id);
        if ($ret) {
            $this->success("删除记录成功");
        } else {
            $this->error("删除记录失败: " . $NewsModel->getError());
        }
    }

    /**
     * 修改新闻表     */
    public function upd() {
        $id = I('id', 0, 'intval');
        $Model = D('News');
        if (IS_POST) {
            if ($Model->create()) {
                if (($ret = $Model->_save()) !== FALSE ) {
                    $this->success('修改成功', U('index'));
                } else {
                    $errorInfo = $Model->getError() .(APP_DEBUG ? '' : ', ' . $Model->getLastSql());
                    $this->error('修改失败: ' . $errorInfo);
                }
            } else {
                $this->error('修改失败: ' . $Model->getError());
            }
        } else {
            $data = $Model->field($this->fields)->where($this->where)->find($id);
            $this->data = $data;
            $this->display();
        }
    }
    
    /**
     * 上传文件
     */ 
    public function upload() {

        $data = upload();
        echo json_encode($data);

//        $data = \Common\Components\PluginsInterface::upload();
//        echo json_encode($data);
    }
}


