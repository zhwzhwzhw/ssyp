<?php
namespace Org\Wechat;
use Org\Wechat\Base;
class Msg extends Base{
	//客服消息开始
	public function customSendImg($openid,$path){
		
		$obj = new \Org\Wechat\Material();
		$media_id = $obj->add_tem($path, 'image');
		$data = '
				{
				    "touser":"'.$openid.'",
				    "msgtype":"image",
				    "image":
				    {
				      "media_id":"'.$media_id.'"
				    }
				}	
				';
		return $this->customSend($data);
	}
	public function customSendText($openid,$content){
		$data = '
				{
				    "touser":"'.$openid.'",
				    "msgtype":"text",
				    "text":
				    {
				         "content":"'.$content.'"
				    }
				}
				';
		return $this->customSend($data);
	}
	private function customSend($data){
		$url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$this->accessToken();
		$json = $this->getHttp($url,$data);
		//{"errcode":45015,"errmsg":"response out of time limit or subscription is canceled hint: [KCJyLa0372ge20]"} 没有关注
		//{"errcode":0,"errmsg":"ok"}  发送成功
		$errcode = $this->jsonData($json, 'errcode');
		if($errcode == 0){
			return true;
		}else if($errcode == 45047){
			$this->errorMsg = '给主动给公众号回复任意消息后再发送';
		}else if($errcode == 45015){
			$this->errorMsg = '给主动给公众号回复任意消息后再发送';
		}
		return false;
	}
	public function getError(){
		return $this->errorMsg;
	}
	
}