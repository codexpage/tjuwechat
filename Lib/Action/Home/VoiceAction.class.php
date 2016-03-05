<?php

class VoiceAction extends BaseAction {
	private $mediaId;
	private $format;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		$this->mediaId = $recvObj->mediaId;
		$this->format = $recvObj->format;
		
		if ($recvObj->msgType == "voice") {
			return true;
		}
		return false;
	}
	function handle(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://www.google.com/speech-api/v1/recognize?xjerr=1&client=chromium&lang=zh-CN&maxresults=10");
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents('1.flac'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: audio/x-flac; rate=16000"));
		$data = curl_exec($ch);
		curl_close($ch);
		if ($data=json_decode($data,true)) {

		foreach($data['hypotheses'] as $i) 
		$contentStr.= $i['utterance'];

		} else {
			$contentStr = "识别出错";
		}
		$contentStr = $this->format;
		return parent::getTextXml($contentStr);
	}
}

?>