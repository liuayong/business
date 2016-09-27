<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台管理 - 添加<?php echo $this->tableComment; ?></title>
    <link href="__PUBLIC__/css/common.css" rel="stylesheet" />
    <SCRIPT src="__PUBLIC__/js/jquery.2.1.4.js"></script>
    <link rel="stylesheet" href="__PUBLIC__/plugins/zebra_dialog/css/zebra_dialog.css" type="text/css">
    <script type="text/javascript" src="__PUBLIC__/plugins/zebra_dialog/zebra_dialog.js"></script>
    <Script src="__PUBLIC__/js/form.js"></script>
    <script type="text/javascript">
    var uploadify_show = "{:U('Uploadify/index')}";
    var uploadify_remove = "{:U('Uploadify/remove')}";
    $(function() {
    });
    </script>
</head>
<body>
    <div id="append_parent"></div>
    <div id="cpcontainer" class="container">
        <div id="contentHeader">
            <h3><?php echo $this->tableComment; ?>管理</h3>
            <div class="searchArea">
                <ul class="action left">
                    <li class="current"><a class="actionBtn" href="{:U('index')}"><span>返回</span></a></li>
                    <li class="current"><a class="actionBtn disabled" href="javascript:;"><span>录入</span></a></li>
                </ul>
            </div>
        </div>
        <script src="__PUBLIC__/plugins/jscolor/jscolor.js" type="text/javascript"></script>
        <form method="post" action="" id="xform" enctype="multipart/form-data" name="xform">
            <table class="form_table">
                <tbody>
                    <tr>
                        <td class="tb_title">标题：</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="Post_title" name="Post[title]" class="validate[required]" maxlength="128" size="60" />
                            <input type="checkbox" value="Y" id="style[bold]" name="style[bold]"> 加粗
                            <input type="checkbox" value="Y" id="style[underline]" name="style[underline]"> 下划线
                            <input size="5"  id="style[color]" class="color" name="style[color]" autocomplete="off" />
                        </td>
                    </tr>
                    <tr>
                        <td class="tb_title">副标题：</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" value="" id="Post_title_second" name="Post[title_second]" maxlength="128" size="60">
                        </td>
                    </tr>
                    <tr>
                        <td class="tb_title">唯一标识(英文字母或数字组合)：</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" value="" id="Post_title_alias" name="Post[title_alias]" maxlength="128" size="60">
                        </td>
                    </tr>
                    <tr>
                        <td class="tb_title">所属类别/所属专题：</td>
                    </tr>
                    <tr>
                        <td>
                            <select  id="Post_cate_id" name="Post[cate_id]">
                                <option value="0"> ==所属栏目== </option>
                                <foreach name="tree" item="v">
                                <option value="{$v.id}">{$v.preHtml}{$v.cate_name}</option>
                                </foreach>
                            </select>
                            <select name="Post[special_id]">
                                <option value="0"> ==所属专题== </option>
                                <foreach name="specialData" item="v" key="key">
                                <option value="{$key}">{$v}</option>
                                </foreach>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="tb_title">来源：</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" value="" id="Post_copy_from" name="Post[copy_from]" maxlength="128" size="20">网址
                            <input type="text" value="" id="Post_copy_url" name="Post[copy_url]" maxlength="128" size="50">
                        </td>
                    </tr>
                    <tr>
                        <td class="tb_title">跳转网址(此处若填写，则不显示内容)：</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" value="" id="Post_redirect_url" name="Post[redirect_url]" maxlength="128" size="60">
                        </td>
                    </tr>
                    <tr>
                        <td class="tb_title">封面图片：</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="file" id="img_original" name="img_original">
                        </td>
                    </tr>
                    <tr>
                        <td class="tb_title">详细介绍：</td>
                    </tr>
                    <tr>
                        <td>
                            <include file="Public/editor" form_name="Post[content]" form_id="content" form_value=""  height="300"  width="1000" /> 
                        </td>
                    </tr>
                    <tr>
                        <td class="tb_title">摘要：</td>
                    </tr>
                    <tr>
                        <td>
                            <textarea id="Post_intro" name="Post[intro]" cols="90" rows="5"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="tb_title">组图：</td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <p>
                                    <a href="javascript:uploadifyAction('fileListWarp')">
                                        <img align="absmiddle" src="/bagecms/static/admin/images/create.gif" />添加图片
                                    </a>
                                </p>
                                <ul id="fileListWarp"> </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="tb_title">模板：</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" value="" id="Post_template" name="Post[template]" maxlength="80" size="30">留空则继承栏目中设置的模板</td>
                    </tr>
                    <tr>
                        <td class="tb_title">Tags(逗号或空格隔开)：</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" value="" id="Post_tags" name="Post[tags]" maxlength="255" size="50">
                            <input type="button" onclick="keywordGet('Post_title', 'Post_tags')" value="自动提取">
                        </td>
                    </tr>
                    <tr>
                        <td>收藏次数：
                            <input type="text" value="0" id="Post_favorite_count" name="Post[favorite_count]" maxlength="10" size="5"> 关注人数
                            <input type="text" value="0" id="Post_attention_count" name="Post[attention_count]" maxlength="10" size="5">查看次数：
                            <input type="text" value="1" id="Post_view_count" name="Post[view_count]" maxlength="10" size="5"> 评论次数
                            <input type="text" value="0" id="Post_reply_count" name="Post[reply_count]" maxlength="10" size="5">排序
                            <input type="text" value="0" id="Post_sort_order" name="Post[sort_order]" maxlength="10" size="5">
                        </td>
                    </tr>
                    <tr>
                        <td class="tb_title">状态：</td>
                    </tr>
                    <tr>
                        <td>
                            <select id="Post_status_is" name="Post[status_is]">
                                <option selected="selected" value="Y">显示</option>
                                <option value="N">隐藏</option>
                            </select>
                            <select id="Post_commend" name="Post[commend]">
                                <option value="Y">已推荐</option>
                                <option selected="selected" value="N">未推荐</option>
                            </select>
                            <select id="Post_top_line" name="Post[top_line]">
                                <option value="Y">头条</option>
                                <option selected="selected" value="N">非头条</option>
                            </select>
                            <select id="Post_reply_allow" name="Post[reply_allow]">
                                <option selected="selected" value="Y">允许回复</option>
                                <option value="N">不允许回复</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="tb_title">SEO标题：</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" value="" id="Post_seo_title" name="Post[seo_title]" maxlength="80" size="50">
                        </td>
                    </tr>
                    <tr>
                        <td class="tb_title">SEO关键字：</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" value="" id="Post_seo_keywords" name="Post[seo_keywords]" maxlength="80" size="50">
                        </td>
                    </tr>
                    <tr>
                        <td class="tb_title">SEO描述：</td>
                    </tr>
                    <tr>
                        <td>
                            <textarea id="Post_seo_description" name="Post[seo_description]" cols="80" rows="5"></textarea>
                        </td>
                    </tr>
                </tbody>
                <tbody style="display:none" id="attrArea">
                    <tr>
                        <td class="tb_title">自定义属性：</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="attr2cotnent">
                                <table class="content_list">
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr class="submit">
                        <td colspan="2">
                            <input type="submit" tabindex="3" class="button" value="提交" name="editsubmit">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>
