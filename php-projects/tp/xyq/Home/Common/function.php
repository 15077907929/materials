<?php
function CleanHtmlTags($content){
	$content=htmlspecialchars( $content );
	$content=str_replace('\n','<br />',$content );
	$content=str_replace('  ','&nbsp;&nbsp;',$content );
	return str_replace('\t','&nbsp;&nbsp;&nbsp;&nbsp;',$content );
}

function GetIP(){
	if($_SERVER['HTTP_CLIENT_IP'])
		return $_SERVER['HTTP_CLIENT_IP'];
	elseif($_SERVER['HTTP_X_FORWARDED_FOR'])
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	else
		return $_SERVER['REMOTE_ADDR'];
}