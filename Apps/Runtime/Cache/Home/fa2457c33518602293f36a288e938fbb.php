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
	</body>
	<script>

		$(function() {
			var search=getSearchString('value');
			$.ajax({
				url: "https://bgt.we-fs.com/api/api/search?admin_id=1&value="+search+'&class=goods',
				success: function(res) {
					console.log(res);
					var list = JSON.parse(res).data;
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
			
		})
	</script>

</html>