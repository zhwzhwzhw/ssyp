<?php
namespace Api\Controller;
use Think\Controller;
class CategoryController extends Controller {
	private $where = array(
    			'c_status'=>'1',
    			'c_ordernum'=>array('gt',0)
    );
	//分类全部 状态为1的全部
    public function index(){
    	$obj = M('category');
    	$where = $this->where;
    	$list = $obj->field('id,c_name,fid')->where($where)->order('c_ordernum desc')->select();
    	echo $_GET['callback'].'('.json_encode($list).')';
    }
	
    //通过id找子类
    public function child(){
    	$fid = I('param.id');
    	$obj = M('category');
    	$where = $this->where;
    	$where['fid'] = $fid;
    	$list = $obj->field('id,c_name')->where($where)->order('c_ordernum desc')->select();
    	$this->ajaxReturn($list);
    }
}