<?php
namespace Home\Model;
use Think\Model; 
class UserModel extends Model{
	protected $_validate = array(
		 array('realname','require','姓名不能为空'), //默认情况下用正则进行验证
		 array('webname','require','平台昵称不能为空'),
		 array('phone','require','联系电话不能为空'),
		 array('phone','','电话号码已经存在！',0,'unique',2),
		 array('phone','/^1\d{10}$/','电话号码不正确'),
		 //array('status','/^[1-9]\d*$/','选择用户类型'),
	);
}