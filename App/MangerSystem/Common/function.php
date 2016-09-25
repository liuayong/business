<?php

function descMsgNum() {
    $num = session('msg');
    if ($num > 0) {
	session('msg', --$num);
    }
}


/**
 * 有图片形象的显示状态
 * @param type $status 状态值
 * @param type $type   状态属性
 */
function showBooleanStatus($status) {
    $map = [1 => 'icon_right.gif', 0 => 'icon_error.gif'];
    $imgTag = '<img src="' . __ROOT__ . '/Public/images/' . $map[$status] . '"/>';

    return $imgTag;
    //  echo '<img src="__PUBLIC__/Admin/images/no.gif" alt="未激活" />';
}