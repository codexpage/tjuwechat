<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {

    public function index(){
    	
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		/*$postStr = "<xml>
 			<ToUserName>qwe</ToUserName>
 			<FromUserName>olMF1joRZotnekNsNhMkWe-As6sw</FromUserName> 
 			<CreateTime>1395240673</CreateTime>
 			<MsgType>text</MsgType>
 			<Content>新人报道</Content>
 			<MsgId>1234567890123456</MsgId>
 			</xml>";*/
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		import("@.Vo.Message");
		$recvObj = new Message($postObj);

		$Module = M("Module");
		$modules = $Module->where("enable=1")->order('sequence')->select();
		foreach ($modules as $key => $value) {
			$m = A("Home/".$value["name"]);
			if ($m->shouldHandle($recvObj)){
				$resultStr = $m->handle();
				break;
			}
		}
		
		echo $resultStr;
    }
    
}