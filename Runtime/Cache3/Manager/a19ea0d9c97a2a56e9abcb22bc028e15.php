<?php if (!defined('THINK_PATH')) exit();?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>天津大学团委-微信墙抽奖</title>

<style type="text/css">
*{margin:0;padding:0;}
body{font-size:12px;color:#222;font-family:"Microsoft YaHei";background:#f0f0f0;text-align: center;}
p{font-family: "楷体","楷体_GB2312"; font-size: 24px; font-weight: bold}
button{font-family: "楷体","楷体_GB2312"; font-size: 20px;}
.clear:after{content: ".";display: block;height: 0;clear: both;visibility: hidden;}
.clear{zoom:1;}
ul,li{list-style:none;}
img{border:0;}
.wrapper{width:1024px;margin:0 auto;background: url("__ROOT__/Public/Images/lotteryboard/bg.jpg");}
/* focus */
.content_bg {height:515px;float:left;margin-left: 15px}
.title{text-align: left;color:#ffffff;margin:10px 0 0 10px;}
.title span{color:#fdcb08;}
.lottery_btn {background:url("__ROOT__/Public/Images/lotteryboard/scroll_lottery.png") center;width:263px;height:36px;margin-top:10px}

.table_ele {
	position: relative;
	margin: 5px 10px 5px 40px;
	width: 170px;
	height: 50px;
	float: left;
	padding: 5px 5px 5px 90px;
	font-size: 22px;
	line-height: 18px;
	font-family: "Microsoft YaHei";
	font-weight: bold;
}

.table_ele img {position: absolute; left: 5px; width: 50px;	height: 50px;}
.table_ele .name {margin: 5px 0px; text-align: left; line-height: 40px; color: #ffffff;}
#footer{margin-top:20px;}
#footer p{margin:auto;color: #817e7e}
#footer a{text-decoration: none; color: #003e7e}
</style>
	<script type="text/javascript" src="__ROOT__/Public/Js/jquery.min.js"></script>
<script type="text/javascript">
var students = new Array();
<?php if(is_array($users)): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?>students.push('<?php echo ($user["nickname"]); ?>');<?php endforeach; endif; else: echo "" ;endif; ?>

$(document).ready(function(e) {
	$(".lottery_btn").click(function(){
		getMessage($(this).attr('lottery'), $(this).attr('num'), $(this));
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
		"error" : function(xhr, status, errorThrown){
			alert("发生网络错误:" + r.status + " " + errorThrown);
		},
		"success" : function(json){
			$("#lottery_num").text(json.users.length);
			$("#parti_num").text(json.count);
			$("#result").html("");
			for (var i = 0 ; i < json.users.length ; i++){
		        var obj = json.users[i];
				var html = "<div class='table_ele'><img src='/Public/Avatars/" + obj.fakeid + ".jpg' onerror='javascript:this.src=/Public/default.jpg'/><p class='name'>" + obj.nickname + "</p></div>";
				$("#result").append(html);
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
			<div style="color:#ffffff;font-size:32px;float:left;margin:20px 0px 0px 40px">“四海同心向北洋” 2014届天津大学毕业晚会</div>
			<div class="clear"></div>
			<div style="color:#fdcb08;font-size:30px;float:right;margin:0px 60px 20px 0px">校团委微信现场抽奖</div>
			<div class="clear"></div>
		</div>

		<div id="content">
			<div style="background:url('__ROOT__/Public/Images/lotteryboard/mask1.png');width:340px" class="content_bg">
				<p class="title">抽奖区|参加抽奖人数<span id="parti_num"><?php echo ($count); ?></span></p>
				<button class="lottery_btn" lottery="1" num="1">抽取一等奖</button>
				<button class="lottery_btn" lottery="2" num="2">抽取二等奖</button>
				<button class="lottery_btn" lottery="3" num="3">抽取三等奖</button>
			</div>
			<div style="background:url('__ROOT__/Public/Images/lotteryboard/mask2.png');width:632px" class="content_bg">
				<p class="title">抽奖名单|获奖人数<span id="lottery_num">0</span></p>
				<div style="width:100%" id="result"></div>
			</div>
			<div class="clear"></div>
		</div><!--focus end-->

		<div id="footer">
			<img src="__ROOT__/Public/Images/lotteryboard/logo.png"/>
		</div>
	</div><!-- wrapper end -->
</body>
</html>