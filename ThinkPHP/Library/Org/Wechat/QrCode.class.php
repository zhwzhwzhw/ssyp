<?php
//获取参数的二维码
namespace Org\Wechat;
use Org\Wechat\Base;
class QrCode extends Base{
	public function getQr($filename,$tag){
	    $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->accessToken();
	    $json = '{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$tag.'"}}}';
	    $re = $this->getHttp($url,$json);
	    $obj = json_decode($re);
	    $ticket = urlencode($obj->ticket);
	    $img_url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket;
	    $img = imagecreatefromjpeg($img_url);
	    $re = imagejpeg($img,$filename);//__DIR__.'/1.jpeg'
	    imagedestroy($img);
	    return $re;  //true  null
	}
}