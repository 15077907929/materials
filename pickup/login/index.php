<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>模拟登录采集https</title>
</head>
<body>
<?php 
error_reporting(0);
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
			"Cookie:_ga=GA1.3.1825302949.1509947994; _gid=GA1.3.2093756332.1509947994; mp_mixpanel__c=0; last_seen=1509947996176; __ar_v4=O6PAVQAXOBABNFHH4XWNFX%3A20171106%3A47%7C2A2Z4DRHZFCVHPK3E2BEC6%3A20171106%3A47%7C7QNDLYOCPJFYHMPLKZT63T%3A20171106%3A47; intercom-session-621c9ae4ca235ec165a469548fc6694b0c80f5e8=SS9ZUGtpMEFIYnZjNm5UL2VTNVZqeDRuemZBMWp5cVk5Z0NibzhTc2xuOU8xREZNQkV4NHQ2YWhxNmd3TUF5ZC0tOEZxV3VuZEI3Ri9WWGxnOUV0eGxSUT09--9880809c473b93d2c8a9eebe999bb73281008266; _apptweak_session=BAh7CUkiD3Nlc3Npb25faWQGOgZFVEkiJTFiNjcxYThkYmY3Nzg0MjRkNDJlMDdlNGZiMGNjYjQ0BjsAVEkiE3VzZXJfcmV0dXJuX3RvBjsAVCIGL0kiGXdhcmRlbi51c2VyLnVzZXIua2V5BjsAVFsHWwZpAqriSSIiJDJhJDEwJDl2Q3NjRTM2S1loWVZqOU11U3hlcmUGOwBUSSIQX2NzcmZfdG9rZW4GOwBGSSIxSkM4VGpGcERiUW1GR0tBUGIxUFVnNytueFpKZklvbnd1eXpLalZ5bjRmQT0GOwBG--a6c13e053a8e8a8280db22308bfc521114fe385a; country_code=us; _hjIncludedInSample=1; mp_145b4be9639b426d9fed9cd9e423a8f0_mixpanel=%7B%22distinct_id%22%3A%2058026%2C%22%24initial_referrer%22%3A%20%22https%3A%2F%2Fapp.apptweak.com%2Fusers%2Fsign_in%22%2C%22%24initial_referring_domain%22%3A%20%22app.apptweak.com%22%2C%22__mps%22%3A%20%7B%7D%2C%22__mpso%22%3A%20%7B%7D%2C%22__mpa%22%3A%20%7B%7D%2C%22__mpu%22%3A%20%7B%7D%2C%22__mpap%22%3A%20%5B%5D%2C%22%24search_engine%22%3A%20%22google%22%7D",
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
		echo 'keyword:'.$keyword.' | kei:'.$kei.' | competition:'.$competition.' | results: '.$results.' | volume:'.$volume.'<br/><br/>';		
				
		$query='insert into results set keyword=\''.$keyword.'\',kei='.$kei.',competition='.$competition.',results='.$results.',volume='.$volume;
		if(!mysql_query($query)){
			echo 'insert db error!';
			exit;	
		}
					
	}
}
?>


</body>
</html>





