<?php

class ZhoubianAction extends BaseAction {
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");

		if ($recvObj->msgType == "text"){
			$this->msg = str_replace($qian, $hou, $recvObj->content);
		
			if ($this->msg == "生活攻略") {
				return true;
			}
		} else if ($recvObj->msgType == "event" 
			&& $recvObj->event == "CLICK" && $recvObj->eventKey == "生活攻略"){
			return true;
		}
		
		return false;
	}
	function handle(){
		$return_arr = array (
			array (
					"【周边银行 】",
					"",	"http://tjuxinmeiti.tju.edu.cn/Public/Images/action/zhoubian/1.jpg",	"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=202848377&idx=1&sn=1a40105c4f9a099e709b905b5968ac58#rd" 
			),
			array (
					"【周边酒店】",
					"",	"http://tjuxinmeiti.tju.edu.cn/Public/Images/action/zhoubian/2.jpg",	"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=202848377&idx=2&sn=b732390691a03398b7361ccf5626112c#rd" 
			),
			array (
					"【周边购物】",
					"",	"http://tjuxinmeiti.tju.edu.cn/Public/Images/action/zhoubian/3.jpg",	"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=202848377&idx=3&sn=d4165c057730ec1ad8dce9693067a9bf#rd" 
			),
			array (
					"【周边美食】",
					"",	"http://tjuxinmeiti.tju.edu.cn/Public/Images/action/zhoubian/4.jpg",	"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=202848377&idx=4&sn=b90570db74785cb58519c359f7b9ee5e#rd" 
			)
		);
						
		//数组循环转化
		foreach ( $return_arr as $value ) {
			$contentStr .= "<item>\n
			<Title><![CDATA[" . $value [0] . "]]></Title>\n
			<Description><![CDATA[" . $value [1] . "]]></Description>\n
			<PicUrl><![CDATA[" . $value [2] . "]]></PicUrl>\n
			<Url><![CDATA[" . $value [3] . "]]></Url>\n
			</item>\n";
		}
		$count  =  count($return_arr);
		return parent::getNewsXml($count, $contentStr);
	}
}