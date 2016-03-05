<?php



class ManagerAction extends Action {



	//在微信墙界面上获取列表构建Combobox

	function result(){

		$C = M("Admin");

		$result = $C->order("poll desc")->select();

		if (count($result) > 0){

			$result[0]['selected'] = true;

		}

		echo json_encode($result);

	}



	//以下都是在活动管理列表里用

	function get_manager(){

		$page = $this->param('page', 1);

		$rows = $this->param('rows', 10);



		$offset = ($page - 1) * $rows;



		$Competitor = D("Admin");

		$result["total"] = $Competitor->count();



		$result["rows"] = $Competitor->limit($rows)->page($page)->select();

		if (is_null($result["rows"]))

			$result["rows"] = array();



		echo json_encode($result);

	}



	function save_manager(){

		$name = $this->_param('name');

		$mid = $this->_param('mid');

		$password = $this->_param('password');

		$C = M('Admin');

		$data['name'] = $name;

		$data['password'] = $code;

		$data['mid'] = $mid;

		$id = $C->add($data);

		if ($id > 0)

			echo json_encode($C->find($id));

		else

			echo dump($C->getlastsql());

	}



	function update_manager(){

		$C = M('Admin');

		$C->create();

		$C->save();

		echo json_encode($this->_param('id'));

	}



	function del_manager(){

		$data['id'] = $this->_param('id');

		$C = M('Admin');

		$C->where($data)->delete();

		echo json_encode(array('success'=>true));

	}



	function param($name, $default){

		return is_null($this->_param($name)) ? $default : $this->_param($name);

	}



}