<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>微信墙大屏幕</title>
    <link rel="stylesheet" type="text/css" href="__ROOT__/Public/Css/msgwall.css" />
    <script type="text/javascript" src="__ROOT__/Public/Js/jquery.min.js"></script>
    <script type="text/javascript" src="__ROOT__/Public/Js/msgwall/msgwall.js"></script>
</head>

<body>
<div class="main">
    <div class="top" onclick="viewExplanToggle();">
    	<div class="k">
        	添加微信号：<b style="font-size:24px;">天津大学团委</b> 或 <b style="font-size:24px;">y02tju</b><br />发送 <b style="font-size:24px;">#十佳青年#+内容</b> 即可上墙！
        </div>
    </div>
	<div class="wall">
		<div class="left"></div>
		<div class="center">
			<div class="list">
				<ul id="list"></ul>
			</div>
			<div class="footer"></div>
		</div>
		<div class="right"></div>
	</div>
	<div class="mone" id="mone" onclick="viewOneHide();"></div>
	<div id="explan" style="display:none" onclick="viewExplanToggle();">
    	<div class="explain_half"><p>
        	<b style="font-size:50px;">【上墙方法】</b>
            <!--<b style="color:#FDCB08;font-size:36px;">【扫一扫 加关注】</b>-->
            <br />扫描右侧二维码<br />搜索<b style="color:#FDCB08;font-size:40px;">天津大学团委</b><br />微信号<b style="color:#FDCB08;font-size:40px;">y02tju</b>
            <!--<b style="color:#FDCB08;font-size:36px;"">【发消息参与互动】</b>--><br />发送<b style="color:#FDCB08;font-size:40px;">#十佳青年#+内容</b><br />即可上墙！
        </p></div>
        <div class="explain_half">
        	<!--<div style="width:100%;height:80%; margin-left:-30px; background:url(./images/tdcode3.png) center center no-repeat;"></div>-->
            <table style="width:100%;height:80%; margin-left:-30px;margin-top:45px;"><tr><td><img src="__ROOT__/Public/Images/msgwall/tdcode3.png"/></td></tr></table>
            <!--<div style="width:100%;height:10%;line-height:12px;margin-left:-30px;font-size:36px;color:#FDCB08; text-align:center;"><b>关注团委　　如此简单</b></div>-->
        </div>
    </div>
    <!--<div id="setting">
        <input type="text" id="interval_setting"/><input type="button" onclick="intervalSetting();" value="设置时间间隔" />
    </div>-->
</div>
</body>
</html>