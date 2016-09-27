<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Blog By ThinkPHP 3.0-- <?php echo (THEME_NAME); ?></title>
        <link href="/business/static/blog/css/style.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="/business/static/plugins/ztree/css/demo.css" type="text/css">
        <link rel="stylesheet" href="/business/static/plugins/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
        <script type="text/javascript" src="/business/static/blog/js/jquery-2.2.4.js"></script>
        <script type="text/javascript" src="/business/static/plugins/ztree/js/jquery.ztree.core.js"></script>
    </head>
    <body>
        <div id="header">
    <div id="innerHeader">
        <div id="blogLogo"></div>
        <div class="blog-header">
            <div class="blog-desc">ThinkPHP [ Blog示例程序]</div>
        </div>
        <div id="menu">
           <ul>
                <li><a href="/business/index.php/Post">日志首页</a></li>
                <li><a href="#" onclick="alert('请登录后台撰写'); window.location.href='<?php echo U('MangerSystem/Post');?>'">撰写日志</a></li>
                <li><a href="<?php echo U('Tag/index');?>">标签云</a></li>
                <?php if(defined('THEME_NAME') && THEME_NAME == 'default') : ?>
                <li><a data-pjax="no" href="<?php echo U(CONTROLLER_NAME.'/'.ACTION_NAME , array_merge($_GET, array(C('VAR_TEMPLATE')=>'very')));?>">无刷新模式</a></li>
                <?php else : ?>
                <li><a data-pjax="no" href="<?php echo U(CONTROLLER_NAME.'/'.ACTION_NAME , array_merge($_GET, array(C('VAR_TEMPLATE')=>'default')));?>">普通模式</a></li>
                <?php endif; ?>
           </ul>
        </div>
    </div>
</div>
<!--
<script type="text/javascript" src="/business/static/blog/js/jquery.pjax.js"></script>
<script type="text/javascript">
jQuery(function($) {
    $('#content').pjax('div.pages div.pagination a, a',{timeout:5000});
});    
</script>
-->
        <!--中间部分-->
        <div id="mainWrapper">
            <div id="sidebar" class="sidebar">
                <div id="innerSidebar">
                    <div id="panelSearch" class="panel">
                        <?php echo ($statistics_html); ?>
                        <div class="panel-content">
    <h5>日志分类 </h5>
    <ul id="category" class="ztree">
        <li>
            <div class="fLeft">
                <input TYPE="text" id="categoryName" class="text" NAME="name">
            </div>
            <input TYPE="button" value="增 加" class="submit hMargin small" onclick="addCategory()">
            <br style="clear:both;float:auto" />
        </li>
    </ul>
</div>
<script type="text/javascript">
var setting = {
    async: {
        enable: true,
        url: "<?php echo U('Cate/ztree');?>",
        autoParam: ["id=pid", "level=lv"],
        otherParam: {
            "otherParam": "zTreeAsyncTest"
        },
        dataFilter: filter
    }
};

function filter(treeId, parentNode, childNodes) {
    if (!childNodes)
        return null;
    //for (var i=0, l=childNodes.length; i<l; i++) {
    //childNodes[i].name = childNodes[i].name.replace(/\.n/g, '.');
    //}
    return childNodes;
}


// 交还$控制权
jQuery.noConflict();
// Put all your code in your document ready area  
jQuery(document).ready(function($) {
    // 这样你可以在这个范围内随意使用$而不用担心冲突  
    $.fn.zTree.init($("#category"), setting);
});

/*
 // $ 符号 prototype 和 jquery 冲突
 $(document).ready(function() {
    $.fn.zTree.init($("#category"), setting);
 });
 */
//-->
function addCategory() {
    ThinkAjax.send('/tpdemo/ThinkPHP_3.0/Examples/Blog/index.php/Category/insert', 'ajax=1&title=' + $F('categoryName'), addComplete);
}

function addComplete(data, status) {
    if (status == 1) {
        $('category').innerHTML += '<li id="category_' + data.id + '">' +
            '<img src="/business/static/blog/images/folder.gif" width="18" height="18" border="0" alt="" align="absmiddle">' +
            '<a href="/tpdemo/ThinkPHP_3.0/Examples/Blog/index.php/Category/' + data.id + '">' + data.title + '</a> <span >(0)</span>' +
            +'<img src="/business/static/blog/images/del.gif" width="20" height="20" border="0" style="cursor:pointer" alt="" onclick="delCategory(' + data.id + ')" align="absmiddle" />';
    }
}

function delCategory(id) {
    ThinkAjax.send('/tpdemo/ThinkPHP_3.0/Examples/Blog/index.php/Category/delete/', 'ajax=1&id=' + id, delComplete);
}

function delComplete(data, status) {
    if (status == 1) {
        $('category_' + data).style.display = 'none';
    }
}
</script>

                    </div>
                    <?php echo ($new_post_html); ?>
                    <?php echo ($new_comment_html); ?>
                    <?php echo ($left_tags_html); ?>
                    <?php echo ($left_archive_html); ?>
                </div>
            </div>
            <div id="content" class="content">
                <div id="innerContent">
                    <div class="announce text">
                        <div class="announce-content" style="height:45px">
                            <h4>[ <?php echo ($cateInfo['cate_name']); ?> ] 下面的文章<span style="font-weight:normal"> [ <?php echo ($_cnt); ?> ] </span></h4>
                        </div>
                    </div>
                    <?php echo ($blog_list_html); ?>
                </div>
            </div>
        </div>
    <!-- 版权信息区域 -->
<div id="footer" class="footer">
    <div id="innerFooter">
        Powered by ThinkPHP 3.0 | Template designed by <a target="_blank" href="http://www.topthink.com.cn">TopThink</a>
    </div>
</div>
</body>
</html>