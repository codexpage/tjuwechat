<?php
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
	//{"base_resp":{"ret":0,"err_msg":"ok"},"redirect_url":"\/cgi-bin\/home?t=home\/index&lang=zh_CN&token=42321501"}
	//preg_match('/\/cgi-bin\/home\?t=home\/index&lang=zh_CN&token=(\d+)\"/', $result, $ptoken);
	preg_match('/token=(\d+)\"/', $result, $ptoken);
	
	$token = $ptoken[1];
	$cookie = "";
	foreach ($header_cookies[1] as $header_cookie){
		$m = explode("=", $header_cookie);
		setcookie($m[0], $m[1]);
		if ($cookie == "")
			$cookie = $header_cookie;
		else
			$cookie = $cookie . "; " . $header_cookie;
	}
	
	return array("cookie"=>$cookie, "token"=>$token);
}

function getTextMessageFromWc(){
	$r = login();
	$token = $r['token'];
	$cookie = $r['cookie'];
	$url = "https://mp.weixin.qq.com/cgi-bin/message?t=message/list&count=20&day=7&token={$token}&lang=zh_CN";
	//$keyword = urlencode($content);
	//$url = "https://mp.weixin.qq.com/cgi-bin/message?t=message/list&action=search&keyword={$keyword}&count=20&token={$token}&lang=zh_CN";

	$result = sendGetHttps($url, $cookie);
	
	preg_match('/\(\{\"msg_item\":(.*?)\}\)\.msg_item/', $result, $mchs);

	$json = json_decode($mchs[1]);
	//如果是文本，则$json包含的域为：{"id":xx,"type":1,"fakeid":"xx","nick_name":"xx","date_time":xx,"content":"xx","source":"","msg_status":4,"has_reply":0,"refuse_reason":""}
	//如果是图片，则$json包含的域为：{"id":xx,"type":2,"fakeid":"xx","nick_name":"xx","date_time":xx,"source":"","msg_status":4,"has_reply":0,"refuse_reason":""}

	return array("cookie"=>$cookie, "token"=>$token, "json"=>$json);
}
?>