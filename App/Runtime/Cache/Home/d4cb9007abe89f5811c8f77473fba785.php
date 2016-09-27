<?php if (!defined('THINK_PATH')) exit(); if(!$_comments_list): ?><div class="no-comment-box">这篇日志还没有评论</div>
    <?php else: ?>
    <div class="comment-pages"><?php echo ($pagelist); ?></div>
    <?php if(is_array($_comments_list)): foreach($_comments_list as $key=>$comment): ?><div id="comment_<?php echo ($comment["comment_id"]); ?>" class="commentbox">
            <a name="<?php echo ($comment["comment_id"]); ?>"></a> 
            <div class="commentbox-title" > 
                <a href="mailto:<?php echo ($comment["email"]); ?>"><?php echo ($comment["nickname"]); ?></a> 发表的评论 <span style="color:gray">[ <?php echo (friendlyShowTime($comment["create_time"])); ?> ]</span>
                <!--<a href="javascript:delComment(<?php echo ($comment["comment_id"]); ?>)">删除评论</a>-->
            </div>
            <div class="commentbox-content"><?php echo (nl2br($comment["content"])); ?></div>
        </div><?php endforeach; endif; ?>
    <div class="comment-pages"><?php echo ($pagelist); ?></div><?php endif; ?>