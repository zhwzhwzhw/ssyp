<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class RoleController extends BaseController{
    public function index(){
    	$roleObj = M('role');
    	$roleArr = $roleObj->select();
    	foreach ($roleArr as $k=>$v){
    		$roleArr[$k]['power'] = explode('|', $v['power']);
    	}
    	
    	$powerObj = M('power');
    	$powerArr = $powerObj->select();
    	
    	$this->assign('power',$powerArr);
    	$this->assign('role',$roleArr);
        $this->display();
    }
    
    public function add(){  //编辑添加在一块
    	$roleObj = M('role');
    	if($_POST){
    		$id = I('post.id');
    		$data['role_type'] = $_POST['role_type'];
    		$data['power'] = join('|', $_POST['powerid']);
    		$data['role_name'] = $_POST['role_name'];
    		if($id){
    			$re = $roleObj->data($data)->where('id="%s"',$id)->save();
    		}else{
    			$re = $roleObj->data($data)->add();
    		}
    	
    		if($re){
    			$this->success('操作成功',U('index'));
    		}else{
    			$this->error('操作失败');
    		}
    		exit;
    	}
    	$id = I('get.id');
    	$data = $roleObj->where('id="%s"',$id)->find();
    	$this->assign('data',$data);
    	$have = explode('|', $data['power']);
    	$role_type = $_GET['role_type'];
    	if($role_type){
    		if($role_type == '1'){
    			$where = array(
    					'module' => 'Admin'
    			);
    		}
    		
    		$powerObj = M('power');
    		$powerArr = $powerObj->where($where)->select();
    		if($powerArr == array()){
    			$this->error('请先添加权限',U('Power/add'));
    		}
			foreach ($powerArr as $k=>$v){
				if(in_array($v['id'], $have)){
					$powerArr[$k]['have'] = 1;
					
				}
			}
    		$this->assign('power',$powerArr);
    		$this->display();
    	}else{
    		$this->error('请选择要添加的角色类型',U('index'));
    	}
    	
    }
   
   
}