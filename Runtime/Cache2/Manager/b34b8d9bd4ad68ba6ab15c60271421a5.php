<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>天津大学团委微信公众平台</title>
	<link rel="stylesheet" type="text/css" href="__ROOT__/Public/Js/themes/default/easyui.css" />
	<link rel="stylesheet" type="text/css" href="__ROOT__/Public/Js/themes/icon.css" />
	<link rel="stylesheet" type="text/css" href="__ROOT__/Public/Css/demo.css" />
	<script type="text/javascript" src="__ROOT__/Public/Js/jquery.min.js"></script>
	<script type="text/javascript" src="__ROOT__/Public/Js/jquery.easyui.min.js"></script>
</head>
<body>
	<div class="easyui-layout center">
		<div data-options="region:'north'" style="height:50px"></div>
		<div data-options="region:'south',split:true" style="height:50px;"></div>
		<div data-options="region:'east',split:true" title="East" style="width:180px;">
		</div>
		<div data-options="region:'west',split:true" title="管理面板" style="width:150px;">
			<div class="easyui-accordion" data-options="fit:true,border:false">
				<div title="信息墙" <?php if($mo == 'Msgwall'): ?>data-options="selected:true"<?php endif; ?>style="padding:10px;">
					<ul>
						<li><a href="/tjuwechat?g=Manager&mo=Msgwall&ac=show" class="easyui-linkbutton" iconCls="icon-ok" plain="true">上墙信息管理</a></li>
						<li><a href="/tjuwechat?g=Manager&mo=Msgwall&ac=each" class="easyui-linkbutton" iconCls="icon-ok" plain="true">分活动查看</a></li>
						<li><a href="/tjuwechat?g=Manager&mo=Msgwall&ac=image" class="easyui-linkbutton" iconCls="icon-ok" plain="true">查看图片</a></li>
						<li><a href="/tjuwechat?g=Manager&mo=Msgwall&ac=msgbman" class="easyui-linkbutton" iconCls="icon-ok" plain="true">留言板</a></li>
						<li><a href="/tjuwechat?g=Manager&m=Msgwall&a=msgwall" class="easyui-linkbutton" iconCls="icon-ok" plain="true" target="_blank">信息墙</a></li>
						<li><a href="/tjuwechat?g=Manager&mo=Msgwall&ac=lottery" class="easyui-linkbutton" iconCls="icon-ok" plain="true">抽奖信息</a></li>
						<li><a href="/tjuwechat?g=Manager&m=Msgwall&a=lotteryboard" class="easyui-linkbutton" iconCls="icon-ok" plain="true" target="_blank">到前台抽奖去</a></li>
					</ul>
				</div>
				<div title="自定义菜单" <?php if($mo == 'Menu'): ?>data-options="selected:true"<?php endif; ?>style="padding:10px;">
					<ul>
						<li><a href="/tjuwechat?g=Manager&mo=Menu&ac=create" class="easyui-linkbutton" iconCls="icon-ok" plain="true">创建菜单</a></li>
						<li><a href="/tjuwechat?g=Manager&mo=Menu&ac=delete" class="easyui-linkbutton" iconCls="icon-ok" plain="true">删除菜单</a></li>
					</ul>
				</div>
				<div title="活动管理" <?php if($mo == 'Activity'): ?>data-options="selected:true"<?php endif; ?>style="padding:10px;">
					<ul>
						<li><a href="/tjuwechat?g=Manager&mo=Activity&ac=show" class="easyui-linkbutton" iconCls="icon-ok" plain="true">活动管理</a></li>
					</ul>
				</div>
				<div title="模块管理" <?php if($mo == 'Module'): ?>data-options="selected:true"<?php endif; ?>style="padding:10px">
					<ul>
						<li><a href="/tjuwechat?g=Manager&mo=Module&ac=show" class="easyui-linkbutton" iconCls="icon-ok" plain="true">模块管理</a></li>
					</ul>
				</div>
				<div title="用户管理" <?php if($mo == 'User'): ?>data-options="selected:true"<?php endif; ?>style="padding:10px">
					<ul>
						<li><a href="/tjuwechat?g=Manager&mo=User&ac=avatar" class="easyui-linkbutton" iconCls="icon-ok" plain="true">更新头像</a></li>
					</ul>
				</div>
				<div title="投票管理" <?php if($mo == 'Vote'): ?>data-options="selected:true"<?php endif; ?>style="padding:10px">
					<ul>
						<li><a href="/tjuwechat?g=Manager&mo=Vote&ac=competitor" class="easyui-linkbutton" iconCls="icon-ok" plain="true">选手管理</a></li>
						<li><a href="/tjuwechat?g=Manager&mo=Vote&ac=result" class="easyui-linkbutton" iconCls="icon-ok" plain="true">查看结果</a></li>
						<li><a href="/tjuwechat?g=Manager&m=Vote&a=chart" class="easyui-linkbutton" iconCls="icon-ok" plain="true" target="_blank">以统计图查看</a></li>
						<li><a href="/tjuwechat?g=Manager&mo=Vote&ac=permission" class="easyui-linkbutton" iconCls="icon-ok" plain="true">批处理权限</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div data-options="region:'center',title:'信息展示',iconCls:'icon-ok'">
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="update()">更新所有头像</a>
<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="update_not_exist()">重新下载不存在的头像</a>

<script>
function update(){
	var url = '/tjuwechat/index.php?g=Manager&m=User&a=update_avatar';
	$.post(url, {}, function(result){
        if (result > 0){
        	$.messager.show({
                title: '更新成功',
                msg: '已更新 ' + result + ' 人的头像！'
            });
        } else {
            $.messager.show({
                title: 'Error',
                msg: '出现了错误，操作未成功'
            });
        }
    });
}

function update_not_exist(){
    var url = '/tjuwechat/index.php?g=Manager&m=User&a=update_avatar_not_exist';
    $.post(url, {}, function(result){
        if (result > 0){
            $.messager.show({
                title: '更新成功',
                msg: '已更新 ' + result + ' 人的头像！'
            });
        } else {
            $.messager.show({
                title: 'Error',
                msg: '出现了错误，操作未成功'
            });
        }
    });
}
</script>
		</div>
	</div>
</body>
</html>