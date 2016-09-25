<?php

namespace Collect\Model;

use Think\Model;

class CollectModel extends Model {

    // 自动完成
    protected $_auto = array(
	array('create_time', 'time', self::MODEL_INSERT, 'function'), // 对create_time字段在添加的时候写入当前时间戳
	array('update_time', 'time', self::MODEL_BOTH, 'function'), // 对update_time字段在添加/更新的时候写入当前时间戳
    );

}
