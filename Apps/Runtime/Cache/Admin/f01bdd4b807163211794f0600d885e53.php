<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="/ssypday02/ssyp/Public/Statics/css/reset.css" type="text/css" rel="stylesheet"/>
		<link href="/ssypday02/ssyp/Public/Statics/css/common.css" type="text/css" rel="stylesheet"/>
		<!-- bootstrap 3.0.2 -->
        <link href="/ssypday02/ssyp/Public/Admin/css//bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="/ssypday02/ssyp/Public/Admin/css//font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="/ssypday02/ssyp/Public/Admin/css//ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="/ssypday02/ssyp/Public/Admin/css//AdminLTE.css" rel="stylesheet" type="text/css" />
        <title><?php echo ($title); ?></title>
		<script src="/ssypday02/ssyp/Public/Admin/js/jquery.min.js"></script>
		
		<script src="/ssypday02/ssyp/Public/Statics/js/Popt.js"></script>
		<script src="/ssypday02/ssyp/Public/Statics/js/cityJson.js"></script>
		<script src="/ssypday02/ssyp/Public/Statics/js/citySet.js"></script>
		<link href="/ssypday02/ssyp/Public/Statics/css/city.css" type="text/css" rel="stylesheet"/>

		
		<script src="/ssypday02/ssyp/Public/Statics/laydate/laydate.js"></script>	
		<script src="/ssypday02/ssyp/Public/Statics/layer/layer.js"></script>
		<script src="/ssypday02/ssyp/Public/Statics/js/upload_mobi_yb.js"></script>
		<script src="/ssypday02/ssyp/Public/Statics/js/request.js"></script>
		<script>
		$(function(){
			$('.<?php echo (CONTROLLER_NAME); ?>,.<?php echo (CONTROLLER_NAME); ?>-<?php echo (ACTION_NAME); ?>').addClass('active');
		})
		</script>
		
<script>
$(function(){
	$('.product-turn,.product').addClass('active');
})
</script>
<meta charset="UTF-8">
<style>
#detail th{width:40%;}
.cate_fid select{width:20% !important;}
#detail th{width:20%;}
.images_unit{float:left;display:table-cell !important;width:200px;height:150px;position:relative;margin:3px;background:#fff;box-shadow: 0px 0px 5px #888888; vertical-align:middle;text-align:center;}
.images_unit img,.images_unit .images_but{max-width:200px;max-height:150px;vertical-align:middle;}
.images_unit>.close{background:#fff url(/ssypday02/ssyp/Public/Admin/images/close_16.png) no-repeat center center;width:20px;height:20px;position:absolute;top:0;right:0;border-radius:50%;}
.images_unit .num_wrap{background:#fff;border-top:1px solid #eee;position:absolute;bottom:0;width:100%;height:25px;line-height:25px;font-size:12px;}
.images_unit .num_wrap input{height:100%;width:150px};
</style>

    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="/ssypday02/ssyp/index.php/Admin/Index/index" class="logo">
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
                    <a style="display:block;color:#fff;font-size:16px;margin:10px" href="/ssypday02/ssyp/index.php/Admin/Common/logout">【退出】</a>
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
                            	<img src="/ssypday02/ssyp/Public/Admin/images//headimgurl.png" class="img-circle" alt="" /><?php endif; ?>
                        </div>
                        <div class="pull-left info">
                            <p><?php echo ($time_msg); ?>好, <?php echo ($user_base["realname"]); ?></p>
                            <a href="/ssypday02/ssyp/index.php/Admin/Admin/selfMsg"><i class="fa fa-circle text-success"></i> 个人信息修改</a>
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
		                            	<?php if(is_array($menu)): foreach($menu as $key=>$sv): if(($v["id"]) == $sv["fid"]): ?><li class="<?php echo ($sv["controller"]); ?>-<?php echo ($sv["action"]); ?>"><a href="/ssypday02/ssyp/index.php/Admin/<?php echo ($sv["controller"]); ?>/<?php echo ($sv["action"]); ?>"><i class="fa fa-angle-double-right"></i> <?php echo ($sv["name"]); ?></a></li><?php endif; endforeach; endif; ?>
		                            </ul>
		                        </li>
		                    <?php elseif($v["class_name"] == '1'): ?>
		                    	<li class="<?php echo ($v["controller"]); ?>">
		                            <a href="/ssypday02/ssyp/index.php/Admin/<?php echo ($v["controller"]); ?>/<?php echo ($v["action"]); ?>">
		                                 <span><?php echo ($v["name"]); ?></span> <small class="badge pull-right bg-green"></small>
		                            </a>
		                        </li><?php endif; endforeach; endif; ?>
                    	
                    	
	                    <!-- <li class="user">
                                                    <a href="/ssypday02/ssyp/index.php/Admin/User/index">
                                                         <span>用户管理</span> <small class="badge pull-right bg-green"></small>
                                                    </a>
                                                </li> -->
                       <!--  <li class="shop">
                            <a href="/ssypday02/ssyp/index.php/Admin/Shop/index">
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
		<small><?php echo ($title); ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"> </a></li>
		<li class="active"></li>
	</ol> 
					
</section>

                <section class="content">
				
				

<form onsubmit="return form_submit(this)" method="post" action="/ssypday02/ssyp/index.php/Admin/Product/turnsave">
<table id="detail">
	<tr>
		<th colspan="2" class="det_title" >首页轮播展示
		<input type="hidden" name="id" value="<?php echo ($id); ?>">
		</th>
	</tr>
	
	<tr>
		<th>首页轮播图 375:300</th>
		<td class="clearfix">
		<?php if(is_array($img_list)): foreach($img_list as $key=>$v): ?><div class="images_unit">
				<div class="close" title="删除图片" onclick="del_images(this,'<?php echo ($v["img_name"]); ?>','<?php echo ($v["id"]); ?>')"></div>
				<input type="hidden" name="img_id[]" value="<?php echo ($v["id"]); ?>" />
				<input type="hidden" name="img_name[]" value="<?php echo ($v["img_name"]); ?>" />
				<img id="images_show" src="/ssypday02/ssyp/Uploads/<?php echo ($v["img_name"]); ?>">
				<div class="num_wrap">网址：<input type="text" name="pro_id[]" value="<?php echo ($v["pro_id"]); ?>"/></div>
			</div><?php endforeach; endif; ?>

			<input class="images_but" id="images_but" type="button" value="上传图片" />
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
		<script src="/ssypday02/ssyp/Public/validate/jquery-ui-1.10.3.custom.js"></script>
	    <script src="/ssypday02/ssyp/Public/Admin/js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="/ssypday02/ssyp/Public/Admin/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
       <!--  <script src="/ssypday02/ssyp/Public/Admin/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script> -->
        <!-- Bootstrap WYSIHTML5 -->
        <script src="/ssypday02/ssyp/Public/Admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="/ssypday02/ssyp/Public/Admin/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="/ssypday02/ssyp/Public/Admin/js/AdminLTE/app.js" type="text/javascript"></script>
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
       <!-- <script src="/ssypday02/ssyp/Public/Admin/js/AdminLTE/dashboard.js" type="text/javascript"></script> -->
	
        

<script>


$(function(){
	h_upload('wx_image_but','/ssypday02/ssyp/index.php/Admin/Upload/Upload','callback_wx_image');
	h_upload('images_but','/ssypday02/ssyp/index.php/Admin/Upload/Upload','callback_images');
})
var oldImgName = '<?php echo ($data["pro_images"]); ?>';
function callback_wx_image(imgdata){
	if(oldImgName != ''){
		$.ajax({
			'url':'/ssypday02/ssyp/index.php/Admin/Upload/delImg',
			'type':'post',
			'data':{'imgname':oldImgName}
		});
	}
	oldImgName = imgdata;
	$('#wx_image_show').show().attr('src','/ssypday02/ssyp/Uploads/'+imgdata)
	$('input[name="wx_image"]').val(imgdata);
}


function callback_images(imgdata){
	var wrap = '<div class="images_unit">\
	<div class="close" title="删除图片" onclick="del_images(this,\''+imgdata+'\')"></div>\
	<input type="hidden" name="img_name[]" value="'+imgdata+'" />\
	<img id="images_show" src="/ssypday02/ssyp/Uploads/'+imgdata+'">\
	<div class="num_wrap">网址：<input type="text" name="pro_id[]" /></div>\
	</div>';
	
	$('#images_but').before(wrap);
	
}
function del_images(t,imgName,id){
	if(!confirm('确定删除吗？'))return false;
	if(id){
		$.ajax({'url':'/ssypday02/ssyp/index.php/Admin/Product/del_tb_img/id/'+id})
	}
	$.ajax({
		'url':'/ssypday02/ssyp/index.php/Admin/Upload/delImg',
		'type':'post',
		'data':{'imgname':imgName},
		'success':function(re){
			$(t).parents('.images_unit').remove()
		}
	});
}

</script>

    </body>
</html>