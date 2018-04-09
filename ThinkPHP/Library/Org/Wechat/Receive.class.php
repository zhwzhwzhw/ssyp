<?php
//接受消息
namespace Org\Wechat;
class Receive{
    private $token;
    public function __construct(){
        $this->token = C('TOKEN');
    }
	
	public function checkSignature(){
	    $signature = $_GET["signature"];
	    $timestamp = $_GET["timestamp"];
	    $nonce = $_GET["nonce"];
	    $token = $this->token;
        $tmpArr = array($token, $timestamp, $nonce);
	    sort($tmpArr, SORT_STRING);
	    $tmpStr = implode( $tmpArr );
	    $tmpStr = sha1( $tmpStr );
	
	    if( $tmpStr == $signature ){
	        return true;
	    }else{
	        return false;
	    }
	}
	public function receive(){
	    $getxml = file_get_contents('php://input');
	    $xmlObj = simplexml_load_string($getxml,'SimpleXMLElement',LIBXML_NOCDATA);
        $arr = [];
        foreach ($xmlObj as $k=>$v){
            $arr[$k] = (string)$v;
        }
	    return $arr;  //返回数组
/* 	    $MsgType = (string)$xmlObj->MsgType;
	    switch ($MsgType) {
	        case 'event':
	            $this->event();
	        ;
	        break;
	        
	        default:
	            ;
	        break;
	    } */
	}
	
	
}