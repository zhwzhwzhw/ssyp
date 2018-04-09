<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class PowerController extends BaseController{
    public function index(){
    	$powerObj = M('power');
    	$power = $powerObj->select();
    	$this->assign('power',$power);
    	$this->assign('title','权限列表');
        $this->display();
    }
    public function add(){//添加权限
    	$this->assign('title','添加权限');
    	$this->display();
    }
    public function save(){//保存到表
    	$module = $_POST['module'];
    	$power_name = $_POST['power_name'];
    	$actionArr = $_POST['action'];
    	$controller = $_POST['controller'];
    	foreach ($actionArr as $v){
    		$data[] = array(
    				'power_name'=>$power_name,
    				'module'=>$module,
    				'controller'=>$controller,
    				'action'=>$v
    		);
    	}
    	$powerObj = M('power');
    	$re = $powerObj->addAll($data);
    	if($re){
    		$this->success('权限添加成功');
    	}else{
    		$this->success('权限添加失败');
    	}
    }
    public function del(){
    	$id = I('get.id');
    	$powerObj = M('power');
    	$powerObj->where('id="%s"',$id)->delete();
    	$this->redirect('index');
    }
    public function rename(){
    	if($_POST){
    		$id = $_POST['id'];
    		$data['power_name'] = $_POST['power_name'];
    		$powerObj = M('power');
    		$re = $powerObj->where('id="%s"',$id)->data($data)->save();
    		if($re){
    			$this->success('修改成功',$_SERVER['HTTP_REFERER']);
    		}else{
    			$this->success('修改失败',$_SERVER['HTTP_REFERER']);
    		}
    	}
    }
    
    
    public function getControllerName(){
    	$module = $_POST['module'];
    	$path = ROOT.'Apps/'.$module.'/Controller';
    	$dh = opendir($path);
    	while (false != ($file = readdir($dh))){
    		$noHave = array(
    				'..',
    				'.'
    		);
    		if(!in_array($file, $noHave)){
    			$controller[] = substr($file,0, -20);
    		}
    	}
    	closedir($dh);
    	$this->ajaxReturn($controller);
    }
    
    public function getActionName(){
    	$module = $_POST['module'];
    	$controller = $_POST['controller'];
    	$file = ROOT.'Apps/'.$module.'/Controller/'.$controller.'Controller.class.php';
    	$fh = fopen($file, 'r');
    	while(false != ($line = fgets($fh))) {
    		preg_match('/function (\w*)\(\)\{\/?\/?(.*)/', $line,$re);
    		if($re){
    			$action[] = array('action'=>$re[1],'name'=>trim($re[2]));//$re[1]方法名 $re[2]注释内容
    		}
    	}
    	fclose($fh);
    	$powerObj = M('power');
    	$where = array(
    			'module'=>$module,
    			'controller'=>$controller,
    	);
    	$haveArr = $powerObj->field('action')->where($where)->select();
    	foreach($action as $k=>$v){
    		foreach($haveArr as $hv){
    			if($v['action'] == $hv['action']){
    				unset($action[$k]);
    			}
    		}
    	}
    	
    	$this->ajaxReturn($action);
    }

    
}