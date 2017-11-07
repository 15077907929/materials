<?php
$cookie_file=tempnam('./temp','cookie');
$ch = curl_init();
$url1 = 'http://appmanta.com/app/keywordanalytics.html?appid=com.word.wordzenen&country=usa&store=gp&device=1';
curl_setopt($ch,CURLOPT_URL,$url1);
curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
curl_setopt($ch,CURLOPT_HEADER,0);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
//设置连接结束后保存cookie信息的文件
curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie_file);
$content=curl_exec($ch);
 
curl_close($ch);
 
$ch3 = curl_init();
$url3 = 'http://appmanta.com/ASOWeb/appword/findappword.do';
$curlPost='country=usa&device=1&sdate=2017-11-07&edate=2017-11-06&appid=com.word.wordzenen&uid=AAAA&page=1&sort=asc&col=pos&pagesize=100&timezone=-480&isGoogle=yes';
curl_setopt($ch3,CURLOPT_URL,$url3);
curl_setopt($ch3,CURLOPT_POST,1);
curl_setopt($ch3,CURLOPT_POSTFIELDS,$curlPost);
 
//设置连接结束后保存cookie信息的文件
curl_setopt($ch3,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch3,CURLOPT_COOKIEFILE,$cookie_file); 
curl_setopt($ch3, CURLOPT_ENCODING, 'gzip'); 
$content1=curl_exec($ch3);
$object=json_decode($content1);
$arrlist=$object->list;
if($arrlist){
	require('D:\phpStudy\www\pickup\conn\conn.php');
	foreach($arrlist as $key=>$val){
		$query='insert into pickup1 set ranking='.$val->ranking.',count='.$val->count.',word=\''.$val->word.'\',change_num='.$val->change;
		if(!mysql_query($query)){
			echo 'insert db error!';
			exit;	
		}
	}
}

//计算ajax页面的总页数
$totalpages=$object->totalPages;
$nums=ceil($totalpages/100);

//分页采集
for($i=2;$i<=$nums;$i++){
	$cookie_file=tempnam('./temp','cookie');
	$ch = curl_init();
	$url1 = 'http://appmanta.com/app/keywordanalytics.html?appid=com.word.wordzenen&country=usa&store=gp&device=1';
	curl_setopt($ch,CURLOPT_URL,$url1);
	curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
	curl_setopt($ch,CURLOPT_HEADER,0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
	//设置连接结束后保存cookie信息的文件
	curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie_file);
	$content=curl_exec($ch);
	 
	curl_close($ch);
	 
	$ch3 = curl_init();
	$url3 = 'http://appmanta.com/ASOWeb/appword/findappword.do';
	$curlPost='country=usa&device=1&sdate=2017-11-07&edate=2017-11-06&appid=com.word.wordzenen&uid=AAAA&page='.$i.'&sort=asc&col=pos&pagesize=100&timezone=-480&isGoogle=yes';
	curl_setopt($ch3,CURLOPT_URL,$url3);
	curl_setopt($ch3,CURLOPT_POST,1);
	curl_setopt($ch3,CURLOPT_POSTFIELDS,$curlPost);
	 
	//设置连接结束后保存cookie信息的文件
	curl_setopt($ch3,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch3,CURLOPT_COOKIEFILE,$cookie_file); 
	curl_setopt($ch3, CURLOPT_ENCODING, 'gzip'); 
	$content1=curl_exec($ch3);
	$object=json_decode($content1);
	$arrlist=$object->list;
	if($arrlist){
		require('D:\phpStudy\www\pickup\conn\conn.php');
		foreach($arrlist as $key=>$val){
			$query='insert into pickup1 set ranking='.$val->ranking.',count='.$val->count.',word=\''.$val->word.'\',change_num='.$val->change;
			if(!mysql_query($query)){
				echo 'insert db error!';
				exit;	
			}
		}
	}	
}
echo 'pickup data success!';
?>
