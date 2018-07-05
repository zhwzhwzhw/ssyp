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
		<title>禅品</title>
		<link rel="stylesheet" type="text/css" href="/ssyp/Public/Home/css/reset.css">
		<link rel="stylesheet" href="/ssyp/Public/Home/css/jquery-weui.css">
		<link rel="stylesheet" href="/ssyp/Public/Home/css/global.css" />
		<link rel="stylesheet" type="text/css" href="/ssyp/Public/Home/css/my.css">
		<script src="/ssyp/Public/Home/js/jquery.min.js"></script>
		<script src="/ssyp/Public/Home/js/common.js"></script>
		<script src="/ssyp/Public/Home/js/jquery-weui.min.js"></script>
		<script src="/ssyp/Public/Home/js/swiper.js"></script>
	</head>

	<body>
		<div class="container">
			<div class="top">
				<div class="bg info_bg">
					<img src="/ssyp/Public/Home/images/toright.png" alt="">
					<span>ceshi</span>
				</div>
				<div class="line1"></div>
				<ul class="oprate2">
					<li onclick="toOrder(-1)">
						<span>我的订单</span>
						<img src="/ssyp/Public/Home/images/toright.png" alt="" />
					</li>
				</ul>
				<ul class="oprate1">
					<li onclick="toOrder(0)">
						<img src="/ssyp/Public/Home/images/shop1.png" alt="" />
						<span>待发货</span>
					</li>
					<li onclick="toOrder(1)">
						<img src="/ssyp/Public/Home/images/shop2.png" alt="" />
						<span>已发货</span>
					</li>
					<li onclick="toOrder(2)">
						<img src="/ssyp/Public/Home/images/shop3.png" alt="" />
						<span>已收货</span>
					</li>
					<li>
						<img src="/ssyp/Public/Home/images/shop4.png" alt="" />
						<span>售后</span>
					</li>
				</ul>
				<div class="line1"></div>
				<ul class="oprate2">
					<li class="address">
						<span>收货地址</span>
						<img src="/ssyp/Public/Home/images/toright.png" alt="" />
					</li>
				</ul>
				<div class="line1"></div>
				<ul class="oprate2">
					<li class="address">
						<span>我的团队</span>
						<img src="/ssyp/Public/Home/images/toright.png" alt="" />
					</li>
				</ul>
				<ul class="oprate2">
					<li class="address">
						<span>积分明细</span>
						<img src="/ssyp/Public/Home/images/toright.png" alt="" />
					</li>
				</ul>
			</div>
			<div class="line1"></div>
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
	<script src="https://res.wx.qq.com/open/js/jweixin-1.1.0.js"></script>
	<script>
		function toOrder(type){
			window.location.href="ordersList.html?type="+type
		}
		$(function() {
			var id = localStorage.getItem('id');
//			$.ajax({
//				url: "https://bgt.we-fs.com/api/api/gain?class=user&user_id=" + id,
//				success: function(res) {
//					var info = JSON.parse(res).data[0];
//					$('.info_bg').append(`
//						<img src="${info.img}" class="header" alt="" />
//						<span class="name">${info.user_name}</span>
//					`)
//				},
//				error: function(res) {
//					console.log(res);
//				}
//			})
//
//			$.ajax({
//				url: "https://bgt.we-fs.com/api/api/classify?admin_id=1&parent_id=1090",
//				success: function(res) {
//					var banner = eval(res).data;
//					console.log(banner);
//					for(var i in banner) {
//						$(".swiper-wrapper").append(`
//							<div class='swiper-slide'><img src='https://bgt.we-fs.com/${banner[i].image}'  alt='' ></div>
//						`)
//					}
//					$(".swiper-container").swiper({
//						loop: true,
//						autoplay: 3000
//					});
//				},
//				error: function(res) {
//					console.log(res);
//				}
//			})
			$('body').on('click','.address',function(){
				var localUrl = window.location.href;
				$.ajax({
						url: "https://bgt.we-fs.com/api/api/share",
						data: {
							'url': localUrl,
							'address':''
						},
						success: function(res) {
							console.log(res);
							var info = JSON.parse(res);
							console.log(info);
							appid=info.appId;
							wx.config({
								debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
								appId: info.appId, // 必填，公众号的唯一标识
								timestamp: info.timestamp, // 必填，生成签名的时间戳
								nonceStr: info.nonceStr, // 必填，生成签名的随机串
								signature: info.signature, // 必填，签名
								jsApiList: [
									'checkJsApi',
									'openLocation', 
									'getLocation',
									'openAddress',
									'translateVoice',
								]
							});
							wx.ready(function () {
						    wx.openAddress({
					        success: function (res) {
					        	
					        },
					        error: function(res){
					        	
					        }
						    });
						  })

						}
				})
			})
			
		})
		
	</script>

</html>