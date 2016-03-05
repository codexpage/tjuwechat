<?php

class YxjAction extends BaseAction {
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");

		if ($recvObj->msgType == "text"){
			$this->msg = str_replace($qian, $hou, $recvObj->content);
		
			if ($this->msg == "益行家"||$this->msg == "QQ"||$this->msg == "qq"||$this->msg == "腾讯") {
				return true;
			}
		} else if ($recvObj->msgType == "event" 
			&& $recvObj->event == "CLICK"){
				if($recvObj->eventKey=="益行家"){
					return true;
				}
		}
		
		return false;
	}
	function handle(){
		$return_arr = array (
			array (
					"益行家全国高校藏地挑战赛天津大学报名指南！",
					"益行家活动报名时间为3月12日-4月12日。腾讯益行家官网：yxj.qq.com。天津大学益行家QQ群：185493696，为大家搭建了答疑交流组队的平台，请大家务必进群。",	"http://tjuxinmeiti.tju.edu.cn/pages/images/yxj/yxj1.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200988907&idx=1&sn=e8982999562449ece13dd0da7e2b2f9a#rd" 
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