<?php
namespace Org\Wechat;
use Org\Wechat\Base;
class AutoLogin extends Base{
	private $CURL_PROXY_HOST = "0.0.0.0";//"10.152.18.220";
	private $CURL_PROXY_PORT = 0;//8080;
	private $REPORT_LEVENL = 1;
	public function getUser(){
		$redirectUrl = 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		if (!isset($_GET['code'])){
			//触发微信返回code码
			$baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING']);
			$urlObj["appid"] = $this->appid;
			$urlObj["redirect_uri"] = "$redirectUrl";
			$urlObj["response_type"] = "code";
			$urlObj["scope"] = "snsapi_base";
			$urlObj["state"] = "STATE"."#wechat_redirect";
			$bizString = $this->ToUrlParams($urlObj);
			$url = "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;;
			//echo $url;exit;
			Header("Location: $url");
			exit();
		} else {
			//获取code码，以获取openid
			$code = $_GET['code'];
			$data = $this->getOpenidFromMp($code);
			$a_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->appsecret;
			$a_json = file_get_contents($a_url);

			$a_obj = json_decode($a_json);
			$access_token = $a_obj->access_token;
			$url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$data['openid'];
			//echo $url;
			$content = file_get_contents($url);
			$obj = json_decode($content);
			/* 			subscribe	1
			 openid	"ofWyQ1cIPXDxhlHiUy93_ZXCcdSA"
			nickname	"胡连平"
			sex	1
			language	"zh_CN"
			city	""
			province	"北京"
			country	"中国"
			headimgurl	"http://wx.qlogo.cn/mmopen/Kf5051H8VnGhQXTPJAIMmTeDcVffwGLGNXtVV3rQ00JkibbGNWkMnEttzKyQa4NHtqHadckUCBTgY0nWbRxqFn0RO7ibfH4Jyb/0"
			subscribe_time	1491820414
			remark	""
			groupid	0
			tagid_list */
			if(empty($obj->openid)){
				return false;
			}
			$result['subscribe'] = $obj->subscribe;
			$result['openid'] = $obj->openid;
			$result['nickname'] = $obj->nickname;
			$result['sex'] = $obj->sex;
			$result['area'] = $obj->country. ' ' . $obj->province . ' '.$obj->city;
			$result['headimgurl'] = $obj->headimgurl;
			return $result;
		}
	}

	private function GetOpenidFromMp($code){
		$urlObj["appid"] = $this->appid;
		$urlObj["secret"] = $this->appsecret;
		$urlObj["code"] = $code;
		$urlObj["grant_type"] = "authorization_code";
		$bizString = $this->ToUrlParams($urlObj);
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
		//初始化curl
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		if($this->CURL_PROXY_HOST != "0.0.0.0" && $this->CURL_PROXY_PORT != 0){
			curl_setopt($ch,CURLOPT_PROXY, $this->CURL_PROXY_HOST);
			curl_setopt($ch,CURLOPT_PROXYPORT, $this->CURL_PROXY_PORT);
		}
		//运行curl，结果以jason形式返回
		$res = curl_exec($ch);
		curl_close($ch);
		//取出openid
		$data = json_decode($res,true);
		return $data;
	}
	private function ToUrlParams($urlObj){
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			if($k != "sign"){
				$buff .= $k . "=" . $v . "&";
			}
		}
		$buff = trim($buff, "&");
		return $buff;
	}
}