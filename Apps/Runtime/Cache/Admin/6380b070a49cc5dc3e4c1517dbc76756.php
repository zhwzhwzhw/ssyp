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
	$('.coupon-add,.coupon').addClass('active');
})
</script>
<meta charset="UTF-8">
<style>
#detail th{width:40%;}
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
		产品管理
		<small>产品发布/编辑</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"> </a></li>
		<li class="active"></li>
	</ol> 
					
</section>

                <section class="content">
				
				


<form method="post" action="/ssyp/index.php/Admin/Coupon/save">
<table id="detail">
	<tr>
		<th colspan="2" class="det_title" >基本信息
		<input type="hidden" name="id" value="<?php echo ($data["id"]); ?>" />
		</th>
	</tr>
	<tr>
		<th>优惠券类型</th>
		<td>
			线上-人人都可以领取：<input type="radio" name="status" <?php if($data["status"] == 1): ?>checked<?php endif; ?> value="1" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			线下-通过优惠券代码领取：<input type="radio" name="status" <?php if($data["status"] == 2): ?>checked<?php endif; ?> value="2" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			生日优惠券：<input type="radio" name="status" <?php if($data["status"] == 3): ?>checked<?php endif; ?> value="3" >
		</td>
	</tr>

	
	<tr>
		<th>领取码(数组字母组合,仅用于线下优惠券使用)</th>
		<td><input type="text" name="code" placeholder="领取码（仅对线下有效，线上不用填写此字段）" value="<?php echo ($data["code"]); ?>"></td>
	</tr>
	<tr>
		<th>优惠券名称</th>
		<td><input type="text" name="cou_name" placeholder="填写优惠券名称" value="<?php echo ($data["cou_name"]); ?>"></td>
	</tr>
	<tr>
		<th>产品描述</th>
		<td>
			<textarea name="cou_des" placeholder="填写优惠券描述"><?php echo ($data["cou_des"]); ?></textarea>
		</td>
	</tr>
	<tr>
		<th>有效期（不限制 空即可）</th>
		<td>
		<input type="text" id="pre_start"  name="start" class="data" autocomplete="off"  value="<?php echo ($data["start"]); ?>" /> 至
		<input type="text" id="pre_end"  name="end" class="data" autocomplete="off"  value="<?php echo ($data["end"]); ?>" />
		</td>
	</tr>
	<tr>
		<th>满（抵扣填写0）</th>
		<td><input type="text" name="full" placeholder="满价" value="<?php echo ($data["full"]); ?>"></td>
	</tr>
	<tr>
		<th>减</th>
		<td><input type="text" name="reduce" placeholder="减价" value="<?php echo ($data["reduce"]); ?>"></td>
	</tr>
	<tr>
		<th>数量</th>
		<td><input type="text" name="number" placeholder="发放数量" value="<?php echo ($data["number"]); ?>"></td>
	</tr>
	<tr>
		<th colspan="2" class="det_footer"><input type="submit" value="提&nbsp;&nbsp;&nbsp;交"></th>
	</tr>
</table>
</form>
<script>
$(function(){
	$('[name="is_rob"]').change(function(){
		if($(this).val() == '1'){
			$('.rob').show();
		}else{
			$('.rob').hide()
		}
	})
	$('[name="is_pre"]').change(function(){
		if($(this).val() == '1'){
			$('.pre').show();
		}else{
			$('.pre').hide()
		}
	})
})
var pre_start = {
  elem: '#pre_start',
  format: 'YYYY/MM/DD hh:mm:ss',
  min: laydate.now(), //设定最小日期为当前日期
  max: '2099-06-16 23:59:59', //最大日期
  istime: true,
  istoday: false,
  choose: function(datas){
     pre_end.min = datas; //开始日选好后，重置结束日的最小日期
     pre_end.start = datas //将结束日的初始值设定为开始日
  }
};
var pre_end = {
  elem: '#pre_end',
  format: 'YYYY/MM/DD hh:mm:ss',
  min: laydate.now(),
  max: '2099-06-16 23:59:59',
  istime: true,
  istoday: false,
  choose: function(datas){
    pre_start.max = datas; //结束日选好后，重置开始日的最大日期
  }
};
laydate(pre_start);
laydate(pre_end);

var use_start_data = 0;
var use_end_data = 0;
var use_start = {
  elem: '#use_start',
  format: 'YYYY/MM/DD',
  min: laydate.now(), //设定最小日期为当前日期
  max: '2099-06-16', //最大日期
  istoday: false,
  choose: function(datas){
     use_end.min = datas; //开始日选好后，重置结束日的最小日期
     use_end.start = datas //将结束日的初始值设定为开始日
	 use_start_data = datas;
  }
};
var use_end = {
  elem: '#use_end',
  format: 'YYYY/MM/DD',
  min: laydate.now(),
  max: '2099-06-16',
  istoday: false,
  choose: function(datas){
    use_start.max = datas; //结束日选好后，重置开始日的最大日期
	use_end_data = datas;
  }
};
laydate(use_start);
laydate(use_end);




	

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
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
       <!-- <script src="/ssyp/Public/Admin/js/AdminLTE/dashboard.js" type="text/javascript"></script> -->
	
        
<script src="/ssyp/Public/ueditor/ueditor.config.js"></script>
<script src="/ssyp/Public/ueditor/ueditor.all.min.js"></script>
<script>
var ue = UE.getEditor('editor',{
	initialFrameWidth:800,
	initialFrameHeight:300
});
var ue_pre_msg = UE.getEditor('edi_pre_msg',{
	initialFrameWidth:800,
	initialFrameHeight:300
});
var ue_rob_notice = UE.getEditor('edi_rob_notice',{
	initialFrameWidth:800,
	initialFrameHeight:300
});
	$(function(){
		h_upload('pro_images','/ssyp/index.php/Admin/Upload/Upload','callback_sfz');
	})
	var oldImgName = '<?php echo ($data["pro_images"]); ?>';
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
		$('input[name="pro_images"]').val(imgdata);
	}
	


</script>

    </body>
</html>