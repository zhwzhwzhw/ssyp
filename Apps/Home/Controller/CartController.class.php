<?php
namespace Home\Controller;
class CartController extends BaseController {
    //首页信息
    public function cart(){
        $param=I('param.');
        $where=array();
        $where['user_id']=1;
        /*$where['user_id']=$param['user_id'];*/
        $shopcar=M('shopcar')->field('c.id as cid,c.pro_id,c.number,p.*')->alias('c')
                 ->join('ssyp_product as p on p.id=c.pro_id')
                 ->where($where)
                 ->select();
        $this->assign('car',$shopcar);
        $this->display();
    }
    //店铺列表
    public function seller(){
        $sellerList=M('seller')->field("id,seller_logo")->select();
        $this->assign('sellerList',$sellerList);
        $this->display();
    }
}