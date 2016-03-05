<?php if (!defined('THINK_PATH')) exit();?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>天津大学团委-微信平台留言板</title>

<style type="text/css">
*{margin:0;padding:0;}
body{font-size:12px;color:#222;font-family:"Microsoft YaHei";background:#f0f0f0;text-align: center;}
.clearfix:after{content: ".";display: block;height: 0;clear: both;visibility: hidden;}
.clearfix{zoom:1;}
ul,li{list-style:none;}
img{border:0;}
.wrapper{width:1024px;margin:0 auto;}
/* focus */
#focus {width:1024px;height:550px;overflow:hidden;position:relative;margin:auto;}
#focus ul{height:550px;position:absolute;}
#focus ul li{float:left;width:1024px;height:550px;overflow:hidden;position:relative;background:#000;}
#focus .btnBg{position:absolute;width:1024px;height:20px;left:0;bottom:0;background:#000;}
#focus .btn{position:absolute;width:1000px;height:10px;padding:5px 10px;bottom:0;text-align:center;}
#focus .btn span{display:inline-block;_display:inline;_zoom:1;width:25px;height:10px;_font-size:0;margin-left:5px;cursor:pointer;background:#fff;}
.f5{
	padding-top:10px !important;
	font-size:22px;
	line-height:1.5em;
}

.f4{
	padding-top:10px !important;
	font-size:26px;
	line-height:1.5em;
}

.f3{
	padding-top:12px !important;
	font-size:32px;
	line-height:1.6em;
}

.f2{
	padding-top:20px !important;
	font-size:40px;
	line-height:1.6em;
}

.f1{
	padding-top:36px !important;
	font-size:50px;
	line-height:1.6em;
}
#focus .btn span.on{background:#fff;}
#msgboard{position:absolute;background: url("__ROOT__/Public/Images/msgboard/msgboard.png");width: 585px;height: 310px;z-index: 100; bottom:50; right: 50px;}
#msgboard p{font-family: "楷体","楷体_GB2312"; font-size: 24px; font-weight: bold}
#footer{margin-top:20px;}
#footer p{margin:auto;color: #817e7e}
#footer a{text-decoration: none; color: #003e7e}
</style>
	<script type="text/javascript" src="__ROOT__/Public/Js/jquery.min.js"></script>
	<script type="text/javascript" src="__ROOT__/Public/Js/msgboard/mbscroll.js"></script>
<script type="text/javascript">

var mtime;
var interval = 3000;

$(document).ready(function(e) {
	$("#msgboard").hide();
	mtime = setInterval(getMessage, interval);
});
function getMessage() {
	$.ajax({
		"cache" : false,
		"dataType" : 'json',
		"type" : "POST",
		"async" : false,
		"url" : "/tjuwechat/?g=Manager&m=Msgwall&a=get_one_board",
		"error" : function(xhr, status, errorThrown){
			alert("发生网络错误:" + r.status + " " + errorThrown);
		},
		"success" : function(d){
			if (d.id) {
				var content=d.content;
				if (content.length >=0 && content.length <= 4)
			$("#msgcontent").css("font-size", "60px");
				else if (content.length > 4 && content.length <= 6)//一行18个字，人名占位以最大8个来计，两行是28个字
			$("#msgcontent").css("font-size", "56px");
				else if (content.length > 6 && content.length <= 8)//一行23个字，人名占位以最大8个来计，三行是61个字
			$("#msgcontent").css("font-size", "46px");
				else if (content.length > 8 && content.length <= 12)//一行28个字，人名占位以最大8个来计，四行是61个字
			$("#msgcontent").css("font-size", "40px");
				else if (content.length > 12 && content.length <= 16)//一行33个字，人名占位以最大8个来计，五行是157个字
			$("#msgcontent").css("font-size", "38px");
				else if (content.length > 16 && content.length <= 36)//一行33个字，人名占位以最大8个来计，五行是157个字
			$("#msgcontent").css("font-size", "38px");
				else if (content.length > 36 && content.length <= 48)//一行33个字，人名占位以最大8个来计，五行是157个字
			$("#msgcontent").css("font-size", "30px");
				else if (content.length > 48 && content.length <= 58)//一行33个字，人名占位以最大8个来计，五行是157个字
			$("#msgcontent").css("font-size", "26px");
				else if (content.length > 58 && content.length <= 80)//一行33个字，人名占位以最大8个来计，五行是157个字
			$("#msgcontent").css("font-size", "24px");
			else if (content.length > 80)//一行33个字，人名占位以最大8个来计，五行是157个字
				$("#msgcontent").css("font-size", "20px");
				//$("#msgcontent").addClass(className);
				$("#msgcontent").text(content);
				$("#msgboard").show();
			}
		}
	});
}
function getJsonLength(jsonData){
	var length = 0;
	for(var item in jsonData){
		length++;
	}
	return length;
}
</script>
</head>

<body>
	<div class="wrapper">
		<div id="header">
			<img style="float:left" src="__ROOT__/Public/Images/msgboard/head.png"/>
			<img style="float:right" src="__ROOT__/Public/Images/msgboard/tittle.png"/>
		</div>
		<div id="focus">
			<ul>
				<li><img src="__ROOT__/Public/Images/msgboard/1.jpg" /></li>
				<li><img src="__ROOT__/Public/Images/msgboard/2.jpg" /></li>
				<li><img src="__ROOT__/Public/Images/msgboard/3.jpg" /></li>
				<li><img src="__ROOT__/Public/Images/msgboard/4.jpg" /></li>
				<li><img src="__ROOT__/Public/Images/msgboard/5.jpg" /></li>
			</ul>
			<div id="msgboard">
				<p id="msgcontent" style="text-indent:2em;position:absolute;top:50px;left:40px;font-size:36px;text-align:left;width:505px;line-height:50px"></p>
				<p style="position:absolute;right:110px;bottom:60px">张昕楠</p>
				<p style="position:absolute;right:60px;bottom:20px">2014年4月24日</p>
			</div>
		</div><!--focus end-->
		<div id="footer">
			<p>新浪微博 腾讯微博<a href="javascript:void(0)">@天津大学团委</a> | 微信公众平台<a href="javascript:void(0)">y02tju</a></p>
			<p>共青团天津大学委员会新媒体推广部</a></p>
		</div>
	</div><!-- wrapper end -->
</body>
</html>