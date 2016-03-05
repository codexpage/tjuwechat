<?php

abstract class BaseAction extends Action {
	protected $recvObj;
	function shouldHandle($recvObj){
		$this->recvObj = $recvObj;
	}
	abstract function handle();
	
	/*
 * return给微信的xml的模板变量与方法
 */
  protected $textTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[%s]]></Content>
    <FuncFlag>0</FuncFlag>
    </xml>";
  protected $newsTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[%s]]></MsgType>
    <ArticleCount>%s</ArticleCount>
    <Articles>
    <item>
    <Title><![CDATA[%s]]></Title> 
    <Description><![CDATA[%s]]></Description>
    <PicUrl><![CDATA[%s]]></PicUrl>
    <Url><![CDATA[%s]]></Url>
    </item>
    </Articles>
    <FuncFlag>1</FuncFlag>
    </xml>";
  protected $musicTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[music]]></MsgType>
    <Music>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
    <MusicUrl><![CDATA[%s]]></MusicUrl>
    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
    </Music>
    <FuncFlag>0</FuncFlag>
    </xml>";
     
  function getTextXml($text){
    return sprintf($this->textTpl, $this->recvObj->fromUserName, $this->recvObj->toUserName, 
                time(), $text);
  }

  function getNewsXml($num, $news){
    $resultStr = "<xml>\n
      <ToUserName><![CDATA[" . $this->recvObj->fromUserName . "]]></ToUserName>\n
      <FromUserName><![CDATA[" . $this->recvObj->toUserName . "]]></FromUserName>\n
      <CreateTime>" . time () . "</CreateTime>\n
      <MsgType><![CDATA[news]]></MsgType>\n
      <ArticleCount>" . $num . "</ArticleCount>\n
      <Articles>\n" . $news . "</Articles>\n
      </xml>";
      
    return $resultStr;
  }

  function getMusicXml($name, $descript, $url, $hqurl){
    return sprintf($this->musicTpl, $this->recvObj->fromUserName, $this->recvObj->toUserName, 
                time(), $name, $descript, $url, $hqurl);
  }
}
?>