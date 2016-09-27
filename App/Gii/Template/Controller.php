namespace <?php echo $moduleName; ?>\<?php echo $conLayer; ?> ;
<?php echo $useExpression ; ?> 

/**
 * 后台<?php echo $this->tableComment; ?>控制器
 */
class <?php echo $tpName. $conLayer ; ?> extends <?php echo $superControllerName; ?> {

    /**
     * <?php echo $this->tableComment; ?>列表
     */
    public function index() {
        $<?php echo $tpName; ?>Model = D('<?php echo $tpName; ?>');
        $data = $<?php echo $tpName; ?>Model->search();
        $this->assign('data',$data);
        $this->display();
    }
    
     /**
      * <?php echo $this->tableComment; ?>列表 回收站
      */
    public function trashList() {
        $<?php echo $tpName; ?>Model = D('<?php echo $tpName; ?>');
        $deleteField = C('softDelField');
        $data = $<?php echo $tpName; ?>Model->search([$deleteField => 1]);
        $this->assign($data);
        $this->display();
    }

    /**
     * 从回收站还原操作
     */
    public function restore () {
        $id = I('id', 0, 'intval');
        $<?php echo $tpName; ?>Model = D('<?php echo $tpName; ?>');
        $ret = $<?php echo $tpName; ?>Model->toRestore($id);
        if ($ret) {
            $this->success("还原记录成功");
        } else {
            $this->error("还原记录失败: " . $<?php echo $tpName; ?>Model->getError());
        }
    }
    
    /**
     * 添加<?php echo $this->tableComment; ?> 
     */
    public function add() {
       if (IS_POST) {
            $Model = D('<?php echo $tpName; ?>');
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
        $Model = D('<?php echo $tpName; ?>');
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
        
        $<?php echo $tpName; ?>Model = D('<?php echo $tpName; ?>');
        $ret = $<?php echo $tpName; ?>Model->toTrash($id);
        if ($ret) {
            $this->success("删除记录成功");
        } else {
            $this->error("删除记录失败: " . $<?php echo $tpName; ?>Model->getError());
        }
    }

    /**
     * 修改<?php echo $this->tableComment; ?>
     */
    public function upd() {
        $id = I('id', 0, 'intval');
        $Model = D('<?php echo $tpName; ?>');
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


