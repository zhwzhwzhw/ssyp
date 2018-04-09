<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class CategoryController extends BaseController {
    public function index(){
    	$status  =	(int)I('get.status');
    	if(empty($status)){
    		$status = $_GET['status'] = 1;
    	}
		$obj = M('category');
		$list = $obj->order('c_ordernum desc,id desc')->where('c_status="%s"',$status)->select();
		$listRe = typeList($list);
		$listRe = typeSort($listRe);
		$this->assign('list',$listRe);
		$this->assign('title','分类列表');
        $this->display();
    }
	public function add(){
		$status  =	(int)I('get.status');
		if(empty($status)){
			$status = $_GET['status'] = 1;
		}
		$data = array(
				'c_ordernum'=>50,
				'c_status'=>1,
				'c_isshow'=>1
		);
		$this->assign('category_0',getChildType(0,$status));
		$this->assign('data',$data);//传默认值
		$this->assign('title','分类添加');
		$this->assign('first',0);
		$this->assign('c_list',[]);
		$this->display();
	}
	public function save(){
		$_data = I('post.');
		list($_data['fid_str'],$_data['fid']) = typeToStr($_POST['fid']);
		$id = (int)I('post.id');
		$obj = D('Category');
		if($obj->create($_data)){
			if($id){
				if($_data['fid'] == $id){
					$this->error('父级分类不能为自身');
				}
				$re = $obj->where('id="%s"',$id)->save();
			}else{
				$re = $obj->add();	
			}
		}else{
			$this->error($obj->getError());
		}
		if($re){
			$this->success('提交成功','index');
		}else{
			$this->error('添加/修改失败，请重试');
		}
	}
	public function update(){
		$id = (int)I('get.id');
		$obj = M('category');
		$data = $obj->where('id="%s"',$id)->find();
		$_GET['status'] = $data['c_status'];
		list($first,$c_list) = (typeUpdate($data['fid_str']));
		$this->assign('title','分类修改');
		$this->assign('first',$first);
		$this->assign('c_list',$c_list);
		$this->assign('category_0',getChildType(0));
		$this->assign('data',$data);
		$this->display('add');
	}
	public function getType(){
		$data = getChildType();
		$this->ajaxReturn($data);
	}
}