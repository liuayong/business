<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <title>登录页</title>
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <style>
            #header {
                background: #47a4be none repeat-x scroll left top;
                height: 76px;
                margin-bottom: 12px;
                padding: 0;
            }
            #menu {
                margin: 0;
                padding: 0;
                position: absolute;
                right: 28px;
                text-align: right;
                top: 43px;
            }
            #menu ul {
                margin: 0;
                padding: 0;
            }
            #menu li {
                float: left;
                list-style: outside none none;
                padding-left: 5px;
                text-align: center;
            }
            #menu a {
                background-color: #73bece;
                color: #fff;
                display: block;
                float: left;
                font-weight: bold;
                padding: 4px 12px;
                text-decoration: none;
            }
            #menu a:hover {
                background-color: #081c21;
            }
            #innerHeader {
                height: 76px;
                position: relative;
            }
            .blog-desc {
                color: #f4fafb;
                font-size: 14px;
                margin-left: 45px;
            }
            .blog-desc {
                color: #f4fafb;
                font-size: 14px;
                margin-left: 45px;
            }
        </style>
        <link href="/business/static/blog/css/login.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="/business/static/blog/js/jquery-2.2.4.js"></script>
        <script type="text/javascript" src="/business/static/blog/js/Validate.js"></script>
        <script type="text/javascript" src="/business/static/blog/js/form_verify.js"></script>
        <script type="text/javascript" src="/business/static/blog/js/login.js"></script>
        <script type="text/javascript">
            var check_url = "<?php echo U('User/checkUser');?>";
        </script>
    </head>
    <body>
    <!--头部 -->
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
    <!--头部end -->
    <!--主体 -->
    <div class="loginWrap">
        <div class="main clear">
            <div class="loginImg left"><img src="/business/static/blog/images/loginImg.jpg" alt=""></div>
            <div class="loginBox left">
                <h2>欢迎登陆金银岛网交所</h2>
                <div class="loginCon" style="position:relative;">
                    <div class="errorTip" id="form_error_tip" style="position:absolute;top:5px;left:20px;"></div>
                    <form action="" method="post">
                        <ul class="lgullist">
                            <li class="itemli"><input type="text" id="user_id" name="user_id" class="acctInpt" placeholder="邮箱/手机号/用户名" /></li>
                            <li class="itemli"><input type="password" id="user_passwd" name="password" class="acctInpt" placeholder="请输入密码" /></li>
                            <li class="itemli codeReg">
                                <input type="text" name="code" id="code" class="acctInpt codeInpt" placeholder="验证码" />
                                <div class="codeImg">
                                    <img id="yw0" src="<?php echo U(CONTROLLER_NAME.'/verify');?>" onclick="this.src='<?php echo U(CONTROLLER_NAME.'/verify');?>'+'?'+Math.random()"   alt="图片验证码" title="验证码" />
                                </div>
                            </li>
                            <li class="itemli remeLi clear">
                                <div class="remember left">
                                    <input type="checkbox" name="remember" class="remCheck" />
                                    <span>记住用户名</span>
                                </div>
                                <a href="#" class="right">忘记密码？</a>
                            </li>
                            <li class="itemli btnLi">
                                <input type="submit" class="loginBtn radius2" value="登录" />
                                <input type=hidden id="type" name="type" value="" />
                                <p class="regSkip">> 没有账号？ <a href="<?php echo U('User/register');?>">免费注册</a></p>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--主体 end -->
</body>
</html>