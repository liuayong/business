<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>后台管理 - <?php echo $this->tableComment; ?>列表</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="__PUBLIC__/css/common.css" rel="stylesheet">
    <link href="__PUBLIC__/css/tppager-yii.css" rel="stylesheet">
    <script src="__PUBLIC__/js/jquery.2.1.4.js"></script>
    <script src="__PUBLIC__/js/base.js"></script>
    <script type="text/javascript">
    var batchUrl  = "{:U('batch')}" ;
    $(function() {
        $("#title").val("{:I('get.title', '', 'trim')}");
        $("#catalogId").val("{:I('get.catalogId', 0, 'intval')}");
        $("#titleAlias").val("{:I('get.titleAlias', '', 'trim')}");
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
                    <li><a href="{:U('add')}" class="actionBtn"><span>录入</span></a></li>
                </ul>
                <div class="search right">
                    <form name="xform" class="right " id="searchForm" action="{:U('index')}" method="get">
                        <div style="display:none">
                            <input value="" name="" type="hidden">
                        </div>
                        <select name="catalogId" id="catalogId">
                            <option value="0"> ===全部内容=== </option>
                             <foreach name="tree" item="v">
                                <option value="{$v.id}">{$v.preHtml}{$v.cate_name}</option>
                            </foreach>
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
                    <foreach name="data" item="v">
                    <tr class="tb_list">
                        <td>
                            <input type="checkbox" value="{$v.post_id}" name="post_id[]"> {$v.post_id}
                        </td>
                        <td> <input name="sort_order[{$v.post_id}]" type="text" id="sort_order" value="{$v.sort_order}" size="5" /> </td>
                        <td>
                            <a style="" target="_blank" href="{:U('view', ['id'=>$v['post_id']])}"> {$v.title}</a>
                            &nbsp;<span class="alias"> [ {$v.title_alias} ] </span>
                        </td>
                        <td>{$cateData[$v['cate_id']]}</td>
                        <td><span>{$v.view_count}</span></td>
                        <td>
                            <if condition="$v['status_is'] eq 'Y'">
                                <img src="__PUBLIC__/images/icon_right.gif" alt="显示"  align="absmiddle" />
                                <else />
                                <img src="__PUBLIC__/images/icon_error.gif" alt="隐藏"  align="absmiddle" />
                            </if>
                        </td>
                        <td>{$v.create_time|date="Y-m-d H:i:s",###}</td>
                       <td>
                            <a href="{:U('upd', ['id'=>$v['post_id']])}"  title="修改" alt="删除" >
                                <img src="__PUBLIC__/images/update.png" align="absmiddle" />
                            </a>
                            &nbsp;&nbsp;
                            <a href="{:U('toTrash', ['id'=> $v['post_id']])}" title="删除" alt="删除"  class="confirmSubmit">
                                <img src="__PUBLIC__/images/delete.png" align="absmiddle" />
                            </a>
                        </td>
                    </tr>
                    </foreach>
                    <include file="Public/batchOperation"  page="{$page}"  name="post_id[]" /> 
                    <input type="hidden" name="batchfield" value="post_id" />
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>
