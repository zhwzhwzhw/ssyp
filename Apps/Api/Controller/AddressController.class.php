<?php
namespace Api\Controller;
use Think\Controller;
class AddressController extends Controller {
	public function index(){
		//user_id
		$user_id = I('param.user_id');
		$obj = M('address');
		$list = $obj->where('user_id="%s"',$user_id)->select();
		echo $_GET['callback'].'('.json_encode($list).')';
	}
    public function save(){
    	$param = I('param.');
    	$obj = M('address');
    	if(empty($param))exit('数据为空');
    	if($param['id']){
    		$re = $obj->where('id="%s"',$param['id'])->data($param)->save();
    	}else{
    		$user = M('user');
    		$msg = $user->field('phone')->where('id="%s"',$param['user_id'])->find();
    		if(empty($msg['phone'])){
    			$_data = array(
    					'realname'=>$param['ad_name'],
    					'phone'=>$param['ad_phone']
    			);
    			$user->data($_data)->where('id="%s"',$param['user_id'])->save();
    		}
    		$re = $obj->data($param)->add();
    	}
    	if($re){
    		$arr = ['msg'=>'添加成功','status'=>1];
    	}else{
    		$arr = ['msg'=>'添加失败','status'=>0];
    	}
    	echo $_GET['callback'].'('.json_encode($arr).')';
    }
	public function setDef(){
		$user_id = I('param.user_id');
		$id = I('param.id');
		$obj = M('address');
		$obj->where('user_id="%s"',$user_id)->data(['status'=>2])->save();
		$re = $obj->where('id="%s"',$id)->data(['status'=>1])->save();
		if($re){
			$arr = ['msg'=>'操作成功','status'=>1];
		}else{
			$arr = ['msg'=>'操作失败','status'=>0];
		}
		echo $_GET['callback'].'('.json_encode($arr).')';
	}
    public function del(){
        $id = I('param.id');
        $obj = M('address');
        $re = $obj->where('id="%s"',$id)->delete();
        if($re){
            $arr = ['msg'=>'操作成功','status'=>1];
        }else{
            $arr = ['msg'=>'操作失败','status'=>0];
        }
        echo $_GET['callback'].'('.json_encode($arr).')';
    }

    
}




