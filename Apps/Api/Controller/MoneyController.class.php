<?php
namespace Api\Controller;
use Think\Controller;
class MoneyController extends Controller {
    public function apply(){
    	$param = I('param.');
    	$user_id = $param['user_id'];
    	$where = array(
    			'user_id'=>$user_id,
    			'pub_time'=>['gt',strtotime(date('Y-m-d'))]
    	);
    	$obj = M('money');
    	$count = $obj->where($where)->count('id');
    	$user = M('user')->field('score')->where('id="%s"',$user_id)->find();
    	$config = M('config')->find();
    	if($count >= $config['cash_time']){
    		echo $_GET['callback'].'('.json_encode(['status'=>0,'msg'=>'每天申请次数不能大于'.$config['cash_time'].'次']).')';
    		exit;
    	}
    	if($user['score'] <  $config['cash_money']){
    		echo $_GET['callback'].'('.json_encode(['status'=>0,'msg'=>'余额不足，允许提现金额为'.$config['cash_money'].'元/次']).')';
    		exit;
    	}else{
    		$_data = array(
    				'user_id'=>$user_id,
    				'money_reduce'=>$config['cash_money'],
    				'pub_time'=>NOW_TIME,
    				'status'=>1
    		);
    		$re = $obj->data($_data)->add();
    		if($re){
    			M('user')->where('id="%s"',$user_id)->setDec('score',$config['cash_money']);
    			echo $_GET['callback'].'('.json_encode(['status'=>1,'msg'=>'成功','money'=>$config['cash_money']]).')';
    			exit;
    		}else{
    			echo $_GET['callback'].'('.json_encode(['status'=>0,'msg'=>'操作失败']).')';
    			exit;
    		}
    	}
    	
    }
    

    
}




