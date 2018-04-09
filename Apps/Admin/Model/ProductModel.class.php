<?php
namespace Admin\Model;
use Think\Model; 
class ProductModel extends Model{
	protected $_validate = array(
		 array('name','require','产品名称必填'), //默认情况下用正则进行验证
		 array('category','require','请选择分类'), //默认情况下用正则进行验证
	);
}