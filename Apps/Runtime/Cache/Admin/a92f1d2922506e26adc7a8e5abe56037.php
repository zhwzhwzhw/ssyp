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
		会员信息
		<small>会员列表</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"> </a></li>
		<li class="active"></li>
	</ol> 
					
</section>

                <section class="content">
				
				
	<!--<div class="detail">
		<a href="/ssyp/index.php/Admin/User/edbus" class="btn btn-large btn-update">添加团队</a>
	</div>-->
	<form style="margin-bottom: 10px"id="myform">
		<div id="where" class="clearfix" style="display: inline-block;width:30%">
			<dl>
				<dt style="margin-right: 14px;" >昵称：</dt>
				<dd>
					<input type="text" name="nickname"  value="<?php echo ($nickname); ?>" style="width: 100px;margin-right: 14px;padding:3px"  placeholder="">
				</dd>
			</dl>
			<dl>
				<dt>电话：</dt>
				<dd>
					<input type="text" name="phone"  value="<?php echo ($phone); ?>" style="width: 100px;padding:3px" placeholder="">
				</dd>
			</dl>
			<br/>
		</div>
		<button class="btn-groups btn-submit" style="cursor: pointer;display: inline;padding:3px;float: none;width: 60px" onclick="resetAll()" >重置</button>
		<input class="where_submit" type="submit" value="搜索" style="display: inline-block;width: 60px;margin-left: 20px">
	</form>
<table id="detail" class="list"><tr>
	<th colspan="7">
		当前用户总积分：<?php echo ($score); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		
		待审核的提现积分： <?php echo ($cash); ?> 
	</th>
	<tr>
		<th>id</th>
		<th>微信头像</th>
		<th>昵称</th>
		<!--<th>姓名</th>-->
		<th>电话</th>
		<!--<th>生日</th>-->
		
		<th>积分</th>
		<th>操作</th>
		
	</tr>
	<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
			<td><?php echo ($vo["id"]); ?></td>
			<td><img src="<?php echo ($vo["headimgurl"]); ?>" alt="" width="46px"></td>
			<td><?php if($vo["nickname"] == ''): ?>未获取<?php else: echo ($vo["nickname"]); endif; ?></td>
			<!--<td><?php echo ($vo["realname"]); ?></td>-->
			<td><?php echo ($vo["phone"]); ?></td>
			<!--<td><?php echo ($vo["birthday"]); ?></td>-->
			<td><?php echo ($vo["score"]); ?></td>
			<td>
				<a style="background-color: #3C8DBC; color: white;font-size: 16px;padding: 5px;" href="/ssyp/index.php/admin/admin/add?id=<?php echo ($vo["id"]); ?>&&nickName=<?php echo ($vo["nickname"]); ?>">设置为管理员</a>
				<a style="background-color: #3C8DBC; color: white;font-size: 16px;padding: 5px;" href="/ssyp/index.php/admin/user/task?user_id=<?php echo ($vo["id"]); ?>">打卡任务</a>
				<a style="background-color: #3C8DBC; color: white;font-size: 16px;padding: 5px;cursor: pointer" data-id="<?php echo ($vo["id"]); ?>" onclick="shenhe(this)">选择组别</a>
			</td>
		</tr><?php endforeach; endif; ?>
</table>
<div id="page"><?php echo ($page); ?></div>


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
	layer.alert('<img style="margin:auto;display: block;" src="/ssyp/index.php/Home/Public/ticket?size=6&host=1&content=<?php echo U('Home/Public/wxBind');?>?id='+id+'">',{
	  title:name+' 的微信绑定二维码',
	  skin: 'layer-ext-moon',
	  btn: 0	  
	})
}
function resetAll() {
    $("#myform").find('input[type=text],select,input[type=hidden]').each(function() {
        $(this).val('');
    });
    $("#work").val(0);
    $("#business").val(0);
    $("#sonbus").val(0);
    $("#status").val(0);
    /*$("input").val("");*/
}
function shenhe(obj){
    var id=$(obj).data('id');
    var html='<form method="post" action="/ssyp/index.php/Admin/User/usergroup"><div style="margin: 30px 30px 30px 85px"><label>组名:</label>' +
        '<select style="margin-left: 20px" name="group"><?php if(is_array($group)): foreach($group as $key=>$v): ?><option <?php if(($v["id"]) == $first): ?>selected<?php endif; ?> value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?></select></div>'+
        '<div style="text-align: center;margin-top: 17px;">' +
		'<input type="hidden" name="id" value="'+id+'"/>' +
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

    </body>
</html>