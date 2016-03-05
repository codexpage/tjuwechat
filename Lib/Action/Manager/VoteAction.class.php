<?php

class VoteAction extends Action {

	//在微信墙界面上获取列表构建Combobox
	function result(){
		$C = M("Competitor");
		$result = $C->order("poll desc")->select();
		if (count($result) > 0){
			$result[0]['selected'] = true;
		}
		echo json_encode($result);
	}

	//以下都是在活动管理列表里用
	function get_competitor(){
		$page = $this->param('page', 1);
		$rows = $this->param('rows', 10);

		$offset = ($page - 1) * $rows;

		$Competitor = D("Competitor");
		$result["total"] = $Competitor->count();

		$result["rows"] = $Competitor->limit($rows)->page($page)->select();
		if (is_null($result["rows"]))
			$result["rows"] = array();

		echo json_encode($result);
	}

	function save_competitor(){
		$name = $this->_param('name');
		$code = $this->_param('code');
		$C = M('Competitor');
		$data['name'] = $name;
		$data['code'] = $code;
		$id = $C->add($data);
		if ($id > 0)
			echo json_encode($C->find($id));
		else
			echo dump($C->getlastsql());
	}

	function update_competitor(){
		$C = M('Competitor');
		$C->create();
		$C->save();
		echo json_encode($this->_param('id'));
	}

	function del_competitor(){
		$data['id'] = $this->_param('id');
		$C = M('Competitor');
		$C->where($data)->delete();
		echo json_encode(array('success'=>true));
	}

	function add_vote_permission(){
		$U = M("User");
		$data['vote'] = 1;
		$count = $U->where("id>0")->save($data);
		echo $count;
	}
	
	function del_vote_permission(){
		$U = M("User");
		$data['vote'] = 0;
		$count = $U->where("id>0")->save($data);
		echo $count;
	}

	function show_vote_results(){
		if (is_null($this->_request("query"))) {
			$result = "code\tletter\tpoll\n";
			$votes = M('Competitor')->select();
			foreach ($votes as $player) {
				$result = $result."{$player['code']}\t{$player['name']}\t{$player['poll']}\n";
			}
			echo $result;
		} else {
			$votes = M('Competitor')->select();
			$result = array();
			foreach ($votes as $player) {
				array_push($result, array('code'=>$player['code'], 'name'=>"{$player['name']}", 'poll'=>$player['poll']));
			}
			echo json_encode($result);
		}
		
	}

	function param($name, $default){
		return is_null($this->_param($name)) ? $default : $this->_param($name);
	}

}