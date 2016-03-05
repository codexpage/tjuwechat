<?php

class SuggestAction extends BaseAction {

	private $msg;

	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);

		$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );//截取前两个字
		
		if ($str1 == '#三行诗#') {
			return true;
		}
		return false;
	}

	function handle(){
		$contentStr = "您发送的三行诗小编已经收到啦，感谢您对天津大学团委微信平台的支持！";

		return parent::getTextXml($contentStr);
	}

}

?>