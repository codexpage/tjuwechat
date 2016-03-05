<?php



class JianYiAction extends BaseAction {



	private $msg;



	function shouldHandle($recvObj){

		parent::shouldHandle($recvObj);

		

		$qian = array(" ","　","\t","\n","\r");

		$hou = array("","","","","");

		

		if ($recvObj->msgType == "text"){

			$this->msg = str_replace($qian, $hou, $recvObj->content);

		

			if ($this->msg == "建议") {

				return true;

			}

		} else if ($recvObj->msgType == "event" 

			&& $recvObj->event == "CLICK" && $recvObj->eventKey == "建议"){

			return true;

		}

		return false;

	}



	function handle(){

		$contentStr = "亲爱的同学，如果你对校团委微信有什么建议或宝贵意见的话，可发送内容至 tjuxinmeiti@126.com 与我们交流，小编非常期待你的建议哦~感谢你对天津大学团委微信平台的支持！";



		return parent::getTextXml($contentStr);

	}



}



?>