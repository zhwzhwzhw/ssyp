<?php
namespace Api\Controller;
use Think\Controller;
class PhraseController extends Controller {
	public function index(){
		$where = array(
				'order_num'=>array('gt',0)
		);
		$proObj = M('phrase');
		$list = $proObj->order('order_num desc')->select();
		echo $_GET['callback'].'('.json_encode($list).')';
	}
    public function test(){
    	$re = ['\u4f01\u4e1a\u76f4\u5c5e'];
    	var_dump(json_encode($re));
    	var_dump( json_decode('["\u4f01\u4e1a\u76f4\u5c5e"]') );
    }

    
}




