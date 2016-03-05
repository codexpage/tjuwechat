<?php

class IdAction extends BaseAction {

	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		
		$str1 = mb_substr ( $this->msg, 0, 3, "UTF-8" );//截取前两个字
		
		if ($str1 == '身份证') {
			return true;
		}
		return false;
	}
	
	function handle(){
		$str_key = mb_substr ( $this->msg, 3, mb_strlen ( $this->msg ) - 1, "UTF-8" );
		
		$data = $this->id_search ( $str_key );
		if (! empty ( $data )) {
			$contentStr = "性别：" . $data->sex . "\n生日：" . $data->born . "\n归属地：" . $data->att;
		} else {
			$contentStr = "未查到身份证号" . $str_key . "的信息";
		}
		
		return parent::getTextXml($contentStr);
	}

	//调用身份证查询api
	private function id_search($id_number) {
		if (! empty ( $id_number )) {
			$json = file_get_contents ( "http://api.k780.com/?app=idcard.get&idcard=" . $id_number . "&appkey=10021&sign=13e512adb1ec0e128ffa9c2ea00c6f77&format=json" );
			$text = json_decode ( $json );
			return $text->result;
		} else {
			return null;
		}
	}
}
?>