<?php


//把get来的数据 处理成where条件 和 模板赋值
//传入原始的 条件
function searchWhere($where_init=array()){
	$where = array();
	$assign = array();
	foreach ($_GET as $k=>$v){
		//格式 alias.field  写成 alias|field[e] = 表达式   alias|field[v] = 条件
		$k = str_replace('|', '.', $k);
		if(is_array($v)){
			if(is_null($v['e'])){
				$v['e'] = 'eq';
			}
			if($v['v'] === ''){
				continue;
			}
			if($v['call'] == 'strtotime'){
				$time_v = strtotime($v['v']);
				$time_v1 = strtotime($v['v1']);
				$time_v2 = strtotime($v['v2']);
			}
			if($v['e'] == 'like'){
				$v['v'] = preg_replace('/(\%|\.)/', '\\$1', $v['v']);
				$where[$k] = array('like','%'.$v['v'].'%');
			}else if($v['e'] == 'between'){
				if(!$time_v2)continue;   //第二个没穿 则直接跳过
				$time_v1 = $time_v1 ? $time_v1 : 0;
				$where[$k] = array('between',$time_v1.' , '.$time_v2);
				$assign[str_replace('.', '_', $k.'_where_1')] = $v['v1'];
				$assign[str_replace('.', '_', $k.'_where_2')] = $v['v2'];
			}else{
				$where[$k] = array($v['e'],$v['v']);
			}
			$assign[str_replace('.', '_', $k.'_where')] = $v['v'] ;
		}
	}
	foreach ($_GET as $k=>$v){
		if(is_array($v)){
			foreach ($v as $sk=>$sv){
				unset($_GET[$k]);
				$_GET[$k.'['.$sk.']'] = $sv;
			}
		}
	}
	
/*	return [
		'where'=>array_merge($where_init,$where),
		'assign'=>$assign
	];*/
}

function pay($data){
/* 	
	$_SESSION['pay']['money'];
	$_SESSION['pay']['payName'];
	$_SESSION['pay']['attach'];
	$_SESSION['pay']['title']
	
	$_SESSION['pay']['notify_url'];
	$_SESSION['pay']['ok_url']
	$_SESSION['pay']['err_url']
	 */
	$str = $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"] ;
	$data['notify_url'] = ( strpos($data['notify_url'], 'http://') === false ) ? $str . $data['notify_url'] : $data['notify_url'] ; //$str . $data['notify_url'];
	$data['ok_url'] = ( strpos($data['ok_url'], 'http://') === false ) ? $str . $data['ok_url'] : $data['ok_url'] ;//$str . $data['ok_url'];
	$data['err_url'] = ( strpos($data['err_url'], 'http://') === false ) ? $str . $data['err_url'] : $data['err_url'] ; //$str . $data['err_url'];
	$data['money'] = intval(100*$data['money']);
	session('pay',$data);
	//var_dump($data);exit;
	header('location:'.BASE_URL . 'Public/pay/example/jsapi.php');
}
function pay_notify($funName = null,$status = 1){
	//  		$getxml = '<xml><appid><![CDATA[wx7c4ca8d18b6d6735]]></appid>
	// 					<attach><![CDATA[12]]></attach>
	// 					<bank_type><![CDATA[CFT]]></bank_type>
	// 					<cash_fee><![CDATA[1]]></cash_fee>
	// 					<fee_type><![CDATA[CNY]]></fee_type>
	// 					<is_subscribe><![CDATA[N]]></is_subscribe>
	// 					<mch_id><![CDATA[1351058201]]></mch_id>
	// 					<nonce_str><![CDATA[x02qpqjgm2qop9d85p7k9otcxs05rt4c]]></nonce_str>
	// 					<openid><![CDATA[o6SNewOHf0bXMJc9vHQ5pO6as1uE]]></openid>
	// 					<out_trade_no><![CDATA[135105820120161104104337]]></out_trade_no>
	// 					<result_code><![CDATA[SUCCESS]]></result_code>
	// 					<return_code><![CDATA[SUCCESS]]></return_code>
	// 					<sign><![CDATA[F35951DA6983894A199966765A18CCA6]]></sign>
	// 					<time_end><![CDATA[20161104104343]]></time_end>
	// 					<total_fee>1</total_fee>
	// 					<trade_type><![CDATA[JSAPI]]></trade_type>
	// 					<transaction_id><![CDATA[4004842001201611048690848044]]></transaction_id>
	// 					</xml>';
	//$getxml = $GLOBALS['HTTP_RAW_POST_DATA'];
	$getxml = file_get_contents('php://input');
	$xmlObj = simplexml_load_string($getxml,'SimpleXMLElement',LIBXML_NOCDATA);
	$money = (string)$xmlObj->total_fee;
	$transaction_id = (string)$xmlObj->transaction_id;
	$payArr = array(
			'transaction_id'=>$transaction_id,
			'time_end'=>(string)$xmlObj->time_end,
			'attach'=>(string)$xmlObj->attach,
			'money'=>$money,
			'openid'=>(string)$xmlObj->openid,
			'status'=>1
	);
	/*if(!empty($funName)){
		$funName($payArr);
	}*/
	$obj = M('pay');
	$count = $obj -> where('transaction_id="%s"',$transaction_id) -> count('id');
	if($count){
		echo 'SUCCESS';exit;
	}
	$re = $obj->data($payArr)->add();
	/* $fh = fopen(ROOT.'aa.txt','a');
	$re = fwrite($fh,$getxml."1\n");
	fclose($fh); */
	if($re){
		echo 'SUCCESS';exit;
	}
}
//下面是支付的附加函数  预订支付
function order_change($payArr){
	$_data = array(
			'status'=>2 ,
			'pay_time' => NOW_TIME
	);   //2等待发货
	if(!empty($payArr['attach'])){
		$ord = M('orders');
		$data = $ord->field('status,pub_user,score_money')->where('id="%s"',$payArr['attach'])->find();
		if($data['status'] == '1'){
			M('user')->where('id="%s"',$data['pub_user'])->setDec('score',$data['score_money']);
			$ord->where('id="%s"',$payArr['attach'])->data($_data)->save();
			
			// 改变库存
			$op = M('ordpro');
			$norms_o = M('norms');
			$pro_o = M('product');
			$ordpro_data = $op -> where('ord_id="%s"',$payArr['attach']) ->select();
			foreach ($ordpro_data as $k=>$v){
				$pro_data = $norms_o->field('pro_id')->where('id="%s"',$v['norms_id'])->find();
				$pro_o -> where('id="%s"',$pro_data['pro_id']) -> setDec('pro_number',$v['ord_number']);
				$norms_o ->where('id="%s"',$v['norms_id'])-> setDec('number_norms',$v['ord_number']);//减少库存
				
			}
			// 改变库存结束
		}
		
	}
}
//订单更新 分销商数据
function sellerData($orders_id){
	$orders = M('orders');
	$data = $orders->field('money_share,status')->where('id="%s"',$orders_id)->find();
// 	if($data['status'] != '2'){
// 		return false;
// 	}
	$money_share = json_decode($data['money_share']);
	if(!$money_share){
		return false;
	}
	$user = M('user');
	$share = $money_share->c->m +$money_share->p->m;
	foreach ($money_share as $v){
		$where = array('id'=>$v->u);
		$user->where($where)->setInc('score',$v->m);
	}
}


function substrs($str,$start,$length,$content = '...'){
	$newstr = mb_substr($str, $start, $length,'utf-8');
	if(mb_strlen($str , 'utf-8')>$length){
		$newstr = mb_substr($str, $start, $length,'utf-8');
		$newstr = $newstr.$content;
		return $newstr;
	}else{
		return $str;
	}
}

	

//二维码 //参数：定义生成内容
function getTicket($content,$size=4){
	//引入生成二维码类
	import("Org.Net.PhpQrcode");
	$obj=new \QRcode();
	//定义纠错级别
	$errorLevel = "L";
	//定义生成图片宽度和高度;默认为3
	//$size = "4";
	//调用QRcode类的静态方法png生成二维码图片//
	$obj->png($content, false, $errorLevel, $size);
	//生成网址类型
	// 	$url="http://jingyan.baidu.com/article/48a42057bff0d2a925250464.html";
	// 	$url.="\r\n";
	// 	$url.="http://jingyan.baidu.com/article/acf728fd22fae8f8e510a3d6.html";
	// 	$url.="\r\n";
	// 	$url.="http://jingyan.baidu.com/article/92255446953d53851648f412.html";
	// 	$obj->png($url, false, $errorLevel, $size);
}

function headimgurlChange($headimgurl,$num=46){
	$size = array(0,46,64,96,132);
	if(!in_array($num, $size)){
		$num = 46;
	}
	$tmp = explode('/', $headimgurl);
	array_pop($tmp);
	$tmp[] = $num;
	
	return join('/',$tmp);
}

//判断是否属手机
function is_mobile(){
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $mobile_agents = Array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte");
    $is_mobile = 0;
    foreach ($mobile_agents as $device) {//这里把值遍历一遍，用于查找是否有上述字符串出现过
        if (stristr($user_agent, $device)) { //stristr 查找访客端信息是否在上述数组中，不存在即为PC端。
            $is_mobile = true;
            break;
        }
    }
    return $is_mobile;
}

function curl_post($url,$data)
{
	$ch = curl_init ();
	// print_r($ch);
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	curl_setopt ( $ch, CURLOPT_HEADER, 0 );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
	$return = curl_exec ( $ch );
	curl_close ( $ch );
	return $return;
}
/**
 * 
 * @param int $pid  上级id
 * @param number $money 分销金额
 * @return string|boolean|Ambigous <multitype:, unknown, number>
 */
function moneyShare($pid,$money){
	$config = M('config')->find();
	$money_1 = (int)($config['s_one'] * $money);
	$money_2 = (int)($config['s_two'] * $money);
	if($config['is_discount'] == 1){
		return '全场特价';
	}
	if($config['is_share'] != '1'){
		return '分销关闭';
	}
	if($pid == 0){
		return '企业直属';
	}

	$re['one'] = array(
			'u'=>$pid,
			'm'=>$money_1
	);
	
	$usr = M('user');
	$ppu = $usr->field('id')->where('id="%s"',$pid)->find(); //p级
	if(empty($ppu) || $ppu['id'] == $pid){  //个分
		return $re;
	}
	$re['two'] = array(
			'u'=>$ppu['id'],
			'm'=>$money_2
	);
	return $re;
}
function getprice($list){
	$config = M('config')->find();
	foreach ($list as $k=>$v){
		if($config['is_discount'] == 1 || $v['is_discount'] == 1){
			$list[$k]['price_show'] = $v['discount_price'];
			$list[$k]['price_norms'] = $v['discount_norms'];
			$data['is_discount'] = 1;
		}else{
			$list[$k]['price_show'] = $v['pro_price'];
			$list[$k]['price_norms'] = $v['pro_norms'];
		}
	}
	return $list;
}
// 1 wei shu zu 
function getprice_1($data){
	$config = M('config')->find();
	if($config['is_discount'] == 1 || $data['is_discount'] == 1){
		$data['price_show'] = $data['discount_price'];
		$data['price_norms'] = $data['discount_norms'];
		$data['is_discount'] = 1;
	}else{
		$data['price_show'] = $data['pro_price'];
		$data['price_norms'] = $data['pro_norms'];
	}
	return $data;
}


function getExtName($filename){
	$arr = explode('.', $filename);
	return array_pop($arr);
}




/**
 * 
 * @param unknown $time
 * 返回距离当前时间的绝对值
 */
function timeDown($time){
	$now = time();
	$sn = abs($time - $now);//second number
	if($sn >3600){  // 大于1小时
		$str = floor($sn/(3600)).':'.addzeor(floor(($sn%3600)/(60))).':'.addzeor($sn%60);
	}elseif($sn <= 3600 && $sn > 60){    //分钟
		$str = '00:'.addzeor(floor($sn/(60))).':'.addzeor($sn%60);
	}elseif($sn<60){
		$str = '00:00:'.addzeor($sn);
	}
	return $str;
}
function addzeor($num){
	if($num < 10){
		return '0'.$num;
	}else{
		return $num;
	}
}
//微信时间转化成标准格式
function date_wx($str){
	$time='';
	for($i=0;$i<strlen($str);$i++){
		$time .= $str{$i};
		if($i==3 || $i==5){
			$time .='-';
		}elseif ($i==7){
			$time .=' ';
		}elseif($i==9 || $i==11){
			$time .=':';
		}
	}
	return  $time;
}
//希格斯
function idToName($idstr){
	$str = trim($idstr,'>');
	$str = str_replace('>', ',', $str);
	if(empty($str)){
		return false;
	}
	$list = M('category')->where('id in ('.$str.')')->select();
	$re = '';
	foreach ($list as $k=>$v){
		$re .= ($re==='' ? '' : '>').$v['c_name'];
	}
	return $re;
}
function getChildType($fid = '',$status='1' ,$ids = null){
	if($fid === ''){
		$fid = (int)$_GET['fid'];
	}
	$obj = M('category');
	$where = array(
        'fid'=>$fid,
        'c_status'=>$status
    );
	if(!is_null($ids)){
		$where['id']=array('in',$ids);
	}
	$typeArr = $obj->field('id,c_name')->where($where)->select();
	//echo $obj->_sql();
	return $typeArr;
}
//必须有 is_discount,discount_norms,pro_norms , pro_price


//希格斯专属结束

//删除商品后最加产品
function del_numAdd($ord_id){
	return;
	$obj = M('ordpro');
	$list = $obj->field('ord_number,pro_id,norms_id')
	->alias('o')
	->where('ord_id="%s"',$ord_id)
	->join(C('DB_PREFIX').'norms as n on n.id = norms_id')
	->join(C('DB_PREFIX').'product as p on n.pro_id = p.id')
	->select();
	
	$norms = M('norms');
	$product = M('product');
	foreach ($list as $v){
		$norms -> where('id="%s"',$v['norms_id'])->setInc('number_norms',$v['ord_number']);
		$product->where('id="%s"',$v['pro_id'])->setInc('pro_number',$v['ord_number']);
	}
}








