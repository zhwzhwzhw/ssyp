<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class MoneyController extends BaseController {
	public function index(){
		$obj = M('pay');
		$where['status'] = 1;
		$totalRows = $obj->where($where)->count('id');
		$Page = new \Think\Page($totalRows,20);
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$list = $obj->where($where)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$pageStr = $Page->show();
		$this->assign('page',$pageStr);
		$this->assign('list',$list);
		$this->assign('title','财务管理');
		$this->display();
	}
	/*public function supply(){
		
		$pro = M('product');
		$supply = $pro->group('supply')->select();
		$where_init = array(
				'o.status'=>array('neq','1')
		);
		$search = searchWhere($where_init);
		$where = $search['where'];
		$totalRows = $pro->alias('p')
			->join(C('DB_PREFIX').'norms as n on p.id = pro_id ')
			->join(C('DB_PREFIX').'ordpro as op on op.norms_id = n.id')
			->join(C('DB_PREFIX').'orders as o on o.id = op.ord_id')
			->group('p.id')
			->where($where)
			->select();
		$totalRows = count($totalRows);
		$Page = new \Think\Page($totalRows,20);
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$list = $pro->field('supply,symbol,pro_price,cost_price,discount_price,sum(ord_number) as ord_number,sum(ord_price*ord_number) as sell_money')
			->alias('p')
			->join(C('DB_PREFIX').'norms as n on p.id = pro_id ')
			->join(C('DB_PREFIX').'ordpro as op on op.norms_id = n.id')
			->join(C('DB_PREFIX').'orders as o on o.id = op.ord_id')
			->group('p.id')
			->where($where)
			->limit($Page->firstRow,$Page->listRows)
			->select();
		//小计
		$xj = $pro->field('supply,symbol,pro_price,cost_price,discount_price,sum(ord_number) as ord_number,sum(ord_price*ord_number) as sell_money')
			->alias('p')
			->join(C('DB_PREFIX').'norms as n on p.id = pro_id ')
			->join(C('DB_PREFIX').'ordpro as op on op.norms_id = n.id')
			->join(C('DB_PREFIX').'orders as o on o.id = op.ord_id')
			->group('p.id')
			->where($where)
			->select();
		$xj_ = array(
				'num'=>0,
				'sell'=>0,
				'cost'=>0
		);
		foreach ($xj as $v){
			$xj_['num'] += $v['ord_number'];
			$xj_['sell'] += $v['sell_money'];
			$xj_['cost'] += $v['cost_price'];
		}
		$this->assign('xj',$xj_);
		$this->assign('page',$Page->show());
		$this->assign('list',$list);
		$this->display();
	}*/
	public function applyCash(){
		$obj = M('money');
		$list = $obj
		->field('m.*,realname,phone,headimgurl,nickname')
		->alias('m')
		->join(C('DB_PREFIX').'user as u on u.id=user_id')
		->select();
		$this->assign('list',$list);
		$this->assign('title','提现管理');
		$this->display();
	}
	/*public function qy_pay(){
	    $id = I('post.id');
	    $data = M('money')
    	    ->field('m.*,u.openid,realname')
    	    ->alias('m')
    	    ->join(C('DB_PREFIX').'user as u on u.id = m.user_id','left')
    	    ->where('m.id="%s"',$id)
    	    ->find();
	    if($data['status'] != 1){
	        $this->error('错误！ 刷新网页重试');
	    }
	    
	    $pay_money = (int)($data['money_reduce'] * 100);
	    $obj = new \Org\Wechat\QyPay();//money_reduce
	    $re = $obj->pay($pay_money, $data['openid'],  $id, $data['realname'], '希格斯积分提现');
	    if($re === true){
	        M('money')->where('id="%s"',$id)->data(['status'=>9])->save();
	        M('seller')->where('user_id="%s"',$data['user_id'])->setDec('money',$data['money_reduce']);
	        $pay_data = array(
	            'transaction_id'=>"提现金额：{$data['money_reduce']};提现前金额：{{$data['money']}}",
	            'time_end'=>NOW_TIME,
	            'attach'=>$id,
	            'money'=>$pay_money,
	            'openid'=>$data['opneid'],
	            'status'=>1
	        );
	        M('pay')->data($pay_data)->save();
	        $this->success('操作成功');
	    }else{
	        $this->error($re);
	    }
	}*/
	
}