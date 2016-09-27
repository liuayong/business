<?php

namespace MangerSystem\Model;

/**
 * {类型}模型
 */
class PostTagModel extends CommonModel {

    protected $_validate = [
            // array(field,rule,message,condition,type,when,params) 
    ];

    /**
     * tag 添加修改操作
     * @param type $method
     * @param type $tags
     * @param type $post_id
     * @param type $cate_id
     * @return type
     */
    public  function build($method = 'create', $tags = '', $post_id = 0, $cate_id = 0) {
        if (empty(trim($tags))) {
            return;
        }
        
        $tags_array = self::handleTags($tags);
        if ($method == 'create') {
            self::tagsCreate($tags_array, $post_id, $cate_id);
        } elseif ($method == 'update') {
            self::tagsUpdate($tags_array, $post_id, $cate_id);
        }
    }

    /**
     * 添加tags
     * @param array $tags_array
     * @param type $post_id 内容id
     * @param type $cate_id  分类id
     */
    protected  function tagsCreate(array $tags_array, $post_id, $cate_id) {
        $uid = session(getSessionUidKey());
        $nowtime = time() ;
        $addData = [];
        foreach ($tags_array as $tag) {
            $addData[] = array(
                'cate_id' => $cate_id,
                'post_id' => $post_id,
                'user_id' => $uid,
                'tag_name' => $tag,
                'create_time' => $nowtime,
            );
        }
        $this->addAll($addData);

        // 对 tags总表的操作
        $tagModel = M('tags');
        foreach ($tags_array as $tag) {
            $where = ['tag_name' => $tag];
            $findTag = $tagModel->where($where)->find();
            if ($findTag) {
                $tagModel->where($where)->save(['data_count' => ++$findTag['data_count']]);
            } else {
                $this->add(array(
                    'tag_name' => $tag,
                    'cate_id' => $cate_id,
                    'data_count' => 1,
                    'module' => 'post',
                    'create_time' => $nowtime
                ));
            }
        }
    }

    /**
     * 修改tags表
     * @param array $tags_array
     * @param type $cate_id
     */
    protected  function tagsUpdate(array $tags_array, $post_id, $cate_id) {
        $uid = session(getSessionUidKey());
        
        $where = ['post_id' => $post_id] ;
        $oldTags = (array)$this->where($where)->getField('tag_name', true);    
        
        $common = array_intersect($oldTags, $tags_array)   ;
        $notin_oldTags = array_diff($tags_array, $oldTags) ;
        $notin_newTags = array_diff($oldTags, $tags_array) ;
        
        
        $tagModel = M('tags') ;     // 总表tags
        $nowtime = time() ;
        
        // 不在新的 标签需要删除
        foreach($notin_newTags as $tag) {
            $where['tag_name'] = $tag ;
            $this->where($where)->delete() ;
            
            // tags总表的处理 减一 或者删除
            $tagData = $tagModel->where(['tag_name'=>$tag])->find();
            $pkVal = $tagData[$tagModel->getPk()] ;
            if($tagData['data_count'] > 1) {
                $tagModel->where(['tag_name'=> $tag])->save(['data_count'=> -- $tagData['data_count']]);
            } else {
                $tagModel->where(['tag_name'=> $tag])->delete($pkVal);
            }
        }
        
       # // 不在新的标签需要删除 $notin_newTags
       # $conditionWhere = ['tage_name'=> ['not in', $notin_newTags]];
       # $this->where(array_merge($where, $conditionWhere))->delete() ;
       # var_dump($this->_sql());
        
        // 不在原来的标签需要添加 $notin_oldTags
        $dataList = array();
        foreach ($notin_oldTags as $tag) {
            $dataList[] = array(
                'tag_name' => $tag,
                'cate_id' => $cate_id,
                'post_id' => $post_id,
                'user_id' => $uid,
                'create_time' => $nowtime,
            );
            
            // tags总表的处理 加1 或者新增
            $tagData = (array) $tagModel->where(['tag_name'=>$tag])->find();
            
            if($tagData) {
                $tagModel->where(['tag_name'=> $tag])->save(array('data_count'=>  $tagData['data_count']+1));
            } else {
                $addData = array(
                    'cate_id' => $cate_id,
                    'module' => 'post',
                    'tag_name' => $tag,
                    'data_count' => 1,
                    'create_time' => $nowtime,
                );
                $tagModel->add($addData);
            }
        }
        $this->addAll($dataList) ;
        
    }

    /**
     * 对用户传递过来的tags做处理
     * @param type $tags
     * @return type
     */
    protected  function handleTags($tags) {
        $tags = trimall($tags);
        $tags_array = array_unique(explode(',', str_replace('，', ',', $tags)));
        return $tags_array;
    }

}