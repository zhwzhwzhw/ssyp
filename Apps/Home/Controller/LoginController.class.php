<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
	public function test(){
/* 		$wechat = new \Org\Wechat\AutoLogin();
    	$user = $wechat->getUser(); */
		var_dump(file_get_contents('./index.php'));
		var_dump(file_get_contents('http://www.baidu.com'));
		$user = file_get_contents('http://www.baidu.com');
    	var_dump($user);
	}
    public function login(){
//     	$re = $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
//     	var_dump($re);
//     	exit;
    	if(empty($_SESSION['user']['id'])){
    		$obj = M('user');
    		$wechat = new \Org\Wechat\AutoLogin();
    		$user = $wechat->getUser();
    		$where = array(
    				'openid'=>$user['openid']
    		);
    		$user_msg = $obj->field('id')->where($where)->find();
    		if(empty($user_msg)){
    			$user['first_time'] = NOW_TIME;
    			$user['pid'] = (int)I('get.pid');
    			$lastid = $obj->data($user)->add();
    			$arr = array(
    					'id'=>$lastid,
    			);
    		}else{
  				$arr = $user_msg;
    			$obj->where($where)->data($user)->save();
    		}
    		
    		$log_arr = array('login_ip'=>$_SERVER['REMOTE_ADDR'],'login_time'=>NOW_TIME);
    		$log_where = array('openid'=>$user['openid']);
    		$obj->where($log_where)->setInc('login_number');
    		$obj->where($log_where)->data($log_arr)->save();
    		session('user',$arr);
    	}
    	$url =  'http://xigesi.hgirlsmile.com?user_id=' . $_SESSION['user']['id'];
    	header('location:'.$url);
	}
	public function logout(){
		session(null);
	}

}