<?php
namespace Api\Controller;
use Think\Controller;
class NewsController extends Controller {
	public function index(){
		$obj = M('news');
		$data = $obj->find();
		echo $_GET['callback'].'('.json_encode($data).')';
	}
	
	
	
}