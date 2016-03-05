<?php

class PrintAction extends BaseAction{
	
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);

		if ($recvObj->msgType == "image"){
			return true;
		}else if($recvObj->msgType == "text"){
			$qian = array(" ","　","\t","\n","\r");
			$hou = array("","","","","");
			$this->msg = str_replace($qian, $hou, $recvObj->content);
			$this->msg = str_replace("＠", "@", $this->msg);
			if(stripos($this->msg, "@") != false)
			{
				return true;
			}
		}
		return false;
	}

	function handle(){
		$json = array();
		if($this->recvObj->msgType == "image"){
			$json["type"] = "URL";
			$json["url"] = $this->recvObj->picUrl;
			$json["name"] = $this->recvObj->fromUserName;
		}else{
			$code = strtok($this->msg, "@");
			$content = str_replace($code."@", "", $this->msg);
			$json["type"] = "WORD";
			$json["name"] = $this->recvObj->fromUserName;
			$json["code"] = $code;
			$json["content"] = $content;
		}

		$url = "http://markrui.eicp.net/tjuxinmeitiwx/index";
		$jsonStr = json_encode($json);

		$result = sendPost($url, "json=$jsonStr");

		preg_match_all("/<div>(.*?)<\/div>/s", $result, $mchs);	
		$data = htmlspecialchars_decode($mchs[1][0]);
		// $qian = array(" ","　","\t","\n","\r");
		// $hou = array("","","","","");
		// $data = str_replace($qian, $hou, $data);
		$reObj = json_decode($data);
		$content = $reObj->content;

		return parent::getTextXml($content);
	}
}
?>