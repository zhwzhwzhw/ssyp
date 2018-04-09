$(function(){

});

function getType(t,url){
		var mes = '--子分类（不选默认上级分类）--';
 		$(t).nextAll('select[name="'+$(t).attr('name')+'"]').remove();
		value = $(t).val();
		if(value != 0 && $(t).children('option[value="'+value+'"]').html() != mes){
			$.ajax({
				'url':url,//URL+'/getType'
				'dataType':'json',
				'type':'get',
				'data':{'fid':value},
				//async: false,//同步请求，默认情况下是异步（true）
				'beforeSend': function(){
					//$('#warning').text('正在处理，请稍等！');
				},
				
				'success':function(re){
					//查到
					if(re != ''){
						str = '<select onchange="getType(this,\''+url+'\')" name="'+$(t).attr('name')+'" value="0" ><option value="">'+mes+'</option>';
						$.each(re,function(i,v){
							str += '<option value="'+v.id+'">'+v.c_name+'</option>';
						});
						str += '</select>';
						$(t).after(str);
					}
					//$('#warning').text('ok！');
				}
				
			});
		} 
}
