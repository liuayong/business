<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>内容列表</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/business/public/css/common.css" rel="stylesheet">
    <link href="/business/public/css/tppager-yii.css" rel="stylesheet">
    <script src="/business/public/js/jquery.2.1.4.js"></script>
    <script src="/business/public/js/base.js?id=3"></script>
    <script type="text/javascript">
    var batchUrl  = "<?php echo U('batch');?>" ;
    $(function() {
        $("#title").val("<?php echo I('get.title', '', 'trim');?>");
        $("#catalogId").val("<?php echo I('get.catalogId', 0, 'intval');?>");
        $("#titleAlias").val("<?php echo I('get.titleAlias', '', 'trim');?>");
    });
    </script>
</head>
<body>
    <div id="append_parent"></div>
    <div class="container" id="cpcontainer">
        <div id="contentHeader">
            <h3>内容管理</h3>
            <div class="searchArea">
                <ul class="action left">
                    <li><a href="<?php echo U('add');?>" class="actionBtn"><span>录入</span></a></li>
                </ul>
                <div class="search right">
                    <form name="xform" class="right " id="searchForm" action="<?php echo U('index');?>" method="get">
                        <div style="display:none">
                            <input value="" name="" type="hidden">
                        </div>
                        <select name="catalogId" id="catalogId">
                            <option value="0"> ===全部内容=== </option>
                             <?php if(is_array($tree)): foreach($tree as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["preHtml"]); echo ($v["cate_name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                        标题
                        <input id="title" name="title" value="" class="txt" size="15" type="text"> 别名
                        <input id="titleAlias" name="titleAlias" value="" class="txt" size="15" type="text">
                        <input  value="查询" class="button " type="submit">
                    </form>
                </div>
            </div>
        </div>
        <form name="cpform" action="" method="post">
            <table cellspacing="0" cellpadding="0" border="0" class="content_list">
                <thead>
                    <tr class="tb_header">
                        <th width="8%">ID</th>
                        <th width="10%">排序</th>
                        <th>标题</th>
                        <th width="16%">分类</th>
                        <th width="5%">浏览</th>
                        <th width="5%">状态</th>
                        <th width="15%">录入时间</th>
                        <th width="8%">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($data)): foreach($data as $key=>$v): ?><tr class="tb_list">
                        <td>
                            <input type="checkbox" value="<?php echo ($v["post_id"]); ?>" name="post_id[]"> <?php echo ($v["post_id"]); ?>
                        </td>
                        <td> <input name="sort_order[<?php echo ($v["post_id"]); ?>]" type="text" id="sort_order" value="<?php echo ($v["sort_order"]); ?>" size="5" /> </td>
                        <td>
                            <a style="" target="_blank" href="<?php echo U('view', ['id'=>$v['post_id']]);?>"> <?php echo ($v["title"]); ?></a>
                            &nbsp;<span class="alias"> [ <?php echo ($v["title_alias"]); ?> ] </span>
                        </td>
                        <td><?php echo ($cateData[$v['cate_id']]); ?></td>
                        <td><span><?php echo ($v["view_count"]); ?></span></td>
                        <td>
                            <?php if($v['status_is'] == 'Y'): ?><img src="/business/public/images/icon_right.gif" alt="显示"  align="absmiddle" />
                                <?php else: ?>
                                <img src="/business/public/images/icon_error.gif" alt="隐藏"  align="absmiddle" /><?php endif; ?>
                        </td>
                        <td><?php echo (date("Y-m-d H:i:s",$v["create_time"])); ?></td>
                       <td>
                            <a href="<?php echo U('upd', ['id'=>$v['post_id']]);?>"  title="修改" alt="删除" >
                                <img src="/business/public/images/update.png" align="absmiddle" />
                            </a>
                            &nbsp;&nbsp;
                            <a href="<?php echo U('toTrash', ['id'=> $v['post_id']]);?>" title="删除" alt="删除"  class="confirmSubmit">
                                <img src="/business/public/images/delete.png" align="absmiddle" />
                            </a>
                        </td>
                    </tr><?php endforeach; endif; ?>
                    <tr class="submit">
    <td colspan="10">
        <div class="cuspages right">
            <?php echo ($page); ?>
        </div>
        <div class="fixsel">
            <input type="checkbox" name="chkall" id="chkall" onclick="checkAll(this, 'post_id[]')" />
            <label for="chkall">全选</label>
            <select name="command">
                <option value="">选择操作</option>
                <option value="sortOrder">排序</option>
                <option value="totrash">删除</option>
                <option value="toshow">显示</option>
                <option value="unshow">隐藏</option>
            </select>
            <input id="submit_maskall" onclick="return batchAction(this, 'post_id[]');"  class="button confirmSubmit" type="submit" value="提交" name="maskall" />
        </div>
    </td>
</tr> 
                    <input type="hidden" name="batchfield" value="post_id" />
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>