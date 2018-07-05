<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {
    public function _initialize(){
    	if(empty($_SESSION['admin']['id'])){
    		$this->redirect('Common/login');
    	}else{
    		$user_base = M('admin')->field('role_id,realname,login_number')->where('id="%s"',$_SESSION['admin']['id'])->find();
    		//这里查询头像 姓名等
    		//$user_base = M('user')->field('openid,headimgurl,realname,webname')->where('id="%s"',$_SESSION['admin']['id'])->find();
    		$this->assign('user_base',$user_base);
    		$roleObj = M('role');
    		$roleArr = $roleObj->field('power,role_name')->where('id="%s"',$user_base['role_id'])->find();
            $this->assign('role',$roleArr);
    		$rolePowArr = explode('|', $roleArr['power']);
    		$power = $this->power($user_base['role_id'],$rolePowArr);
    		/*if(!$power){
    			echo '<script>alert("没有权限");history.go(-1)</script>';exit;
    		}*/
            
            if(($user_base['role_id'] == '0'  ||  empty($roleArr['power'])) && $user_base['role_id'] != '-1' ){
                $menu = [];
            }else{
                $where_menu = [];
                if($user_base['role_id'] != '-1' ){
                    $where_menu['id'] = array('in',join(',',$rolePowArr));
                }
                $where_menu['fid'] = array('gt',0);
                $menu = M('power')->where($where_menu)->select();
            }
    		
    		$this->assign('menu',$menu);
    		
    	}
    	if(date('H')>12){
    		$time_msg =  '下午';
    	}else{
    		$time_msg = '上午';
    	}
    	$this->assign('time_msg',$time_msg);
    	$this->assign('admin_status',$_SESSION['admin']['status']);
    	$this->assign('title','膳食优品后台管理');
    	$this->myInit();
    }
    protected function myInit(){
    	//做权限;
//     	$status = $_SESSION['admin']['status'];
//     	if(empty($this->power))return ;
//     	if(!array_key_exists($status, $this->power)){
//     		echo '<script>alert("没有权限");history.go(-1);</script>';exit;
//     	}else{
//     		$str_power = $this->power[$status];
//     		if(empty($str_power))return;
//     		$power_action = explode(',', $str_power);
//     		if(in_array(ACTION_NAME, $power_action)){
//     			echo '<script>alert("没有权限");history.go(-1);</script>';exit;
//     		}
//     	}
    }
    public function changeGet(){
    	$_data = I('get.');
    	$id = I('get.id');unset($_data['id']);
    	$tb = I('get.tb');unset($_data['tb']);
    	$obj = M($tb);
    	$obj->where('id="%s"',$id)->data($_data)->save();
    	//echo $obj->_sql();exit;
    	header('location:'.$_SERVER['HTTP_REFERER']);
    }
    private function  power($role_id,$rolePowArr){
    	//最大权限　　-1
		if($role_id == -1){ 
			return true;
		}
		 
		$data = array(
				'module'=>MODULE_NAME,
				'controller'=>CONTROLLER_NAME,
				'action'=>ACTION_NAME
		);
		$powerObj = M('power');
		$power = $powerObj->field('id')->where($data)->find();
		if(empty($power)){
			return true;
		}
		//最小权限　　0
		if($role_id == 0){
			return false;
		}
		 
		
		 
		//权限控制
		if(in_array($power['id'], $rolePowArr)){
			return true;
		}else{
			return false;
		}
	 
	 
	}
    
    
}