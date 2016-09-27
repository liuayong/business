<?php if (!defined('THINK_PATH')) exit();?><!----- 最新评论 ----->
<div id="panelSearch" class="panel">
    <h5>最新评论</h5>
    <div class="panel-content">
        <ul>
            <?php if(is_array($_new_comment)): foreach($_new_comment as $key=>$v): ?><li>
                <img src="/business/static/blog/images/Comment.gif" width="9" height="9" border="0" alt="" align="absmiddle" />
                <a href="mailto:<?php echo ($v["email"]); ?>"> <span style="color:#3366CC"><?php echo ($v["nickname"]); ?></span></a> ：<a href="<?php echo U('Post/view#'.$v['comment_id'], ['id'=>$v['post_id']]);?>" title="<?php echo ($v["content"]); ?>"><?php echo ($v["content"]); ?></a>
            </li><?php endforeach; endif; ?>
        </ul>
    </div>
</div>