<?php

class TransportAction extends BaseAction{
	
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		
		if ($recvObj->msgType == "text"){
			$this->msg = str_replace($qian, $hou, $recvObj->content);
		
			if ($this->msg == "交通") {
				return true;
			}
		} else if ($recvObj->msgType == "event" 
			&& $recvObj->event == "CLICK" && $recvObj->eventKey == "交通"){
			return true;
		}
		
		return false;
	}
	function handle(){
		$return_arr = array (
			array (
					"交通查询",
					"http://tjuxinmeiti.tju.edu.cn/pages/images/jiaotong.jpg",
					"" 
			),
			array (
					"公交查询",
					"http://tjuxinmeiti.tju.edu.cn/pages/images/bus.jpg",
					"http://zuoche.com/touch/" 
			),
			array (
					"地铁查询",
					"http://img.soufun.com/news/2012_03/22/news/1332397041241_000.jpg",
					"http://map.baidu.com/mobile/webapp/subway/show/foo=bar/" 
			),
			array (
					"火车查询",
					"http://www.dqzyxy.net/UploadFiles/dzbgs/2010/11/201011281345123306.jpg",
					"http://touch.qunar.com/h5/train/" 
			),
			array (
					"汽车查询",
					"http://www.cn357.com/upload/batchimg/org/232/2472dt.jpg",
					"http://mbaiduwebapp.trip8080.com/" 
			),
            array (
					"机票查询",
					"http://img.bendibao.com/beijing/201112/13/20111213115537293.JPG",
					"http://touch.qunar.com/h5/flight/" 
			),
            array (
					"酒店查询",
					"http://image2.sina.com.cn/dy/s/p/2007-05-29/U2240P1T1D13100569F21DT20070529092655.jpg",
					"http://touch.qunar.com/h5/hotel/" 
			),
             array (
					"实时路况",
					"http://upload.newhua.com/6/b0/1287019679640.jpg",
					"http://dp.sina.cn/dpool/tools/citytraffic/city.php" 
			)
			);
						
			//数组循环转化
			foreach ( $return_arr as $value ) {
				$contentStr .= "<item>\n
				<Title><![CDATA[" . $value [0] . "]]></Title>\n
				<Description><![CDATA[]]></Description>\n
				<PicUrl><![CDATA[" . $value [1] . "]]></PicUrl>\n
				<Url><![CDATA[" . $value [2] . "]]></Url>\n
				</item>\n";
			}
		$count  =  count($return_arr);
		return parent::getNewsXml($count, $contentStr);
	}
}
?>