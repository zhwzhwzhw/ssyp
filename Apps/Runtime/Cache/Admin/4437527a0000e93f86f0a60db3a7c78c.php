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
		
	<link href="/ssyp/Public/Statics/css/common_18.css" type="text/css" rel="stylesheet"/>

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
							
                <!--<section class="content-header">
					<h1>
                        Blank page
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"> Home</a></li>
                        <li class="active">Blank page</li>
                    </ol> 
					
                </section>-->
				
                <section class="content">
				
				
	<div class="container">
		<!--<div class="title"><span ><?php echo ($title); ?></span></div>-->
		<div style="border-bottom: 1px solid #3c8dbc;font-size: 16px;padding-bottom: 10px;" >
			<span style="width: 200px;margin-left: 10px">
				<a style="color: #367FA9" href="/ssyp/index.php/admin//user/index">会员分组</a>
			</span>——>
			<span>任务完成情况</span>
		</div>
		<div style="margin-top: 0" class="detail">
			<a href="/ssyp/index.php/admin/user/addinfo?group_id=<?php echo ($group_id); ?>" class="btn btn-large btn-update">添加信息</a>
		</div>
		<div class="table-main">
			<table class="table">
				<thead>
				<tr class="th">
					<th>ID</th>
					<th>标题</th>
					<th>信息内容</th>
					<th>添加时间</th>
					<th>操作</th>
				</tr>
				</thead>
				<tbody>
				<?php if(is_array($info)): foreach($info as $key=>$v): ?><tr>
						<td><?php echo ($v["id"]); ?></td>
						<td><?php echo ($v["title"]); ?></td>
						<td><?php echo ($v["content"]); ?></td>
						<td><?php echo (date('Y-m-d H:i',$v["add_time"])); ?></td>
						<td>
							<a  href="/ssyp/index.php/Admin/User/addinfo?id=<?php echo ($v["id"]); ?>" class="btn btn-large  btn-update">编辑</a>
							<a href="/ssyp/index.php/Admin/User/delgroup?id=<?php echo ($v["id"]); ?>" class="btn btn-large btn-delete">删除</a>
						</td>
					</tr><?php endforeach; endif; ?>
				</tbody>
			</table>
		</div>
		<div class="paging" >
			<div class="page">
				<?php echo ($page); ?>
			</div>
		</div>
		<!--  <div class="paging" >
              <div class="page">
                  <a class="prev" href="#">上一页</a>
                  <span class="current">1</span>
                  <a class="num" href="#">2</a>
                  <a class="num" href="#">3</a>
                  <a class="num" href="#">4</a>
                  <a class="num" href="#">5</a>
                  <a class="next" href="#">下一页</a>
              </div>
          </div>  -->

	</div>
	<script>
        function shenhe(obj){
            var html='<form method="post" action="/ssyp/index.php/Admin/User/addgroup"><div style="margin: 30px"><label>组名:</label>' +
                '<input type="text" name="group"style="margin-left: 10px" value=""/></div>'+
                '<div style="text-align: center;margin-top: 17px;">' +
				'<input type="submit" value="提&nbsp;&nbsp;&nbsp;交" style="margin-right: 40px;padding: 0px 4px;">' +
				'<input type="reset" value="取&nbsp;&nbsp;&nbsp;消" style="padding: 0px 4px;"></div>' +
				'</from>';
            layer.open({
                type: 1,
                skin: '', //加上边框
                area: ['320px', '180px'], //宽高
                content: html
            });
        }
        function editor(obj){
            var id=$(obj).data('id');
            var name=$(obj).data('name');
            var html='<form method="post" action="/ssyp/index.php/Admin/User/addgroup?id='+id+'"><div style="margin: 30px"><label>组名:</label>' +
                '<input type="hidden" name="id" value="'+id+'"/>' +
				'<input type="text" name="group"style="margin-left: 10px" value="'+name+'"/></div>'+
                '<div style="text-align: center;margin-top: 17px;">' +
                '<input type="submit" value="提&nbsp;&nbsp;&nbsp;交" style="margin-right: 40px;padding: 0px 4px;">' +
                '<input type="reset" value="取&nbsp;&nbsp;&nbsp;消" style="padding: 0px 4px;"></div>' +
                '</from>';
            layer.open({
                type: 1,
                skin: '', //加上边框
                area: ['320px', '180px'], //宽高
                content: html
            });
        }
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