<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>修改内容</title>
        <link href="/business/public/css/common.css" rel="stylesheet">
        <link rel="stylesheet" href="/business/public/plugins/zebra_dialog/css/zebra_dialog.css" type="text/css">
        <script src="/business/public/js/jquery.2.1.4.js"></script>
        <script type="text/javascript" src="/business/public/plugins/zebra_dialog/zebra_dialog.js"></script>
        <script type="text/javascript">
            var uploadify_show = "<?php echo U('Uploadify/index');?>";
            var uploadify_remove = "<?php echo U('Uploadify/remove');?>";
            var upload = "<?php echo U('ajaxUploadFile');?>";
            var getKeyword = "<?php echo U('getKeyword');?>";      // 分词
            var ajaxAttrUrl = "<?php echo U('ajaxAttr');?>";       // ajax获取扩展属性
            $(function() {
                // $("#xform").validationEngine();
                $("#tabs ul.tabul > li").click(function() {
                    var index = $(this).index();
                    $("#tabs li").removeClass('current');
                    $(this).addClass('current');
                    $("#tabs_container .tabs").css('display', 'none').eq(index).css('display', 'block');
                });
                
                $('form #Post_cate_id').change(function() {
                    changeCate(this);
                });
                $('form #Post_cate_id').change();
            });
        </script>
    </head>
    <body>
        <div id="append_parent"></div>
        <div id="cpcontainer" class="container">
            <div id="contentHeader">
                <h3>内容管理</h3>
                <div class="searchArea">
                    <ul class="action left">
                        <li class="current"><a class="actionBtn" href="<?php echo U('index');?>"><span>返回</span></a></li>
                        <li class="current"><a class="actionBtn" href="<?php echo U('add');?>"><span>录入</span></a></li>
                    </ul>
                </div>
                <p style="clear:both"></p>
            </div>
            <script src="/business/public/plugins/jscolor/jscolor.js" type="text/javascript"></script>

            <form method="post" action="" id="xform" enctype="multipart/form-data" name="xform">
                <div id="tabs">
                    <ul class="tabul">
                        <li class="current"><a href="#tabs-1" title="基本信息">基本信息</a></li>
                        <li><a href="#tabs-2" title="额外信息">额外信息</a></li>
                        <li><a href="#tabs-3" title="详细信息">详细信息</a></li>
                        <li><a href="#tabs-4" title="内容组图">内容组图</a></li>
                        <li><a href="#tabs-5" title="内容属性">内容额外属性</a></li>
                    </ul>
                    <div id="tabs_container">
                        <div id="tabs-1" class="tabs" style="display:block;">
                            <!-- 基本信息 -->
                            <table class="form_table">
                                <tbody>
                                    <tr>
                                        <td class="tb_title">标题：</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id="Post_title" value="<?php echo ($data["title"]); ?>"  name="Post[title]" class="validate[required]" maxlength="128" size="60" />
                                            <input type="checkbox" value="Y" <?php echo selected(titleStyleRestore($data['title_style_serialize'], 'bold'), "Y", 'checkbox'); ?> id="style[bold]" name="style[bold]"> 加粗
                                                   <input type="checkbox" value="Y" <?php echo selected(titleStyleRestore($data['title_style_serialize'], 'underline'), "Y", 'checkbox'); ?>  id="style[underline]" name="style[underline]"> 下划线
                                                   <input size="5" id="style[color]" value="<?php echo titleStyleRestore($data['title_style_serialize'], 'color'); ?>"  class="color" name="style[color]" autocomplete="off" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tb_title">副标题：</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" value="<?php echo ($data["title_second"]); ?>" id="Post_title_second" name="Post[title_second]" maxlength="128" size="60">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tb_title">唯一标识(英文字母或数字组合)：</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" value="<?php echo ($data["title_alias"]); ?>" id="Post_title_alias" name="Post[title_alias]" maxlength="128" size="60">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tb_title">所属类别/所属专题：</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select  id="Post_cate_id" name="Post[cate_id]">
                                                <option value="0"> ==所属栏目== </option>
                                                <?php if(is_array($tree)): foreach($tree as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php if(($data["cate_id"]) == $v['id']): ?>selected="selected"<?php endif; ?> ><?php echo ($v["preHtml"]); echo ($v["cate_name"]); ?></option><?php endforeach; endif; ?>
                                            </select>
                                            <select name="Post[special_id]">
                                                <option value="0"> ==所属专题== </option>
                                                <?php if(is_array($specialData)): foreach($specialData as $key=>$v): ?><option value="<?php echo ($key); ?>"<?php if(($data["special_id"]) == $key): ?>selected="selected"<?php endif; ?> ><?php echo ($v); ?></option><?php endforeach; endif; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tb_title">封面图片：</td>
                                    </tr>
                                    <tr class="preview" style="display: block;">
                                        <td>
                                            <input class="ajaxUpload" name="uploadImg" type="file" id="logo"  />
                                            &nbsp;&nbsp;&nbsp;
                                            <img id="loading" src="/business/public/images/loading.gif" style="display:none;" />
                                            <a href="<?php echo (IMG_URL); echo ($data["img_original"]); ?>" target="_blank">
                                                <img height="50" align="absmiddle" src="<?php echo (IMG_URL); echo ($data["img_original"]); ?>"  />
                                                <input type="hidden" value="<?php echo ($data["img_original"]); ?>" name="Post[img_original]" />
                                            </a>
                                        </td>
                                    </tr>
                                    <tr  class="preview2" style="display: none;">
                                        <td>
                                            <div> 预览效果：</div>
                                            <img width="250" height="180" src="">
                                            <input type="hidden" value="" name="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tb_title">模板：</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" value="<?php echo ($data["template"]); ?>" id="Post_template" name="Post[template]" maxlength="80" size="30">留空则继承栏目中设置的模板</td>
                                    </tr>
                                    <tr>
                                        <td class="tb_title">Tags(逗号或空格隔开)：</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" value="<?php echo ($data["tags"]); ?>" id="Post_tags" name="Post[tags]" maxlength="255" size="50">
                                            <input type="button" onclick="keywordGet('Post_title', 'Post_tags')" value="自动提取">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tb_title">来源：</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" value="<?php echo ($data["copy_from"]); ?>" id="Post_copy_from" name="Post[copy_from]" maxlength="128" size="20" />
                                            网址
                                            <input type="text" value="<?php echo ($data["copy_url"]); ?>" id="Post_copy_url" name="Post[copy_url]" maxlength="128" size="50" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tb_title">跳转网址(此处若填写，则不显示内容)：</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" value="<?php echo ($data["redirect_url"]); ?>" id="Post_redirect_url" name="Post[redirect_url]" maxlength="128" size="60">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="tabs-2"  class="tabs">
                            <!--- 额外信息 -->
                            <table class="form_table">
                                <tbody>
                                    <tr>
                                        <td class="tb_title">状态：</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select id="Post_status_is" name="Post[status_is]">
                                                <option <?php if(($data["status_is"]) == "Y"): ?>selected="selected"<?php endif; ?> value="Y">显示</option>
                                                <option <?php if(($data["status_is"]) == "N"): ?>selected="selected"<?php endif; ?> value="N">隐藏</option>
                                            </select>
                                            <select id="Post_commend" name="Post[commend]">
                                                <option <?php if(($data["commend"]) == "Y"): ?>selected="selected"<?php endif; ?> value="Y">已推荐</option>
                                                <option <?php if(($data["commend"]) == "N"): ?>selected="selected"<?php endif; ?> value="N">未推荐</option>
                                            </select>
                                            <select id="Post_top_line" name="Post[top_line]">
                                                <option <?php if(($data["top_line"]) == "Y"): ?>selected="selected"<?php endif; ?> value="Y">头条</option>
                                                <option <?php if(($data["top_line"]) == "N"): ?>selected="selected"<?php endif; ?> value="N">非头条</option>
                                            </select>
                                            <select id="Post_reply_allow" name="Post[reply_allow]">
                                                <option <?php if(($data["reply_allow"]) == "Y"): ?>selected="selected"<?php endif; ?> value="Y">允许回复</option>
                                                <option <?php if(($data["reply_allow"]) == "N"): ?>selected="selected"<?php endif; ?> value="N">不允许回复</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> <span> 收藏次数：</span>
                                            <input type="text" value="<?php echo ($data["favorite_count"]); ?>" id="Post_favorite_count" name="Post[favorite_count]" maxlength="10" size="5"> 关注人数
                                            <input type="text" value="<?php echo ($data["attention_count"]); ?>" id="Post_attention_count" name="Post[attention_count]" maxlength="10" size="5">查看次数：
                                            <input type="text" value="<?php echo ($data["view_count"]); ?>" id="Post_view_count" name="Post[view_count]" maxlength="10" size="5"> 评论次数
                                            <input type="text" value="<?php echo ($data["reply_count"]); ?>" id="Post_reply_count" name="Post[reply_count]" maxlength="10" size="5">排序
                                            <input type="text" value="<?php echo ($data["sort_order"]); ?>" id="Post_sort_order" name="Post[sort_order]" maxlength="10" size="5">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tb_title">SEO标题：</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" value="<?php echo ($data["seo_title"]); ?>" id="Post_seo_title" name="Post[seo_title]" maxlength="80" size="50">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tb_title">SEO关键字：</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" value="<?php echo ($data["seo_keywords"]); ?>" id="Post_seo_keywords" name="Post[seo_keywords]" maxlength="80" size="50">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tb_title">SEO描述：</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <textarea id="Post_seo_description" name="Post[seo_description]" cols="80" rows="5"><?php echo ($data["seo_description"]); ?></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="tabs-3"  class="tabs">
                            <!-- 详细信息 -->
                            <table class="form_table">
                                <tbody>
                                    <tr>
                                        <td class="tb_title">详细介绍：</td>
                                    </tr>
                                    <tr>
                                        <td><textarea name="Post[content]" id="content"    class="form-control hide-data" > <?php echo ($data["content"]); ?> </textarea>
<!-- 实例化编辑器 -->
<script type="text/javascript" src="/business/public/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/business/public/ueditor/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<!-- Your site ends -->
<!--

      toolbars: [
            [
                'source','bold', 'underline', 'strikethrough', '|',
                'justifyleft', 'justifycenter', 'justifyright', '|',
                'insertorderedlist', 'insertunorderedlist','blockquote', '|',
                'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                'simpleupload', 'insertimage','link', 'unlink', '|',
                'pagebreak', 'source', 'insertcode','|',
                'help','fullscreen'
            ],
           
        ],
-->
<script type="text/javascript">
var ue_content = UE.getEditor('content',{
        serverUrl :'<?php echo U('Upload/ueditor');?>',
        'initialFrameHeight' : '300',
        "initialFrameWidth" :  '1000',
        lang : "zh-cn",
        elementPathEnabled : false,
        initialFrameHeight: 1000,
        initialFrameHeight: 300,
        minFrameHeight: 300,
        autoHeightEnabled: false
});
</script> </td>
                                </tr>
                                <tr>
                                    <td class="tb_title">摘要：（默认自动提取您文章的前200字显示在博客首页作为文章摘要，您也可以在这里自行编辑 ） </td>
                                </tr>
                                <tr>
                                    <td>
                                        <textarea id="Post_intro" name="Post[intro]" cols="90" rows="5"><?php echo ($data["intro"]); ?></textarea>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="tabs-4"  class="tabs">
                            <!-- 内容组图 -->
                            <table class="form_table">
                                <tbody>
                                    <tr>
                                        <td class="tb_title">组图：</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <p>
                                                    <a href="javascript:uploadifyAction('fileListWarp')">
                                                        <img align="absmiddle" src="/business/public/images/create.gif" />修改图片
                                                    </a>
                                                </p>
                                                <ul id="fileListWarp">
                                                    <?php echo ($imgList); ?>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="tabs-5"  class="tabs">
                            <!-- 内容属性 -->
                            <table class="form_table">
                                <tbody id="attrArea">
                                    <tr>
                                        <td class="tb_title">自定义属性：</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div id="attr2cotnent">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--End tabs container-->
                </div>
                <!--End tabs-->
                <table class="form_table">
                    <tbody>
                        <tr class="submit">
                            <td colspan="2">
                                <input type="submit" tabindex="3" class="button" value="提交" name="editsubmit">
                                <input type="hidden" id="Post_post_id" name="Post[post_id]" value="<?php echo ($data["post_id"]); ?>" />

                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <script src="/business/public/js/ajaxfileupload.js"></script>
            <script  type="text/javascript"  src="/business/public/js/form.js"></script>
        </div>
    </body>
</html>