<?php

class APIAction extends BaseAction{
	
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		
		//$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );//截取前两个字
		
		if ($this->msg == 'T34') {
			return true;
		}
		return false;
	}

	function handle(){
		$url = "http://snsosnso83.gotoip3.com/api?auth=T34";
		$auth = "T34";
		$token = "f931822fed1932e33450b913054a0c3d";
	

        $curlPost=array("token"=>$token);
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

		return parent::getTextXml($data);
	}

	function sendGet($url){
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}

	function sendPost($url, $postData){
		$ch = curl_init () ;
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url) ;
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}
}
?>