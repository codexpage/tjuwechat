<?php

class XingzuoAction extends BaseAction{
	
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		
		$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );//截取前两个字
		
		if ($str1 == '星座') {
			return true;
		}
		return false;
	}
	function handle(){
        $str_key = str_replace('星座', "", $this->msg);
        if (empty($str_key))
        {
            $contentStr = "想要看星座运势？跟我一起说星座+星座名，如星座+天蝎座~";
            return parent::getTextXml($contentStr);
        }
		$data = $this->search ($str_key);
		if (! empty ( $data )) {
			$contentStr = $data;
		} else {
			$contentStr = "404 \n Not Found";
		}
		
		return parent::getTextXml($contentStr);
	}

	private function search($name) {
		$str = "%E8%8B%8F%E7%95%85Thug4Life";
		$json = file_get_contents ( "http://api100.duapp.com/astrology/?appkey=" . $str . "&name=" . $name);
		$text = json_decode ( $json );
		return $text;
	}
}
?>