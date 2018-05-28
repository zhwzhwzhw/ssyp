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
		
<script>
$(function(){
	$('.orders,.orders-index').addClass('active');
});
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
		订单管理
		<small>订单列表</small>
	</h1>
</section>

                <section class="content">
				
				
<form>
<div id="where" class="clearfix" >
	<dl>
		<dt style="margin-right: 14px;" >订单id：</dt>
		<dd>
			<input type="text" name="id"  value="<?php echo ($id); ?>" style="width: 100px;margin-right: 14px;padding:3px"  placeholder="输入id">
			<!--<input type="hidden" name="id" value="eq">-->
		</dd>
	</dl>
	<dl>
		<dt>订单编号：</dt>
		<dd>
			<input type="text" name="bh"  value="<?php echo ($bh); ?>" style="width: 100px;padding:3px" placeholder="搜索订单编号">
		</dd>
	</dl>
    
	<br/><dl>
		<dt>下单日期：</dt>
		<dd>
			<input id="pub_time_1" type="text" name="pub_time_start" value="<?php echo ($start); ?>" style="width: 175px;padding:3px"> 至
			<input id="pub_time_2" type="text" name="pub_time_end" value="<?php echo ($end); ?>" style="width: 175px;padding:3px">
			<!--<input type="hidden" name="pub_time[e]" value="between">
			<input type="hidden" name="pub_time[call]" value="strtotime">-->
		</dd>
	</dl>
	<br/>
	<dl>
		<dt>订单状态：</dt>
		<dd>
			全部&nbsp;<input type="radio" name="status" <?php if($status == ''): ?>checked<?php endif; ?> value="" />&nbsp;&nbsp;&nbsp;
			已下单，待支付&nbsp;<input type="radio" name="status" <?php if($status === '1'): ?>checked<?php endif; ?> value="1" />&nbsp;&nbsp;&nbsp;
			已支付，待发货&nbsp;<input type="radio" name="status" <?php if($status === '2'): ?>checked<?php endif; ?> value="2" />&nbsp;&nbsp;&nbsp;
			已发货，待完成&nbsp;<input type="radio" name="status" <?php if($status === '3'): ?>checked<?php endif; ?> value="3" />&nbsp;&nbsp;&nbsp;
			已完成&nbsp;<input type="radio" name="status" <?php if($status === '9'): ?>checked<?php endif; ?> value="9" />&nbsp;&nbsp;&nbsp;
		</dd>
	</dl>
    <dl>
        <input class="where_submit" type="submit" value="搜索">
    </dl>
</div>
</form>
<form method="post" action="/ssyp/index.php/Admin/Orders/excle">
<table id="detail" class="list">
	<tr>
		<th colspan="6">
		共 <?php echo ($totalRows); ?> 单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		
		订单总金额 <?php echo ($score_money + $ord_money + $mail_money); ?> 元&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（包含邮费<?php echo ($mail_money); ?>，订单<?php echo ($ord_money); ?>，积分抵扣<?php echo ($score_money); ?>）
		<input style="border-radius:5px;color:#fff" type="submit" value="选中订单导出excle">
	</th>
	</tr>
	<tr>
 		<th><input  type="checkbox" onclick="check_click(this)"></th>
		<th>订单信息</th>
		<th>商品信息(商品，数量)</th>
		<th>客户信息</th>
		<th>物流信息</th>
		<th>操作</th>
	</tr>
	<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
			<td>
				<input type="checkbox" name="id[]" value="<?php echo ($v["id"]); ?>">
			</td>
			<td>
				订单id:<?php echo ($v["id"]); ?><br/>
				<a href="/ssyp/index.php/Admin/Orders/detail/id/<?php echo ($v["id"]); ?>">订单编号：<?php echo ($v["bh"]); ?></a><br/>
				下单时间：<?php echo (date('Y/m/d H:i',$v["pub_time"])); ?><br/>
			</td>
			<td>
				<table>
					<?php if(is_array($v["product"])): foreach($v["product"] as $key=>$pv): ?><tr>
							<th><?php echo ($pv["name"]); ?></th>
						<!--	<th><?php echo ($pv["norms"]); ?></th>-->
							<th><?php echo ($pv["ord_number"]); ?></th>
						</tr><?php endforeach; endif; ?>
				</table>
			</td>
			<td>
				姓名：<?php echo ($v["custom_name"]); ?><br/>
				电话：<?php echo ($v["custom_phone"]); ?><br/>
				地址：<?php echo ($v["address"]); ?>
			</td>
			<td>
				<a href="https://www.kuaidi100.com/chaxun?com=<?php echo (mail_code($v["mail_code"],0)); ?>&nu=<?php echo (mail_code($v["mail_code"],1)); ?>" target="_blank"><?php echo ($v["mail_code"]); ?></a>
			</td>
			<td>
				<?php if($v["status"] == 1): ?><a onclick="return confirm('确认删除吗')" href="/ssyp/index.php/Admin/Orders/del/id/<?php echo ($v["id"]); ?>">删除</a>
				<?php elseif($v["status"] == 2): ?>
					<a href="javascript:apply(<?php echo ($v["id"]); ?>)">发货</a>
				<?php elseif($v["status"] == 3): ?>
					<a href="/ssyp/index.php/Admin/Orders/finish/id/<?php echo ($v["id"]); ?>">确认完成</a>
				<?php elseif($v["status"] == 9): ?>
					已完成<?php endif; ?>
			</td>
		</tr><?php endforeach; endif; ?>
</table>
</form>
<div id="page"> <?php echo ($page); ?></div>
<script>
function check_click(t) {
    if ($(t).is(':checked')) { // 全选 
      $("input[name='id[]']").each(function () {
        $(this).attr("checked", true);
      });
    }
    else { // 取消全选 
      $("input[name='id[]']").each(function () {
        $(this).attr("checked", false);
      });
    }
};
function apply(id){
	layer.prompt({title: '输入快递单号', formType: 3,value:'韵达快运|'}, function(data, index){
	  //layer.close(index);
	  $.ajax({
		'url':'/ssyp/index.php/Admin/Orders/send',
		'type':'post',
		'data':{'id':id,'data':data},
		'success':function(res){
			if(res.status == 0){
				layer.msg(res.info);
			}else if(res.status == 1){
				layer.closeAll();
				layer.msg(res.info);
				setTimeout(function(){
					location.href=res.url
				},1000);
			}
		}
	  })
	})
}

var pub_start = {
		  elem: '#pub_time_1',
		  format: 'YYYY/MM/DD ',
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
		  format: 'YYYY/MM/DD ',
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
	
        

		
    </body>
</html>