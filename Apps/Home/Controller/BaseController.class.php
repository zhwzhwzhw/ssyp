<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {
    /*public function _initialize(){
        $user_id = session('user_id');
        if(!$user_id){
            //获取当前网页，授权后跳回
            $path =  $_SERVER['REQUEST_URI'];
            header('Location:/home/auth/index?path='.$path);
        }
    }*/
    public function getcode(){
        $appid        = 'wx6974873b607f073e';
        $path = $_REQUEST['path'];
        $redirect_uri = urlencode('http://'.$_SERVER['HTTP_HOST'].'/home/base/callback');
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=".$path."#wechat_redirect";
        header('Location:'.$url);
    }
    public function callBack(){
        $appid  = 'wx6974873b607f073e';
        $secret = '76ecd93b1a5378e0c01f5313b11cfb93';
        //获取到的code
        $code = $_REQUEST['code'];
        //授权结束后的回调网址
        $path = $_REQUEST['state'];
        //获取access_token
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,'https://api.weixin.qq.com/sns/oauth2/access_token?appid='
            .$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code ');
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        //获取access_token和openid,转换为数组
        $data = json_decode(curl_exec($curl),true);
        //如果获取成功，根据access_token和openid获取用户的基本信息
        if($data != null && $data['access_token']){
            //获取用户的基本信息，并将用户的唯一标识保存在session中
            curl_setopt($curl,CURLOPT_URL,'https://api.weixin.qq.com/sns/userinfo?access_token='
                .$data['access_token'].'&openid='.$data['openid'].'&lang=zh_CN');
            $user_data = json_decode(curl_exec($curl),true);
            if($user_data != null && $user_data['openid']){
                curl_close($curl);
                //将用户信息存在数据库中,同时将用户在数据库中唯一的标识保存在session中
                $array = [];
                $array['openid']       = $user_data['openid'];
                $array['nickname']     = $user_data['nickname'];
                $array['headimgurl']   = $user_data['headimgurl'];
                $array['sex']           = $user_data['sex'];
                $array['area']          = $user_data['city'];
                //我这里只存储了用户的openid,nickname,headimgurl
                $model = M('user');
                //先判断用户数据是不是已经存储了，如果存储了获取用户在数据库中的唯一标识
                $user_id = $model->where(['openid'=>$array['openid']])->getField('id');
                if($user_id){
                    session('user_id',$user_id);
                }else{
                    $array['first_time']    = time();
                    $array['subscribe']     = 1;
                    $user_id = $model->add($array);
                    //将用户在数据库中的唯一表示保存在session中
                    session('user_id',$user_id);
                }
                //跳转网页
                header('Location:'.$path);
            }else{
                curl_close($curl);
                exit('获取用户信息失败！');
            }
        }else{
            curl_close($curl);
            exit('微信授权失败');
        }
    }
    //获取access_token
    function getWechatAccessToken(){
        $appid     = '';
        $secret    = '';
        $config    = M('config')->find();
        if($config['access_token']&&(time()<$config['expires_in'])){
            return $config['access_token'];exit;
        }else {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret;
            //获取access_token
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $data = json_decode(curl_exec($curl), true);
            if($config['access_token']){
                M('config')->where('id='.$config['id'])->save($data);
            }else{
                M('config')->add($data);
            }
            return $data['access_token'];
        }
    }
    //获取带参数二维码
    function QrCode($filename,$id){
        $access_token   = $this->getWechatAccessToken();
        $url            = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
        $qrcode         = '{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_id": '.$id.'}}}';
        $result         = $this->api_notice_increment($url, $qrcode);
        $obj            = json_decode($result);
        $ticket         = urlencode($obj['ticket']);
        $img_url        = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket;
        $img            = imagecreatefromjpeg($img_url);
        $re             = imagejpeg($img,$filename);//__DIR__.'/1.jpeg'
        imagedestroy($img);
        return $re;  //true  null
    }
    function api_notice_increment($url, $data){
        $ch = curl_init();
        $header = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
            curl_close( $ch );
            return $ch;
        }else{
            curl_close( $ch );
            return $tmpInfo;
        }
    }
}