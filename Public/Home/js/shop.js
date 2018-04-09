$(document).ready(function(){
 	
});
var page=1;
function pageLoad(url,idname){
	$(document).unbind("scroll").bind("scroll", function(e){
 		if ($(window).scrollTop() + $(window).height() >= $(document).height()){
 			$.ajax({
 				'url':url,
 				'data':{'p':page},
 				'success':function(res){
 					page  ++;
 					$('#'+idname).append(res)
 				}
 			})
 			$('#loading').slideDown('fast');
 		}
 	});
}

//添加上一个节点数值  酒店订单页面
function valChange(status,t,price){
	var obj = $(t).parent().children('.number');
	var v = obj.val();
	var old_v = v;
	if(status<0){
		v--;
	}else{
		v++;
	}
	if(v<=1)v=1;
	
	//判断新旧有无区别
	var cha = v - old_v;
	if(cha!=0){
		$('#zongjia,.zongjia').html( ( parseFloat($('#zongjia').html()) + parseFloat(cha*price)).toFixed(2))
	}
	obj.val(v);
	allchange(v);
}
function allchange(v){}


function for_submit_in(){
	return true;
}
function form_submit(t){
//	$(t).find('input').each(function(){
//		$(this).
//	})
	if(false === for_submit_in())return false;
	$.ajax({
		'url':$(t).attr('action'),
		'type':$(t).attr('method'),
		'data':$(t).serialize(),
		'dataType':'json',
		'success':function(res){
			//{"info":"\u5bc6\u7801\u9519\u8bef","status":0,"url":""}
			if(res.status == 0){
				layer.msg(res.info);
			}else if(res.status == 1){
				layer.msg(res.info);
				setTimeout(function(){
					location.href=res.url
				},1000);
			}
		}
	});
	return false;
}
//ajax改变单个
function chengeCookie(url,t){
	$.ajax({
		'url':url,
		'data':{'field':$(t).attr('name'),'data':$(t).val()},
		'type':'post'
	})
}

//ticket
function ticket(module){
	$.ajax({
		'url':module+'/Wx/qrcode',
		'success':function(src){
			var html = '<img style="margin:auto;display:block;" src="'+src+'" width="220px">';
			layer.open({
			  title: '我的二维码',
			  offset: 'b',
			  type: 1,
			  btn: ['发送到手机'] //可以无限个按钮
			  ,btn1: function(index, layero){
			    $.ajax({
			    	'url':module+'/Wx/sendTicket',
			    	'success':function(re){
			    		layer.closeAll();
			    		if(re === '1'){
			    			layer.msg('发送成功');
			    		}else{
			    			layer.msg('发送失败，请主动给公众号回复信息');
			    		}
			    	}
			    })
			  },
			  area: ['100%', '300px'], //宽高
			  content: html
			});
		}
	})
	
}

