<?php
namespace Home\Controller;
class IndexController extends BaseController {
    //首页信息
    public function index(){
        $turn        = M('config')->where('id='.'1')->getField('turn');
        $sellerList  = M('seller')->field("id,seller_logo")->limit(0,4)->select();
        $turnList    = json_decode($turn,true);
        $product     = M('product')->field("id,wx_image,pro_price")->limit(0,4)->select();
        $category    = M('category')->field("id,c_name,c_icons")->where('fid=0')->select();
        $this->assign('turn',$turnList);
        $this->assign('product',$product);
        $this->assign('category',$category);
        $this->assign('sellerList',$sellerList);
        $this->display();
    }
    //店铺列表
    public function seller(){
        $sellerList=M('seller')->field("id,seller_logo")->select();
        $this->assign('sellerList',$sellerList);
        $this->display();
    }
    /*
     * 任务
     */
    public function sort(){
        $this->display();
    }
}