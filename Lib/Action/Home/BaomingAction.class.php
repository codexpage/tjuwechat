<?php



class BaomingAction extends BaseAction {

	private $msg;

	

	function shouldHandle($recvObj){

		parent::shouldHandle($recvObj);

		

		$qian = array(" ","　","\t","\n","\r");

		$hou = array("","","","","");



		if ($recvObj->msgType == "text"){

			$this->msg = str_replace($qian, $hou, $recvObj->content);

		

			if ($this->msg == "报名") {

				return true;

			}

		} else if ($recvObj->msgType == "event" 

			&& $recvObj->event == "CLICK" && $recvObj->eventKey == "报名"){

			return true;

		}

		

		return false;

	}

	function handle(){

		$contentStr = "<a href=\"https://www.jinshuju.net/f/R7mapA\">点击报名</a>";

		return parent::getTextXml($contentStr);



	}

}