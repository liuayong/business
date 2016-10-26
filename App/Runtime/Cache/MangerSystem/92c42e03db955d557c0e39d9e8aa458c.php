<?php if (!defined('THINK_PATH')) exit(); if(is_array($gallary)): foreach($gallary as $key=>$v): ?><li id="image_<?php echo ($v["attach_id"]); ?>">
    <a target="_blank" href="<?php echo (IMG_URL); echo ($v["img_original"]); ?>">
        <img width="40" align="absmiddle" height="40" src="<?php echo (IMG_URL); echo ($v["img_original"]); ?>" />
    </a>&nbsp; <br>
    <a href="javascript:uploadifyRemove('<?php echo ($v["attach_id"]); ?>', 'image_', <?php echo ($v["gallary_id"]); ?>)">删除</a>
    <input type="hidden" value="<?php echo ($v["attach_id"]); ?>" name="imageList[fileId][]">
    <input type="hidden" value="<?php echo ($v["img_original"]); ?>" name="imageList[file][]">
</li><?php endforeach; endif; ?>