<?php if (!defined('THINK_PATH')) exit();?><div id="panelStats" class="panel">
    <h5>统计数据</h5>
    <div class="panel-content">
        创建日期：<span style="color:#CC9933"><?php echo (date("Y-m-d",$_statistics_data["begin_time"])); ?></span>
        <br /> 日志总数：
        <span style="color:#CC9933"><?php echo ($_statistics_data["post_count"]); ?></span>
        <br /> 阅读总数：
        <span style="color:#6699FF"><?php echo ($_statistics_data["view_count"]); ?></span>
        <br /> 评论总数：
        <span style="color:#FF9900"><?php echo ($_statistics_data["reply_count"]); ?></span>
        <br />
    </div>
</div>