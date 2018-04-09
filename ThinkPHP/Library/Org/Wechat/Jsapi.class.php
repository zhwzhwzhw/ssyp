<?php
namespace Org\Wechat;
use Org\Wechat\Base;
class Jsapi extends Base{
    public function share(){
        $url = $_GET['url'];
        $time = time();
        //var_dump($this->jsapi_file);
        $ticket = file_get_contents($this->jsapi_file);
        $mtime=filemtime($this->jsapi_file);
        //var_dump($ticket);
       // var_dump(empty($ticket) || $time - $mtime > 7150);
        if(empty($ticket) || $time - $mtime > 3000  ){  //没有过期，直接传过去 ticket
            $a_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.C('APPID').'&secret='.C('APPSECRET');
            $a_json = file_get_contents($a_url);
            $a_obj = json_decode($a_json);
            $t_url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$a_obj->access_token.'&type=jsapi';
            $t_json =  file_get_contents($t_url);
            //var_dump($t_json);
            $t_obj = json_decode($t_json);
            $ticket = $t_obj->ticket;
           // var_dump($ticket);
            file_put_contents($this->jsapi_file, $ticket);
        }
        
        $nonceStr = mt_rand(100000, 999999);
        $str = 'jsapi_ticket='.$ticket.'&noncestr='.$nonceStr.'&timestamp='.$time.'&url='.$url;
        //echo $str;
        $arr = array(
            'timestamp'=>$time, // 必填，生成签名的时间戳
            'nonceStr'=>$nonceStr, // 必填，生成签名的随机串
            'signature'=>sha1($str),
            'appId'=>C('APPID')
        );
        return json_encode($arr);
        
    }
}