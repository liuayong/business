<table cellpadding="3" cellspacing="1">
    <tr>
        <th>
            <input type="checkbox" class="selectAll" /> 
            <a href="javascript:;" onclick="listTable.sort('id', this);" title="点击对列表排序">ID编号</a>
        </th>
        <th>
            <a href="javascript:;" onclick="listTable.sort('name', this);" title="点击对列表排序">管理员名称</a>
        </th>
        <th>
            <a href="javascript:;" onclick="listTable.sort('email', this);" title="点击对列表排序">管理员邮箱</a>
        </th>
        <th>
            <a href="javascript:;" onclick="listTable.sort('sort', this);" title="点击对列表排序">推荐排序</a>
        </th>
        <th>
            <a href="javascript:;" onclick="listTable.sort('is_active', this);" title="点击对列表排序">状态(激活/禁用)</a>
        </th>
        <th>
            <a href="javascript:;" onclick="listTable.sort('create_time', this);" title="点击对列表排序">加入时间</a>
        </th>
        <th>
            <a href="javascript:;" onclick="listTable.sort('last_ip', this);" title="点击对列表排序">最后登录IP</a>
        </th>
        <th>
            <a href="javascript:;" onclick="listTable.sort('last_login', this);" title="点击对列表排序">最后登录时间</a>
        </th>
        <th>
            <label for="multFields"  title="多字段联动排序" >排序</label>
            <input type="checkbox" id="multFields" class="multFields"  title="多字段联动排序" />　　操作</th>
    </tr>
    <?php foreach($data as $k=>$v) : ?>
    <tr>
        <td align="center"><input type="checkbox" name="id[]" value="<?php echo $v['id']; ?>"/> <?php echo $v['id']; ?></td>
        <td align="center"><?php echo $v['name']; ?></td>
        <td align="center"><?php echo $v['email']; ?></td>
        <td align="center"><input type="text" value="<?php echo $v['sort']; ?>" size="5" name="sort[<?php echo $v['id']; ?>]" /></td>
        <td align="center" class="ajax"><?php echo showBooleanStatus($v['is_active'], 'is_active'); ?></td>
        <td align="center"><?php echo date("Y-m-d H:i:s", $v['create_time']); ?></td>
        <td align="center"><?php echo $v['last_ip']; ?></td>
        <td align="center"><?php echo date("Y-m-d H:i:s", $v['last_login']); ?></td>
        <td align="center">
            <a href="{:U('upd', ['id' => $v['id'] ])}" title="编辑">编辑</a> |
            <a href="{:U('del', ['id' => $v['id'] ])}" title="编辑">移除</a> 
        </td>
    </tr>
    <?php endForeach; ?>
    <tr>
        <td align="left" nowrap="true" colspan="2">
            <select id="selAction" name="opertype">
                <option value="">请选择...</option>
                <option value="trash">放入回收站</option>
                <option value="active">激活</option>
                <option value="forbidden">禁用</option>
            </select>
            <input type="submit" class="button  operate" id="btnSubmit" disabled="true" value=" 确定 ">
        </td>
        <td align="center" nowrap="true" colspan="6">
            <div id="turn-page" class="page">
                <?php echo $Page->ajaxShow(); ?>
            </div>
        </td>
        <td align="" nowrap="true">
            <input type="submit" class="button sort"   value="设置推荐排序">
        </td>
    </tr>
</table>