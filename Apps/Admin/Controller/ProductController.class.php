<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class ProductController extends BaseController{
	public function index(){
        $param       = I('param.');
        $start       = strtotime($param['pub_time_start']);
        $where       = array();
        if($start){
            $where['pub_time'] = array('egt',$start);
            $this->assign('start',$start);
        }
        $end         = strtotime($param['pub_time_end']);
        if($end){
            $where['pub_time'] = array('elt',$end);
            $this->assign('end',$end);
        }
        $supply      = $param['supply'];
        if($supply){
            $where['supply'] = array('like',"%$supply%");
            $this->assign('supply',$supply);
        }
		$proObj   = M('product');
		$id       = $_SESSION['admin']['id'];
        $role     = M('admin')->field('role_id,cat_shop')->where("id=$id")->find();
        if($role['role_id']!=-1){
            $where['p_cat_shop']=$role['cat_shop'];
        }
        /*$search   = searchWhere();*/
        /*	$where = $search['where'];*/
        /*	$assign = $search['assign'];
		$this->assign('assign',"%$assign%");*/
		$totalRows = $proObj->alias('p')
			->join(C('DB_PREFIX').'category as cs on cs.id = status','left')
			->where($where)
			->count('p.id');
		$Page = new \Think\Page($totalRows,20);
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$list = $proObj->field('p.*,cs.c_name as status_str')
			->alias('p')
			->join(C('DB_PREFIX').'category as cs on cs.id = status','left')//category_status
			->where($where)
			->limit($Page->firstRow,$Page->listRows)
			->order('p.id desc')
			->select();
		//订单日期处理
		$time_s = empty($_GET['start']) ? 0 : strtotime($_GET['start']);
		$time_e = empty($_GET['end']) ? 9999999999 : strtotime($_GET['end']);
		
		//拼产品条件 
		/*$where_o_init = $where;   */
		$where_o_init['o.pub_time'] = array('between',$time_s.' , '.$time_e); 
		$n_obj = M('norms');
		foreach ($list as $k=>$v){
			$orders = $proObj->alias('p')
			->join(C('DB_PREFIX').'norms as n on n.pro_id = p.id')
			->join(C('DB_PREFIX').'ordpro as op on n.id=op.norms_id')
			->join(C('DB_PREFIX').'orders as o on op.ord_id=o.id');
			$list[$k]['category_str'] = idToName($v['category']);
			$where_o = $where_o_init;
			$where_o['p.id'] = ['eq',$v['id']];
			
			$sell_pronum = $orders->field('op.ord_number,o.status')->where($where_o)->select();   //卖出的数量
			$list[$k]['sell_pronum_1'] = $list[$k]['sell_pronum_else'] = 0 ; 
			foreach ($sell_pronum as $sv){
				if($sv['status']  == 1){
					$list[$k]['sell_pronum_1'] ++ ;
				}else{
					$list[$k]['sell_pronum_else'] ++ ;
				}
			}
			$list[$k]['norms'] = $n_obj->where('pro_id="%s"',$v['id'])->select();   //规格
			
		}
		//总销售情况
		$zong_sell = $orders = $proObj->alias('p')
			->join(C('DB_PREFIX').'norms as n on n.pro_id = p.id')
			->join(C('DB_PREFIX').'ordpro as op on n.id=op.norms_id')
			->join(C('DB_PREFIX').'orders as o on op.ord_id=o.id')
			->field('op.ord_number,o.status')->where($where_o_init)->select();
		$z_1 = $z_else = 0 ;
		foreach ($zong_sell as $sv){
			if($sv['status']  == 1){
				$z_1 ++ ;
			}else{
				$z_else ++ ;
			}
		}
		//总库存
		$z_numner = $proObj
			->alias('p')
			->join(C('DB_PREFIX').'norms as c on p.id = pro_id')
			->where($where)
			->sum('number_norms');
		$this->assign('z_1',$z_1);
		$this->assign('z_else',$z_else);
		$this->assign('z_number',$z_numner);
		$pageStr = $Page->show();
		$this->assign('page',$pageStr);
		$this->assign('title','商品管理');
		$this->assign('list',$list);
		$this->display();
	}
	//添加商品
	public function add(){
		$data = array(
				'ordernum'=>50,
				'pro_number'=>0,
				'pro_price'=>0.00,
				'discount_price'=>0.00,
				'cost_price'=>0.00,
		);
		print_r($_SESSION['a']);
        echo $_SESSION['b'];
		$this->assign('data',$data);
		$ids = M('seller')->where('id="%s"',$_SESSION['admin']['cat_shop'])->getField('cat_list');
		$this->assign('category_0',getChildType(0,1,$ids));
		$this->assign('category_s2',$this->getStatus());
		$this->assign('title','商品添加');
		$this->display();
	}
	//保存商品
	public function save(){
		$_data = I('post.');
		/*foreach ($_data as $k=>$v){
			if(is_array($v) && strpos($v, 'task_') !== false){
				$_data[$k] = json_encode($v);
			}
		}*/
        $_data = $this->task($_data);
		$_data['pro_detail']  = $_POST['pro_detail'];
		$_data['size_notice'] = $_POST['size_notice'];
        $_data['p_cat_shop']  = $_SESSION['admin']['cat_shop'];
		list($_data['category'],$fid) = typeToStr($_POST['fid']);
		unset($_data['fid']);
		$id = ( isset($_data['id']) && (int)$_data['id']>0 ) ? (int)$_data['id'] : 0 ;
		unset($_data['id']);
		$obj = D('Product');
		if($id){
			$_data['edi_time'] = NOW_TIME;
			$_data['edi_user'] = $_SESSION['admin']['id'];
			if($obj->create($_data)){
				$this->save_images($_data['img_name'],$_data['img_ordernum'],$id,$_data['img_id']);
				$re = $obj->where('id="%s"',$id)->save();
			}else{
				$this->error($obj->getError());
			} 
		}else{
			$_data['pub_time'] = NOW_TIME;
			$_data['pub_user'] = $_SESSION['admin']['id'];
			if($obj->create($_data)){
				$re = $obj->add();
				$this->save_images($_data['img_name'],$_data['img_ordernum'],$re);
			}else{
				$this->error($obj->getError());
			} 
		}
		if($re){
			$this->success('发布成功',U('index'));
		}else{
			$this->error('发布失败');
		}
	}
	public function task($_data){
        $task_peicai=json_encode($_data['task_peicai']);
        $_data['task_peicai']=$task_peicai;
        $task_duanlian=json_encode($_data['task_duanlian']);
        $_data['task_duanlian']=$task_duanlian;
        $task_yinyue=json_encode($_data['task_yinyue']);
        $_data['task_yinyue']=$task_yinyue;
        $task_pingcha=json_encode($_data['task_pingcha']);
        $_data['task_pingcha']=$task_pingcha;
        $task_heshui=json_encode($_data['task_heshui']);
        $_data['task_heshui']=$task_heshui;
        $task_mingxiang=json_encode($_data['task_mingxiang']);
        $_data['task_mingxiang']=$task_mingxiang;
        return $_data;
    }
	public function update(){
		$id = (int)I('get.id');
		if(empty($id)){
			$this->redirect('Home/Public/not_found');
		}
		$obj = M('product');
		$data = $obj->where('id="%s"',$id)->find();
		list($first,$c_list) = (typeUpdate($data['category']));
		$this->assign('c_list',$c_list);
		$this->assign('first',$first);
		
		$ids = M('seller')->where('id="%s"',$_SESSION['admin']['cat_shop'])->getField('cat_list');
		$this->assign('category_0',getChildType(0,1,$ids));
		$this->assign('category_s2',$this->getStatus());
		foreach ($data as $k=>$v){
			if( strpos($k, 'task_') !== false ){
				$tmp_arr = [];
				$tmp_o = json_decode($v);
				foreach ($tmp_o as $ok=>$ov){
					$tmp_arr[$ok] = $ov;
				}
				$data[$k] = $tmp_arr;
			}
		}
		$this->assign('data',$data);
		
		$img = M('images');
		$img_list = $img->where('pro_id="%s"',$id)->select();
		$this->assign('img_list',$img_list);
		//var_dump($img_list);
		$this->assign('title','商品编辑');
		$this->display('add');
	}
	//获取最新最热等分类
	public function getStatus(){
		$obj = M('category');
		$list = $obj->where(['c_status'=>'2'])->select();
		return $list;
	}
	public function detail(){
		$id = (int)I('get.id');
		if(empty($id)){
			$this->redirect('Home/Public/not_found');
		}
		$obj = M('product');
		$data = $obj->where('p.id="%s"',$id)
		->field('p.*,u.webname as pub_webname')
		->alias('p')
		->join(C('DB_PREFIX') . 'user as u on p.pub_user = u.id','left')
		->find();
		$ord = M('orders');
		$ord_where = ['pro_id'=>$id,'is_pay'=>1];
		$ord_count = $ord->where($ord_where)->count('id');
		$ord_sum = $ord->where($ord_where)->sum('ord_number');
		$this->assign('ord_count',$ord_count);
		$this->assign('ord_sum',$ord_sum);
		$this->assign('data',$data);
		$this->assign('title','产品详情');
		$this->display('detail');
	}
	private function save_images($img_name,$img_ordernum,$pro_id,$img_id=array()){
		$obj = M('images');
		$arr = [];
		foreach ($img_name as $k=>$v){
			if($img_id[$k] > 0){
				$obj->where('id="%s"',$img_id[$k])->data(['img_ordernum'=>$img_ordernum[$k]])->save();
				continue;
			}
            $arr[] = array(
                'img_name'=>$v,
                'img_ordernum'=>$img_ordernum[$k],
                'pro_id'=>$pro_id
            );
		}
		$obj->addAll($arr);
	}
	
	private function getCatalog(){
		$obj = M('catalog');
		return $obj->field('id,log_name')->order('id desc')->select();
	}
	
	public function del_tb_img(){
		$id = I('get.id');
		$obj = M('images');
		$obj->where('id="%s"',$id)->delete();
	}
	
	public function norms(){
		$id = I('get.id');
		$product = M('product')->field('id,name,pro_price,discount_price,cost_price,pro_number')->where('id="%s"',$id)->find();
		
		$nor_f = getChildType(0,3);
		$category = M('category');
		$jsonArr = [];
		foreach ($nor_f as $k=>$v){
			$jsonArr[] = array(
					'fname'=>$v['c_name'],
					'data'=>$category->field('c_name as name')->where('fid="%s"',$v['id'])->select(),
			);
		}
		$this->assign('c_json',json_encode($jsonArr));
		
		$list = M('norms')->where('pro_id="%s"',$id)->select();
		$this->assign('list',$list);
		$this->assign('title','产品规格设置');
		$this->assign('data',$product);
		$this->display();
	}
	public function saveNorms(){
		$_data = I('post.');
		$obj = M('norms');
		$check = [];
		$addArr = [];
		foreach ($_data['norms'] as $k=>$v){
			if(empty($v)){
				continue;
			}
			if( substr_count($v,',') != 1){
				$this->error('行号为 '.$_data['line_num'][$k].' 的规格分隔符数量不符合');
			}
			$unit = array(
					'pro_id'=>$_data['pro_id'],
					'norms'=>$v,
					'pro_norms'=>$_data['pro_norms'][$k],
					'discount_norms'=>$_data['discount_norms'][$k],
					'cost_norms'=>$_data['cost_norms'][$k],
					'number_norms'=>$_data['number_norms'][$k],
					'norms_status'=>$_data['norms_status'][$k],
			);
			
			if(in_array($v,$check)){
				$this->error('行号为 '.$_data['line_num'][$k].' 的规格重复');
			}
			$norms_num = $obj->where('pro_id="%s"',$_data['pro_id'])->sum('number_norms');
			$norms_number=$norms_num+$_data['number_norms'][$k];
			$pro_num   = M('product')->where('id="%s"',$_data['pro_id'])->getField('pro_number');
			if($norms_number>$pro_num){
				$this->error('库存超过商品总库存');
			}
			$check[] = $v;
			if($_data['norms_id'][$k] > 0){
				$obj->where('id="%s"',$_data['norms_id'][$k])->data($unit)->save();
			}else{
				$addArr[] = $unit;
			}
		}
		$obj->addAll($addArr);
		$this->success('操作成功',__APP__."/admin/product/norms/id/".$_data['pro_id']);
	}
	
	public function delNorms(){
		$id = (int)I('post.id');
		$obj = M('norms');
		$obj->where('id="%s"',$id)->delete();
		echo 1;
	}
	public function turn(){
		$config = M('config')->find();
		$js_ob = json_decode($config['turn']);
		$js_ar = [];
		foreach ($js_ob as $k=>$v){
			$js_ar[$k]['img_name'] = $v->img;
			$js_ar[$k]['pro_id'] = $v->pro_id;
		}
		$this->assign('img_list',$js_ar);
		$this->assign('title','轮播图设置');
		$this->assign('id',$config['id']);
		$this->display();
	}
	public function turnsave(){
		$_data = I('post.');
		$config_id = $_data['id'];
		$re = [];
		foreach ($_data['img_name'] as $k=>$v){
			$re[] = array(
					'img'=>$v,
					'pro_id' => $_data['pro_id'][$k]
			);
		}
		$re = M('config')->where('id="%s"',$config_id)->data(['turn'=>json_encode($re)])->save();
		if($re){
			$this->success('上传成功');
		}else{
			$this->error('保存失败，请刷新重试');
		}
	}
	
	public function del(){
		$id = (int)I('get.id');
		$obj = M('product');
		$re = $obj->where('id="%s"',$id)->delete();
		/*if($re){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}*/
		if($re){
		    $data=array(
		        'ec'     => 200,
		        'msg'    => '删除成功',
                'action' => '__APP__/admin/product/index'
            );
		    echo json_encode($data);
        }else{
            $data=array(
                'ec'     => 404,
                'msg'    => '删除失败',
                'action' => '__APP__/admin/product/index'
            );
            echo json_encode($data);
        }
	}
}