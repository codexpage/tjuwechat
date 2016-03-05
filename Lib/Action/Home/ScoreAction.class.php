<?php

class ScoreAction extends BaseAction{
	
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);

		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		
		$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );//截取前两个字
		
		if ($str1 == '分数') {
			return true;
		}
		return false;
	}

	function handle(){
        
		$url = "http://markrui.sinaapp.com/wechat/phonepages/score/logon.html";
        return parent::getTextXml("数据来自办公网，猛戳进入~\n" . "<a href='$url'>点击此处进行查询</a>");
	}
}
?>