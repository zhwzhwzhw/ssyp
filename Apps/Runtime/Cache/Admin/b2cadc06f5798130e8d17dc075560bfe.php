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
	$('.admin-add,.admin').addClass('active');
})
</script>
<meta charset="UTF-8">
<style>
#detail th{width:40%;}
.cate_fid select{width:20% !important;}
#detail th{width:20%;}
.images_unit{float:left;display:table-cell !important;width:200px;height:150px;position:relative;margin:3px;background:#fff;box-shadow: 0px 0px 5px #888888; vertical-align:middle;text-align:center;}
.images_unit img,.images_unit .images_but{max-width:200px;max-height:150px;vertical-align:middle;}
.images_unit>.close{background:#fff url(/ssyp/Public/Admin/images/close_16.png) no-repeat center center;width:20px;height:20px;position:absolute;top:0;right:0;border-radius:50%;}
.images_unit .num_wrap{background:#fff;border-top:1px solid #eee;position:absolute;bottom:0;width:100%;height:25px;line-height:25px;font-size:12px;}
.images_unit .num_wrap input{height:100%;width:50px};
</style>

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
		<small><?php echo ($title); ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"> </a></li>
		<li class="active"></li>
	</ol> 
					
</section>

                <section class="content">
				
				

<form onsubmit="return form_submit(this)" method="post" action="">
<table id="detail">
	<tr>
		<th colspan="2" class="det_title" >用户基本信息
		<input type="hidden" name="id" value="<?php echo ($data["id"]); ?>" />
		</th>
	</tr>
	<tr>
		<th>店铺名称</th>
		<td><input type="text" name="seller_name" placeholder="输入店铺名称" value="<?php echo ($data["seller_name"]); ?>"></td>
	</tr>
	<tr>
		<th>店铺描述</th>
		<td><textarea type="text" name="seller_des" placeholder="店铺描述" ><?php echo ($data["seller_des"]); ?></textarea></td>
	</tr>
	<tr>
		<th>店铺logo</th>
		<td>
			<input type="hidden" name="seller_logo" value="<?php echo ($data["seller_logo"]); ?>" />
			<img id="seller_logo_show" src="/ssyp/Uploads/<?php echo ($data["seller_logo"]); ?>" <?php if($data["seller_logo"] == ''): ?>style="display:none"<?php endif; ?> width="100px" alt="">
			<input id="seller_logo" type="button" value="上传/更换 图片" />
		</td>
	</tr>
	<tr>
		<th>联系电话</th>
		<td ><input type="text" name="seller_phone" placeholder="店铺联系电话" value="<?php echo ($data["seller_phone"]); ?>"></td>
	</tr>
	<tr>
		<th>店铺地址</th>
		<td ><input type="text" name="seller_address" placeholder="店铺地址" value="<?php echo ($data["seller_address"]); ?>"></td>
	</tr>
	<tr>
		<th>店铺坐标&nbsp;&nbsp;<a href="http://lbs.qq.com/tool/getpoint/" target="_blank" >获取坐标方法</a></th>
		<td ><input type="text" name="seller_position" placeholder="店铺坐标" value="<?php echo ($data["seller_position"]); ?>"></td>
	</tr>
	
	<tr>
		<th>允许分类：不选表示所有</th>
		<td>
			<?php if(is_array($category)): foreach($category as $key=>$v): ?><span style="display:inline-block;padding:3px 10px;">
					<input <?php if(in_array($v['id'],$cat)): ?>checked<?php endif; ?> type="checkbox" name="cat[]" value="<?php echo ($v["id"]); ?>">
					 <?php echo ($v["c_name"]); ?>
				 </span><?php endforeach; endif; ?>
		</td>
	</tr>
	
	<tr>
		<th colspan="2" class="th_br">
		
		</th>
	</tr>
	
	<tr>
		<th colspan="2" class="det_footer"><input type="submit" value="提&nbsp;&nbsp;&nbsp;交"></th>
	</tr>
</table>
</form>




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
$(function(){
	h_upload('seller_logo','/ssyp/index.php/Admin/Upload/Upload','seller_logo');
})
var oldImgName = '<?php echo ($data["seller_logo"]); ?>';
function seller_logo(imgdata){
	if(oldImgName != ''){
		$.ajax({
			'url':'/ssyp/index.php/Admin/Upload/delImg',
			'type':'post',
			'data':{'imgname':oldImgName}
		});
	}
	oldImgName = imgdata;
	$('#seller_logo_show').show().attr('src','/ssyp/Uploads/'+imgdata)
	$('input[name="seller_logo"]').val(imgdata);
}
</script>

    </body>
</html>