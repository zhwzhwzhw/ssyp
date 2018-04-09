<?php
namespace Api\Controller;
use Think\Controller;
class OrderController extends Controller {
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
     	echo $_GET['callback'].'('.json_encode($arr).')';
    	
		
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
		echo $_GET['callback'].'('.json_encode(['ord'=>$data,'pro'=>$list]).')';
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
	//我的订单
    public function mineOrder(){
        $param                = I('param.');
        $type                 = $param['type'];
        if($type){
            $where['status'] = $type;
        }
        $user_id              = $param['user_id'];
        $where['pub_user']   = $user_id;
        $orderList            = M('orders')->where($where)->select();
        foreach($orderList as $k=>$v){
            $proList          = M('ordpro')->field('pro_id')->where("ord_id=".$v['id'])->select();
            $product=array();
            foreach($proList as $key=>$val){
                $productList  = M('product')->field('id,name,wx_image')->where("id=".$val['pro_id'])->find();
                $product[]    = $productList;
            }
            $orderList[$k]['product'] = $product;
        }
        echo json_encode($orderList);
    }
    //生成订单
    public function order(){
        $param        = I('param.');
        $user_id      = $param['user_id'];
        $order_money  = $param['order_money'];
        $data         = $param['data'];
        $order_number = date('YmdHi').$this->todayCount();
        $_data                    = array();
        $_data['ord_money']      = $order_money;
        $_data['pub_user']       = $user_id;
        $_data['pub_time']       = NOW_TIME;
        $_data['bh']              = $order_number;
        $_data['comment']         = $param['comment'];
        $_data['custom_name']    = $param['custom_name'];
        $_data['custom_phone']   = $param['custom_phone'];
        $_data['custom_mail']    = $param['custom_mail'];
        $_data['address']         = $param['address'];
        $re = M('orders')->data($_data)->add();
        if($re){
            foreach($data as $k=>$v){
                $orddata  = array();
                $orddata['ord_id']     = $re;
                $orddata['pro_id']     = $v['pro_id'];
                $orddata['norms_id']   = $v['norms_id'];
                $orddata['ord_number'] = $v['number'];
                 M('ordpro')->data($orddata)->add();
                 $res=M('norms')->where("id=".$v['norms_id'])->setDec("cost_norms",$v['number']);
				if($res){
					M('norms')->where("id=".$v['pro_id'])->setDec("pro_number",$v['number']);
					$arr = ['status'=>1,'msg'=>'提交订单成功','order'=>$order_number];
				}else{
					$arr = ['status'=>0,'msg'=>'提交订单失败'];
				}
            }
        }else{
			$arr = ['status'=>0,'msg'=>'提交订单失败'];
		}
		echo json_encode($arr);
    }
    //订单支付
    function payOrder(){
        $param        = I('param.');
        $orderId      = $param['orderId'];
        $body         = $param['body'];
        $amount       = $param['amount'];
        $notify_url = $this->response->responseHost().'/mobile/wxpay/tradeNotify';//回调地址
        $wx_pay     = new App_Plugin_Weixin_NewPay($this->shop['s_id']);
        $tid        = $orderId."native";//拼接native,避免商户订单号重复
        $ret        = $this->unifiedNativeOrder($order[0]['to_g_id'], $body, $tid, $amount, $notify_url, $other);
    }
    /**
     * 微信NATIVE方式统一下单支付接口
     * @param string $pid  商品ID
     * @param string $body 商品描述，必填
     * @param string $tid 商户系统内部的订单号
     * @param float  $amount 支付总金额，单位元
     * @param string $notify_url 通知回调地址
     * @param array $other 其他辅助数据，例如array('attach')
     * @return array|int
     */
    public function unifiedNativeOrder($pid, $body, $tid, $amount, $notify_url, $other = array()) {
        if (!$this->has_ready) {
            Libs_Log_Logger::outputLog("微信支付未配置");
            return false;
        }
        $amount     = round($amount*100);//转化为分
        $body       = mb_strlen($body, 'UTF-8') > 40 ? mb_substr($body, 0, 40, 'UTF-8') : $body;
        $mch_id     = $this->wx_pay['wp_mchid'];//商户ID
        $mch_key    = $this->wx_pay['wp_mchkey'];//商户key
        $wx_appid   = $this->wx_pay['wp_appid'];//公众号ID

        $request_params = array(
            'appid'             => $wx_appid,//公众号ID
            'mch_id'            => $mch_id,//商户号
            'nonce_str'         => self::getNonceStr(24),
            'body'              => $body,
            'out_trade_no'      => $tid,//商户内部订单号
            'total_fee'         => $amount,//单位分
            'spbill_create_ip'  => plum_get_server('SERVER_ADDR'),
            'notify_url'        => $notify_url,
            'trade_type'        => 'NATIVE',
            'product_id'        => $pid,
        );
        $request_params = array_merge($request_params, $other);
        $sign   = self::makeWxpaySign($request_params, $mch_key);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $ret = self::postXmlCurl($xml, $this->unified_url);
            Libs_Log_Logger::outputLog($ret);
            $ret = $this->fromXml($ret);
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    return array(
                        'code'           => 0,
                        'appid'          => $ret['appid'],
                        'mch_id'         => $ret['mch_id'],
                        'trade_type'     => $ret['trade_type'],
                        'prepay_id'     => $ret['prepay_id'],
                        'app_key'       => $mch_key,
                        'code_url'      => $ret['code_url'],
                    );
                }
            } else {
                return 40004;
            }
        } else {
            return 40003;
        }
    }

    /**
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return string 产生的随机字符串
     */
    public static function getNonceStr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }

    /*
     * 生成签名
     * @param string $appkey 微信支付商户密钥
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public static function makeWxpaySign(array $fields, $appkey) {
        //签名步骤一：按字典序排序参数
        ksort($fields);
        $string = self::toUrlParams($fields);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".$appkey;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }
    /**
     * 输出xml字符
     * @throws WxPayException
     **/
    public static function toXml(array $values) {
        if(!is_array($values) || count($values) <= 0) {
            return false;
        }

        $xml = "<xml>";
        foreach ($values as $key=>$val) {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }
    /*
     * 以post方式提交xml到对应的接口url
     *
     * @param string $xml  需要post的xml数据
     * @param string $url  url
     * @param mixed $useCert 是否需要证书，默认不需要
     * @param int $second   url执行超时时间，默认30s
     * @throws WxPayException
     */
    private static function postXmlCurl($xml, $url, $useCert = false, $second = 30) {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);

        //如果有配置代理这里就设置代理
        /*
        if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
            && WxPayConfig::CURL_PROXY_PORT != 0){
            curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
            curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
        }
        */
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if($useCert !== false){
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, $useCert['ssl_cert']);
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, $useCert['ssl_key']);
        }
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            Libs_Log_Logger::outputLog("curl出错，错误码:$error");
            //小于10次的重试
            if (self::$curl_retry_times < 10) {
                Libs_Log_Logger::outputLog("curl出错，重试次数:".self::$curl_retry_times);
                self::$curl_retry_times++;
                self::postXmlCurl($xml, $url, $useCert, $second);
            } else {
                return false;
            }
        }
    }
    /*
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
    public static function fromXml($xml) {
        if(!$xml){
            return false;
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }
}




