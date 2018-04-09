<?php
namespace Home\Controller;
use Think\Controller;
class WxController extends Controller {
//     public function ms(){
//         header('Content-Type:text/html;charset=utf-8');
//         $idArr = array('2','3');
//         $idWhere = join(',', $idArr);
//         $newsObj = M('News');
//         $news = $newsObj->where('id in ('.$idWhere.')')->select();
//         $thumb = $news[0]['thumb'];
//         $title = $news[0]['title'];
//         $content = $news[0]['content'];
//         $subhead = $news[0]['subhead'];
        
        
//         $obj = new \Org\Wechat\Material();
//         $token = $obj->accessToken();
//         $path = ROOT . 'Uploads/' . $thumb;
//         $media = 'cGInOqZYNNtu1AC-AiLMLd0RIEewVIU0Lk1vu00-mOg';//$obj->add_forever($path, 'image');
//         $url = 'https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token='.$token;
//         $json = '
// {
//    "articles": [
// 		 {
//              "thumb_media_id":'.$media.',
//              "author":"龙行天下",
// 			 "title":"'.$title.'",
// 			 "content_source_url":"http://www.baidu.com",
// 			 "content":"'.$content.'",
// 			 "digest":"'.$subhead.'",
//              "show_cover_pic":1
// 		 }
//    ]
// }';
//         echo $json;
//         $re = $obj->getHttp($url,$json);
//         var_dump($re);
//     }
//     public function code(){
//         echo urlencode('gQEA8jwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyRHQ4UHdjMTVlNzQxMDAwMHcwNzYAAgTKEKFZAwQAAAAA');
//         $obj = new \Org\Wechat\QrCode();
//         $re = $obj->getQr();
//         //var_dump($re);
//         //https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=
//     }
    public function index(){
        $obj = new \Org\Wechat\Receive();
        if($obj->checkSignature()){
            if(isset($_GET['echostr'])){
                echo $_GET['echostr'];exit();
            }else{
                $arr = $obj->receive();

                switch ($arr['MsgType']) {
                    case 'event':
                        $this->event($arr);
                    ;
                    break;
                    
                    default:
                        ;
                    break;
                }
                
            }
        }else {
            echo 'SUCCESS';exit;
        }
    }
	private function event($arr){
	    if(!empty($arr['Ticket'])){          //扫码事件
	        $openid = $arr['FromUserName'];
	        $tag = str_replace('qrscene_', '', $arr['EventKey']);
			if(strpos($tag, 'admin_') === false){
				//扫码后逻辑  开通分销商   前台
				$msg = $this->addseller($openid, $tag);
				$obj = new \Org\Wechat\Msg();
				$re = $obj->customSendText($openid, $msg);
			}else{
				//前台
				$url = $url_1 = $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].'/shop/index.php/admin';
				$admin = M('admin');
				$count = $admin->where('openid="%s"',$openid)->count('id');
				if($count <= 0){
					$tag = str_replace('admin_', '', $arr['EventKey']);
					$admin->data(['openid'=>$openid])->where('id="%s"',$tag)->save();
					$msg = "绑定成功 \n登录<a href='{$url}'>管理员界面</a>";
				}else{
					$msg = "这个账号已经绑定过管理员";
				}
				
				$obj = new \Org\Wechat\Msg();
				$re = $obj->customSendText($openid, $msg);
			}
	        
	    }
	    
	     
	}
    private function addseller($openid,$pid){
    	$url_1 = $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].'/xgs';
    	$url_2 = $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].'/xgs/person.html';
        $obj = M('user');
        $self = $obj->where('openid="%s"',$openid)->count('id');
        if($self>0){
            return "您已是商城会员，无需再次注册\n 进入 <a href='{$url_2}'>个人中心</a>\n完善资料 赚取积分吧";
        }else{
            $last_id = $obj->data(['openid'=>$openid,'pid'=>$pid])->add();
        	$puser = $obj->field('realname')->where('id="%s"',$pid)->find();
        	return "【{$puser['realname']}】已邀请您成为商城会员！\n\n进入 <a href='{$url_1}'>商城首页</a>\n\n 进入 <a href='{$url_2}'>个人中心</a>";
        }
       
    }
    
    
    //返回二维码地址
    public function qrcode(){
        $id = I('param.user_id');
        $file = ROOT.'Uploads/_qrcode/'.$id.'.jpeg';
        if(!file_exists($file)){
            $obj = new \Org\Wechat\QrCode();
            $obj->getQr($file, $id);
        }
        echo BASE_URL.'Uploads/_qrcode/'.$id.'.jpeg';exit;
    }
    
    public function sendTicket(){
        $id = $_SESSION['user']['id'];
        $ticket_img = ROOT.'Uploads/_qrcode/'.$id.'.jpeg';
        $tmp = ROOT . 'Tmp/ticket_tp.jpg';
        $re_img = ROOT . 'Tmp/ticket/'.$id.'.jpg';
        
        $image = new \Think\Image();
        $image->open($ticket_img)->thumb(200, 200)->save($re_img);
        
        $name_info = M('user')->field('realname,openid')->where('id="%s"',$id)->find();
        $name = $name_info['realname'] ? $name_info['realname'] :'龙行天下';
        $len = mb_strlen($name,'utf-8');
        $fontsize = 25;
        $text_x = 177 - ($fontsize + 8)*$len;
        $re = $image->open($tmp)->water($re_img,array(82,165))
        ->text($name, ROOT . 'Public/fonts/STLITI.TTF', $fontsize ,'#000000' , array($text_x,60))
        ->save($re_img);
        
        $obj = new \Org\Wechat\Msg();
		$re = $obj->customSendImg($name_info['openid'], $re_img);
		//var_dump($re);
		if($re)exit('1');
		else exit('0');
    }
    
    
    
    
    
    
}