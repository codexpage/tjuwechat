<?php



class TjuphoneAction extends BaseAction {
	private $msg;

	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);

		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);

		if ($this->msg == '校园电话') {
			return true;
		}
		return false;
	}

	function handle(){
		$contentStr = "★售电：
		
六里台售电办公室电话：022-27406923  
七里台售电办公室电话：022-27404908 

★北洋水厂：

鹏翔公寓：022-87895481   
七里台宿舍：022-27407957 
六里台宿舍：022-27409088
饮水机维修：022-27409088

★快递联系方式：

申通：15522291082   
圆通：13672147687
顺丰：13516130281
韵达：13323409098
天天：13332023751";

		return parent::getTextXml($contentStr);
	}
}

?>