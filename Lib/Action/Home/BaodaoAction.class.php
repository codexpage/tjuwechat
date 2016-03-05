<?php

class BaodaoAction extends BaseAction {
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");

		if ($recvObj->msgType == "text"){
			$this->msg = str_replace($qian, $hou, $recvObj->content);
		
			if ($this->msg == "新生报到") {
				return true;
			}
		} else if ($recvObj->msgType == "event" 
			&& $recvObj->event == "CLICK" && $recvObj->eventKey == "新生报到"){
			return true;
		}
		
		return false;
	}
	function handle(){
		$return_arr = array (
			array (
					"报到第一击：向天大进发",
					"",	"http://tjuxinmeiti.tju.edu.cn/Public/Images/action/baodao/1.jpg",	"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=202845145&idx=1&sn=370f9ba5659cd463a131fc6582ed1e1d#rd" 
			),
			array (
					"报到第二击：报到很简单",
					"",	"http://tjuxinmeiti.tju.edu.cn/Public/Images/action/baodao/2.jpg",	"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=202845145&idx=2&sn=93c7196bf2fff8d2fec968cbeb76e598#rd" 
			),
			array (
					"报到第三击：入住那些事儿",
					"",	"http://tjuxinmeiti.tju.edu.cn/Public/Images/action/baodao/3.jpg",	"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=202845145&idx=3&sn=4dad7fb94e34e00e56a9d22140d5f5dd#rd" 
			),
			array (
					"报到第四击：生活全方略",
					"",	"http://tjuxinmeiti.tju.edu.cn/Public/Images/action/baodao/4.jpg",	"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=202845145&idx=4&sn=17822e11b6d2af418b10a27806ea2e96#rd" 
			),
			array (
					"报到第五击：手续办理导航",
					"",	"http://tjuxinmeiti.tju.edu.cn/Public/Images/action/baodao/5.jpg",	"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=202845145&idx=5&sn=3dee85d23d0eb162e7fd42db3873175c#rd" 
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