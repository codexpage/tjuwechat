<?php

class TranslateAction extends BaseAction {
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian=array(" ","　","\t","\n","\r");
		$hou=array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		
		$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );//截取前两个字
		
		if ($str1 == '翻译') {
			return true;
		}
		return false;
	}
	function handle(){
		$str_key = mb_substr ( $this->msg, 2, mb_strlen ( $this->msg ) - 1, "UTF-8" );
		
		if (preg_match ( "/^[\x7f-\xff]+$/", $str_key )) {
			$contentStr = $this->language ( $str_key );
		} else {
			$contentStr = $this->language ( $str_key );
		}
		
		return parent::getTextXml($contentStr);
	}
	//调用百度翻译api
	private function language($value, $from = "auto", $to = "auto") {
		$value_code = urlencode ( $value );
		// 先对要翻译的文字进行 urlencode 处理
		$appid = "4RTGvorznzpxQDuM6bha4g1u";
		// 注册的API Key
		$languageurl = "http://openapi.baidu.com/public/2.0/bmt/translate?client_id=" . $appid . "&q=" . $value_code . "&from=" . $from . "&to=" . $to;
		// 成翻译API的URL GET地址
		$json = $this->language_text ( $languageurl );
		$text = json_decode ( $json );
		$text = $text->trans_result;
		return $text [0]->dst;
	}
	
	//将百度翻译返回内容进行编码
	function language_text($url, $postData) 	// 取目标URL所打印的内容
	{
		$file_contents = sendPost($url, $postData);
		$file_contents = mb_convert_encoding($file_contents, "utf-8", "gbk");
		return $file_contents;
	}
}

?>