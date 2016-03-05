<?php

class HistoryAction extends BaseAction {
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");

		if ($recvObj->msgType == "text"){
			$this->msg = str_replace($qian, $hou, $recvObj->content);
		
			if ($this->msg == "校史沿革") {
				return true;
			}
		} else if ($recvObj->msgType == "event" 
			&& $recvObj->event == "CLICK" && $recvObj->eventKey == "校史沿革"){
			return true;
		}
		
		return false;
	}
	function handle(){
		$return_arr = array (
			array (
					"【北洋概况】天津大学简介",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/History/0.jpeg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200093467&idx=1&sn=df6bd792c9b755296db834aeb50f84ae#rd" 
			),
			array (
					"【校史沿革】肇基学府 洋洋大风（初创时期）",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/History/1.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200093713&idx=1&sn=e2598a76782dd47c5c0a43acfddf0ca9#rd" 
			),
			array (
					"【校史沿革】筚路蓝缕 穷理振工（专办工科时期）",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/History/2.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200093713&idx=2&sn=fb92d6c10b3989158353194a105b071a#rd" 
			),
			array (
					"【校史沿革】三工连理 薪火相承（抗战时期）",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/History/3.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200093713&idx=3&sn=68228ca58f14d2c1e775b49180865c5d#rd" 
			),
			array (
					"【校史沿革】百川归海 西沽重兴（理工结合时期）",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/History/4.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200093713&idx=4&sn=695efb0d0d2d90ceb7dd286a931c151f#rd" 
			),
			array (
					"【校史沿革】改天换地 北洋新生（建设多科性工业大学时期）",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/History/5.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200093713&idx=5&sn=0714759e72b9fe5dbb8540adef58c6ea#rd" 
			),
			array (
					"【校史沿革】锐意改革 日新月异（改革开放到百年校庆，新的发展时期）",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/History/6.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200093713&idx=6&sn=4ce1078eb6df14a2ddfd811e0a2d626f#rd" 
			),
			array (
					"【校史沿革】百年风华 再攀高峰（向综合性大学发展时期）",
					"",	"http://tjuxinmeiti.tju.edu.cn/pages/images/History/7.jpg",			"http://mp.weixin.qq.com/s?__biz=MjM5MDA4MTk0MA==&mid=200093713&idx=7&sn=3a8c270d413d00157ccf7b07e1aaa96e#rd" 
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