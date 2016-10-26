<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
    <head>
        <title>后台管理系统</title>
        <link type="image/x-icon" href="/business/public/favicon.ico" rel="shortcut icon">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="/business/public/css/dpl-min.css"  rel="stylesheet"  type="text/css" /> 
        <link href="/business/public/css/bui-min.css"  rel="stylesheet"  type="text/css" />
        <link href="/business/public/css/main-min.css" rel="stylesheet"  type="text/css" />
        <script src="/business/public/js/jquery-1.8.1.min.js" type="text/javascript"></script>
        <script src="/business/public/js/bui-min.js" type="text/javascript"></script>
        <script src="/business/public/js/common/main-min.js" type="text/javascript"></script>
        <script src="/business/public/js/config-min.js" type="text/javascript"></script>
        <script src="/business/public/Plugins/ligerUI/js/core/base.js" type="text/javascript"></script>
        <script src="/business/public/Plugins/ligerUI/js/plugins/ligerDialog.js" type="text/javascript"></script>
        <link href="/business/public/Plugins/ligerUI/skins/Aqua/css/ligerui-dialog.css" rel="stylesheet" type="text/css" />
        <script src="/business/public/js/jquery.cookie.js" type="text/javascript"></script>
        <script>
            $(function () {
                //ajaxPull();
                // 弹窗
                var last_ip = $.cookie('login_ip');
                var last_time = $.cookie('login_time');
                if (last_ip && last_time) {
                    setTimeout(function () {
                        $.ligerDialog.success('上一次登录IP: ' + last_ip + '，上一次登录时间: ' + last_time);
                        $('.l-dialog').fadeOut(3000);
                        $.removeCookie('login_ip', {path: '/'}); // 删除 cookie
                        $.removeCookie('login_time', {path: '/'}); // 删除 cookie
                    }, 500);
                    setTimeout(function () {
                        $('.l-dialog-btn-inner').click();
                    }, 3000);
                }

                //轮询，实时更新消息数,10秒更新一次
                function ajaxPull() {
                    updateMsg();
                    setInterval(updateMsg, 10000);
                }
                //每个轮询操作
                function updateMsg() {
                    var msgnum = parseInt($("#msgnum").text());
                    //异步操作，发送请求，对比消息数变更
                    var url = 'index.php/index/pull';
                    $.post("<?php echo U('pull');?>", function (data) {
                        if (data.status == 1) {
                            //更新消息提示
                            $("#msgnum").text(data.msgnum);
                        }
                    }, 'json');

                }
            })
        </script>
    </head>
    <body>
        <div class="header">
            <div class="dl-title">
                <!--<img src="/chinapost/Public/assets/img/top.png">-->
            </div>
            <div class="dl-log">欢迎您，<span class="dl-log-user" id="<?php echo session('uid');?>">
                    <?php echo session('nickname');?> (<?php echo session('uname');?>) </span>   
                <span class="glyphicon glyphicon-envelope"></span>  
                <span class="badge" id="msgnum"><?php if(session('?msg')): echo session('msg'); else: ?>0<?php endif; ?></span>
                <a  onclick="return confirm('确定要退出?');" href="<?php echo U('logout');?>" title="退出系统" class="dl-log-quit">[退出]</a>
                <a href="/business/index.php"  class="dl-log-quit" target="_blank"> 前台首页 </a>
            </div>
        </div>
        <div class="content">
            <div class="dl-main-nav">
                <div class="dl-inform">
                    <div class="dl-inform-title"><s class="dl-inform-icon dl-up"></s></div>
                </div>
                <ul id="J_Nav"  class="nav-list ks-clear">
                    <!--
                    <li class="nav-item dl-selected"><div class="nav-item-inner nav-home">系统管理</div></li>
                    <li class="nav-item"><div class="nav-item-inner nav-distribution">每日一练</div></li>
                    <li class="nav-item"><div class="nav-item-inner nav-goods">专题模块</div></li>
                    <li class="nav-item"><div class="nav-item-inner nav-marketing">用户管理</div></li>
                    -->
                    <li class="nav-item dl-selected"><div class="nav-item-inner nav-home">系统管理</div></li>
                    <li class="nav-item"><div class="nav-item-inner nav-distribution">内容管理</div></li>
                    <li class="nav-item"><div class="nav-item-inner nav-goods">我的导航</div></li>
                    <li class="nav-item"><div class="nav-item-inner nav-marketing">桌面应用</div></li>

                    <!--
                    <li class="nav-item"><div class="nav-item-inner nav-home"> 首页 </div><div class="nav-item-mask"></div></li>
                    <li class="nav-item"><div class="nav-item-inner nav-order"> 表单页 </div><div class="nav-item-mask"></div></li>
                    <li class="nav-item"><div class="nav-item-inner nav-inventory"> 搜索页 </div><div class="nav-item-mask"></div></li>
                    <li class="nav-item"><div class="nav-item-inner nav-supplier"> 详情页 </div><div class="nav-item-mask"></div></li>
                    <li class="nav-item"><div class="nav-item-inner nav-marketing"> 图表 </div><div class="nav-item-mask"></div></li>
                    -->
                </ul>
            </div>
            <ul id="J_NavContent" class="dl-tab-conten"></ul>
        </div>
        <script>
            var users = "<?php echo U('index/users');?>";
            var thumb = "<?php echo U('index/thumb');?>";
            var sendmsg = "<?php echo U('index/sendmsg');?>";
            var msg = "<?php echo U('index/myReceive');?>";
            var mysend = "<?php echo U('index/mysend');?>";
            var user_list = "<?php echo U('admin/index');?>";
            var user_add = "<?php echo U('Admin/add');?>";
            
            var index = "<?php echo U('Index/home');?>" ;  // 系统首页
            var cate_index = "<?php echo U('Cate/index');?>" ;  // 栏目管理
            var cate_add = "<?php echo U('Cate/add');?>" ;  // 添加栏目
            //
            // BUI.use('common/main', function () {
            var config = [
                {id: '1', menu: [
                        {text: '渠道管理', items: [
                                {id: '11', text: '银行列表', href: "<?php echo U('bank/index');?>"}, 
                                {id: '12', text: '添加银行', href: "<?php echo U('bank/add');?>"},
                            {id: '13', text: '支付平台列表', href: "<?php echo U('PayType/index');?>"}, 
                            {id: '14', text: '添加支付平台', href: "<?php echo U('PayType/add');?>"}]
                        },
                        {text: '消息管理', items: [
                                {id: '21', text: '我的消息', href: '<?php echo U("index/myReceive");?>'},
                                {id: '22', text: '我发送的', href: '<?php echo U("index/mySend");?>'},
                                {id: '23', text: '发送信息', href: '<?php echo U("index/sendMsg");?>'}
                            ]
                        },
                        {text: '用户管理', items: [{id: '31', text: '用户列表', href: "<?php echo U('admin/index');?>"}, {id: '32', text: '添加用户', href: "<?php echo U('admin/add');?>"}]},
                    ]},
                {id: '4', homePage: '41', menu: [
                    {text: '业务系统', items: [{id: '41', text: '系统首页', href: index},
                            {id: '42', text: '栏目管理', href: cate_index},
                            {id: '43', text: '添加栏目', href: cate_add},
                            {id: '44', text: '专题管理', href: "<?php echo U('Special/index');?>"},
                            {id: '45', text: '内容管理', href: "<?php echo U('Post/index');?>"},
                            {id: '46', text: '评论管理', href:  "<?php echo U('Comment/index');?>"},
                            {id: '47', text: '附件管理', href:  "<?php echo U('Attach/index');?>"},
                        ]}
                ]},
                {id: '5', homePage: '51', menu: [
                    {text: '导航信息网', 
                        items: [
                            {id: '51', text: '导航信息网首页', href: "<?php echo U('Nav/index');?>"},
                            {id: '52', text: '全部导航', href: "<?php echo U('Nav/list');?>"},
                            {id: '53', text: '添加导航', href: "<?php echo U('Nav/add');?>"}
                    ]}
                ]},
                {id: '6', homePage: '61', menu: [
                    {text: '桌面应用', 
                        items: [
                            {id: '61', text: '桌面应用', href: "<?php echo U('Desktop/index');?>"},
                            {id: '62', text: '添加应用', href: "<?php echo U('Desktop/add');?>"},
                    ]}
                ]}
            ];

            new PageUtil.MainPage({
                modulesConfig: config
            });
            //});
        </script>
    </body>
</html>