<?php

class ImgrecgAction extends BaseAction {
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		if ($recvObj->msgType == "image"){
			return true;
		}
		return false;
	}
	
	function handle(){
		
        $data = $this->img_recg();
        $face = $data->face;
        if (count($face) == 0) {
			$contentStr = "完了，老眼昏花啦，没检测出来人脸~";
			return parent::getTextXml($contentStr);
		} else {
			$img_data = $face;
			$contentStr = "<item>\n
                <Title><![CDATA[【人脸识别结果】]]></Title>\n
				<Description><![CDATA[]]></Description>\n
				<PicUrl><![CDATA[]]></PicUrl>\n  
				<Url><![CDATA[]]></Url>\n
				</item>\n";

                            //数组循环转化
			foreach ( $img_data as $val ) {
				$value = $val->attribute;
				$gender = "";
				if ($value->gender->value=="Female") {
					$gender = "女";
				} else {
					$gender = "男";
				}

                                $smiling = $value->smiling->value;
                                $english_format_number = number_format($smiling, 2, '.', '');
                             

				$contentStr .= "<item>\n
				<Title><![CDATA[性别:" . $gender . "\n年龄:" . $value->age->value . "\n种族:" . $value->race->value . "\n微笑程度:" . $english_format_number ."]]></Title>\n
				<Description><![CDATA[]]></Description>\n
				<PicUrl><![CDATA[" . $data->url . "]]></PicUrl>\n
				<Url><![CDATA[]]></Url>\n
				</item>\n";
			}
  
            $count = count($img_data) + 1;
            return parent::getNewsXml($count, $contentStr);
        }
	}               

	function img_recg() {
		
		$api_key = "9cfddf4923ca813bbf1feb2d709cfe7a";
        $api_secret="xrWx0_lnKOqbNMvqKQvH4gpfRASrvBjl";
        $attribute="glass,pose,gender,age,race,smiling";
		$json =  file_get_contents(
			"http://apicn.faceplusplus.com/v2/detection/detect?api_key=9cfddf4923ca813bbf1feb2d709cfe7a&api_secret=xrWx0_lnKOqbNMvqKQvH4gpfRASrvBjl&url={$this->recvObj->picUrl}&attribute=glass,pose,gender,age,race,smiling");
		return  json_decode($json);
		
	}
}








