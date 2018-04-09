<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller{
	public function login(){
		if(!empty($_SESSION['admin']['id'])){
			$this->redirect('Index/index');
		}
		$this->display();
	}
	public function check(){
		if(!$_POST){
			$this->redirect('login');
		}
		$phone = I('post.phone');
		$password = I('post.password');
		$obj = M('admin');
		$where = [
			'phone'=>$phone,
			'password'=>md5($password),
		];
		$user = $obj->field('id,cat_shop') -> where($where) ->find();
		if($user){
			$obj->where('id="%s"',$user['id'])
				->data(array('login_ip'=>$_SERVER['REMOTE_ADDR'],'login_time'=>NOW_TIME))
				->save();
			$obj->where('id="%s"',$user['id'])->setInc('login_number');
			//$_SERVER['REMOTE_ADDR'];
			
			session('admin',$user);
			$this->success('登陆成功，正在跳转...',U('Index/index'));
		}else{
			$exist = $obj->where('phone="%s"',$phone)->count('id');	
			if($exist > 0 ){
				$this->error('密码错误');
			}else{
				$this->error('用户不存在');
			}
		}
	}
	
	public function logout(){
		session(null);
		$this->redirect('login');
	}
}


