<?php if (!defined('THINK_PATH')) exit();?>﻿<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>天津大学团委-微信墙抽奖</title>
<style type="text/css">
*{margin:0;padding:0;}
body{font-size:12px;color:#222;font-family:"Microsoft YaHei";background:#f0f0f0;text-align: center;}
p{font-family: "Microsoft YaHei","Microsoft YaHei"; font-size: 24px; font-weight: bold}
button{font-family: "Microsoft YaHei","Microsoft YaHei"; font-size: 20px;}
.clear:after{content: ".";display: block;height: 0;clear: both;visibility: hidden;}
.clear{zoom:1;}
ul,li{list-style:none;}
img{border:0;}
.wrapper{width:1024px;height:768px;margin:0 auto;background: url("__ROOT__/Public/Images/lotteryboard/bg.jpg") center no-repeat;}
/* focus */
.content_bg {height:515px;float:left;margin-left: 15px}
.title{text-align:center;color:#ffffff;margin:10px 0 0 10px;}
.title span{color:#fdcb08;}
.lottery_btn {background:url("__ROOT__/Public/Images/lotteryboard/scroll_lottery.png") center;width:263px;height:36px;margin-top:10px;color:#A00202;font-weight:bold; }
#special_lottery_btn {background:url("__ROOT__/Public/Images/lotteryboard/scroll_lottery.png") center;width:263px;height:36px;margin-top:10px;color:#A00202;font-weight:bold; }

.table_ele {
	position: relative;
	margin: 8px 0px 8px 15px;
	width: 200px;
	height: 68px;
	float: left;
	padding: 5px 5px 5px 88px;
	font-size: 28px;
	line-height: 5px;
	font-family: "Microsoft YaHei";
	font-weight: bold;
	background:url("__ROOT__/Public/Images/lotteryboard/ele_bg.png");
}

.table_ele img {position: absolute; left: 5px; width: 65px;	height: 65px;border: #CFCFCF 2px solid;}
.table_ele .name {margin: 3px 0px; text-align: left; line-height: 30px; color: #0C62B1;}
.scroll {background:url("__ROOT__/Public/Images/lotteryboard/ele_bg.png"; width: 263px; height: 65px;text-align: center; color: #0C62B1;}
#footer{margin-top:10px; padding-top:20px}
#footer p{margin:auto;color: #817e7e}
#footer a{text-decoration: none; color: #003e7e}
</style>
	<script type="text/javascript" src="__ROOT__/Public/Js/jquery.min.js"></script>
<script type="text/javascript">
var students = new Array();
<?php if(is_array($users)): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?>students.push('<?php echo ($user["nickname"]); ?>');<?php endforeach; endif; else: echo "" ;endif; ?>
var isSpecialRunning = false;
var showInterval;//interval
var scrollIndex = 0;
var showIndex = 0;
var showJson;
$(document).ready(function(e) {
	$(".lottery_btn").click(function(){
		if (isSpecialRunning) {
			isSpecialRunning = false;
			$("#result").html("");
			$(this).text($(this).attr("v"));
			showResults();
		} else {
			isSpecialRunning = true;
			getMessage($(this).attr('lottery'), $(this).attr('num'), $(this));
			$(this).text("再点一下");
			scroll();
		}
	});
	$(".lottery_btn").each(function(){$(this).text($(this).attr("v"));})
	$("#special_lottery_btn").click(function(){
		if (isSpecialRunning) {
			isSpecialRunning = false;
			getSpecialResult();
			$(this).text("抽取特等奖");
		} else {
			isSpecialRunning = true;
			getSpecial();
			$(this).text("点击选出最终奖");
		}
	});
});
function getMessage(lottery, num, obj) {
	$.ajax({
		"cache" : false,
		"dataType" : 'json',
		"type" : "POST",
		"async" : false,
		"url" : "/tjuwechat/?g=Manager&m=Msgwall&a=lottery",
		"data":{"lottery":lottery, "num":num},
		"success" : function(json){
			$("#lottery_num").text(json.users.length);
			$("#parti_num").text(json.count);
			$("#result").html("");
			showIndex = 0;
			showJson = json.users;
		}
	});
}

function getSpecial() {
	$.ajax({
		"cache" : false,
		"dataType" : 'json',
		"type" : "POST",
		"async" : false,
		"url" : "/tjuwechat/?g=Manager&m=Msgwall&a=lottery_for_special_list",
		"success" : function(json){
			students = new Array();
			for (var i = 0; i < json.length ; i++) {
				students.push(json[i].nickname);
			}
			scroll();
		}
	});
}

function getSpecialResult() {
	$("#result").html("");
	$.ajax({
		"cache" : false,
		"dataType" : 'json',
		"type" : "POST",
		"async" : false,
		"url" : "/tjuwechat/?g=Manager&m=Msgwall&a=lottery_for_special",
		"success" : function(json){
			showIndex = 0;
			showJson = json;
			$("#result").html("");
			showResults();
		}
	});
}

function showResults() {
	var obj = showJson[showIndex];
	showIndex++;
	var html = "<div class='table_ele'><img src='/Public/Avatars/" + obj.fakeid + ".jpg' onerror='javascript:this.src=/Public/default.jpg'/><p class='name'>" + obj.nickname + "</p></div>";
	$("#result").append(html);
	if (showIndex < showJson.length) {
		setTimeout(showResults, 100)
	} else {
		$("#scroll").html(" ");
		clearInterval(showInterval);
	}
}

function scroll() {
	showInterval = setInterval(function(){
		var obj = students[scrollIndex];
		scrollIndex = (scrollIndex+1) % students.length;
		//var html = obj;
		var html = "<p class='name'>" + obj + "</p>";
		$("#scroll").html(html);
	}, 100);
}
</script>
</head>
<body>
	<div class="wrapper">
		<div id="header">
		  <div style="color:#ffffff;font-size:38px;float:left;margin:30px 0px 0px 110px;font-align:center">自动化学院2014级新生晚会</div>
			<div class="clear"></div>
			<div style="color:#fdcb08;font-size:30px;float:right;margin:15px 60px 20px 0px;font-weight: bold">校团委微信平台抽奖墙</div>
			<div class="clear"></div>
		</div>

		<div id="content">
			<div style="background:url('__ROOT__/Public/Images/lotteryboard/mask1.png');width:340px" class="content_bg">
				<p class="title">抽奖区 | 参加抽奖人数 <span id="parti_num">***</span></p>
				<div id="scroll" style="height: 75px; width: 263px; margin: 10px 0 4px 38px; opacity: 0.3; background: #E9E9E9; border: #CFCFCF 2px solid;"><p class="name">&nbsp;</p></div>
				<button class="lottery_btn" lottery="1" num="5" v="抽奖"></button>
				<!--<button class="lottery_btn" lottery="2" num="10" v="二等奖10"></button>
				<button class="lottery_btn" lottery="3" num="10" v="三等奖 01-10"></button>
				<button class="lottery_btn" lottery="4" num="10" v="三等奖 11-20"></button>
                <button class="lottery_btn" lottery="5" num="10" v="三等奖 21-30"></button>
                <button class="lottery_btn" lottery="6" num="10" v="三等奖 31-40"></button>
                <button class="lottery_btn" lottery="7" num="10" v="三等奖 41-50"></button>
				<button id="special_lottery_btn">抽取特等奖</button>-->

			</div>
			<div style="background:url('__ROOT__/Public/Images/lotteryboard/mask2.png');width:632px" class="content_bg">
				<p class="title">抽奖名单 | 获奖人数 <span id="lottery_num">0</span></p>
				<div style="width:100%" id="result"></div>
			</div>
			<div class="clear"></div>
		</div><!--focus end-->

		<div id="footer" style="padding-top:10px">
			<img src="__ROOT__/Public/Images/lotteryboard/logo.png"/>
		</div>
	</div><!-- wrapper end -->
</body>
</html>