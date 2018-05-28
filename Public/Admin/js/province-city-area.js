/**
 * Created by zhaoweizhen on 16/8/18.
 */

function initSelect(){
    initRegion(1,'province');
}
/**
 * 省会变更
 */
function changeProvince(){
    var fid = $('#province').val();
    initRegion(fid ,'city');
}
/**
 * 城市变更
 */
function changeCity(){
    var fid = $('#city').val();
    initRegion(fid ,'zone');
}

function initRegion(fid,selectId,df){
    if(fid > 0) {
        var data = {
            'fid': fid
        };
        $.ajax({
            'type'   : 'post',
            'url'   : '/manage/index/region',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    region_html(ret.data,selectId,df);
                    if(!df){
                        if(selectId == 'province'){
                            initRegion(ret.data[0].region_id,'city');
                        }
                        if(selectId == 'city'){
                            initRegion(ret.data[0].region_id,'zone');
                        }
                    }
                }
            }
        });
    }
}

/**
 * 省会变更
 */
function changeWxappProvince(){
    var fid = $('#province').val();
    initWxappRegion(fid ,'city');
}
/**
 * 城市变更
 */
function changeWxappCity(){
    var fid = $('#city').val();
    initWxappRegion(fid ,'zone');
}

function initWxappRegion(fid,selectId,df){
    if(fid > 0) {
        var data = {
            'fid': fid
        };
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/index/region',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    region_html(ret.data,selectId,df);
                    if(!df){
                        if(selectId == 'province'){
                            initWxappRegion(ret.data[0].region_id,'city');
                        }
                        if(selectId == 'city'){
                            initWxappRegion(ret.data[0].region_id,'zone');
                        }
                    }
                }
            }
        });
    }
}

/**
 * 展示区域省市区
 * @param data
 * @param selectId
 */
function region_html(data,selectId,df){
    var option = '';
    for(var i=0 ; i < data.length ; i++){
        var temp  = data[i];
        var sel   = '';
        if(df && temp.region_id == df ){
            sel = 'selected';
        }
        option += '<option  value="'+temp.region_id+'" '+sel+'>'+temp.region_name+'</option>';
    }
    $('#'+selectId).html(option);
}

