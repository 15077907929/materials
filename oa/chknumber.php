<?php
function getRandNumber($fMin,$fMax){
	srand((double)microtime()*1000000);
	$fLen='%0'.strlen($fMax).'d';
	return sprintf($fLen,rand($fMin,$fMax));
}

$str=getRandNumber(1000,9999);
setcookie('code',$str);

$width=50;	//验证码图片的宽度
$height=22;	//验证码图片的高度
header('Content-Type:image/png');
$im=imagecreate($width,$height);
//背景色
$back=imagecolorallocate($im,0xff,0xff,0xff);
//模糊点颜色
$pix=imagecolorallocate($im,187,230,247);
//字体色
$font=imagecolorallocate($im,41,163,238);
//绘模糊作用的点
mt_rand();
for($i=0;$i<1000;$i++){
	imagesetpixel($im,mt_rand(0,$width),mt_rand(0,$height),$pix);
}
imagestring($im,5,7,3,$str,$font);
imagerectangle($im,0,0,$width-1,$header-1,$font);
imagepng($im);
imagedestroy($im);
?>