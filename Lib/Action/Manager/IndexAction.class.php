<?php

// 本类由系统自动生成，仅供测试用途

class IndexAction extends Action {

    public function index(){
    	 //检查用户是否登录
		    if(isset($_SESSION['admin']))  {
		    //跳转到首页		   
	    	$mo = is_null($this->_param('mo')) ? 'Msgwall' : $this->_param('mo');//mo表示module

	    	$ac = is_null($this->_param('ac')) ? 'each' : $this->_param('ac');//ac表示action
			
			$this->assign('mo', $mo);

	    	$this->assign('includeurl', 'Tpl/Manager/'.$mo.'/'.$ac.'.html');

			$this->display();
	}
		 else{
		    //到登录页面

			$this->display('Login/login');

     		}

}
}