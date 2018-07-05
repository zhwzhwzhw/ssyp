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
        if($param['nickname']){
            $where['nickname']  = array('like',"%".$param['nickname']."%");
            $this->assign('nickname',$param['nickname']);
        }
        if($param['phone']) {
            $where['custum_phone']     = $param['phone'];
            $this->assign('phone',$param['phone']);
        }

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
		$list = $obj->where($where)
			    	->order('id desc')
			    	->limit($Page->firstRow,$Page->listRows)
			    	->select();
        $group = M('group')->field('id,name')->select();
        $this->assign('group',$group);
		$this->assign('score',$obj->sum('score'));
		$this->assign('cash',M('money')->where('status="%s"',1)->sum('money_reduce'));
		$this->assign('list',$list);
		$this->assign('title','会员信息');
        $this->display();
    }

    /**
     * 任务列表
     */
   public function task(){
       $param  = I('param.');
       $where  = array();
       $where['t_user_id']=$param['user_id'];
       /*$where['t_user_id']=0;*/
       $totalRows = M('task')->where($where)->count('t_id');
       $Page      = new \Think\Page($totalRows,20);
       $Page->setConfig('prev','上一页');
       $Page->setConfig('next','下一页');
       $this->assign('page',$Page->show());
       $task=M('task')->where($where)->limit($Page->firstRow,$Page->listRows)->select();
       foreach ($task as $k=>$v){
           $task[$k]['content']=json_decode($v['t_task'],true);
       }
       $this->assign('user_id',$param['user_id']);
       $this->assign('task',$task);
       $this->assign('title','任务管理');
        $this->display();
   }

    /**
     * 添加任务
     */
   public function addtask(){
       $param = I('param.');
       if($param['id']){
           $where=array();
           $where['t_id']=$param['id'];
           $task=M('task')->where($where)->find();
           $task['t_date_start']=date('Y-m-d',$task['t_date_start']);
           $task['t_date_end']=date('Y-m-d',$task['t_date_end']);
           $this->assign('task',$task);
           $content=json_decode($task['t_task'],true);
           $this->assign('content',$content);
       }
       $this->assign('userid',$param['userid']);
       $this->display();
   }
    /**
     * 保存任务
     */
    public function savetask(){
       $param = I('param.');
       $user=M('user')->field('realname,id')->where('id='.$param['userid'])->find();
       $data  = array(
             't_user_id'    => $param['userid'],
             't_username'   => $user['realname'],
             't_date_start' => strtotime($param['time_start']),
             't_date_end'   => strtotime($param['time_end']),
       );
       $arr  = array();
       foreach ($param['task_name'] as $k=>$v){
           $arr[$k]=array(
               'name'=>$v,
               'time_start'=>$param['start'][$k],
               'time_end'=>$param['end'][$k],
           );
       }
       $data['t_task']=json_encode($arr);
       if($param['id']){
           $re     = M('task')->where('t_id='.$param['id'])->save($data);
       }else{
           $re     = M('task')->add($data);
       }
        if($re){
            $this->success('上传成功',U('task',array('user_id'=>$param['userid'])));
        }else{
            $this->error('保存失败，请刷新重试');
        }
    }
    /**
     * 删除任务
     */
    public function deltask(){
        $param = I('param.');
        $re     = M('task')->where('t_id='.$param['id'])->delete();
        if($re){
            $this->success('删除成功',U('task',array('user_id'=>$param['userid'])));
        }else{
            $this->error('删除失败，请刷新重试');
        }
    }
    /**
     * 任务列表
     */
    public function clock(){
        $param  = I('param.');
        $where  = array();
        $where['user_id']=$param['userid'];
        $where['t_id']=$param['id'];
        $totalRows = M('clock')->where($where)->count('id');
        $Page      = new \Think\Page($totalRows,20);
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $this->assign('page',$Page->show());
        $clock=M('clock')->where($where)->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('user_id',$param['userid']);
        $this->assign('clock',$clock);
        $this->assign('title','任务管理');
        $this->display();
    }
    /**
     * 任务列表
     */
    public function group(){
        $param  = I('param.');
        $totalRows = M('group')->count('id');
        $Page      = new \Think\Page($totalRows,20);
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $this->assign('page',$Page->show());
        $group=M('group')->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('group',$group);
        $this->display();
    }
    /**
     * 添加分组
     */
    public function addgroup(){
        $param=I('param.');
        $data=array(
            'name'=>$param['group'],
            'time'=>time(),
        );
        if($param['id']){
            $re=M('group')->where('id='.$param['id'])->save($data);
        }else{
            $re=M('group')->add($data);
        }
        if($re){
            $this->success('成功','group');
        }else{
            $this->error('失败，请刷新重试');
        }
    }
    /**
     *删除分组
     */
    public function delgroup(){
        $param  = I('param.');
        $re   = M('group')->where('id='.$param['id'])->delete();
        if($re){
            $this->success('成功','group');
        }else{
            $this->error('失败');
        }
    }
    /**
     * 用户分组
     */
    public function usergroup(){
        $param=I('param.');
        $data=array(
            'group_id'=>$param['group'],
        );
        if($param['id']){
            $re=M('user')->where('id='.$param['id'])->save($data);
        }
        if($re){
            $this->success('成功','index');
        }else{
            $this->error('失败，请刷新重试');
        }
    }
    /**
     *分组用户
     */
    public function groupuser(){
        $param  = I('param.');
        $totalRows = M('user')->where('group_id='.$param['id'])->count('id');
        $Page      = new \Think\Page($totalRows,20);
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $this->assign('page',$Page->show());
        $user   = M('user')->field('realname,id,phone,group_id')->where('group_id='.$param['id'])->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('user',$user);
        $this->display();
    }
    /**
     *删除分组用户
     */
    public function delgroupuser(){
        $param  = I('param.');
        $data=array(
            'group_id'=>0,
        );
        $re   = M('user')->where('id='.$param['id'])->save($data);
        if($re){
            $this->success('成功',U('groupuser',array('id'=>$param['group_id'])));
        }else{
            $this->error('失败');
        }
    }
    /**
     * 站内消息
     */
    public function info(){
        $param=I('param.');
        $where=array(
            'group_id'=>$param['id'],
        );
        $info=M('info')->where($where)->select();
        $this->assign('info',$info);
        $this->assign('group_id',$param['id']);
        $this->display();
    }
    /**
     * 站内消息
     */
    public function addinfo(){
        $param=I('param.');
        $where=array(
            'group_id'=>$param['group_id'],
        );
        $info=M('info')->where($where)->select();
        $this->assign('info',$info);
        $this->assign('group_id',$param['group_id']);
        $this->display();
    }
    /**
     * 添加站内信息
     */
    public function  saveinfo(){
        $param=I('param.');
        $data=array(
            'group_id'=>$param['group_id'],
            'title'   => $param['title'],
            'content' => $param['content'],
            'add_time'=> time(),
        );
        $re=M('info')->add($data);
        if($re){
            $this->success('成功','info');
        }else{
            $this->error('失败');
        }

    }
}