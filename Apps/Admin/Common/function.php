<?php





//产品任务 自动背景色判断
function taskIsShow($s){
	if($s < 1 && ACTION_NAME != 'add'){
		return  'style="background:#f1f1f1"';
	}
	//<if condition='$data["task_peicai"]["s"] lt 1 and ($Think.const.ACTION_NAME neq "add")'>style="background:#f1f1f1"</if>
}

function mail_code($str,$key){
	$arr = explode('|', $str);
	return $arr[$key];
}


//提交分类时候需要用到的
function typeToStr($arr){
	$arr_1 = $arr;
	$lastid_1 = array_pop($arr_1);
	if($lastid_1<=0){
		$arr = $arr_1;
	}
	$str = join('>', $arr);
	if(!empty($str)){
		$str = '>'.$str.'>';
	}
	$lastid = array_pop($arr);
	$lastid = $lastid ? $lastid : 0 ;
	return [$str,$lastid];
}
 
/**
 * 分类列表递归函数 
 * @param array $type 二维数组
 * @param number $fid
 * @param number $s
 * fid字段
 */
function typeList($type,$fid=0,$s=0,$re = []){
	$tmp = $type;
	$s++;
	foreach ($tmp as $k=>$v){
		if($v['fid'] == $fid){
			$re[] = $v;
			$type[$k]['s'] = $s;   //$type  在参数中
			$type = typeList($type,$v['id'],$s);
		}
	}
	return $type;
}
function typeSort($type,$fid=0,$re = []){
	foreach ($type as $v){
		if($v['fid'] == $fid){
			$re[] = $v;
			$re = typeSort($type,$v['id'],$re);
		}
	}
	return $re;
}

//分类修改需要转化成数组
function typeUpdate($str){
	$str = trim($str,'>');
	$arr = explode('>', $str);
	$firstId = array_shift($arr);
	if($arr){
		$where = 'id in ('.join(',', $arr).')';
		$list = M('category')->field('id,c_name')->where($where)->select();
	}else{
		$list = array();
	}
	
	return [$firstId,$list];
}




