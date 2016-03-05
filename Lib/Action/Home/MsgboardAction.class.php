<?php

class MsgboardAction extends BaseAction {

	private $activityName;
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		$User = M('User');
		$u = $User->where("openid='%s'", $this->recvObj->fromUserName)->find();
		if (!is_null($u) && $u['alike'] == 1) {
			$u = null;
			$User->delete($u['id']);
		}
		
		if (is_null($u) || $u == false){
			load("@.login");
			$r = getTextMessageFromWc();
			$json = $r['json'];
			$token = $r['token'];
			$cookie = $r['cookie'];
			//$this->msg = json_encode($json[0])." ".$this->recvObj->createTime;
			//$json = $this->login();
			foreach ($json as $k=>$v){
				if ($v->type != 1)	//不是文本
					continue;
				if ($v->content == $this->recvObj->content && 
						abs($v->date_time, $this->recvObj->createTime) < 5) {
					$url = "https://mp.weixin.qq.com/misc/getheadimg?token={$token}&fakeid={$v->fakeid}";
					load("@.file");
					download($url, $cookie, $_SERVER['DOCUMENT_ROOT'] . "/Public/Avatars/{$v->fakeid}.jpg");

					$u = array();
					$u['openid'] = $this->recvObj->fromUserName;
					$u['fakeid'] = $v->fakeid;
					$u['nickname'] = $v->nick_name;
					$u['lasttime'] = $v->date_time;
					if ($v->date_time != $this->recvObj->createTime){
						$u['alike'] = 1;
					} else {
						$u['alike'] = 0;
					}
					$u['id'] = $User->add($u);
					break;
				}
			}
		} else {
			$u['lasttime'] = $this->recvObj->createTime;
			$User->save($u);
		}

		$newu = $User->find($u['id']);
		if (!is_null($newu) && $newu != false){
			if ($newu['nickname'] != "苏畅"){
				return false;
			}
			$Message = M('Message');
			$m['uid'] = $u['id'];
			$m['msgtype'] = 0;
			$m['content'] = $this->recvObj->content;
			$m['msgid'] = $this->recvObj->msgId;
			$m['activity'] = 3;
			$m['addtime'] = $this->recvObj->createTime;
			$m['status'] = 5;
			$Message->add($m);
		}
		return true;
	}

	function handle(){
		$contentStr = "留言成功";
		return parent::getTextXml($contentStr);
	}

}

?>