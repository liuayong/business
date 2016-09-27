<?php if (!defined('THINK_PATH')) exit();?><!----- 最新日志 ----->
<div id="panelSearch" class="panel">
    <h5>最新日志</h5>
    <div class="panel-content">
        <ul>
            <?php if(is_array($_new_post_data)): foreach($_new_post_data as $key=>$v): ?><li>
                <img src="/business/static/blog/images/icon_ctb.gif" width="11" height="11" border="0" alt="" align="absmiddle" />
                <a href="<?php echo U('Post/view', ['id'=>$v['post_id']]);?>" title="<?php echo ($v["title"]); ?>"><?php echo (getShortContent($v["title"],15)); ?></a>
                <sup style="color:silver;font-size:12px">[<span style="color:#3366CC" title="回复数" > <?php echo ($v["reply_count"]); ?> </span> | <span  title="浏览量" style="color:#FF6600"> <?php echo ($v["view_count"]); ?> </span>]</sup>
            </li><?php endforeach; endif; ?>
        </ul>
    </div>
</div>