<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=no">
<title>资料修改</title>
<link rel="stylesheet" href="/ssyp/Public/Home/css/reset.css">
<link rel="stylesheet" href="/ssyp/Public/Home/css/shop.css">
<!-- <script src="/ssyp/Public/Home/js//jquery.min.js"></script> -->
<style type="text/css">
.user_user li .tit{background:none !important;}
.user_user li .text{padding-left:10px !important;}
.user_user li .right{min-height:45px;text-align:right;}
.user_user li .right input[type="text"]{font-size:18px;width:100%;height:45px;text-align:right;border:none;background:none;}
</style>
</head>
<body>
<div class="body_wrap">
	<ul class="header clearfix header_2">
		<li class="left" onclick="history.go(-1)">&nbsp;</li>
		<li class="center" style="color:#ffb000;width:calc(100% - 190px)">资料修改</li>
	</ul>
	<div class="header_height"></div>
	<div style="height:45px;"></div>
	
	<div class="dmt" style="height:5px;"></div>
	<form onsubmit="return form_submit(this)" action="/ssyp/index.php/Home/User/save" method="post">
	<ul class="main_msg user_user">
		<li  class="clearfix tit_w" onclick="location.href='/ssyp/index.php/Home/User/ord_1'"><div class="tit">
			<span class="text" style="line-height:100px;">头像</span><div class="right"><img src="<?php echo ($data["headimgurl"]); ?>" width="100px" alt=""></div>
		</div></li>
		<li class="tit_w"><div class="tit">
			<span class="text" >平台昵称</span>
			<div class="right"><input type="text" value="<?php echo ($data["webname"]); ?>" name="webname"/></div>
		</div></li>
		
		
		
		<li class="tit_w"><div class="tit">
			<span class="text" >真实姓名</span>
			<div class="right"><input type="text" value="<?php echo ($data["realname"]); ?>" name="realname"/></div>
		</div></li>
		<li class="tit_w"><div class="tit">
			<span class="text" >电话号码</span>
			<div class="right"><input type="text" value="<?php echo ($data["phone"]); ?>" name="phone"/></div>
		</div></li>
		
		<li class="tit_w" style="border-bottom:none;">
			<input class="msg_sumbit"  type="submit" value="修改资料"/>
		</li>
		
		
	</ul>
	</form>

<ul class="footer clearfix">
	<li id="ft_one"><a href="/ssyp"><img src="/ssyp/Public/Home/images/bb_1.png" alt="">首页</a></li>
	<li id="ft_two"><a href="/ssyp/index.php/Home/News/index"  ><img src="/ssyp/Public/Home/images/shouye_2.png" alt="">播报</a></li>
	<li onclick="$('.list_menu,#zhezhao,.rt_share').show()" id="ft_three"><a><img src="/ssyp/Public/Home/images/yyy_2x.png" alt="">预订</a></li>
	<li id="ft_four"><a  href="/ssyp/index.php/Home/User/index"><img src="/ssyp/Public/Home/images/shouye_4.png" alt="" style="margin:2px auto 0px">我的</a></li>
</ul>
<ul class="list_menu" style="padding:0;bottom:67px;left:50%;top:initial;right:initial;box-shadow:0px 0px 5px 5px #ccc;">
	<li style="border-bottom:1px solid #ccc;"><a href="/ssyp/index.php/Home/Product/index">今日抢购</a><li>
	<li style="border-bottom:1px solid #ccc;"><a href="/ssyp/index.php/Home/Hotel/index">酒店预订</a><li>
	<li><a href="/ssyp/index.php/Home/Hotel/index/category/2">门票预订</a><li>
</ul>
<div id="zhezhao" style="background:none;" onclick="$('.list_menu,#zhezhao,.rt_share').hide()"></div>

<script src="/ssyp/Public/Home/js/jquery.min.js"></script>
<script>
var ft="ft_four";
var img = '/ssyp/Public/Home/images/wd_2x.png';
$(function(){
	ft_active(ft,img);
})
function ft_active(ftname,img){
	$('#'+ftname).find('a').css('color','#feb100');
	$('#'+ftname).find('img').attr('src',img);
}
</script>

</div>
<script src="/ssyp/Public/Home/js/jquery.min.js"></script>
<script src="/ssyp/Public/Statics/layer/layer.js"></script>
<script src="/ssyp/Public/Home/js/shop.js"></script>
</body>
</html>