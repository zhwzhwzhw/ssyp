<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="/ssyp/Public/Statics/css/reset.css" type="text/css" rel="stylesheet"/>
		<link href="/ssyp/Public/Statics/css/common.css" type="text/css" rel="stylesheet"/>
		<!-- bootstrap 3.0.2 -->
        <link href="/ssyp/Public/Admin/css//bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="/ssyp/Public/Admin/css//font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="/ssyp/Public/Admin/css//ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="/ssyp/Public/Admin/css//AdminLTE.css" rel="stylesheet" type="text/css" />
        <title><?php echo ($title); ?></title>
		<script src="/ssyp/Public/Admin/js/jquery.min.js"></script>
        <script src="/ssyp/Public/Admin/js/jquery.min.js"></script>
		<script src="/ssyp/Public/Statics/js/Popt.js"></script>
		<script src="/ssyp/Public/Statics/js/cityJson.js"></script>
		<script src="/ssyp/Public/Statics/js/citySet.js"></script>
		<link href="/ssyp/Public/Statics/css/city.css" type="text/css" rel="stylesheet"/>

		
		<script src="/ssyp/Public/Statics/laydate/laydate.js"></script>	
		<script src="/ssyp/Public/Statics/layer/layer.js"></script>
		<script src="/ssyp/Public/Statics/js/upload_mobi_yb.js"></script>
		<script src="/ssyp/Public/Statics/js/request.js"></script>
		<script>
		$(function(){
			$('.<?php echo (CONTROLLER_NAME); ?>,.<?php echo (CONTROLLER_NAME); ?>-<?php echo (ACTION_NAME); ?>').addClass('active');
		})
		</script>
		
<script>
$(function(){
	$('.admin-add,.admin').addClass('active');
})
</script>
<meta charset="UTF-8">
<style>
#detail th{width:40%;}
.cate_fid select{width:20% !important;}
#detail th{width:20%;}
.images_unit{float:left;display:table-cell !important;width:200px;height:150px;position:relative;margin:3px;background:#fff;box-shadow: 0px 0px 5px #888888; vertical-align:middle;text-align:center;}
.images_unit img,.images_unit .images_but{max-width:200px;max-height:150px;vertical-align:middle;}
.images_unit>.close{background:#fff url(/ssyp/Public/Admin/images/close_16.png) no-repeat center center;width:20px;height:20px;position:absolute;top:0;right:0;border-radius:50%;}
.images_unit .num_wrap{background:#fff;border-top:1px solid #eee;position:absolute;bottom:0;width:100%;height:25px;line-height:25px;font-size:12px;}
.images_unit .num_wrap input{height:100%;width:50px};
</style>

    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="/ssyp/index.php/Admin/Index/index" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <?php if($user_base["role_id"] == -1): ?>总管理员
                <?php elseif(($user_base["role_id"] == 0) OR ($role["role_name"] == '')): ?>未分配角色
                <?php else: echo ($role["role_name"]); endif; ?>
                
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <a style="display:block;color:#fff;font-size:16px;margin:10px" href="/ssyp/index.php/Admin/Common/logout">【退出】</a>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">                
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                        	<?php if($user_base["headimgurl"] != ''): ?><img src="<?php echo ($user_base["headimgurl"]); ?>" class="img-circle" alt="" />
                        	<?php else: ?>
                            	<img src="/ssyp/Public/Admin/images//headimgurl.png" class="img-circle" alt="" /><?php endif; ?>
                        </div>
                        <div class="pull-left info">
                            <p><?php echo ($time_msg); ?>好, <?php echo ($user_base["realname"]); ?></p>
                            <a href="/ssyp/index.php/Admin/Admin/selfMsg"><i class="fa fa-circle text-success"></i> 个人信息修改</a>
                        </div>
                    </div>
                   
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    
                    <ul class="sidebar-menu">
                    	<?php if(is_array($menu)): foreach($menu as $key=>$v): if($v["class_name"] == 'treeview'): ?><li class="<?php echo ($v["class_name"]); ?> <?php echo ($v["controller"]); ?>">
		                            <a href="#">
		                                <span><?php echo ($v["name"]); ?></span>
		                                <i class="fa fa-angle-left pull-right"></i>
		                            </a>
		                            <ul class="treeview-menu">
		                            	<?php if(is_array($menu)): foreach($menu as $key=>$sv): if(($v["id"]) == $sv["fid"]): ?><li class="<?php echo ($sv["controller"]); ?>-<?php echo ($sv["action"]); ?>"><a href="/ssyp/index.php/Admin/<?php echo ($sv["controller"]); ?>/<?php echo ($sv["action"]); ?>"><i class="fa fa-angle-double-right"></i> <?php echo ($sv["name"]); ?></a></li><?php endif; endforeach; endif; ?>
		                            </ul>
		                        </li>
		                    <?php elseif($v["class_name"] == '1'): ?>
		                    	<li class="<?php echo ($v["controller"]); ?>">
		                            <a href="/ssyp/index.php/Admin/<?php echo ($v["controller"]); ?>/<?php echo ($v["action"]); ?>">
		                                 <span><?php echo ($v["name"]); ?></span> <small class="badge pull-right bg-green"></small>
		                            </a>
		                        </li><?php endif; endforeach; endif; ?>
                    	
                    	
	                    <!-- <li class="user">
                                                    <a href="/ssyp/index.php/Admin/User/index">
                                                         <span>用户管理</span> <small class="badge pull-right bg-green"></small>
                                                    </a>
                                                </li> -->
                       <!--  <li class="shop">
                            <a href="/ssyp/index.php/Admin/Shop/index">
                                 <span>微店营销</span> <small class="badge pull-right bg-green">new</small>
                            </a>
                        </li> -->
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Right side column. Contains the navbar and content of the page -->
		    <aside class="right-side">  
				
<section class="content-header">
	<h1>
		管理员
		<!--<small><?php echo ($title); ?></small>-->
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"> </a></li>
		<li class="active"></li>
	</ol>

</section>

                <section class="content">
				
				

<form onsubmit="return form_submit(this)" method="post" action="">
<table id="detail">
	<tr>
		<th colspan="2" class="det_title" >用户基本信息
		<input type="hidden" name="id" value="<?php echo ($data["id"]); ?>" />
		</th>
	</tr>
	<tr>
		<th>店铺名称</th>
		<td><input type="text" name="seller_name" placeholder="输入店铺名称" value="<?php echo ($data["seller_name"]); ?>"></td>
	</tr>
	<tr>
		<th>店铺描述</th>
		<td><textarea type="text" name="seller_des" placeholder="店铺描述" ><?php echo ($data["seller_des"]); ?></textarea></td>
	</tr>
	<tr>
		<th>店铺logo</th>
		<td>
			<input type="hidden" name="seller_logo" value="<?php echo ($data["seller_logo"]); ?>" />
			<img id="seller_logo_show" src="/ssyp/Uploads/<?php echo ($data["seller_logo"]); ?>" <?php if($data["seller_logo"] == ''): ?>style="display:none"<?php endif; ?> width="100px" alt="">
			<input id="seller_logo" type="button" value="上传/更换 图片" />
		</td>
	</tr>
	<tr>
		<th>联系电话</th>
		<td ><input type="text" name="seller_phone" placeholder="店铺联系电话" value="<?php echo ($data["seller_phone"]); ?>"></td>
	</tr>
	<tr>
		<th>店铺地址</th>
		<td ><input type="text" name="seller_address" placeholder="店铺地址" value="<?php echo ($data["seller_address"]); ?>"></td>
	</tr>
	<tr>
		<th>店铺坐标&nbsp;&nbsp;<a href="http://lbs.qq.com/tool/getpoint/" target="_blank" >获取坐标方法</a></th>
		<td ><input type="text" name="seller_position" placeholder="店铺坐标" value="<?php echo ($data["seller_position"]); ?>"></td>
	</tr>
  <!--  <tr>
		<th class="control-label"><font color="red">*</font>详细地址：</th>

		<td class="control-group" style="float: left;width: 63%;margin: 0;">
			<input type="text" class="form-control" id="address" name="address" style="width: 50%;display: inline-block;margin-left: 18px;margin-top: 20px" placeholder="请填写具体地址" value="">
			<input type="text" class="form-control" id="community" style="width: 43%;display: inline-block;margin-left: 5px;margin-top: 20px" name="community" placeholder="所在小区" required="required" value="">
		</td>

		<td class="control-group col-sm-2 text-left" style="margin-left: 0;margin-top: 54px">
			<input type="hidden" id="lng" name="lng" placeholder="请在地图中标注分店位置" value="">
			<input type="hidden" id="lat" name="lat" placeholder="请在地图中标注分店位置" value="">
			<label class="btn btn-default btn-sm btn-map-search"> 搜索地图 </label>
		</td>


	</tr>
	<tr id="container">
		&lt;!&ndash;<div class="form-group">
			<div class="control-group col-sm-9">
				<div id="container"></div>
			</div>
		</div>
		<div class="space-6"></div>&ndash;&gt;
	</tr>-->
	<tr>
		<th>允许分类：不选表示所有</th>
		<td>
			<?php if(is_array($category)): foreach($category as $key=>$v): ?><span style="display:inline-block;padding:3px 10px;">
					<input <?php if(in_array($v['id'],$cat)): ?>checked<?php endif; ?> type="checkbox" name="cat[]" value="<?php echo ($v["id"]); ?>">
					 <?php echo ($v["c_name"]); ?>
				 </span><?php endforeach; endif; ?>
		</td>
	</tr>

	<tr>
		<th colspan="2" class="th_br">

		</th>
	</tr>

	<tr>
		<th colspan="2" class="det_footer"><input type="submit" value="提&nbsp;&nbsp;&nbsp;交"></th>
	</tr>
</table>
</form>




                </section>
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->


        <!-- jQuery UI 1.10.3 -->
		<script src="/ssyp/Public/validate/jquery-ui-1.10.3.custom.js"></script>
	    <script src="/ssyp/Public/Admin/js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="/ssyp/Public/Admin/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
       <!--  <script src="/ssyp/Public/Admin/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script> -->
        <!-- Bootstrap WYSIHTML5 -->
        <script src="/ssyp/Public/Admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="/ssyp/Public/Admin/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="/ssyp/Public/Admin/js/AdminLTE/app.js" type="text/javascript"></script>
        <script src="/ssyp/Public/Admin/js/plugins/layer/layer.js"></script>
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
       <!-- <script src="/ssyp/Public/Admin/js/AdminLTE/dashboard.js" type="text/javascript"></script> -->
	
        
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>
<!--<script type="text/javascript" src="/public/admin/js/province-city-area.js"></script>-->
<!--	<script type="text/javascript" src="/public/common/js/province-city-area.js"></script>-->
<script>
$(function(){
	h_upload('seller_logo','/ssyp/index.php/Admin/Upload/Upload','seller_logo');
})
var oldImgName = '<?php echo ($data["seller_logo"]); ?>';
function seller_logo(imgdata){
	if(oldImgName != ''){
		$.ajax({
			'url':'/ssyp/index.php/Admin/Upload/delImg',
			'type':'post',
			'data':{'imgname':oldImgName}
		});
	}
	oldImgName = imgdata;
	$('#seller_logo_show').show().attr('src','/ssyp/Uploads/'+imgdata)
	$('input[name="seller_logo"]').val(imgdata);
}
$(function(){
    //高德地图引入
    var marker, geocoder,map = new AMap.Map('container',{
        zoom            : 10,
        keyboardEnable  : true,
        resizeEnable    : true,
        topWhenClick    : true
    });
    //添加地图控件
    AMap.plugin(['AMap.ToolBar'],function(){
        var toolBar = new AMap.ToolBar();
        map.addControl(toolBar);
    });

    //地图添加点击事件
    map.on('click', function(e) {
        $('#lng').val(e.lnglat.getLng());
        $('#lat').val(e.lnglat.getLat());
        //添加地图服务
        AMap.service('AMap.Geocoder',function(){
            //实例化Geocoder
            geocoder = new AMap.Geocoder({
                city: "010"//城市，默认：“全国”
            });
            //TODO: 使用geocoder 对象完成相关功能
            //逆地理编码
            var lnglatXY=[e.lnglat.getLng(), e.lnglat.getLat()];//地图上所标点的坐标
            geocoder.getAddress(lnglatXY, function(status, result) {
                console.log(result);
                if (status === 'complete' && result.info === 'OK') {
                    addMarker(e.lnglat.getLng(), e.lnglat.getLat(),result.regeocode.formattedAddress);

                    //详细地址处理
                    var pcz  = {
                        'province'  : result.regeocode.addressComponent.province,
                        'city'      : result.regeocode.addressComponent.city,
                        'zone'      : result.regeocode.addressComponent.district
                    };

                    var province    = result.regeocode.addressComponent.province;
                    var city       = result.regeocode.addressComponent.city;
                    var zone        = result.regeocode.addressComponent.district;
                    var township    =  result.regeocode.addressComponent.township;
                    var street      =  result.regeocode.addressComponent.street;
                    var streetNumber=  result.regeocode.addressComponent.streetNumber;
                    var neighborhood=  result.regeocode.addressComponent.neighborhood;
                    town = zone;
                    var adds = province + city + zone + township + street + streetNumber + neighborhood;
                    $('#zone').val(zone);
                    $('#address').val(township+street+streetNumber);
                }else{
                    //获取地址失败
                }
            });
        });
    });
    //搜索地图位置
    $('.btn-map-search').on('click',function(){
        var addr = $('#address').val();
        var zone = $('#zone').val();
        var community = $('#community').val();
        var detail  = '江苏省连云港市'+zone+''+addr+''+community;
        if(detail){
            var address = detail;
            console.log(address);
            AMap.service('AMap.Geocoder',function(){ //回调函数
                //实例化Geocoder
                geocoder = new AMap.Geocoder({
                    'city'   : '', //城市，默认：“全国”
                    'radius' : 1000   //范围，默认：500
                });
                //TODO: 使用geocoder 对象完成相关功能
                //地理编码,返回地理编码结果
                geocoder.getLocation(address, function(status, result) {
                    console.log(result);
                    if (status === 'complete' && result.info === 'OK') {
                        var loc_lng_lat = result.geocodes[0].location;
                        $('#lng').val(loc_lng_lat.getLng());
                        $('#lat').val(loc_lng_lat.getLat());
                        addMarker(loc_lng_lat.getLng(),loc_lng_lat.getLat(),result.geocodes[0].formattedAddress);
                    }else{
                        layer.msg('您输入的地址无法找到，请确认后再次输入');
                    }
                });
            });

        }else{
            layer.msg('请填写详细地址');
        }
    });
    /**
     * 添加一个标签和一个结构体
     * @param lng
     * @param lat
     * @param address
     */
    function addMarker(lng,lat,address) {
        if (marker) {
            marker.setMap();
        }
        marker = new AMap.Marker({
            icon    : "https://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
            position: [lng,lat]
        });
        marker.setMap(map);

        infoWindow = new AMap.InfoWindow({
            offset  : new AMap.Pixel(0,-30),
            content : '您选中的位置：'+address
        });
        infoWindow.open(map, [lng,lat]);
    }

});

function initCityRegion(fid,selectId,df){
    if(fid > 0) {
        var data = {
            'fid': fid
        };
        $.ajax({
            'type'   : 'post',
            'url'   : '/shop/house/region',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    region_html(ret.data,selectId,df);
                    if(!df){
                        if(selectId == 'city'){
                            initWxappRegion(ret.data[0].region_id,'zone');
                        }
                    }
                }
            }
        });
    }
}

function initWxappRegion(fid,selectId,df){
    if(fid > 0) {
        var data = {
            'fid': fid
        };
        $.ajax({
            'type'   : 'post',
            'url'   : '/shop/index/region',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    region_html(ret.data,selectId,df);
                }
            }
        });
    }
}
</script>

    </body>
</html>