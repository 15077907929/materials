<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>模拟采集https</title>
</head>
<body>
<?php 
error_reporting(0);
$url="https://app.apptweak.com/users/sign_in";  

//获取登录页面的cookie值，模拟登录时需要用到
$ch3=curl_init();	//初始化
curl_setopt($ch3, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
curl_setopt($ch3, CURLOPT_HEADER, 1);
curl_setopt($ch3,CURLOPT_SSL_VERIFYPEER, false);	//对认证证书来源的检查，0表示阻止对证书的合法性的检查。这个选项是必须的，对https协议来说的
curl_setopt($ch3,CURLOPT_URL,$url);  //设置请求地址
curl_setopt($ch3,CURLOPT_RETURNTRANSFER,1);	//关闭直接输出
$content=curl_exec($ch3);	//触发请求 
if (curl_errno($ch3)) {    
	echo 'Errno'.curl_error($ch3);  
} 
curl_close($ch3);	//关闭curl，释放资源
preg_match('/Set-Cookie:(.+);/iU', $content, $re);
$cookie3=$re[1];	//获取到登录前的cookie值，头信息里面需要用到

//匹配获得登录表单内的信息
preg_match_all("/value=\"[^\"]*\"/i",$content,$matches);
$post='utf8='.trim(substr($matches[0][0],6),'"').'&authenticity_token='.trim(substr($matches[0][1],6),'"').'&user[email]=letangjacquie@gmail.com&user[password]=lt@147258369.&user[remember_me]=0&commit=Log in';

//登录
$ch = curl_init();	//初始化
curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
curl_setopt($ch,CURLOPT_HEADER, 1);
curl_setopt($ch,CURLOPT_URL,$url);  //设置请求地址
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);	//对认证证书来源的检查，0表示阻止对证书的合法性的检查。这个选项是必须的，对https协议来说的
curl_setopt($ch,CURLOPT_POST,1);	//使用post提交数据
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);	//关闭直接输出  
curl_setopt($ch,CURLOPT_POSTFIELDS,$post);	//设置 post提交的数据
curl_setopt($ch, CURLOPT_HTTPHEADER, array(				
	"Host:app.apptweak.com",
	"User-Agent:Mozilla/5.0 (Windows NT 6.1; W…) Gecko/20100101 Firefox/56.0",
	"Accept:text/html,application/xhtml+xm…plication/xml;q=0.9,*/*;q=0.8",
	"Accept-Language:zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3",
	"Accept-Encoding:gzip, deflate, br",
	"Content-Type:application/x-www-form-urlencoded",
	"Referer:https://app.apptweak.com/users/sign_in",
	"Cookie:".$cookie3,
	"Connection:keep-alive",
	"Upgrade-Insecure-Requests:1",
));
$content=curl_exec($ch);	//触发请求 
if (curl_errno($ch)) {    
	echo 'Errno:'.curl_error($ch);  
} 
curl_close($ch);	//关闭curl，释放资源
preg_match('/Set-Cookie:(.+);/iU', $content, $re);
$cookie=$re[1];	//获取到cookie值，用于保持登录状态用的




//向页面https://app.apptweak.com/发起请求，获取登录后的信息		这一部分代码是测试登录状态是否保持成功的，可以忽略
$url2="https://app.apptweak.com/";
$ch2=curl_init();	//初始化
curl_setopt($ch2, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
curl_setopt($ch2, CURLOPT_HEADER, 1);
// 设置浏览器的特定header
curl_setopt($ch2, CURLOPT_HTTPHEADER, array(				
	"Host:app.apptweak.com",
	"User-Agent:Mozilla/5.0 (Windows NT 6.1; W…) Gecko/20100101 Firefox/56.0",
	"Accept:text/html,application/xhtml+xm…plication/xml;q=0.9,*/*;q=0.8",
	"Accept-Language:zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3",
	"Accept-Encoding:gzip, deflate, br",
	"Referer:https://app.apptweak.com/users/sign_in",	
	"Cookie:".$cookie,
	"Connection:keep-alive",
	"Upgrade-Insecure-Requests:1",
));
curl_setopt($ch2,CURLOPT_SSL_VERIFYPEER, false);	//对认证证书来源的检查，0表示阻止对证书的合法性的检查。这个选项是必须的，对https协议来说的
curl_setopt($ch2,CURLOPT_URL,$url2);  //设置请求地址
curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);	//开启直接输出
curl_exec($ch2);	//触发请求 
if (curl_errno($ch2)) {    
	echo 'Errno'.curl_error($ch2);  
} 
curl_close($ch2);	//关闭curl，释放资源




//程序第二步采集的代码
require('D:\phpStudy\www\pickup\conn\conn.php');
$query='select count(*) as num from pickup1';
$res=mysql_query($query);
$row=mysql_fetch_array($res);
$num=$row['num'];
$pages=ceil($num/100);
$j=1;
for($i=0;$i<$pages;$i++){
	$query='select word from pickup1 limit '.($i*100).',100';
	$res=mysql_query($query);
	while($row=mysql_fetch_array($res)){
		$keywords=str_replace(' ','+',$row['word']);
		echo ($j++).'.'.$keywords.'<br/>';			
		$url2 = "https://api3.app.apptweak.com/api/google/keywords/stats?api_key=ZomNfrKhkWE23sfq92ECTQfEeNLMtLebLBqiHXMk&country=us&language=us&device=google&keywords=".$keywords;   
		$ch = curl_init();
		// 设置浏览器的特定header
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Host: app.apptweak.com",
			"Connection: keep-alive",
			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
			"Upgrade-Insecure-Requests: 1",
			"Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3",
			"Cookie:".$cookie,
			));
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0');
		curl_setopt($ch, CURLOPT_REFERER,"https://app.apptweak.com/");
		curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, sdch");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_URL, $url2);
		curl_setopt($ch, CURLOPT_TIMEOUT,120);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//302redirect
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		$html = curl_exec($ch);
		curl_close($ch);
		
		$arr=json_decode($html);
		$object=$arr[0];
		$keyword=$object->keyword;
		$kei=round($object->kei);
		$competition=round($object->competition);
		$volume=round($object->volume);
		$results=$object->results;
		//echo 'keyword:'.$keyword.' | kei:'.$kei.' | competition:'.$competition.' | results: '.$results.' | volume:'.$volume.'<br/><br/>';		
				
		$query='insert into results set keyword=\''.$keyword.'\',kei='.$kei.',competition='.$competition.',results='.$results.',volume='.$volume;
		if(!mysql_query($query)){
			echo 'insert db error!';
			exit;	
		}			
	}
}
echo '数据采集成功！';
?>
</body>
</html>





