<?php

class MenuAction extends Action {
	function create(){
		$data = $this->_param('data');
		$data = str_replace("&amp;quot;", "\"", $data);
		$token = getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$token}";
		$result = sendPostHttps($url, $data, 0, "");
		echo $result;
	}

	function delete(){
		$data = $this->_param('data');
		$token = getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$token}";
		$result = sendPostHttps($url, $data);
		$json = json_decode($result);
		echo $json->errcode;
	}
}