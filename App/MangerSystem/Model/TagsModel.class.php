<?php

namespace MangerSystem\Model;

/**
 * {类型}模型
 */
class PostTagsModel extends CommonModel {

    /**
     * tags 操作
     * @param $method
     * @param $tags
     * @param $titleId
     * @param $model
     * @param $jumpUri
     */
    public static function build($method = 'create', $tags = '', $catalog_id = 0) {
        if (empty($tags)) {
            return;
        }

        $tags_array = self::handleTags($tags);
        if ($method == 'create') {
            self::tagsCreate($tags_array, $catalog_id);
        } elseif ($method == 'update') {
            self::tagsUpdate($tags_array, $catalog_id );
        }
    }
    
    /**
     * 添加tags
     * @param array $tags_array
     * @param type $cate_id
     */
    protected static  function tagsCreate(array $tags_array, $cate_id) {
        foreach ($tags_array as $tag) {
            $where = ['tag_name' => $tag] ;
            $findTag = $this->where($where)->find();
            if($findTag) {
                $this->where($where)->save(['data_count' => ++$findTag['data_count'] ]);
            } else {
                $this->add(array(
                    'tag_name' => $tag,
                    'cate_id' => $cate_id,
                    'data_count' => 1,
                    'create_time' => time()
                ));
            }
        }
    }
    
    /**
     * 修改tags表
     * @param array $tags_array
     * @param type $cate_id
     */
    protected static  function tagsUpdate(array $tags_array, $cate_id) {
        foreach ($tags_array as $tag) {
            $where = ['tag_name' => $tag] ;
            $findTag = $this->where($where)->find();
            
            if($findTag) {
                if($findTag['data_count']> 1) {
                    $this->where($where)->save(['data_count' => --$findTag['data_count'] ]);
                } else {
                    // 删除该条记录
                    $this->where($where)->delete($this->pk) ;
                }
            } else {
                
            }
            
        }
    }

    
    /**
     * 对用户传递过来的tags做处理
     * @param type $tags
     * @return type
     */
    protected static function handleTags($tags) {
        $tags = trimall($tags);
        $tags_array = array_unique(explode(',', str_replace('，', ',', $tags)));
        return $tags_array;
    }
}