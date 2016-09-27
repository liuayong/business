<?php if (!defined('THINK_PATH')) exit();?><!----- 日志归档 ----->
<div id="panelSearch" class="panel">
    <h5>日志归档</h5>
    <div class="panel-content">
        <ul>
            <?php if(is_array($_archive_months)): foreach($_archive_months as $key=>$v): ?><li>
                    <img src="/business/static/blog/images/icon_quote.gif" width="11" height="11" border="0" alt="" align="absmiddle" />
                    <a href="<?php echo U('Post/archive', ['year'=>$v['year'], 'month'=>$v['month']]);?>"><?php echo (date("Y年m月",$v["timestamp"])); ?></a>
                </li><?php endforeach; endif; ?>
        </ul>
    </div>
</div>