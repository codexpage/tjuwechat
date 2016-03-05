<?php

class ModuleAction extends Action {

	//以下都是在活动管理列表里用
	function get(){
		$page = $this->param('page', 1);
		$rows = $this->param('rows', 10);

		$offset = ($page - 1) * $rows;

		$M = D("Module");
		$result["total"] = $M->where('id>0')->count();

		$result["rows"] = $M->where('id>0')->order("id")->limit($rows)->page($page)->select();
		if (is_null($result["rows"]))
			$result["rows"] = array();

		echo json_encode($result);
	}

	function save(){
		$name = $this->_param('name');
		$description = $this->_param('description');
		$sequence = $this->_param('sequence');
		$enable = $this->_param('enable');
		$M = M('Module');
		$data['name'] = $name;
		$data['description'] = $description;
		$data['sequence'] = $sequence;
		$data['enable'] = $enable;
		$data['addtime'] = gettime(time());
		$id = $M->add($data);
		if ($id > 0)
			echo json_encode($M->find($id));
		else
			echo dump($M->getlastsql());
	}

	function update(){
		$M = M('Module');
		$M->create();
		$M->save();
		echo json_encode($this->_param('id'));
	}

	function del(){
		$data['id'] = $this->_param('id');
		$M = M('Module');
		$M->where($data)->delete();
		echo json_encode(array('success'=>true));
	}

	function param($name, $default){
		return is_null($this->_param($name)) ? $default : $this->_param($name);
	}

}