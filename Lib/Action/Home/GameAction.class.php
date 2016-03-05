<?php

class GameAction extends BaseAction{
	
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);

		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);	
		
		if ($this->msg == '游戏') {
			return true;
		}
		return false;
	}

	function handle(){
		$return_arr = array (
			array (
					"游戏",
					"",
					"" 
			),
			array (
					"2048",
					"http://imgt4.bdstatic.com/it/u=436350699,3654357169&fm=11&gp=0.jpg",
					"http://gabrielecirulli.github.io/2048/" 
			),
			array (
					"Flappy Bird",
					"http://imgt4.bdstatic.com/it/u=4148255114,1700527686&fm=11&gp=0.jpg",
					"http://www.flappybirdonweb.com/" 
			)
			);
						
			//数组循环转化
			foreach ( $return_arr as $value ) {
				$contentStr .= "<item>\n
				<Title><![CDATA[" . $value [0] . "]]></Title>\n
				<Description><![CDATA[]]></Description>\n
				<PicUrl><![CDATA[" . $value [1] . "]]></PicUrl>\n
				<Url><![CDATA[" . $value [2] . "]]></Url>\n
				</item>\n";
			}
		$count  =  count($return_arr);
		return parent::getNewsXml($count, $contentStr);
	}
}
?>