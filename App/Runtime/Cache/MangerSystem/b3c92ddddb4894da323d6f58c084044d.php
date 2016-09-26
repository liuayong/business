<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
    <head>
        <title>后台登录</title>
        <link type="image/x-icon" href="/business/public/favicon.ico" rel="shortcut icon">
        <link href="/business/public/css/login.css" rel="stylesheet" type="text/css" />
        <script src="/business/public/js/jquery.1.8.3.js" type="text/javascript"></script>
        <link href="/business/public/Plugins/ligerUI/skins/Aqua/css/ligerui-dialog.css" rel="stylesheet" type="text/css" />
        <link href="/business/public/Plugins/ligerUI/skins/Gray/css/dialog.css" rel="stylesheet" type="text/css" />
        <script src="/business/public/Plugins/ligerUI/js/core/base.js" type="text/javascript"></script>
        <script src="/business/public/Plugins/ligerUI/js/plugins/ligerDialog.js" type="text/javascript"></script>
        <script src="/business/public/js/jquery.validate.js" type="text/javascript"></script>
        <script src="/business/public/js/jquery.form.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(function () {
                $(".login-text").focus(function () {
                    $(this).addClass("login-text-focus");
                }).blur(function () {
                    $(this).removeClass("login-text-focus");
                });
                $('form').validate({
                    submitHandler: function (form) {
                        // $(form).ajaxSubmit();
                        $.ajax({
                            type: 'post', cache: false, dataType: 'json',
                            url: "/business/index.php/MangerSystem/Login/index.html",
                            data: $("form").serialize(),
                            success: function (retData) {
                                if (retData.code == 0) {
                                    $.ligerDialog.alert(retData.msg, '登录提示', "success");
                                    setTimeout(function () {
                                        location.href = decodeURIComponent("<?php echo U('/'.MODULE_NAME);?>");
                                        location.href = decodeURIComponent("<?php echo U('Index/index');?>");
                                    }, 100);
                                } else {
                                    $.ligerDialog.alert(retData.msg, '登录提示', "error");
                                }
                            },
                            error: function () {
                                $.ligerDialog.alert("系统错误,请与系统管理员联系!", '登录提示', "error");
                            },
                            beforeSend: function () {
                                $.ligerDialog.waitting(" 正在登陆中,请稍后... ");
                                $("#btnLogin").prop("disabled", true);
                            },
                            complete: function ()
                            {
                                $.ligerDialog.closeWaitting();
                                $("#btnLogin").prop("disabled", false);
                            }
                        });
                    },
                    rules: {
                        username: {
                            required: true
                        },
                        password: {
                            required: true
                        },
                        verify: {
                            required: true,
                            minlength: 4
                        }
                    },
                    messages: {
                        username: {
                            required: '账号不能为空'
                        },
                        password: {
                            required: '密码不能为空'
                        },
                        verify: '验证码不正确'
                    },
                    errorPlacement: function (error, element) {
                        if ($('body > div.l-dialog:visible').length == 0) {
                            $.ligerDialog.alert(error.html(), '登录提示', "error")
                        }
                        element.focus();
                        return false;
                    },
                    onkeyup: false
                });

            });
        </script>
    </head>
    <body style="padding:10px">
        <div id="login">
            <div id="loginlogo"></div>
            <div id="loginpanel">
                <div class="panel-h"></div>
                <div class="panel-c">
                    <div class="panel-c-l">
                        <form  method="post" >
                            <table cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td align="left" colspan="2">
                                            <h3>红岭资本管理（北京）有限公司官网后台系统</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">账号：</td><td align="left"><input type="text" name="username" id="txtUsername" class="login-text" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">密码：</td><td align="left"><input type="password" name="password" id="txtPassword" class="login-text" /></td>
                                    </tr>
                                    <tr class="verify">
                                        <td align="right">验证码：</td><td align="left"><input type="text" id="inputCode" name="verify" class="login-text" maxlength="4"/>
                                            <img src="<?php echo U('verify');?>" id="verifyImg" onclick="this.src = '/business/index.php/MangerSystem/Login/verify/' + Math.random()"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" colspan="2">
                                            <input type="submit" id="btnLogin" value="登陆" class="login-btn" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table></form>
                    </div>
                    <div class="panel-c-r">
                        <p>请从左侧输入登录账号和密码登录</p>
                        <p>如果遇到系统问题，请联系网络管理员。</p>
                        <p>如果没有账号，请联系网站管理员。 </p>
                        <p>......</p>
                    </div>
                </div>
                <div class="panel-f"></div>
            </div>
            <div id="logincopyright">&copy; 2016  红岭资本  All rights reserved  红岭资本管理（北京）有限公司 </div>
        </div>
    </body>
</html>