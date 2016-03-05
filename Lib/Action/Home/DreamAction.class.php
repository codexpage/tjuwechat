<?php

class DreamAction extends BaseAction {

	private $msg;

	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);

		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );//截取前两个字

		if ($str1 == '梦见'|| $str1 == '梦到') {
			return true;
		}
		return false;
	}

	function handle(){
		$str_key = mb_substr ( $this->msg, 2, mb_strlen ( $this->msg ) - 3, "UTF-8" );

		$data = $this->dreamof ( $str_key );
		if (! empty ( $data )) {
			$contentStr = $data;
		} else {
			$contentStr = "周公不知道你为什么梦见" . $str_key;
		}

		return parent::getTextXml($contentStr);
	}

	private function dreamof($key) {
		$str = "%E8%8B%8F%E7%95%85Thug4Life";
		$json = sendGet ( "http://api100.duapp.com/dream/?appkey=" . $str . "&content=" . urlencode ( $key ));
		$text = json_decode ( $json );
		return $text;
	}

}

?>