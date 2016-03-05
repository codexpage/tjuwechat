<?php

class VoteAction extends BaseAction{
	
	private $msg;
	private $token;
	private $cookie;
	private $query = false;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		
		$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );//截取前两个字
		$str2 = mb_substr ( $this->msg, 0, 1, "UTF-8" );
		
		if ($str1 == "投票") {
			$this->query = true;
			return true;
		} else if ($str2 == "t") {
			return true;
		}
		return false;
	}
	function handle(){
		$C = M("Competitor");
		/*if (strpos($this->msg, "投票查询") === 0){
			$key = str_replace('投票查询', "", $this->msg);
        	$key = trim($key);
			preg_match("/(\d)号/", $key, $res);
			$contentStr = "";
			if (count($res) == 2){
				$cs = $C->where("code='%d'", $res[1])->find();echo $cs['name'];
				$contentStr = sprintf("%4s %5s %6s\n", $cs['code']."号", $cs['name'], $cs['poll']."票");
				echo sprintf("%4s %5s %6s\n", $cs['code']."号", $cs['name'], $cs['poll']."票");
			} else {
				$cs = $C->order("poll desc")->select();
				foreach ($cs as $k=>$v) {
					$contentStr = $contentStr.sprintf("第%d名：%4s %5s %6s\n", $k+1, $v['code']."号", $v['name'], $v['poll']."票");
				}
			}
			$contentStr = $contentStr."谢谢您的支持！";
			return parent::getTextXml($contentStr);
		}*/
		if ($this->query) {
			$cs = $C->order("code")->select();
			foreach ($cs as $k=>$v) {
				$contentStr = $contentStr.sprintf("%4s %5s\n", $v['code']."号", $v['name']);
			}
			$contentStr = $contentStr."请输入“t+选手号”，如“t01”进行投票。每个微信ID只能为一名候选人投票。";
			return parent::getTextXml($contentStr);
		}
        $key = str_replace('t', "", $this->msg);
        $key = trim($key);
        //preg_match('/(\d+)号*/', $this->msg, $result);
        //if (count($result) == 0){
        //	$cs = $C->order("code")->select();
		//	foreach ($cs as $k=>$v) {
		//		$contentStr = $contentStr.sprintf("%4s %5s\n", $v['code']."号", $v['name']);
		//	}
		//	$contentStr = $contentStr."请输入投票+选手号，如“投票 1号”进行投票";
		//	return parent::getTextXml($contentStr);
        //}
        //$code = $result[1];
        $User = M('User');
		$u = $User->where("openid='%s'", $this->recvObj->fromUserName)->find();
		if (is_null($u) || $u == false){
			load("@.login");
			$r = getTextMessageFromWc();
			$json = $r['json'];
			$token = $r['token'];
			$cookie = $r['cookie'];

			foreach ($json as $k=>$v){
				if ($v->type != 1)	//不是文本
					continue;
				if (abs($v->date_time, $this->recvObj->createTime) < 3 &&
						$v->content == $this->recvObj->content){
					$url = "https://mp.weixin.qq.com/misc/getheadimg?token={$token}&fakeid={$v->fakeid}";
					load("@.file");
					download($url, $cookie, $_SERVER['DOCUMENT_ROOT'] . "/Public/Avatars/{$v->fakeid}.jpg");

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

		$u = $User->find($u['id']);
		if (!is_null($u) && $u != false){
			if ($u['vote'] <= 0){
				$contentStr = "对不起，您已经投过票了！";
				return parent::getTextXml($contentStr);
			}
			
			$r = $C->where("code='%s'", $key)->setInc('poll');
			if ($r == 0) {
				$contentStr = "对不起，您输入的候选人不存在！请发送“投票”查看详情。";
				return parent::getTextXml($contentStr);
			} else {
				$com = $C->where("code='%s'", $key)->find();
				$res = $User->where("id='%d'", $u['id'])->setDec('vote');
				$contentStr = "为 ".str_replace(array(" ","　","\t"), array("","",""), $com['name'])." 投票成功，谢谢你的支持！";
				return parent::getTextXml($contentStr);
			}
		}
	}
}

?>