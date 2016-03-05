<?php



class UserAction extends Action {

	private $token;

	private $cookie;

	function update_avatar(){

		load("@.file");

		$dir = $_SERVER['DOCUMENT_ROOT'] . "/Public/Avatars/";

		//clear_dir($dir);

		$U = M("User");

		$users = $U->select();

		$count = 0;

		load("@.login");

		$r = login();

		$this->token = $r['token'];

		$this->cookie = $r['cookie'];

		//foreach ($users as $k=>$v){
		for($i = 2720; $i <count($users);$i++){
			$count++;

			$url = "https://mp.weixin.qq.com/misc/getheadimg?token={$this->token}&fakeid=".$users[$i]['fakeid'];

			download($url, $this->cookie, $dir . $users[$i]['fakeid'].".jpg");

		}

		echo $count;

	}



	function update_avatar_not_exist(){

		load("@.file");

		$dir = $_SERVER['DOCUMENT_ROOT'] . "/Public/Avatars/";

		$U = M("User");

		$users = $U->select();

		$count = 0;

		load("@.login");

		$r = login();

		$this->token = $r['token'];

		$this->cookie = $r['cookie'];

		foreach ($users as $k=>$v){

			$imgname = $dir . "{$v['fakeid']}.jpg";

			if (!file_exists($imgname)){

				$count++;

				$url = "https://mp.weixin.qq.com/misc/getheadimg?token={$this->token}&fakeid={$v['fakeid']}";

				download($url, $this->cookie, $imgname);

			}

		}

		$error = find_empty($dir);

		$default = $_SERVER['DOCUMENT_ROOT'] . "/Public/default.jpg";

		foreach ($error as $k=>$v){

			$count++;

			$imgname = $dir . "{$v}";

			$fakeid=str_replace(".jpg", "", $v);

			$url = "https://mp.weixin.qq.com/misc/getheadimg?token={$this->token}&fakeid={$fakeid}";

			download($url, $this->cookie, $imgname);



      		if (filesize($imgname) <= 0){

	      		copy($default, $imgname);

	      	}

		}

		echo $count;

	}



	function update_nickname(){

		set_time_limit(0);

		$U = M("User");

		$users = $U->select();

		$count = 0;

		load("@.login");

		$r = login();

		$this->token = $r['token'];

		$this->cookie = $r['cookie'];

		

		//取出总人�?
		//load("@.common");

		$url = "https://mp.weixin.qq.com/cgi-bin/contactmanage?t=user/index&pagesize=10&pageidx=0&type=0&token=345356558&lang=zh_CN";

		$result = sendGetHttps($url, $this->cookie);

		preg_match('/\(\{\"groups\":(.*?)\}\)\.groups/', $result, $mchs);

		$json = json_decode($mchs[1]);

		foreach ($json as $k => $v) {

			//计算总人�?
			$count += $v->cnt;

		}
		$c = 0;
		for ($i=7; $i < $count/500 + 1; $i++) { 

			$url = "https://mp.weixin.qq.com/cgi-bin/contactmanage?t=user/index&pagesize=500&pageidx=$i&type=0&token=345356558&lang=zh_CN";

			$result = sendGetHttps($url, $this->cookie);

			preg_match('/\(\{\"contacts\":(.*?)\}\)\.contacts/', $result, $mchs);

			$json = json_decode($mchs[1]);

			//更新数据�?
			foreach ($json as $k => $v) {

				$u["nickname"] = $v->nick_name;

				$U->where("fakeid=".$v->id)->save($u);
				$c++;
			}

		}

		

		echo $c;

	}



	function login(){

		$username = C('WXMP_USERNAME');

		$password = C('WXMP_PASSWORD');

		

		$wx_pwd = md5($password);

		

		$url = "https://mp.weixin.qq.com/cgi-bin/login?lang=zh_CN";

		$postData = "username={$username}&pwd={$wx_pwd}&imgcode=&f=json";

		//必须指定referer头，否则会返回错误码-2，即用户名密码错�?
		$referer = "https://mp.weixin.qq.com/";

		

		$result = sendPost($url, $postData, 1, $referer);

		

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

		

		$this->cookie = $cookie;

	}

}