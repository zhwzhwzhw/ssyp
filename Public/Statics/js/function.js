//分装一个类似于微信的弹框函数
var pop_box_time;
var cur_img_node;//记录当前查看的是哪张图片
function pop_box(msg){
	var box = '<div id="pop_box" style="position:fixed;bottom:100px;border-radius:5px;filter:alpha(opacity=80);\
				-moz-opacity:0.80;\
				opacity:0.80;background:#000;color:#fff;font-size:14px;text-align:center;padding:5px 20px;z-index:1000">'+msg+'</div>';
	clearTimeout(pop_box_time);
	$(function(){
		$('body').append(box);
		$('#pop_box').css('left',($('body').width()-$('#pop_box').width())/2-20);
		pop_box_time = setTimeout(function(){
			clearTimeout(pop_box_time);
			$('#pop_box').remove()
		},1500);
	})
}

/**
 * 查看大图
 * @param t
 */
function show_img(t){
	cur_img_node = $(t).parents('.image_upload');
	var src = $(t).attr('src');
	var box = '<div id="img_box" ontouchmove="TouchTo(this,\'my_void\',\'prev_img\',\'my_void\',\'next_img\',50)" style="position:fixed;z-index:51;border-radius:5px;\
	background:#fff;width:90%;left:5%;"><img id="img_big" src="'+src+'" alt="" width="100%" >\
	<div onclick="close_img()" style="background:#fff;color:#fe4242;position:absolute;top:-35px;right:-5%;width:30px;height:30px;border-radius:50%;text-align:center;line-height:25px;font-size:30px;">×</div>\
	</div>';
	var zhezhao = '<div onclick="close_img()" id="zhezhao" style="opacity:0.5;filter:alpha(opacity=50);top:0;z-index:50;position:fixed;width:100%;height:100%;background:#000;">\
		</div>'
	$(function(){
		if($('#img_box').length == 0){
			$('body').append(box).append(zhezhao);
		}else{
			$('#img_box #img_big').attr('src',src);
			$('#zhezhao,#img_box').show();
		}
		$('#img_box').css({'top':($(window).height()-$('#img_box').height())/2});
	})
}

function close_img(){
	$('#zhezhao,#img_box').hide();
}

//表单变成整数
function input_int(t){
	var num = $(t).val();
	var int = parseInt(num);
	if(isNaN(int)){
		$(t).val('')
	}else{
		$(t).val(int)
	}
	
	
}


/**
 * 滑动事件 接点名字  回电函数名字
 */
function TouchTo(nodeName,tFun,rFun,bFun,lFun,leg){
	var tFun = eval(tFun);
	var rFun = eval(rFun);
	var bFun = eval(bFun);
	var lFun = eval(lFun);
	if(leg == undefined){
		leg=5
	}
    var startX, startY, moveEndX, moveEndY, X, Y;
    $(nodeName).on("touchstart", function(e) {
       // e.preventDefault();
        startX = e.originalEvent.changedTouches[0].pageX,
        startY = e.originalEvent.changedTouches[0].pageY;
    });
    $(nodeName).on("touchmove", function(e) {
       // e.preventDefault();
        
    });
    $(nodeName).on('touchend',function(e){
    	moveEndX = e.originalEvent.changedTouches[0].pageX,
        moveEndY = e.originalEvent.changedTouches[0].pageY,
        X = moveEndX - startX,
        Y = moveEndY - startY;  
        if ( Math.abs(X) > Math.abs(Y) && X > leg ) {  //从左侧向右滑动
       	rFun()
       }else if(Math.abs(X) > Math.abs(Y) && X < -1*leg){
       	lFun()
       }else if(Math.abs(X) < Math.abs(Y) && Y > leg){
       	bFun()
       }else if(Math.abs(X) < Math.abs(Y) && Y < -1*leg){
       	tFun()
       }
       return true;
    })
}

function my_void(){
}
function prev_img(){
	//获取上一个接点下符合条件的图片接点
	var img_obj = $(cur_img_node).prev().prev().find('.img');
		img_src = img_obj.attr('src');
	if(!img_src) return false;
	img_obj.click();
}
function next_img(){
	var img_obj = $(cur_img_node).next().next().find('.img');
	img_src = img_obj.attr('src');
	if(!img_src) return false;
	img_obj.click();
}
