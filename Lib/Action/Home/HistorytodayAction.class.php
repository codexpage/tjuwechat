<?php

class HistorytodayAction extends BaseAction{
	
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		
		if ($this->msg == '历史') {
			return true;
		}
		return false;
	}
	function handle(){
		$data = $this->lishi ();
		if (! empty ( $data )) {
			$contentStr = $data;
		} else {
			$contentStr = "404 \n Not Found";
		}
		
		return parent::getTextXml($contentStr);
	}

	private function lishi() {
		$str = "%E8%8B%8F%E7%95%85Thug4Life";
		$json = file_get_contents ( "http://api100.duapp.com/history/?appkey=" . $str );
		$text = json_decode ( $json );
		return $text;
	}
}
?>