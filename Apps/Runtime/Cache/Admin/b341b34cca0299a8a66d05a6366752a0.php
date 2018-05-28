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
	$('.product-index,.product').addClass('active');
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
#detail tr th{width:auto !important;padding:0 !important;text-align:center;}
#detail tr th{width:30px !important;}
#jia,.norms_do .jian{cursor:pointer;float:left;background: no-repeat center center;width:32px;height:32px;}
.norms_do .jian{background-image:url(/ssyp/Public/Admin/images/jian.png)}
#jia{background-image:url(/ssyp/Public/Admin/images/jia.png);background-size:29px 29px;margin-top: -2px;}
.line_num{width:100%; background:none;border:none;text-align:center}
.submit_norms{width:20%;height:35px;display:block;margin:10px auto;}
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
		商品管理
		<small><?php echo ($title); ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"> </a></li>
		<li class="active"></li>
	</ol> 
					
</section>

                <section class="content">
				
				

<form onsubmit="return form_submit(this)" method="post" action="/ssyp/index.php/Admin/Product/saveNorms">
<table id="detail">
	<tr>
		<th colspan="8" class="det_title" >商品名：<?php echo ($data["name"]); ?>
		<input type="hidden" name="pro_id" value="<?php echo ($data["id"]); ?>" />
		</th>
	</tr>
	
	<tr>
		<th >行号</th>
		<th style="font-size:12px;">规格（尺寸,颜色）注意先后顺序 使用英文,</th>
		<th>销售价</th>
		<th>特惠价</th>
		<th>成本价</th>
		<th>库存量</th>
		<!--<th>当前状态（0表示隐藏 1表示再用）</th>-->
		<th >操作</th>
	</tr>
	<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr class="norms_tr">
			<th style="padding:0">
			<input type="hidden" name="norms_id[]" value="<?php echo ($v["id"]); ?>">
			<input value="id_<?php echo ($v["id"]); ?>" type="text" readonly name="line_num[]" class="line_num"></th>
			<td>
				<input onclick="normsSet(this,event)" type="text" value="<?php echo ($v["norms"]); ?>" name="norms[]" style="border:1px solid #ddd">
			</td>
			<td>
				<input type="text" value="<?php echo ($v["pro_norms"]); ?>"  name="pro_norms[]" style="border:1px solid #ddd">
			</td>
			<td>
				<input type="text" value="<?php echo ($v["discount_norms"]); ?>" name="discount_norms[]" style="border:1px solid #ddd">
			</td>
			<td>
				<input type="text" value="<?php echo ($v["cost_norms"]); ?>" name="cost_norms[]" style="border:1px solid #ddd">
			</td>
			<td>
				<input type="text" value="<?php echo ($v["number_norms"]); ?>" name="number_norms[]" style="border:1px solid #ddd">
			</td>
			<!--<td>
				<input type="text" value="<?php echo ($v["norms_status"]); ?>" name="norms_status[]" style="border:1px solid #ddd">
			</td>-->
			<th class="norms_do" style="padding:0">
				<div class="jian" onclick="jian(this,'<?php echo ($v["id"]); ?>')" ></div>
			</th>
		</tr><?php endforeach; endif; ?>
	<tr class="norms_tr">
		<th style="padding:0"><input value="1" type="text" readonly name="line_num[]" class="line_num"></th>
		<td>
			<input onclick="normsSet(this,event)" type="text" name="norms[]" style="border:1px solid #ddd">
		</td>
		<td>
			<input type="text" value="<?php echo ($data["pro_price"]); ?>" name="pro_norms[]" style="border:1px solid #ddd">
		</td>
		<td>
			<input type="text" value="<?php echo ($data["discount_price"]); ?>" name="discount_norms[]" style="border:1px solid #ddd">
		</td>
		<td>
			<input type="text" value="<?php echo ($data["cost_price"]); ?>" name="cost_norms[]" style="border:1px solid #ddd">
		</td>
		<td>
			<input type="text" value="<?php echo ($data["pro_number"]); ?>" name="number_norms[]" style="border:1px solid #ddd">
		</td>
		<!--<td>
				<input type="text" value="1" name="norms_status[]" style="border:1px solid #ddd">
		</td>-->
		<th class="norms_do" style="padding:0">
			<div class="jian" onclick="jian(this)" ></div>
			<div id="jia" onclick="jia(this)" ></div>
		</th>
	</tr>
</table>

	<input type="submit" class="submit_norms" value="提&nbsp;&nbsp;&nbsp;交">
</form>

<table id="init_html" style="display:none">
		<tr class="norms_tr">
		<th style="padding:0"><input  type="text" readonly name="line_num[]" class="line_num"></th>
		<td>
			<input onclick="normsSet(this,event)" type="text" name="norms[]" style="border:1px solid #ddd">
		</td>
		<td>
			<input type="text" value="<?php echo ($data["pro_price"]); ?>" name="pro_norms[]" style="border:1px solid #ddd">
		</td>
		<td>
			<input type="text" value="<?php echo ($data["discount_price"]); ?>" name="discount_norms[]" style="border:1px solid #ddd">
		</td>
		<td>
			<input type="text" value="<?php echo ($data["cost_price"]); ?>" name="cost_norms[]" style="border:1px solid #ddd">
		</td>
		<td>
			<input type="text" value="<?php echo ($data["pro_number"]); ?>" name="number_norms[]" style="border:1px solid #ddd">
		</td>
		<td>
				<input type="text" value="1" name="norms_status[]" style="border:1px solid #ddd">
		</td>
		<th class="norms_do" style="padding:0">
			<div class="jian" onclick="jian(this)" ></div>
			<div id="jia" onclick="jia(this)" ></div>
		</th>
	</tr>
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
	
        
<script src="/ssyp/Public/Admin/js/norms-Set.js"></script>
<script>
var c_json = '<?php echo ($c_json); ?>';
var norms = $.parseJSON( c_json );
var province = norms[0].data
var area1 = norms[1].data
function jian(t,ids){
	if(ids){
		if(!confirm('删除后不能恢复，确定删除？'))return false;
		$.ajax({
			'url':'/ssyp/index.php/Admin/Product/delNorms',
			'type':'post',
			'data':{'id':ids}
		})
	}
	if($('#detail').find('.norms_tr').length > 1){
		//alert($(t).parents('.norms_tr').next('.norms_tr').length)
		if($(t).parents('.norms_tr').next('.norms_tr').length <= 0){
			jia_str = '<div id="jia" onclick="jia(this)" ></div>'
			$(t).parents('.norms_tr').prev().find('.norms_do').append(jia_str);
		}
		$(t).parents('.norms_tr').remove();
	}else{
		alert('至少填写一项规格');
	}
}
function jia(t){
	var last = $(t).parents('.norms_tr').find('.line_num').val();
	last = parseInt(last);
	if(last<=0 || isNaN(last)){
		last = 0;
	}
	$('#init_html').find('.line_num').attr('value',(last+1));
	var init_html = $('#init_html').html();
	$('#detail').append(init_html);
	$(t).remove();
}
</script>

    </body>
</html>