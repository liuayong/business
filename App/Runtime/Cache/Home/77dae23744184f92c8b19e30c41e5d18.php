
/**
 * ztree树状结构
 * @param type $pid
 */
public function ztree($pid = 0) {
$pid = I('pid', 0, 'intval');
#C('show_page_trace', fasle);

// 使用缓存
$key = 'catelist-'.$pid ;
// 开发阶段不使用缓存
if (APP_DEBUG || !$data = S($key)) {
   
	$CateModel = D('MangerSystem/Cate');

	$parentKey = $CateModel->parent_id;
	$field = [$CateModel->getPk() => 'id', $parentKey => 'pid', 'cate_name' => 'name', 'cate_name_alias' => 'alias'];
	$data = $CateModel->field($field)->where([$parentKey => $pid])->getAll();
	$data = self::addColumn($data);
	APP_DEBUG || S($key, $data);
}

   echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

<include file="default/common/header" />