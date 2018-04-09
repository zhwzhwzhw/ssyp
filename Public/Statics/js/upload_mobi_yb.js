//idname  按钮id名字 响应地址 name $_FILES 的表单名字
var wrapObj = document.createElement('div');
	wrapObj.style.display='none';
var frameObj = document.createElement('iframe');
	frameObj.name = 'upload';
	wrapObj.appendChild(frameObj);
var h_upload = function (idname,action,callback_funname){
	this.config = {
		'idname':idname,
		'name' : 'file',
		'action' : action
	};
	if(!callback_funname){
		callback_funname = 'default_callback'
	}
	this.formObj = document.createElement('form');
	this.formObj.method = 'post';
	this.formObj.target = 'upload';
	this.formObj.id = 'form_'+idname;
	this.formObj.action = this.config.action;
	this.formObj.enctype='multipart/form-data';
	this.inputObj = document.createElement('input');
	this.inputObj.type='file';
	this.inputObj.name = this.config.name;
	
	this.inputObj_funname = document.createElement('input');
	this.inputObj_funname.type='hidden';
	this.inputObj_funname.name = 'fun_name';
	this.inputObj_funname.value = callback_funname;
	formObj.appendChild(inputObj_funname);
	formObj.appendChild(inputObj);
	wrapObj.appendChild(formObj);
	document.body.appendChild(wrapObj);
	$('#'+config.idname).click(function(){
		$('#form_'+idname).children('[type="file"]').click();
	})
	$(inputObj).change(function(){
		$('#form_'+idname).submit()
	});	
	return this;
}

function iframe_callback(msg,funname){
	eval(funname+'("'+msg+'")');//调用函数，传入参数
}

//id是show_img里面追加
function callback_df(imgdata){   //为add1 定制
	var show_img_obj = document.getElementById('show_img');
	var div = '<div id="aaaaaa" class="image_upload" style="position:relative;"><div onclick="del_img(this,\''+imgdata+'\',8)" class="close_16"></div><img onclick="" class="img" layer-src="'+ROOT+'/Uploads/'+imgdata+'" src="'+ROOT+'/Uploads/'+imgdata+'" alt=""></div>';
	div += '<input type="hidden" name="image[]" value="'+imgdata+'"/>';
	$(show_img_obj).append(div);
	if($(show_img_obj).children('.image_upload').length > 8){
		$('#upload_button').hide();
	}
	
}	


function del_img(t,data){
	$.ajax({
		'url':MODULE+'/Upload/delImg',
		'type':'post',
		'data':{'imgname':data},
		'success':function(re){
			$(t).parents('td').find('.image_upload').show()
			$(t).parent('.image_upload').remove();
		}
	})
}

