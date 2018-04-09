<?php
namespace Api\Controller;
use Think\Controller;
class OrdController extends Controller {
    public function add(){
    	$param = I('param.');
    	$norms = $param['norms'];   //传入购物车结算信息
    	$user_id = $param['user_id'];
    	if(empty($user_id)){
    		echo $_GET['callback'].'('.json_encode(['status'=>0,'msg'=>'用户信息有误']).')';exit;
    	}
    	$ordpro = $this->ordpro($norms);
    	if(!$ordpro){
    		echo $_GET['callback'].'('.json_encode(['status'=>0,'msg'=>'商品没有选择']).')';exit;
    	}
    	$ordpro_data = $ordpro['data'];
    	$money = $ordpro['money'];
    	$_data['text'] = $ordpro['text'];
    	$_data['money_share'] = $ordpro['money_share'];
    	$_data['ord_money'] = $money;
    	$_data['pub_user'] = $user_id;
     	$_data['pub_time'] = NOW_TIME;
     	$_data['bh'] = date('YmdHi').$this->todayCount();
    	$ord = M('orders');
    	$last_id = $ord->data($_data)->add();
     	if($last_id){
     		$norms_o = M('norms');
     		$pro_o = M('product');
     		foreach ($ordpro_data as $k=>$v){
     			//$pro_data = $norms_o->field('pro_id')->where('id="%s"',$v['norms_id'])->find();
     			//$pro_o -> where('id="%s"',$pro_data['pro_id']) -> setDec('pro_number',$v['ord_number']);
     			//$norms_o ->where('id="%s"',$v['norms_id'])-> setDec('number_norms',$v['ord_number']);//减少库存
     			//$pro_o
     			$ordpro_data[$k]['ord_id'] = $last_id;
     		}
     		$re = M('ordpro')->addAll($ordpro_data);
     	}else{
     		$re = false;
     	}

     	if($re){
     		$arr = ['status'=>1,'msg'=>'下单成功','ord_id'=>$last_id];
     	}else{
     		$arr = ['status'=>0,'msg'=>'下单失败'];
     	}
     /*	echo $_GET['callback'].'('.json_encode($arr).')';*/
        echo json_encode($arr);
		
    }
    public function detail(){
    	$param = I('param.');
		$ord_id = $param['ord_id'];
		$obj = M('ordpro');
		$where = array(
				'ord_id'=>$ord_id
		);
		$data = M('orders')->where('id="%s"',$ord_id)->find();
		$list = $obj->alias('op')->field('op.*,pro_id,name,wx_image,n.*,symbol')
		->where('ord_id="%s"',$ord_id)
		->join(C('DB_PREFIX').'norms as n on n.id=norms_id')
		->join(C('DB_PREFIX').'product as p on p.id=n.pro_id')
		->select();
		/*echo $_GET['callback'].'('.json_encode(['ord'=>$data,'pro'=>$list]).')';*/
		echo json_encode($list);
    }
    public function save(){
    	//优惠券
    	$param = I('param.');
    	$score = $param['score'];
    	$ord_id = $param['ord_id'];
    	$_data['comment'] = $param['comment'];
    	$ad_id = $param['ad_id'];
    	$ord = M('orders')->field('pub_user,ord_money,money_share')->where('id="%s"',$ord_id)->find();
    	$user = M('user')->field('id,pid,score')->where('id="%s"',$ord['pub_user'])->find();
    	
    	$_data['ord_money'] = $ord['ord_money'];
    	$_data['money_share'] = json_encode(moneyShare($user['pid'],$ord['money_share'])); //////////////////优惠券会有问题
    	$_data['mail_price'] = 10.00;
    		
    	$ad_data = M('address')->where('id="%s"',$ad_id)->find();
    	if(empty($ad_data)){
    		echo $_GET['callback'].'('.json_encode(['status'=>0,'msg'=>'选择地址']).')';exit;
    	}
    	if($score == 1){
    		$dk_re = $ord['ord_money'] - $user['score'];  //抵扣
    		if($dk_re > 0){                          //积分不足 全部抵扣
    			$_data['ord_money'] = $dk_re;
    			$_data['score_money'] = $user['score'];
    		}else{
    			$floor = floor($ord['ord_money']);  
    			$l_re = $ord['ord_money'] - $floor   ; //留
    			if($l_re>0){      //小数点
    				$_data['ord_money'] = $l_re;
    				$_data['score_money'] = $floor;
    			}else{
    				$_data['ord_money'] = 1;
    				$_data['score_money'] = $ord['ord_money']-1;
    			}
    		}
    	}
    	$_data['custom_name'] = $ad_data['ad_name'];
    	$_data['custom_phone'] = $ad_data['ad_phone'];
    	$_data['custom_mail'] = $ad_data['ad_mail'];
    	$_data['address'] = $ad_data['address'];
    	$re =  M('orders')->where('id="%s"',$ord_id)->data($_data)->save();
    	if($re){
     		$arr = ['status'=>1,'msg'=>'下单成功'];
     	}else{
     		$arr = ['status'=>0,'msg'=>'下单失败'];
     	}
     	echo $_GET['callback'].'('.json_encode($arr).')';
    }
    //根据规格id和数量下单  //'ord_id'=>$ord_id,
	private function ordpro($_data){
		$pro_ids = array_keys($_data);
		if(empty($pro_ids))return false;
		$norms = M('product')->alias('p')
		->field('n.id,pro_norms,discount_norms,is_discount')
		->join(C('DB_PREFIX').'norms as n on pro_id = p.id')
		->where('n.id in ('.join(',', $pro_ids).')')
		->select(['index'=>'id']);
		$norms = getprice($norms);
		$money = $money_share = 0;
		$text = '';
		foreach($norms as $n_id=>$v){
			$money = $money + ($v['price_norms'] * $_data[$n_id]);  //money 该分销的金额
			if($v['is_discount'] != '1'){
				$money_share = $money_share + ($v['price_norms'] * $_data[$n_id]);  //money 该分销的金额
			}else{
				$text .= ( ( $text === '' ) ? '特贿商品规格id,' : ',' ) . $v['id'] ;
			}
			$addArr[] = array(
					'norms_id'=>$n_id,
					'ord_price'=>$v['price_norms'],
					'ord_number'=>$_data[$n_id]
			);
		}
		return ['data'=>$addArr,'money'=>$money,'text'=>$text,'money_share'=>$money_share];
	}
	public function index(){
		$param = I('param.');
		$user_id = $param['user_id'];
		$status = (int)$param['status'];
		$where['pub_user'] = $user_id ;
		if($status){
			$where['status'] = $status ? $status : 0;
		}
		if($param['team_id']){
			$where_1 = array(
					'money_share'=>array('like','%"one":{"u":"'.$param['team_id'].'"%'),
					'pub_user' => array('eq',$param['team_id']),
					'_logic' => 'OR'
			);
			$where = array(
					'_complex' => $where_1,
					'status'=>array('eq',9),
					'_logic' => 'AND'
			);
			
		}
		$ord = M('orders');
		if(empty($param['team_id'])){
			$totalRows = $ord->where($where)->count('id');
			$page = new \Think\Page($totalRows,10);
			$list = $ord->where($where)->order('id desc')->limit($page->firstRow,$page->listRows)->select();
		}else{
			$list = $ord->where($where)->order('id desc')->select();
		}

		$where_child = '';
		foreach ($list as $k=>$v){
			$where_child .= ( ( $where_child === '' ) ? '' : ',' ) . $v['id'] ;
		}
		if(!empty($where_child)){
			$obj = M('ordpro');
			$list_child = $obj->alias('op')->field('op.*,pro_id,name,wx_image,n.*,symbol')
			->where('ord_id in ('.$where_child.')')
			->join(C('DB_PREFIX').'norms as n on n.id=norms_id')
			->join(C('DB_PREFIX').'product as p on p.id=n.pro_id')
			->select();
			foreach ($list as $k=>$v){
				foreach ($list_child as $k_c => $v_c){
					if($v['id'] == $v_c['ord_id']){
						$list[$k]['product'][] =$v_c;
					}
				}
			}
		}
		
		echo $_GET['callback'].'('.json_encode($list).')';
		
		
	}
	
	
	
    public function del(){
    	$ord_id = I('param.ord_id');
    	if(empty($ord_id)){
    		echo $_GET['callback'].'('.json_encode(['status'=>0,'msg'=>'选择删除商品']).')';exit;
    	}
    	del_numAdd($ord_id);
    	$obj = M('orders');
    	$where = array(
    			'id'=>['eq',$ord_id],
    			'status'=>['eq',1]
    	);
    	$re = $obj->where($where)->delete();
    	if($re){
    		$re = M('ordpro')->where('ord_id="%s"',$ord_id)->delete();
    	}
    	if($re){
    		$arr = ['status'=>1,'msg'=>'删除成功'];
    	}else{
    		$arr = ['status'=>0,'msg'=>'删除失败'];
    	}
    	echo $_GET['callback'].'('.json_encode($arr).')';
    }
    public function todayCount(){
    	$obj = M('orders');
    	$where = array(
    		'pub_time'=>array('gt',strtotime(date('Y-m-d')))	
    	);
    	$num = $obj->where($where)->count('id');
    	
    	$bit = 5;//产生5位数的数字编号
    	$num_len = strlen($num);
    	$zero = '';
    	for($i=$num_len; $i<$bit; $i++){
    		$zero .= "0";
    	}
    	$real_num = "d".$zero.$num;
    	return $real_num;
    }
    function getMillisecond() {
		list($t1, $t2) = explode(' ', microtime());     
		return  (float)sprintf('%.0f', floatval($t1) * 10000);  
	}
	public function finish(){
		$param = I('param.');
		$ord_id = $param['ord_id'];
		$user_id = $param['user_id'];
		$obj = M('orders');
		$where = array(
				'id'=>['eq',$ord_id],
				'status'=>['eq',3],
				'pub_user'=>$user_id
		);
		$_data['status'] = 9;
		$_data['confirm_time'] = NOW_TIME;
		$re = $obj->where($where)->data($_data)->save();
		if($re){
			$arr = ['status'=>1,'msg'=>'操作成功'];
			sellerData($ord_id);
		}else{
			$arr = ['status'=>0,'msg'=>'操作失败'];
		}
		echo $_GET['callback'].'('.json_encode($arr).')';
	}
	
	//积分明细
	public function score(){
		$param = I('param.');
		$user_id = $param['user_id'] ;
		$where_1 = array(
				'pub_user' => ['eq',$user_id],
				'score_money' => ['gt',0],
		);
		$where = array(
				'_complex'=>$where_1,
				'money_share'=>array('like','%{"u":"'.$user_id.'"%'),
				'_logic'=>'OR'
		);
		$where = '((pub_user="'.$user_id.'") and (score_money>0)) OR ((money_share like \'%{"u":"'.$user_id.'"%\') or (status <> 1))';
		$obj = M('orders');
		$re = $obj->field('pub_time,money_share,pub_user,score_money')->where($where)->order('id desc')->select();
		$arr = [];
		foreach ($re as $k=>$v){
			$pub_time = date('Y-m-d H:i:s',$v['pub_time']);
			if($v['pub_user'] == $user_id){
				$score = $v['score_money'];
				$status = -1;
			}else{
				$status = 1;
				$score = $this->jsonToMoney($user_id,$v['money_share']);
			}
			$arr[] = array(
					'status'=>$status,
					'score'=>$score,
					'pub_time'=>$pub_time
			);
		}
		echo $_GET['callback'].'('.json_encode($arr).')';
	}
	private function jsonToMoney($user_id,$json){
		$o = json_decode($json);
		$m = 0;
		foreach ($o as $v){
			if($v->u == $user_id){
				$m = $v->m;
				break;
			}
		}
		return $m;
	}
}




