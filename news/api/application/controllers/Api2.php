<?php
class Api2Controller extends Yaf_Controller_Abstract{
	public function pickupartsAction(){
		$url='http://weixin.sogou.com/';	//带采集的页面
		$ch = curl_init();	//初始化
		curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
		curl_setopt($ch,CURLOPT_HEADER,0);	//关闭header输出
		curl_setopt($ch,CURLOPT_URL,$url);  //设置请求地址
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);	//对认证证书来源的检查，0表示阻止对证书的合法性的检查。这个选项是必须的，对https协议来说的
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);	//关闭直接输出  
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(	
			'Accept:text/html,application/xhtml+xm…plication/xml;q=0.9,*/*;q=0.8',
			'Accept-Encoding:gzip, deflate',
			'Accept-Language:zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
			'Cache-Control:max-age=0',
			'Connection:keep-alive',
			'Cookie:IPLOC=CN3401; SUID=B24768DA2F2…1936|v1; weixinIndexVisited=1',
			'Host:weixin.sogou.com',
			'Upgrade-Insecure-Requests:1',
			'User-Agent:Mozilla/5.0 (Windows NT 6.1; W…) Gecko/20100101 Firefox/61.0',
		));
		
		$content=curl_exec($ch);	//触发请求 
		if (curl_errno($ch)) {    
			echo 'Errno:'.curl_error($ch);  
		} 
		curl_close($ch);	//关闭curl，释放资源
		
		// echo $content;
		
		preg_match_all('/<div class="img-box">[^\"]*<a uigs="[^\"]*" href="[^\"]*" target="_blank">[^\"]*<img src="([^\"]*)" onload="resizeImage\(this\)" onerror="errorImage\(this\)"\/>[^\"]*<\/a>[^\"]*<\/div>/iU', $content, $img_arr);
		preg_match_all('/<h3>[^\"]*<a uigs="[^\"]*" href="([^\"]*)" target="_blank" data-share="[^\"]*">([^\"]*)<\/a>[^\"]*<\/h3>/iU', $content, $tit_arr);
		$img_arr=$img_arr[1];
		$url_arr=$tit_arr[1];
		$tit_arr=$tit_arr[2];
		foreach($url_arr as &$val){
			$val=str_replace("&",'&amp;',$val);
		}
		foreach($img_arr as $val){
			$ch = curl_init();	//初始化
			curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
			curl_setopt($ch,CURLOPT_HEADER,0);	//关闭header输出
			curl_setopt($ch,CURLOPT_URL,'http:'.$val);  //设置请求地址
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);	//对认证证书来源的检查，0表示阻止对证书的合法性的检查。这个选项是必须的，对https协议来说的
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);	//关闭直接输出 
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(	
				'Accept:text/html,application/xhtml+xm…plication/xml;q=0.9,*/*;q=0.8',
				'Accept-Encoding:gzip, deflate',
				'Accept-Language:zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
				'Cache-Control:max-age=0',
				'Connection:keep-alive',
				'If-None-Match:8524c7c5b6458fc76b7b19a72f14bfc3',
				'Upgrade-Insecure-Requests:1',
				'User-Agent:Mozilla/5.0 (Windows NT 6.1; W…) Gecko/20100101 Firefox/61.0'
			));
			$content=curl_exec($ch);	//触发请求 
			echo $content;
			if (curl_errno($ch)) {    
				echo 'Errno:'.curl_error($ch);  
			} 
			curl_close($ch);	//关闭curl，释放资源		
		}
		
		echo '<pre>';
		print_r($img_arr);
		print_r($tit_arr);
		print_r($url_arr);
	}
	
	
	
	
	
	
	
}

