<?php

class BaikeAction extends BaseAction{
	
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		
		$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );//截取前两个字
		
		if ($str1 == '百科') {
			return true;
		}
		return false;
	}
	function handle(){
        $str_key = str_replace('百科', "", $this->msg);
        if (empty($str_key))
        {
            $contentStr = "百科什么啊？对我大声说百科+内容，如百科微信~";
            return parent::getTextXml($contentStr);
        }
		$data = $this->search ($str_key);
		if ( empty ( $data )) {
            $contentStr = "404 \n Not Found";	
            return parent::getTextXml($contentStr);
		} else {
            if ( stripos($data, "Title") !== false )
            {
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
            }else{
				$contentStr = $data;
                return parent::getTextXml($contentStr);
            }
		}
		
		
	}

	private function search($word) {
		$str = "%E8%8B%8F%E7%95%85Thug4Life";
		$json = file_get_contents ( "http://api100.duapp.com/encyclopedia/?appkey=" . $str . "&word=" . $word );
		return $json;
	}
}

?>