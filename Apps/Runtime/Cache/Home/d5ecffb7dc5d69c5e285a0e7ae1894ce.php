<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
		<link rel="stylesheet" href="/ssyp/Public/Home/css/reset.css"/>
		<link rel="stylesheet" href="/ssyp/Public/Home/css/cart.css"/>
		<link rel="stylesheet" href="/ssyp/Public/Home/css/global.css"/>
		<script src="/ssyp/Public/Home/js/common.js"></script>
	</head>

	<body>
		<div class="addGoods">
			<div class="top">
				<div class="goods_list">
					<?php if(is_array($car)): foreach($car as $key=>$v): ?><div class="list">
							<div class="check">
								<img src="/ssyp/Public/Home/images/check.png" />
							</div>
							<div class="photo">
								<img src="/ssyp/Uploads/<?php echo ($v["wx_image"]); ?>" alt="" />
							</div>
							<div class="info">
								<span class="name"><?php echo ($v["name"]); ?></span>
								<p class="price">¥</p><span class="goods_price price"><?php echo ($v["pro_price"]); ?></span>
								<div class="oprate">
									<p class="icon minus">-</p>
									<span class="count"><?php echo ($v["number"]); ?></span>
									<p class="icon plus">+</p>
								</div>
							</div>
							<div class="remove">X</div>
						</div><?php endforeach; endif; ?>
				</div>
				<div class="pay">
					<div class="check1 checkAll">
						<img src="/ssyp/Public/Home/images/check.png" />
						<span>全选</span>
					</div>
					<div class="total">
						总计：￥<span class="totalPrice">0</span>
					</div>
					<button type="submit" class="confirm">去付款</button></div>
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
		<script type="text/javascript">
			$(document).ready(function() {
				var openid = localStorage.getItem('openid');
				$.ajax({
					type: "get",
					url: "https://bgt.we-fs.com/api/api/cartinfo?admin_id=1&openid=" + openid,
					success: function(res) {
						var info = JSON.parse(res).data;
						console.log(info);
						if(typeof(info)=='undefined') {
							$('.goods_list').append('<p class="notice">您还没有添加商品哦</p>');
						} else {
							for(var i in info) {
								$('.goods_list').append(`
									<div class="list">
										<div class="check">
											<img src="/ssyp/Public/Home/images/check.png" />
										</div>
										<div class="photo">
											<img src="${info[i].goods_img}" alt="" />
										</div>
										<div class="info">
											<span class="name">${info[i].goods_name}</span>
											<p class="price">¥</p><span class="goods_price price">${info[i].goods_price}</span>
											<div class="oprate">
												<p class="icon minus">-</p>
												<span class="count">1</span>
												<p class="icon plus">+</p>
											</div>
										</div>
										<input type="hidden" name="" value="${info[i].goods_id}" />
										<div class="remove">X</div>
									</div>
								`);
							}
						}
					},
					error: function(){
						
					}
				})
				$('body').on('click', '.remove', function() {
					var goods_id=$(this).siblings('input[type=hidden]').val();
					console.log(goods_id);
					console.log("https://bgt.we-fs.com/api/api/del?admin_id=1&name_id=cart_id"+'&class=cart'+'&openid='+openid+'&id='+goods_id);
					var mythis = $(this)
					$.ajax({
						type: "get",
						url: "https://bgt.we-fs.com/api/api/del?admin_id=1&name_id=cart_id"+'&class=cart'+'&openid='+openid+'&id='+goods_id,
						success: function(res) {
							console.log(res);
							mythis.parent().remove();
							var num = mythis.siblings('.info').find(".count").text();
							var shopPrice = mythis.siblings('.info').children('.goods_price').text();
							if((mythis.parents('.list').children('.check').hasClass('checked'))) {
								var goods_price = parseFloat(shopPrice * num);
								$(".totalPrice").text((parseFloat($(".totalPrice").text()) - goods_price).toFixed(2));
							}else{
								var goods_price = parseFloat(shopPrice * num);
								$(".totalPrice").text(parseFloat($(".totalPrice").text()).toFixed(2));
							}
						},
						error: function(res) {
							console.log(res)
						}
					})
				})
				
				$("body").on('click', '.plus', function() {
					var num = $(this).siblings(".count").text();
					num++;
					$(this).siblings(".count").text(num);
					if($(this).parents('.list').children('.check').hasClass('checked')) {
						var goods_price = parseFloat($(this).parent().parent().children(".goods_price").text());
						$(".totalPrice").text((parseFloat($(".totalPrice").text()) + goods_price).toFixed(2));
					}

				});

				$("body").on('click', '.minus', function() {
					var num = $(this).siblings(".count").text();
					num--;
					$(this).siblings(".count").text(num);
					if($(this).parents('.list').children('.check').hasClass('checked')) {
						var goods_price = parseFloat($(this).parent().parent().children(".goods_price").text());
						$(".totalPrice").text((parseFloat($(".totalPrice").text()) - goods_price).toFixed(2));
					}
					if(num <= 1) {
						$(this).css('pointer-events', 'none');
					}
				});

				$("body").on('click', '.check', function() {
					if(!($(this).hasClass('checked'))) {
						$(this).find('img').attr('src', '/ssyp/Public/Home/images/checked.png');
						$(this).addClass('checked');
						var num = $(this).siblings('.info').find(".count").text();
						var shopPrice = $(this).siblings('.info').children('.goods_price').text();
						$(".totalPrice").text((parseFloat($(".totalPrice").text()) + parseFloat(shopPrice * num)).toFixed(2));
					} else {
						$(this).find('img').attr('src', '/ssyp/Public/Home/images/check.png');
						$(this).removeClass('checked');
						var num = $(this).siblings('.info').find(".count").text();
						var shopPrice = $(this).siblings('.info').children('.goods_price').text();
						$(".totalPrice").text((parseFloat($(".totalPrice").text()) - parseFloat(shopPrice * num)).toFixed(2));
					}
				});
				$('.checkAll').click(function() {
					if(!($(this).hasClass('checkedAll'))) {
						$('.list').find('.check').children('img').attr('src', '/ssyp/Public/Home/images/checked.png');
						$(this).find('img').attr('src', '../img/checked.png');
						$(this).addClass('checkedAll');
						$('.list').find('.check').addClass('checked');
						var arr = [];
						for(var i = 0; i < $('.list').length; i++) {
							var list = parseFloat($('.list').eq(i).find('.count').text());
							var count = parseFloat($('.list').eq(i).find('.goods_price').text());
							var totalPrice = list * count;
							arr.push(totalPrice)
						}
						function getSum(total, num) {
							return total + num;
						}
						function myFunction(item) {
							document.getElementsByClassName("totalPrice")[0].innerHTML = arr.reduce(getSum);
							totalPrice = arr.reduce(getSum)+'';
							if(totalPrice.indexOf('.') < 0){
								totalPrice=arr.reduce(getSum)+'.00'
							}
							$('.totalPrice').text(totalPrice)
						}
						myFunction();
					} else {
						$('.list').find('.check').children('img').attr('src', '/ssyp/Public/Home/images/check.png');
						$('.list').find('.check').removeClass('checked');
						$(this).find('img').attr('src', '../img/check.png');
						$(this).removeClass('checkedAll');
						$('.totalPrice').text(0);
					}
				})
				
				$('.confirm').on('click',function(){
					var checkeds=$('.checked');
					console.log(checkeds.length);
					var pays=[];
					for (var i=0;i<checkeds.length;i++) {
						pays.push({
							'pays_name': $('.list').eq(i).find('.name').text(),
							'pays_price':$('.list').eq(i).find('.goods_price').text(),
							'pays_num':$('.list').eq(i).find('.count').text(),
							'pays_img':$('.list').eq(i).find('.photo').children('img').attr('src'),
							'cart_id':$('.list').eq(i).find('input[type=hidden]').val(),
						})
						console.log(pays);
					}
					var totalPrice=$('.totalPrice').text();
					if(totalPrice==0){
						alert('您还没有选择商品');
					}else{
						localStorage.setItem('pays',JSON.stringify(pays));
						window.location.href="pay.html?price="+totalPrice;
					}
					
				})
			});
		</script>
	</body>

</html>