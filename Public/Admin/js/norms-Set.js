var input_ths;
function normsSet(obj,e) {
	input_ths = obj
    var ths = obj;
    //var menu_list = '<li class="citySel">尺码</li><li>颜色</li><li>区县</li>';
    //var cate_wrap = '<div id="_citys0" class="_citys1"></div><div style="display:none" id="_citys1" class="_citys1"></div><div style="display:none" id="_citys2" class="_citys1"></div>';
    var menu_list = '<ul id="_citysheng" class="_citys0">';
    var cate_wrap = '';
    for ( var i in norms){
    	var s=''  //菜单当前状态
    	var d = 'style="display:none"';
    	if(i == 0){s = 'class="citySel"';d=''}
    	if(norms[i].fname){
    		cate_wrap += '<div  id="_citys'+i+'" '+d+' class="_citys1"></div>';
        	menu_list += '<li '+s+'>'+norms[i].fname+'</li>';
    	}
    }
	menu_list += '</ul>';
    var dal = '<div class="_citys"><span title="关闭" id="cColse" >×</span>'+menu_list+cate_wrap+'</div>';
    //alert(dal)
    Iput.show({ id: ths, event: e, content: dal,width:"470"});
    $("#cColse").click(function () {
        Iput.colse();
    });
    var tb_province = [];
    var b = province;
    for (var i = 0, len = b.length; i < len; i++) {
        tb_province.push('<a onclick="unit_click(this,1)" data-level="0" data-id="' + b[i]['id'] + '" data-name="' + b[i]['name'] + '">' + b[i]['name'] + '</a>');
    }
    $("#_citys0").append(tb_province.join(""));
    
    $("#_citysheng li").click(function () {
        $("#_citysheng li").removeClass("citySel");
        $(this).addClass("citySel");
        var s = $("#_citysheng li").index(this);
        $("._citys1").hide();
        $("._citys1:eq(" + s + ")").show();
    });
}
function unit_click(t,sts){
	var g = getCity($(t));
    $("#_citys1 a").remove();
    $("#_citys1").append(g);
    $("._citys1").hide();
    $("._citys1:eq(1)").show();
    $("#_citys0 a,#_citys1 a,#_citys2 a").removeClass("AreaS");
    $(t).addClass("AreaS");
    if($(t).parents('._citys1').next().length<=0){
    	$("#cColse").click()
    }
    if(sts){
    	$(input_ths).val('')
    }
    var sel = $(t).html()
    if ($(input_ths).val() == '') {
    	$(input_ths).val(sel)
    }
    else {
        $(input_ths).val($(input_ths).val() + ',' + sel)
    }
}
function getCity(obj) {
	var f = area1;
    var g = '';
    for (var j = 0, clen = f.length; j < clen; j++) {
        g += '<a onclick="unit_click(this)" data-name="' + f[j]['name'] + '" title="' + f[j]['name'] + '">' + f[j]['name'] + '</a>'
    }
    $("#_citysheng li").removeClass("citySel");
    $("#_citysheng li:eq(1)").addClass("citySel");
    
    return g;
}
