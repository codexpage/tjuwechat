<?php

class Message {

	public $toUserName;
	public $fromUserName;
	public $createTime;
	public $msgType;
	public $msgId;

	// MsgType == text
	public $content;

	// MsgType == image
	public $picUrl;
	public $mediaId;

	// MsgType == voice
	// voice里已定义 public $mediaId;
	public $format;

	// MsgType == video
	// image里已定义 public $mediaId;
	public $thumbMediaId;

	//MsgType == location
	public $locationX;
	public $locationY;
	public $scale;
	public $label;

	// MsgType == link
	public $title;
	public $description;
	public $url;

	// MsgType == event
	public $event;
	// Event == subscribe/scan
	public $eventKey;
	public $ticket;
	// Event == Location
	public $latitude;
	public $longitude;
	public $precision;
	
	function __construct($postObj) {
		// 为了便于应对以后微信对新消息格式的扩充，把每一种情况都完整的写在一个函数里，
		// 不可避免地出现一定量的重复代码

		if ($postObj->MsgType == "text") {
			$this->constructText($postObj);
		} else if ($postObj->MsgType == "image") {
			$this->constructImage($postObj);
		} else if ($postObj->MsgType == "voice") {
			$this->constructVoice($postObj);
		} else if ($postObj->MsgType == "video") {
			$this->constructVideo($postObj);
		} else if ($postObj->MsgType == "location") {
			$this->constructLocation($postObj);
		} else if ($postObj->MsgType == "link") {
			$this->constructLink($postObj);
		} else if ($postObj->MsgType == "event") {
			$this->constructEvent($postObj);
		}
	}

	function constructText($postObj){
		$this->toUserName = (string) $postObj->ToUserName;
		$this->fromUserName = (string) $postObj->FromUserName;
		$this->createTime = (string) $postObj->CreateTime;
		$this->msgType = (string) $postObj->MsgType;
		$this->msgId = (string) $postObj->MsgId;

		$this->content = (string) $postObj->Content;
	}

	function constructImage($postObj){
		$this->toUserName = (string) $postObj->ToUserName;
		$this->fromUserName = (string) $postObj->FromUserName;
		$this->createTime = (string) $postObj->CreateTime;
		$this->msgType = (string) $postObj->MsgType;
		$this->msgId = (string) $postObj->MsgId;

		$this->picUrl = (string) $postObj->PicUrl;
		$this->mediaId = (string) $postObj->MediaId;
	}

	function constructVoice($postObj){
		$this->toUserName = (string) $postObj->ToUserName;
		$this->fromUserName = (string) $postObj->FromUserName;
		$this->createTime = (string) $postObj->CreateTime;
		$this->msgType = (string) $postObj->MsgType;
		$this->msgId = (string) $postObj->MsgId;

		$this->format = (string) $postObj->Format;
		$this->mediaId = (string) $postObj->MediaId;
	}

	function constructVideo($postObj){
		$this->toUserName = (string) $postObj->ToUserName;
		$this->fromUserName = (string) $postObj->FromUserName;
		$this->createTime = (string) $postObj->CreateTime;
		$this->msgType = (string) $postObj->MsgType;
		$this->msgId = (string) $postObj->MsgId;

		$this->thumbMediaId = (string) $postObj->ThumbMediaId;
		$this->mediaId = (string) $postObj->MediaId;
	}

	function constructLocation($postObj){
		$this->toUserName = (string) $postObj->ToUserName;
		$this->fromUserName = (string) $postObj->FromUserName;
		$this->createTime = (string) $postObj->CreateTime;
		$this->msgType = (string) $postObj->MsgType;
		$this->msgId = (string) $postObj->MsgId;

		$this->locationX = (string) $postObj->Location_X;
		$this->locationY = (string) $postObj->Location_Y;
		$this->scale = (string) $postObj->Scale;
		$this->label = (string) $postObj->Label;
	}

	function constructLink($postObj){
		$this->toUserName = (string) $postObj->ToUserName;
		$this->fromUserName = (string) $postObj->FromUserName;
		$this->createTime = (string) $postObj->CreateTime;
		$this->msgType = (string) $postObj->MsgType;
		$this->msgId = (string) $postObj->MsgId;

		$this->title = (string) $postObj->Title;
		$this->description = (string) $postObj->Description;
		$this->url = (string) $postObj->Url;
	}

	function constructEvent($postObj){
		$this->toUserName = (string) $postObj->ToUserName;
		$this->fromUserName = (string) $postObj->FromUserName;
		$this->createTime = (string) $postObj->CreateTime;
		$this->msgType = (string) $postObj->MsgType;
		$this->event = (string) $postObj->Event;

		if ($this->event == "subscribe" || $this->event == "scan"){
			$this->eventKey = (string) $postObj->EventKey;
			$this->ticket = (string) $postObj->Ticket;
		} else if($this->event == "LOCATION"){
			$this->latitude = (string) $postObj->Latitude;
			$this->longitude = (string) $postObj->Longitude;
			$this->precision = (string) $postObj->Precision;
		} else if($this->event == "CLICK"){
			$this->eventKey = (string) $postObj->EventKey;
		}
	}
}

?>