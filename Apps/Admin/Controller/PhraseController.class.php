<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class PhraseController extends BaseController{
	public function index(){
		$proObj = M('phrase');
		$list = $proObj->order('order_num desc')->select();
		
		$this->assign('title','常见问题');
		$this->assign('list',$list);
		$this->display('Phrase/index');
	}
	public function add(){
		$data = array(
				'order_num'=>50,
		);
		$this->assign('data',$data);
		$this->assign('title','常见问题添加');
		$this->display();
	}
	public function save(){
		$_data = I('post.');

		$_data['edi_time'] = NOW_TIME;
		$id = ( isset($_data['id']) && (int)$_data['id']>0 ) ? (int)$_data['id'] : 0 ;
		unset($_data['id']);
		$obj = M('phrase');
		if($id){
			$re = $obj->data($_data)->where('id="%s"',$id)->save();
		}else{
			$re = $obj->data($_data)->add();
		}
		if($re){
			$this->success('发布成功',U('index'));
		}else{
			$this->error('发布失败');
		}
	}
	public function update(){
		$id = (int)I('get.id');
		if(empty($id)){
			$this->redirect('Home/Public/not_found');
		}
		$obj = M('phrase');
		$data = $obj->where('id="%s"',$id)->find();
		
		$this->assign('data',$data);
		
		
		$this->assign('title','常见问题编辑');
		$this->display('add');
	}
	public function del(){
		$obj = M('phrase');
		$id = (int)I('get.id');
		$re = $obj->where('id="%s"',$id)->delete();
		header('location:'.$_SERVER['HTTP_REFERER']);
	}
	
	
	
	
	
	
}