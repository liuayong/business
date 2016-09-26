<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Blog By ThinkPHP 3.0</title>
    <link href="/business/static/blog/css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/business/static/plugins/ztree/css/demo.css" type="text/css">
    <link rel="stylesheet" href="/business/static/plugins/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <script type="text/javascript" src="/business/static/blog/js/prototype.js"></script>
    <script type="text/javascript" src="/business/static/blog/js/mootools.js"></script>
    <script type="text/javascript" src="/business/static/plugins/ztree/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="/business/static/plugins/ztree/js/jquery.ztree.core.js"></script>
    <!--- ThinkAjax 依赖于 js库 prototype -->
    <script type="text/javascript" src="/business/static/blog/js/ThinkAjax.js"></script>
    <script type="text/javascript" src="/business/static/blog/js/common.js"></script>
    <script type="text/javascript" src="/business/static/blog/js/base.js"></script>
    <script language="JavaScript">
    //指定当前组模块URL地址
    var URL = '/business/index.php/Home/Post';
    var APP = '/business/index.php';
    var PUBLIC = '/business/static';
    var doComment = '<?php echo U("Post/comment");?>'
    ThinkAjax.updateTip = '<IMG SRC="/business/static/blog/images/loading2.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="loading..." align="absmiddle"> 数据处理中...';
    </script>
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
                <div class="article-top">
                    <div class="prev-article" title="上一篇" ><a href="<?php echo U('Post/view', array('id'=>$prevData['post_id']));?>"> <?php echo ($prevData["title"]); ?> </a></div>
                    <div class="next-article" title="下一篇" ><a href="<?php echo U('Post/view', array('id'=>$nextData['post_id']));?>"> <?php echo ($nextData["title"]); ?> </a></div>
                </div>
                <div class="textbox-title">
                    <h4>
                            <img width="11" height="11" border="0" align="absmiddle" src="/business/static/blog/images/icon_point2.gif">  <?php echo ($post["title"]); ?> 
                        </h4>
                    <div class="textbox-label">
                        <span style="color:gray;font-weight:normal">
                                [ <img width="17" height="16" border="0" align="absmiddle" src="/business/static/blog/images/write.gif" />  <?php echo (date("Y-m-d H:i:s",$post["create_time"])); ?>
                                发表在 <a href="<?php echo U('Cate/index', ['id'=>$post['cate_id']]);?>"><?php echo ($cateData[$post['cate_id']]); ?></a>  ]
                            </span>
                    </div>
                </div>
                <div class="textbox-content">
                    <?php echo (htmlspecialchars_decode($post["content"])); ?>
                </div>
                <!-- 附件
                    <fieldset style="width:75%;margin:8px;color:gray">
                        <legend>附件列表</legend>
                        <div>
                            还没有上传任何附件 
                        </div>
                    </fieldset>
                    -->
                <div class="left">  关键词: <?php echo (showTags($post["tags"])); ?> </div>
                <div class="textbox-bottom">
                    <sup style="color:silver;font-size:12px">[<span title="回复数" style="color:#3366CC">回复数: <?php echo ($post["reply_count"]); ?> </span> | <span style="color:#FF6600" title="浏览量">浏览量: <?php echo ($post["view_count"]); ?> </span>]</sup>
                    <img width="12" height="12" border="0" align="" src="/business/static/blog/images/cm_t_ArtRank2.gif" />
                    <a href="<?php echo U('Post/view#reply', ['id'=>$post['post_id']]);?>">我有话要说</a>
                </div>
                <div align="right" class="textbox-urls"></div>
                <!--
                    <div class="no-comment-box"> 
                        [ 管理：<a target="_blank" href="<?php echo U('Post/edit', array('id'=>$post['post_id']));?>">编辑日志</a> 
                        <a href="javascript:delBlog(<?php echo ($post['post_id']); ?>)">删除日志</a> ]
                    </div>
                    -->
                <script type="text/javascript">
                function delComplete(data, status) {
                    if (status == 1) {
                        $('comment_' + data).style.display = 'none';
                    }
                }

                function delComment(id) {
                    ThinkAjax.send('/business/index.php/Home/Post/delComment', 'ajax=1&id=' + id, delComplete);
                }

                function doComplete(data, status) {
                    if (status == 1) {
                        $('comments').innerHTML += '<div id="comment_' + data.id + '" class="commentbox" style="border:1px solid #56CD2E;"><div class="commentbox-content"> ' + data.content + ' </div></div>';
                        $('form1').reset();
                        fleshVerify();
                    }
                }
                </script>
                <!-- 评论部分 -->
                <div id="comments">
                    <?php echo ($comment_list_html); ?>
                </div>
                <a name="reply"></a>
                <div id="comment">
                    <div class="result none" id="result"></div>
                    <form id="form1" method="post">
                        <table width="500" cellspacing="3" cellpadding="3">
                            <tbody>
                                <tr>
                                    <td class="tRight tTop"></td>
                                    <td class="tLeft">
                                        用户名：
                                        <input type="text" class="text" name="nickname" /> 邮箱:
                                        <input type="text" class="text" name="email" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tRight tTop"></td>
                                    <td class="tLeft">
                                        <textarea name="content" style="width:472px; height:120px;"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="center">
                                        <input type="hidden" value="1" name="ajax">
                                        <input type="hidden" value="Blog" name="module">
                                        <input type="hidden" value="<?php echo ($post["post_id"]); ?>" name="post_id">
                                        <div class="fLeft hMargin1">输入验证码 [ <a href="javascript:fleshVerify()">看不清？</a> ] <img height="30" align="absmiddle" src="<?php echo U('Post/verify');?>" id="verifyImg">
                                            <input type="text" class="small text" name="verify">
                                        </div>
                                        <div class="fLeft hMargin">
                                            <input type="reset" value="重 置"  class="submit small">
                                        </div>
                                        <div class="fLeft hMargin">
                                            <input type="button" class="submit small" onclick="ThinkAjax.sendForm('form1', doComment, doComplete, 'result');" value="发表评论" id="submit">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
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