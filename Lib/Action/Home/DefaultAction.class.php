<?php

class DefaultAction extends BaseAction {

	private $msg;

	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		return true;
	}

	function handle(){
		$contentStr = "小编已收到您发送的消息，感谢对天津大学团委微信平台的支持！目前微信平台具有的功能有：
-----------------------
查自习室    英汉翻译  
成语大全    百度百科  
历史今天    天气查询
快递查询    附近查询  
周公解梦    菜谱查询 
星座运势    微笑鉴定
加权查询
-----------------------
如果您想了解各功能的使用方法，请直接回复“帮助”或“h”获取相关信息。
";
		return parent::getTextXml($contentStr);
	}

}

?>