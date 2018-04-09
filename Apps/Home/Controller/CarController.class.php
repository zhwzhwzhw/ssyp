<?php
namespace Home\Controller;
use Home\Controller\BaseController;
class CarController extends BaseController {
    //购物车增加商品
    public function add(){
    	$param     =  I('param.');
    	$id        =  $param['pro_id'];
        $norms_id  =  $param['norms_id'];
        $user_id   =  $param['user_id'];
    	$obj       =  M('shopcar');
    	$where     =  array();
    	$where['pro_id']   = $id;
    	$where['norms_id'] = $norms_id;
        $where['user_id']  = $user_id;
    	$list   =  $obj->where($where)->find();
    	if($list){
    	    $re  = $obj->where("id=$where[id]")->setInc("number");
        }else{
            $re  = $obj->data($param)->add();
        }
        if($re){
            $this->success('添加成功',U('index'));
        }else{
            $this->error('添加失败');
        }
    }
    //购物车减少商品
    public function reduce(){
        $param     =  I('param.');
        $id        =  $param['id'];
        $norms_id  =  $param['norms_id'];
        $user_id   =  $param['user_id'];
        $obj       =  M('shopcar');
        $where     =  array();
        $where['pro_id']    = $id;
        $where['norms_id']  = $norms_id;
        $where['user_id']   = $user_id;
        $re  = $obj->where($where)->setDec("number");
        if($re){
            $this->success('减少成功',U('index'));
        }else{
            $this->error('减少失败');
        }
    }
    //购物车信息
    public function index(){
    	$param   =  I('param.');
    	$user_id =  $param['user_id'];
    	$obj     =  M('shopcar');
    	$where   =  array();
    	$where[] =  'c.number > 0';
    	$where[] =  "c.user_id=$user_id";
    	$list    = $obj->field('p.id as pro_id,p.wx_image,p.name,p.pro_price,c.number,c.id as car_id')->alias('c')
	    	     -> join('ssyp_product as p on p.id = c.pro_id')
                 -> join('ssyp_norms as n on n.id = c.norms_id')
                 -> where($where)
	    	     -> order('c.id desc')
	    	     -> select();
    	/*$list = getprice($list);*/
    	/*echo $_GET['callback'].'('.json_encode($list).')';*/
        $this->assign('list',$list);
        $this->display();
    }
    public function del(){
    	$param = I('param.');
    	$cars = $param['car_id'];
    	if(empty($cars)){
    		echo $_GET['callback'].'('.json_encode(['msg'=>'请选择','status'=>0]).')';exit;
    	}
    	$ids  = join(',', $cars);
    	$obj  = M('shopcar');
    	$data = array('deleted'=>1);
    	$re   = $obj->where('id in ('.$ids.')')->save($data);
        if($re){
            $this->success('删除成功',U('index'));
        }else{
            $this->error('删除失败');
        }
    }
}




