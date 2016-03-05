﻿<?php

class CaipuAction extends BaseAction{
	
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		
		$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );//截取前两个字
		
		if ($str1 == "菜谱") {
			return true;
		}
		return false;
	}
	function handle(){
        $str_key = str_replace('菜谱', "", $this->msg);
        if (empty($str_key))
        {
            $contentStr = "想查菜谱？对我大声说菜谱+菜名，如菜谱 剁椒鱼头~";
            return parent::getTextXml($contentStr);
        }
		$data = $this->search ($str_key);
		if (stripos($data, "Title") !== false) {
            $count = substr_count($data, "Title");
            $return_arr = json_decode($data);
			
			//数组循环转化
			foreach ( $return_arr as $value ) {
				$contentStr .= "<item>\n
				<Title><![CDATA[" . $value->Title . "]]></Title>\n
				<Description><![CDATA[]]></Description>\n
				<PicUrl><![CDATA[" . $value->PicUrl . "]]></PicUrl>\n
				<Url><![CDATA[" . $value->Url . "]]></Url>\n
				</item>\n";
			}
                if ($count > 10)
                    $count = 10;
			return parent::getNewsXml($count, $contentStr);
		} else {
			$contentStr = "404 \n Not Found";
            return parent::getTextXml($contentStr);
		}	
	}

	private function search($name) {
		$str = "%E8%8B%8F%E7%95%85Thug4Life";
		$json = file_get_contents ( "http://api100.duapp.com/recipe/?appkey=" . $str . "&name=" . $name );
		return $json;
	}
}
?>