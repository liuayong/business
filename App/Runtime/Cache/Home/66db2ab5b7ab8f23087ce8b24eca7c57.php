<?php if (!defined('THINK_PATH')) exit();?><div id="innerContent">
    <div class="announce text">
        <div class="announce-content" style="height:45px">
            <h4>[ <?php echo ($cateInfo['cate_name']); ?> ] 下面的文章<span style="font-weight:normal"> [ <?php echo ($_cnt); ?> ] </span></h4>
        </div>
    </div>
    <?php echo ($blog_list_html); ?>
</div>