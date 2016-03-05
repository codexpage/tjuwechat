<?php

class CxcyAction extends BaseAction {
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");

		if ($recvObj->msgType == "text"){
			$this->msg = str_replace($qian, $hou, $recvObj->content);
		
			if ($this->msg == "创新创业") {
				return true;
			}
		} else if ($recvObj->msgType == "event" 
			&& $recvObj->event == "CLICK" && $recvObj->eventKey == "创新创业"){
			return true;
		}
		
		return false;
	}
	function handle(){
		$return_arr = array (
			array (
					"【创新创业】香水改变人生，创业成就梦想—侠倩科技创业团队",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/cxcy.png",			
					"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=201835544&idx=2&sn=8b195e24a085e68e5ab27defd80cfa42#rd" 
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