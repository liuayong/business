<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>栏目列表</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/business/public/css/common.css" rel="stylesheet">
    <script src="/business/public/js/jquery.2.1.4.js"></script>
</head>
<body>
    <div id="append_parent"></div>
    <div class="container" id="cpcontainer">
        <div id="contentHeader">
            <h3>栏目管理</h3>
            <div class="searchArea">
                <ul class="action left">
                    <li class="current"><a href="<?php echo U('add');?>" class="actionBtn"><span>录入</span></a></li>
                </ul>
                <div class="search right"> </div>
            </div>
        </div>
        <table class="content_list">
            <form method="post" action="" name="cpform">
                <tr class="tb_header">
                    <th width="8%"> ID</th>
                    <th width="8%"> 排序</th>
                    <th width="40%">名称</th>
                    <th>唯一标识</th>
                    <th>显示状态</th>
                    <th width="15%">录入时间</th>
                    <th>操作</th>
                </tr>
                <?php if(is_array($data)): foreach($data as $key=>$v): ?><tr class="tb_list">
                        <td> <input type="checkbox" name="id[]" value="<?php echo ($v["id"]); ?>"> <?php echo ($v["id"]); ?> </td>
                        <td> <input name="sort_order[<?php echo ($v["id"]); ?>]" type="text" id="sort_order" value="<?php echo ($v["sort_order"]); ?>" size="5" /> </td>
                        <td>
                             <?php echo ($v["preHtml"]); ?>
                            <a href="<?php echo U('add', ['id'=>$v['id']]);?>">
                                <img src="/business/public/images/insert.png" align="absmiddle" />
                            </a>
                            <a href="<?php echo U('upd', ['id'=>$v['id']]);?>"> <?php echo ($v["cate_name"]); ?> </a> [<?php echo ($v["cate_name_second"]); ?>] 
                            <?php if($v['img_thumb']): ?><img src="/business/public/images/image.png" align="absmiddle" /><?php endif; ?>
                        </td>
                        <td><?php echo ($v["cate_name_alias"]); ?></td>
                        <td>
                            <?php if($v['status_is'] == 'Y'): ?><img src="/business/public/images/icon_right.gif" alt="显示"  align="absmiddle" />
                            <?php else: ?>
                            <img src="/business/public/images/icon_error.gif" alt="隐藏"  align="absmiddle" /><?php endif; ?>
                        </td>
                        <td><?php echo (date("Y-m-d H:i:s",$v["create_time"])); ?></td>
                        <td>
                            <a href="<?php echo U('upd', ['id'=>$v['id']]);?>"  title="修改" alt="删除" >
                                <img src="/business/public/images/update.png" align="absmiddle" />
                            </a>
                            &nbsp;&nbsp;
                            <a href="<?php echo U('trash', ['id'=> $v['id']]);?>" title="删除" alt="删除"  class="confirmSubmit">
                                <img src="/business/public/images/delete.png" align="absmiddle" />
                            </a>
                        </td>
                    </tr><?php endforeach; endif; ?>
                <tr class="submit">
                    <td colspan="10">
                        <div class="cuspages right"> </div>
                        <div class="fixsel">
                            <input type="checkbox" name="chkall" id="chkall" onclick="checkAll(this.form, 'id')" />
                            <label for="chkall">全选</label>
                            <select name="command">
                                <option>选择操作</option>
                                <option value="sortOrder">排序</option>
                                <option value="delete">删除</option>
                                <option value="verify">显示</option>
                                <option value="unVerify">隐藏</option>
                            </select>
                            <input id="submit_maskall" class="button confirmSubmit" type="submit" value="提交" name="maskall" />
                        </div>
                    </td>
                </tr>
            </form>
        </table>
        <script type="text/javascript">
        $(function() {
         
            $(".confirmSubmit").click(function() {
                var text = this.title || this.alt ;
                if(this.id == 'submit_maskall') {
                    text = $(this).parents('tr.submit').find('select option:selected').text();
                }
                confirm('您在进行 '+ text +' 操作，确定继续？');
                return false ;
            });
            
            /**
             * 全选，反选的效果
             * @returns {undefined}
             */
            function selAll() {
                    $form = $('form[name=listForm]');       // 操作的表单
                    selectCheck = $('.selectAll[type=checkbox]', $form) ;
                    otherCheck = $('[type=checkbox][name=id\\[\\]]', $form) ;
                    btnSubmit = $('#btnSubmit', $form);
                    
                    selectCheck.click(function() {
                        otherCheck.prop('checked', this.checked);
                        
                        // 批量删除的按钮是否可以点击
                        btnSubmit.prop('disabled', otherCheck.filter(":checked").length == 0) ; 
                    });
                    otherCheck.click(function() {
                        var len1 = otherCheck.length ;
                        var len2 = otherCheck.filter(":checked").length ;
                        selectCheck.prop('checked', len1 === len2);
                        
                         // 批量删除的按钮是否可以点击
                        btnSubmit.prop('disabled', otherCheck.filter(":checked").length == 0) ; 
                    });
                }
        });
        </script>
    </div>
</body>
</html>