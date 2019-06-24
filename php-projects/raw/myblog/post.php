<?php
if(!isset($_GET['entry'])){
	echo '请求参数错误';
	exit;
}
$path=substr($_GET['entry'],0,6);
$entry=substr($_GET['entry'],7,9);
$file_name='contents/'.$path.'/'.$entry.'.txt';
if(file_exists($file_name)){
	$fp=fopen($file_name,'r');
	if($fp){
		flock($fp,LOCK_SH);
		$result=fread($fp,1024);
	}
	flock($fp,LOCK_UN);
	fclose($fp);
}
$content_arr=explode('$|$',$result);
echo '<h1>我的BLOG</h1>';
echo '<b>日志标题：</b>'.$content_arr[0];
echo '<br/><b>发布时间：</b>'.date('Y-m-d H:i:s',$content_arr[1]);
echo '<hr>';
echo $content_arr[2];