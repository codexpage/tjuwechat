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

						<li><a href="/tjuwechat?g=Manager&mo=Msgwall&ac=each" class="easyui-linkbutton" iconCls="icon-ok" plain="true">分活动查看</a></li>

                        <li><a href="/tjuwechat?g=Manager&mo=Msgwall&ac=show" class="easyui-linkbutton" iconCls="icon-ok" plain="true">上墙信息管理</a></li>

                        <li><a href="/tjuwechat?g=Manager&m=Msgwall&a=deleteAll" onclick="return confirm('确定清空所有信息?');" class="easyui-linkbutton" iconCls="icon-ok" plain="true">清空上墙信息</a></li>

                        <li><a href="/tjuwechat?g=Manager&m=Msgwall&a=msgwall" class="easyui-linkbutton" iconCls="icon-ok" plain="true" target="_blank">信息墙</a></li>

						<li><a href="/tjuwechat?g=Manager&mo=Msgwall&ac=image" class="easyui-linkbutton" iconCls="icon-ok" plain="true">查看图片</a></li>

						<li><a href="/tjuwechat?g=Manager&mo=Msgwall&ac=msgbman" class="easyui-linkbutton" iconCls="icon-ok" plain="true">留言板</a></li>					

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

				<div title="功能管理" <?php if($mo == 'Module'): ?>data-options="selected:true"<?php endif; ?>style="padding:10px">

					<ul>

						<li><a href="/tjuwechat?g=Manager&mo=Module&ac=show" class="easyui-linkbutton" iconCls="icon-ok" plain="true">功能管理</a></li>

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
				<div title="管理员管理" <?php if($mo == 'Vote'): ?>data-options="selected:true"<?php endif; ?>style="padding:10px">

					<ul>

						<li><a href="/tjuwechat?g=Manager&mo=Manager&ac=manager" class="easyui-linkbutton" iconCls="icon-ok" plain="true">管理管理员</a></li>

						<li><a href="/tjuwechat/?g=Manager&m=Login&a=logout" class="easyui-linkbutton" iconCls="icon-ok" plain="true">登出</a></li>



					</ul>

				</div>
			</div>

		</div>

		<div data-options="region:'center',title:'信息展示',iconCls:'icon-ok'">

			<script type="text/javascript" src="__ROOT__/Public/Js/plugins/jquery.edatagrid.js"></script>
<table id="dg" title="活动列表" style="width:auto;"
        toolbar="#toolbar" idField="id" fit="true" pagination="true"
        rownumbers="true" fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th field="name" width="50" editor="{type:'validatebox',options:{required:true}}">活动名</th>
            <th field="towall" width="50" editor="{type:'validatebox',options:{required:true}}">是否上墙</th>
        </tr>
    </thead>
</table>
<div id="toolbar">
    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#dg').edatagrid('addRow')">New</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:$('#dg').edatagrid('destroyRow')">Destroy</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:$('#dg').edatagrid('saveRow')">Save</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Cancel</a>
</div>
<script>
$('#dg').edatagrid({
    url: '/tjuwechat/index.php?g=Manager&m=Activity&a=get',
    saveUrl: '/tjuwechat/index.php?g=Manager&m=Activity&a=save',
    updateUrl: '/tjuwechat/index.php?g=Manager&m=Activity&a=update',
    destroyUrl: '/tjuwechat/index.php?g=Manager&m=Activity&a=del'
});

</script>

		</div>

	</div>

</body>

</html>