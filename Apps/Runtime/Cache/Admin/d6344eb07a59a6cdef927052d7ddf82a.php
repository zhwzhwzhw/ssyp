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
		
<meta charset="UTF-8">
<style>
#detail th{width:30%;}
</style>
<script>
$(function(){
	$('.category-add,.category').addClass('active');
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
		分类管理
		<small><?php echo ($title); ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"> </a></li>
		<li class="active"></li>
	</ol> 
					
</section>

                <section class="content">
				
				
<ul id="head_menu" class="clearfix" <?php if(ACTION_NAME== 'update'): ?>style="display:none"<?php endif; ?>>
	<li <?php if($_GET['status']== 1): ?>class="active"<?php endif; ?> ><a href="/ssyp/index.php/Admin/Category/add/status/1">商品分类</a></li>
<!-- 	<li <?php if($_GET['status']== 2): ?>class="active"<?php endif; ?>><a href="/ssyp/index.php/Admin/Category/add/status/2">展示状态</a></li> -->
	<li <?php if($_GET['status']== 3): ?>class="active"<?php endif; ?>><a href="/ssyp/index.php/Admin/Category/add/status/3">商品规格</a></li>
</ul>
<br/>

<form onsubmit="return form_submit(this)" method="post" action="/ssyp/index.php/Admin/Category/save">
<input type="hidden" name="c_status"  value="<?php echo ($_GET['status']); ?>" >
<table id="detail">
	<tr>
		<th colspan="2" class="det_title" ><?php echo ($title); ?></if>
		<input type="hidden" name="id" value="<?php echo ($data["id"]); ?>">
		</th>
	</tr>
	
	
	<tr>
		<th>分类名称</th>
		<td>
			<input type="text" name="c_name" placeholder="分类名称" value="<?php echo ($data["c_name"]); ?>"/>
		</td>
	</tr>
 	<tr>
		<th>分类图标</th>
		<td>
			<input type="hidden" name="c_icons" value="<?php echo ($data["c_icons"]); ?>" />
			<img id="log_img_show" src="/ssyp/Uploads/<?php echo ($data["c_icons"]); ?>" <?php if($data["c_icons"] == ''): ?>style="display:none"<?php endif; ?> width="100px" alt="">
			<input id="log_images" type="button" value="上传/更换 图片" />
		</td>
	</tr> 
	<tr>
		<th>排序值（由大到小）0为不显示</th>
		<td>
			<input type="text" name="c_ordernum" placeholder="排序值" value="<?php echo ($data["c_ordernum"]); ?>"/>
		</td>
	</tr>
	
	<tr>
		<th>选择父级:<br/>1、商品管理不大于3级<br/>   2、展示状态请选择顶级分类 <br/>3、商品规格不大于2级</th>
		<td>
			<select name="fid[]" onchange="getType(this,'/ssyp/index.php/Admin/Category/getType')">
				<option value="0">顶级分类</option>
				<?php if(is_array($category_0)): foreach($category_0 as $key=>$v): ?><option <?php if(($v["id"]) == $first): ?>selected<?php endif; ?> value="<?php echo ($v["id"]); ?>"><?php echo ($v["c_name"]); ?></option><?php endforeach; endif; ?>
			</select>
			<?php if(is_array($c_list)): foreach($c_list as $key=>$v): ?><select name="fid[]" onchange="getType(this,'/ssyp/index.php/Admin/Category/getType')">
					<option value="<?php echo ($v['id']); ?>"><?php echo ($v["c_name"]); ?></option>
				</select><?php endforeach; endif; ?>
		</td>
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
	
        
<script src="/ssyp/Public/Admin/js/type-select.js"></script>
<script>
$(function(){
	h_upload('log_images','/ssyp/index.php/Admin/Upload/Upload','callback_sfz');
})
var oldImgName = '<?php echo ($data["log_images"]); ?>';
function callback_sfz(imgdata){
	if(oldImgName != ''){
		$.ajax({
			'url':'/ssyp/index.php/Admin/Upload/delImg',
			'type':'post',
			'data':{'imgname':oldImgName}
		});
	}
	oldImgName = imgdata;
	$('#log_img_show').show().attr('src','/ssyp/Uploads/'+imgdata)
	$('input[name="c_icons"]').val(imgdata);
}

</script>

    </body>
</html>