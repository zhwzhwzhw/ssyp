<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class OrdersController extends BaseController{
	public function excle(){
		$ids = $_POST['id'];
		if(empty($ids)){
			echo '<script>alert("请选择要导出的订单");history.go(-1)</script>';exit;
		}
	    import("Org.Net.PHPExcel");
		$obj = new \PHPExcel();
		
// 		$obj->getProperties()->setCreator("Maarten Balliauw");
// 		$obj->getProperties()->setLastModifiedBy("Maarten Balliauw");
// 		$obj->getProperties()->setTitle("Office 2007 XLSX Test Document");
// 		$obj->getProperties()->setSubject("Office 2007 XLSX Test Document");
// 		$obj->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
// 		$obj->getProperties()->setKeywords("office 2007 openxml php");
// 		$obj->getProperties()->setCategory("Test result file");
		$objActSheet = $obj->getActiveSheet();
		$objActSheet->getColumnDimension('A')->setWidth(20);//改变此处设置的长度数值
		$objActSheet->getColumnDimension('B')->setWidth(40);
		$objActSheet->getColumnDimension('C')->setWidth(20);
		$objActSheet->getColumnDimension('D')->setWidth(20);
		$objActSheet->getColumnDimension('E')->setWidth(20);
		$objActSheet->getColumnDimension('F')->setWidth(80);//改变此处设置的长度数值
		$objActSheet->getColumnDimension('G')->setWidth(20);
		$objActSheet->getColumnDimension('H')->setWidth(20);
		
		//设置sheet 索引
		$obj->setActiveSheetIndex(0);
		$objActSheet = $obj->getActiveSheet();
		//设置单元格为文本
		//$obj->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode("@");
		//设置当前sheet 的titile
		$objActSheet->setTitle('韵达快递');
		// 设置 栏目名称
		$objActSheet->setCellValue("A1","订单号");
		$objActSheet->setCellValue("B1","商品信息");
		$objActSheet->setCellValue("C1","备注");
		$objActSheet->setCellValue("D1","收件人姓名 ");
		$objActSheet->setCellValue("E1","收件人手机");
		$objActSheet->setCellValue("F1","收件人详细地址");
		$objActSheet->setCellValue("G1","收件人邮编");
		$objActSheet->setCellValue("H1","收件人公司");
		$where  = array(
				'id'=>array('in',join(',', $ids))
		);
 		$msg=M('orders');
		$data=$msg->where($where)->select();
		
		$where_op  = array(
				'ord_id'=>array('in',join(',', $ids))
		);
		$ord_pro = M('ordpro')->alias('op')
		->join(C('DB_PREFIX').'norms as n on n.id = op.norms_id')
		->join(C('DB_PREFIX').'product as p on op.pro_id = p.id')
		->where($where_op)
		->select();
		$i=2;
		foreach ($data as $key => $val){
			$str = '';
			$comment = $val['comment'];
			$comment = empty($comment) ? '' : '备注：'.$comment;
			foreach($ord_pro as $v){
				if($val['id'] == $v['ord_id']){
					$str .= "【{$v['name']}-{$v['norms']}(数量：{$v['ord_number']})".$comment."】";
				}
			}
			$objActSheet->setCellValue("A".$i,$val['bh']);
			$objActSheet->setCellValue("B".$i,$str);//商品信息
			$objActSheet->setCellValue("C".$i,$val['comment']);//备注
			$objActSheet->setCellValue("D".$i,$val['custom_name']); //收件人姓名
			$objActSheet->setCellValue("E".$i,$val['custom_phone']);//收件人手机
			$objActSheet->setCellValue("F".$i,$val['address']); //"收件人详细地址"
			$objActSheet->setCellValue("G".$i,""); //收件人邮编
			$objActSheet->setCellValue("H".$i,""); //收件人公司
			$i++;
		} 
		$write = new \PHPExcel_Writer_Excel5($obj);
		$name=date('Y/m/d H:i:s',NOW_TIME);
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");
		header('Content-Disposition:attachment;filename="'.$name.'.xls"');
		header("Content-Transfer-Encoding:binary");
		$write->save('php://output');
		//echo '<script>history.go(-1)</script>';
	}
	public function index(){
        $param       = I('param.');
        $where       = array();
        $id          = $param['id'];
        if($id){
            $where['id']=$id;
            $this->assign('id',$id);
        }
        $bh      = $param['bh'];
        if($bh){
            $where['bh'] = array('like',"%$bh%");
            $this->assign('bh',$bh);
        }
        $start       = strtotime($param['pub_time_start']);
        $end         = strtotime($param['pub_time_end']);
        if($start&&$end){
            $where['pub_time']=array('between',array($start,$end));
            $this->assign('start',$param['pub_time_start']);
            $this->assign('end',$param['pub_time_end']);
        }
        $status         = $param['status'];
        if($status){
            $where['status'] = $status;
            $this->assign('status',$status);
        }
        $role       = $_SESSION['admin']['role_id'];
        if($role!=-1){
            $where['shop_id']=$_SESSION['admin']['cat_shop'];
        }
		$Obj = M('orders');
		/*$search = searchWhere();
		$this->assign('assign',$search['assign']);
		$where = $search['where'] ;*/
		$totalRows =  $Obj->alias('o')->where($where)->count('id');
		$Page = new \Think\Page($totalRows,20);
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$list = $Obj
		->where($where)
		->limit($Page->firstRow,$Page->listRows)
		->order('id desc')
		->select();
		$ids = [];
		foreach ($list as $k=>$v){
			$ids[] = $v['id'];
		}

		$where_child = '';
		foreach ($list as $k=>$v){
			$where_child .= ( ( $where_child === '' ) ? '' : ',' ) . $v['id'] ;
		}
		if(!empty($where_child)){
			$obj = M('ordpro');
			$list_child = $obj->alias('op')->field('op.*,p.name,symbol')
			->where('ord_id in ('.$where_child.')')
		/*	->join(C('DB_PREFIX').'norms as n on n.id=norms_id')*/
			->join(C('DB_PREFIX').'product as p on p.id=op.pro_id')
			->select();
			foreach ($list as $k=>$v){
				foreach ($list_child as $k_c => $v_c){
					if($v['id'] == $v_c['ord_id']){
						$list[$k]['product'][] =$v_c;
					}
				}
			}
		}
		$ord_money =  $Obj->where($where)->sum('ord_money');
		$score_money =  $Obj->where($where)->sum('score_money');
		$mail_money = $Obj->where($where)->sum('mail_price');
		$this->assign('mail_money',$mail_money);
		//echo $Obj->getLastSql();
		$this->assign('ord_money',$ord_money);
		$this->assign('score_money',$score_money);
		$this->assign('totalRows',$totalRows);//总单数
		$pageStr = $Page->show();
		$this->assign('page',$pageStr);
		$this->assign('title','订单管理');
		$this->assign('list',$list);
		$this->display();
	}
	
	public function detail(){
    	$param = I('param.');
		$ord_id = $param['id'];
		$obj = M('ordpro');
		$where = array(
				'ord_id'=>$ord_id
		);
		$data = M('orders')->where('id="%s"',$ord_id)->find();
		if(empty($data)){
			echo '<script>alert("订单未找到");history.go(-1)</script>';
		}
		
		$ms_o = json_decode($data['money_share']);
		
		//分销积分
		if(is_numeric($data['money_share'])){
			$data['sell'] = 0;
		}else if(strpos($data['money_share'], '"') === false){
			$data['sell'] = $data['money_share'];
		}else{
			if($ms_o){
				$data['sell'] = 0;
				foreach ($ms_o as $v){
					$data['sell'] += $v->m;
				}
			}
		}
		$pay = M('pay')->where('attach="%s"',$ord_id)->find();
		
		$list = $obj->alias('op')->field('op.*,p.name,p.wx_image')
		->where('ord_id="%s"',$ord_id)
	/*	->join(C('DB_PREFIX').'norms as n on n.id=norms_id')*/
		->join(C('DB_PREFIX').'product as p on p.id=op.pro_id')
		->select();
		$this->assign('pay',$pay);
		$this->assign('data',$data);
		$this->assign('list',$list);
		$this->assign('title','订单详情');
		$this->display();
		
	}
	
	public function save(){
		$allow_field = ['comment_com','comment_admin','text','comment'];
		$_data = I('post.');
		$id = (int)$_data['id'];
		foreach ($_data as $k=>$v){
			if(!in_array($k,$allow_field)){
				unset($_data[$k]);
			}
		}
		$obj = M('Orders');
		$re = $obj->where('id="%s"',$id)->data($_data)->save();
		if($re){
			$this->success('修改成功');
		}else{
			$this->error('更改失败');
		}
		
	}
	//确认完成
	public function finish(){
		$ord_id = (int)I('get.id');
		$obj = M('orders');
    	$where = array(
    			'id'=>['eq',$ord_id],
    			'status'=>['eq',3],
    	);
    	$order = $obj->where($where)->find();
    	if(!strpos($order['mail_code'], '自提')){
    		$where['send_time'] =  [array('lt',NOW_TIME - 36000*24),array('gt',0),'and'];
    	}
    	
    	$_data['status'] = 9;
		$_data['confirm_time'] = NOW_TIME;
		$re = $obj->where($where)->data($_data)->save();
    	//echo $obj->_sql();//UPDATE `xgs_orders` SET `status`='9',`confirm_time`='1508125245' WHERE `id` = 22 AND `status` = 3 AND ( `send_time` < 1507261245 AND `send_time` > 0 )
    	if($re){
    		sellerData($ord_id);
    		$this->success('操作成功');
    	}else{
    		$this->error('操作失败,必须发货后10天 才可以执行此操作');
    	}
	}
	//发货
	public function send(){
		$id =  (int)I('post.id');
		$where['id'] = $id;
		$where['status'] = 2;
		$obj = M('orders');
		
		$_data['status'] = 3;
		$_data['mail_code'] = I('post.data') ;
		$_data['send_time'] = NOW_TIME;
		$re = $obj->where($where)->data($_data)->save();
		if($re){
			$this->success('发货成功');
		}else{
			$this->error('发货失败，请刷新重试');
		}
		
		
	}
	
	//删除
	public function del(){
		$ord_id = I('param.id');
		
    	if(empty($ord_id)){
    		$this->error('选择要删除的订单');
    	}
    	del_numAdd($ord_id);
    	$obj = M('orders');
    	$where = array(
    			'id'=>['eq',$ord_id],
    			'status'=>['eq',1]
    	);
    	$re = $obj->where($where)->delete();
    	if($re){
    		$re = M('ordpro')->where('ord_id="%s"',$ord_id)->delete();
    	}
    	if($re){
    		$this->success('删除成功');
    	}else{
    		$this->error('删除失败');
    	}
	}
	
	
	
}










