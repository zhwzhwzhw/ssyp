<?php
namespace Api\Controller;
use Think\Controller;
class UserController extends Controller {
	public function msg(){
		$user_id = I('param.user_id');
		$obj = M('user');
		$msg = $obj->where('id="%s"',$user_id)->find();
		echo $_GET['callback'].'('.json_encode($msg).')';
	}
	public function msg_p(){
		$user_id = I('param.user_id');
		$obj = M('user');
		$list = $obj->where('pid="%s"',$user_id)->select();
		echo $_GET['callback'].'('.json_encode($list).')';
	}
	
	public function update(){
		$param = I('param.');
		$id = $param['user_id'];
		$_data['birthday'] = $param['birthday'];
		$_data['phone'] = $param['phone'];
		$_data['realname'] = $param['realname'];
		$re = M('user')->where('id="%s"',$id)->data($_data)->save();
		if($re){
			$arr = ['status'=>1,'msg'=>'设置成功'];
		}else{
			$arr = ['status'=>0,'msg'=>'设置失败'];
		}
		echo $_GET['callback'].'('.json_encode($arr).')';
	}
	public function config(){
		$config = M('config')->field('is_share')->find();
		echo $_GET['callback'].'('.json_encode($config).')';
	}
	
	
}