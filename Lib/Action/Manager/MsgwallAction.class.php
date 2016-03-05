<?php



class MsgwallAction extends Action {



	//通过某人的昵称搜索这个人说的话

	function search(){

		$page = $this->param('page', 1);

		$rows = $this->param('rows', 10);



		$offset = ($page - 1) * $rows;



		$user = D('user');

		$nickname = $this->param("nickname", "nickname");

		$d["nickname"] = array("like", "%".$nickname."%");

		$d = $user->where($d)->select();



		$data = "";

		for ($i=0; $i < count($d); $i++) { 

			$data .= "uid = ".$d[$i]["id"];

			if($i != count($d)-1)

				$data .= " or ";

		}



		$Msg = D("Message");

        $result["total"] = $Msg->where($data)->count();

		$result["rows"] = $Msg->relation(true)->where($data)->limit($rows)->page($page)->select();



		if (is_null($result["rows"]))

			$result["rows"] = array();



		echo json_encode($result);

	}





	/**

	 * 获取信息墙相关信息，按状态查询, 后台管理界面用, 这名起得不大好……

	 */

	function walllist(){

		$page = $this->param('page', 1);

		$rows = $this->param('rows', 10);



		$offset = ($page - 1) * $rows;

		

		$status = $this->param('status', 1);

		$data["status"] = $status;

		$act = M("activity") -> where('towall=1') -> find();

		$data["activity"] = intval($act['id']);

		$Msg = D("Message");

		$result["total"] = $Msg->where($data)->count();



		$result["rows"] = $Msg->relation(true)->where($data)->limit($rows)->page($page)->order('addtime desc')->select();

		if (is_null($result["rows"]))

			$result["rows"] = array();


		echo json_encode($result);

	}



	/* 改变审核状态，后台管理用 */

	function changestatus(){

		$Msg = M("Message");

		$data['id'] = $this->param('id', 0);

		$status = $this->param('status', 1);

		$data['status'] = $status;

		$r = $Msg->save($data);

		//if ($status == 2){

			/*获取抽奖资格*/

		//	$message = $Msg->find($data['id']);

		//	$d['uid'] = $message['uid'];

		//	$d['status'] = 1;

		//	M("Lottery")->add($d);

		//}

		echo $r;

	}



	/* 删除消息，后台管理用 */

	function delete(){

		$Msg = M("Message");

		$data['id'] = $this->param('id', 0);

		$r = $Msg->where($data)->delete();

		echo $r;

	}



	/**

	 * One activity list获取某个活动下的所有信息, 后台管理用

	 */

	function actlist(){

		$page = $this->param('page', 1);

		$rows = $this->param('rows', 10);



		$offset = ($page - 1) * $rows;

		

		$activity = $this->param('activity', 1);

		$data["activity"] = $activity;



		$Msg = D("Message");

		$result["total"] = $Msg->where($data)->count();



		$result["rows"] = $Msg->relation(true)->where($data)->limit($rows)->page($page)->select();

		if (is_null($result["rows"]))

			$result["rows"] = array();

		foreach ($result["rows"] as $k=>$v)

			$result["rows"][$k]["addtime"] = gettime($v["addtime"]);

		echo json_encode($result);

	}



	/**

	 * 获取图片列表

	 */

	function imglist(){

		$page = $this->param('page', 1);

		$rows = $this->param('rows', 10);



		$offset = ($page - 1) * $rows;

		

		$data["msgtype"] = 1;



		$Msg = D("Message");

		$result["total"] = $Msg->where($data)->count();



		$result["rows"] = $Msg->relation(true)->where($data)->limit($rows)->page($page)->select();

		if (is_null($result["rows"]))

			$result["rows"] = array();

		foreach ($result["rows"] as $k=>$v)

			$result["rows"][$k]["addtime"] = gettime($v["addtime"]);

		echo json_encode($result);

	}



	/**

	 * 获取一条状态5未展示的消息，用于留言板

	 */

	function get_one_board() {

		$Msg = D("Message");

		$result = $Msg->where("status=5")->find();

		if ($result == false) {

			echo json_encode('{id:0}');

		} else {

			$d['id'] = $result['id'];

			$d['status'] = 4;

			$Msg->save($d);

			echo json_encode($result);

		}

	}



	/**

	 * 人工设置留言板，使用苏畅的id

	 */

	function set_one_board() {

		$Message = M('Message');

		$content = $this->param("content", "");

		$content = str_replace("&amp;quot;", "\"", $content);

		$m['uid'] = 29;

		$m['msgtype'] = 0;

		$m['content'] = $content;

		$m['msgid'] = "1234567890123456789";

		$m['activity'] = 9;

		$m['addtime'] = time();

		$m['status'] = 5;

		echo $Message->add($m);

	}



	/**

	 * 获取一条状态2未展示的消息，用于信息墙

	 */

	function get_one_wall() {

		$Msg = D("Message");

		$result = $Msg->where("status=2")->relation(true)->find();

		if ($result == false) {

			echo json_encode('{id:0}');

		} else {

			$d['id'] = $result['id'];

			$d['status'] = 4;

			$Msg->save($d);

			echo json_encode($result);

		}

	}



	/* 后台点击抽奖按钮后调用，参数为几等奖、几个人，抽奖后通知用户 */

	function lottery() {

		$lottery = $this->param("lottery", 0);

		$num = $this->param("num", 0);

		if ($lottery <= 0) {

			echo die(json_encode(array("errcode"=>-1, "errmsg"=>"请指定中奖级别（>0）")));

		}

		$Model = new Model();

		$users = $Model->query("SELECT id, nickname, fakeid FROM twwx_lottery l JOIN twwx_user u ON l.uid=u.id WHERE lottery={$lottery}");

		if (count($users) < $num) {

			$num = $num - count($users);

			$users = array_merge($users, $Model->query("SELECT id, nickname, fakeid FROM twwx_lottery l JOIN twwx_user u ON l.uid=u.id WHERE lottery=0 ORDER BY rand() LIMIT {$num}"));

			$ids = array();

			foreach ($users as $u) {

				array_push($ids, $u['id']);

			}

			$d['uid'] = array("IN", implode(",", $ids));

			M("Lottery")->where($d)->setField("lottery", $lottery);

			/*load("@.login");

			$r = login();

			$token = $r['token'];

			$cookie = $r['cookie'];

			$url = "https://mp.weixin.qq.com/cgi-bin/singlesend";



			load("@.math");

			$lot = num2char($lottery, false);

			//$content = "恭喜你中了${lot}等奖，谢谢你对我们的支持！";



			foreach ($users as $u) {

				$referer = "https://mp.weixin.qq.com/cgi-bin/singlesendpage?tofakeid=${u['fakeid']}&t=message/send&action=index&token=${token}&lang=zh_CN";

				$random = random();

				$postData = "type=1&content=${content}&tofakeid=${u['fakeid']}&imgcode=&token=${token}&lang=zh_CN&random=${random}&f=json&ajax=1&t=ajax-response";

				$result = sendPostHttps($url, $postData, 0, $referer, $cookie);

			}*/

		}

		

		$left = $Model->query("SELECT nickname, fakeid FROM twwx_lottery l JOIN twwx_user u ON l.uid=u.id WHERE lottery=0");

		echo json_encode(array("users"=>$users, "count"=>count($left)));

	}



	/* 后台获取列表 */

	function lottery_list() {

		$result["total"] = M("Lottery")->where("lottery>0")->count();

		$Model = new Model();

		$result["rows"] = $Model->query("SELECT id, nickname, fakeid, lottery, status FROM twwx_lottery l JOIN twwx_user u ON l.uid=u.id where l.lottery>0 ORDER BY l.lottery");

		$ids = array();

		load("@.math");

		foreach ($result["rows"] as &$u) {

			$lot = num2char($u['lottery'], false);

			$u['content'] = "${lot}等奖";

		}

		echo json_encode($result);

	}



	function lotteryboard(){

		$Model = new Model();

		$users = $Model->query("SELECT nickname, fakeid FROM twwx_lottery l JOIN twwx_user u ON l.uid=u.id WHERE lottery=0 ORDER BY rand() LIMIT 2000");

		$this->assign("users", $users);

		$this->assign("count", count($users));

		$this->display();

	}



	// 给予抽特等奖的权限，这几个函数名起的实在不怎么样，sorry for that

	function lottery_to_access_special() {

		$id = $this->_param("id");

		$status = M("Lottery")->where("uid=${id}") ->find();

		if($status['status']){

			$ret = M("Lottery")->where("uid=${id}")->setField("status", 0);

		}

			else{

			$ret = M("Lottery")->where("uid=${id}")->setField("status", 3);
		}
		echo json_encode(array("status"=>$ret));

	}

	// 获取能抽特等奖的用户列表

	function lottery_for_special_list() {

		$Model = new Model();

		$results = $Model->query("SELECT id, nickname, fakeid FROM twwx_lottery l JOIN twwx_user u ON l.uid=u.id WHERE l.status=3");

		echo json_encode($results);

	}

	// 抽特等奖

	function lottery_for_special() {

		$Model = new Model();

		$result = $Model->query("SELECT id, nickname, fakeid FROM twwx_lottery l JOIN twwx_user u ON l.uid=u.id WHERE l.status=4");

		if (!$result && count($result) < 1) {

			$result = $Model->query("SELECT id, nickname, fakeid FROM twwx_lottery l JOIN twwx_user u ON l.uid=u.id WHERE l.status=3 ORDER BY rand() LIMIT 2");

			M("Lottery")->where("uid=%d", $result[0]['id'])->setField("status", 4);

			M("Lottery")->where("uid=%d", $result[1]['id'])->setField("status", 4);

		}

		echo json_encode($result);

	}



	function param($name, $default){

		return is_null($this->_param($name)) ? $default : $this->_param($name);

	}
 //清空message表
	public function deleteAll(){

		$sql = 'truncate table twwx_message';

		M('message') -> execute($sql);

	}

	public function msgwall(){

		$activity = M('activity') -> where('towall=1') -> find();

		$this -> assign('activity',$activity);

		$this -> display();

	}
	//重置抽取特等奖信息
	public function special_lottery_clear(){

		M("lottery") -> execute("update twwx_lottery set status=0");

	}

}

?>