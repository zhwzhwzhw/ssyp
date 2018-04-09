var jsApiList= ['getLocation','openLocation','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','onMenuShareQZone','chooseImage'];


var wxUserId = '';
var title = ''
var imgUrl = '';
var toUrl = 'http://www.fabao.hoild.com';//location.href.split('#')[0] 本网页 有跳转的不能用;

var shareDesc = '';
var shareType = '';
var shareDataUrl = '';


$.ajax({
	'url':URL+"/share", 
    data: {
        Type: "config",
        url: location.href.split('#')[0]
    },
    dataType: 'json',
    type: 'get',
    timeout: 5000,
    success: function(data) {
        wx.config({
            debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: data.appId, // 必填，公众号的唯一标识
            timestamp: data.timestamp, // 必填，生成签名的时间戳
            nonceStr: data.nonceStr.toString(), // 必填，生成签名的随机串
            signature: data.signature, // 必填，签名，见附录1
            jsApiList: jsApiList // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
        });
    }
})
wx.error(function(res){
	
	//alert('error')
    // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。

});
wx.ready(function(){
	if(toUrl.indexOf("?") > 0 ){
		toUrl = toUrl+'&wxUserId='+wxUserId
	}else{
		toUrl = toUrl+'?wxUserId='+wxUserId
	}
	wx.onMenuShareTimeline({  //朋友圈
	    title: title, // 分享标题
	    link: toUrl, // 分享链接
	    imgUrl: imgUrl, // 分享图标
	    success: function () { 
	    	sucMeg('分享到朋友圈')
	        // 用户确认分享后执行的回调函数
	    },
	    cancel: function () { 
	    	celMeg('分享到朋友圈')
	        // 用户取消分享后执行的回调函数
	    }
	});
	
	wx.onMenuShareAppMessage({ //分享给朋友
	    title: title, // 分享标题
	    desc: shareDesc, // 分享描述
	    link: toUrl, // 分享链接
	    imgUrl: imgUrl, // 分享图标
	    type: shareType, // 分享类型,music、video或link，不填默认为link
	    dataUrl: shareDataUrl, // 如果type是music或video，则要提供数据链接，默认为空
	    success: function () { 
	    	sucMeg('分享给朋友')
	        // 用户确认分享后执行的回调函数
	    },
	    cancel: function () { 
	    	celMeg('分享给朋友')
	        // 用户取消分享后执行的回调函数
	    }
	});
	$('#chooseImage').click(function(){
		wx.chooseImage({  
		    count: 1, // 默认9 最多选择的个数
		    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
		    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
		    success: function (res) {
		        var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
		       
		    }
		});
	})
    // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
});


function sucMeg(msg){
	//alert('恭喜您，分享成功')
}
function celMeg(msg){}