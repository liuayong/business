<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>后台管理 - <?php echo $this->tableComment; ?>列表</title>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/css/blue.css" />
    <script src="__PUBLIC__/Admin/js/Common.js" type="text/javascript"></script>
    <script type="text/javascript">
        //指定当前组模块URL地址
        var URL     = '__URL__';
        var App	    = '__APP__';
        var PUBLIC  = '__PUBLIC__';

    </script>
</head>
<body>
<!-- 菜单区域 -->
<!-- 主页面开始 -->
<div id="main" class="main">
    <!-- 主体内容 -->
    <div class="content">
        <div class="title"><?php echo $this->tableComment; ?>列表</div>
        <!-- 功能操作区域 -->
        <div class="operate">
            <div class="impBtn hMargin fLeft shadow">
                <input type="button" id="" name="add" value="新增" onclick="add()" class="add imgButton">
            </div>
            <div class="impBtn hMargin fLeft shadow">
                <input type="button" id="" name="edit" value="编辑" onclick="edit()" class="edit imgButton">
            </div>
            <div class="impBtn hMargin fLeft shadow">
                <input type="button" id="" name="delete" value="删除" onclick="del()" class="delete imgButton">
            </div>
            <!-- 查询区域 -->
            <div class="impBtn hMargin fLeft shadow">
                <form method='get' action="__SELF__">
                    <div class="fRig">
                        <div class="fLeft">
                            <span id="key"><input type="text" name="uname" title="帐号查询" class="medium"></span>
			    <input type="hidden" name="searchField" value="" />
                        </div>
                        <div class="impBtn hMargin fLeft shadow">
                            <input type="submit" id=""  value="查询"  class="search imgButton" />
                        </div>
                    </div>
                    <!-- 高级查询区域 -->
                    <div id="searchM" class=" none search cBoth"></div>
                </form>
            </div>
        </div>
        <!-- 功能操作区域结束 -->
        <!-- 列表显示区域 -->
        <div class="list">
            <!-- Think 系统列表组件开始 -->
            <table id="checkList" class="list" cellpadding=0 cellspacing=0>
                <tr>
                    <td height="5" colspan="<?php echo $cnt= count($this->showFields) + 2 ; ?>" class="topTd"></td>
                </tr>
                <tr class="row"  align="center" >
                    <th width="20">
                        <input type="checkbox" id="check" onclick="CheckAll('checkList')">
                    </th>
<?php
    $fullFields = $this->fullFields ;
    foreach($this->showFields  as $field => $v) :
        if($fullFields[$field]['key'] == 'PRI') {
            $width = 'width="8%"';
            $text = '编号';
        } else {
            $width = '';
            $text = $fullFields[$field]['label'];
        }

?>
                    <th <?php echo $width; ?> align="center" >
                        <a href="javascript:sortBy('<?php echo $field; ?>','1')" title="按照<?php echo $text; ?>升序排列 "> <?php echo $text; ?> </a>
                    </th>
<?php endforeach; ?>
                    <th align="center" > 操作 </th>
                </tr>
<?php
echo <<<HTML
                <?php
                foreach(\$data['list'] as \$k => \$v) : ?>
                <tr class="row" onmouseover="over(event)" onmouseout="out(event)" onclick="change(event)" align="center">
                    <td><input type="checkbox" name="key" value="<?php echo \$v['$this->pk']; ?>"></td>\n
HTML;

foreach($this->showFields as $kk => $vv ) :?>
                    <td><?php echo "<?php  echo \$v['$kk']; ?>" ?></td>
<?php endforeach; ?>
<?php
echo <<<HTML
                    <td>
                        <a href="javascript:edit('<?php echo \$v['{$this->pk}']?>')">编辑</a>&nbsp;
                        <a href="javascript:del('<?php echo \$v['{$this->pk}']?>')">删除</a>&nbsp;
                    </td>
                </tr>
                <?php endForeach; ?>
HTML;
?>
                    
		    <!--
                    <th>
                        <a href="javascript:sortBy('login_count','1','index')" title="按照登录次数升序排列 ">登录次数
                            <img src="/hlzb/Admin/Tpl/Public/images/desc.gif" width="12" height="17" border="0" align="absmiddle" />
                        </a>
                    </th>
                    -->
                <tr>
                    <td height="5" colspan="<?php echo $cnt; ?>" class="bottomTd"></td>
                </tr>
            </table>
            <!-- Think 系统列表组件结束 -->
        </div>
        <!-- 分页显示区域 -->
        <div class="page">
            <?php echo '<?php echo $data[\'page\']->show(); ?>'; ?>
	    
            <!-- 5 条记录 1/1 页 -->
        </div>
        <!-- 列表显示区域结束 -->
    </div>
    <!-- 主体内容结束 -->
</div>
<!-- 主页面结束 -->
</body>
</html>
