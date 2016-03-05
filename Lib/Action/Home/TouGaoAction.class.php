<?php

class TouGaoAction extends BaseAction {

	private $msg;

	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		
		if ($recvObj->msgType == "text"){
			$this->msg = str_replace($qian, $hou, $recvObj->content);
		
			if ($this->msg == "投稿") {
				return true;
			}
		} else if ($recvObj->msgType == "event" 
			&& $recvObj->event == "CLICK" && $recvObj->eventKey == "投稿"){
			return true;
		}
		return false;
	}

	function handle(){
		$contentStr = "亲爱的同学们，团委微信平台现公开面向全校同学征集稿件，我们的内容板块有【最美天大】、【学术尖端】、【生活百科】、【艺术欣赏】等，如果你看到过什么好的文章；如果你身边有什么高大上的英雄事迹；如果你在校园里拍到过什么经典人物或风景照并希望与大家一起分享……那就快快发送给我们吧！稿件一经采用，就会有精美礼品一份等你拿哦！稿件请发送到：xinmeitisucai@126.com
来稿请以“投稿+标题+姓名”为题 （正文注明你的联系方式，稿件为附件）";
		return parent::getTextXml($contentStr);
	}

}

?>