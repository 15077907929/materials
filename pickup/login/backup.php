<?php
$url = "https://app.apptweak.com/users/sign_in";  
$cookie = tempnam('./tmp','cookie');  

//匹配获得登录表单内的信
$html=file_get_contents('https://app.apptweak.com/users/sign_in');
preg_match_all("/value=\"[^\"]*\"/i",$html,$matches); 

$post='utf8='.trim(substr($matches[0][0],6),'"').'&authenticity_token='.trim(substr($matches[0][1],6),'"').'&user[email]=letangjacquie@gmail.com&user[password]=lt@147258369.&user[remember_me]=0&commit=Log in';

function login_post($url,$cookie,$post) { 
	//请求头信息
	$headerArray = array(  
		'Accept:text/html,application/xhtml+xm…plication/xml;q=0.9,*/*;q=0.8',  
		'Content-Type:application/x-www-form-urlencoded',  
		'Referer:https://app.apptweak.com/users/sign_in'  
	); 
 
	$ch = curl_init();  
	curl_setopt($ch,CURLOPT_URL,$url);  
	// 对认证证书来源的检查，0表示阻止对证书的合法性的检查。  
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	// 从证书中检查SSL加密算法是否存在  
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//关闭直接输出  
	curl_setopt($ch,CURLOPT_POST,1);//使用post提交数据    
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36');//设置用户代理  
	curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);//设置头信息  
	// curl_setopt($ch, CURLOPT_SSLVERSION, 3); //设定SSL版本
	curl_setopt($ch,CURLOPT_POSTFIELDS,$post);//设置 post提交的数据  
	curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie);//设置cookie的保存目录，这里很重要，你懂的（cookie你都不存，你以为你是麻花腾啊！）  
	$loginData = curl_exec($ch);//这里会返回token，需要处理一下。  
	if (curl_errno($ch)) {    
		echo 'Errno'.curl_error($ch);  
	}  
	curl_close($ch); 
}

function get_content($url,$cookie) { 
	$ch = curl_init($url);
	// 对认证证书来源的检查，0表示阻止对证书的合法性的检查。  
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	// 从证书中检查SSL加密算法是否存在  
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);      
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//关闭直接输出      	
	curl_setopt($ch,CURLOPT_COOKIEFILE,$cookie); //读取cookie  
	$rs = curl_exec($ch); //执行cURL抓取页面内容 
	curl_close($ch);  
	return $rs;  
}

$url = "https://app.apptweak.com/users/sign_in"; //登录地址  
$cookie = dirname(__FILE__).'/cookie.txt'; //设置cookie保存路径  
$url2 = "https://app.apptweak.com/dumb-ways-to-die-2--the-games/google-playstore/us/us/app-marketing-app-store-optimization-aso/app-keywords-tool/air-au-com-metro-DumbWaysToDie2"; //登录后要获取信息的地址  
//login_post($url,$cookie,$post); //模拟登录 

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
    // 在HTTP请求头中"Referer: "的内容。
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
	echo $html;
	
	exit;
$content=get_content($url2,$cookie); //获取$url2的信息 
//echo $content;
//@unlink($cookie); //删除cookie文件  
exit;


require('D:\phpStudy\www\pickup\conn\conn.php');

$query='select count(*) as num from pickup1';
$res=mysql_query($query);
$row=mysql_fetch_array($res);
$num=$row['num'];
$pages=ceil($num/100);
for($i=0;$i<$pages;$i++){
	$queryString='';
	
	$query='select word from pickup1 limit '.($i*100).',100';
	$res=mysql_query($query);
	while($row=mysql_fetch_array($res)){
		$queryString=$queryString.$row['word'].',';	
	}
	$queryString=trim($queryString,',');
	echo $queryString.'<br/><br/>';
	exit;
}
?>



