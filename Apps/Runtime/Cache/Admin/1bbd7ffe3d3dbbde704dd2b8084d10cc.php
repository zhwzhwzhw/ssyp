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
	$('.product-add,.product').addClass('active');
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
.images_unit .num_wrap input{height:100%;width:50px}
.task_msg{width:300px !important;}
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
				
				

<form onsubmit="return form_submit(this)" method="post" action="/ssyp/index.php/Admin/Product/save">
<table id="detail">
	<tr>
		<th colspan="2" class="det_title" >商品基本信息
		<input type="hidden" name="id" value="<?php echo ($data["id"]); ?>" />
		</th>
	</tr>
	<tr>
		<th>商品分类</th>
		<td class="cate_fid">
			<select name="fid[]" onchange="getType(this,'/ssyp/index.php/Admin/Category/getType')">
				<option value="0">--请选择--</option>
				<?php if(is_array($category_0)): foreach($category_0 as $key=>$v): ?><option <?php if(($v["id"]) == $first): ?>selected<?php endif; ?> value="<?php echo ($v["id"]); ?>"><?php echo ($v["c_name"]); ?></option><?php endforeach; endif; ?>
			</select>
			<?php if(is_array($c_list)): foreach($c_list as $key=>$v): ?><select name="fid[]" onchange="getType(this,'/ssyp/index.php/Admin/Product/getType')">
					<option value="<?php echo ($v['id']); ?>"><?php echo ($v["c_name"]); ?></option>
				</select><?php endforeach; endif; ?>
		</td>
	</tr>
	<tr>
		<th>商品名称</th>
		<td><input type="text" name="name" placeholder="填写商品名称" value="<?php echo ($data["name"]); ?>"></td>
	</tr>
	<tr>
		<th>商品货号</th>
		<td><input type="text" name="symbol" placeholder="填写商品货号" value="<?php echo ($data["symbol"]); ?>"></td>
	</tr>
	<!--<tr>
		<th>供应商</th>
		<td><input type="text" name="supply" placeholder="填写供应商" value="<?php echo ($data["supply"]); ?>"></td>
	</tr>-->
	<tr>
		<th>价格</th>
		<td><input type="text" name="pro_price" placeholder="价格" value="<?php echo ($data["pro_price"]); ?>"></td>
	</tr>
	<tr>
		<th>特惠价</th>
		<td><input type="text" name="discount_price" placeholder="特惠时间段的价格" value="<?php echo ($data["discount_price"]); ?>"></td>
	</tr>
	<!--<tr>
		<th>成本价</th>
		<td><input type="text" name="cost_price" placeholder="成本价" value="<?php echo ($data["cost_price"]); ?>"></td>
	</tr>-->
	<tr>
		<th>库存数量（总数）</th>
		<td><input type="text" name="pro_number" placeholder="库存数量" value="<?php echo ($data["pro_number"]); ?>"></td>
	</tr>
	<tr>
		<th>推荐排序值（1-99 0表示下架 推荐优先由大到小 ）</th>
		<td><input type="text" name="ordernum" placeholder="推荐排序值 " value="<?php echo ($data["ordernum"]); ?>"> </td>
	</tr>
	<!--<tr>
		<th>商品备注（仅后台可见）</th>
		<td><input type="text" name="pro_comment" placeholder="商品备注" value="<?php echo ($data["pro_comment"]); ?>"></td>
	</tr>-->
	<tr>
		<th>封面图片（165:195）</th>
		<td>
			<input type="hidden" name="wx_image" value="<?php echo ($data["wx_image"]); ?>" />
			<img id="wx_image_show" src="/ssyp/Uploads/<?php echo ($data["wx_image"]); ?>" <?php if($_GET['id']== ''): ?>style="display:none"<?php endif; ?> width="200px" alt="">
			<input id="wx_image_but" type="button" value="上传/更换 图片" />
			
		</td>
	</tr>
	<tr>
		<th>商品图片（商品详情轮播） 305:420</th>
		<td class="clearfix">
		<?php if(is_array($img_list)): foreach($img_list as $key=>$v): ?><div class="images_unit">
				<div class="close" title="删除图片" onclick="del_images(this,'<?php echo ($v["img_name"]); ?>','<?php echo ($v["id"]); ?>')"></div>
				<input type="hidden" name="img_id[]" value="<?php echo ($v["id"]); ?>" />
				<input type="hidden" name="img_name[]" value="<?php echo ($v["img_name"]); ?>" />
				<img id="images_show" src="/ssyp/Uploads/<?php echo ($v["img_name"]); ?>">
				<div class="num_wrap">排序(从大到小 1-99)：<input type="text" name="img_ordernum[]" value="<?php echo ($v["img_ordernum"]); ?>"/></div>
			</div><?php endforeach; endif; ?>
<!-- 		<input type="hidden" name="images[]" value="<?php echo ($data["wx_image"]); ?>" />
			<img id="images_show" src="/ssyp/Uploads/<?php echo ($data["wx_image"]); ?>"> -->
			<input class="images_but" id="images_but" type="button" value="上传图片" />
		</td>
	</tr>
	<!--<tr>
		<th>展示状态</th>
		<td class="cate_fid">
			<select name="status" >
				<option value="0">&#45;&#45;不选择&#45;&#45;</option>
				<?php if(is_array($category_s2)): foreach($category_s2 as $key=>$v): ?><option <?php if(($v["id"]) == $data["status"]): ?>selected<?php endif; ?> value="<?php echo ($v["id"]); ?>"><?php echo ($v["c_name"]); ?></option><?php endforeach; endif; ?>
			</select>
			
		</td>
	</tr>
	<tr>
		<th>关联商品id 用英文,分割</th>
		<td>
			<input type="text" name="relation" placeholder="相关商品id 用英文,分割" value="<?php echo ($data["relation"]); ?>">
		</td>
	</tr>-->
	<tr class="pre">
		<th>商品详情</th>
		<td>
			<script name="pro_detail" id="editor"><?php echo ($data["pro_detail"]); ?></script>
		</td>
	</tr>
	<!--<tr class="pre">
		<th>尺码指南</th>
		<td>
			<script name="size_notice" id="editor_size"><?php echo ($data["size_notice"]); ?></script>
		</td>
	</tr>-->
<!-- 	<tr>
		<th colspan="2" class="th_br">
		</th>
	</tr>
	<tr>
		<th colspan="2" class="det_title" >微信分享专用
		</th>
	</tr>
	
	<tr>
		<th>分享描述</th>
		<td>
			<textarea name="wx_describe" placeholder="填写商品描述"><?php echo ($data["wx_describe"]); ?></textarea>
		</td>
	</tr> -->

	
	<tr>
		<th colspan="2" class="th_br">
		</th>
	</tr>
	<tr>
		<th colspan="2" class="det_title" >商品任务设置
		</th>
	</tr>
	
	<tr>
		<th>配菜任务</th>
		<td>
			是否显示:<input class="task_s" <?php if(ACTION_NAME== "add" OR ($data["task_peicai"]["s"] > 0)): ?>checked<?php endif; ?> type="checkbox" name="task_peicai[s]" value="1">&nbsp;&nbsp;&nbsp;
			任务时间:<input type="time" <?php echo (taskIsShow($data["task_peicai"]["s"])); ?> class="task_time" name="task_peicai[start]" value="<?php echo ($data["task_peicai"]["start"]); ?>">-<input type="time" <?php echo (taskIsShow($data["task_peicai"]["s"])); ?> name="task_peicai[end]" value="<?php echo ($data["task_peicai"]["end"]); ?>">&nbsp;&nbsp;&nbsp;
			提示信息:<input type="text" <?php echo (taskIsShow($data["task_peicai"]["s"])); ?> class="task_msg" name="task_peicai[msg]" placeholder="配菜任务提示信息" value="<?php echo ($data["task_peicai"]["msg"]); ?>">
		</td>
	</tr> 
	
	<tr>
		<th>锻炼任务</th>
		<td>
			是否显示:<input class="task_s" <?php if(ACTION_NAME== "add" OR ($data["task_duanlian"]["s"] > 0)): ?>checked<?php endif; ?> type="checkbox" name="task_duanlian[s]" value="1">&nbsp;&nbsp;&nbsp;
			任务时间:<input type="time" <?php echo (taskIsShow($data["task_duanlian"]["s"])); ?> class="task_time" name="task_duanlian[start]" value="<?php echo ($data["task_duanlian"]["start"]); ?>">-<input type="time" <?php echo (taskIsShow($data["task_duanlian"]["s"])); ?> name="task_duanlian[end]" value="<?php echo ($data["task_duanlian"]["end"]); ?>">&nbsp;&nbsp;&nbsp;
			提示信息:<input type="text" <?php echo (taskIsShow($data["task_duanlian"]["s"])); ?> class="task_msg" name="task_duanlian[msg]" placeholder="锻炼任务提示信息" value="<?php echo ($data["task_duanlian"]["msg"]); ?>">
		</td>
	</tr>
	<tr>
		<th>音乐任务</th>
		<td>
			是否显示:<input class="task_s" <?php if(ACTION_NAME== "add" OR ($data["task_yinyue"]["s"] > 0)): ?>checked<?php endif; ?> type="checkbox" name="task_yinyue[s]" value="1">&nbsp;&nbsp;&nbsp;
			任务时间:<input type="time" <?php echo (taskIsShow($data["task_yinyue"]["s"])); ?> class="task_time" name="task_yinyue[start]" value="<?php echo ($data["task_yinyue"]["start"]); ?>">-<input type="time" <?php echo (taskIsShow($data["task_yinyue"]["s"])); ?> name="task_yinyue[end]" value="<?php echo ($data["task_yinyue"]["end"]); ?>">&nbsp;&nbsp;&nbsp;
			提示信息:<input type="text" <?php echo (taskIsShow($data["task_yinyue"]["s"])); ?> class="task_msg" name="task_yinyue[msg]" placeholder="音乐任务提示信息" value="<?php echo ($data["task_yinyue"]["msg"]); ?>">
		</td>
	</tr>
	<tr>
		<th>品茶任务</th>
		<td>
			是否显示:<input class="task_s" <?php if(ACTION_NAME== "add" OR ($data["task_pingcha"]["s"] > 0)): ?>checked<?php endif; ?> type="checkbox" name="task_pingcha[s]" value="1">&nbsp;&nbsp;&nbsp;
			任务时间:<input type="time" <?php echo (taskIsShow($data["task_pingcha"]["s"])); ?> class="task_time" name="task_pingcha[start]" value="<?php echo ($data["task_pingcha"]["start"]); ?>">-<input type="time" <?php echo (taskIsShow($data["task_pingcha"]["s"])); ?> name="task_pingcha[end]" value="<?php echo ($data["task_pingcha"]["end"]); ?>">&nbsp;&nbsp;&nbsp;
			提示信息:<input type="text" <?php echo (taskIsShow($data["task_pingcha"]["s"])); ?> class="task_msg" name="task_pingcha[msg]" placeholder="品茶任务提示信息" value="<?php echo ($data["task_pingcha"]["msg"]); ?>">
		</td>
	</tr>
	<tr>
		<th>喝水任务</th>
		<td>
			是否显示:<input class="task_s" <?php if(ACTION_NAME== "add" OR ($data["task_heshui"]["s"] > 0)): ?>checked<?php endif; ?> type="checkbox" name="task_heshui[s]" value="1">&nbsp;&nbsp;&nbsp;
			任务时间:<input type="time" <?php echo (taskIsShow($data["task_heshui"]["s"])); ?> class="task_time" name="task_heshui[start]" value="<?php echo ($data["task_heshui"]["start"]); ?>">-<input type="time" <?php echo (taskIsShow($data["task_heshui"]["s"])); ?> name="task_heshui[end]" value="<?php echo ($data["task_heshui"]["end"]); ?>">&nbsp;&nbsp;&nbsp;
			提示信息:<input type="text" <?php echo (taskIsShow($data["task_heshui"]["s"])); ?> class="task_msg" name="task_heshui[msg]" placeholder="喝水任务提示信息" value="<?php echo ($data["task_heshui"]["msg"]); ?>">
		</td>
	</tr>
	<tr>
		<th>冥想任务</th>
		<td>
			是否显示:<input class="task_s" <?php if(ACTION_NAME== "add" OR ($data["task_mingxiang"]["s"] > 0)): ?>checked<?php endif; ?> type="checkbox" name="task_mingxiang[s]" value="1">&nbsp;&nbsp;&nbsp;
			任务时间:<input type="time" <?php echo (taskIsShow($data["task_mingxiang"]["s"])); ?> class="task_time" name="task_mingxiang[start]" value="<?php echo ($data["task_mingxiang"]["start"]); ?>">-<input type="time" <?php echo (taskIsShow($data["task_mingxiang"]["s"])); ?> name="task_mingxiang[end]" value="<?php echo ($data["task_mingxiang"]["end"]); ?>">&nbsp;&nbsp;&nbsp;
			提示信息:<input type="text" <?php echo (taskIsShow($data["task_mingxiang"]["s"])); ?> class="task_msg" name="task_mingxiang[msg]" placeholder="冥想任务提示信息" value="<?php echo ($data["task_mingxiang"]["msg"]); ?>">
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
	
        
<script src="/ssyp/Public/ueditor/ueditor.config.js"></script>
<script src="/ssyp/Public/ueditor/ueditor.all.min.js"></script>
<script src="/ssyp/Public/Admin/js/type-select.js"></script>
<script>
$(function(){
	$('.task_s').change(function(){
		if ($(this).is(':checked')) { // 全选 
			$(this).parent('td').find('[type="text"],[type="time"]').css('background','#fff')
	    }
	    else { // 取消全选 
	      $(this).parent('td').find('[type="text"],[type="time"]').css('background','#f1f1f1')
	    }
	})
})
var ue = UE.getEditor('editor',{
	initialFrameWidth:800,
	initialFrameHeight:300
});
var ue = UE.getEditor('editor_size',{
	initialFrameWidth:800,
	initialFrameHeight:300
});

$(function(){
	h_upload('wx_image_but','/ssyp/index.php/Admin/Upload/Upload','callback_wx_image');
	h_upload('images_but','/ssyp/index.php/Admin/Upload/Upload','callback_images');
})
var oldImgName = '<?php echo ($data["pro_images"]); ?>';
function callback_wx_image(imgdata){
	if(oldImgName != ''){
		$.ajax({
			'url':'/ssyp/index.php/Admin/Upload/delImg',
			'type':'post',
			'data':{'imgname':oldImgName}
		});
	}
	oldImgName = imgdata;
	$('#wx_image_show').show().attr('src','/ssyp/Uploads/'+imgdata)
	$('input[name="wx_image"]').val(imgdata);
}


function callback_images(imgdata){
	var wrap = '<div class="images_unit">\
	<div class="close" title="删除图片" onclick="del_images(this,\''+imgdata+'\')"></div>\
	<input type="hidden" name="img_name[]" value="'+imgdata+'" />\
	<img id="images_show" src="/ssyp/Uploads/'+imgdata+'">\
	<div class="num_wrap">排序(从大到小 1-99)：<input type="text" name="img_ordernum[]" value="50"/></div>\
	</div>';
	
	$('#images_but').before(wrap);
	
}
function del_images(t,imgName,id){
	if(!confirm('确定删除吗？'))return false;
	if(id){
		$.ajax({'url':'/ssyp/index.php/Admin/Product/del_tb_img/id/'+id})
	}
	$.ajax({
		'url':'/ssyp/index.php/Admin/Upload/delImg',
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