<?php
namespace Home\Controller;
use Think\Controller;
class TicketController extends Controller{
	//sendPoster
	
	public function get(){
		$user_id = I('param.user_id');
		$tmp_path = ROOT . 'Tmp/poster/';
		$poster = $tmp_path . $user_id . '.png';
		if(!file_exists($poster)){
			$this->img();
		}
		echo $_GET['callback'].'('.json_encode(['url'=>$_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].'/Tmp/poster/'.$user_id . '.png']).')';
	}
	public function img(){
	    header('content-type:text/html;charset=utf-8');
		$width_t = $height_t = 180;//二维码宽高
		//二维码距离边缘距离
		$left_t = 136;
		$bottom_t = 180;
		$text_size = 24;//名字字体大小
		$text_bottom = 356 ;
		$text_left = 356;
 		$user_id = I('param.user_id');
 		$link = $this->detailLink($user_id);
		$user = M('user')->field('nickname,headimgurl')->where('id="%s"',$user_id)->find();
// 		$user = array(
// 				'nickname'=>'爱神的箭发货',
// 				'headimgurl'=>'http://wx.qlogo.cn/mmopen/P3Bnu5KAd24ibw7GglibK62h4wVZQoUtXegpxcdz3RPkkHeBR3AOqmewAzPElgeaUad624jmJesAjvHI66x9kUicSfCHAEjoS4ia/0'
// 		);
 		
 		//生成二维码地址
 		$tmp_path = ROOT . 'Tmp/poster/';
 		$poster_t = $tmp_path . $user_id . '_t.png';
		//生成二维码图片
		import("Org.Net.PhpQrcode");
		$obj=new \QRcode();
		$errorLevel = "L";
		$obj->png($link, $poster_t, $errorLevel, 6);
		
		$image = new \Think\Image();
		$image->open($poster_t)->thumb($width_t,$height_t,\Think\Image::IMAGE_THUMB_FIXED)->save($poster_t);
		
		$head_img = $user['headimgurl'];
		$head_save = $tmp_path . $user_id . '_h.png';
		$this->head($head_img, $head_save);
		
		$image->open($head_save)->thumb(110,110,\Think\Image::IMAGE_THUMB_FIXED)->save($head_save);
		gd_radius($head_save);
		//模板地址
		$tmp_img = ROOT.'Uploads/' . '_qrcode/tmp_img.png';
		

		//合并 
		$extName = getExtName($tmp_img);
		$image->open($tmp_img);
		$poster_width = $image->width();
		$width = $image->width() ;
		$height = $image->height() ;
		
		
		$t_x = $left_t; 
		$t_y = $height - $height_t - $bottom_t;
		$text_x = $text_left;
		$text_y = $height - $text_size*3 - $text_bottom-10;
		
		
		$text = "我是 {$user['nickname']}\n我要为H.girlsmile代言";
		$poster_re = $tmp_path . $user_id . '.' . $extName;
		$image
		->text($text, ROOT . 'Public/fonts/STLITI.TTF', $text_size ,'#000000' , array($text_x,$text_y))
		->water($head_save,array(222,600))
		->water($poster_t,array($t_x,$t_y))->save($poster_re);
		
		//名字
		
		
		
		//发消息开始
		$obj = new \Org\Wechat\Msg();
		$re = $obj->customSendImg($_SESSION['user']['openid'], $poster_re);
		if($re)exit('1');
		else exit($obj->getError() );
	}
	private function detailLink($user_id){
		return   'http://xigesi.hgirlsmile.com?pid='.$user_id;
	}
	private function ticket(){
		
	}
 	private function head($headimgurl,$savename){
 		
// 		$exd = array(1=>'gif',2=>'jpeg',3=>'png');
// 		$imgMsg = getimagesize($headimgurl);
// 		var_dump($imgMsg);exit;
//		$extName = $exd[$imgMsg[2]];
 		$extName = 'jpeg';
		$creatFun = 'imagecreatefrom'.$extName;
		$outFun = 'image'.$extName;
		$img = $creatFun($headimgurl);
		$a = $outFun($img,$savename);
		imagedestroy($img);
		
	}
	
	
}