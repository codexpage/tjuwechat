<?php

class NewsAction extends BaseAction {
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		
		if ($this->msg == "三行诗") {
			return true;
		}
		return false;
	}
	function handle(){
		$return_arr = array (
			array (
					"【互动专刊】“给2014的三行诗”征集大赛！猛戳有惊喜！",
					"小伙伴们，你的2013年有哪些美好或深刻的回忆？有哪些有趣或动人的故事？你对2014年有哪些期盼和设想？无论你是个满脑子跑代码却不解柔情的IT男，还是个外表女汉子内心小清新的工科女，相信你都是个热爱生活的好青年！",	"http://tjuxinmeiti.tju.edu.cn/pages/images/Background.jpg",			"http://mp.weixin.qq.com/mp/appmsg/show?__biz=MzA3NjEwNzQwNA==&appmsgid=10018169&itemidx=1&sign=7128f8c9dd2d4987a04ab634c5dd3f4d#wechat_redirect" 
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