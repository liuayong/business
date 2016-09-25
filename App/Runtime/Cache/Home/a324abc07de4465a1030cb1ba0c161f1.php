<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Blog By ThinkPHP 3.0</title>
        <link href="/business/static/blog/css/style.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="/business/static/plugins/ztree/css/demo.css" type="text/css">
        <link rel="stylesheet" href="/business/static/plugins/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
        <script type="text/javascript" src="/business/static/plugins/ztree/js/jquery-1.4.4.min.js"></script>
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
                <li><a href="#">撰写日志</a></li>
                <li><a href="<?php echo U('Tag/index');?>">标签云</a></li>
            </ul>
        </div>
    </div>
</div>
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
        url: "<?php echo U('Post/ztree');?>",
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
                        <h4 style="color:#FF3300">
                            <img src="/business/static/blog/images/wav.gif" width="18" height="18" border="0" alt="" align="absmiddle" />
                            <div>简单的BLOG示例</div>
                        </h4>
                        <h3>刘阿勇的博客，欢迎访问</h3>
                        <p>请按照下面步骤操作，增加分类、添加日志、增加评论。</p>
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