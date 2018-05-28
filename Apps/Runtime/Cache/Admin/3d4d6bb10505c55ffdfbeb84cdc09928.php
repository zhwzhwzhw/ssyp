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
	$('.admin,.admin-index').addClass('active')
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
		管理员
		<small>管理员列表</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"> </a></li>
		<li class="active"></li>
	</ol> 
					
</section>

                <section class="content">
				
				
<table id="detail" class="list">
	<tr>
		<th>id</th>
		<th>手机号(登录账号)</th>
		<th>姓名</th>
		<th>角色</th>
		<th>店铺</th>
		<th>操作</th>
		<!-- <th>微信</th> -->
	</tr>
	<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
			<td><?php echo ($v["id"]); ?></td>
			<td><?php echo ($v["phone"]); ?></td>
			<td><?php echo ($v["realname"]); ?></td>
			<td>
				<?php if($v["role_id"] == -1): ?>总平台管理员
				<?php elseif($v["role_id"] == 0): ?>暂无权限
				<?php else: echo ($v["role_name"]); endif; ?>
			</td>
			<td>
				<?php if($v["cat_shop"] == 0): ?>总店
				<?php else: echo ($v["seller_name"]); endif; ?>
			</td>
			<td>
				
				<a href="/ssyp/index.php/Admin/Admin/update?id=<?php echo ($v["id"]); ?>">编辑</a>
				<a onclick="return confirm('请确认是否删除？')"  href="/ssyp/index.php/Admin/Admin/del?id=<?php echo ($v["id"]); ?>">删除</a>
			</td>
<!-- 			<td>
				<?php if($v["openid"] == ''): ?>未绑定：<a href="javascript:show_ticket('<?php echo ($v["realname"]); ?>','<?php echo ($v["id"]); ?>')">绑定二维码</a>
				<?php else: ?>
					已绑定：<a onclick="return confirm('请确认是否解除？')" href="/ssyp/index.php/Admin/Admin/changeGet/tb/admin/id/<?php echo ($v["id"]); ?>?openid=">解绑微信</a><?php endif; ?>
			</td> -->
		</tr><?php endforeach; endif; ?>
</table>


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
function show_ticket(name,id){
	$.ajax({
		'url':'/ssyp/index.php/Home/Wx/qrcode?user_id=admin_'+id+'',
		'success':function(res){
			layer.alert('<img style="margin:auto;display: block;width:200px;" src="'+res+'">',{
				  title:name+' 的微信绑定二维码',
				  skin: 'layer-ext-moon',
				  btn: 0	  
			})
		}
	})
	
}
</script>

    </body>
</html>