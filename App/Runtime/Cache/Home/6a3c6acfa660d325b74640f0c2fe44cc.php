<?php if (!defined('THINK_PATH')) exit();?>
<!-- 顶部分页 -->
<div class="article-top">
    <div class="view-mode">浏览模式: <a href="<?php echo U(CONTROLLER_NAME.'/'.ACTION_NAME , array_merge($_GET, array('mode'=>'normal')));?>">普通</a> | <a href="<?php echo U(CONTROLLER_NAME.'/'.ACTION_NAME, array_merge($_GET, array('mode'=>'intro')));?>">简介</a></div>
    <div class="pages">
        <?php echo ($pagelist); ?>
    </div>
</div>

<!-- 文章列表 [ 普通的列表:normal  简介的列表：intro ] -->
<?php switch($mode): case "normal": if(is_array($_blog_list)): foreach($_blog_list as $key=>$v): ?><div class="textbox-list">
            <div class="textbox-list-title">
                <img src="/business/static/blog/images/icon_point2.gif" width="13" height="13" border="0" alt="" align="absmiddle" /> 
                [ <a href="<?php echo U('Cate/index', ['id' => $v['cate_id']]);?>"><?php echo ($v["cate_name"]); ?></a> ] 
                <a href="<?php echo U('Post/view', ['id' => $v['post_id']]);?>"><?php echo ($v["title"]); ?></a> 
                <span class="pubtime"><?php echo (date("Y-m-d",$v["create_time"])); ?></span>
            </div>
            <div class="textbox-author"> 
                [<a href="<?php echo U('Post/view#reply', ['id' => $v['post_id']]);?>"><span title="回复数"><?php echo ($v["reply_count"]); ?> </span></a> | <span title="浏览量"> <?php echo ($v["view_count"]); ?> </span>]
            </div>
        </div><?php endforeach; endif; break;?>
    <?php case "intro": if(is_array($_blog_list)): foreach($_blog_list as $key=>$v): ?><div id="blog_<?php echo ($v["post_id"]); ?>">
            <div class="textbox-title">
                <h4>
                    <img width="13" border="0" align="absmiddle" height="13" alt="" src="/business/static/blog/images/icon_point2.gif" />
                    <a href="<?php echo U('Post/view', ['id' => $v['post_id']]);?>"><?php echo ($v["title"]); ?></a> 
                </h4>
                <div class="textbox-label">
                    [ <?php echo (date("Y-m-d H:i:s",$v["create_time"])); ?> | <a href="<?php echo U('Cate/index', ['id' => $v['cate_id']]);?>"><?php echo ($v["cate_name"]); ?></a> ]
                </div>
            </div>
            <div class="textbox-content">
                <?php echo (getIntro($v["content"])); ?>
            </div>
            <div class="textbox-bottom">
                <a class="left more" href="<?php echo U('Post/view', ['id' => $v['post_id']]);?>">查看更多</a> 
                <!--[ 管理：<a href="javscript:;">编辑</a> <a href="javascript:delBlog(22)">删除</a> ]--> 
                关键词: <?php echo ($v["tags"]); ?>| <a href="<?php echo U('Post/view#reply', ['id' => $v['post_id']]);?>"><span title="评论:">评论: <?php echo ($v["reply_count"]); ?> </span></a> | <span title="浏览量">浏览: <?php echo ($v["view_count"]); ?> </span> 
            </div>
        </div><?php endforeach; endif; break;?>
    <?php default: endswitch;?>

<!-- 尾部分页 -->
<div class="article-bottom">
    <div class="pages"> 
        <?php echo ($pagelist); ?>
    </div>
</div>