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
		<link rel="stylesheet" type="text/css" href="/ssyp/Public/Home/css/detail.css">
		<link rel="stylesheet" href="/ssyp/Public/Home/css/global.css" />
		<script src="/ssyp/Public/Home/js/jquery.min.js"></script>
		<script src="/ssyp/Public/Home/js/common.js"></script>
		<script src="/ssyp/Public/Home/js/jquery-weui.min.js"></script>
		<script src="/ssyp/Public/Home/js/swiper.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="inner">
				<div class="index_plugin">
					<div class="swiper-container" data-space-between='10' data-pagination='.swiper-pagination' data-autoplay="45000">
						<div class="swiper-wrapper">
							<?php if(is_array($images)): foreach($images as $key=>$v): ?><div class="swiper-slide"><img style="width: 100%" src="/ssyp/Uploads/<?php echo ($v["img_name"]); ?>" alt=""></div><?php endforeach; endif; ?>

							<!--<div class="swiper-slide"><img src="/ssyp/Public/Home/images/banner.jpg" alt=""></div>-->
						</div>
						<div class="swiper-pagination"></div>
					</div>
				</div>
				<!--<div class="swiper-container" data-space-between='10' data-pagination='.swiper-pagination' data-autoplay="1000">
					<div class="top1" class="swiper-wrapper">
						<?php if(is_array($images)): foreach($images as $key=>$v): ?><div class="swiper-slide">
								<img  src="/ssyp/Uploads/<?php echo ($v["img_name"]); ?>" alt="" />
							</div><?php endforeach; endif; ?>
					</div>
					<div class="swiper-pagination"></div>
				</div>-->
				<div class="goods_info">
					<p class="name"><?php echo ($detail["name"]); ?></p>
					<p class="price">￥<?php echo ($detail["pro_price"]); ?></p>
					<p class="other"><text>运费：包邮</text> <text>库存：<?php echo ($detail["pro_number"]); ?></text></p>
					<div class="share" id="share">
						<img src="/ssyp/Public/Home/images/share.png" />
						<span>分享</span>
					</div>
				</div>
				<!--<img src="/ssyp/Public/Home/images/title.jpg" class='w100' />-->
				<div class="title">产品详情</div>
				<div class="cont">
					<?php echo ($detail["pro_detail"]); ?>
				</div>
			</div>
			<div class="oprate">
				<div class="kefu" onclick="location.href = 'tel:18603118355';">
					<img src="/ssyp/Public/Home/images/kefu.png" alt="" />
					<span>客服</span>
				</div>
				<div class="collect" id="collect">
					<img src="/ssyp/Public/Home/images/collect1.png" alt="" />
					<span>收藏</span>
				</div>
				<button class="btn cart" id="cart" onclick="aa()" style="background-color: #f5a623;">加入购物车</button>
				<button class="btn" id="btn" style="background-color: #ff7101;">立即购买</button>
			</div>
		</div>
	</body>
	<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script src="/ssyp/Public/Home/js/iscroll.js"></script>
	<script src="/ssyp/Public/Home/js/navbarscroll.js"></script>
	<script src="/ssyp/Public/Statics/laydate/laydate.js"></script>
	<script src="/ssyp/Public/Statics/layer/layer.js"></script>
	<script>
		$(function() {
			var localUrl = window.location.href;
			$('#share').on('click',function(){
				$.ajax({
				url: "https://bgt.we-fs.com/api/api/share",
				data: {
					'url': localUrl,
					'address': ''
				},
				success: function(res) {
					console.log(res);
					var info = JSON.parse(res);
					console.log(info);
					wx.config({
						debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
						appId: info.appId, // 必填，公众号的唯一标识
						timestamp: info.timestamp, // 必填，生成签名的时间戳
						nonceStr: info.nonceStr, // 必填，生成签名的随机串
						signature: info.signature, // 必填，签名
						jsApiList: [
							'checkJsApi',
							'onMenuShareTimeline',
							'onMenuShareAppMessage',
							'onMenuShareQQ',
							'onMenuShareWeibo',
							'chooseWXPay'
						]
					});
					wx.ready(function() {
						wx.onMenuShareTimeline({
							title: '云星太极文化中心' + goods_name, // 分享标题
							link: 'https://bgt.we-fs.com/html2/pages/detail.html?goods_id=' + goods_id, // 分享链接
							imgUrl: goods_img, // 分享图标
							success: function() {
								alert("分享成功");
							},
							cancel: function() {
								alert("分享取消");
							}
						});
						wx.onMenuShareAppMessage({
							title: '云星太极文化中心' + goods_name, // 分享标题
							link: 'https://bgt.we-fs.com/html2/pages/detail.html?goods_id=' + goods_id, // 分享链接
							imgUrl: goods_img, // 分享图标
							success: function() {
								alert("分享成功");
							},
							cancel: function() {
								alert("分享取消");
							}
						});
					})
				}
			})
			})
			
			var goods_id = getSearchString('goods_id');
			var openid = localStorage.getItem('openid');
			var goods_price;
			var goods_name;
			var goods_img;
			var goods_num;
			$.ajax({
				url: "https://bgt.we-fs.com/api/api/goodsInfo?admin_id=1&goods_id=" + goods_id,
				success: function(res) {
					var list = eval(res).data[0];
					console.log(list);
					$(".inner").append(`
								<div class="top1">
									<img src="https://bgt.we-fs.com/${list.img}" alt="" />
								</div>
								<p class="name">${list.goods_name}</p>
								<p class="price">${list.market_price}</p>
								<div class="line"></div>
								<div class="title"></div>
								<div class="cont">
									${list.goods_content}
								</div>
							`)
					goods_price = list.market_price;
					goods_name = list.goods_name;
					goods_img = 'https://bgt.we-fs.com/' + list.img;
					goods_num = 1;
					var imgs = $('.cont p img');
					console.log(imgs.length)
					for(var i = 0; i < imgs.length; i++) {
						var src1 = $(".cont p img").eq(i).attr("src");
						$(".cont p img").eq(i).attr("src", 'https://bgt.we-fs.com/' + src1);
					}
				},
				error: function(res) {
					console.log(res);
				}
			})
			var localUrl = window.location.href;
			$.ajax({
				url: "https://bgt.we-fs.com/api/api/share",
				data: {
					'url': localUrl,
					'address': ''
				},
				success: function(res) {
					console.log(res);
					var info = JSON.parse(res);
					console.log(info);
					wx.config({
						debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
						appId: info.appId, // 必填，公众号的唯一标识
						timestamp: info.timestamp, // 必填，生成签名的时间戳
						nonceStr: info.nonceStr, // 必填，生成签名的随机串
						signature: info.signature, // 必填，签名
						jsApiList: [
							'checkJsApi',
							'onMenuShareTimeline',
							'onMenuShareAppMessage',
							'onMenuShareQQ',
							'onMenuShareWeibo',
							'chooseWXPay'
						]
					});
					wx.ready(function() {
						wx.onMenuShareTimeline({
							title: '云星太极文化中心' + goods_name, // 分享标题
							link: 'https://bgt.we-fs.com/html2/pages/detail.html?goods_id=' + goods_id, // 分享链接
							imgUrl: goods_img, // 分享图标
							success: function() {
								alert("分享成功");
							},
							cancel: function() {
								alert("分享取消");
							}
						});
						wx.onMenuShareAppMessage({
							title: '云星太极文化中心' + goods_name, // 分享标题
							link: 'https://bgt.we-fs.com/html2/pages/detail.html?goods_id=' + goods_id, // 分享链接
							imgUrl: goods_img, // 分享图标
							success: function() {
								alert("分享成功");
							},
							cancel: function() {
								alert("分享取消");
							}
						});
					})
				}
			})
			//wx.hideOptionMenu();/***隐藏分享菜单****/

			// 购物车
			/*$('#cart').on('click', function() {
                alert('已购物车');
							$.ajax({
								url: "/ssyp/index.php/home/product/car?user_id=1"+ '&pro_id=' + "{detail.id}" + '&pro_price=' + "<?php echo ($detail["pro_price"]); ?>" + '&pro_name=' + "<?php echo ($detail["name"]); ?>",
								success: function(res) {
									/!*var list = JSON.parse(res);
									console.log(list);*!/
									alert('已加入购物车');
								},
								error: function(res) {
									console.log(res);
								}
							})
						})

				// 购买
			})*/
			$("#collect").on('click', function() {
				$('#collect img').attr('src','/ssyp/Public/Home/images/collect2.png');
				alert('收藏成功');
			})
			$('#btn').on('click', function() {
				//			var pays=[];
				//			var goods_id = getSearchString('goods_id');
				//			pays.push({
				//				'pays_name': $('.name').text(),
				//				'pays_price':($('.price').text()),
				//				'pays_num':1,
				//				'pays_img':$('.top1').find('img').attr('src'),
				//				'cart_id':goods_id
				//			})
				//			price=($('.price').text());
				//			localStorage.setItem('pays',JSON.stringify(pays));
				//			window.location.href="pay.html?price="+price
			})
		});
		$(".swiper-container").swiper({
			loop: true,
			autoplay: 3000
		});
        $('.wrapper').navbarscroll();
        function aa() {
            var data={
                'user_id':1,
				'pro_id':"<?php echo ($detail["id"]); ?>",
				'pro_price':"<?php echo ($detail["pro_price"]); ?>",
				'pro_name':"<?php echo ($detail["name"]); ?>"
			};
            $.ajax({
                'url':'/ssyp/index.php/home/product/car',
                'type':'post',
                'data':data,
				'dataType':'json',
                'success':function(res){
                    if(res.status == 404){
                        layer.msg(res.info);
                    }else if(res.status == 200){
                        layer.msg(res.info);
                        setTimeout(function(){
                            location.href="/ssyp/index.php/home/cart/cart?user_id=1"
                        },1000);
                    }else{
                        layer.msg(1);
                        layer.msg(res);
					}
                }
         	});
		}
</script>
</html>