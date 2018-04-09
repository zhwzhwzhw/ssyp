<?php
namespace Org\Net;
use Think\Controller;
class MessageDB extends Controller{
	public  $me;
	public $cNum = 10;//每次获取数
	public $bNum = 20;//上拉获取数
	protected $meid;
    public function index(){
        $this->display();
    }
    
    public function getUser(){
    	if(isset($_GET['name']) && isset($_GET['name'])!=''){
    		$where['nickname'] = array('like',"%{$_GET['name']}%");
    	}else{
    		$where = 1;
    	}

    	$memberObj = M('user');
    	$member = $memberObj->where($where)->select();
    	$this->ajaxReturn($member);
    }
    

    
    public function getRemarks(){
    	$megObj = M('message');
    	if(is_array($this->me)){
    		$where = array(
    			'm_from' => 'bz_'.reset($this->me),
    			'm_to'   => 'bz_'.$_POST['m_to']
    		);
    	}else{
    		$where = array(
    			'm_from' => 'bz_'.$this->me,
    			'm_to'   => 'bz_'.$_POST['m_to']
    		);
    	}
    	
    	//     	/var_dump($where);
    	$arr = $megObj->where($where)->select();
    	$this->ajaxReturn($arr,'json');
    }
    public function setRemarks(){
    	if($_POST['m_to']!='' && $_POST['content']!='' ){
    		$data['m_to'] = 'bz_'.I('post.m_to');
    		$data['content'] = I('post.content');
    		$data['isread'] = 1;
    		if(is_array($this->me)){
    			$data['m_from'] = 'bz_'.reset($this->me);
    		}else{
    			$data['m_from'] = 'bz_'.$this->me;
    		}
    		
    		$data['send_time'] = time();
    		$megObj = M('message');
    		$re = $megObj->data($data)->add();
    		if($re){ //插入失败  //要存入数据库的
    			echo '1';exit;
    		}else{
    			echo '0';exit;
    		}
    	}else{
    		exit('0');
    	}
    }
    
    
 
	public function send($m_to = null){
		$param = I('param.');
		$param['content'] = trim($param['content']);
		if(empty($param['content'])){
			if($_GET['callback']){
				echo $_GET['callback'].'('.json_encode(['msg'=>'信息为空']).')';exit;
			}else{
				exit(0);
			}
		}
		
		if(!is_null($m_to)){
			$param['m_to'] = $m_to;
		}
    	$this->beforeSend();
    	if($param['m_to']!='' && $param['content']!='' ){
    		$obj = M('message');
    		$data = array(
    				'content'=>$param['content'],
    				'send_time'=>time(),
    				'm_to'=>$param['m_to'],
    				'm_from'=>$this->me,
    				'isread' => 0,
    		);
    		$re = $obj->data($data)->add();
    		if($_GET['callback']){
    			echo $_GET['callback'].'('.json_encode(['msg'=>'成功']).')';exit;
    		}
    		if($re){
    			exit('1');
    			$this->userStatus();
    		}else{
    			exit('0');
    		}
    	}else{
    		exit('0');
    	}
    }
    protected function userStatus(){
    	
    }
    protected function beforeSend(){
    	 
    }
   
    public function getMessage($fen = true){  //区分聊天对象
    	$obj = M('message');
    	$m_to = I('post.m_to');
    	if($fen){
    		$where_init = "((m_to = '{$this->me}' and m_from = '{$m_to}') or (m_from = '{$this->me}' and m_to = '{$m_to}'))";
       	}else{
       		$where_init = "(m_to = '{$this->me}' or m_from = '{$this->me}')";
       	}
    	
    	if(isset($_GET['before']) && $_GET['before'] != ''){
    		$where = $where_init . " AND id < {$_GET['before']}";
    		$num = $this->bNum;
    		if($_GET['callback']){
    			$num = '';
    			$where = $where_init;
    		}
    		$re = $obj->where($where)->order('id desc')->limit($num)->select(array('index'=>'id'));
    	}else{
    		$where = $where_init;
    		$num = $this->cNum;//查看记录数；
    		$re = $obj->where($where)->order('id desc')->limit($num)->select(array('index'=>'id'));
    	}
    	$where = $where . " and m_to='{$this->me}'";
    	$obj->where($where)->data(['isread'=>1])->save();   //保存
    	if($_GET['callback']){
    		$re_1 = [];
    		foreach ($re as $v){
    			$re_1[] = $v;
    		}
    		$re = $re_1;
    		echo $_GET['callback'].'('.json_encode($re).')';
    	}else{
    		$this->ajaxReturn($re);
    	}
    }
    public function getRead(){
    	$obj = M('message');
    	$where = array(
    			'isread'=>0,
    			'm_to'=>$this->me
    	);
    	$re = $obj->alias('m')
    	->field('count(m.id) as num,u.id,nickname,headimgurl,CONCAT("u_",u.id) as m_from')
    	->join(C('DB_PREFIX').'user as u on u.id = substring(m_from,3)')
    	->where($where)
    	->group('u.id')
    	->select();
    	$this->ajaxReturn($re);
    
    }
    
    public function getPhrase(){
    	$arr = array('?','？','。','.',',','，','"','\'','’','“','·','`','~','、','\\',';','；');
    	if(isset($_GET['typeid']) && $_GET['typeid']!=''){ //点击分类找
    		$where = array('typeid'=>$_GET['typeid']);
    	}elseif(isset($_GET['title']) && $_GET['title']!=''){ //搜索找
    		$title = $_GET['title'];
    		if(in_array($title, $arr)){
    			exit('');
    		}
    		
    		$where['title'] = array('like',"%{$title}%");
    	}elseif(isset($_GET['lawyerid'])&&$_GET['lawyerid']!=''){ //点击我的分类找 别人发的 会记入到最后改的人
    		$where = array('lawyer_id'=>$_SESSION['lawyerLogin']['id']);
    	}else{
    		exit('');
    	}
    	$phraseObj = M('phrase');
    	$phrase = $phraseObj->where($where)->order('use_num desc,id desc')->select();
    	$this->ajaxReturn($phrase);
    }
    public function addPhUseNum(){
    	if(isset($_GET['id']) && $_GET['id']!=''){
    		$phraseObj = M('phrase');
    		$phraseObj->where('id="%s"',$_GET['id'])->setInc('use_num');
    	}
    }
    public function uploadify(){
    	
    	if(isset($_POST['Filename']) && isset($_POST['Upload'])){
    		unset($_POST['Filename'],$_POST['Upload']);
    	}
    	
    	$_POST['m_to'] = join('', $_POST);
    	
    	$upload = new \Think\Upload();// 实例化上传类
    	//$upload->mimes         =  array('application/octet-stream','application/zip','application/x-zip-compressed'.'application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','text/plain','image/jpg','image/png','image/jpeg','image/gif'); //允许上传的文件MiMe类型
    	$upload->exts          =  array('zip','rar','doc','docx','txt','jpg','jpeg','png','gif'); //允许上传的文件后缀
    	$upload->maxSize       =  1024*1024*20; //上传的文件大小限制 (0-不做限制)
    	$upload->subName       =  array('date', 'Y-m'); //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
    	$upload->savePath      =  'meg/'; //保存路径
    	$info = $upload->upload($_FILES);
    	if ($info) {
    		$_POST['content'] = C('SEND_FILE_LEFT').$info['Filedata']['savepath'].$info['Filedata']['savename'].C('SEND_FILE_RIGHT');
    		
    		$this->send();
    	} else {
    		echo $upload->getError();
    	}
    }
    
    
    
     public function reward(){//用户聊天给律师发红包
    	//记录没做
    	$money = $_POST['money'];
    	$lid = $_POST['m_to'];
    	$_POST['content']=C('SEND_HONGBAO_LEFT').$money.C('SEND_HONGBAO_RIGHT');
    		
    	if($money<=0){
    		exit('error');
    	}
    	if($_SESSION['memberLogin']['money'] >= $money){
    		//用户
    		$data[] = array(
    				'time'=>time(),
    				'money'=>$money*-1,
    				'tran_type'=>3,
    				'pay_type'=>1,
    				'userid'=>$this->me,
    				'tran_userid'=>$lid,
    				'remarks'=>'聊天红包',
    		);
    		//律师
    		$data[] = array(
    				'time'=>time(),
    				'money'=>$money,
    				'tran_type'=>3,
    				'pay_type'=>1,
    				'userid'=>$lid,
    				'tran_userid'=>$this->me,
    				'remarks'=>'收到聊天红包'
    		);
    		$memberObj = M('member');
    		$lawyerObj = M('lawyer');
    		$moneyObj = M('money');
    		$memberObj->startTrans();
    		$post = $memberObj->where('id="%s"',$this->meid)->setDec('money',round($money,2));
    		$get = $lawyerObj->where('id="%s"',substr($lid, 2))->setInc('money',round($money,2));
    		$log = $moneyObj->addAll($data);
    		if ($post && $get && $log){
    			$_SESSION['memberLogin']['money'] = $_SESSION['memberLogin']['money'] - $money;
    			// 提交事务
    			$memberObj->commit();
    			$this->send();
    			//做资金流水记录
    		}else{
    			// 事务回滚
    			$memberObj->rollback();
    			exit('0');
    		}
    	}else{
    		exit('notEnough');
    	}
    } 
}