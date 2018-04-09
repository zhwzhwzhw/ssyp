<?php
namespace Home\Model;
use Think\Model; 
class OrdersModel extends Model{
	protected $_validate = array(
		 array('custom_phone','/^$|1\d{10}$/','电话号码不正确'),
	);
}