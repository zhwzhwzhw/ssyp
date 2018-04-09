<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class ShareController extends BaseController{
	public function index(){
		$news_id = (int)I('get.news_id');
		$obj = M('share');
		$totalRows = $obj->count('id');
		$Page = new \Think\Page($totalRows,20);
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$list = $obj->field('s.*,u.nickname,n.title')
					->alias('s')
					->join(C('DB_PREFIX').'news as n on n.id = news_id','left')
					->join(C('DB_PREFIX').'user as u on u.id=user_id','left')
					->limit($Page->firstRow.','.$Page->listRows)
					->where('news_id="%s"',$news_id)
					->order('id desc')
					->select();
		$pageStr = $Page->show();
		$this->assign('page',$pageStr);
		$this->assign('list',$list);
		$this->assign('title','动态列表');
		$this->display();
	}
	
	
	
}