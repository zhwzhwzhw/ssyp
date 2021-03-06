<?php
namespace Home\Controller;
class ProductController extends BaseController {
	private $where = array(
			'ordernum'=>['gt',0],
	);
	public function index(){
		$arr = $this->data();
		echo $_GET['callback'].'('.json_encode($arr).')';
	}
	public function status(){  //最新
		$type = getChildType();
		$pro = $this->data(false);
		$re = [];
		$i = 0 ;
		foreach ($type as $tv){
			foreach ($pro['data'] as $v){
				if(strpos($v['category'] , '>'.$tv['id'].'>') === 0){
					$re[$i]['pro'][] = $v;
				}
			}
			if(!empty($re[$i]['pro'])){
				$re[$i]['cname'] = $tv['c_name'];
				$i++;
			}
			
		}
		echo $_GET['callback'].'('.json_encode($re).')';
	}
	public function my_collect(){  //收藏的商品
		$param = I('param.');
		$user_id = $param['user_id'];
		$obj = M('user');
		$msg = $obj->field('collect')->where('id="%s"',$user_id)->find();
		if(empty($msg['collect'])){
			echo $_GET['callback'].'('.json_encode([]).')';exit;
		}
		$where['p.id']= array('in',$msg['collect']);
		$re = $this->data(false,$where);
		echo $_GET['callback'].'('.json_encode($re).')';
	}
	private function data($is_page = true,$map = array()){
		$size = I('get.size');
		$having = empty($size) ? '' : 'size like "%|'.$size.',%"';
		$order = $_GET['order'] ? $_GET['order'] : 'ordernum desc';
		$where_init = $this->where;
		if($map){
			$where_init = array_merge($where_init,$map);
		}
		$search = searchWhere($where_init);
		$where = $search['where'];
		$obj = M('product');
		if($is_page){
			$totalRows =  $obj->where($where)->alias('p')->join(C('DB_PREFIX').'norms as n on n.pro_id=p.id')->group('n.pro_id')->count('p.id');
			$page = new \Think\Page($totalRows,20);
		}
		$list = $obj->field('p.*,CONCAT("|",group_concat(norms separator "|"),"|") as size')
			->alias('p')
			->join(C('DB_PREFIX').'norms as n on n.pro_id=p.id')
			->where($where);
		if($is_page){
			$list = $list ->limit($page->firstRow,$page->listRows);
		}	
		
		$list = $list -> having($having)
			->group('n.pro_id')
			->order($order)
			->select();
		$list = getprice($list);
		$assign = $search['assign'];
		$arr = array(
				'data'=>$list,
				'param'=>$assign
		);
		
		return $arr;
	}
	public function detail(){
		$id     = (int)I('get.id');
		$obj    = M('product');
		$data   = $obj->where('id="%s"',$id)->find();
		$data   = getprice_1($data);
		$images = M('images')->where('pro_id="%s"',$id)->order('img_ordernum desc')->select();
		/*$norms = M('norms')->where('pro_id="%s" and norms_status="1"',$id)->select();*/
		/*foreach ($norms as $k=>$v){
			$norms[$k]['is_discount'] = $data['is_discount'];
		}
		$norms = getprice($norms);*/
		$relation = [];
		if(!empty($data['relation'])){
			$relation = $obj->where('id in ('.$data['relation'].')')->select();
			$relation = getprice($relation);
		}
		/*$a0 = [];
		$a1 = [];*/
		/*foreach ($norms as $v){
			$ar = explode(',', $v['norms']);
			if(!in_array($ar[0], $a0)){
				$a0[] = $ar[0];
			}
			if(!in_array($ar[1], $a1)){
				$a1[] = $ar[1];
			}
		}*/
		$arr = array(
				'product'=>$data,
				/*'norms'=>$norms,*/
				/*'norms_list'=>[$a0,$a1],*/
				'images'=>$images,
				'relation'=>$relation
		);
        $data['pro_detail']=plum_parse_img_path($data['pro_detail']);
        $this->assign('images',$images);
        $this->assign('detail',$data);
        $this->display();
	}
	/**
       轮播图接口
	 */
	public function turn(){
		$config = M('config')->find();
		echo $_GET['callback'].'('.$config['turn'].')';
	}
	//收藏商品
	public function collect(){
		$param = I('param.');
		$del = $param['del'];
		$user_id = $param['user_id'];
		$pro_id = $param['pro_id'];
		$obj = M('user');
		$msg = $obj->field('collect')->where('id="%s"',$user_id)->find();
		if(empty($msg['collect'])){
			$list = [];
			$collect = $pro_id ;
			$collect_del = '';
		}else{
			$ar = $del_ar = $list =  explode(',', $msg['collect']); //ar 添加 删除  列表
			foreach ($del_ar as $k=>$v){
				if($v == $pro_id){
					unset($del_ar[$k]);break;
				}
			}
			$collect_del = join(',', $del_ar);
			$ar[] = $pro_id;
			$ar = array_unique($ar);
			$collect = join(',', $ar);
		}
		if($pro_id){
			if($del){
				if($del == 'all') $collect_del= '';
				$re = $obj->where('id="%s"',$user_id)->data(['collect'=>$collect_del])->save();
			}else{
				$re = $obj->where('id="%s"',$user_id)->data(['collect'=>$collect])->save();
			}
			if($re){
				$arr = ['status'=>1,'msg'=>'收藏成功'];
			}else{
				$arr = ['status'=>0,'msg'=>'收藏失败'];
			}
			echo json_encode($arr);
		}else{
			echo json_encode($list);
		}
	}
	//商品列表
    public function goodsList(){
	    $param=I('param.');

        $obj    = M('product');
        if($param['type']==1){
            $where=array();
            $where['is_tj']=1;
            $data   = $obj->where($where)->order('ordernum desc')->select();
        }elseif ($param['type']==2){
            $where=array();
            $where['is_tj']=1;
            $data   = $obj->where($where)->order('sell_num desc')->select();
        }elseif ($param['type']==3){
            $where=array();
            $where['is_tj']=2;
            $data   = $obj->where($where)->order('ordernum desc')->select();
        }else{
            $where=array();
            $where['is_tj']=1;
            $data   = $obj->where($where)->order('ordernum desc')->select();
        }
        $this->assign('type',$param['type']);
       $this->assign('list',$data);
        $this->display();
    }
    //搜索商品
    public function search(){
        $param  = I('param.');
        $obj    = M('product');
        $where=array();
        $where['name']=array('like','%'.$param['name'].'%');
        $data   = $obj->where($where)->order('ordernum desc')->select();
        $this->assign('list',$data);
        $this->display();
    }
	//商品分类
    public function category(){
        $where = "fid=0 and c_status=1 and c_ordernum desc";
        $list  = M('category')->field('id,c_name')->where($where)->select();
        echo json_encode($list);
    }
	/**
     * 购物车
     */
	public function car(){
	    $param=I('param.');
	    $data=array(
	        'pro_id'=>$param['pro_id'],
            'user_id'=>$param['user_id'],
            'pro_name'=>$param['user_id'],
        );
	    $where=array();
	    $where['user_id']=$param['user_id'];
        $where['pro_id']=$param['pro_id'];
	    $shopcar=M('shopcar')->where($where)->find();
	    if($shopcar){
	        $re=M('shopcar')->where('id='.$shopcar['id'])->setInc('number');
            if($re){
                $arr = ['info'=>'成功','status'=>200];
                echo json_encode($arr);
            }else{
                $arr = ['info'=>'失败','status'=>404];
                echo json_encode($arr);
            }
        }else{
            $re=M('shopcar')->add($data);
            if($re){
                $arr = ['info'=>'成功','status'=>200];
                echo json_encode($arr);
            }else{
                $arr = ['info'=>'失败','status'=>404];
                echo json_encode($arr);
            }
        }
    }
}










