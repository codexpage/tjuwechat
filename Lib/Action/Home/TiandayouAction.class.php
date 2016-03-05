<?php

class TiandayouAction extends BaseAction {
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");

		if ($recvObj->msgType == "text"){
			$this->msg = str_replace($qian, $hou, $recvObj->content);
		
			if ($this->msg == "一日游") {
				return true;
			}
		} else if ($recvObj->msgType == "event" 
			&& $recvObj->event == "CLICK" && $recvObj->eventKey == "一日游"){
			return true;
		}
		
		return false;
	}
	function handle(){
		$return_arr = array (
			array (
					"团团陪你游天大——文化篇",
					"",	"http://tjuxinmeiti.tju.edu.cn/Public/Images/action/tiandayou/1.jpg",	"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=202856883&idx=1&sn=743db6a5a28583b06b9a307c233a4923#rd" 
			),
			array (
					"团团陪你游天大——建筑篇",
					"",	"http://tjuxinmeiti.tju.edu.cn/Public/Images/action/tiandayou/2.jpg",	"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=202856883&idx=2&sn=386566f02f3f6f8ebc2f0507fb823245#rd" 
			),
			array (
					"团团陪你游天大——风景篇",
					"",	"http://tjuxinmeiti.tju.edu.cn/Public/Images/action/tiandayou/3.jpg",	"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=202856883&idx=3&sn=c366270ea1bb7af4bdd9afe9edf21454#rd" 
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