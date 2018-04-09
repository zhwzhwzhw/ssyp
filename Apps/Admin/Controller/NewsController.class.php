<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class NewsController extends BaseController{
	public function index(){
		$obj = M('News');
        $data = $obj->find();
        $this->assign('data',$data);
		$this->assign('title','专题管理');
		$this->display();
	}
	public function save(){
		$id = (int)I('post.id');
		$_data = I('post.');
		$_data['content'] = $_POST['content'];
		$obj = M('News');
		if($obj->data($_data)){
			if($id>0){
				$re = $obj->where('id="%s"',$id)->save();
			}else{
				$re = $obj->add();
			}
			if($re)
				$this->success('发布成功',U('index'));
			else 
				$this->error('发布失败');
		}else{
			$this->error($obj->getError());
		}
	}
	public function update(){
		$id = (int)I('get.id');
		$obj = M('News');
		$data = $obj->where('id="%s"',$id)->find();
		$data['live_start'] = $data['live_start']>0 ?  date('Y/m/d',$data['live_start']) : '';
		$data['live_end'] = $data['live_end']>0 ? date('Y/m/d' , $data['live_end'] - 24*3600) : '';
		$this->assign('data',$data);
		$this->display('add');
	}
	
	
}