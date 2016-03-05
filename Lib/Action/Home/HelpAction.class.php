<?php

class HelpAction extends BaseAction {

	private $msg;

	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);

		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");

		if ($recvObj->msgType == "text"){
			$this->msg = str_replace($qian, $hou, $recvObj->content);
		
			if ($this->msg == '帮助' || $this->msg == 'h'|| $this->msg == 'H') {
				return true;
			}
		} else if ($recvObj->msgType == "event" 
			&& $recvObj->event == "CLICK"){
			if ($recvObj->eventKey == 'h') {
				return true;
			}
			return true;
		}
		return false;
	}

	function handle(){
		$contentStr = "★学习类：

【查自习室】
发送“自习+教学楼”（例如：“自习 26楼A座”），获取当前时段可用自习室情况；发送“自习+教学楼+第几节课”（例如：“自习 西阶 晚第二节课”），获取对应时段可用自习室情况。

【英汉翻译】
发送“翻译+中文/英文/日文”（例如：“翻译 I love you ”）。支持英汉互译、日译汉。

【成语大全】
发送“成语+成语内容”（例如：“成语 千言万语”），获取成语的出处及例子。

【历史上的今天】
发送“历史”，获取历史上的今天都发生了哪些大事件。

【百度百科】
发送“百科+内容”（例如：“百科+天津大学”），获取对应内容的百度百科信息。

【加权查询】
发送“分数”，查询自己的加权与绩点。

★生活类：

【天气查询】
发送“天气”，获取天津市天气信息；发送“城市名+天气”（例如：“北京 天气”），获取对应城市天气信息。 

【快递查询】
发送“某某快递+快递单号”（例如：“顺丰快递 966902008817”），获取物流信息。

【附近查询】
微信发送你的地理位置，记录成功后，发送“附近+查询内容”（例如：“附近 KTV”），获取所在位置附近的相关信息。


★娱乐类：

【周公解梦】
发送“梦见+所梦内容”（例如：“梦见 火”），获取周公解梦内容。

【星座运势】
发送“星座+星座名”（例如：“星座 处女座”），获取当日星座运势。

【菜谱查询】
发送“菜谱+菜名”（例如：“菜谱 剁椒鱼头”），获取菜谱详情。

【微笑鉴定】
微信直接发送照片，获取人脸识别结果。
";

		return parent::getTextXml($contentStr);
	}
}

?>