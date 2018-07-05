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
						<img src="/ssyp/Public/Home/images/search.png" alt="">
						<input type="text" name="search" value="">
					</div>
					<div class="add">
						<a href="/ssyp/index.php/home/product/search">
							搜索
						</a>
					</div>
				</div>
				<div class="title">
				<!--	<span class="active" onclick="active(this)"><a href="/ssyp/index.php/home/product/goodsList?type=1">最新</a></span>
					<span onclick="active()"><a href="/ssyp/index.php/home/product/goodsList?type=2">销量</a></span>
					<span onclick="active()"><a href="/ssyp/index.php/home/product/goodsList?type=2">推荐</a></span>-->
					<?php if($type==2): ?><span ><a href="/ssyp/index.php/home/product/goodsList?type=1">最新</a></span>
						<span class="active"><a href="/ssyp/index.php/home/product/goodsList?type=2">销量</a></span>
						<span><a href="/ssyp/index.php/home/product/goodsList?type=3">推荐</a></span>
					<?php elseif($type==3): ?>
						<span><a href="/ssyp/index.php/home/product/goodsList?type=1">最新</a></span>
						<span><a href="/ssyp/index.php/home/product/goodsList?type=2">销量</a></span>
						<span  class="active"><a href="/ssyp/index.php/home/product/goodsList?type=3">推荐</a></span>
					<?php else: ?>
					<span class="active"><a href="/ssyp/index.php/home/product/goodsList?type=1">最新</a></span>
					<span><a href="/ssyp/index.php/home/product/goodsList?type=2">销量</a></span>
					<span ><a href="/ssyp/index.php/home/product/goodsList?type=3">推荐</a></span><?php endif; ?>

				</div>
			<div class="top1">
				<div class="recommand">
					<ul class="cont">
						<?php if(is_array($list)): foreach($list as $k=>$v): ?><li>
								<a href="/ssyp/index.php/home/product/detail?id=<?php echo ($v["id"]); ?>">
								<img src="/ssyp/Public/Home/images/outdoor.jpg" alt="">
								<span class="name"><?php echo ($v["name"]); ?></span>
								<!--<span class="name">百利甜</span>-->
								<span class="price ">￥<?php echo ($v["discount_price"]); ?></span>
								</a>
							</li><?php endforeach; endif; ?>
					</ul>
				</div>
			</div>
			
		</div>
	</body>
	<script>
         function active(obj){
	      $(obj).addClass('active');
          $(obj).siblings().removeClass('active');
         }
	</script>

</html>