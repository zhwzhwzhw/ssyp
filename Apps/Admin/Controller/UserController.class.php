<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class UserController extends BaseController {
    public function index(){
        $adminId   = $_SESSION['admin']['id'];
        $where     = array();
        $adminObj  = M('admin');
        $param     = I('param.');
        $admin     = $adminObj->where("id=$adminId")->find();
        if($admin['role_id']!=-1){
           $where['pid']=$admin['user_id'];
        }
        $where['nickname']  = array('like',"%".$param['nickname']."%");
        $where['custum_phone']     = $param['phone'];
		$obj       = M('user');
		$totalRows = $obj->where($where)->count('id');
		$Page      = new \Think\Page($totalRows,20);
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$this->assign('page',$Page->show());
        $id       = $_SESSION['admin']['id'];
        $role     = M('admin')->field('id,role_id,cat_shop,user_id')->where("id=$id")->find();
        if($role['role_id']!=-1&&$role['role_id']!=5){
            if($role['role_id']=1||$role['role_id']=6){
                $wherea=array();
                $wherea['cate_shop']=$role['cat_shop'];
                $admin_user=M('admin')->field('id,role_id,cat_shop,user_id')->where($wherea)->select();
                $ad_user='';
                foreach($admin_user as $k=>$v){
                    $ad_user.=$v['user_id'].',';
                }
                $ad_user=rtrim($ad_user,',');
                $where['p_id']=array('in',$ad_user);
            }elseif ($role['role_id']=2||$role['role_id']=3||$role['role_id']=4){
                $where['p_id']=$role['user_id'];
            }
            $where['p_cat_shop']=$role['cat_shop'];
        }
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