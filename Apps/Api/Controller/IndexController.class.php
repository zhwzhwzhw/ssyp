<?php
namespace Api\Controller;
use Think\Controller;
class indexController extends Controller {
    //首页信息
    public function index(){
    $turn=M('config')->where('id='.'1')->getField('turn');
    $sellerList=M('seller')->field("id,seller_logo")->limit(0,4)->select();
    $turnList=json_decode($turn);
    $product=M('product')->field("id,wx_image,pro_price")->limit(0,4)->select();
    $category=M('category')->field("id,c_name,c_icons")->where('fid=0')->select();
    $data=array(
        'turn'    => $turnList,
        'seller'  => $sellerList,
        'product' => $product,
        'category'=> $category,
    );
    echo json_encode($data);
    }
    //店铺列表
    public function seller(){
        $sellerList=M('seller')->field("id,seller_logo")->select();
        $data=array(
            'seller'=>$sellerList,
        );
        echo json_encode($data);
    }
}