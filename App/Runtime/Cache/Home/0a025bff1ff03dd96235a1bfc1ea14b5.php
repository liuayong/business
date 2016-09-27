<?php if (!defined('THINK_PATH')) exit();?><!----- 标签云集 ----->
<div id="panelSearch" class="panel">
    <h5>标签云集 [ <a href="<?php echo U('Tag/index');?>">更多</a> ]</h5>
    <div class="panel-content">
        <ul>
            <li>
            <?php if(is_array($_left_tags)): foreach($_left_tags as $key=>$v): ?><a title="<?php echo ($v["data_count"]); ?>条内容" href="<?php echo U('Tag/post', ['name' => urlencode($v['tag_name'])]);?>">
                    <span style="font-size:<?php echo (getTitleSize($v['data_count'])); ?>;color:<?php echo rand_color();?>"><?php echo ($v['tag_name']); ?></span>
                </a>&nbsp;&nbsp;&nbsp;<?php endforeach; endif; ?>
            </li>
        </ul>
    </div>
</div>