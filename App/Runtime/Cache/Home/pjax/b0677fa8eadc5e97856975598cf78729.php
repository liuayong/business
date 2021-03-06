<?php if (!defined('THINK_PATH')) exit();?><!--
<script type="text/javascript" src="/business/static/blog/js/mootools.js"></script>
# ThinkAjax 依赖于 js库 prototype  
<script type="text/javascript" src="/business/static/blog/js/ThinkAjax.js"></script>
<script type="text/javascript" src="/business/static/blog/js/common.js"></script>
<script type="text/javascript" src="/business/static/blog/js/base.js"></script>
<script language="JavaScript">
    createScript("/business/static/blog/js/mootools.js");
    createScript("/business/static/blog/js/ThinkAjax.js");
    createScript("/business/static/blog/js/common.js");
    //指定当前组模块URL地址
    var URL = '/business/index.php/Home/Post';
    var APP = '/business/index.php';
    var PUBLIC = '/business/static';
    var doComment = '<?php echo U("Post/comment");?>'
    ThinkAjax.updateTip = '<IMG SRC="/business/static/blog/images/loading2.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="loading..." align="absmiddle"> 数据处理中...';
</script>
-->
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