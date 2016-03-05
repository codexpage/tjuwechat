<?php

class ByjAction extends BaseAction {
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");

		if ($recvObj->msgType == "text"){
			$this->msg = str_replace($qian, $hou, $recvObj->content);
		
			if ($this->msg == "毕业季") {
				return true;
			}
		} else if ($recvObj->msgType == "event" 
			&& $recvObj->event == "CLICK"){
				if($recvObj->eventKey=="毕业季"){
					return true;
				}
		}
		
		return false;
	}
	function handle(){
		$return_arr = array (
			array (
					"【毕业季互动】“那道源自于你的光芒”——主题照片征集",
					"快快挖掘下大学时光里那些你坚持做过的让你最有成就，最值得骄傲，亦或是最让人感动的事情，把他们拍成照片留做印记！都教授同款天文望远镜、“铁三角”头戴耳机、阿迪达斯2014巴西世界杯官方用球大奖等你来拿！",	"http://tjuxinmeiti.tju.edu.cn/pages/images/byj.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=201728416&idx=1&sn=0bacc0b35f5b16d108d2b0e513e6c042#rd" 
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