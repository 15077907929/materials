<?php
namespace Pickup\Controller;
class AppmanagerController extends RoleController{
	public function getkeyword1(){
		$num_start=0;
		$this->getkeyword($num_start);
	}
	
	public function getkeyword2(){
		$num_start=4;
		$this->getkeyword($num_start);
	}
	
	public function getkeyword3(){
		$num_start=8;
		$this->getkeyword($num_start);
	}

	public function getkeyword4(){
		$num_start=12;
		$this->getkeyword($num_start);
	}

	public function getkeyword5(){
		$num_start=16;
		$this->getkeyword($num_start);
	}
	
    private function getkeyword($num_start){
		$datetime=date('Y-m-d');
		$query='select * from google_app_config where gkw=1 order by id desc limit '.$num_start.',4';
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
			$pickup_arr[]=$row;
		}
		$start=date('Y-m-d');	//post参数的开始日期
		$end=date('Y-m-d',strtotime(date('Y-m-d').'+1 day'));	//post参数的结束日期
		$url='http://appmanta.com/ASOWeb/appword/findappword.do';
		$country_arr=array('US','TW','FR','GB','SG','DE','TH','IN');	//国家数组，需要校验的国家
		foreach($pickup_arr as $key=>$value){
			//采集第一页并获得数据总页数	每个包名只抓排名3-99的关键词   所以只取第一页的数据
			$ch=curl_init();
			$curlPost='country=usa&device=1&sdate='.$start.'&edate='.$end.'&appid='.$value['package_name'].'&uid=AAAA&page=1&sort=asc&col=pos&pagesize=100&timezone=-480&isGoogle=yes';
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
				foreach($arrlist as $k=>$v){
					if($v->ranking>3){
						//在这里要校验关键词是否可用，可用的话在进行下一步操作		
						foreach($country_arr as $sub_k=>$sub_v){
							$account_data = array();
							$getAccountInfo = $this->_getAccounInfo(1084);
							$getAccountInfo['packageName']=$value['package_name'];
							$getAccountInfo['vendingCountry']=$sub_v;;
							$getAccountInfo['keyWords']=$v->word;
							$account_data['account_ids'][] = $getAccountInfo;												

							$locale='de_DE.UTF-8';
							setlocale(LC_ALL,$locale);
							putenv('LC_ALL='.$locale);

							//TODO 生成的临时账号数据文件
							$rand_text_name = 'search_' . date('YmdHis') . rand(0, 999) . '.txt';

							//TODO 将协议数据写入文件
							file_put_contents('/home/www/gtils/' . $rand_text_name, json_encode($account_data));

							//TODO
							exec('java -jar /home/www/gtils/gtils10.jar search 1 /home/www/gtils/' . $rand_text_name, $output, $return_var);

							@unlink('/home/www/gtils/' . $rand_text_name);

							$data = json_decode($output[0], TRUE);

							if($data['results'][0]['rank'] > -1){
								$query='insert into app_keywords set package_name=\''.$value['package_name'].'\',country=\''.$sub_v.'\',word=\''.$v->word.'\',rank='.$v->ranking.',addtime='.time().',datetime=\''.$datetime.'\'';
								mysql_query($query);
							}else{
								echo $v->word . "###{$data['results'][0]['rank']}<br />";
							}
						}
					}
				}
			}
		}
	}
	
    private function _getAccounInfo($account_id){
        $accountIds = array(
            1084,1088,1075,1863,1087,1076
        );
        if($account_id){
            $accountInfo = getRedis()->get('account_id_' . $account_id);
        }else{
            $accountInfo = getRedis()->get('account_id_' . $accountIds[rand(0, (count($accountIds) - 1))]);
        }

        //$accountInfo = getRedis()->get('account_id_105310');
        $packageName = '';
        $keyword = '';
        $downloadInfo = array(
            'digest' => $accountInfo['digest'],'androidID' => $accountInfo['androidID'],'vendingSecureAuthToken' => $accountInfo['vendingSecureAuthToken'],
            'vendingAuthToken' => $accountInfo['vendingAuthToken'],'deviceDataVersionInfo' => $accountInfo['deviceDataVersionInfo'],'otherTarget' => $accountInfo['otherTarget'] ? $accountInfo['otherTarget'] : '',
            'vendingVersionCode' => $accountInfo['vendingVersionCode'],'vendingApiVersion' => $accountInfo['vendingApiVersion'],'tocCookie' => $accountInfo['tocCookie'],
            'loggingID' => $accountInfo['loggingID'],'AdId' => $accountInfo['AdId'],'supportTarget' => $accountInfo['supportTarget'] ? $accountInfo['supportTarget'] : '',
            'vendingVersionName' => $accountInfo['vendingVersionName']
        );

        if($accountInfo['targetsList'] != ''){
            $downloadInfo['targetsList'] = $accountInfo['targetsList'];
        }

        //获取账号机器信息
        if(strlen($accountInfo['configurationMNC']) == 1){
            $accountInfo['configurationMNC'] = '0' . $accountInfo['configurationMNC'];
        }

        $returnMachineInfo = array(
            'buildSdkInt' => $accountInfo['buildSdkInt'],
            'buildDevice' => $accountInfo['buildDevice'],
            'buildHardware' => $accountInfo['buildHardware'],
            'buildProduct' => $accountInfo['buildProduct'],
            'buildRelease' => $accountInfo['buildRelease'],
            'buildModel' => $accountInfo['buildModel'],
            'buildID' => $accountInfo['buildID'],
            'publicAndroidID' => $accountInfo['publicAndroidId'],
            'language' => 'en',
            'country' => 'US',
            'buildBrand' => $accountInfo['buildBrand'],
            'buildBoard' => $accountInfo['buildBoard'],
            'configurationMCC' => $accountInfo['configurationMCC'] ? $accountInfo['configurationMCC'] : "",
            'configurationMNC' => $accountInfo['configurationMNC'] ? $accountInfo['configurationMNC'] : "",
            'buildFingerPrint' => $accountInfo['buildFingerPrint'] ? $accountInfo['buildFingerPrint'] : "",
            'buildManufacture' => $accountInfo['buildManufacture'] ? $accountInfo['buildManufacture'] : "",
            'buildRadioVersion' => $accountInfo['buildRadioVersion'] ? $accountInfo['buildRadioVersion'] : "",
        );

        return array_merge($accountInfo, $returnMachineInfo);
    }	
}