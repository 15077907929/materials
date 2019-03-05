<?php
// 本类由系统自动生成，仅供测试用途
namespace Pickup\Controller;
use Think\Controller;
class CdsController extends Controller {
	public function get_band_en(){
		$writeFilePath='/data/www/googlemanager/Apps/Pickup/Controller/log.txt';
		$url='https://www.chandashi.com/ranking/index/country/us/genre/6014/date/20190304.html';
		$content=$this->curl($url,array());
		preg_match_all('/<p class="developer">[^\"]*<a style="min-height: 100px;" title="([^\"]*)" href="\/apps\/view\/appId\/([^\"]*)\/country\/us.html" target="_blank">([^\"]*)<\/a>/iU', $content, $temp_arr);
		$appid_arr=$temp_arr[2];
		$appname_arr=$temp_arr[1];
		$url='https://www.chandashi.com/ranking/index/country/us/genre/6014/date/20190304.html?view=more';
		$content=$this->curl($url,array());
		preg_match_all('/<p class="developer">[^\"]*<a style="min-height: 100px;" title="([^\"]*)" href="\/apps\/view\/appId\/([^\"]*)\/country\/us.html" target="_blank">([^\"]*)<\/a>/iU', $content, $temp_arr);
		$appid_arr=array_merge($appid_arr,$temp_arr[2]);
		$appname_arr=array_merge($appname_arr,$temp_arr[1]);
		// echo $content;exit;
		// echo '<pre>';
		// print_r($temp_arr);
		// print_r($appid_arr);
		// echo '</pre>';
		foreach($appid_arr as $key=>$val){
			$url='https://itunes.apple.com/lookup?country=us&id='.$appid_arr[$key];
			$content=$this->curl($url,array());
			$json=json_decode($content);
			$package_name=$json->results[0]->bundleId;
			if($package_name){
				$url='https://play.google.com/store/apps/details?id='.$package_name.'&hl=en-EN';	//带采集的页面
				$content=$this->curl($url,array());
				//获取游戏总下载量(预估,取最小值)
				preg_match_all('/Installs<\/div><span class="htlgb"><div class="IQ1z0d"><span class="htlgb">([^\']*)[-+ ][^"]*<\/span><\/div><\/span>/iU', $content, $downloads_arr);	
				$downloads=intval(str_replace(',','',$downloads_arr[1][0]));
			}else{
				$downloads=0;
			}
			$app=array(
				'appid'=>$val,
				'name'=>$appname_arr[$key],	
				'package_name'=>$package_name,	
				'create_at'=>'2019-03-04'				
			);
			file_put_contents($writeFilePath, implode(PHP_EOL, $app).PHP_EOL,FILE_APPEND);
			M('cds_apps')->add($app);
			$package_id=M('cds_apps')->where('package_name=\''.$package_name.'\'')->find()['id'];
			$data=array(
				'package_id'=>$package_id,
				'downloads'=>$downloads,
				'create_at'=>'2019-03-04'
			);
			M('cds_band_en')->add($data);
			// $i++;
			// if($i>50){
				// exit;
			// }
		}
		$logSQl = $mysql_cmd . ' -h36.7.151.221 -u' . C('DB_USER') . ' -p' . C('DB_PWD') . ' --local-infile=1 keywordsDB -e  "load  data local infile \'' . $WriteFilePath . '\'  ignore into table keywords fields terminated by \'||\' enclosed by \'\"\' lines terminated by \'\n\' ';
		$logSQl .= '(package_name,keyword,change1,count,hot,ranking,create_at);"';
		exec($logSQl, $out, $status);	
		sleep(3);
		// echo $content;
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
	
	public function curl($url,$header_arr){
		$ch = curl_init();	//初始化
		curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
		curl_setopt($ch,CURLOPT_HEADER,0);	//关闭header输出
		curl_setopt($ch,CURLOPT_URL,$url);  //设置请求地址
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);	//对认证证书来源的检查，0表示阻止对证书的合法性的检查。这个选项是必须的，对https协议来说的
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);	//关闭直接输出  
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header_arr);
		$content=curl_exec($ch);	//触发请求 
		if (curl_errno($ch)) {    
			// echo 'Errno:'.curl_error($ch);  
		} 
		curl_close($ch);	//关闭curl，释放资源
		return $content;
	}
	
	public function cds_exec(){
		exec('/opt/php/bin/php /data/www/googlemanager/index.php Pickup/Cds/get_band_en/', $output, $result);		
	}
}