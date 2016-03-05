<?php

class OrgAction extends BaseAction {
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");

		if ($recvObj->msgType == "text"){
			$this->msg = str_replace($qian, $hou, $recvObj->content);
		
			if ($this->msg == "社团简介") {
				return true;
			}
		} else if ($recvObj->msgType == "event" 
			&& $recvObj->event == "CLICK" && $recvObj->eventKey == "社团简介"){
			return true;
		}
		return false;
	}
	function handle(){
		$return_arr = array (
			array (
					"【社团简介】天津大学学生会",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/Org/1.png",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200104031&idx=1&sn=a917c7e16f6671048ba5bc86d2cacdc7#rd" 
			),
			array (
					"【社团简介】天津大学学生科技协会",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/Org/2.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200104031&idx=2&sn=bad0d42cbb7a745f24ed28ad012d4ae7#rd" 
			),
			array (
					"【社团简介】天津大学北洋艺术团",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/Org/3.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200104031&idx=3&sn=326ac34e384e9ee526cba58d8cbbdd0d#rd" 
			),
			array (
					"【社团简介】天津大学青年文化促进会",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/Org/4.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200104031&idx=4&sn=b15008f1be96a89978e996d50db29b77#rd" 
			),
			array (
					"【社团简介】天津大学学生社团团委",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/Org/5.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200104031&idx=5&sn=72e00b2f95844e10fe5098311ab88f80#rd" 
			),
			array (
					"【社团简介】天津大学求实团校",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/Org/6.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200104031&idx=6&sn=b3fed63a37297f3b7c94ddbda334095b#rd" 
			),
			array (
					"【社团简介】天津大学青年志愿者协会",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/Org/7.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200104031&idx=7&sn=369aea6dee3d1025d9bdd2c1179035fd#rd" 
			),
			array (
					"【社团简介】天津大学社团联合会",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/Org/8.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200104031&idx=8&sn=e378085a3c4a76cfccdf2b497e5690f4#rd" 
			)
,
			array (
					"【社团简介】天津大学团委新青年新媒体中心",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/Org/9.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=203055546&idx=1&sn=0ee10eb2611f1c697fe42969d48acc05#rd" 
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