<?php
/**
 * 记录日志到内存中，当积攒到一定量时再写到日志文件里面
 * @author Administrator
 *
 */
class WriteLogs {

	public static function pushData($key,$value){
		JMQClient::writeMQ(JMQClient::LOG,$key,$value);
		return 1;
	} 
	
	public static function putLog($value){
		$config = new Yaf_Config_Ini(CONFIG_INI, 'product');
		$dir = $config->logPath->url;
		echo $dir;
		$filename="putLog.log";
		$logs=new Logs($dir,$filename);
		$logs->setLog($value);
		return $dir;
	}
	
	public static function putValue($value){
		$config = new Yaf_Config_Ini(CONFIG_INI, 'product');
		$dir = $config->logPath->url;
		$filename="user_log.log";
		$logs=new Logs($dir,$filename);
		$logs->setLog($value);
	}
	
	public static function putValueLog($type,$value){
		$config = new Yaf_Config_Ini(CONFIG_INI, 'product');
		$time = date("Y-m-d");
		$dir = $config->logPath->url;
		$filename=$type.".".$time.".log";
		$logs=new Logs($dir,$filename);
		$logs->setLog($value);
		
	}
	
	public static function putScoreLog($appid,$value){
		$config = new Yaf_Config_Ini(CONFIG_INI, 'product');
		$time = date("Y-m-d");
		$dir = $config->logPath->url."/score/";
		$filename=$appid.".".$time.".log";
		$logs=new Logs($dir,$filename);
		$logs->setLog($value);
	}
	
	public static function putUserGoodsLog($value){
		$config = new Yaf_Config_Ini(CONFIG_INI, 'product');
		$time = date("Y-m-d");
		$dir = $config->logPath->url."/goods/";
		$filename="user_goods.".$time.".log";
		$logs=new Logs($dir,$filename);
		$logs->setLog($value);
	}
	
	public static function putPlanReward($type,$value){
		$dir = '/data/log/game/reward';
		$filename=$type.".plan_reward.".date("Y-m-d").".log";
		$logs=new Logs($dir,$filename);
		$logs->setLog($value);
	}
	
	public static function putPlanCoin($appid,$value){
		$dir = '/data/log/game/coin';
		$filename=$appid.".plan_coin.".date("Y-m-d").".log";
		$logs=new Logs($dir,$filename);
		$logs->setLog($value);
	}
	
	public static function putBearLog($value){
		$dir = '/data/log/game/bear';
		$filename="bearLog.".date("Y-m-d").".log";
		$logs=new Logs($dir,$filename);
		$logs->setLog($value);
	}
	
	public static function putAllLog($value,$app_id,$key){
		$dir = '/data/log/game/'.$key;
		$filename=$app_id.".".date("Y-m-d").".log";
		$logs=new Logs($dir,$filename);
		$logs->setLog($value);
	}
	
	public static function putAllLogNEW($value,$app_id,$key){
		$dir = '/data/log/game/'.$key;
		$filename=$app_id.$key.".log";
		$logs=new Logs($dir,$filename);
		$logs->setLog($value);
	}
	
	public static function putNEWLog($value,$app_id,$key){
		if ($app_id == 1151) $app_id = 155;
		if ($app_id == 225) $app_id = 227;
		$value = "|".$app_id.$value;
		if ($app_id > 1000 && $app_id < 30000) return;
		if ($app_id < 155 ) return;
		$dir = '/data/log/gamelog/'.$app_id;
		$filename=$key.".".date("Y-m-d").".log";
		
		$logs=new Logs($dir,$filename);
		$logs->setLog($value);
	}
	
	public static function putPidLog($value,$key){
		$dir = '/data/log/gamelog/';
		$filename=$key.".".date("Y-m-d").".log";
		$logs=new Logs($dir,$filename);
		$logs->setLog($value);
	}
}

?>