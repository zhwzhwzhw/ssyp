<?php
namespace Org\Net;
use Think\Controller;
class Message extends Controller{
	protected $memNum = 10000;
	protected $maxMemNum = 12000;
	protected $minMemNum = 8000;
	public  $me;
	public $cNum = 10;//每次获取数
	public $bNum = 20;//上拉获取数
	protected $meid;
    public function index(){
 /*    	$typeObj = M('type');
    	$type = $typeObj->field('type_name,id')->where('fid="%s"',C('CJWT_TYPE_ID'))->select();
    	$this->assign('type',$type);
    	
    	
    	$lawyerObj = M('lawyer');
    	$lawyer = $lawyerObj->select();
    	foreach ($lawyer as $k=>$v){
    		$lawyer[$k]['uid'] = 'l_'.$v['id'];
    	}
    	$this->assign('lawyer',$lawyer);
    	
    	$memberObj = M('member');
    	$member = $memberObj->select();
    	foreach ($member as $k=>$v){
    		$member[$k]['uid'] = 'm_'.$v['id'];
    	}
    	$this->assign('member',$member);
    	
    	$agentObj = M('agent');
    	$agent = $agentObj->select();
    	foreach ($agent as $k=>$v){
    		$agent[$k]['uid'] = 'a_'.$v['id'];
    	}
    	$this->assign('agent',$agent);
    	
        $adminObj = M('admin');
        $admin = $adminObj->select();
        foreach ($admin as $k=>$v){
        	$admin[$k]['uid'] = 'ad_'.$v['id'];
        }
        $this->assign('admin',$admin); */
        
        $this->display();
    }
    
    public function getUser(){
    	if(isset($_GET['name']) && isset($_GET['name'])!=''){
    		$where['username'] = array('like',"%{$_GET['name']}%");
    	}else{
    		$where = 1;
    	}

    	$memberObj = M('member');
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
    
    
 /*    public function send(){
    	if($_POST['m_to']!='' && $_POST['content']!='' ){
	    	$data['m_to'] = I('post.m_to');
	    	$data['content'] = I('post.content');
	    	$data['m_from'] = $this->me;
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
    } */
    public function send(){
    	$this->beforeSend();
    	if($_POST['m_to']!='' && $_POST['content']!='' ){
    		
    		$data['m_to'] = I('post.m_to');
    		$data['content'] = I('post.content');
    		if(is_array($this->me)){
    			$data['m_from'] = reset($this->me);
    		}else{
    			$data['m_from'] = $this->me;
    		}
    		
    		$data['send_time'] = time();
    		$data['isread'] = 0;
    		$this->writeMegMemcache($data);
    		$this->userStatus();
    		exit('1');
    	}else{
    		exit('0');
    	}
    }
    protected function userStatus(){
    	
    }
    protected function beforeSend(){
    	 
    }
    //写入到内存 内存到数据库
    public function writeMegMemcache($arr){
    	$cache = S(array('type'=>'memcache','prefix'=>'meg_'));
    	$c = $cache->message;
    	if($c === array()){
    		$c[1] = $arr;
    	}else{
    		$c[] = $arr;
    	}
    	krsort($c);
    	$key = array_keys($c,$arr);
    	$c[$key[0]]['id'] = $key[0];        ///加入id
    	$count = count($c);
    	if($count >= $this->maxMemNum){
    		$data = array_slice($c, $this->minMemNum);
    		foreach ($data as $k=>$v){
    			ksort($v);
    			$data[$k] = $v;
    		}
    		$megObj = M('message');
	    	$re = $megObj->addAll($data,array(),true);
	    	if($re){
	    		$c = array_slice($c, 0 , $this->minMemNum ,true);
	    	}
    	}
    	$cache->message = $c;
    }
    public function BF(){
    	$cache = S(array('type'=>'memcache','prefix'=>'meg_'));
    	$c = $cache->message;
    	$megObj = M('message');
    	foreach ($c as $k=>$v){
    		ksort($v);
    		$c[$k] = $v;
    	}
    	$re = $megObj->addAll($c,array(),true);
    	if($re){
    		unset($cache->message);
    		exit('备份成功');
    	}
    }
    public function R(){
    	$cache = S(array('type'=>'memcache','prefix'=>'meg_'));
    	$c = $cache->message;
    	print_r($c);
    }
     public function D(){
    	$cache = S(array('type'=>'memcache','prefix'=>'meg_'));
    	unset($cache->message);
    }  
    
    //数据库到内存的同步
    public function readMegMemcache($num=10 ,$isbefore = false,$before = 0 ,$where = false  ){//从缓存中查数据
    	$cache = S(array('type'=>'memcache','prefix'=>'meg_'));
    	if(!$cache->message){
    		$megObj = M('message');
    		$re  = $megObj->order('id desc')->limit($this->memNum)->select(array('index'=>'id'));
    		//krsort($re);
    		$cache->message = $re;
    	}
    	$arr = array();
    	$i = 1 ;
    	$changeReadArr = array();
    	foreach ($cache->message as $k=>$v){
    		if($i>$num){
    			break;
    		}
    
    		if($where === false){
    			if(strpos($_POST['m_to'], 'gp_') === false){//群聊
    				if(is_array($this->me)){
    					$where1 = (in_array((string)$v['m_from'], $this->me) && (string)$v['m_to'] == (string)$_POST['m_to']) || (in_array((string)$v['m_to'], $this->me) && (string)$v['m_from']==(string)$_POST['m_to']);
    				}else{
    					if($_POST['m_to'] === '0'){ //0表示发给所有
    						$where1 = ((string)$v['m_from'] == (string)$this->me && (string)$v['m_to'] == (string)$_POST['m_to']) || ((string)$v['m_to'] ==(string)$this->me && substr($v['m_from'], 0 ,3)=== 'ad_');
    
    					}else{
    						$where1 = ((string)$v['m_from'] == (string)$this->me && (string)$v['m_to'] == (string)$_POST['m_to']) || ((string)$v['m_to'] ==(string)$this->me && (string)$v['m_from']==(string)$_POST['m_to']);
    					}
    
    				}
    			}else{
    				$where1 = ((string)$v['m_to'] == (string)$_POST['m_to']);
    			}
    
    		}
    		if($isbefore){
    			$where1 = $where1 && $v['id']<$before;
    		}
    
    		if($where1){
    				
    			$arr[$k] = $v;
    			unset($arr[$k]['m_to']);
    			$i++;
    		}
    			
    			
    			
    		if(strpos($_POST['m_to'], 'gp_') === false){//群聊
    			if(is_array($this->me)){
    				if(in_array($v['m_to'], $this->me)  && $v['m_from']==$_POST['m_to']){ ////变为已读
    					$v['isread'] = 1;
    					$changeReadArr[$k] = $v;
    				}
    			}else{
    				if($_POST['m_to'] === '0'){
    					if($v['m_to'] ==$this->me && substr($v['m_from'], 0 ,3)=== 'ad_'){ ////变为已读
    						$v['isread'] = 1;
    						$changeReadArr[$k] = $v;
    					}
    				}else{
    					if($v['m_to'] ==$this->me && $v['m_from']==$_POST['m_to']){ ////变为已读
    						$v['isread'] = 1;
    						$changeReadArr[$k] = $v;
    					}
    				}
    
    			}
    		}else{
    			if((string)$v['m_to'] == (string)$_POST['m_to']){ ////变为已读
    				$v['isread'] = 1;
    				$changeReadArr[$k] = $v;
    			}
    		}
    			
    
    		$cache->message[$k] = $v;
    
    	}
    	$centerArr = $changeReadArr + $cache->message;
    	krsort($centerArr);
    	$cache->message = $centerArr;
    	return $arr;
    }
    /*     public function d(){
     $cache = S(array('type'=>'memcache','prefix'=>'meg_'));
    $megObj = M('message');
    $data = array_slice($cache->message, 0);
    $re = $megObj->addAll($data,array(),true);
    echo $megObj->_sql();
    if($re){
    
    exit('数据备份成功');
    unset($cache->message);
    }else{
    exit('数据备份失败');
    }
    
    } */
    /*     public function r(){
     $cache = S(array('type'=>'memcache','prefix'=>'meg_'));
    var_dump($cache->message);
    } */
    
    public function getMessage(){
    	if(isset($_GET['before']) && $_GET['before'] != ''){
    		$num = $this->bNum;
    		$cacheRe = $this->readMegMemcache($num,true,$_GET['before']);
    	}else{
    		$num = $this->cNum;//查看记录数；
    		$cacheRe = $this->readMegMemcache($num);
    	}
    		
    	if($cacheRe === array()){
    		//exit('[{"id":"242","m_from":"l_1","content":"坏了","send_time":"1484882053"}]');
    		$arr = $this->readMegDb($num);
    		//加入到缓存
    		//$cache = S(array('type'=>'memcache','prefix'=>'meg_'));
    		//$cache->message = $arr + $cache->message;
    	}else{
    		$arr = $cacheRe;
    		$checkNum = count($arr);
    		if($checkNum<$num){
    			$arr1 = $this->readMegDb($num-$checkNum);
    			$arr = $arr1+$arr;
    		}
    	}
    		
    		
    	foreach ($arr as $k=>$v){
    		if(substr($v['m_from'],0,3) === 'ad_' && $this->me === $_SESSION['id']){ //仅仅为了前台的 适用于律众
    			$arr[$k]['m_from'] = 0;
    		}
    		$arr[$k]['content'] = str_replace("\n", '<br/>', $v['content']);
    		if(preg_match('/'.C('SEND_HONGBAO_LEFT').'(.*)'.C('SEND_HONGBAO_RIGHT').'/', $v['content'])){
    			$arr[$k]['content'] = preg_replace('/'.C('SEND_HONGBAO_LEFT').'(.*)'.C('SEND_HONGBAO_RIGHT').'/', '<div class="hongb_meg">$1</div>', $v['content']);
    		}
    		if(preg_match('/^'.C('SEND_FILE_LEFT').'(.*)\/(.*)'.C('SEND_FILE_RIGHT').'$/', $v['content'],$match)){
    			$exd = end(explode('.', $match[2]));
    			if(in_array($exd, array('jpg','png','gif','jpeg'))){
    				$arr[$k]['content'] = preg_replace('/^'.C('SEND_FILE_LEFT').'(.*)\/(.*)'.C('SEND_FILE_RIGHT').'$/', '<a href="/Uploads/$1/$2" target="_blank" class="file_send">图像：$2<br/><span>点击查看</span></a>', $v['content']);
    			}else if(in_array($exd, array('txt'))){
    				$arr[$k]['content'] = preg_replace('/^'.C('SEND_FILE_LEFT').'(.*)\/(.*)'.C('SEND_FILE_RIGHT').'$/', '<a href="/Uploads/$1/$2" target="_blank" class="file_send">文本文件：$2<br/><span>点击查看</span></a>', $v['content']);
    			}else{
    				$arr[$k]['content'] = preg_replace('/^'.C('SEND_FILE_LEFT').'(.*)\/(.*)'.C('SEND_FILE_RIGHT').'$/', '<a href="/Uploads/$1/$2" target="_blank" class="file_send">文件：$2<br/><span>点击下载</span></a>', $v['content']);
    			}
    				
    				
    		}
    	}
    	$arr = $this->megResult($arr);
    	$this->ajaxReturn($arr,'json');
    }
    public function megResult($arr){
    	return $arr;
    }
    protected function readMegDb($num){
    	$megObj = M('message');
    	if(strpos($_POST['m_to'], 'gp_') === false){//群聊
    		if(is_array($this->me)){
    			foreach ($this->me as $k=>$v){
    				$where[] = array(
    						'm_from' => $this->me[$k],
    						'm_to'   => $_POST['m_to']
    				);
    				$where[] = array(
    						'm_to' => $this->me[$k],
    						'm_from'   => $_POST['m_to']
    				);
    				$whereToRead[] = array( //与上一个相同
    						'm_to' => $this->me[$k],
    						'm_from'   => $_POST['m_to']
    				);
    			}
    				
    			$whereToRead['_logic']="OR";
    			$megObj->where($whereToRead)->data(array('isread'=>1))->save();
    		}else{
    				
    			$where[0] = array(
    					'm_from' => $this->me,
    					'm_to'   => $_POST['m_to']
    			);
    			if($_POST['m_to'] === '0'){
    				$where[1] = array(
    						'm_to' => $this->me,
    						'm_from'   => array('like','ad_%')
    				);
    			}else{
    				$where[1] = array(
    						'm_to' => $this->me,
    						'm_from'   => $_POST['m_to']
    				);
    			}
    			$megObj->where($where[1])->data(array('isread'=>1))->save();
    		}
    	}else{
    		$where[1] = array(
    				'm_to'   => $_POST['m_to']
    		);
    		$megObj->where($where[1])->data(array('isread'=>1))->save();
    	}
    
    
    	$where['_logic']="OR";
    	if(isset($_GET['before']) && $_GET['before'] != ''){
    
    		$map['_complex'] = $where;
    		$map['id'] = array('LT',$_GET['before']);
    
    	}
    	//     	/var_dump($where);
    
    	if(isset($_GET['before']) && $_GET['before'] != ''){
    		$arr = $megObj->where($map)->order('id desc')->limit($num)->select(array('index'=>'id'));
    	}else{
    		$arr = $megObj->where($where)->order('id desc')->limit($num)->select(array('index'=>'id'));
    	}
    	return $arr;
    }
/*     public function getMessage(){
    	if($this->getMegMemcache()){
    
    	}else{
    
    	}
    	$num = 6;//查看记录数；
    	$megObj = M('message');
    	$where[0] = array(
    			'm_from' => $this->me,
    			'm_to'   => $_POST['m_to']
    	);
    	$where[1] = array(
    			'm_to' => $this->me,
    			'm_from'   => $_POST['m_to']
    	);
    	$where['_logic']="OR";
    
    	if(isset($_GET['before']) && $_GET['before'] != ''){
    		$num = 20;
    		$map['_complex'] = $where;
    		$map['id'] = array('LT',$_GET['before']);
    		 
    	}
    	//     	/var_dump($where);
    	$megObj->where($where[1])->data(array('isread'=>1))->save();
    	if(isset($_GET['before']) && $_GET['before'] != ''){
    		$arr = $megObj->field('id,content,send_time,m_from')->where($map)->order('id desc')->limit($num)->select();
    	}else{
    		$arr = $megObj->field('id,content,send_time,m_from')->where($where)->order('id desc')->limit($num)->select();
    	}
    	krsort($arr);
    	$arr1 = array();
    	foreach ($arr as $v){
    		$v['content'] = preg_replace('/'.C('SEND_HONGBAO_LEFT').'(.*)'.C('SEND_HONGBAO_RIGHT').'/', '<div class="hongb_meg">$1</div>', $v['content']);
    		$arr1[] = $v;
    	}
    	$this->ajaxReturn($arr1,'json');
    } */
/*     public function getRead(){
    	$megObj = M('message');
    	$where = array(
    			'm_to'=>$this->me,
    			'isread'=>0
    	);
    	 
    	$re = $megObj->field('count("id") as num,m_from')->where($where)->group('m_from')->select();
    	$this->ajaxReturn($re,'json');
    } */
    //内存中的未读
    public function getRead(){ 
    	$cache = S(array('type'=>'memcache','prefix'=>'meg_'));
    	$re = array();
    	foreach($cache->message as $k=>$v){
    		if(is_array($this->me)){
    			if(((in_array($v['m_to'], $this->me) || in_array($v['m_from'], $this->me)) && $v['isread'] == 0)){
    				if(isset($re[$v['m_from']]['m_from'])){
    					$re[$v['m_from']]['num']++;
    				}else{
    					$re[$v['m_from']]['m_from'] = $v['m_from'];
    					$re[$v['m_from']]['num'] = 1;
    				}
    			}
    		}else{
    			//这里加入群聊提示，而群聊中必须存一个群的信息。
    			if(($v['m_to'] == $this->me && $v['isread'] == 0)){
    				if(isset($re[$v['m_from']]['m_from'])){
    					$re[$v['m_from']]['num']++;
    				}else{
    					$re[$v['m_from']]['m_from'] = $v['m_from'];
    					$re[$v['m_from']]['num'] = 1;
    				}
    			}
    		}
    		
    	};
    	$this->ajaxReturn($re,'json');
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
    
    
    
/*     public function reward(){//用户聊天给律师发红包
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
    } */
}