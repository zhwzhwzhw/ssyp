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
		
<link href="/ssyp/Public/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<script src="/ssyp/Public/plugins/daterangepicker/moment.min.js" type="text/javascript"></script>

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
				
				
<div class="wrapper">
    <!-- <div class="breadcrumbs" id="breadcrumbs">
	<ol class="breadcrumb">
	<?php if(is_array($navigate_admin)): foreach($navigate_admin as $k=>$v): if($k == '后台首页'): ?><li><a href="<?php echo ($v); ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo ($k); ?></a></li>
	    <?php else: ?>   
	        <li></li><?php endif; endforeach; endif; ?>         
	</ol>
</div> -->

    <section class="content ">
        <!-- Main content -->
        <div class="container-fluid">
            <div class="pull-right">
                <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回"><i class="fa fa-reply"></i></a>
           		<a href="javascript:;" class="btn btn-default" data-url="http://www.tp-shop.cn/Doc/Index/article/id/1012/developer/user.html" onclick="get_help(this)"><i class="fa fa-question-circle"></i> 帮助</a>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-list"></i> 添加优惠券</h3>
                </div>
                <div class="panel-body ">   
                    <!--表单数据-->
                    <form action="" method="post">              
                        <!--通用信息-->
                    <div class="tab-content col-md-10">                 	  
                        <div class="tab-pane active" id="tab_tongyong">                           
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td class="col-sm-2">优惠券名称：</td>
                                    <td class="col-sm-4">
                                        <input type="text" value="<?php echo ($coupon["name"]); ?>" class="form-control" id="name" name="name" >
                                        <span id="err_attr_name" style="color:#F00; display:none;"></span>                                        
                                    </td>
                                    <td class="col-sm-4">请填写优惠券名称
                                    </td>
                                </tr>  
                                <tr>
                                    <td>优惠券面额：</td>
                                    <td >
                         				<input type="text" value="<?php echo ($coupon["money"]); ?>" class="form-control" id="money" name="money"  onpaste="this.value=this.value.replace(/[^\d.]/g,'')" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')"/>
                                    </td>
                                    <td class="col-sm-4">优惠券可抵扣金额</td>
                                </tr>  
                                <tr>
                                    <td>消费金额：</td>
                                    <td>
                      					<input type="text" value="<?php echo ($coupon["condition"]); ?>" class="form-control active" id="condition" name="condition"  onpaste="this.value=this.value.replace(/[^\d.]/g,'')" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" />
                                    </td>
                                    <td class="col-sm-4">订单需满足的最低消费金额(必需为整数)才能使用</td>
                                </tr>
                                <tr  style="display:none">
			                        <td>发放类型:</td>
			                        <td id="order-status">
			                         	<input name="type" type="radio" value="0" <?php if($coupon['type'] === '0'): ?>checked<?php endif; ?> >面额模板
			                            <input name="type" type="radio" value="1" <?php if($coupon['type'] == 1 OR ($coupon['type'] == '')): ?>checked<?php endif; ?> >按用户发放			                           
			                            <input name="type" type="radio" value="2" <?php if($coupon['type'] == 2): ?>checked<?php endif; ?> >注册发放
			                            <input name="type" type="radio" value="3" <?php if($coupon['type'] == 3): ?>checked<?php endif; ?> >邀请发放
			                            <input name="type" type="radio" value="4" <?php if($coupon['type'] == 4): ?>checked<?php endif; ?> >线下发放
			                        </td>
			                    </tr> 
			                    <tr>
			                    	<td>发放数量:</td>
			                    	<td><input type="text" value="<?php echo ($coupon["createnum"]); ?>" class="form-control" id="createnum" name="createnum" placeholder="0" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" /></td>
			                    	<td class="col-sm-4">发放数量限制(默认为0则无限制)</td>
			                    </tr>
			                    <tr class="timed">
			                        <td>发放起始日期:</td>
			                        <td>
			                            <div class="input-prepend input-group">
			                                <span class="add-on input-group-addon">
			                                      <i class="glyphicon glyphicon-calendar fa fa-calendar">  </i>
			                                </span>
			                                <input type="text" value="<?php echo (date('Y-m-d',$coupon["send_start_time"])); ?>" class="form-control" id="send_start_time" name="send_start_time">
			                            </div>
			                        </td>
			                        <td class="col-sm-4"></td>
			                    </tr>
			
			                    <tr class="timed">
			                        <td>发放结束日期:</td>
			                        <td>
			                            <div class="input-prepend input-group">
			                                <span class="add-on input-group-addon">
			                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"> </i>
			                                </span>
			                                <input type="text" value="<?php echo (date('Y-m-d',$coupon["send_end_time"])); ?>" class="form-control" id="send_end_time" name="send_end_time">
			                            </div>
			                        </td>
			                        <td class="col-sm-4"></td>
			                    </tr>
					            <tr>
			                        <td>使用起始日期:</td>
			                        <td>
			                            <div class="input-prepend input-group">
			                                <span class="add-on input-group-addon">
			                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
			                                </span>
			                                <input type="text" value="<?php echo (date('Y-m-d',$coupon["use_start_time"])); ?>" class="form-control" id="use_start_time" name="use_start_time">
			                            </div>
			                        </td>
			                        <td class="col-sm-4"></td>
			                    </tr> 
			                    <tr>
			                        <td>使用结束日期:</td>
			                        <td>
			                            <div class="input-prepend input-group">
			                                <span class="add-on input-group-addon">
			                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
			                                </span>
			                                <input type="text" value="<?php echo (date('Y-m-d',$coupon["use_end_time"])); ?>" class="form-control" id="use_end_time" name="use_end_time">
			                            </div>
			                        </td>
			                        <td class="col-sm-4"></td>
			                    </tr>                              
                                </tbody> 
                                <tfoot>
                                	<tr>
                                	<td>
                                		<input type="hidden" name="id" value="<?php echo ($coupon["id"]); ?>">
                                	</td>
                                	<td class="col-sm-4"></td>
                                	<td class="text-right"><input class="btn btn-primary" type="submit" value="保存"></td>
                                	</tr>
                                </tfoot>                               
                            </table>
                        </div>                           
                    </div>              
			    	</form><!--表单数据-->
                </div>
            </div>
        </div>
    </section>
</div>




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
	
        

<script src="/ssyp/Public/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script>
$('input[type="radio"]').click(function(){
    if($(this).val() == 0){
    	$('.timed').hide();
    }else{
    	$('.timed').show();
    }
})


$(function(){
    data_pick('send_start_time');
    data_pick('send_end_time');
    data_pick('use_start_time');
    data_pick('use_end_time');
    $('input[type="radio"]:checked').trigger('click');
})
    
function data_pick(id){
    var myDate = new Date();
    $('#'+id).daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minDate:myDate.getFullYear()+'-'+myDate.getMonth()+'-'+myDate.getDate(),
        maxDate:'2030-01-01',
        format: 'YYYY-MM-DD',
        locale : {
            applyLabel : '确定',
            cancelLabel : '取消',
            fromLabel : '起始时间',
            toLabel : '结束时间',
            customRangeLabel : '自定义',
            daysOfWeek : [ '日', '一', '二', '三', '四', '五', '六' ],
            monthNames : [ '一月', '二月', '三月', '四月', '五月', '六月','七月', '八月', '九月', '十月', '十一月', '十二月' ],
            firstDay : 1
        }
    });
}
</script>

    </body>
</html>