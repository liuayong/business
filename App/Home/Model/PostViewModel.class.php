<?php

namespace Home\Model ;

class PostViewModel extends \Think\Model\ViewModel {
    
    public $viewFields = array(
       'Post'=>array('post_id' ,'title','create_time','cate_id','content','view_count','tags','reply_count', 'is_deleted', 'status_is', 'sort_order'),
        'Cate'  =>  array('cate_name', '_on'=>'Post.cate_id=Cate.id')
    );
}
?>
