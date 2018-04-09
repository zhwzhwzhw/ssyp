<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0036)http://192.168.1.121/index.php/admin -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>膳食优品管理系统</title>

<meta name="robots" content="nofollow">
<link href="/ssyp/Public/Admin/css/adminStyle.css" rel="stylesheet" type="text/css">
<style>
body{width:100%;height:100%;overflow:hidden;background:url(/ssyp/Public/Admin/images/pc_loginBg.jpg) no-repeat;background-size:cover;position:absolute;}
</style>
<script src="/ssyp/Public/Admin/js/jquery.min.js"></script>
<script src="/ssyp/Public/Admin/js/Particleground.js"></script>
<script>
$(document).ready(function() {
  $('body').particleground({
    dotColor:'green',
    lineColor:'#c9ec6e'
  });
  $('.intro').css({
    'margin-top': -($('.intro').height() /2)
  });
    
});
</script>
<script src="/ssyp/Public/Statics/layer/layer.js"></script>
        
<script type="text/javascript" src="/ssyp/Public/Statics/js/request.js"></script>
</head>
<body><canvas class="pg-canvas" width="1235" height="974"></canvas>

  <section class="loginform">
   <form onsubmit="return form_submit(this)" action="/ssyp/index.php/Admin/Common/check" method="post">
        
   
   <h1>膳食优品管理系统</h1>
   <ul>
    <li>
     <label>账号：</label>
     <input type="text" name="phone" id="name" required class="textBox" placeholder="电话号码">
    </li>
    <li>
     <label>密码：</label>
     <input type="password" name="password" required id="password" class="textBox" placeholder="登陆密码">
    </li>
    <li>
     <input type="submit" value="立即登陆">
    </li>
   </ul>
   </form>
  </section>

</body></html>