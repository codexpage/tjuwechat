<?php

class FunAction extends BaseAction {

	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		
		$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );//截取前两个字
		
		if ($str1 == '笑话') {
			return true;
		}
		return false;
	}
	function handle(){
		$data = $this->xiaohua ();
		if (! empty ( $data )) {
			$contentStr = $data;
		} else {
			$contentStr = "404 \n Not Found";
		}
		
		return parent::getTextXml($contentStr);
	}

	private function xiaohua() {
		$str = "%E8%8B%8F%E7%95%85Thug4Life";
		$json = file_get_contents ( "http://api100.duapp.com/joke/?appkey=" . $str );
		$text = json_decode ( $json );
		return $text;
	}
}

?>