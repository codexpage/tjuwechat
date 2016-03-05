<?php

class PhoneAction extends BaseAction {

	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		
		$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );//截取前两个字
		
		if ($str1 == '手机') {
			return true;
		}
		return false;
	}
	
	function handle(){
		$str_key = mb_substr ( $this->msg, 2, mb_strlen ( $this->msg ) - 1, "UTF-8" );
		
		$data = $this->phone_search ( $str_key );
		if ($data->success == 1) {
			$contentStr = "所在城市：" . $data->result->att . "\n卡类型：" . $data->result->ctype;
		} else {
			$contentStr = $data->msg;
		}
		
		return parent::getTextXml($contentStr);
	}

	//调用手机号码查询api
	private function phone_search($phone_number) {
		if (! empty ( $phone_number )) {
			$json = file_get_contents ( "http://api.k780.com/?app=phone.get&phone=" . $phone_number . "&appkey=10021&sign=13e512adb1ec0e128ffa9c2ea00c6f77&format=json" );
			$text = json_decode ( $json );
			return $text;
		} else {
			return null;
		}
	}
}
?>