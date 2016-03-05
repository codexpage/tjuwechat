<?php

class ImageAction extends BaseAction {

	private $token;
	private $cookie;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		if ($recvObj->msgType == "image"){
			return true;
		}
		return false;
	}
	
	function handle(){
		$User = M('User');
		$u = $User->where("openid='%s'", $this->recvObj->fromUserName)->find();

		$status = 1;
		if (is_null($u) || $u == false){
			$json = $this->login_and_get_images();

			foreach ($json as $k=>$v){
				if ($v->type != 2)	//不是图片
					continue;
				
				if (abs($v->date_time, $this->recvObj->createTime) < 3){
					$url = "https://mp.weixin.qq.com/misc/getheadimg?token={$this->token}&fakeid={$v->fakeid}";
					load("@.file");
					download($url, $this->cookie, $_SERVER['DOCUMENT_ROOT'] . "/Public/Avatars/{$v->fakeid}.jpg");

					$u = array();
					$u['openid'] = $this->recvObj->fromUserName;
					$u['fakeid'] = $v->fakeid;
					$u['nickname'] = $v->nick_name;
					$u['lasttime'] = $v->date_time;
					$u['id'] = $User->add($u);
					break;
				}
			}
		} else {
			$u['lasttime'] = $this->recvObj->createTime;
			$User->save($u);
		}
		
		if (!is_null($u) && $u != false){
			$Message = M('Message');
			$m['uid'] = $u['id'];
			$m['msgtype'] = 1;
			$m['content'] = $this->recvObj->picUrl;
			$m['msgid'] = $this->recvObj->msgId;
			$m['activity'] = 0;
			$m['addtime'] = $this->recvObj->createTime;
			$m['status'] = $status;
			$Message->add($m);
		}

		$contentStr = "保存图片成功";
		return parent::getTextXml($contentStr);
	}

	function login_and_get_images(){
		load("@.login");
		$login_result = login();
		$this->token = $login_result['token'];
		$this->cookie = $login_result['cookie'];
		$url = "https://mp.weixin.qq.com/cgi-bin/message?t=message/list&count=10&day=7&token={$this->token}&lang=zh_CN";
		$result = sendGetHttps($url, $this->cookie);
		
		preg_match('/\(\{\"msg_item\":(.*?)\}\)\.msg_item/', $result, $mchs);

		$json = json_decode($mchs[1]);
		//如果是文本，则$json包含的域为：{"id":xx,"type":1,"fakeid":"xx","nick_name":"xx","date_time":xx,"content":"xx","source":"","msg_status":4,"has_reply":0,"refuse_reason":""}
		//如果是图片，则$json包含的域为：{"id":xx,"type":2,"fakeid":"xx","nick_name":"xx","date_time":xx,"source":"","msg_status":4,"has_reply":0,"refuse_reason":""}

		return $json;
	}
}

?>