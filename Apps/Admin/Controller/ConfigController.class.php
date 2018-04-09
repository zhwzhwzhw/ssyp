<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class ConfigController extends BaseController {
    public function index(){
    	$obj = M('config');
    	$data = $obj->find();
    	$this->assign('data',$data);
		$this->assign('title','系统设置');
        $this->display();
    }
    public function save(){
    	$_data = I('post.');
    	$id = (int)$_data['id'];
    	$re = M('config')->where('id="%s"',$id)->data($_data)->save();
    	if($re){
    		$this->success('修改成功',U('index'));
    	}else{
    		$this->error('修改失败',U('index'));
    	}
    }
    
    
    public function turn(){
    	$config = M('config')->find();
    	$js_ob = json_decode($config['turn']);
    	$js_ar = [];
    	foreach ($js_ob as $k=>$v){
    		$js_ar[$k]['img_name'] = $v->img;
    		$js_ar[$k]['pro_id'] = $v->pro_id;
    	}
    	$this->assign('img_list',$js_ar);
    	$this->assign('title','轮播图设置');
    	$this->assign('id',$config['id']);
    	$this->display();
    }
    public function turnsave(){
    	$_data = I('post.');
    	$config_id = $_data['id'];
    	$re = [];
    	foreach ($_data['img_name'] as $k=>$v){
    		$re[] = array(
    				'img'=>$v,
    				'pro_id' => $_data['pro_id'][$k]
    		);
    	}
    	$re = M('config')->where('id="%s"',$config_id)->data(['turn'=>json_encode($re)])->save();
    	if($re){
    		$this->success('上传成功');
    	}else{
    		$this->error('保存失败，请刷新重试');
    	}
    }
    public function news(){
    	$obj = M('News');
    	$data = $obj->find();
    	$this->assign('data',$data);
    	$this->assign('title','专题管理');
    	$this->display();
    }
    public function phrase(){
    	$obj = new PhraseController();
    	$obj->index();
    }
    
}