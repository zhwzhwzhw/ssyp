var interMeg;
var megWite;
var isBeiZhu = false;
var lastMegId = 0;
var lastHeight = 0;
var shouc_show = false;
var send_time = 0;
var jg_time = 600;//间隔时间
var headimg;//其他人的头像
var myheadimg = false
var uuid = 0;
var error_time = 3000;
var load_num = 0;//ajax计数  弹出加载动画  需要些div遮罩标签 id="zhezhao_msg"    仅仅在发送消息 接受消息
var ph='';//常见问题总内容
//var isclick = false;//是不是点击 决定滚动条是否执行getmessage
$(function(){
	var user_divHeight = $('.left_side .other').height();
	var user_nScrollHeight = $('.left_side .other')[0].scrollHeight;
	var uid = $('input[name="m_to"]').val();
	if(uid != ''){
		getMessage(uid);
	}
	//判断滚动条是否在底部
	$("#message").scroll(function(){
	    var divHeight = $(this).height();
	    var nScrollHeight = $(this)[0].scrollHeight;
	    var nScrollTop = $(this)[0].scrollTop;
	    uid = $('input[name="m_to"]').val();
	    //alert(nScrollTop + '-' + divHeight + '=' + nScrollHeight)
	   //判断滚动到底部时候的事件
	    if(nScrollTop + divHeight +20 >= nScrollHeight) {
	    	clearInterval(interMeg);
	    	if(isBeiZhu){
		    	getRemarks(uid)
		    }else{
		    	getMessage(uid)
		    }
	    	
	    }else if(nScrollTop <= 0){
	    	clearInterval(interMeg);
	    	if(!isBeiZhu){
	    		getBeforeMeg()
	    	}
	    	
	    }else{
	    	clearInterval(interMeg);
	    }
	  });
	
	//提交
	$('#send').submit(function(){
		var content = $('textarea[name="content"]').val();
		uid = $('input[name="m_to"]').val();
		if(uid == '' ){
			alert('请选择发送人');
		}else if(content == '' ){
			alert('内容不能为空');
		}else{
			var action = 'send';
			if(isBeiZhu){
				action = 'setRemarks';
				$('#message').append('<li class="meg_time">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;刚刚&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li><li class="beizhu clearfix">'+replace_em(content)+'</li>');
				$('#message').scrollTop( $('#message')[0].scrollHeight);
			}
			$.ajax({
				'url':URL+'/'+action,
				'type':'post',
				'data':{'m_to':$('input[name="m_to"]').val(),'content':$('textarea[name="content"]').val()},
				'beforeSend': function(){
					load_num++
					$('#zhezhao_msg').show();
				},
				'timeout':error_time,
				'error':function(){
					load_num--
					if(load_num<=0){
						$('#zhezhao_msg').hide()
					}
					$('.net_error').stop().show().fadeOut(4000);
				},
				'success':function(re){
					load_num--
					if(load_num<=0){
						$('#zhezhao_msg').hide()
					}
					if(re=='1'){
						isckick=true
						send_success(content)
 						$('#message').append('<li class="me"><div>'+content+'</div></li>');
// 						$('#message').scrollTop( $('#message')[0].scrollHeight);
						$('textarea[name="content"]').val('');
					}else if(re == '0'){
						alert('发送失败');
					}
					$('#message').scrollTop( $('#message')[0].scrollHeight);
				}
			});
		}
		return false;
	});
	
	//名单点击
/*	$('.dt').click(function(){
		$('.ul li').css('background','none')
		var name = $(this).html();
		uid=$(this).attr('uid');
		
		if($('li[uid="'+uid+'"]').html() == undefined){
			var titleUser = '<li onclick="m_to(this)" uid="'+uid+'">'+name+'</li>';//在聊天中的用户顶部显示
			$('.ul').append(titleUser);
		}
		$('li[uid="'+uid+'"]').css('background','#666')
		$('input[name="m_to"]').val(uid);
		
		if(isBeiZhu){
			getRemarks(uid);
		}else{
			getMessage(uid);
		}
		
		
		$('.center_header,#message,.send_wrap').show()
	});*/
	
	//切换备注和对话
	//备注
	$('.qiehuan_bz').click(function(){
		isBeiZhu = true;
		$(this).addClass('current');
		$('.qiehuan_dh').removeClass('current')
		clearInterval(interMeg);
		if(uid != ''){
			getRemarks(uid)
		}
			
	});
	//对话
	$('.qiehuan_dh').click(function(){
		isBeiZhu = false;
		$(this).addClass('current');
		$('.qiehuan_bz').removeClass('current');
		if(uid != ''){
			getMessage(uid)
		}
		
	});
	
	//搜索联系人
	$('#search_user').on('input',function(){
		$.ajax({
			'url':URL+'/getUser/name/'+$(this).val(),
			'timeout':error_time,
			'error':function(){
				$('.net_error').stop().show().fadeOut(4000);
			},
			'success':function(re){
				if(re != ''){
					var user = '';
					$.each(re,function(i,v){
						var current = '';
						var src_head = 'src="'+STATICS+'images/other_header.png"';
						var nickname='匿名用户';
						if(v.nickname){
							nickname = v.nickname
						}
						if(v.headimgurl){
							src_head = 'src="'+v.headimgurl+'"';
						}
						if(uid == 'u_'+v.id){
							current = 'style="background:#999"'
						}
						user += '<li '+current+'><div class="other_header" onclick="click_user(this)"  uid="u_'+v.id+'">\
						<img '+src_head+' width="35px" height="35px" alt="">\
						</div>\
						<div class="other_meg" >\
							<dl class="other_name" onclick="click_user(this)" uid="u_'+v.id+'">'+nickname+'</dl>\
						</div></li>';
						
						
						$('.other').html(user);
					});
				}else{
					$('.other').html('<li style="color:#fff;text-align:center;line-height:70px;">未找到</li>');
				}
				
			}
		});
	});
	//常用语 点击分类
	$('.phrase dl:not("#shouc_me")').click(function(){
		/*全部隐藏*/
		$('.search_ph .ph_text').val('');
		$('.phrase dl').removeClass('ph_dl_current')
		$('.ph_co_wr').hide()
		$(this).addClass('ph_dl_current')
		/* aa*/
		var tObj = $(this)
		if($(this).next('.ph_co_wr').html() == undefined){ 
			var orderurl = '';
			var order = $('.phrase li.ph_dl_current').attr('data-order');
			if(order)
				orderurl = '/order/'+order;
			var lawyerurl = '';
			var lawyer = $('.phrase .ph_lawyer.ph_dl_current').attr('data-id');
			if(lawyer)
				lawyerurl = '/lawyerid/'+lawyer;
			var href = URL+'/getPhrase'+orderurl+'/typeid/'+$(this).attr('typeid')+lawyerurl;
			$.ajax({
				'url':href,
				'timeout':error_time,
				'error':function(){
					$('.net_error').stop().show().fadeOut(4000);
				},
				'beforeSend':function(){
					$('#phrase_list').html('<img style="display:block;margin:30px auto;" src="'+STATICS+'images/loading.gif" alt=""/>');
				},
				'success':function(re){
					$('.phrase dl').removeClass('ph_dl_current');
					append_ph(tObj,re)
				}
			})
		}else{
			ph = '';
			$(this).nextUntil('dl,#phrase_list,.clearfix').each(function(){
				ph += $(this).prop("outerHTML")
			});
			$('#phrase_list').html(ph);
			$('#phrase_list .ph_co_wr').show();
			/*if($(this).next('.ph_co_wr').css('display') == 'none'){
				$(this).addClass('ph_dl_current').nextUntil('dl').stop().slideDown();
			}else{
				$(this).removeClass('ph_dl_current').nextUntil('dl').stop().slideUp();
			}*/
		}
		
	});
	//我的收藏
	$(".shouc_me").click(function(){
		var tObj = $(this)
		if(!shouc_show){ 
			$.ajax({
				'url':URL+'/getPhrase/lawyerid/lawyerid',
				'timeout':error_time,
				'error':function(){
					$('.net_error').stop().show().fadeOut(4000);
				},
				'success':function(re){
					if(re != ''){
						var ph='';
						$.each(re,function(i,v){
							ph += '<div class="ph_co_wr" ondblclick="to_send(this,'+v.id+')">\
								<dd class="ph_title">'+v.title+'</dd>\
								<dd class="ph_content">'+v.content+'</dd>\
								<dd class="ph_caina">'+v.use_num+'次采纳</dd>\
								</div>';
						})
					}
					tObj.nextAll('.ph_co_wr').remove()
					tObj.addClass('ph_dl_current').after(ph);
					shouc_show = true;
				}
			})
		}else{
			if($(this).next('.ph_co_wr').css('display') == 'none'){
				$(this).addClass('ph_dl_current').nextAll('.ph_co_wr').stop().slideDown();
			}else{
				$(this).removeClass('ph_dl_current').nextUntil('dl').stop().slideUp();
			}
		}
	});
	//红包发送开始
	$('.hongb').click(function(){
		if($('.hongb_wrap').css('display') == 'none'){
			$('.hongb_wrap').stop().show().animate({'width':'205px'});
		}else{
			$('.hongb_wrap').stop().animate({'width':'0px'},'next',function(){
				$('.hongb_wrap').hide()
			});
		}
	});
	$('.hongb_send').click(function(){
		if($('.hongb_money').val()==''){
			show_err_msg('请正确输入金额');
		}else{
			$.ajax({
				'url':URL+'/reward',
				'type':'post',
				'data':{'m_to':uid,'money':$('.hongb_money').val()},
				'timeout':error_time,
				'error':function(){
					$('.net_error').stop().show().fadeOut(4000);
				},
				'success':function(re){
					if(re == 'error'){
						show_err_msg('请正确输入金额');
					}else if(re == 'notEnough'){
						show_err_msg('您的余额不足，请先充值');
					}else if(re == '1'){
						$('.hongb_wrap').stop().animate({'width':'0px'},'next',function(){
							$('.hongb_wrap').hide();
						});
						$('hongb_money').val('')
						$('#message').scrollTop( $('#message')[0].scrollHeight);
					}else if(re == '0'){
						show_err_msg('红包发送失败');
					}
					
				}
			})
		}
	})
	//红包结束
	
	
	
	//搜索常见问题
/*	$('.ph_text').on('input',function(){
		search_phrase()
	})*/
	$('.ph_button').click(function(){
		search_phrase()
	})
	
	//评论点赞
/*	$('.dianzan').click(function(e){
		var z = $(this)
		var n = parseInt(z.next().html());
		$.ajax({
			'url':'__MODULE__/Index/commentUpnumAdd/ajax/ajax/id/'+$(this).attr('commentid'),
			'success':function(re){
				if(re == 'no_login'){
					location.href="__MODULE__/Member/login"
				}else if(re == 'have_up'){
					$('#addone').html('已赞').show().css({'top':e.pageY-10,'left':e.pageX-10}).animate({'top':e.pageY-30}).fadeOut(1000)
				}else{
					z.next().html(n+1)
					z.removeClass('weidian').addClass('yidian')
					$('#addone').html('+1').show().css({'top':e.pageY-10,'left':e.pageX-10}).animate({'top':e.pageY-30}).fadeOut(1000)
				}
			}
		});
	})*/
	//收藏
	$('.shouc').click(function(){
		$('.shouc_wrap > table textarea').val($('#saytext').val());
		if($('.shouc_wrap').css('display')=='none'){
			$('.shouc_wrap').show();
		}else{
			$('.shouc_wrap').hide()
		}
	})
	$('.shouc_qx').click(function(){
		$('.shouc_wrap').hide()
	})
	$('.shouc_qr').click(function(){
		var shouc_content = $('.shouc_wrap>table textarea').val();
		var shouc_title = $('.shouc_wrap>table input').val();
		var shouc_type = $('.shouc_wrap>table select').val();
		if(shouc_content==''){
			$('#shouc_meg').hide().html('请输入内容').stop().show().fadeOut(4000);
		}else if(shouc_title==''){
			$('#shouc_meg').hide().html('请输入标题').stop().show().fadeOut(4000);
		}else if(shouc_type==''){
			$('#shouc_meg').hide().html('请选择分类').stop().show().fadeOut(4000);
		}else{
			$.ajax({
				'url':MODULE+'/Phrase/add/ajax/ajax',
				'type':'post',
				'data':{'title':shouc_title,'content':shouc_content,'typeid':shouc_type},
				'timeout':error_time,
				'error':function(){
					$('.net_error').stop().show().fadeOut(4000);
				},
				'success':function(re){
					if(!isNaN(re)){
						var ph = '<div class="ph_co_wr" ondblclick="to_send(this,'+re+')">\
								<dd class="ph_title">'+shouc_title+'</dd>\
								<dd class="ph_content">'+shouc_content+'</dd>\
								<dd class="ph_caina">'+0+'次采纳</dd>\
								</div>';
						$('#shouc_me').addClass('ph_dl_current').after(ph);
						$('.shouc_wrap').hide();
						$('.shouc_wrap>table textarea').val('')
						$('.shouc_wrap>table input').val('')
						$('.shouc_wrap>table select').val('0')
					}else{
						$('#shouc_meg').hide().html(re).stop().show().fadeOut(4000);
					}
					$("#shouc_me").show();
					
					
				}
			})
		}
		
	})
	
//	$('.left_side .other li').mouseover(function(){
//		if($(this).attr('data-color')!= 1){
//			$(this).css('background-color','#323336')
//		}
//		
//	}).mouseout(function(){
//		if($(this).attr('data-color')!= 1){
//			$(this).css('background','#3C3F46');
//		}
//	});
	//下拉加载更多用户
	$('.left_side .other').scroll(function(){
		var divHeight = $(this).height();
	    var nScrollHeight = $(this)[0].scrollHeight;
	    var nScrollTop = $(this)[0].scrollTop;
	    if(nScrollTop + divHeight  >= nScrollHeight){
	    	addMoreUser()
	    }
	});
	if(user_divHeight  >= user_nScrollHeight){
    	addMoreUser();
    }
	//用户分类导航的点击 
	$('.left_side .other_nav li').click(function(){
		$('.left_side .other_nav li').removeClass('nav_current');
		$(this).addClass('nav_current');
		$('.other li').hide();
		$('.other .meg_status'+$(this).attr('data-meg-status')).show();
		var divHeight = $('.left_side .other').height();
	    var nScrollHeight = $('.left_side .other')[0].scrollHeight;
	    if(divHeight  >= nScrollHeight){
	    	addMoreUser();
	    }
	});
	
	//上传
	
/*		$('#file_upload').uploadify({
			'swf'      : STATICS+'js/uploadify.swf',
			'uploader' : MODULE+"/Public/uploadify/me/"+session,
			'fileSizeLimit':'20MB',
			'onUploadStart':function(){
				$('#file_upload').uploadify('settings','formData',$('input[name="m_to"]').val());
			},
			
			'onUploadSuccess' : function(file, data, response) {
	            //alert('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);
				if(data == '1'){
					
				}else if(data == '0'){
					alert('请选择联系人')
				}else{
					alert(data)
				}
	            
		    }
		});*/
		
		$('.swfupload').attr('title','发送文件：允许发送小于20MB的文件类型有图片、压缩文件、word文件和txt文件');

		/*无刷新分页*/
		$('body').on('click','#msg_page a',function(){
			var href = $(this).attr('href');
			phrese_ajax_require(href,'page_click')
			return false;
		})
	
});

/*常见问题排序*/
function phrase_order(t,order){
	$('.search_ph .ph_text').val('');
	$('.right_side .phrase li').removeClass('ph_dl_current');
	$(t).addClass('ph_dl_current')
	var typeurl = '';
	var typeid = $('.phrase dl.ph_dl_current').attr('typeid');
	if(typeid)
		typeurl = '/typeid/'+typeid;
	var lawyerurl = '';
	var lawyer = $('.phrase .ph_lawyer.ph_dl_current').attr('data-id');
	if(lawyer)
		lawyerurl = '/lawyerid/'+lawyer;
	var href = URL+'/getPhrase'+typeurl+'/order/'+order+lawyerurl;
	phrese_ajax_require(href,'ph_order_click')
}
/*更具发布律师找phrase*/
function phrase_lawyer(t,id){
	$('.search_ph .ph_text').val('');
	$('.right_side .phrase>.ph_lawyer').removeClass('ph_dl_current');
	$(t).addClass('ph_dl_current');
	var typeurl = '';
	var typeid = $('.phrase dl.ph_dl_current').attr('typeid');
	if(typeid)
		typeurl = '/typeid/'+typeid;
	var orderurl = '';
	var order = $('.phrase li.ph_dl_current').attr('data-order');
	if(order)
		orderurl = '/order/'+order;
	var href = URL+'/getPhrase'+'/lawyerid/'+id+typeurl+orderurl;
	phrese_ajax_require(href,'ph_order_click')
}
//phrase发起ajax请求
function phrese_ajax_require(href,funname){
	var f = eval(funname);
	$.ajax({
		'url':href,
		'timeout':error_time,
		'error':function(){
			$('.net_error').stop().show().fadeOut(4000);
		},
		'beforeSend':function(){
			$('#phrase_list').html('<img style="display:block;margin:30px auto;" src="'+STATICS+'images/loading.gif" alt=""/>');
		},
		'success':f
	})
}

function page_click(re){
	var phObj = $('.phrase .ph_dl_current');
	//phObj.nextUntil('dl,#phrase_list,.clearfix').remove()
	append_ph(phObj,re)
}
function ph_order_click(re){
	//phObj.nextUntil('dl,#phrase_list,.clearfix').remove()
	append_ph(this,re)
}

function m_to(t){	
	uid=$(t).attr('uid');
	$('.ul li').css('background','none')
	$(t).css('background','#666')
	$('input[name="m_to"]').val(uid);
	getMessage(uid);
}
//搜索常见问题
function search_phrase(){
	if($('.ph_text').val().length){
		var orderurl = '';
		var order = $('.phrase li.ph_dl_current').attr('data-order');
		if(order)
			orderurl = '/order/'+order;
		var typeurl = '';
		var typeid = $('.phrase dl.ph_dl_current').attr('typeid');
		if(typeid)
			typeurl = '/typeid/'+typeid;
		var lawyerurl = '';
		var lawyer = $('.phrase .ph_lawyer.ph_dl_current').attr('data-id');
		if(lawyer)
			lawyerurl = '/lawyerid/'+lawyer;
		$.ajax({
			'url':URL+'/getPhrase/title/'+$('.ph_text').val()+orderurl+typeurl+lawyerurl,
			'timeout':error_time,
			'error':function(){
				$('.net_error').stop().show().fadeOut(4000);
			},
			'beforeSend':function(){
				$('#phrase_list').html('<img style="display:block;margin:30px auto;" src="'+STATICS+'images/loading.gif" alt=""/>');
			},
			'success':function(re){
				ph = '';
				$.each(re,phrase_ajaxre);
				$('#phrase_list').html(ph).find('.ph_co_wr').show();
			}
		});
	}else{
		$('#phrase_list').empty();
	}
	
}
//定时获取信息
function getMessage(m_to){
	clearTimeout(megWite)
	$('.meg_wite').hide();
	var uid = $('input[name="m_to"]').val();
	send_time=0;
	$.ajax({
		'url':URL+'/getMessage',
		'dataType':'json',
		'type':'post',
		'data':{'m_to':m_to},
		'beforeSend': function(){
			load_num++
		},
		'success':function(re){
			isckick=false
			load_num--
			if(load_num<=0){
				$('#zhezhao_msg').hide()
			}
			$('[uid="'+uid+'"]').children('span').remove();//点击消除未读提醒（一闪一闪）
			//这里消除红点
			killRedPoing();
			var message = '';
			var isFirst = true;
			$.each(re,function(k,v){
				if(isFirst){
					lastMegId = v.id;
				}
				isFirst = false ;
				if((v.send_time-send_time)>=jg_time){
					message += '<li class="meg_time">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+data_time(v.send_time)+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>';
				}
				if(v.m_from == uid){
					//判读是否有头像
					message += '<li class="other clearfix"><div class="meg_header"><img src="'+headimg+'" width="35px" height="35px" alt=""/></div><div class="meg_content">'+replace_em(v.content)+'</div></li>'
				}else{
					if(myheadimg === false){
						message += '<li class="me clearfix"><div class="meg_header"><img src="'+STATICS+'images/other_header.png" width="35px" height="35px" alt=""/></div><div class="meg_content">'+replace_em(v.content)+'</div>'+msg_menu(v)+'</li>';
					}else if(myheadimg === 'arr'){
						message += '<li class="me clearfix"><div class="meg_header"><img src="'+STATICS+'images/headimg/'+v.m_from+'.jpg" width="35px" height="35px" alt=""/></div><div class="meg_content">'+replace_em(v.content)+'</div>'+msg_menu(v)+'</li>';
					}else{ //正合适的头像
						message += '<li class="me clearfix"><div class="meg_header"><img src="'+myheadimg+'" width="35px" height="35px" alt=""/></div><div class="meg_content">'+replace_em(v.content)+'</div>'+msg_menu(v)+'</li>';
					}
					
				}
				send_time = v.send_time;
			});
			$('#message').html(message);
			$('#message').scrollTop( $('#message')[0].scrollHeight - $('#message').height())
		}
		
	});
	clearInterval(interMeg);
	interMeg = setInterval(function(){
		send_time=0;
		$.ajax({
			'url':URL+'/getMessage',
			'dataType':'json',
			'type':'post',
			'data':{'m_to':m_to},
			'beforeSend': function(){
				load_num++
			},
			'success':function(re){
				load_num--
				if(load_num<=0){
					$('#zhezhao_msg').hide()
				}
				$('[uid="'+uid+'"]').children('span').remove();//点击消除未读提醒
				var message = '';
				var isFirst = true ;
				$.each(re,function(k,v){
					if(isFirst){
						lastMegId = v.id;
					}
					isFirst = false ;
					if((v.send_time-send_time)>=jg_time){
						message += '<li class="meg_time">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+data_time(v.send_time)+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>';
					}
					if(v.m_from == uid){
						message += '<li class="other clearfix"><div class="meg_header"><img src="'+headimg+'" width="35px" height="35px" alt=""/></div><div class="meg_content">'+replace_em(v.content)+'</div></li>';
						
					}else{
						if(myheadimg === false){
							message += '<li class="me clearfix"><div class="meg_header"><img src="'+STATICS+'images/other_header.png" width="35px" height="35px" alt=""/></div><div class="meg_content">'+replace_em(v.content)+'</div>'+msg_menu(v)+'</li>';
						}else if(myheadimg === 'arr'){ //一群人
							message += '<li class="me clearfix"><div class="meg_header"><img src="'+STATICS+'images/headimg/'+v.m_from+'.jpg" width="35px" height="35px" alt=""/></div><div class="meg_content">'+replace_em(v.content)+'</div>'+msg_menu(v)+'</li>';
						}else{ //正合适的头像
							message += '<li class="me clearfix"><div class="meg_header"><img src="'+myheadimg+'" width="35px" height="35px" alt=""/></div><div class="meg_content">'+replace_em(v.content)+'</div>'+msg_menu(v)+'</li>';
						}
					}
					send_time = v.send_time;
				});
				$('#message').html(message);
				$('#message').scrollTop( $('#message')[0].scrollHeight);
			}
			
		});
	},10000);

	
}

//上拉获取信息
function getBeforeMeg(){
	send_time=0;
	lastHeight = $('#message')[0].scrollHeight;
	var uid = $('input[name="m_to"]').val();
	$.ajax({
		'url':URL+'/getMessage/before/'+lastMegId,
		'dataType':'json',
		'type':'post',
		'data':{'m_to':uid},
		'timeout':error_time,
		'error':function(){
			load_num--
			if(load_num<=0){
				$('#zhezhao_msg').hide()
			}
			$('.net_error').stop().show().fadeOut(4000);
		},
		'beforeSend':function(){
			megWite = setTimeout(function(){
				$('.meg_wite').show(); //请稍后字样
			},1000)
			load_num++
			
		},
		'success':function(re){
			load_num--
			if(load_num<=0){
				$('#zhezhao_msg').hide()
			}
			clearTimeout(megWite)
			$('.meg_wite').hide();
			$('[uid="'+uid+'"]').children('span').remove();//点击消除未读提醒
			var message = '';
			var isFirst = true;
			$.each(re,function(k,v){
				if(isFirst){
					lastMegId = v.id;
				}
				isFirst = false ;
				if((v.send_time - send_time)>=jg_time){
					message += '<li class="meg_time">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+data_time(v.send_time)+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>'
				}
				if(v.m_from == uid){
					
					
					if(v.isread == 0){//未读消息
						//判读是否有头像
						message += '<li class="other clearfix"><div class="meg_header"><img src="'+headimg+'" width="35px" height="35px" alt=""/></div><div class="meg_content" style="position:relative;">'+replace_em(v.content)+'<div id="newMeg">未读</div></div></li>';
					}else{
						//判读是否有头像
						message += '<li class="other clearfix"><div class="meg_header"><img src="'+headimg+'" width="35px" height="35px" alt=""/></div><div class="meg_content">'+replace_em(v.content)+'</div></li>';
					}
					
				}else{
					//判读是否有头像
					if(myheadimg === false){
						message += '<li class="me clearfix"><div class="meg_header"><img src="'+STATICS+'images/other_header.png" width="35px" height="35px" alt=""/></div><div class="meg_content">'+replace_em(v.content)+'</div>'+msg_menu(v)+'</li>';
					}else if(myheadimg === 'arr'){ //一群人
						message += '<li class="me clearfix"><div class="meg_header"><img src="'+STATICS+'images/headimg/'+v.m_from+'.jpg" width="35px" height="35px" alt=""/></div><div class="meg_content">'+replace_em(v.content)+'</div>'+msg_menu(v)+'</li>';
					}else{ //正合适的头像
						message += '<li class="me clearfix"><div class="meg_header"><img src="'+myheadimg+'" width="35px" height="35px" alt=""/></div><div class="meg_content">'+replace_em(v.content)+'</div>'+msg_menu(v)+'</li>';
					}
				}
				send_time = v.send_time;
			});
			$('#message').prepend(message);
			$('#message').scrollTop($('#message')[0].scrollHeight - lastHeight);
		}
		
	});	
}



//获取备注消息
function getRemarks(m_to){
	$.ajax({
		'url':URL+'/getRemarks',
		'dataType':'json',
		'type':'post',
		'data':{'m_to':m_to},
		'timeout':error_time,
		'error':function(){
			$('.net_error').stop().show().fadeOut(4000);
		},
		'success':function(re){
			var message = '';
			$.each(re,function(k,v){
				message += '<li class="meg_time">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+data_time(v.send_time)+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li><li class="beizhu clearfix">'+replace_em(v.content)+'</li>';
			});
			$('#message').html(message);
			$('#message').scrollTop( $('#message')[0].scrollHeight);
		}
		
	});
}


//点击名单
function click_user(t){
	headimg = $(t).parents('li').children('.other_header').children('img').attr('src');
	
	$('.ul li').css('background','none')
	var name = $(t).html();
	uid=$(t).attr('uid');
	//判断是否隐藏红包
	if(uid.substring(0,1) == 'l'){
		$('.hongb').show();
	}else{
		$('.hongb').hide();
	}
	
	
	
	if($('li[uid="'+uid+'"]').html() == undefined){
		var titleUser = '<li onclick="m_to(this)" uid="'+uid+'">'+name+'</li>';//在聊天中的用户顶部显示
		$('.ul').append(titleUser);
	}
	//$('li[uid="'+uid+'"]').css('background','#666')
	$('input[name="m_to"]').val(uid);
	
	if(isBeiZhu){
		getRemarks(uid);
	}else{
		getMessage(uid);
	}
	$('.center_header,#message,.send_wrap').show()
	$(t).parents('.other').children('li').css('background','#3C3F46').attr('data-color','0');
	$(t).parents('li').css('background','#888').attr('data-color','1');
	click_user_do(t);
	if(load_num > 0){
		$('#zhezhao_msg').show();
	}
}
function click_user_do(t){
	
}

//双击到发送框
function to_send(t,id){
	if($('.send_wrap').css('display')!='none'){
		var content = $(t).children('.ph_content').html();
		$('#send textarea').val(content);
		$.ajax({
			'url':URL+'/addPhUseNum/id/'+id
		})
	}
	
}

//绑定ctrl+回车  发送
$(document).keydown(function(e){
	if(e.ctrlKey && e.keyCode === 13 ){
		$('#saytext').val($('#saytext').val()+'\r\n')
		return false
	} 
	if(e.keyCode === 13 && $('#send textarea').val().length){
		$("#send").submit();
	} 
})


//未读提醒
$.ajax({
		'url':URL+'/getRead',
		'dataType':'json',
		'success':function(re){
			$.each(re,function(i,v){
				addReadUser(v.nickname,v.headimgurl,v.m_from);
				var obj = $('[uid="'+v.m_from+'"].other_name');
				obj.children('span').remove();
				var name = obj.html();
				if(v.num>99){
					v.num = '…';
				}
				obj.html(name+'<span class="read-num"> '+v.num+'</span>');
			});
		}
});
var getReadInt = setInterval(function(){
	$.ajax({
		'url':URL+'/getRead/ajax/ajax',
		//'dataType':'json',
		'success':function(re){
			if(re == 'no_login'){
				alert('检查是否已退出登录');
				location.href='';
			}else{
				$.each(re,function(i,v){
					addReadUser(v.nickname,v.headimgurl,v.m_from);
					var obj = $('[uid="'+v.m_from+'"].other_name');
					obj.children('span').remove();
					var name = obj.html();
					if(v.num>99){
						v.num = '…';
					}
					obj.html(name+'<span class="read-num"> '+v.num+'</span>');
				});
			}
			
		}
	
	});
},20000);


//时间
function data_time(time){ 
	var now = new Date(parseInt(time) * 1000);
	return now.toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
}
//
function data_time_ymd(time){ 
	var now = new Date(parseInt(time) * 1000);
	var temp =  now.toLocaleString().replace(/年|月/g, "/").replace(/日/g, "").replace(/\s.*/g, "");
	return temp//.substr(0,10);.replace(/\/(\d*?)/g, "/$1")
}


//在某事件下 改变表单俩位浮点数 （金钱）
//点击改变受理状态
function changeMesStatus(t,id,s){
	$.ajax({
		'url':URL+'/changeMesStatus/s/'+s+'/id/'+id,
		'success':function(re){
			if(re == '1'){
				$(t).parents('li').removeClass('meg_status'+(s-1)).addClass('meg_status'+s).hide();
				if(s == 1){
					$(t).parent().append('<dt class="other_meg_status" title="点击移动到已经完成" onclick="changeMesStatus(this,'+id+',2)">受理中</dt>');
					$(t).remove();
				}else if(s == 2){
					$(t).parent().append('<dt class="other_meg_status" >已完成</dt>');
					$(t).remove();
				}
				
			}
		}
	})
}


/*追加点击分类的内容*/
function append_ph(tObj,re){
	if(re != ''){
		ph = '';
		$.each(re,phrase_ajaxre);
	}else{
		ph = '<div class="ph_co_wr" style="display:none;text-align:center;font-size:14px; color:#fe4242;margin-top:10px">未找到此类消息</div>'
	}
	$(tObj).addClass('ph_dl_current')//.after(ph);
	$('#phrase_list').html(ph);
	$('#phrase_list .ph_co_wr').show();
}
/*ajax返回的数据*/
function phrase_ajaxre(i,v){
	if(i != 'page'){
		ph += '<div style="display:none;" class="ph_co_wr" ondblclick="to_send(this,'+v.id+')">\
		<dd class="ph_title">'+v.title+'</dd>\
		<dd class="ph_content">'+v.content+'</dd>\
		<dd class="ph_caina">'+v.use_num+'次采纳</dd>\
		</div>';
	}else{
		ph += '<div class="ph_co_wr" style="display:none;" >\
		'+v+'\
		</div>';
	}
}


//接受到消息 添加 未读消息用户排序和显示
function addReadUser(nickname,headimgurl,m_from){
	
}

function addMoreUser(){
	
}
//消除红点
function killRedPoing(){
	
}

//发送成功后执行的函数
function send_success(content){
	//在lawyer/consultMsg中写了
}

//小菜单显示

function msg_menu(obj){
	return '';
}





