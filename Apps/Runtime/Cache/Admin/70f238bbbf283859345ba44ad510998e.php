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
		
<meta charset="utf-8">
<title>聊天</title>	
<link href="/ssyp/Public/message/message.css" type="text/css" rel="stylesheet"/>
<style>
	.message_wrap{width:760px;}
	#message{height:426px;}
    .left_side .other li{border-top: 1px solid #999;}
	.left_side .other .other_meg .other_name{height:50px;line-height:50px;}
.left_side .search_user input{background:#f1f1f1}
.left_side .other{height:calc(100% - 68px)}
#message .me .meg_content{color:#fff}
</style>
<script type="text/javascript" src="/ssyp/Public/message/jquery1.min.js"></script>
<script type="text/javascript" src="/ssyp/Public/message/jquery.qqFace.js"></script>
<script type="text/javascript">
$(function(){
	$('.biaoq').qqFace({
		id : 'facebox', 
		assign:'saytext', 
		path:'/ssyp/Public/message/arclist/'	//表情存放的路径
	});
});

//查看结果
function replace_em(str){
/* 	str = str.replace(/\</g,'&lt;');
	str = str.replace(/\>/g,'&gt;');
	str = str.replace(/\n/g,'<br/>'); */
	str = str.replace(/\[em_([0-9]*)\]/g,'<img src="/ssyp/Public/message/arclist/$1.gif" border="0" />');
	return str;
}
</script>


<script type="text/javascript" >
var URL='/ssyp/index.php/Admin/Message'
var STATICS = '/ssyp/Public/Statics/';
var MODULE = '/ssyp/index.php/Admin'
	var session="<?php echo ($_SESSION['lawyerLogin']['id']); ?>"
		var meid = 'l_<?php echo ($_SESSION['lawyerLogin']['id']); ?>'
</script>
<script type="text/javascript" src="/ssyp/Public/message/message.js"></script>
<script>
function addReadUser(v_nickname,v_headimgurl,v_m_from){ 
	var current = '';
	var src_head = 'src="'+STATICS+'images/other_header.png"';
	var nickname='匿名用户';
	if(v_nickname){
		nickname = v_nickname
	}
	if(v_headimgurl){
		src_head = 'src="'+v_headimgurl+'"';
	}
	if(v_m_from == $('input[name="m_to"]').val()){
		current = 'style="background:#999"'
	}
	var str = '<li '+current+'><div class="other_header" onclick="click_user(this)"  uid="'+v_m_from+'">\
		<img '+src_head+' width="35px" height="35px" alt="">\
		</div>\
		<div class="other_meg" >\
			<dl class="other_name" onclick="click_user(this)" uid="'+v_m_from+'">'+nickname+'</dl>\
		</div></li>';
		
	
	
	$('.other_header[uid="'+v_m_from+'"]').parents('li').remove()
	//alert(readUser)
	$('.left_side .other').prepend(str);
}
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
				
				
<div class="net_error">网络异常！</div>
<div class="message_wrap clearfix">
<div class="left_side" >
	<ul class="self">
		<!-- <li class="header_img">
		<img src="/ssyp/Public/message/images/self_header.png" height="42px" width="42px" alt="">
		</li> -->
		<li style="width:150px;" class="lawyer_name"><span class="list_title">客户列表 </span>
		<?php if($my["online"] == 1): ?><a style="color:#0f0" href="/ssyp/index.php/Admin/Message/online/s/2">【在线中】</a>
		<?php else: ?>
			<a style="color:#f00" href="/ssyp/index.php/Admin/Message/online/s/1">【已下线】</a><?php endif; ?>
		<li class="message_shezhi"><a class="img_shezhi" href=""></a></li>
	</ul>
<!-- 	<form class="search_user"><input id="search_user" type="text" autocomplete="off" placeholder="搜索联系人"/><div class="search_user_zoom"></div></form>
 -->	<ul class="other clearfix">
<!-- 		<li>
			<div class="other_header">
				<img src="/ssyp/Public/message/images/other_header.png" width="35px" height="35px" alt="">
			</div>
			<div class="other_meg">
				<dl class="other_name">张三年</dl>
				<div>
				<dt class="other_update"></dt><dt class="other_bz">备注一个</dt>
				</div>
			</div>
		</li> -->
		<?php if(is_array($user)): foreach($user as $key=>$v): ?><li>
			<div class="other_header" onclick="click_user(this)"  uid="u_<?php echo ($v["id"]); ?>">
				<?php if($v["headimgurl"] != ''): ?><img src="<?php echo ($v["headimgurl"]); ?>" width="35px" height="35px" alt="">
				<?php else: ?>
				<img src="/ssyp/Public/message/images/other_header.png" width="35px" height="35px" alt=""><?php endif; ?>
			</div>
			<div class="other_meg" >
				<dl class="other_name" onclick="click_user(this)" uid="u_<?php echo ($v["id"]); ?>">
				<?php if($v["nickname"] != ''): echo ($v["nickname"]); ?>
				<?php else: ?>匿名用户<?php endif; ?>
				</dl>
			</div>
		</li><?php endforeach; endif; ?>
	</ul>

	
</div>
<div class="center_side" >
<!-- <h2 class="center_header">
	<ul>
		<li class="qiehuan_bz">咨询记录备注</li>
		<li class="qiehuan_dh current">对话</li>
	</ul>
</h2> -->
<div class="meg_wite">请稍后...</div>

<ul style="" id="message">

	<!-- 对话内容 -->
<!-- 	<li class="meg_time">//&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2016/12/17&nbsp;&nbsp;08:61&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//</li>
	<li class="beizhu clearfix">asasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfdfasdf</li>
	<li class="meg_time">//&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2016/12/17&nbsp;&nbsp;08:61&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//</li>
	<li class="me clearfix"><div class="meg_header"><img src="/ssyp/Public/Statics//images/other_header.png" width="35px" height="35px" alt=""/></div><div class="meg_content">asdfasdf</div></li>
	<li class="meg_time">//&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2016/12/17&nbsp;&nbsp;08:61&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//</li>
	<li class="me clearfix"><div class="meg_header"><img src="/ssyp/Public/Statics//images/other_header.png" width="35px" height="35px" alt=""/></div><div class="meg_content">asdfasdf</div></li>
 --></ul>
<div class="shouc_wrap">
<div id="shouc_meg"></div>
	<table >
		<tr>
			<th>类别：</th>
			<td>
				<select name="type">
					<option value='0'>--请选择--</option>
					<?php if(is_array($type)): foreach($type as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["type_name"]); ?></option><?php endforeach; endif; ?>	
				</select>
			</td>
		</tr>
		<tr>
			<th>添加标题：</th>
			<td><input type="text"/></td>
		</tr>
		<tr>
			<td colspan="2">
				<textarea></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="shouc_footer"><div class="shouc_qr">收 藏</div><div class="shouc_qx">取消</div></td>
		</tr>
	</table>
</div>
<div class="send_wrap" >
	<div class="grey clearfix">
		<!-- <div class="biaoq"></div>
		<div class="shouc"></div> -->
	</div>
	<form id="send" action="/ssyp/index.php/Admin/Message/send" method="post">
		<input autocomplete="off" type="hidden" value="" name="m_to" />
		<textarea id="saytext" autocomplete="off" name="content" placeholder="按 Enter 发送"></textarea>
		<input class="submit"  type="submit" value="发送"/>
	</form>
</div>
</div>
<div class="right_side" style="display:none">
	<div class="search_ph"><input class="ph_text" type="text" autocomplete="off" placeholder="常见问题搜索"/><input class="ph_button" type="button" value="搜索"></div>
	<div class="ph_wrap"><div class="phrase" id="se_ph"></div></div>
	<div class="ph_wrap">
		<div class="wenben">常见问题：</div>
		
		<div class="phrase">
		<dl id="shouc_me" class="shouc_me">我的收藏</dl>
		<?php if(is_array($type)): foreach($type as $key=>$v): ?><dl typeid="<?php echo ($v["id"]); ?>"><?php echo ($v["type_name"]); ?></dl><?php endforeach; endif; ?>
<!-- 			<dl>问候语</dl>
			<dl>刑事</dl>
			<dl class="ph_dl_current">民事</dl>
			<dt>
				<dd class="ph_title">适用居住的情形有哪些？</dd>
				<dd class="ph_content">根据法律规定根据法律规定根据法律规定根据法律规定根据法律规定根据法律规定根据法律规定根据法律规定</dd>
				<dd class="ph_caina">325次采纳</dd>
			</dt>
			<dt>
				<dd class="ph_title">适用居住的情形有哪些？</dd>
				<dd class="ph_content">根据法律规定根据法律规定根据法律规定根据法律规定根据法律规定根据法律规定根据法律规定根据法律规定</dd>
				<dd class="ph_caina">325次采纳</dd>
			</dt>
			<dt>
				<dd class="ph_title">适用居住的情形有哪些？</dd>
				<dd class="ph_content">根据法律规定根据法律规定根据法律规定根据法律规定根据法律根据法律规定根据法律规定根据法律规定根据法律规定根据法律根据法律规定根据法律规定根据法律规定根据法律规定根据法律根据法律规定根据法律规定根据法律规定根据法律规定根据法律根据法律规定根据法律规定根据法律规定根据法律规定根据法律规定根据法律规定根据法律规定根据法律规定</dd>
				<dd class="ph_caina">325次采纳</dd>
			</dt> -->
		</div>
	</div>
</div>

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
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
       <!-- <script src="/ssyp/Public/Admin/js/AdminLTE/dashboard.js" type="text/javascript"></script> -->
	
        

		
    </body>
</html>