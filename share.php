<?php
if(!is_weixin())
{
    echo '请用微信打开该链接';
    exit;
}
$app_id = 'wx4dcad2892f3ea01d';
$app_secret = '85258812fa21f0228aa74277cea89b01';
$base_url = 'http://h5.hiwechats.com';
$redirect_uri = urlencode($base_url.'/ltNewYear/share.php');
if(isset($_GET['code']))
{
    $code = $_GET['code'];
    $token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$app_id.'&secret='.$app_secret.'&code='.$code.'&grant_type=authorization_code';
    $result_str = file_get_contents($token_url);
    $result = json_decode($result_str, true);
    if($result['access_token'])
    {
        $access_token = $result['access_token'];
        $open_id = $result['openid'];
        $info_url = 'chttps://api.weixin.qq.om/sns/userinfo?access_token='.$access_token.'&openid='.$open_id.'&lang=zh_CN';
        $user_info = file_get_contents($info_url);
        if($user_info)
        {
            $info = json_decode($user_info, true);
            if($info)
            {
            	if ($info['headimgurl']){
	                $img_name = uniqid().'.'.getImgType($info['headimgurl']);
	                $big_path = __DIR__.'/img/'.$img_name;
	                $small_path = __DIR__.'/thumb/'.$img_name;
	                file_put_contents($big_path, file_get_contents($info['headimgurl']));
	                if(thumb($big_path, $small_path))
	                    $icon_url = 'http://h5.hiwechats.com/ltNewYear/thumb/'.$img_name;
	                else
	                    $icon_url = 'http://h5.hiwechats.com/ltNewYear/img/'.$img_name;
            	}else{
            		$icon_url = 'http://h5.hiwechats.com/ltNewYear/img/bigbear.png';
            	}
                $param = json_decode(file_get_contents(__DIR__.'/thumb/share.txt'), true);
                $param['name'] = $info['nickname'];
                $param['icon'] = $icon_url;
                $param['open_id'] = $open_id;
                $next_url = $base_url.'/ltNewYear/wechat.php?'.http_build_query($param);
                header('Location:'.$next_url);
            }
        }
    }
    exit;
}
else
{
    file_put_contents(__DIR__.'/thumb/share.txt', json_encode($_GET));
    $code_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$app_id.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect';
    header('Location:'.$code_url);
    exit;
}

function is_weixin()
{ 
    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false )
        return true;
    else
        return false;
}

function getImgType($headimgurl)
{
	$info = $head_img_info = getimagesize($headimgurl);
	list($f_type, $image_type) = explode('/', $info['mime'], 2);
	return $image_type;
}

function thumb($src_img, $dst_img, $width = 75, $height = 75, $cut = 0, $proportion = 0)
{
    if(!is_file($src_img))
    {
        return false;
    }
    $ot = fileext($dst_img);
    $otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
    $srcinfo = getimagesize($src_img);
    $src_w = $srcinfo[0];
    $src_h = $srcinfo[1];
    $type  = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
    $createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);
 
    $dst_h = $height;
    $dst_w = $width;
    $x = $y = 0;
 
    /**
     * 缩略图不超过源图尺寸（前提是宽或高只有一个）
     */
    if(($width> $src_w && $height> $src_h) || ($height> $src_h && $width == 0) || ($width> $src_w && $height == 0))
    {
        $proportion = 1;
    }
    if($width> $src_w)
    {
        $dst_w = $width = $src_w;
    }
    if($height> $src_h)
    {
        $dst_h = $height = $src_h;
    }
 
    if(!$width && !$height && !$proportion)
    {
        return false;
    }
    if(!$proportion)
    {
        if($cut == 0)
        {
            if($dst_w && $dst_h)
            {
                if($dst_w/$src_w> $dst_h/$src_h)
                {
                    $dst_w = $src_w * ($dst_h / $src_h);
                    $x = 0 - ($dst_w - $width) / 2;
                }
                else
                {
                    $dst_h = $src_h * ($dst_w / $src_w);
                    $y = 0 - ($dst_h - $height) / 2;
                }
            }
            else if($dst_w xor $dst_h)
            {
                if($dst_w && !$dst_h)  //有宽无高
                {
                    $propor = $dst_w / $src_w;
                    $height = $dst_h  = $src_h * $propor;
                }
                else if(!$dst_w && $dst_h)  //有高无宽
                {
                    $propor = $dst_h / $src_h;
                    $width  = $dst_w = $src_w * $propor;
                }
            }
        }
        else
        {
            if(!$dst_h)  //裁剪时无高
            {
                $height = $dst_h = $dst_w;
            }
            if(!$dst_w)  //裁剪时无宽
            {
                $width = $dst_w = $dst_h;
            }
            $propor = min(max($dst_w / $src_w, $dst_h / $src_h), 1);
            $dst_w = (int)round($src_w * $propor);
            $dst_h = (int)round($src_h * $propor);
            $x = ($width - $dst_w) / 2;
            $y = ($height - $dst_h) / 2;
        }
    }
    else
    {
        $proportion = min($proportion, 1);
        $height = $dst_h = $src_h * $proportion;
        $width  = $dst_w = $src_w * $proportion;
    }
 
    $src = $createfun($src_img);
    $dst = imagecreatetruecolor($width ? $width : $dst_w, $height ? $height : $dst_h);
    $white = imagecolorallocate($dst, 255, 255, 255);
    imagefill($dst, 0, 0, $white);
 
    if(function_exists('imagecopyresampled'))
        imagecopyresampled($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    else
        imagecopyresized($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);    
    $otfunc($dst, $dst_img);
    imagedestroy($dst);
    imagedestroy($src);
    return true;
}

function fileext($file)
{
    return pathinfo($file, PATHINFO_EXTENSION);
}
?>