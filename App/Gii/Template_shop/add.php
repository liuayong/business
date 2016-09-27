<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>后台管理 - 添加<?php echo $this->tableComment; ?></title>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/css/blue.css" />
    <script>window.jQuery || document.write('<script type="text/javascript" src="__PUBLIC__/Admin/js/jquery.1.7.2.min.js"><\/script>');</script>
    <script src="__PUBLIC__/Admin/js/Common.js" type="text/javascript"></script>
    <script src="__PUBLIC__/Admin/js/jquery.validate.js" type="text/javascript"></script>
    <script src="__PUBLIC__/Admin/js/jquery.form.js" type="text/javascript"></script>

    <script type="text/javascript">
    //指定当前组模块URL地址
    var URL     = '__URL__';
    var App	    = '__APP__';
    var PUBLIC  = '__PUBLIC__';
    $(function(){
        /*
	$('form').validate(<?php echo $jsValicate; ?>);
	*/
    });
    </script>
</head>
<body>
<div id="main" class="main" >
    <div class="content">
        <div class="title">新增<?php echo $this->tableComment; ?> [ <a href="__CONTROLLER__/index">返回列表</a> ]</div>
        <form method='post' id="form" action="__CONTROLLER__/add" >
        <table cellpadding=3 cellspacing=3>
<?php 
foreach($this->fullFields as $field => $fieldInfo ) :
    if( strpos($fieldInfo['formItem'], 'none' ) === 0 || $fieldInfo['key'] == 'PRI' ) {   // none 不做表单操作
	$typeItems[$field] = 'none' ;
	continue ; 
    } else if( strpos($fieldInfo['formItem'], 'editor' ) === 0 ) {
        $typeItems[$field] = 'editor' ;
        $formItem = '<textarea  id="'.$field.'_id" name="'. $field .'" style="width:750px;height:300px;"></textarea>' ;
    } else if( strpos($fieldInfo['formItem'], 'textarea' ) ===0 ) {
        $typeItems[$field] = 'textarea' ;
        $formItem = '<textarea class="bLeft"  id="'.$field.'_id"  name="'. $field .'" rows="6" cols="65"></textarea>' ;
    } else if( strpos($fieldInfo['formItem'], 'select' ) === 0 ) {
        $typeItems[$field] = 'select' ;
        $formItem = '<select class="bLeft" id="'.$field.'_id"  name="'. $field.'">' ;
        foreach($fieldInfo['value'] as $k => $v) {
            $formItem .= '<option value="'.$k.'">'.$v.'</option>' ;
        }
        $formItem .= '</select>' ;
    } else if( strpos($fieldInfo['formItem'], 'image' )   === 0) {      // 单图片上传, 图片上传一般要有预览功能
        $typeItems[$field] = 'image' ;
        $formItem = '<input type="file"  id="'.$field.'_id" class="medium bLeftRequire"  name="'. $field.'" />' ;
    } else if( strpos($fieldInfo['formItem'], 'mimage' )  === 0) {     // 多图片文件上传, 图片上传一般要有预览功能
        $typeItems[$field] = 'mimage' ;
        $formItem = <<<HTML
	<div style="width:610px; height:auto; border:1px solid #e1e1e1; font-size:12px; padding:10px;">
	<div id="thumbnails">
            <ul id="pic_list" style="margin:5px;" class="album"></ul>
	<div style="clear: both;"></div>
	</div>
	<input type="file"  id="upload" name="upload"  size="2"/>
	<input name="cover" type="hidden" id="cover" value="" />
	<input name="album" type="hidden" id="album" value="" />
</div>
<div id="info_msg" style="display:none;width:100px;"></div>
<div id="copyedok" style="display:none">已经拷贝到剪贴板！</div>
<div id="copytocpbord" style="display:none;">
    <input type="text" class="ipt_3" value="" /> <input id="cp_click" type="button" class="btn" value="复制到剪切板" /> <input type="button" class="btn" name="close" value="关闭" />
</div>
HTML;
	
    } else if( strpos($fieldInfo['formItem'], 'file' ) === 0) {      // 单文件上传
        $typeItems[$field] = 'file' ;
    } else if(strpos($fieldInfo['formItem'], 'mfile' ) === 0) {     // 多文件上传
        $typeItems[$field] = 'mfile' ;
    } else if( strpos($fieldInfo['formItem'], 'date' )   === 0) {      // 日期选择器
        $typeItems[$field] = 'date' ;
        $formItem = '<input type="input"  readonly="readonly" id="'.$field.'_id" value="<?php echo date("Y-m-d"); ?>" onclick="WdatePicker()"  name="'. $field.'" />' ;
    } else if(strpos($fieldInfo['formItem'], 'password' ) === 0 ) {
	$formItem = '<input type="password" class="medium bLeftRequire" id="'.$field.'_id"  name="'. $field.'" />' ;
    } else if(strpos($fieldInfo['formItem'], 'input' ) === 0 ) {
	$formItem = '<input type="text" class="medium bLeftRequire" id="'.$field.'_id"  name="'. $field.'" />' ;
    } else {
        $formItem = '<input type="text" class="medium bLeftRequire" id="'.$field.'_id"  name="'. $field.'" />' ;
    }
    $label = $fieldInfo['label'] ;
?>
            <tr>
                <td class="tRight" ><?php echo $label; ?>：</td>
                <td class="tLeft" >
                    <?php echo $formItem ; ?>
<?php if(isset($this->fullFields[$field]) && $this->fullFields[$field]['key'] == 'UNI') :?>
		    
                    <input type="button" value="检测<?php echo $label; ?>"  class="submit hMargin">
<?php endif; ?>

                </td>
            </tr>
<?php endforeach; ?>
            <tr>
                <td></td>
                <td class="center">
                    <input type="submit" value="保 存" class="small submit">
                    <input type="reset" class="submit  small" value="重 置" >
                </td>
            </tr>
        </table>
        </form>
    </div>
</div>

<!-- 加载所需要的资源文件 -->
<?php  foreach($typeItems as $field => $type) : ?>
<?php if('image' === $type) : ?>
<script src="__PUBLIC__/Admin/js/ajaxfileupload.js" type="text/javascript"></script>    
<?php elseif ('editor' === $type ) : ?>
<script src="__PUBLIC__/Admin/Plugins/editor/kindeditor.js" type="text/javascript"></script>    
<?php elseif ('date' === $type ) : ?>
<script src="__PUBLIC__/Admin/Plugins/My97DatePicker/WdatePicker.js" type="text/javascript"></script>    
<?php elseif ('mimage' === $type ) : ?>
<script type="text/javascript" src="__PUBLIC__/Admin/js/uploadify-v3.1/jquery.uploadify-3.1.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/Admin/js/ThinkBox/jquery.ThinkBox.js"></script>
<script type="text/javascript" src="__PUBLIC__/Admin/js/zeroclipboard/ZeroClipboard.js"></script>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/css/upload.css" media="all">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/js/ThinkBox/css/ThinkBox.css" media="all">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/js/uploadify-v3.1/uploadify.css" media="all">
<script type="text/javascript">
function getElementOffset(e){
	 var t = e.offsetTop;
	 var l = e.offsetLeft;
	 var w = e.offsetWidth;
	 var h = e.offsetHeight-1;

	 while(e=e.offsetParent) {
	 t+=e.offsetTop;
	 l+=e.offsetLeft;
	 }
	 return {
	 top : t,
	 left : l,
	 width : w,
	 height : h
	 }
}

function copyUrl(o){
    var imgurl = $(o).parent().parent().attr('data-src');
    var input_field = $('#copytocpbord').find('input[type=text]');
    var input_btn = $('#copytocpbord').find('input[type=button]');
    var pos = getElementOffset(o);
    input_field.val(imgurl);
    
    if(pos.left+360 > document.documentElement.clientWidth){
        $('#copytocpbord').css('left',document.documentElement.clientWidth-360);
    }else{
        $('#copytocpbord').css('left',pos.left);
    }
    $('#copytocpbord').css('top',pos.top+pos.height);
    $('#copytocpbord').show();
    
    clipobj = copy_clip(imgurl,'cp_click','click_cp_button');
    $('#copytocpbord').find('input[name=close]').unbind('click').bind('click',function(){
		$('#copytocpbord').hide();
        clipobj.destroy();
	});
}
function click_cp_button(){
    var pos = getElementOffset($('#cp_click').get(0));
    $('#copyedok').css('left',pos.left);
    $('#copyedok').css('top',pos.top);
    $('#copyedok').show().animate({opacity: 1.0}, 1000).fadeOut();
    $('#copytocpbord').animate({opacity: 1.0}, 1000).fadeOut();
}
function copy_clip(copy,bid,func){
	var clip = new ZeroClipboard.Client();
	clip.setText('');
	clip.setHandCursor( true );
	clip.addEventListener('mouseOver',function(client) { 
		clip.setText(copy);
	});

	clip.addEventListener('complete',function(o){
	    clip.destroy();
		eval(func+'();');
	})
	clip.glue(bid);
	return clip;
}

function rename_pic(o){
    var info = $(o).parent();
    var info_txt = info.text();
	var str=$(o).parent().parent().attr('data-path');	
	var arr=str.split('+');
	var path=arr[0];
    info.html('<input id="input_id" type="text" value="'+info_txt+'" class="ipt_2" />');
    var input = $('#input_id');
    input.focus();
    input.select();
    input.blur(
        function(){
			if(info_txt!=this.value){
				var album=$('#album').val();
				var str1=path+'+'+info_txt;
				var str2=path+'+'+this.value;
				str=album.replace(str1,str2);
				//alert(str1+str2);
				info.html('<a onclick="rename_pic(this)">'+this.value+'</a>');
				$('#album').val(str);
			}else{
				info.html('<a onclick="rename_pic(this)">'+this.value+'</a>');
			}
        }
    );
    /*input.unbind('keypress').bind('keypress',
        function(e){
            if(e.keyCode == 13){
                input.blur();
            }
        }
    );*/
}
function rename_pic1(o) {
    
    var info = $(o).parent().parent().find('.info');
    var info_txt = info.text();
    var path=$(o).parent().parent().attr('data-path');
    info.html('<input id="input_id" type="text" value="'+info_txt+'" class="ipt_2" />');
    var input = $('#input_id');
    input.focus();
    input.select();
    input.blur(function(){
	if(info_txt!=this.value){
	    var album=$('#album').val();
	    var arr=path.split('+');
	    var str2=arr[0]+'+'+this.value;
	    str=album.replace(path,str2);
	    info.html('<a onclick="rename_pic(this)">'+this.value+'</a>');
	    $('#album').val(str);
	}else{
	    info.html('<a onclick="rename_pic(this)">'+this.value+'</a>');
	}
    });
}
function del_pic(o){
	var parent=$(o).parent().parent();
	var str=parent.attr('data-path');	
	var arr=str.split('+');
	var path=arr[0];	
	if(confirm('确定要删除吗？')){
		$.ajax({
			type: "POST",   //访问WebService使用Post方式请求
			url: '{:U("Common/delUpdImg")}', //调用WebService的地址和方法名称组合---WsURL/方法名
			data:"path="+encodeURI(path),
			success: function(data){	
				parent.animate({opacity: 'hide' }, "slow");
				var album=$('#album').val();
				var tmp=album.replace(str+',','');
				var tmp1=tmp.replace(','+str,'');
				var tmp2=tmp1.replace(str,'');
				$('#album').val(tmp2);
			}
		});
	}
}
function set_pic_cover(o){
	var str=$(o).parent().parent().attr('data-path');
	var arr=str.split('+');
	$('#cover').val(arr[0]);			
	var pos = getElementOffset($(o).parent().parent().find('span.img').get(0));
	//var pos = getElementOffset(o);   
    $('#info_msg').css('top',pos.top+20);
	$('#info_msg').css('left',pos.left);
	//$('#info_msg').css('top',pos.top-50);
	$('#info_msg').html('已设为封面');
	//$('#info_msg').show();
	$('#info_msg').show().animate({opacity: 1.0}, 1000).fadeOut();
	$("div[class='selected']").hide();
	$(o).parent().parent().find("div[class='selected']").show();
}

$(function (){
	$("#upload").uploadify({
		'queueSizeLimit' : 20,
		'removeTimeout' : 0.5,
		'preventCaching' : true,
		'multi'    : true,
		'swf' 			: '__PUBLIC__/Admin/js/uploadify-v3.1/uploadify.swf',
		'uploader' 		: '{:U("Common/upload2")}?{:session_name()}={:session_id()}',//PHPSESSID为登录用户要用到的，在判断登录的地方用到
		'buttonText' 	: '<img src="__PUBLIC__/Admin/images/add.png">',
		'width' 		: '84',
		'height' 		: '30',
		'fileTypeExts'	: '*.jpg; *.png; *.gif;',
		'onUploadSuccess' : function(file, data, response){
			var data = $.parseJSON(data);	
			if(data['status'] == 0){
				$.ThinkBox.error(data['info'],{'delayClose':3000});
				return;
			}
			// var img='<img src="__PIC_URL__/'+data['data']+'?random='+Math.random()+'" width="100" height="80" /> ';
			// var img='<li data-src="__PIC_URL__/'+data['data']+'" data-path="'+data['data']+'+未命名"><span class="img"><img src="__PIC_URL__/'+data['data']+'?random='+Math.random()+'" width="100" height="80" border="0"/></span><span class="info"><a onclick="rename_pic(this)">未命名</a></span><span class="control"><a href="javascript:void(0)" onclick="copyUrl(this)"><img src="__PUBLIC__/Admin/images/copyu.gif" alt="复制网址" title="复制网址" /></a><a href="javascript:;" onclick="del_pic(this)" ><img src="__PUBLIC__/Admin/images/delete.gif" alt="直接删除" title="直接删除" /></a><a href="javascript:void(0)" onclick="set_pic_cover(this)"><img src="__PUBLIC__/Admin/images/cover.gif" alt="设为封面" title="设为封面" /></a><a href="javascript:void(0)" onclick="rename_pic1(this)"><img src="__PUBLIC__/Admin/images/rename.gif" alt="修改标题" title="修改标题" /></a></span><div class="selected" ></div></li>'
			    
			var img='<li data-src="'+data['imgFullPath']+'" data-path="'+data['imgPath']+'+未命名"><span class="img"><img src="'+data['imgFullPath']+'?random='+Math.random()+'" width="100" height="80" border="0"/></span><span class="info"><a onclick="rename_pic(this)">未命名</a></span><span class="control"><a href="javascript:void(0)" onclick="copyUrl(this)"><img src="/Public/Admin/images/copyu.gif" alt="复制网址" title="复制网址" /></a><a href="javascript:;" onclick="del_pic(this)" ><img src="/Public/Admin/images/delete.gif" alt="直接删除" title="直接删除" /></a><a href="javascript:void(0)" onclick="set_pic_cover(this)"><img src="/Public/Admin/images/cover.gif" alt="设为封面" title="设为封面" /></a><a href="javascript:void(0)" onclick="rename_pic1(this)"><img src="/Public/Admin/images/rename.gif" alt="修改标题" title="修改标题" /></a></span><div class="selected" ></div></li>';

			//两个预览窗口赋值
			$('#pic_list').append(img);
			
			//隐藏表单赋值
			
			/*第一张图片为封面*/
			if(!$('#cover').val()){
			    // $('#cover').val(data['imgPath']);
			    // $("div[class='selected']").show();
			}
			
			$('#album').val($('#album').val()+','+data['imgPath']+'+未命名');
	     }
	});
});
</script>
<?php endif; ?>
<?php endforeach; ?>
<script type="text/javascript" >
$(function(){
<?php 
foreach($typeItems as $field => $type) :
    if($type === 'image') : ?>
    //jQuery.getScript("__PUBLIC__/Admin/js/ajaxfileupload.js");
    $("form #<?php echo $field; ?>_id").change(function() {
        var _this = this ;
        var $nowTr = $(this).closest('tr');
        loading();//动态加载小图标
        $.ajaxFileUpload ({
            url:'__URL__/upload', // 你处理上传文件的服务端
            secureuri:false,
            fileElementId: _this.id,	// 与页面处理代码中file相对应的ID值
            dataType: 'json',		// 返回数据类型:text，xml，json，html,scritp,jsonp五种
            success: function (data) {
                if(!$nowTr.next().hasClass('preview')) {
                    $trHtml = '<tr class="preview"><td align="right">预览效果：</td><td><img width="250" height="180"  src="'+ data.imgFullPath +'"  /><input type="hidden" name="'+ $(_this).attr('name') +'" value="'+ data.imgPath +'" /></td></tr>' ;
                    $nowTr.after($trHtml);
                } else {
                    $nowTr.next('.preview').find('img').attr('src',data.imgFullPath );
                    $nowTr.next('.preview').find('input[type=hidden]').val(data.imgPath);
                    //$nowTr.next('.preview').find('input[type=hidden]').attr(name, _this.name );
                }
            },
            error: function(data) {
                console.log(data);
                alert('上传失败: ' + data.msg);
            }
        });
    });

    function loading(){
        $("#loading").ajaxStart(function(){
            $(this).show();
        }).ajaxComplete( function(){
            $(this).hide();
        });
    }

<?php elseif( $type === 'editor' ) : ?>
    KE.show({
	id : '<?php echo $field; ?>_id' //TEXTAREA输入框的ID
    });

<?php elseif($type === 'file') : ?>
    // 普通的文件上传
<?php elseif($type === 'date') : ?>
    // 日期控件
    $('form #<?php echo $field; ?>_id').click(function() {
	// WdatePicker();
	console.log('333');
    });
<?php endif;endforeach; ?>

});
</script>    
</body>
</html>