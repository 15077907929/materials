<?php
function get_updir_name($t){
    switch($t){
        case '1':
            $name =  date('Ymd');
            break;
        case '2':
            $name = date('Ym');
            break;
        default:
            $name = date('Ymd');
    }
    return $name;
}

function showInfo($message,$flag = true,$link = '',$target = '_self'){
    $titlecolor = $flag?'infotitle2':'infotitle3';
    $otherlink = $link == '' ?"javascript:history.back();":$link;
    
    print <<<EOF
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>操作提示</title>
<link href="Public/css/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="append_parent"></div>
<div class="container" id="cpcontainer"><h3>操作提示</h3><div class="infobox"><h4 class="$titlecolor">$message</h4><h5><a class="return_btn" href="$otherlink" target="$target">返回</a></h5></div>
</div>
</body>
</html>
EOF;
    exit();
}

function addwater($realpath){
	if(C('open_watermark')==true){
		include_once(LIB_PATH.'Org/image.class.php');
		$imgobj = new Image();
		$imgobj->load($realpath);
		if($imgobj->image_type != IMAGETYPE_GIF){
			$imgobj->setQuality(95);
			$imgobj->waterMark(C('watermark_path'),C('watermark_pos'));
			$imgobj->save($realpath);
		}
	}
}

function generatepic($dir,$key,$ext){
	ignore_user_abort(true);

	$realpath = APP_PATH.'Uploads/'.mkImgLink($dir,$key,$ext,'orig');
	include_once(LIB_PATH.'Org/image.class.php');
	$imgobj = new Image();

	$size = 'big';
	$width = '900';
	$height = '900';
	$bigpath = APP_PATH.'Uploads/'.mkImgLink($dir,$key,$ext,$size);
	$imgobj->load($realpath);
	$imgobj->setQuality(95);
	
	$orgwidth = $imgobj->getWidth();
	$orgheight = $imgobj->getHeight();

	if($orgwidth <= $width && $orgheight <= $height){
		copy($realpath,$bigpath);
	}else{
		$imgobj->resizeScale($width,$height );
		$imgobj->save($bigpath);
	}
	@chmod($bigpath,0755);
	
	$size = 'medium';
	$width = '550';
	$height = '550';
	$newpath = APP_PATH.'Uploads/'.mkImgLink($dir,$key,$ext,$size);
	if($orgwidth <= $width && $orgheight <= $height){
		copy($realpath,$newpath);
	}else{
		$imgobj->load($bigpath);
		$imgobj->resizeScale($width,$height);
		$imgobj->save($newpath);
	}
	@chmod($newpath,0755);

	$size = 'small';
	$width = '240';
	$height = '240';
	$newpath = APP_PATH.'Uploads/'.mkImgLink($dir,$key,$ext,$size);
	if($orgwidth <= $width && $orgheight <= $height){
		copy($realpath,$newpath);
	}else{
		$imgobj->load($bigpath);
		$imgobj->resizeScale($width,$height );
		$imgobj->save($newpath);
	}
	@chmod($newpath,0755);
	
	$size = 'thumb';
	$width = '110';
	$height = '150';
	$newpath = APP_PATH.'Uploads/'.mkImgLink($dir,$key,$ext,$size);
	if($orgwidth <= $width && $orgheight <= $height){
		copy($realpath,$newpath);
	}else{
		$imgobj->load($bigpath);
		$imgobj->resizeScale($width,$height );
		$imgobj->save($newpath);
	}
	@chmod($newpath,0755);
	
	$size = 'square';
	$width = '75';
	$newpath = APP_PATH.'Uploads/'.mkImgLink($dir,$key,$ext,$size);
	if($orgwidth <= $width && $orgheight <= $width){
		copy($realpath,$newpath);
	}else{
		$imgobj->load($bigpath);
		$imgobj->square($width);
		$imgobj->save($newpath);
	}
	@chmod($newpath,0755);
}

function save_setting($st){
	// $basedir = defined('REWRITE_BASE')?REWRITE_BASE:get_basepath();
	// $htaccess_content = '<ifmodule mod_rewrite.c>
// RewriteEngine On
// RewriteBase '.$basedir.'data
// Options +FollowSymLinks'."\n";
	
	// if($st['access_ctl'] == 'true'){
		// if('' != trim($st['access_domain'])){
			// $htaccess_content .= '#access'."\n";
			// $htaccess_content .= 'RewriteCond %{HTTP_REFERER} !^$ [NC]'."\n";
			// $access_arr = explode("\n",$st['access_domain']);
			// foreach($access_arr as $v){
				// if('' != trim($v)){
					// $htaccess_content .= 'RewriteCond %{HTTP_REFERER} !^(http|https)://'.trim($v).' [NC]'."\n";
				// }
			// }
			// $htaccess_content .= 'RewriteRule .*\.(jpg|jpeg|gif|png)$ ../img/noaccess.jpg [NC,L]'."\n";
		// }
	// }
	
	// if($st['demand_resize'] == 'true'){
		// $htaccess_content .= '#auto resize'."\n";
		// $htaccess_content .= 'RewriteCond %{REQUEST_FILENAME} !-f
// RewriteRule .*/(.*)_(.*)\.(jpg|jpeg|gif|png)$ ../index.php?ctl=photo&act=resize&size=$2&key=$1 [NC,L]'."\n";
	// }
	
	// $htaccess_content .= '</ifmodule>';
	
	// if($st['demand_resize'] == 'true' || $st['access_ctl'] == 'true'){
		// @file_put_contents(DATADIR.'.htaccess',$htaccess_content);
		// @chmod(DATADIR.'.htaccess',0755);
	// }else{
		// @unlink(DATADIR.'.htaccess');
	// }
	
	$st_content = '<?php return array('."\n";
	$st_content .= '\'site_title\' => \''.html_replace($st['site_title']).'\','."\n";
	$st_content .= '\'site_keyword\' => \''.html_replace($st['site_keyword']).'\','."\n";
	$st_content .= '\'site_description\'=> \''.html_replace($st['site_description']).'\','."\n";
	$st_content .= '\'url\' => \''.$st['url'].'\','."\n";
	$st_content .= '\'open_pre_resize\' => '.$st['open_pre_resize'].','."\n";
	$st_content .= '\'resize_img_width\' => \''.$st['resize_img_width'].'\','."\n";
	$st_content .= '\'resize_img_height\' => \''.$st['resize_img_height'].'\','."\n";
	$st_content .= '\'resize_quality\' => \''.$st['resize_quality'].'\','."\n";
	$st_content .= '\'demand_resize\' => '.$st['demand_resize'].','."\n";
	$st_content .= '\'imgdir_type\' => \''.$st['imgdir_type'].'\','."\n";
	$st_content .= '\'size_allow\' => \''.$st['size_allow'].'\','."\n";
	$st_content .= '\'pageset\' => \''.$st['pageset'].'\','."\n";
	$st_content .= '\'open_photo\' => '.$st['open_photo'].','."\n";
	$st_content .= '\'gallery_limit\' => \''.$st['gallery_limit'].'\','."\n";
	$st_content .= '\'access_ctl\' => '.$st['access_ctl'].','."\n";
	$st_content .= '\'access_domain\' => \''.html_replace($st['access_domain']).'\','."\n";
	$st_content .= '\'open_watermark\' => '.$st['open_watermark'].','."\n";
	$st_content .= '\'watermark_path\' => \''.html_replace($st['watermark_path']).'\','."\n";
	$st_content .= '\'watermark_pos\' => '.$st['watermark_pos'].','."\n";
	$st_content .= ');'."\n";
	
	return @file_put_contents(APP_PATH.'/Common/Conf/config_album.php',$st_content);
}

function delpicfile($dir,$key,$ext){
	$list = array('small','square','medium','big','thumb','orig');
	foreach($list as $v){
		@unlink(APP_PATH.'Uploads/'.mkImgLink($dir,$key,$ext,$v));
	}
}

function where_is_tmp(){
    $uploadtmp=ini_get('upload_tmp_dir');
    $envtmp=(getenv('TMP'))?getenv('TMP'):getenv('TEMP');
    if(is_dir($uploadtmp) && is_writable($uploadtmp))return $uploadtmp;
    if(is_dir($envtmp) && is_writable($envtmp))return $envtmp;
    if(is_dir('/tmp') && is_writable('/tmp'))return '/tmp';
    if(is_dir('/usr/tmp') && is_writable('/usr/tmp'))return '/usr/tmp';
    if(is_dir('/var/tmp') && is_writable('/var/tmp'))return '/var/tmp';
    return ".";
}