<?php
namespace Api\Controller;
use Org\Net\MessageDB;
class MessageController extends MessageDB {
	function _initialize(){
		$param = I('param.');
		$this->me = 'u_'.$param['user_id'];
	}
	public function tmp(){
		$phrase_id = I('param.phrase_id');
		$obj = M('phrase');
		$data = $obj->where('id="%s"',$phrase_id)->find();
		$m_to= $this->m_to();
		$problem = array(
    				'content'=>$data['problem'],
    				'send_time'=>time(),
    				'm_to'=>a_0,
    				'm_from'=>$this->me,
    				'isread' => 0,
    	);
		$answer = array(
				'content'=>$data['answer'],
				'send_time'=>time(),
				'm_to'=>$this->me,
				'm_from'=>a_0,
				'isread' => 0,
		);
		$msg = M('message');
    	$re = $msg->data($problem)->add();
    	$re = $msg->data($answer)->add();
    	echo $_GET['callback'] . '('.json_encode(['msg'=>'成功']).')';
		
	}
	public function send_u(){
		$content = I('param.content');
		$m_to= $this->m_to();
		$admin_id = str_replace('a_', '', $m_to);
		$admin = M('admin')->field('openid')->where('id="%s"',$admin_id)->find();
		$url = $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].'/shop/index.php/admin/message';
		$obj = new \Org\Wechat\Msg();
		$text = "有新的咨询\n【{$content}】\n进入 <a href='{$url}'>管理员界面</a> 进行回复";
		$obj->customSendText($admin['openid'], $text);
		$this->send($m_to);
	}
	public function get_u(){
		$this->getMessage(false);
	}
	public function getRead(){
		$obj = M('message');
		$where = array(
				'isread'=>0,
				'm_to'=>$this->me
		);
		$count = $obj->where($where)->count(id);
		echo $_GET['callback'],'('.json_encode(['num'=>$count]).')';
	
	}
	private function m_to(){
	 	//找出最后一条信息   找出当前在线客服  客服角色是2
	 	//规则 1 上次在线  或者都不在线 给上一个  先给上一个客服
	 	//规则 2  上衣不在线  且有客服  随机给在线
		$msg_where = array(
				'm_from'=>$this->me,
				'm_to' => $this->me,
				'_logic' => 'OR'
		);
		$last_msg = M('message')->where($msg_where)->order('id desc')->find();
		
		$a_where = array(
				'role_id'=>2,
		);
		$admin = M('admin');
		$custom = $admin->field('id,online')->where($a_where)->select();
		$c_1 = $c_2 = [];
		foreach ($custom as $v){
			if($v['online'] == 1){
				$c_1[] = 'a_'.$v['id'];
			}else{
				$c_2[] = 'a_'.$v['id'];
			}
			
		}
		$c = empty($c_1) ? $c_2 : $c_1;
		
		if(empty($last_msg)){
			return $c[array_rand($c)];
		}
		$last_msg_a = $last_msg['m_to'] == $this->me ? $last_msg['m_from'] :$last_msg['m_to'] ;
		
		
		
		
		if(in_array($last_msg_a, $c) ){
			return $last_msg_a;
		}else{
			return $c[array_rand($c)] ;
		}
	}
	
    
}




