<?php

namespace MangerSystem\Model;

use Common\Components\Pinyin;

/**
 * {类型}模型
 */
class SpecialModel extends CommonModel {

    protected $_validate = [
        // array(field,rule,message,condition,type,when,params) 
        // array(field, url,'错误提示',self::VALUE_VALIDATE, callback, self:MODEL_BOTH , params) 
        ['special_name', 'require', '专题名称不能为空', self::MODEL_BOTH],
        ['name_alias', 'require', '专题的唯一标识不能为空'],
        ['name_alias', '', '专题的唯一标识名必须是唯一的', self::MUST_VALIDATE, 'unique', self::MODEL_INSERT],
    ];

    /**
     * 添加方法
     */
    public function _add() {
        $data = $this->data;
        // my_copy('./UploadsTemp/' . $data['cate_pic'], './Uploads/', true);
        // $data['content'] = str_replace('images/', '/Public/Home/images/', $data['content']);

        $this->data = $data;
        return parent::_add();
    }


    /**
     * 修改方法
     */
    public function _save() {
        $data = $this->data;

        /*
          // my_copy('./UploadsTemp/' . $data['cate_pic'], './Uploads/', true);
          // 删除原来的图片(原始图和缩略图)
          $pk = $this->pk;
          $row = $this->field(['cate_pic'])->find($data[$pk]);
          if ($row['cate_pic'] != $data['cate_pic']) {
          $srcImg = './Uploads/' . $row['cate_pic'];
          @unlink($srcImg);
          }
         */

        $this->data = $data;

        return parent::_save();
    }

    // 插入成功后的回调方法
    protected function _after_insert($data, $options) {
        
    }

    /**
     * 设置栏目的英文名称
     */
    protected function setCateEName() {
        $data = $this->data;
        $data['name_en'] = getLetters($data['name_zh']);
        $this->data = $data;
    }

    /**
     * 根据栏目名称 获取某个栏目下的 几篇文章
     */
    public function getCateNews($name, $cnt = 1, &$url) {
        $where = ['cate_name' => $name, 'cate_id' => $name, '_logic' => 'OR'];
        $cate_id = $this->where($where)->getField('cate_id');

        $where = ['cate_id' => $cate_id];

        $field = ['news_id', 'title', 'title_id', 'show_img', 'tag'];
        $data = D('News')->field($field)->where($where)->order(['sort_order' => 'desc'])->limit($cnt)->select();

        $url = U('/Home/Cate/index', ['id' => $cate_id]);
        return $data;
    }

    // 计算栏目的URL
    protected function calcCateUrl(&$data) {        // 传值 或者 像upImg 传递状态
        // 计算栏目跳转的urL
        if (trim($data['redirect_url']) == '') {
            if ($data[$this->parent_id] == 0) { // 对于顶级栏目的处理, 顶级栏目没有模板, 访问第一个子级栏目
                $sons = $this->getSons($data[$this->getPk()]);
                if ($sons) {
                    $data['cate_url'] = U('Home/Cate/index', ['id' => $sons[0]]);
                } else {
                    $data['cate_url'] = '';    // U('Home/Cate/index', ['id' => $data['cate_id']])
                }
            } else {

                $data['cate_url'] = '';
            }
        } else if (strpos($data['redirect_url'], 'http://') === 0 || strpos($data['redirect_url'], 'https://') === 0) {
            $data['cate_url'] = $data['redirect_url'];
        } else {
            // 加载静态页
        }
        return true;
    }

}
