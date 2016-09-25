<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>基于jquery tool.js实现的类似windows桌面特效代码下载</title>
    <link type="text/css" rel="stylesheet" href="/business/static/desktop/css/css.css" />
    <link type="text/css" rel="stylesheet" href="/business/static/desktop/css/jquery.tool.css" />
    <link type="text/css" rel="stylesheet" href="/business/static/desktop/css/smartMenu.css" />
    <script type="text/javascript" src="/business/static/desktop/js/jquery-1.6.2.min.js"></script>
    <!--<script type="text/javascript" src="/business/static/desktop/js/shortcut.js"></script>-->
    <script type="text/javascript" src="/business/static/desktop/shortcut.js"></script>
    <script type="text/javascript">
    var desktop_w, desktop_h ;
    $().ready(function() {
        desktop_w = $("#desk").width()  - 100 ;
        desktop_h = $("#desk").height() - 20 ;
        document.body.onselectstart = document.body.ondrag = function() {
            return false;
        }
        Core.init();
    });
    </script>
</head>

<body id="lxcn" style="background:url(/business/static/desktop/images/background.jpg) repeat right bottom transparent;">
    <div id="task-bar">
        <ul class="task-window">
        </ul>
        <ul class="task-panel">
            <li class="sys" title="系统设定"><b class="">系统设定</b></li>
        </ul>
    </div>
    <div id="desk">
        <ul></ul>
    </div>
</body>
<script type="text/javascript" src="/business/static/desktop/js/jquery.tool.js"></script>
<script type="text/javascript" src="/business/static/desktop/js/templates.js"></script>
<script type="text/javascript" src="/business/static/desktop/js/jquery-smartMenu.js"></script>
<script type="text/javascript" src="/business/static/desktop/js/core.js"></script>
</html>