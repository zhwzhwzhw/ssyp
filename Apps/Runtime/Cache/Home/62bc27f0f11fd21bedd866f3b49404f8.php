<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html style="font-size: 40px;">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type" />
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
		<meta http-equiv="expires" content="Wed, 26 Feb 1997 08:21:57 GMT">
		<meta content="telephone=no, address=no" name="format-detection" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
		<title>我的任务</title>
		<link rel="stylesheet" type="text/css" href="/ssyp/Public/Home/css/reset.css">
		<link rel="stylesheet" href="/ssyp/Public/Home/css/jquery-weui.css">
		<link rel="stylesheet" href="/ssyp/Public/Home/css/global.css" />
		<link rel="stylesheet" type="text/css" href="/ssyp/Public/Home/css/sort.css">
		<script src="/ssyp/Public/Home/js/jquery.min.js"></script>
		<script src="/ssyp/Public/Home/js/common.js"></script>
		<script src="/ssyp/Public/Home/js/jquery-weui.min.js"></script>
		<script src="/ssyp/Public/Home/js/swiper.js"></script>
	</head>

	<body>
		<div class="container">
			<ul class="cont">
				<li>
					<div class="li_top">
						<img src="/ssyp/Public/Home/images/outdoor.jpg" alt="">
						<div class="li_top_center">
							<span>商品名称</span>
							<span>￥199</span>
							<span class="overflow1">简要</span>
						</div>
						<div class="li_top_right">
							2015-10-15
						</div>
					</div>
					<div class="li_bottom">
						<div class="li_bottom_left">合计：5000</div>
						<button class="li_bottom_right ">已打卡</button>
					</div>
					<div class="line"></div>
					<div class="line"></div>
				</li>
			</ul>
			<ul class="bottom bottom2">
	<li class="active" onclick="location.href='index.html'">
		<a href="/ssyp/index.php/home/index/index">
			<img src="/ssyp/Public/Home/images/sicon1.png" alt="">
			<p>首页</p>
		</a>
	</li>
	<li onclick="location.href='sort.html'">
		<a href="/ssyp/index.php/home/task/task">
			<img src="/ssyp/Public/Home/images/icon2.png" alt="">
			<p>我的任务</p>
		</a>
	</li>
	<li onclick="location.href='cart.html'">
		<a href="/ssyp/index.php/home/cart/cart">
			<img src="/ssyp/Public/Home/images/icon3.png" alt="">
			<p>购物车</p>
		</a>
	</li>
	<li onclick="location.href='my.html'">
		<a href="/ssyp/index.php/home/user/index">
			<img src="/ssyp/Public/Home/images/icon4.png" alt="">
			<p>我的</p>
		</a>
	</li>
</ul>
		</div>
	</body>
	<script>
		$(function() {
			// 轮播
			$(".swiper-container").swiper({
				loop: true,
				autoplay: 3000
			});
		})
	</script>

</html>