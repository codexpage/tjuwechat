<?php

class IpaddressAction extends BaseAction {

	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		
		$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );//截取前两个字
		
		if ($str1 == 'ip') {
			return true;
		}
		return false;
	}
	function handle(){
		$str_key = mb_substr ( $this->msg, 2, mb_strlen ( $this->msg ) - 1, "UTF-8" );
		
		$data = $this->ip_search ( $str_key );
		if (! empty ( $data->result)) {
			$contentStr = "ip归属地：" . $data->result->att. "\n详细信息：" . $data->result->detailed;
		} else {
			$contentStr = "未查到ip地址" . $str_key . "的信息";
		}
		
		return parent::getTextXml($contentStr);
	}

	//调用ip地址查询api
	private function ip_search($ip_number) {
		if (! empty ( $ip_number )) {
			$file_contents = sendGet ( "http://api.k780.com/?app=ip.get&ip=" . $ip_number . "&appkey=10021&sign=13e512adb1ec0e128ffa9c2ea00c6f77&format=json");
			$file_contents = json_decode ( $file_contents );
			return $file_contents;
		} else {
			return null;
		}
	}
}
?>