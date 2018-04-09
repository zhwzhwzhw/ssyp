<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class UserController extends BaseController {
    public function index(){
        $adminId   = $_SESSION['admin']['id'];
        $adminObj  = M('admin');
        $admin     = $adminObj->where("id=$adminId")->find();
        if($admin['role_id']!=-1){
           $where['pid']=$admin['user_id'];
        }
		$obj       = M('user');
		$where     = [];
		$totalRows = $obj->where($where)->count('id');
		$Page      = new \Think\Page($totalRows,20);
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$this->assign('page',$Page->show());
		$list= $obj->where($where)
			    	->order('id desc')
			    	->limit($Page->firstRow,$Page->listRows)
			    	->select();
		$this->assign('score',$obj->sum('score'));
		$this->assign('cash',M('money')->where('status="%s"',1)->sum('money_reduce'));
		$this->assign('list',$list);
		$this->assign('title','会员信息');
        $this->display();
    }
   
    
    
	
	
}