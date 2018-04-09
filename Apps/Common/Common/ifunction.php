<?php
function return_cat_list($ids){
	if(empty($ids))return'';
	$obj = M('category');
	$where = array(
	    'fid'=>0,
        'c_status'=>1,
        'id'=>array('in',$ids),);
	$typeArr = $obj->field('id,c_name')->where($where)->select();
	$str = '';
	foreach ($typeArr as $v){
		$str .= '<span style="display:inline-block;padding:3px 5px;border:1px solid #ddd;margin:0 3px;">'.$v['c_name'].'</span>';
	}
	return $str;
}




