var w=document.documentElement.clientWidth;
var a=$("html").css("font-size");
var ws=(w*4/75).toFixed(5)+"px";
$("html").css({"font-size":ws});

//window.onload=function(){
	function getSearchString(key) {
	var str = location.search;
	str = str.substring(1, str.length);
	var arr = str.split("&");
	var obj = new Object();
	for(var i = 0; i < arr.length; i++) {
		var tmp_arr = arr[i].split("=");
		obj[decodeURIComponent(tmp_arr[0])] = decodeURIComponent(tmp_arr[1]);
	}
	return obj[key];
}
//}
$.fn.toggle = function( fn, fn2 ) {
    var args = arguments,guid = fn.guid || $.guid++,i=0,
    toggle = function( event ) {
      var lastToggle = ( $._data( this, "lastToggle" + fn.guid ) || 0 ) % i;
      $._data( this, "lastToggle" + fn.guid, lastToggle + 1 );
      event.preventDefault();
      return args[ lastToggle ].apply( this, arguments ) || false;
    };
    toggle.guid = guid;
    while ( i < args.length ) {
      args[ i++ ].guid = guid;
    }
    return this.click( toggle );
  };

function formatDate(time) {
  var unixtime = time;
  var unixTimestamp = new Date(unixtime * 1000);
  var year = unixTimestamp.getFullYear();
  var month = unixTimestamp.getMonth() + 1;
  var date = unixTimestamp.getDate();
  var day = unixTimestamp.getDay();
  var hours = unixTimestamp.getHours();
  var minutes = unixTimestamp.getMinutes();
  var seconds = unixTimestamp.getSeconds();
  if (month < 10) {
    month = '0' + month;
  }
  if (date < 10) {
    date = '0' + date;
  }
  if (hours < 10) {
    hours = '0' + hours;
  }
  if (minutes < 10) {
    minutes = '0' + minutes;
  }
  if (seconds < 10) {
    seconds = '0' + seconds;
  }
  
     var toDay = year + '-' + month + '-' + date +' '+ hours + ':' + minutes+':'+seconds;
//var toDay = year + '-' + month + '-' + date + ' ';
  return toDay;
}