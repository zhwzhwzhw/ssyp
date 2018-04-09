function form_submit(t){
//	$(t).find('input').each(function(){
//		$(this).
//	})
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

var countdown=120; 
var settime_int;
var is_click = true;
var but_val ;
function settime(val) { 
	if(is_click){
		is_click = false;
		but_val = val.value;
		dx_send(val)
	}
	settime_int = setTimeout(function() { 
		settime(val) 
	},1000) 
	if (countdown == 0) { 
		is_click = true
		val.removeAttribute("disabled");    
		val.value=but_val; 
		countdown = 120; 
		clearTimeout(settime_int);
	} else { 
		val.setAttribute("disabled", true); 
		val.value="重新发送(" + countdown + ")"; 
		countdown--; 
	}
} 
function dx_send(val){}

