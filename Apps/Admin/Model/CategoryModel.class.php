<?php
namespace Admin\Model;
use Think\Model; 
class CategoryModel extends Model{
	protected $_validate = array(
		 array('c_name','require','分类名称不能为空'), //默认情况下用正则进行验证
	);
}