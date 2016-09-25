$(function() {
    $("input[type=file].ajaxUpload").change(function() {
        var that = this;
        var fileElementId = this.id || 'upImg';

        loading();//动态加载小图标
        $.ajaxFileUpload({
            url: upload, // 处理上传文件的服务端
            secureuri: false,
            fileElementId: fileElementId, // 与页面处理代码中file相对应的ID值
            dataType: 'json', // 返回数据类型:text，xml，json，html,scritp,jsonp五种
            success: function(retData) {
                if (retData.code == 0) {
                    $('tr.preview').show().find('img').attr('src', retData.urlPath);
                    $('tr.preview').find('input[type=hidden]').val(retData.savepath);
                    $('tr.preview').find('a').attr('href', retData.urlPath);
                } else {
                    console.log("fail: " + retData.msg);
                }
                console.log("上传成功");
                /*
                 if (retData.code == 0) {
                 $('tr.preview').show().find('img').attr('src', retData.urlPath);
                 $('tr.preview').find('input[type=hidden]').val(retData.savepath);
                 } else {
                 console.log("fail: " +  retData.msg);
                 } 
                 */
            },
            error: function(data) {
                var retData = eval("(" + data.responseText + ")");
                if (retData.code == 0) {
                    $('tr.preview').show().find('img').attr('src', retData.urlPath);
                    $('tr.preview').find('input[type=hidden]').val(retData.savepath);
                } else {
                    console.log("fail: " + retData.msg);
                }
                //alert('上传失败: ' + data.responseText);
                console.warn('上传失败: ' + data.responseText);
            }
        });
    });
});

/** ajax 状态显示 **/
function loading() {
    console.log($("#loading"));

    $("#loading").ajaxStart(function() {
        console.log(this);
        $(this).show();
    }).ajaxComplete(function() {
        console.log(this);
        $(this).hide();
    });
}


/** 上传组图 **/
function uploadifyAction(imgListId) {
    $.Zebra_Dialog('', {
        source: {
            'iframe': {
                'src': uploadify_show,
                'height': 300,
                'name': 'ayong_post',
                'id': 'ayong_post'
            }
        },
        width: 600,
        'buttons': [{
                caption: '确认',
                callback: function() {
                    var htmls = $(window.frames['ayong_post'].document).find("#fileListWarp").html().trim();
                    if (htmls) {
                        $("#" + imgListId).append(htmls);
                    } else {
                        alert('没有文件被选择');
                    }
                }
            }, {
                caption: '取消',
                callback: function() {
                    return;
                }
            }],
        'type': false,
        'title': '附件上传',
        'modal': false
    });
}

/** 删除上传组图  **/
function uploadifyRemove(fileId, attrName, gallaryId) {
    if (confirm('本操作不可恢复，确定继续？')) {
        $.post(uploadify_remove, {imageId: fileId, gid: gallaryId}, function(res) {
            $("#" + attrName + fileId).remove();
        }, 'json');
    }
}


/** 根据不同的栏目 显示不出不同的自定义属性 ***/
function changeCatalog(ths) {
    $.post("<?php echo $this->createUrl('ajax/attr2content')?>", {catalog: ths.value}, function(res) {
        if (res.state == 'success') {
            $("#attr2cotnent").html(res.text);
            $("#attrArea").show();
        } else {
            $("#attrArea").hide();
            $("#attr2cotnent").html('');
        }
    }, 'json');
}

/*
 关键词整获取
 */
function keywordGet(keywordFromId, keywordIdSet) {
    var keywords = $("#" + keywordFromId).val();
    $.post(getKeyword, {keywords: keywords}, function(res) {
        if (res.code != 0) {
            alert('获取失败，请手动填写');
        } else {
            $("#" + keywordIdSet).val(res.content);
        }
    }
    , 'json')
}

/**
 *  根据不同的栏目 显示不出不同的自定义属性
 * @param {type} that
 * @returns {undefined}
 */
function changeCate(that) {
    var cate_id = $(that).val() ;
    var post_id = $("#Post_post_id").val();
    $.post(ajaxAttrUrl, {cate_id: cate_id, post_id : post_id}, function(res){
        $("#attr2cotnent").html(res);
    },'html');
}