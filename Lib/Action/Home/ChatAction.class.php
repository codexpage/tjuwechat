<?php

class ChatAction extends BaseAction{
	
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$this->msg = $recvObj->content;
		
		
		return true;
	}

	function handle(){	
		$data = $this->chat ( $this->msg );
		
		return parent::getTextXml($data);
	}

	private function chat($keyword) {
		$curlPost=array("chat"=>$keyword);
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,'http://www.xiaojo.com/bot/chata.php');//抓取指定网页
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        if(!empty($data))
        {
            return $data;
        }else{
            return "嘿嘿，不太懂诶~";
        }
	}
}
?>