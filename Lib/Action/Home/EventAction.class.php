<?php



class EventAction extends BaseAction {



	function shouldHandle($recvObj){

		parent::shouldHandle($recvObj);

		$str1 = $recvObj->event;



		if ($str1 == 'subscribe') {

			return true;

		}

		return false;

	}



	function handle(){

		$contentStr = "感谢您关注天津大学团委微信平台！我们将第一时间为你提供最新的校园活动资讯和最全面的服务信息。目前微信平台具有的功能有：
-----------------------
查自习室    英汉翻译  
成语大全    百度百科  
历史今天    天气查询
快递查询    附近查询  
周公解梦    菜谱查询 
星座运势    微笑鉴定
加权查询
-----------------------
如果您想了解各功能的使用方法，请直接回复“帮助”或“h”获取相关信息。校团委新青年新媒体中心开始纳新了，同学们回复【报名】即可加入我们！";

		return parent::getTextXml($contentStr);

	}



}



?>