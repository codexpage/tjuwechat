<?php

/*
 * time参数为年（4位数），月（两位数），日（两位数）
 * 三个参数之间可以用'-'，'.'等任意字符链接，
 * 主要在差自习室的功能中使用，根据输入的年月日获取时间戳
 */
function getTimeStamp($time){
	$year=((int)substr($time, 0, 4));//取得年份
	$month=((int)substr($time, 5, 2));//取得月份
	$day=((int)substr($time, 8, 2));//取得几号
	return mktime(0, 0, 0, $month, $day, $year);
}

function gettime($timestamp){
	return date("Y-m-d H:i:s", $timestamp);
}

/*
 * 发送Post请求，返回请求结果
 * @url 发送post请求的目标url
 * @postData post请求携带的数据，a=1&b=2的形式
 * @header 是否返回header信息，若需要获取Cookie，则需要置为1
 * @referer 设置请求的referer头，微信做了判断，如果不设置referer，模拟登陆不会成功
 */
function sendPost($url, $postData, $header=0, $referer="", $cookie=""){
	$ch = curl_init () ;

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url) ;
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
	curl_setopt($ch, CURLOPT_REFERER, $referer);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	$result = curl_exec($ch);
	curl_close($ch);

	return $result;
}

/*
 * 发送Get请求，返回请求结果
 * @url 发送get请求的目标url
 * @cookie 之前设置的cookie一起发送，判断登录用的key就在cookie中
 */
function sendGet($url, $cookie=""){
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	$result = curl_exec($ch);
	curl_close($ch);

	return $result;
}

function sendPostHttps($url, $postData, $header=0, $referer="", $cookie=""){
	$ch = curl_init () ;

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url) ;
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
	curl_setopt($ch, CURLOPT_REFERER, $referer);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
	curl_setopt($ch, CURLOPT_SSLVERSION, 3);
	$result = curl_exec($ch);
	curl_close($ch);

	return $result;
}

function sendGetHttps($url, $cookie=""){
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
	curl_setopt($ch, CURLOPT_SSLVERSION, 3);
	$result = curl_exec($ch);
	curl_close($ch);

	return $result;
}

/**
 * 根据用户名获取用户信息
 */
function getAccessToken(){
	$app_id = C('APP_ID');
	$secret = C('APP_SECRET');
	$token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$app_id}&secret={$secret}";

	$result = json_decode(sendGetHttps($token_url));
	return $result->access_token;
}
?>