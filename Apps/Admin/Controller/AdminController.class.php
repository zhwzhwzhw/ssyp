<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class AdminController extends BaseController {
    public function index(){
		$obj = M('Admin');
		$list = $obj->field('a.id,phone,seller_name,realname,role_name,role_id,cat_shop')
		->alias('a')
		->join('__ROLE__ as r on r.id = role_id','left')
		->join('__SELLER__ as s on s.id = cat_shop','left')
        ->where('deleted!=1')
		->select();
		$this->assign('list',$list);
		$this->display();
    }
    public function add(){
        $param          = I('param.');
        $useid          = $param['id'];
        $nickName       = $param['nickName'];
        print_r($param);
        if($nickName&&$useid){
            $this->assign('nickName',$nickName);
            $this->assign('useid',$useid);
        }else{
            $this->assign('useid',0);
        }
    	$this->assign('role',M('role')->select());
    	$list = M('seller')->select();
    	$this->assign('shop_list',$list);
    	$this->assign('title','添加管理员');
    	$this->display('add');
    }
    public function update(){
    	$data = M('admin')->where('id="%s"',(int)$_GET['id'])->find();
    	
    	$this->assign('data',$data);
    	$this->add();
    }
    public function del(){
        $data=array(
            'deleted'=>1
        );
        $re = M('admin')->where('id="%s"',(int)$_GET['id'])->data($data)->save();
        if($re){
            $this->success('操作成功',U('index'));
        }else{
            $this->error('操作失败');
        }
    }
    public function shop_add(){
    	$obj = M('seller');
    	$id = (int)I('id');
    	if(IS_POST){
    		$_data = I('post.');
    		$_data['cat_list'] = join(',', $_POST['cat']);
    		if(empty($_data['seller_name']))$this->error('名称不能为空');
    		if($id){
    			$re = $obj->where('id="%s"',$id)->data($_data)->save();
    		}else{
    			$re = $obj->data($_data)->add();
    		}
    		
    		if($re){
    			$this->success('添加成功',U('shop'));
    		}else{
    			$this->error('添加失败');
    		}
    		exit;
    	}
    	if($id){
    		$data = $obj->where('id="%s"',$id)->find();
    		$this->assign('cat',explode(',', $data['cat_list']));
    		$this->assign('data',$data);
    	}

    	$this->assign('category',getChildType(0));
    	$this->display();
    	
    }
    //店铺管理
    public function shop(){
    	$obj = M('seller');
    	
    	if($_GET['del']=='del' && !empty($_GET['id'])){
    		$count = M('admin')->where('cat_shop="%s"',(int)$_GET['id'])->count('id');
    		if($count){
    			$this->error('该店铺下有用户，不可以删除');exit;
    		}
    		$re = $obj->where(['id'=>(int)$_GET['id']])->delete();
    		if($re){
    			$this->success('删除成功');
    		}else{
    			$this->error('删除失败');
    		}
    		exit;
    	}
    	$list = $obj->where([])->select();
    	$this->assign('list',$list);
    	$this->display();
    }
	public function save(){
		$obj = D('admin');
		$_data = I('post.');
		$id = $_data['id'];unset($_data['id']);
		if(empty($id)){
			$_data['password'] = md5(C('DEF_PWD'));
			$_data['cat_shop'] = $_SESSION['admin']['cat_shop'] ;
		}
		else{
			$admin = $obj->field('phone')->where('id="%s"',$id)->find();
			if($_data['phone'] == $admin['phone']){
				unset($_data['phone']);
			}
		}
		if($obj->create($_data)){
			if($id){
				$re = $obj->where('id="%s"',$id)->save();
			}else{
				$re = $obj->add();
			}
		}else{
			$this->error($obj->getError());
		}
		if($re){
			$this->success('操作成功',U('index'));
		}else{
			$this->error('操作失败');
		}
	}
	public function selfMsg(){
		$id = $_SESSION['admin']['id'];
		$obj = M('admin');
		$data = $obj->where('id="%s"',$id)->find();
		$this->assign('data',$data);
		$this->display();
	}
	public function re_pwd(){
		$obj = M('admin');
		$_data = I('post.');
		foreach ($_data as $k=>$v){
			$_data[$k] = trim($v);
		}
		$id = $_SESSION['admin']['id'];
		$where = array('id'=>$id);
		$data = $obj->field('password')->where($where)->find();
		if(md5($_data['old_password']) != $data['password']){
			$this->error('原密码输入错误');
		}
		if($_data['password'] != $_data['re_password'] ){
			$this->error('俩次密码输入不一致');
		}
		$re = $obj->where($where)->data(['password'=>md5($_data['password'])])->save();
		if($re)
			$this->success('修改成功');
		
		else
			$this->error('修改失败');
	}
    public function re_name(){
        $obj = M('admin');
        $_data = I('post.');
        foreach ($_data as $k=>$v){
            $_data[$k] = trim($v);
        }
        $id = $_SESSION['admin']['id'];
        $where = array('id'=>$id);
        $data = $obj->where($where)->find();
        if($data){
            $re = $obj->where($where)->data(['realname'=>$_data['realname']])->save();
        }
        if($re)
            $this->success('修改成功');

        else
            $this->error('修改失败');
    }
	
	
}