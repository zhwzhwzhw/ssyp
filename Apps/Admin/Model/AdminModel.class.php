<?php
namespace Admin\Model;
use Think\Model; 
class AdminModel extends Model{
	protected $_validate = array(
		 array('realname','require','姓名不能为空'), //默认情况下用正则进行验证
		 array('phone','require','联系电话不能为空'),
		 array('phone','','电话号码已经存在！',0,'unique',3),
		 array('phone','/^1\d{10}$/','电话号码不正确'),
	);
}