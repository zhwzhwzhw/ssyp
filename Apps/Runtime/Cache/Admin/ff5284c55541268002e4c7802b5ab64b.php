<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="/ssyp/Public/Statics/css/reset.css" type="text/css" rel="stylesheet"/>
		<link href="/ssyp/Public/Statics/css/common.css" type="text/css" rel="stylesheet"/>
		<!-- bootstrap 3.0.2 -->
        <link href="/ssyp/Public/Admin/css//bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="/ssyp/Public/Admin/css//font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="/ssyp/Public/Admin/css//ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="/ssyp/Public/Admin/css//AdminLTE.css" rel="stylesheet" type="text/css" />
        <title><?php echo ($title); ?></title>
		<script src="/ssyp/Public/Admin/js/jquery.min.js"></script>
        <script src="/ssyp/Public/Admin/js/jquery.min.js"></script>
		<script src="/ssyp/Public/Statics/js/Popt.js"></script>
		<script src="/ssyp/Public/Statics/js/cityJson.js"></script>
		<script src="/ssyp/Public/Statics/js/citySet.js"></script>
		<link href="/ssyp/Public/Statics/css/city.css" type="text/css" rel="stylesheet"/>

		
		<script src="/ssyp/Public/Statics/laydate/laydate.js"></script>	
		<script src="/ssyp/Public/Statics/layer/layer.js"></script>
		<script src="/ssyp/Public/Statics/js/upload_mobi_yb.js"></script>
		<script src="/ssyp/Public/Statics/js/request.js"></script>
		<script>
		$(function(){
			$('.<?php echo (CONTROLLER_NAME); ?>,.<?php echo (CONTROLLER_NAME); ?>-<?php echo (ACTION_NAME); ?>').addClass('active');
		})
		</script>
		
<link type="text/css" rel="stylesheet" href="/ssyp/Public/Statics/css/calendar-pro.css">
<script type="text/javascript" src="/ssyp/Public/Statics/js/calendar-pro.js"></script>
<script>
$(function(){
	$('.product-index,.product').addClass('active');
})

</script>

    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="/ssyp/index.php/Admin/Index/index" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <?php if($user_base["role_id"] == -1): ?>总管理员
                <?php elseif(($user_base["role_id"] == 0) OR ($role["role_name"] == '')): ?>未分配角色
                <?php else: echo ($role["role_name"]); endif; ?>
                
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <a style="display:block;color:#fff;font-size:16px;margin:10px" href="/ssyp/index.php/Admin/Common/logout">【退出】</a>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">                
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                        	<?php if($user_base["headimgurl"] != ''): ?><img src="<?php echo ($user_base["headimgurl"]); ?>" class="img-circle" alt="" />
                        	<?php else: ?>
                            	<img src="/ssyp/Public/Admin/images//headimgurl.png" class="img-circle" alt="" /><?php endif; ?>
                        </div>
                        <div class="pull-left info">
                            <p><?php echo ($time_msg); ?>好, <?php echo ($user_base["realname"]); ?></p>
                            <a href="/ssyp/index.php/Admin/Admin/selfMsg"><i class="fa fa-circle text-success"></i> 个人信息修改</a>
                        </div>
                    </div>
                   
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    
                    <ul class="sidebar-menu">
                    	<?php if(is_array($menu)): foreach($menu as $key=>$v): if($v["class_name"] == 'treeview'): ?><li class="<?php echo ($v["class_name"]); ?> <?php echo ($v["controller"]); ?>">
		                            <a href="#">
		                                <span><?php echo ($v["name"]); ?></span>
		                                <i class="fa fa-angle-left pull-right"></i>
		                            </a>
		                            <ul class="treeview-menu">
		                            	<?php if(is_array($menu)): foreach($menu as $key=>$sv): if(($v["id"]) == $sv["fid"]): ?><li class="<?php echo ($sv["controller"]); ?>-<?php echo ($sv["action"]); ?>"><a href="/ssyp/index.php/Admin/<?php echo ($sv["controller"]); ?>/<?php echo ($sv["action"]); ?>"><i class="fa fa-angle-double-right"></i> <?php echo ($sv["name"]); ?></a></li><?php endif; endforeach; endif; ?>
		                            </ul>
		                        </li>
		                    <?php elseif($v["class_name"] == '1'): ?>
		                    	<li class="<?php echo ($v["controller"]); ?>">
		                            <a href="/ssyp/index.php/Admin/<?php echo ($v["controller"]); ?>/<?php echo ($v["action"]); ?>">
		                                 <span><?php echo ($v["name"]); ?></span> <small class="badge pull-right bg-green"></small>
		                            </a>
		                        </li><?php endif; endforeach; endif; ?>
                    	
                    	
	                    <!-- <li class="user">
                                                    <a href="/ssyp/index.php/Admin/User/index">
                                                         <span>用户管理</span> <small class="badge pull-right bg-green"></small>
                                                    </a>
                                                </li> -->
                       <!--  <li class="shop">
                            <a href="/ssyp/index.php/Admin/Shop/index">
                                 <span>微店营销</span> <small class="badge pull-right bg-green">new</small>
                            </a>
                        </li> -->
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Right side column. Contains the navbar and content of the page -->
		    <aside class="right-side">  
				
<section class="content-header">
	<h1>
		商品管理
		<small>商品列表</small>
	</h1>
</section>

                <section class="content">
				
				
<form style="margin-bottom: 10px">
<div id="where" class="clearfix" style="display: inline-block;width:55%">

	<dl>
		<dt>发布日期：</dt>
		<dd>
			<input id="pub_time_1" type="text" name="pub_time_start" value="<?php echo ($start); ?>" style="padding:3px"> 至
			<input id="pub_time_2" type="text" name="pub_time_end" value="<?php echo ($end); ?>" style="padding:3px">
			<!--<input type="hidden" name="p|pub_time[e]" value="between">
			<input type="hidden" name="p|pub_time[call]" value="strtotime">-->
		</dd>
	</dl>
	<dl>
		<dt>供货商：</dt>
		<dd>
			<input type="text" name="supply" value="<?php echo ($supply); ?>" placeholder="模糊搜索" style="padding:3px">
			<!--<input type="hidden" name="supply" value="like">-->
		</dd>
	</dl><br/>
	<!--<dl>
		<dt>下单日期：</dt>
		<dd>
			<input id="pub_time_1_o" type="text" name="start" value="<?php echo ($_GET['start']); ?>"> 至
			<input id="pub_time_2_o" type="text" name="end" value="<?php echo ($_GET['end']); ?>">
		</dd>
	</dl>-->
</div>
<input class="where_submit" type="submit" value="搜索" style="display: inline-block;">
</form>
<table id="detail" class="list">
	<tr>
		<th colspan="7">
			当前条件下  已支付的销售量<?php echo ($z_else); ?>。 &nbsp;&nbsp;&nbsp;未支付的销售量<?php echo ($z_1); ?>。&nbsp;&nbsp;&nbsp;总库存量<?php echo ($z_number); ?>
		</th>
	</tr>
	<tr>
		<!-- <th></th> -->
		<th>产品信息</th>
		<th>销售信息</th>
		<th>规格</th>
		<th>编辑信息</th>
		<th>产品价格</th>
		<th>状态信息</th>
		<th>操作</th>
	</tr>
	<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
		<td>
			（id：<?php echo ($v["id"]); ?>）（编号：<?php echo ($v["symbol"]); ?>）<br/><?php echo ($v["name"]); ?><br/>
			所属分类：<?php echo ($v["category_str"]); ?>
		</td>
		<td>
			已支付总件数：<?php echo ($v["sell_pronum_else"]); ?> <br/>
			未支付总件数：<?php echo ($v["sell_pronum_1"]); ?>
		</td>
		<td>
			<?php if(is_array($v["norms"])): foreach($v["norms"] as $key=>$nv): ?><div><?php echo ($nv["norms"]); ?>(库存：<?php echo ($nv["number_norms"]); ?>)</div><?php endforeach; endif; ?>
		</td>
		<td>
			发布时间：<?php echo (date('Y-m-d H:i:s',$v["pub_time"])); ?><br/>
			上次修改时间：<?php if($v["edi_time"] > 0): echo (date('Y-m-d H:i:s',$v["edi_time"])); else: ?>未修改<?php endif; ?><br/>
		</td>
		<td>
			销售价格：<?php echo ($v["pro_price"]); ?><br/>
			特惠价格：<?php echo ($v["discount_price"]); ?><br/>
			成本价格：<?php echo ($v["cost_price"]); ?><br/>
		</td>
		<td>
			库存量：<?php echo ($v["pro_number"]); ?><br/>
			显示状态：<?php if($v["status_str"] == ''): ?>无<?php else: echo ($v["status_str"]); endif; ?><br/>
			排序值(0表示下架):<?php echo ($v["ordernum"]); ?><br/>
			是否特惠:
			<?php if($v["is_discount"] == 1): ?><a style="color:red" href="/ssyp/index.php/Admin/Product/changeGet/tb/product/id/<?php echo ($v["id"]); ?>/is_discount/2">当前特惠</a>
			<?php elseif($v["is_discount"] == 2): ?>
				<a href="/ssyp/index.php/Admin/Product/changeGet/tb/product/id/<?php echo ($v["id"]); ?>/is_discount/1">当前正常</a><?php endif; ?><br/>
		</td>
		<td>
			
			<a href="/ssyp/index.php/Admin/Product/update/id/<?php echo ($v["id"]); ?>">编辑</a><br>
			<a onclick="productDel(this) " data-id="<?php echo ($v["id"]); ?>">删除</a><br>
			<a href="/ssyp/index.php/Admin/Product/norms/id/<?php echo ($v["id"]); ?>">产品规格</a>
		</td>
	</tr><?php endforeach; endif; ?>
</table>
<div id="page"> <?php echo ($page); ?></div>
<script>
var pub_start = {
  elem: '#pub_time_1',
  format: 'YYYY/MM/DD hh:mm:ss',
  min: '2000-01-01 00:00:00', //设定最小日期为当前日期
  max: '2099-06-16 23:59:59', //最大日期
  istime: true,
  istoday: false,
  choose: function(datas){
	  pub_end.min = datas; //开始日选好后，重置结束日的最小日期
	  pub_end.start = datas //将结束日的初始值设定为开始日
  }
};
var pub_end = {
  elem: '#pub_time_2',
  format: 'YYYY/MM/DD hh:mm:ss',
  min: '2000-01-01 00:00:00',
  max: '2099-06-16 23:59:59',
  istime: true,
  istoday: false,
  choose: function(datas){
	  pub_start.max = datas; //结束日选好后，重置开始日的最大日期
  }
};
laydate(pub_start);
laydate(pub_end);
var pub_start_o = {
  elem: '#pub_time_1_o',
  format: 'YYYY/MM/DD hh:mm:ss',
  min: '2000-01-01 00:00:00', //设定最小日期为当前日期
  max: '2099-06-16 23:59:59', //最大日期
  istime: true,
  istoday: false,
  choose: function(datas){
	  pub_end_o.min = datas; //开始日选好后，重置结束日的最小日期
	  pub_end_o.start = datas //将结束日的初始值设定为开始日
  }
};
var pub_end_o = {
  elem: '#pub_time_2_o',
  format: 'YYYY/MM/DD hh:mm:ss',
  min: '2000-01-01 00:00:00',
  max: '2099-06-16 23:59:59',
  istime: true,
  istoday: false,
  choose: function(datas){
	  pub_start_o.max = datas; //结束日选好后，重置开始日的最大日期
  }
};

laydate(pub_start_o);
laydate(pub_end_o);
</script>


                </section>
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->


        <!-- jQuery UI 1.10.3 -->
		<script src="/ssyp/Public/validate/jquery-ui-1.10.3.custom.js"></script>
	    <script src="/ssyp/Public/Admin/js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="/ssyp/Public/Admin/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
       <!--  <script src="/ssyp/Public/Admin/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script> -->
        <!-- Bootstrap WYSIHTML5 -->
        <script src="/ssyp/Public/Admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="/ssyp/Public/Admin/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="/ssyp/Public/Admin/js/AdminLTE/app.js" type="text/javascript"></script>
        <script src="/ssyp/Public/Admin/js/plugins/layer/layer.js"></script>
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
       <!-- <script src="/ssyp/Public/Admin/js/AdminLTE/dashboard.js" type="text/javascript"></script> -->
	
        
<script>
var product_id;
var use_start;
var use_end;
function data_num(id,start,end){
	product_id = id;
	use_start = start;
	use_end = end;
	layer.open({
	  type: 1,
	  skin: 'layui-layer-rim', //加上边框
	  area: ['512px', '388px'], //宽高
	  content: '<div  class="calendar-box demo-box"></div>'
	});
	$.ajax({
		'url':'/ssyp/index.php/Admin/Product/dateJson',
		'data':{'id':id},
		'dataType':'json',
		'success':function(re){
			$('.calendar-box').calendar({
				ele : '.demo-box', //依附
				title : '选择预约时间',
				beginDate : start,
				endDate : end,
				data : re
			});
		}
	})
}

//点击日历 填写数字
function click_date_ext(){
	var data = $('.calendar-box').calendarGetActive();
	layer.prompt({title: '输 '+data.date+' 的预定限制数量', formType: 3}, function(number, index){
	  layer.close(index);
	  $.ajax({
		'url':'/ssyp/index.php/Admin/Product/dataNum',
		'type':'post',
		'data':{'id':product_id,'date':data.date,'num':number},
		'success':function(re){
			if(re == '1'){
				layer.closeAll();
				data_num(product_id,use_start,use_end);
			}
		}
	  })
	});
	//alert(data.date+" "+data.money);
}
//商品删除
function productDel(obj){
    var id=$(obj).data('id');
    layer.confirm('删除后不能恢复，确认删除吗？', {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.ajax({
                'url':'/ssyp/index.php/Admin/Product/del',
                'type':'get',
                'data':{'id':id},
                'success':function(re){
                    if(re == '1'){
                        layer.closeAll();
                        data_num(product_id,use_start,use_end);
                    }
                }
            });
        layer.msg('的确很重要', {icon: 1});
    }, function(){
        layer.msg('也可以这样', {
            time: 20000, //20s后自动关闭
            btn: ['明白了', '知道了']
        });
    });
}
</script>

    </body>
</html>