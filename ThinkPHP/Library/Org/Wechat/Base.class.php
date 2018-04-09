<?php
namespace Org\Wechat;
class Base{
	protected  $appid;
	protected  $appsecret;
	private $file;
	protected  $errorMsg;
	protected $User_Code;
    protected $jsapi_file;
	public function __construct($appid = NULL,$appsecret = NULL){
		$appid = is_null($appid) ? C('APPID') : $appid;
		$appsecret = is_null($appsecret) ? C('APPSECRET') : $appsecret;
		$this->appid = $appid;
		$this->appsecret = $appsecret;
		$this->file = ROOT.'Tmp/access_token.txt';
		$this->User_Code = $_GET['code'];
		$this->jsapi_file = ROOT.'Tmp/jsapi_access_token.txt';
 	}
 	//获取access_token
	public function accessToken(){
		$access_token = file_get_contents($this->file);
		$mtime=filemtime($this->file);

// 		var_dump($access_token);
// 		var_dump(time() - $mtime);
// 		var_dump(empty($access_token) || (time()-$mtime)>7150);
		
		//var_dump(time()-$mtime);
		if(empty($access_token) || (time()-$mtime)>2000){
			$access = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->appsecret;
			$access_json = file_get_contents($access);
			$access_obj = json_decode($access_json);
			$access_token= $access_obj->access_token;
			file_put_contents($this->file, $access_token);
		}
		return $access_token;
	}
	public function configMessage(){
		$str = $_GET['echostr'];
		if($this->checkSignature()){
			echo $str;
			exit();
		}
	}
	public function checkSignature(){
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];
	
		$token = TOKEN;
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
	public function getHttp($url,$data=NULL){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//https跳过SSL证书检查。 服务器证书位开启 exec输出是空
	
		curl_setopt($ch, CURLOPT_URL, $url);
	
		//curl_setopt($ch, CURLOPT_HEADER, 0);
		if($data){
			curl_setopt($ch, CURLOPT_POST, 1);
			//curl_setopt ( $ch, CURLOPT_SAFE_UPLOAD, false);
			
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$opt = curl_exec($ch);
		curl_close($ch);
		return $opt;
	}	
	public function jsonData($json,$field){
		$obj = json_decode($json);
		return $obj->$field;
	}
}