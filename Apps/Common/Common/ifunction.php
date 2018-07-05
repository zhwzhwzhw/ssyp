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
function plum_parse_img_path($content) {
    $host = $_SERVER['HTTP_HOST'];
    /*$host = PLUM_IMG_HOST_PATH;*/
    if (!$content) {
        return '';
    }
    //$pattern = '/<img src=\"(.+?)\"(.*?)\/>/i';
    $pattern = '/<img .*?src=\"(?!http)(.+?)\"(.*?)\/>/i';
    $replace = '<img src="http://'.$host.'$1"$2/>';
    return preg_replace($pattern, $replace, $content);
}



