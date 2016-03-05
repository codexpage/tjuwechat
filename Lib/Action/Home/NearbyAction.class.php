<?php

class NearbyAction extends BaseAction{
	
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian=array(" ","　","\t","\n","\r");
		$hou=array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		
		$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );//截取前两个字
		
		if ($str1 == '附近') {
			return true;
		}
		return false;
	}

	function handle(){
		$str_key = str_replace('附近', "", $this->msg);
		if (empty($str_key))
        {
            $contentStr = "想看附近的景点？请输入附近+内容，如附近 肯德基~";
            return parent::getTextXml($contentStr);
        }

        $User = M('User');
		$u = $User->where("openid='%s'", $this->recvObj->fromUserName)->find();

		if (is_null($u) || $u == false || $u["position_x"] == null|| $u["position_y"] == null){
			$contentStr = "无法获取您的位置，尝试发送位置给我瞧瞧？";
			return parent::getTextXml($contentStr);
		} else {
			$position_x = $u["position_x"];
			$position_y = $u["position_y"];
			// 地址解析使用百度地图API的链接
			$map_api_url = "http://api.map.baidu.com/geocoder?";
			// 坐标
			$map_coord_type = "&coord_type=wgs84";

			// 抓取百度地址解析
			$geocoder = file_get_contents ( $map_api_url . $map_coord_type . "&location=" . $position_x . "," . $position_y );

				// 匹配出城市
				preg_match_all ( "/\<formatted_address\>(.*?)\<\/formatted_address\>/", $geocoder, $city );


			$return_arr = $this->search_nearby($str_key, $position_x, $position_y);
			if ($return_arr == "附近没有找到" . $str_key)
			{
				return parent::getTextXml($return_arr . "或者重新发送位置试试~");
			}

			$contentStr .= "<item>\n
				<Title><![CDATA[您的位置:" . $city[1][0] . "]]></Title>\n
				<Description><![CDATA[]]></Description>\n
				<PicUrl><![CDATA[]]></PicUrl>\n
				<Url><![CDATA[]]></Url>\n
				</item>\n";
			//数组循环转化
			foreach ( $return_arr as $value ) {
				$contentStr .= "<item>\n
				<Title><![CDATA[" . $value->Title . "]]></Title>\n
				<Description><![CDATA[]]></Description>\n
				<PicUrl><![CDATA[" . $value->PicUrl . "]]></PicUrl>\n
				<Url><![CDATA[" . $value->Url . "]]></Url>\n
				</item>\n";
			}
            
			$contentStr .= "<item>\n
				<Title><![CDATA[位置不精确？再给我看看位置呗~]]></Title>\n
				<Description><![CDATA[]]></Description>\n
				<PicUrl><![CDATA[]]></PicUrl>\n
				<Url><![CDATA[]]></Url>\n
				</item>\n";
			$count  =  count($return_arr) + 2;
			return parent::getNewsXml($count, $contentStr);
        }	
	}

	//调用api
	function search_nearby($value, $x, $y) {
		$appkey = "%E8%8B%8F%E7%95%85Thug4Life";
		$url = "http://api100.duapp.com/map/?appkey=" . $appkey . "&lat=".  $x . "&lng=" . $y . "&entity=" . $value;
		$json = file_get_contents ( $url );
		$text = json_decode ( $json );
		return $text;
	}
}

?>