<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class IndexController extends BaseController {
    public function index(){
    	//var_dump($_SESSION);
    	//array(1) { ["admin"]=> array(2) { ["id"]=> string(2) "14" ["cat_shop"]=> string(2) "50" } }
    	$obj = M('admin');
        $this->display();
    }
}