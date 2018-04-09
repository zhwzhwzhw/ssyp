<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class CouponController extends BaseController{
	public function index(){
		$obj = M('coupon');
		$search = searchWhere(); 
		$where = $search['where'];
		$assign = $search['assign'];
		$this->assign('assign',$assign);
		$totalRows = $obj->where($where)->count('id');
		$Page = new \Think\Page($totalRows,20);
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$list = $obj->where($where)
			->limit($Page->firstRow,$Page->listRows)
			->order('id desc')
			->select();

		$pageStr = $Page->show();
		$this->assign('page',$pageStr);
		$this->assign('title','优惠券列表');
		$this->assign('lists',$list);
		$this->display();
	}
	
	/*
	 * 删除优惠券类型
	*/
	public function del_coupon(){
		//获取优惠券ID
		$cid = I('get.id');
		//查询是否存在优惠券
		$row = M('coupon')->where(array('id'=>$cid))->delete();
		if($row){
			//删除此类型下的优惠券
			M('coupon_list')->where(array('cid'=>$cid))->delete();
			$this->success("删除成功");
		}else{
			$this->error("删除失败");
		}
	}
	
	
	
	
	
	
	
	//新
	
	/*
	 * 添加编辑一个优惠券类型
	*/
	public function coupon_info(){
		if(IS_POST){
			$data = I('post.');
			$data['send_start_time'] = strtotime($data['send_start_time']);
			$data['send_end_time'] = strtotime($data['send_end_time']);
			$data['use_end_time'] = strtotime($data['use_end_time']);
			$data['use_start_time'] = strtotime($data['use_start_time']);
			if($data['send_start_time'] > $data['send_end_time']){
				$this->error('发放日期填写有误');
			}
			if(empty($data['id'])){
				$data['add_time'] = time();
				$row = M('coupon')->add($data);
			}else{
				$row =  M('coupon')->where(array('id'=>$data['id']))->save($data);
			}
			if(!$row)
				$this->error('编辑代金券失败');
			$this->success('编辑代金券成功',U('Admin/Coupon/index'));
			exit;
		}
		$cid = I('get.id');
		if($cid){
			$coupon = M('coupon')->where(array('id'=>$cid))->find();
			$this->assign('coupon',$coupon);
		}else{
			$def['send_start_time'] = strtotime("+1 day");
			$def['send_end_time'] = strtotime("+1 month");
			$def['use_start_time'] = strtotime("+1 day");
			$def['use_end_time'] = strtotime("+2 month");
			$this->assign('coupon',$def);
		}
		$this->display();
	}
	
	
	
	/*
	 * 优惠券详细查看
	*/
	public function coupon_list(){
		//获取优惠券ID
		$cid = I('get.id');
		//查询是否存在优惠券
		$check_coupon = M('coupon')->field('id,type')->where(array('id'=>$cid))->find();
		if(!$check_coupon['id'] > 0)
			$this->error('不存在该类型优惠券');
		 
		//查询该优惠券的列表的数量
		$sql = "SELECT count(1) as c FROM __PREFIX__coupon_list  l ".
				"LEFT JOIN __PREFIX__coupon c ON c.id = l.cid ". //联合优惠券表查询名称
				"LEFT JOIN __PREFIX__order o ON o.order_id = l.order_id ".     //联合订单表查询订单编号
				"LEFT JOIN __PREFIX__users u ON u.user_id = l.uid WHERE l.cid = ".$cid;    //联合用户表去查询用户名
	
		$count = M()->query($sql);
		$count = $count[0]['c'];
		$Page = new \Think\Page($count,10);
		$show = $Page->show();
	
		//查询该优惠券的列表
		$sql = "SELECT l.*,c.name,o.order_sn,u.nickname FROM __PREFIX__coupon_list  l ".
				"LEFT JOIN __PREFIX__coupon c ON c.id = l.cid ". //联合优惠券表查询名称
				"LEFT JOIN __PREFIX__order o ON o.order_id = l.order_id ".     //联合订单表查询订单编号
				"LEFT JOIN __PREFIX__users u ON u.user_id = l.uid WHERE l.cid = ".$cid.    //联合用户表去查询用户名
				" limit {$Page->firstRow} , {$Page->listRows}";
		$coupon_list = M()->query($sql);
		$this->assign('coupon_type',C('COUPON_TYPE'));
		$this->assign('type',$check_coupon['type']);
		$this->assign('lists',$coupon_list);
		$this->assign('page',$show);
		$this->display();
	}
	
	
	
	
	
	
	
	
	
}