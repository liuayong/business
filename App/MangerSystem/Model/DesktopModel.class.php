<?php

namespace MangerSystem\Model;

use Common\Components\Pinyin;

/**
 * {类型}模型
 */
class DesktopModel extends CommonModel {

    protected $_validate = [
        // array(field,rule,message,condition,type,when,params) 
        // array(field, url,'错误提示',self::VALUE_VALIDATE, callback, self:MODEL_BOTH , params) 
        ['name', 'require', '名称不能为空', self::MODEL_BOTH],
        ['original_icon', 'require', '图标不能为空'],
    ];

    /**
     * 添加方法
     */
    public function _add() {
        $data = $this->data;

        // 生成拼音
        if (empty($data['name_pinyin'])) {
            $data['name_pinyin'] = getLetters($data['name']);
        }

        $this->data = $data;
        return parent::_add();
    }

    /**
     * 修改方法
     */
    public function _save() {
        $data = $this->data;

        // 生成拼音
        if (empty($data['name_pinyin'])) {
            $data['name_pinyin'] = getLetters($data['name']);
        }

        $this->data = $data;
        return parent::_save();
    }

    // 插入成功后的回调方法
    protected function _after_insert($data, $options) {
        self::putInitData();
    }

    // 删除成功后的回调方法
    protected function _after_delete($data, $options) {
        self::putInitData();
    }

    // 更新成功后的回调方法
    protected function _after_update($data, $options) {
        self::putInitData();
    }

    /**
     * 像文件中写入初始化的数据
     * 用于显示桌面
     */
    public function putInitData($file = null) {
        if (empty($file) || !file_exists($file)) {
            $file = './static/desktop/shortcut.js';
            // $file = getRootPath(). 'static/shortcut.js' ; 
        }
        $data = $this->field(['name', 'thumb_icon', 'url', 'width', 'height'])->getAll();
        $data = $this->toJsArrayData($data);

        $newline = PHP_EOL ;
        $statement = "//id,iconName,iconUrl,url,width,height {$newline} var shortcut = {$newline}";
        $statement .= json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "; {$newline}";
        file_put_contents($file, $statement);
    }

    /**
     * 返回js需要的二维数组的数据
     * @param array $data
     * @return array
     */
    protected function toJsArrayData(array $data = array()) {
        $ret = array();
        foreach ($data as $k => $v) {
            $v['thumb_icon'] && $v['thumb_icon'] = IMG_URL . $v['thumb_icon'];
            $v = array_values($v);
            array_unshift($v, $k);
            $ret[] = $v;
        }
        return $ret;
    }

    // 计算URL
    protected function calcUrl(&$data) { // 传值 或者 像upImg 传递状态
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
