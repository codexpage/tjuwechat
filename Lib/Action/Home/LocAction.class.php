<?php

class LocAction extends BaseAction{
	
	private $Loc_X;
	private $Loc_Y;
	private $Scale;
	private $Lable;
    private $token;
    private $cookie;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		
		if ($recvObj->msgType == "location") {
			$this->Loc_X = $recvObj->locationX;
			$this->Loc_Y = $recvObj->locationY;
			$this->Scale = $recvObj->scale;
			$this->Lable = $recvObj->label;
			return true;
		}
		return false;
	}
    
	function handle(){
		$User = M('User');
		$u = $User->where("openid='%s'", $this->recvObj->fromUserName)->find();
		$status = 0;

		if (is_null($u) || $u == false){
			$json = $this->login();
		
			foreach ($json as $k=>$v){
				if ($v->type != 1)	//不是文本
					continue;

				if ($v->date_time == $this->recvObj->createTime){
					$url = "https://mp.weixin.qq.com/cgi-bin/getheadimg?token={$this->token}&fakeid={$v->fakeid}";
					load("@.file");
					download($url, $this->cookie, $_SERVER['DOCUMENT_ROOT'] . "/Public/Avatars/{$v->fakeid}.jpg");

					$u = array();
					$u['openid'] = $this->recvObj->fromUserName;
					$u['fakeid'] = $v->fakeid;
					$u['nickname'] = $v->nick_name;
					$u['lasttime'] = $v->date_time;
					$u['position_x'] = $this->Loc_X;
					$u['position_y'] = $this->Loc_Y;
					$u['id'] = $User->add($u);
					break;
				}
			}
		} else {
			$u['position_x'] = $this->Loc_X;
			$u['position_y'] = $this->Loc_Y;
			$u['lasttime'] = $this->recvObj->createTime;
			$User->save($u);

		}
        
        // 地址解析使用百度地图API的链接
		$map_api_url = "http://api.map.baidu.com/geocoder?";
		// 坐标
		$map_coord_type = "&coord_type=wgs84";

		// 抓取百度地址解析
		$geocoder = file_get_contents( $map_api_url . $map_coord_type . "&location=" . $this->Loc_X . "," . $this->Loc_Y );
		// 如果抓取地址解析成功

		preg_match_all ( "/\<formatted_address\>(.*?)\<\/formatted_address\>/", $geocoder, $city );
        
		$contentStr = "已记录您的位置信息~\n您当前位置为：".$city[1][0]."\n想查询附近的景点或基础设施？请输入附近+内容，如附近 快餐or火锅or快捷酒店orKTV~";
		return parent::getTextXml($contentStr);
		
	}

	function login(){
		$username = C('WXMP_USERNAME');
		$password = C('WXMP_PASSWORD');
		
		$wx_pwd = md5($password);
		
		$url = "https://mp.weixin.qq.com/cgi-bin/login?lang=zh_CN";
		$postData = "username={$username}&pwd={$wx_pwd}&imgcode=&f=json";
		//必须指定referer头，否则会返回错误码-2，即用户名密码错误
		$referer = "https://mp.weixin.qq.com/";
		
		$result = sendPostHttps($url, $postData, 1, $referer);
		
		preg_match_all('/Set-Cookie: (.*?);/', $result, $header_cookies);
		preg_match('/\/cgi-bin\/home\?t=home\/index&lang=zh_CN&token=(\d+)\"/', $result, $ptoken);
		
		$this->token = $ptoken[1];
		$cookie = "";
		foreach ($header_cookies[1] as $header_cookie){
			$m = explode("=", $header_cookie);
			setcookie($m[0], $m[1]);
			if ($cookie == "")
				$cookie = $header_cookie;
			else
				$cookie = $cookie . "; " . $header_cookie;
		}
		
		$url = "https://mp.weixin.qq.com/cgi-bin/message?t=message/list&count=10&day=7&token={$this->token}&lang=zh_CN";
		$result = sendGetHttps($url, $cookie);
		$this->cookie = $cookie;
		
		preg_match('/\(\{\"msg_item\":(.*?)\}\)\.msg_item/', $result, $mchs);

		$json = json_decode($mchs[1]);
		//如果是文本，则$json包含的域为：{"id":xx,"type":1,"fakeid":"xx","nick_name":"xx","date_time":xx,"content":"xx","source":"","msg_status":4,"has_reply":0,"refuse_reason":""}
		//如果是图片，则$json包含的域为：{"id":xx,"type":2,"fakeid":"xx","nick_name":"xx","date_time":xx,"source":"","msg_status":4,"has_reply":0,"refuse_reason":""}

		return $json;
	}
}

?>