<?php

class MusicAction extends BaseAction{
	
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		
		$qian = array(" ","　","\t","\n","\r");
		$hou = array("","","","","");
		$this->msg = str_replace($qian, $hou, $recvObj->content);
		
		$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );//截取前两个字
		
		if ($str1 == '音乐') {
			return true;
		}
		return false;
	}
	function handle(){
		$str_key = str_replace('音乐', "", $this->msg);
        if (empty($str_key))
        {
            $contentStr = "想听音乐？跟我一起大声喊 音乐+名字，如音乐 龙的传人@王力宏~";
            return parent::getTextXml($contentStr);
        }
        if (stripos($str_key, "@") !== false)
        {
			$song = substr($str_key, 0, strrpos($str_key,'@'));
        	$author = str_replace($song . "@", "", $str_key);
        }else{
            $song = $str_key;
        	$author = "";
        }

		$resultObj = $this->getMusic ( $song, $author );
		$data = simplexml_load_string ( $resultObj, 'SimpleXMLElement', LIBXML_NOCDATA );
		
		if ( $data->count > 0) {    
			$name = $song;
			$descript = $author;

            $id = substr($data->url[0]->decode, 0, strrpos($data->url[0]->decode,'.m'));
            $mid = substr($data->url[0]->decode, 0, strrpos($data->url[0]->decode,'&mid'));
            $url = 'http://zhangmenshiting.baidu.com/data2/music/' . $id . '/' . $mid;
            
            $hqid = substr($data->durl[0]->decode, 0, strrpos($data->durl[0]->decode,'.m'));
            $hqmid = substr($data->durl[0]->decode, 0, strrpos($data->durl[0]->decode,'&mid'));
            $hqurl = 'http://zhangmenshiting2.baidu.com/data2/music/' . $hqid . '/' . $hqmid;

			return parent::getMusicXml($name, $descript, $url, $hqurl);
		} else {
			$contentStr = "抱歉，未找到歌曲" . $str_key . "的信息哦~";
			return parent::getTextXml($contentStr);
		}
	}

	private function getMusic($song, $author) {
        if (!empty($author))
			$text = file_get_contents ( "http://box.zhangmen.baidu.com/x?op=12&count=1&title=". urlencode($song) . "$$" . urlencode($author) . "$$$$" );
        else
            $text = file_get_contents ( "http://box.zhangmen.baidu.com/x?op=12&count=1&title=". urlencode($song) . "$$$$$$" );
		
		return $text;
	}
}
?>