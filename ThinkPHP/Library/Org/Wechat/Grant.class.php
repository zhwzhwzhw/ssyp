<?php
namespace Org\Wechat;
use Org\Wechat\Base;
//微信网页授权
class Grant extends Base{

	/*
	 *
	 * 获取用户信息
	 *
	 *
	 */
	public function getUser() {
	    $user = array() ;
	    $url = "https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=zh_CN" ;
	    $contentS = file_get_contents(sprintf($url,$this->Token,$this->OpenID));
	    $C =  json_decode($contentS,true) ;
	    if(is_array($C))$user = $C ;
	
	    return $user ;
	
	}
	/*
	 *
	 * 获取Token
	 *
	 *
	 */
	public function getToken() {
	    $openid = "" ;
	    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code " ;
	    $contentS = file_get_contents(sprintf($url,$this->appid,$this->appsecret,$this->User_Code));
	    //var_dump(sprintf($url,$this->appid,$this->appsecret,$this->User_Code));
	    $C =  json_decode($contentS,true) ;
	    if(is_array($C) && isset($C['openid']))
	    {
	        $this->OpenID = $C['openid'] ;$this->Token = $C['access_token'] ; return true ;
	    }
	    return false ;
	     
	}

	/*
	 * 
	 * 判断设备
	 * 
	 * 
	 */
	public function checkDevice() {
	    $useragent  = strtolower($_SERVER["HTTP_USER_AGENT"]);
	    $is_weixin  = strripos($useragent,'micromessenger');
	    $is_win8  = strripos($useragent,'Windows Phone');
	    if(!$is_weixin && !$is_win8)return false ;
	    return true ;
	}
	//$redirect=false 表示跳转到原来的网址 
	/**
	 * 
	 * @param string $updateOnly 穿入id
	 * @param string $redirect
	 * @param unknown $meg
	 */
	public function getWxUser($updateOnly=false,$redirect=false,$meg = array()){
		$currentUrl  = $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

		
		if(empty($_SESSION['wxLogin'])){
			//二维码参数
			$urlStr = '';
			if($meg !==array()){
				foreach ($meg as $k=>$v){
					$urlStr .= '&'.$k.'='.$v;
				}
			}
			$ishave = strpos($currentUrl, '?');
			if($ishave === false){
				$currentUrl .= '?a='.mt_rand(1000, 9999).$urlStr;
			}else{
				$currentUrl .= '&a='.mt_rand(1000, 9999).$urlStr;
			}
			if(!isset($this -> User_Code))
			{
				$redirect_uri = urlencode($currentUrl) ;
				header("location: https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this -> appid}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE&connect_redirect=1#wechat_redirect");
				exit() ;
			}
			
			if(!$this->checkDevice())die("404") ;
			if(!$this->getToken())die('token验证失败');
			
			$user = $this->getUser() ;
			if($user == array())die('登陆失败');
			
			$arr = array(
					'openid'=>$user['openid'],
					'area'=>$user['country'].' '.$user['province'].' '.$user['city'],
					'headimgurl'=>$user['headimgurl'],
					'sex'=>$user['sex'],
					//'onlinetime' => time(),
					'nickname'=>$user['nickname']
			);
			$userOb = M('user');
			if($updateOnly){
				if($userOb->where('openid="%s"',$arr['openid'])->count('id')>0){
					echo '<h2 style="text-align:center;margin-top:20px">这个微信号已经被绑定</h2>';exit();
				}
				$userOb->where('id="%s"',$updateOnly)->data($arr)->save();
			}else{
				//检查微信信息是否存在
				$old = $userOb->field('id')->where('openid="%s"',$arr['openid'])->find();
				
				if($old['id']<=0){
					$re = $userOb->data($arr)->add();
					$arr['id'] = $re;
				}else{
					$re = $userOb->data($arr)->where(array('id'=>$old['id']))->save();
					$arr['id'] = $old['id'];
				}
			}
			
			
			if($arr['headimgurl'] == '')$arr['headimgurl']='no';
			session('wxLogin',$arr);
			$ishave = strpos($currentUrl, '?');
			
			if($redirect !== false){
				$currentUrl = $redirect;
			}
			$currentUrl = str_replace('&code='.$this->User_Code, '', $currentUrl);
			
			header('location:'.$currentUrl);
		}
	}



}