<?php

class ChengyuAction extends BaseAction{
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		
		$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );//截取前两个字
		
		if ($str1 == "成语") {
			return true;
		}
		return false;
	}
	function handle(){
        $str_key = str_replace('成语', "", $this->msg);
        if (empty($str_key))
        {
            $contentStr = "想查成语词典？对我大声说成语+内容，如成语 千言万语~";
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

	private function search($word) {
		$str = "%E8%8B%8F%E7%95%85Thug4Life";
		$json = file_get_contents ( "http://api100.duapp.com/idiom/?appkey=" . $str . "&word=" . $word );
		return $json;
	}
}
?>