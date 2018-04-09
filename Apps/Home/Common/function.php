<?php
function get_lt_rounder_corner($radius) {
	$img     = imagecreatetruecolor($radius, $radius);  // 创建一个正方形的图像
	$bgcolor    = imagecolorallocate($img, 231, 231, 231);   // 图像的背景
	$fgcolor    = imagecolorallocate($img, 0, 0, 0);
	imagefill($img, 0, 0, $bgcolor);
	// $radius,$radius：以图像的右下角开始画弧
	// $radius*2, $radius*2：已宽度、高度画弧
	// 180, 270：指定了角度的起始和结束点
	// fgcolor：指定颜色
	imagefilledarc($img, $radius, $radius, $radius*2, $radius*2, 180, 270, $fgcolor, IMG_ARC_PIE);
	// 将弧角图片的颜色设置为透明
	imagecolortransparent($img, $fgcolor);
	// 变换角度
	// $img = imagerotate($img, 90, 0);
	// $img = imagerotate($img, 180, 0);
	// $img = imagerotate($img, 270, 0);
	// header('Content-Type: image/png');
	// imagepng($img);
	return $img;
}

function gd_radius( $filename ,$radius  = null){
	$size = getimagesize($filename);
	//array(7) { [0]=> int(640) [1]=> int(640) [2]=> int(2) [3]=> string(24) "width="640" height="640"" ["bits"]=> int(8) ["channels"]=> int(3) ["mime"]=> string(10) "image/jpeg" }
	 
	$image_width    = $size[0];
	$image_height   = $size[1];
	$resource = imagecreatefromjpeg($filename);
	//     $resource    = imagecreatetruecolor($image_width, $image_height);   // 创建一个正方形的图像
	//     $bgcolor     = imagecolorallocate($resource, 223, 223, 0);   // 图像的背景
	 
	//imagefill($resource, 0, 0, $bgcolor);
	 
	// 圆角处理
	if(is_null($radius)){
		$radius  = $image_width/2;
	}
	 
	// lt(左上角)
	$lt_corner  = get_lt_rounder_corner($radius);
	imagecopymerge($resource, $lt_corner, 0, 0, 0, 0, $radius, $radius, 100);
	// lb(左下角)
	$lb_corner  = imagerotate($lt_corner, 90, 0);
	imagecopymerge($resource, $lb_corner, 0, $image_height - $radius, 0, 0, $radius, $radius, 100);
	// rb(右上角)
	$rb_corner  = imagerotate($lt_corner, 180, 0);
	imagecopymerge($resource, $rb_corner, $image_width - $radius, $image_height - $radius, 0, 0, $radius, $radius, 100);
	// rt(右下角)
	$rt_corner  = imagerotate($lt_corner, 270, 0);
	imagecopymerge($resource, $rt_corner, $image_width - $radius, 0, 0, 0, $radius, $radius, 100);
	 
	header('Content-Type: image/png');
	imagepng($resource,$filename);
}