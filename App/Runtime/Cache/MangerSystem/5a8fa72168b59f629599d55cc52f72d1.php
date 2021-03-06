<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>添加栏目分类</title>
        <!--<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">-->
        <link href="/business/public/css/common.css" rel="stylesheet">
        <script src="/business/public/js/jquery.2.1.4.js"></script>
        <script type="text/javascript">
        $(function() {
        });
        </script>
    </head>
    <body>
        <div id="append_parent"></div>
        <div class="container" id="cpcontainer">
            <div id="contentHeader">
                <h3>栏目管理</h3>
                <div class="searchArea">
                    <ul class="action left">
                        <li><a href="<?php echo U('index');?>" class="actionBtn"><span>返回</span></a></li>
                        <li class="current"><a href="javascript:;" class="actionBtn"><span>录入</span></a></li>
                    </ul>
                    <div class="search right"> </div>
                </div>
            </div>
            <form name="xform" enctype="multipart/form-data" id="xform" action="<?php echo U('add');?>" method="post">
                <table class="form_table">
                    <tbody>
                        <tr>
                            <td class="tb_title">栏目名称：</td>
                        </tr>
                        <tr>
                            <td>
                                <input size="40" maxlength="128" class="validate[required]" name="Cate[cate_name]" id="Cate_cate_name" type="text">
                            </td>
                        </tr>
                        <tr>
                            <td class="tb_title">名称别名：</td>
                        </tr>
                        <tr>
                            <td>
                                <input size="40" maxlength="128" class="validate[required]" name="Cate[cate_name_second]" id="Cate_cate_name_second" type="text" value="">
                            </td>
                        </tr>
                        <tr>
                            <td class="tb_title">唯一标识(英文字母或数字组合)：</td>
                        </tr>
                        <tr>
                            <td>
                                <input size="40" maxlength="128" name="Cate[cate_name_alias]" id="Cate_cate_name_alias" type="text" value="">
                                <button class="btn btn-primary check" type="button">验证唯一</button>
                                <span class="tips" style="display: block;"> 如若: 不填写则会后台自动生成一个唯一标识  </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="tb_title">所属分类：</td>
                        </tr>
                        <tr>
                            <td>
                                <select name="Cate[parent_id]" id="Cate_parent_id">
                                    <option value="0"> ==顶级分类== </option>
                                    <?php if(is_array($tree)): foreach($tree as $key=>$v): ?><option <?php if(($my_id) == $v['id']): ?>selected="selected"<?php endif; ?> value="<?php echo ($v["id"]); ?>"><?php echo ($v["preHtml"]); echo ($v["cate_name"]); ?></option><?php endforeach; endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="tb_title">显示方式：</td>
                        </tr>
                        <tr>
                            <td class="tb_title">
                                <select name="Cate[display_type]" id="Cate_display_type">
                                    <option value="list" selected="selected">列表</option>
                                    <option value="page">单页</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="tb_title">每页显示数量(0或空表示默认20条)：</td>
                        </tr>
                        <tr>
                            <td class="tb_title">
                                <input size="5" maxlength="5" name="Cate[page_size]" id="Cate_page_size" type="text" value="0">
                            </td>
                        </tr>
                        <tr>
                            <td class="tb_title">列表模板：</td>
                        </tr>
                        <tr>
                            <td>
                                <input size="40" maxlength="128" class="validate[required]" name="Cate[template_list]" id="Cate_template_list" type="text" value="list_text">
                            </td>
                        </tr>
                        <tr>
                            <td class="tb_title">单页模板：</td>
                        </tr>
                        <tr>
                            <td>
                                <input size="40" maxlength="128" class="validate[required]" name="Cate[template_page]" id="Cate_template_page" type="text" value="list_page">
                            </td>
                        </tr>
                        <tr>
                            <td class="tb_title">内容页模板：</td>
                        </tr>
                        <tr>
                            <td>
                                <input size="40" maxlength="128" class="validate[required]" name="Cate[template_show]" id="Cate_template_show" type="text" value="show_post">
                            </td>
                        </tr>
                        <tr>
                            <td class="tb_title">跳转地址：</td>
                        </tr>
                        <tr>
                            <td>
                                <input size="60" maxlength="128" name="Cate[redirect_url]" id="Cate_redirect_url" type="text" value="">
                                <span class="tips" style="display: block;"> 若填写此地址则直接跳转到链接地址</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="tb_title">封面图片：</td>
                        </tr>
                        <tr>
                            <td>
                                <input name="img_original" type="file" id="img_original">
                            </td>
                        </tr>
                        <tr>
                            <td class="tb_title">栏目介绍：</td>
                        </tr>
                        <tr>
                            <td>
                                <textarea name="Cate[content]" id="content"    class="form-control hide-data" >  </textarea>
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
</script>
                            </td>
                        </tr>
                        <tr>
                            <td class="tb_title">SEO标题：</td>
                        </tr>
                        <tr>
                            <td>
                                <input size="50" maxlength="128" name="Cate[seo_title]" id="Cate_seo_title" type="text" value="">
                            </td>
                        </tr>
                        <tr>
                            <td class="tb_title">SEO关键字：</td>
                        </tr>
                        <tr>
                            <td>
                                <input size="50" maxlength="128" name="Cate[seo_keywords]" id="Cate_seo_keywords" type="text" value="">
                            </td>
                        </tr>
                        <tr>
                            <td class="tb_title">SEO描述：</td>
                        </tr>
                        <tr>
                            <td>
                                <textarea rows="5" cols="80" name="Cate[seo_description]" id="Cate_seo_description"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="tb_title">状态：</td>
                        </tr>
                        <tr>
                            <td>
                                <select name="Cate[status_is]" id="Cate_status_is">
                                    <option value="Y" selected="selected">显示</option>
                                    <option value="N">隐藏</option>
                                </select>
                                <span class="field"> 排序: </span>
                                <input size="6" maxlength="128" name="Cate[sort_order]" id="Cate_sort_order" type="text" value="0">
                            </td>
                        </tr>
                        <tr class="submit">
                            <td>
                                <input type="submit" name="editsubmit" value="提交" class="button" tabindex="3">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </body>
</html>