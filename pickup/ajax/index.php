<?php
//采集第一页并获得数据总页数
$ch=curl_init();
$url='http://appmanta.com/ASOWeb/appword/findappword.do';
$curlPost='country=usa&device=1&sdate=2017-11-15&edate=2017-11-16&appid=com.word.wordzenen&uid=AAAA&page=1&sort=asc&col=pos&pagesize=100&timezone=-480&isGoogle=yes';
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS,$curlPost);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); 
$content=curl_exec($ch);
curl_close($ch);
$object=json_decode($content);
$arrlist=$object->list;
if($arrlist){
	require('D:\phpStudy\www\pickup\conn\conn.php');
	foreach($arrlist as $key=>$val){
		$query='select id from pickup1 where word=\''.$val->word.'\'';	//此处判断数据是否已经采集过了，采集过的数据则不插入
		$res=mysql_query($query);
		$num=mysql_num_rows($res);
		if($num==0){
			$query='insert into pickup1 set ranking='.$val->ranking.',count='.$val->count.',word=\''.$val->word.'\',change_num='.$val->change;
			if(!mysql_query($query)){
				echo 'insert db error!';
				exit;	
			}
		}
	}
}

//计算ajax页面的总页数
$totalpages=$object->totalPages;
$nums=ceil($totalpages/100);


//分页采集(剩余的页面)
for($i=2;$i<=$nums;$i++){
	$ch2=curl_init();
	$url3='http://appmanta.com/ASOWeb/appword/findappword.do';
	$curlPost='country=usa&device=1&sdate=2017-11-15&edate=2017-11-16&appid=com.word.wordzenen&uid=AAAA&page='.$i.'&sort=asc&col=pos&pagesize=100&timezone=-480&isGoogle=yes';
	curl_setopt($ch2,CURLOPT_URL,$url3);
	curl_setopt($ch2,CURLOPT_POST,1);
	curl_setopt($ch2,CURLOPT_POSTFIELDS,$curlPost);
	curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch2, CURLOPT_ENCODING, 'gzip'); 
	$content2=curl_exec($ch2);
	curl_close($ch2);
	
	$object=json_decode($content2);
	$arrlist=$object->list;
	if($arrlist){
		require('D:\phpStudy\www\pickup\conn\conn.php');
		foreach($arrlist as $key=>$val){
			$query='select id from pickup1 where word=\''.$val->word.'\'';	//此处判断数据是否已经采集过了，采集过的数据则不插入
			$res=mysql_query($query);
			$num=mysql_num_rows($res);
			if($num==0){
				$query='insert into pickup1 set ranking='.$val->ranking.',count='.$val->count.',word=\''.$val->word.'\',change_num='.$val->change;
				if(!mysql_query($query)){
					echo 'insert db error!';
					exit;	
				}
			}
		}
	}	
}
ob_start();
echo 'pickup data success!';
?>
