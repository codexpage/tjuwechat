<?php

class MsgWallAction extends BaseAction {

	private $activityName;
	private $msg;
	//private $token;
	//private $cookie;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);

		$this->msg = trim($recvObj->content);
		$this->msg = str_replace("＃", "#", $this->msg);
		preg_match('/^#(.*?)#/', $this->msg, $items);
		
		if (count($items) == 2){
			$this->activityName = trim($items[1]);
			$this->msg = trim(str_replace($items[0], "", $this->msg));
			return true;
		}
		return false;
	}

	function handle(){
		$params['name'] = $this->activityName;
		$a = M('Activity')->where($params)->find();

		if (is_null($a) || $a == false){
			$contentStr = "活动名有错误，仔细检查一下~";
			return parent::getTextXml($contentStr);
		}
		
		$User = M('User');
		$u = $User->where("openid='%s'", $this->recvObj->fromUserName)->find();
		if (!is_null($u) && $u['alike'] == 1) {
			$u = null;
			$User->delete($u['id']);
		}

		$status = ($a["towall"] == 1) ? 1 : 0;
		
		if (is_null($u) || $u == false){
			load("@.login");
			$r = getTextMessageFromWc();
			$json = $r['json'];
			$token = $r['token'];
			$cookie = $r['cookie'];
			
			foreach ($json as $k=>$v) {
				if ($v->type != 1)
					continue;
				if (abs($v->date_time, $this->recvObj->createTime) < 3 &&
						$v->content == $this->recvObj->content) {
					//$url = "https://mp.weixin.qq.com/cgi-bin/getheadimg?token={$token}&fakeid={$v->fakeid}";
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
					}
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
			$m['msgtype'] = 0;
			$m['content'] = $this->msg;
			$m['msgid'] = $this->recvObj->msgId;
			$m['activity'] = $a["id"];
			$m['addtime'] = $this->recvObj->createTime;
			$m['status'] = $status;
			$Message->add($m);
			// 获取抽奖资格
			$d['uid'] = $u['id'];
			$d['status'] = 1;
			M("Lottery")->add($d);
		}

		$contentStr = "发送成功";

		return parent::getTextXml($contentStr);
	}
	
}

?>