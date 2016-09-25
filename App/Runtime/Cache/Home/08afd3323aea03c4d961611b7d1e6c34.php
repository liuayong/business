<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <title>金银岛网交所注册页</title>
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
        <link href="/business/static/blog/css/register.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="/business/static/blog/js/jquery-2.2.4.js"></script>
        <script type="text/javascript" src="/business/static/blog/js/Validate.js"></script>
        <script type="text/javascript" src="/business/static/blog/js/form_verify.js"></script>
        <script type="text/javascript" src="/business/static/blog/js/register_veri.js"></script>
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
    <div class="mainBox pdbt70">
        <div class="main">
            <div class="mainttWrap">
                <div class="mainttbar"><i></i>注册金银岛网交所账号</div>
            </div>
            <div class="registerWrap clear">
                <ul class="registCon" id="registCon" style="display:block">
                    <form id="registerForm" action="" method="post">
                        <input type=hidden id="type" name="type" value="">
                        <li class="itemli">
                            <label><b>*</b>用户名：</label>
                            <div class="inputWrap">
                                <input type="text" name="user_id" id="user_id" empty="no" validate="number_letter" min=6 max=30 class="acctInpt" placeholder="手机号/邮箱/用户名">
                                <div class="errorTip" ></div>
                            </div>
                        <li class="itemli">
                            <label><b>*</b>登录密码：</label>
                            <div class="inputWrap">
                                <input type="password" name="password" id="user_passwd" empty="no" min=6 max=14 class="acctInpt" placeholder="限6到14位的字母和数字的组合">
                                <div class="errorTip"></div>
                            </div>
                            <div class="pwdStatus">
                                <div class="pswarp radius2">
                                    <span class="s_box s_box">低</span><span class="s_box s_box">中</span><span class="s_box s_box">高</span>
                                </div>
                            </div>
                        </li>
                        <li class="itemli">
                            <label><b>*</b>确认登录密码：</label>
                            <div class="inputWrap">
                                <input type="password" name="reuser_passwd" id="reuser_passwd" empty="no" class="acctInpt" placeholder="再次输入您设定的密码">
                                <div class="errorTip"></div>
                            </div>
                        </li>
                        <!--
                        <li class="itemli">
                            <label><b>*</b>邮箱：</label>

                            <div class="inputWrap">
                                <input type="text" name="mail" id="mail" max=100 validate="email" class="acctInpt"
                                       placeholder="电子邮箱">

                                <div class="errorTip"></div>
                            </div>
                        </li>
                        -->
                        <li class="itemli">
                            <label>联系电话：</label>
                            <div class="inputWrap">
                                <input type="text" name="telphone" id="telphone" max=20 class="acctInpt" placeholder=" 联系电话或手机号">
                                <div class="errorTip"></div>
                            </div>
                        </li>
                        <!--
                        <li class="itemli">
                            <label>联系手机：</label>
                            <div class="inputWrap">
                                <input type="text" name="cellphone" id="cellphone" max=20 validate="mobile" class="acctInpt"
                                       placeholder="格式 ：13911112222">
                                <div class="errorTip"></div>
                            </div>
                        </li>
                        -->
                        <li class="itemli codeli" >
                            <label id="yanzhengma"><b>*</b>验证码：</label>
                            <div class="inputWrap">
                                <span id="yzm_input">
                                    <input type="text" name="code" id="code" empty="no" class="acctInpt codeInpt" placeholder="验证码">
                                </span>
                                <span id="yzm_msg">
                                    <img id="yw0" src="<?php echo U(CONTROLLER_NAME.'/verify');?>" onclick="this.src = '<?php echo U(CONTROLLER_NAME.'/verify');?>' + '?' + Math.random()"   alt="图片验证码" title="验证码" />
                                    <div class="errorTip" id="errorTip_code"></div>
                                </span>
                            </div>
                        </li>
                        <li class="itemli agreeli">
                            <label></label>
                            <div class="inputWrap">
                                <input type="checkbox" name="agree" id="agree" value="true" checked="checked" class="agreementIpt"> 已阅读并同意《
                                <a href="javascript:;">金银岛网交所服务协议</a>》《<a href="javascript:;">交易商须知</a>》
                                <span id="yzm_msg">
                                    <div class="errorTip" id="errorTip_yuedu"></div>
                                </span>
                            </div>
                        </li>
                        <li class="itemli btnli">
                            <label></label>
                            <div class="inputWrap">
                                <input id="registerButton" class="registBtn radius2" name="button" type="submit" value="注册" />
                                <div class="skip">>已有账号？<a href="<?php echo U('User/login');?>">立即登录</a></div>
                            </div>
                        </li>
                        </li>
                    </form>
                    <script language="javascript">
        $(document).ready(function() {
            var img = new Image;
            img.onload = function() {
                $('#yw0_button').trigger('click');
            }
            img.src = $('#yw0').attr('src'); //这段js解决yii验证码不刷新
        });
                    </script>
                </ul>
            </div>
        </div>
    </div>
    <!--主体 end -->
</body>
</html>