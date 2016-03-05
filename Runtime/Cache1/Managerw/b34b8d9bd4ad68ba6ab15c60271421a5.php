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
			<div id="tb" style="padding:5px;height:auto">
    <input class="easyui-combobox" style="width:100px" id="cb" />
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="getList()">搜索</a>
</div>
<table id="tt" class="easyui-datagrid" style="width:auto;"
        toolbar="#tb" title="各主题的内容" iconCls="icon-save" fit="true"
        rownumbers="true" pagination="true">
    <thead>
        <tr>
            <th field="a" width="50" formatter="formatAvatar" align="center" halign="center">头像</th>
            <th field="n" width="80" formatter="formatNickname" align="center" halign="center">用户名</th>
            <th field="content" width="560">说的话</th>
            <th field="addtime" width="80" align="center">添加时间</th>
        </tr>
    </thead>
</table>

<script>

function formatAvatar(val, row){
    var url = '/Public/Avatars/' + row.user.fakeid + '.jpg'
    return '<img src="' + url + '" width="30px"/>';
}
function formatNickname(val, row){
    return row.user.nickname;
}

var baseUrl = "/tjuwechat/index.php?g=Manager&m=Msgwall&a=actlist&activity=";
var activity = -1;
var args = {
    rownumbers : true,
    pagination : true, 
    fitColumns : true,
    columns : [[
        {field:'a', title:'头像', width:50, formatter:formatAvatar, align:'center', halign:'center'}, 
        {field:'n', title:'用户名', width:80, formatter:formatNickname, align:'center', halign:'center'}, 
        {field:'content', title:'大家说的话', width:560}, 
        {field:'addtime', title:'添加时间', width:100}
    ]]
};

$('#cb').combobox({
    url:'/tjuwechat/index.php?g=Manager&m=Activity&a=alist',
    valueField:'id',
    textField:'name',
    onSelect:function(rec){
        activity = rec.id;
    }
});

function getList(){
    args.url = baseUrl + $('#cb').combobox('getValue');;
    $('#tt').datagrid(args);
}
</script>
		</div>
	</div>
</body>
</html>