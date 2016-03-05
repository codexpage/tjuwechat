<?php

class ActivityAction extends Action {

	//在微信墙界面上获取列表构建Combobox
	function alist(){
		$A = M("Activity");
		$result = $A->order("addtime desc")->where('id>0')->select();
		if (count($result) > 0){
			$result[0]['selected'] = true;
		}
		echo json_encode($result);
	}

	//以下都是在活动管理列表里用
	function get(){
		$page = $this->param('page', 1);
		$rows = $this->param('rows', 10);

		$offset = ($page - 1) * $rows;

		$Act = D("Activity");
		$result["total"] = $Act->where('id>0')->count();

		$result["rows"] = $Act->where('id>0')->limit($rows)->page($page)->select();
		if (is_null($result["rows"]))
			$result["rows"] = array();

		echo json_encode($result);
	}

	function save(){
		$name = $this->_param('name');
		$towall = $this->_param('towall');
		$A = M('Activity');
		$data['name'] = $name;
		$data['towall'] = $towall;
		$data['addtime'] = gettime(time());
		$id = $A->add($data);
		if ($id > 0)
			echo json_encode($A->find($id));
		else
			echo dump($A->getlastsql());
	}

	function update(){
		$A = M('Activity');
		$A->create();
		$A->save();
		echo json_encode($this->_param('id'));
	}

	function del(){
		$data['id'] = $this->_param('id');
		$A = M('Activity');
		$A->where($data)->delete();
		echo json_encode(array('success'=>true));
	}

	function param($name, $default){
		return is_null($this->_param($name)) ? $default : $this->_param($name);
	}

}