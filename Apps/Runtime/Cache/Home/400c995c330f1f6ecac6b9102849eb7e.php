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
	<title>膳食优品</title>
	<link rel="stylesheet" type="text/css" href="/ssyp/Public/Home/css/reset.css">
	<link rel="stylesheet" href="/ssyp/Public/Home/css/jquery-weui.css">
	<link rel="stylesheet" href="/ssyp/Public/Home/css/global.css" />
	<link rel="stylesheet" type="text/css" href="/ssyp/Public/Home/css/index.css">

	<script src="/ssyp/Public/Home/js/jquery.min.js"></script>
	<script src="/ssyp/Public/Home/js/common.js"></script>
	<script src="/ssyp/Public/Home/js/jquery-weui.min.js"></script>
	<script src="/ssyp/Public/Home/js/swiper.js"></script>
	<style>
		.cont {
			width: 100%;
		}
	</style>
</head>

	<body>

		<div class="container">
			<div class="toIndex" onclick="location.href='index.html'">首页</div>
			<div class="top">
				<div class="index_plugin">
					<div class="swiper-container" data-space-between='10' data-pagination='.swiper-pagination' data-autoplay="1000">
						<div class="swiper-wrapper">
							<?php if(is_array($turn)): foreach($turn as $key=>$v): ?><div class="swiper-slide"><img src="/ssyp/Uploads/<?php echo ($v["img"]); ?>" alt=""></div><?php endforeach; endif; ?>
							<!--<div class="swiper-slide"><img src="/ssyp/Public/Home/images/banner.jpg" alt=""></div>-->
						</div>
						<div class="swiper-pagination"></div>
					</div>
				</div>
				<div class="search">

					<div class="write">
						<img src="/ssyp/Public/Home/images/search.png" alt="">
						<input type="text" name="search" value="">
					</div>
					<div class="add">
						搜索
					</div>
				</div>
				<ul class="nav">
					<li onclick="toNav(0)">
						<a href="/ssyp/index.php/home/product/goodsList">
							<img src="/ssyp/Public/Home/images/nav01.png" alt="">
							<span>全部商品</span>
						</a>
					</li>
					<li onclick="toNav(1114)">
						<a href="/ssyp/index.php/home/product/goodsList">
							<img src="/ssyp/Public/Home/images/nav02.png" alt="">
							<span>新品上市</span>
						</a>
					</li>
					<li onclick="toNav(1177)">
						<a href="/ssyp/index.php/home/active/active">
						<img src="/ssyp/Public/Home/images/nav03.png" alt="">
						<span>活动专题</span>
						</a>
					</li>
					<li onclick="toNav(1178)">
						<img src="/ssyp/Public/Home/images/nav04.png" alt="">
						<span>特价优惠</span>
					</li>
				</ul>
				<div class="line"></div>
				<div class="line"></div>

				<div class="recommand">
					<div class="title">店铺街<a href="/ssyp/index.php/home/shop/index"><span>></span></a></div>
					<div class="wrapper" id="wrapper1">
						<div class="scroller">
							<ul class="clearfix">
								<?php if(is_array($sellerList)): foreach($sellerList as $key=>$v): ?><li>
										<div class="intro">
											<a href="">
												<img src="/ssyp/Uploads/<?php echo ($v["seller_logo"]); ?>" alt="" />
												<span></span>
											</a>
										</div>
									</li><?php endforeach; endif; ?>
								<!--<li>
									<div class="intro">
										<a href="/ssyp/index.php/home/shop/index">
										<img src="/ssyp/Public/Home/images/store1.jpg" alt="" />
										<span></span>
										</a>
									</div>
								</li>-->
							</ul> 
						</div>
					</div>
					<div class="line"></div>
					<div class="line"></div>
					<div class="recommand">
						<div class="title">专题狂欢节<span></span></div>
						<ul class="cont">
							<?php if(is_array($product)): foreach($product as $key=>$v): ?><li>
									<a href="/ssyp/index.php/home/product/detail?id=<?php echo ($v["id"]); ?>">
										<img src="/ssyp/Uploads/<?php echo ($v["wx_image"]); ?>" alt="">
										<span class="name"><?php echo ($v["name"]); ?></span>
										<span class="price"><?php echo ($v["pro_price"]); ?></span>
									</a>
								</li><?php endforeach; endif; ?>
							<!--<li>
								<a href="/ssyp/index.php/home/product/detail">
									<img src="/ssyp/Public/Home/images/outdoor.jpg" alt="">
									<span class="name">太极拳服</span>
									<span class="price">￥100.00</span>
								</a>
							</li>-->
						</ul>
					</div>
				</div>
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
		<script src="/ssyp/Public/Home/js/iscroll.js"></script>
	<script src="/ssyp/Public/Home/js/navbarscroll.js"></script>
	<script>
		function toNav(id) {
			window.location.href = "goodsList.html?cate_id=" + id;
		}
		$(".swiper-container").swiper({
			loop: true,
			autoplay: 3000
		});
		$('.wrapper').navbarscroll();
		$(function() {
            var id = getSearchString('id');
            if (getSearchString('id')) {
                console.log(getSearchString('id'));
                localStorage.setItem("id", getSearchString('id'));
            } else {
            }
        })
	</script>


</html>