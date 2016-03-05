<?php

class KeXueYingAction extends BaseAction {

	private $msg;

	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		
		if ($recvObj->msgType == "text"){
			$this->msg = str_replace($qian, $hou, $recvObj->content);
		
			if ($this->msg == "科学营") {
				return true;
			}
		} else if ($recvObj->msgType == "event" 
			&& $recvObj->event == "CLICK" && $recvObj->eventKey == "科学营"){
			return true;
		}
		return false;
	}

	function handle(){
		$contentStr = "亲爱的营员同学们，欢迎关注天津大学团委微信平台，我们每天会为大家带来科学营的最新信息，请点击右下角的【科技邂逅】栏目，为大家设置了【日程安排】、【往日精彩】、【掌上讲堂】、【联系小班】服务板块，为同学们提供在科学营期间的贴心服务。";
		return parent::getTextXml($contentStr);
	}

}

?>