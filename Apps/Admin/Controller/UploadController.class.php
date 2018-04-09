<?php
namespace Admin\Controller;
use Think\Controller;
class UploadController extends Controller{
	public function _initialize(){
		if(strpos( $_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME']) === false){ //用于不直接访问的网站
			exit('非法操作');
		}
	}
	public function upload(){
		$keys = array_keys($_FILES);
		$keyname = $keys[0];
		$upload = new \Think\Upload();
		$upload->mimes         =  array('image/jpg','image/png','image/jpeg'); //允许上传的文件MiMe类型
		$upload->maxSize       =  0; //上传的文件大小限制 (0->不做限制)
		$upload->exts          =  array('png','jpg','jpeg'); //允许上传的文件后缀
		$upload->autoSub       =  true; //自动子目录保存文件
		$upload->subName       =  array(date, 'Y-m'); //子目录创建方式，[0]->函数名，[1]->参数，多个参数使用数组
		$upload->rootPath      =  './Uploads/'; //保存根路径
		$upload->saveName      =  array(uniqid,time().'-'); //上传文件命名规则，[0]->函数名，[1]->参数，多个参数使用数组
		$re = $upload->upload();
		$data = $re[$keyname]['savepath'].$re[$keyname]['savename'];
		if($data){
			echo "<script>
					parent.iframe_callback('{$data}','".trim($_POST['fun_name'])."');
				</script>";
			exit;
		}else{
			$error =  $upload->getError();
			echo "<script>
					parent.iframe_callback('{$error}','pop_box');
				</script>";
			exit;
		}
	}
	public function delImg(){
		$imgName = trim(I('post.imgname'));
		@unlink(ROOT.'/Uploads/'.$imgName);
		echo '1';
		exit;
	}
	
	
	
}