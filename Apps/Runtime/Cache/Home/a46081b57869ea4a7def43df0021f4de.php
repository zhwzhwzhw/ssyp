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
		<link rel="stylesheet" type="text/css" href="/ssyp/Public/Home/css/goodsList.css">
		
		<script src="/ssyp/Public/Home/js/jquery.min.js"></script>
		<script src="/ssyp/Public/Home/js/common.js"></script>
		<script src="/ssyp/Public/Home/js/jquery-weui.min.js"></script>
		<script src="/ssyp/Public/Home/js/swiper.js"></script>
		<style >
			.cont{
				width: 100%;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="search">
					<div class="write">
						<img src="/ssyp/Public/Home/image/search.png" alt="">
						<input type="text" name="search" value="">
					</div>
					<div class="add">
						搜索
					</div>
				</div>
				<div class="title">
					<span class="active">最新</span>
					<span>销量</span>
					<span>推荐</span>
				</div>
			<div class="top1">
				<div class="recommand">
					<ul class="cont">
						<li>
							<img src="/ssyp/Public/Home/images/outdoor.jpg" alt="">
							<span class="name">太极拳服</span>
							<span class="name">百利甜</span>
							<span class="price ">￥100.00</span>
						</li>
						<li>
							<img src="/ssyp/Public/Home/images/outdoor.jpg" alt="">
							<span class="name">太极拳服</span>
							<span class="name">百利甜</span>
							<span class="price ">￥100.00</span>
						</li>
						<li>
							<img src="/ssyp/Public/Home/images/outdoor.jpg" alt="">
							<span class="name">太极拳服</span>
							<span class="name">百利甜</span>
							<span class="price ">￥100.00</span>
						</li>
					</ul>
				</div>
			</div>
			
		</div>
	</body>
	<script>

		$(function() {
			$('.title span').on('click',function(){
				var i = $('.title span').index(this);
				$('.title span').eq(i).addClass('active').siblings().removeClass('active');
			})
			var cate_id=getSearchString('cate_id');
			if(cate_id==0){
				$.ajax({
					url: "https://bgt.we-fs.com/api/api/goodsInfo?admin_id=1",
					success: function(res) {
						var list = eval(res).data;
						console.log(list);
						for(var i in list) {
							$(".cont").append(`
								<li onclick="location.href='detail.html?admin_id=1&goods_id=${list[i].goods_id}'">
									<img src="https://bgt.we-fs.com/${list[i].img}" alt="">
									<span class="name">${list[i].goods_name}</span>
									<span class="price">${list[i].market_price}</span>
								</li>
							`)
						}
					},
					error: function(res) {
						console.log(res);
					}
				})
			}else{
				$.ajax({
				url: "https://bgt.we-fs.com/api/api/goodsInfo?admin_id=1&cat_id="+cate_id,
				success: function(res) {
					
					var list = eval(res).data;
					console.log(list);
					for(var i in list) {
						$(".cont").append(`
							<li onclick="location.href='detail.html?admin_id=1&goods_id=${list[i].goods_id}'">
								<img src="https://bgt.we-fs.com/${list[i].img}" alt="">
								<span class="name">${list[i].goods_name}</span>
								<span class="price">${list[i].market_price}</span>
							</li>
						`)
					}
				},
				error: function(res) {
					console.log(res);
				}
			})
			}
			
		})
	</script>

</html>