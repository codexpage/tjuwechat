<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript" src="__ROOT__/Public/Js/jquery.min.js"></script><style>
html, body {
	margin:0px;
	width: 100%;
	text-align: center;
}

.header_top {
	width:1024px;
	height:4px;
	background: url("__ROOT__/Public/Images/vote/top.png");
}

.header_title {
	width:1024px;
	height:124px;
	background: url("__ROOT__/Public/Images/vote/title.png");
}

.footer {
	width:1024px;
	height:84px;
	background: url("__ROOT__/Public/Images/vote/logo.png") no-repeat center center;
	margin-top: 10px;
}

.result {
	position:absolute;
	top:130px;
	width:1024px;
	height:auto;
	background: url("__ROOT__/Public/Images/vote/shelter.jpg") ;
}

#table {
	display: inline;
}

.table_ele {
	position: relative;
	margin: 5px 10px 5px 40px;
	width: 180px;
	height: 85px;
	float: left;
	padding: 5px 5px 5px 90px;
	background: #ffffff;
	font-size: 22px;
	line-height: 18px;
	font-family: "Microsoft YaHei";
	font-weight: bold;
}

.table_ele img {
	position: absolute;
	left: 5px;
	width: 85px;
	height: 85px;
}

.table_ele .code {
	margin: 5px 0px;
	color: #3d749e;
}

.table_ele .poll {
	margin: 5px 0px;
	color: #7fbb01;
	font-size: 28px;
}

.votechart {
	top: 150px;
	width:1024px;
	height:540px
}
</style>
<body>
<div style="margin:0 auto;width:1024px;position:relative">
	<div class="header_top"></div>
	<div class="header_title" id="title"></div>
	<div class="votechart"></div>
	<div class="footer"></div>
	<div class="result" id="result">
		<div id="table">
		</div>
	</div>
</div>
</body>
<script type="text/javascript">
function loadComs() {
	$.ajax({
        "cache" : false,
        "dataType" : 'json',
        "type" : "POST",
        "async" : false,
        "url" : "/tjuwechat/?g=Manager&m=Vote&a=show_vote_results&query=1",
        "error" : function(xhr, status, errorThrown){
            alert("发生网络错误:" + r.status + " " + errorThrown);
        },
        "success" : loadCallback
    });
}

function loadCallback(json){
	var $tr;
	for (var i = 0 ; i < json.length ; i++){
        var obj = json[i];
		var html = "<div class='table_ele'><img src='/Public/Images/vote/avatars/" + obj.code + ".jpg'/><p class='code'>" + obj.code + "号 " + obj.name + "</p><br/><p class='poll' id='poll" + obj.code + "'>票数 " + obj.poll + "</p></div>";
		$("#table").append(html);
    }
    $("#table").append("<div style='clear:both'></div>");
}
loadComs();
$("#result").toggle();
$("#title").click(function(){
	$("#result").toggle("slow");
});
</script>
<!-- 注意，include本文件，必须要引用jquery文件，且在include之前，必须创建class名为
     votechart的元素（如div），这将是盛放图表的容器 -->
<!DOCTYPE html>
<meta charset="utf-8">
<style>

/*body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  position: relative;
  width: 960px;
}*/

.axis text {
  font: 10px sans-serif;
}

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.bar {
  fill: steelblue;
  fill-opacity: .9;
}

.x.axis path {
  display: none;
}

label {
  position: absolute;
  top: 10px;
  right: 10px;
}

</style>
<script type="text/javascript" src="__ROOT__/Public/Js/d3.v3.min.js"></script>
<script>

var data_src = "/tjuwechat/?g=Manager&m=Vote&a=show_vote_results";

var margin = {top: 20, right: 20, bottom: 30, left: 40},
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

var x = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1, 1);

var y = d3.scale.linear()
    .range([height, 0]);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")

var svg = d3.select(".votechart").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.tsv(data_src, function(error, data) {

  data.forEach(function(d) {
    d.poll = +d.poll;
  });

  x.domain(data.map(function(d) { return d.letter; }));
  y.domain([0, d3.max(data, function(d) { return d.poll; })]);

  svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis);

  svg.append("g")
      .attr("class", "y axis")
      .call(yAxis)
    .append("text")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .text("票数");

  svg.selectAll(".bar")
      .data(data)
    .enter().append("rect")
      .attr("class", "bar")
      .attr("x", function(d) { return x(d.letter); })
      .attr("width", x.rangeBand())
      .attr("y", function(d) { return y(d.poll); })
      .attr("height", function(d) { return height - y(d.poll); });

  svg.select(".x.axis").selectAll("g").data(data)
      .append("text")
      .text(function(d) { return d.code + "号"; })
      .attr("y", 21)
      .attr("dy", ".71em")
      .attr("transform", "translate(-10, 0)");

  //sortBars();

  setInterval(function(){
      $.ajax({
        "cache" : false,
        "dataType" : 'json',
        "type" : "POST",
        "async" : false,
        "url" : data_src + "&query=1",
        "data" : {"status" : 2},
        "error" : function(xhr, status, errorThrown){
            alert("发生网络错误:" + r.status + " " + errorThrown);
        },
        "success" : queryCallback
      });
  }, 3000);

  function queryCallback(json){
      var changed = false;
      data.forEach(function(d) {
        for (var i = 0 ; i < json.length ; i++){
          var obj = json[i];
          if (d.code == obj.code && d.poll != obj.poll) {
              changed = true;
              d.poll = obj.poll;
              $("#poll" + d.code).text("票数 " + d.poll);
          }
        }
      });
      if (!changed)
        return;
      y.domain([0, d3.max(data, function(d) { return d.poll; })]);
      var trans = svg.transition().duration(750),
          delay = function(d, i) { return i * 50; };

      trans.selectAll(".bar")
          .delay(delay)
          .attr("y", function(d) { return y(d.poll); })
          .attr("height", function(d) { return height - y(d.poll); });
      trans.select(".y.axis")
          .call(yAxis)
          .selectAll("g")
          .delay(delay);

      //setTimeout(function(){sortBars();}, 1000);
  }

  function sortBars(){
    var x0 = x.domain(data.sort(function(a, b) { return b.poll - a.poll; })
      .map(function(d) { return d.letter; }))
      .copy();

    var transition = svg.transition().duration(750),
        delay = function(d, i) { return i * 50; };

    transition.selectAll(".bar")
        .delay(delay)
        .attr("x", function(d) { return x0(d.letter); });

    transition.select(".x.axis")
        .call(xAxis)
      .selectAll("g")
        .delay(delay);
  }

});

</script>