<?php
namespace Admin\Controller;
use \Org\Net\MessageDB;
class MessageController extends MessageDB{
	public $cNum = 8;//每次获取数
	public $bNum = 20;//上拉获取数
	public $listNum = 15;
	function _initialize(){
		$base = new \Admin\Controller\BaseController();
		$this->me = 'a_'.$_SESSION['admin']['id'];
	}

	public function online(){
		$id = $_SESSION['admin']['id'];
		$online = I('get.s');
		$obj = M('admin');
		$obj->where(['id'=>$id])->data(['online'=>$online])->save();
		header('location:'.$_SERVER['HTTP_REFERER']);
	}
	function index(){
		$my = M('admin')->where('id="%s"',$_SESSION['admin']['id'])->find();
		$this->assign('my',$my);
		$user_o = M('user');
		$user = $user_o->field('u.id,headimgurl,nickname,max(m.id) as max_id')
		->alias('u')
		->join(C('DB_PREFIX').'message as m on substring(m_from,3)=u.id')
		->order('max_id desc')
		->group('u.id')
		->where('m_to="%s"',$this->me)
		->select();
		
		
		$this->assign('user',$user);
		$this->display();
		//$this->display('mobi_index');
		
	}
/* 	public function msgOk(){
		$obj = M('respond');
		$re = $obj->where('id="%s"',(int)$_POST['id'])->data(array('status'=>9))->save();
		if($re){
			exit('1');
		}else{
			exit('0');
		}
	} */
	public function msgError(){
		
	}
	public function msgUpdate(){
		
	}
	public function msgDel(){
		
	}
	
	
	
	
	function changeMesStatus(){//已处理 未处理等
		if(isset($_GET['s']) && $_GET['s']!='' && isset($_GET['id']) && $_GET['id']!=''){
			$cache = S(array('type'=>'memcache','prefix'=>'meg_'));
			$c = $cache->fl_LZ;
			if(isset($c[$_GET['id']]['meg_status'])){
				$c[$_GET['id']]['meg_status'] = $_GET['s'];
				$cache->fl_LZ = $c;
			}
			$flObj = M('fl');
			$re = $flObj->where('id="%s"',$_GET['id'])->data(array('meg_status'=>$_GET['s']))->save();
			if($re){
				exit('1');
			}
		}
	}
	
	
	
	public function moreUser(){
		if($_POST){
			$id = I('post.id');
			$s = I('post.s');
			$flObj = M('fl');
			$where = array(
					'id'=>array('not in',$id),
					'meg_time'=>array('neq',0),
					'meg_status'=>array('eq',$s)
			);
			$member = $flObj->where($where)->field('id,name,headimgurl,meg_time,meg_bz')->order('meg_time desc,last_login_time desc,id asc')->limit($this->listNum)->select();
			foreach ($member as $k=>$v){
				if($v['headimgurl'] == ''){
					$member[$k]['headimgurl'] = 'no';
				}
				if($v['meg_bz'] == ''){
					$member[$k]['meg_bz'] = 'no';
				}

			}
			$this->ajaxReturn($member,'json');
		}
	}
	function nameBZ(){
		if(isset($_GET['id']) && isset($_GET['bz']) && $_GET['id'] != '' && $_GET['bz'] != ''){
			$cache = S(array('type'=>'memcache','prefix'=>'meg_'));
			$c = $cache->fl_LZ;
			if(isset($c[$_GET['id']]['meg_bz'])){
				$c[$_GET['id']]['meg_bz'] = $_GET['bz'];
				$cache->fl_LZ = $c;
			}
			$flObj = M('fl');
			$re = $flObj->where('id="%s"',$_GET['id'])->data(array('meg_status'=>$_GET['s']))->save();
			if($re){
				exit('1');
			}
				
			$obj = M('fl');
			$re = $obj->where('id="%s"',$_GET['id'])->data(array('meg_bz'=>$_GET['bz']))->save();
			if($re){
				exit('1');
			}
		}
	}

	function showFl(){
		$cache = S(array('type'=>'memcache','prefix'=>'meg_'));
		$c = $cache->fl_LZ;
		print_r($c);
	}
	/* 	function DshowFl(){
		$cache = S(array('type'=>'memcache','prefix'=>'meg_'));
	unset($cache->fl_LZ);
	echo mt_rand('1000', '9999');

	} */

}