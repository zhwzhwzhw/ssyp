<?php
namespace Home\Controller;
use Think\Controller;
class PayController extends Controller {
	public function pay(){
		$param = I('param.');
		$ord_id = $param['ord_id'];
		$where = array('id'=>$ord_id);
		$order = M('orders')->field('ord_money')->where($where)->find();
		$data = array(
				'notify_url'=>U('Pay/order_pay_notify'),
				'ok_url'=>$param['ok_url'],
				'err_url'=>$param['err_url'],
				'title'=>'希格斯-订单支付',
				'payName'=>'希格斯-订单支付',
				'money'=>$order['ord_money']+10,
				'attach'=>$ord_id
		);
		pay($data);
	}
	public function order_pay_notify(){
		$funName = 'order_change';
		pay_notify($funName);
		//积分处理  底单处理
	}
}