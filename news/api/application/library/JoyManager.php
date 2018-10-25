<?php

class JoyManager{
	
	public static function getNameByIp($ip = null){
		if (!$ip)$ip = JoyUtil::getIp();
		$data = geoip_record_by_name($ip);
		if ($data && $data['city']){
			return $data['city'];
		}
		return false;
	}
	
		//获取请求参数
    public static function getRequest($name, $defval = -1) {
        if ( isset($_REQUEST[$name]) && trim($_REQUEST[$name])) {
            return trim($_REQUEST[$name]);
        }
        return $defval;
    }
    
    public static function getGameDataMax($key,$app_id,$channel_id,$versionCode){
		$cache = JoyCache::getInstance();
		$key = $key.$app_id;
		$data = $cache->get($key);
		$list = array();
		if ($data){
			foreach($data as $temp){
				if ($temp['app_id'] != $app_id) continue;
				$channels = explode("|",$temp["channel_id"]);
				if ($channels[0] == "no"){
					if (in_array($channel_id,$channels)){
						continue;
					}elseif ($versionCode >= $temp['version'] ) {
						$list = $temp;
						break;	
					}
				}else{
					if ($versionCode >= $temp['version']  && $temp['channel_id'] == "all" ){
						$list = $temp;
						break;
					}
					if ($versionCode >= $temp['version']  && is_array($channels) && in_array($channel_id,$channels)) {
						$list = $temp;
						break;
					}
				}
			}
		}
		return $list;
    }
    
    public static function getGameData($key,$app_id,$channel_id,$versionCode,$uid=0,$opName,$city){
		$cache = JoyCache::getInstance();
		$key = $key.$app_id;
		$data = $cache->get($key);
		$list = array();
		if ($data){
			foreach($data as $temp){
				if ($temp['app_id'] != $app_id) continue;
				$channels = explode("|",$temp["channel_id"]);
				if ($channels[0] == "no"){
					if (in_array($channel_id,$channels)){
						continue;
					}elseif ($versionCode < $temp['version'] ) {
						$list = $temp;
						break;	
					}
				}else{
					if ($versionCode < $temp['version']  && $temp['channel_id'] == "all" ){
						$list = $temp;
						break;
					}
					if ($versionCode < $temp['version']  && is_array($channels) && in_array($channel_id,$channels)) {
						$list = $temp;
						break;
					}
				}
			}
		}
		if ($list) {
			unset($list['id']);
			unset($list['sort']);
			unset($list['channel_id']);
			$url = $list['download'];
			$list['download'] = "http://data.joymeng.com/sp/download_apk.php?app_id=$app_id&channel_id=$channel_id&version=$versionCode&uid=$uid&url=$url";
			$ch = JoyCacheLTUN::getInstance();
			$data = $ch->hGetAll("GAME_DOWNLOAD_ONLINE_COUNT");
		    $count_max = $cache->hGet("game_config_new","game_download_max_count");
			$count = count($data);
			if ($count > $count_max) $list = array();//限定最大下载人数
	    	$citys = $cache->hGet("game_config_new","game_download_city");
	    	$tu = JoyManager::isArea($citys,'area',$city);
			if (isset($list['op_name']) && !strstr($list['op_name'],strtolower($opName))) $list = array();//是否是移动版本包
        	if ( $tu ) $list = array();//排除城市
        	if (!$uid) $list = array();//新注册
		}
		return $list;
    }
	public static function getAddressByXY($x,$y){
		$url = "http://api.map.baidu.com/geocoder/v2/?ak=Ae6Y1cq6AF3wE94d5M1zT5RV&output=json&location=";
		$xy = $x.",".$y;
		$data = json_decode(file_get_contents($url.$xy),true);
		if ($data['status'] == 0){
			return array('city'=>$data['result']['addressComponent']['province'],'addr'=>$data['result']['formatted_address'],'cityCode'=>$data['result']['cityCode']);
		}
		return null;
	}
	public static function isHeFei(){
		$ip = JoyUtil::getIp();
		$city = JoyManager::getNameByIp($ip);
		if ( $city == "Hefei"){
			return 1;
		}else if (!$city){
			$city = JoyManager::getIp($ip);
			if ($city && $city['country'] =="安徽省") return 1;
			return 0;
		}
	}
	public static function getOpName(){
  	  return isset($_REQUEST['opName'])?$_REQUEST['opName']:"";
	}
	
	public static function isCity($name){
		$ip = JoyUtil::getIp();
		$city = JoyManager::getIp($ip);
		if ($city && strstr($city['country'],$name)) return 1;
		return 0;
	}
	
	public static   function getAppIds($app_id){
		if ($app_id == 1151) $app_id=155;
		if ($app_id == 225) $app_id=227;
		if ($app_id == 907) $app_id=254;
		return $app_id;
	}
	public static  function mySubstr($str , $len)
		{
		    for ($i = 0; $i < $len; $i++) {
		        $temp_str = substr($str, 0, 1);
		        if (ord($temp_str) > 127) {
		            $i++;
		            if ($i < $len) {
		                $new_str[] = substr($str, 0, 3);
		                $str = substr($str, 3);
		            }
		        } else {
		            $new_str[] = substr($str, 0, 1);
		            $str = substr($str, 1);
		        }
		    }
		
		    return implode($new_str);
		}
	
	
	public static function getIp($ip = '')
	{
		require_once("IpLocation.class.php");
		$ipLocation  = new IpLocation();
		return $ipLocation->getLocation($ip);
	}
	
	public static function addGameId($user,$gameId){
		$applist = $user->gameId?$user->gameId:null;
		if (!$applist){
			$user->gameId = intval($gameId);
			$user->save();
		} else{
			$applist = explode(",", $applist);
			if (!in_array(intval($gameId), $applist)){
				$user->gameId = $user->gameId.",".intval($gameId);
				$user->save();
			}
		}
		return $user->gameId;
	}
	
	public static function getOpNameD(){
  	  return isset($_REQUEST['opName'])?$_REQUEST['opName']:"CM";
	}
	
	public static function G_POST() {
  	  return isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
	}
	/**
	 * token 合法性检测
	 * @param $return_uid bool true返回uid,false返回username.
	 * @return string|int 失败：给出提示，退出程序
	 * 		 成功：返回username|uid
	 */
	public static function authToken($return_uid = 0) {
		
		if (isset($_REQUEST['uid'])) return $_REQUEST['uid'];
		
		if(!isset($_REQUEST['token'])) {
			$result['status'] = JoyConst::FAILURE_TOKEN_EMPTY;
			$result['msg'] = 'auth failed1.';
			exit(json_encode($result));
		}
		$token = $_REQUEST['token'];
		if(!($id = self::getToken($token, 'uid'))) {
			$result['status'] = JoyConst::FAILURE_TOKEN_EXPIRED;
			$result['msg'] = 'token expired2.';
			exit(json_encode($result));
		}
		if (!is_numeric($id)) {
			$result['status'] = JoyConst::FAILURE_TOKEN_EMPTY;
			$result['msg'] = 'auth failed3.';
			exit(json_encode($result));
		};
		return $id;
	}
	
	
	public static function authTokenS($return_uid = 0) {
		if(!isset($_REQUEST['token'])) {
			return 0;
		}
		$token = $_REQUEST['token'];
		if(!($id = self::getToken($token, 'uid'))) {
			return 0;
		}
		if (!is_numeric($id)) {
			return 0;
		};
		return $id;
	}
	
	public static function arrayMap($id){
		return 'USER'.JoyConst::PUB_ID.$id ;
	}
	
	public static function arrayMaps($id){
		$app_id = JoyManager::getAppId();
		return $app_id."lt_gameUser_uids_".$id;
	}
	
	public static function arrayMapsWeb($uid){
		$key1 = "gameArchive_BY_UID_".$uid;
		return $key1;
	}
	
	public static function getVersionCode(){
		if(isset($_REQUEST['versionCode'])) {
			if (!is_numeric($_REQUEST['versionCode'])) return str_replace(".","",$_REQUEST['versionCode']);
			return intval($_REQUEST['versionCode']);
			exit;
		}
		return -1;
	} 
	/**
	 * 取得游戏ID
	 * @return unknown
	 */
	public static function getAppId(){
		if(!isset($_REQUEST['app_id']) && !isset($_REQUEST['appid'])) {
			$result['status'] = JoyConst::FAILURE_TOKEN_EMPTY;
			$result['msg'] = 'appid is empty';
			exit(json_encode($result));
		}
		if (isset($_REQUEST['app_id'])) $appid = $_REQUEST['app_id'];
		if (isset($_REQUEST['appid']) && !isset($_REQUEST['app_id'])) $appid = $_REQUEST['appid'];
		if ($appid == 1153 && self::getVersionCode() == 5 )$appid = 1151;
		if ($appid == 155) $appid=1151;
		if ($appid == 227) $appid=225;
		if ($appid == 907) $appid=254;
		return intval($appid);
	}
	
	
	public static function getSinging(){
		$singing = isset($_REQUEST['singing'])?$_REQUEST['singing']:0;
		return $singing;
	}
	
	public static function getMobile(){
		$mobile = isset($_REQUEST['mobile'])?$_REQUEST['mobile']:0;
		return $mobile;
	}
	
	/**
	 * 取得游戏ID
	 * @return unknown
	 */
	public static function getSdk(){
		if(isset($_REQUEST['sdk'])) {
			return $_REQUEST['sdk'];
			exit;
		}
		return null;
	}
	
	public static function querySql($sql,$app_id,$table){
		$cache = JoyCache::getInstance();
//		$appids = $cache->get("game_config");
//		$appids = json_decode($appids["game_new_log"]);
		$appids = $cache->hGet("game_config_new","game_new_log");
		if (in_array($app_id,$appids)){
			$databases = "lt_ucenter_new";
			$new_table = $table."_".$app_id;
			$sql = str_replace($table,$new_table,$sql);
			JoyDbNew::query($sql,$databases);
		}else{
			JoyDb::query($sql);
		}
	}
	
	public static function getChannelId(){
		$chanelId = isset($_REQUEST['channel_id'])?$_REQUEST['channel_id']:1;
		if ($chanelId == "" || empty($chanelId)){
			$chanelId = 1;
		}
		$chanelId = str_replace("\r\n","",$chanelId);
		if (strlen($chanelId) >7 ) $chanelId = "0000001";
		return $chanelId;
	}
	
	public static function getWeekly($app_id,$date=1,$channel_id=1){
		$type =1;
		if ($channel_id >=8000000 && $channel_id <9000000){
			$type = "ios_";
		}
		if ($date == date("Y-m-d")) $date = date("Y-m-d H");
//		else if ($channel_id ==1668 || $channel_id ==2054){
//			$type = "kp_";
//		}
		if ($app_id == 1151){
			if ($date >='2014-09-10 00' && $date<'2014-09-19 09')
				return "BearCPPKRankDataRedis_".$type.$app_id."_3";
			else if ($date >='2014-09-19 09' && $date<'2014-09-26 00'){
				if ($channel_id ==1668 || $channel_id ==2054)$type = "kp_";
				return "BearCPPKRankDataRedis_".$type.$app_id."_4";
			}
			else
				return "BearCPPKRankDataRedis_".$type.$app_id;
		}else{
			return "BearCPPKRankDataRedis_".$type.$app_id;
		}
		
	}
	
	
	public static function ZhengBSList($app_id,$channel_id=1,$key_order='GameScoreCpRankList_'){
		$cache = JoyCache::getInstance();
//		$gameids = $cache->get("game_config");
//		$uids = json_decode($gameids["gameid_shipei"],true);////重复游戏老用户。
		$uids = $cache->hGet("game_config_new","gameid_shipei");
		if (isset($uids[$app_id]) && $uids[$app_id]) $app_id = $uids[$app_id];
		
		$key = $key_order.$app_id;
        $result = $cache->get($key);
		$list = array();
		$time = date("Y-m-d H:i:s");
		if (!$result) return false;
		foreach($result as $temp){
			$channels = explode("|",$temp["channel_id"]);
			if ($channels[0] == "no"){
				if (in_array($channel_id,$channels)){
					continue;
				}else{
					if ($time >=$temp['time1'] && $time <$temp['time2'] && $channel_id != 8000000) 
						$list[] = $temp;
				}
			}else{
				if ($time >=$temp['time1'] && $time <$temp['time2'] && $temp['channel_id'] == "all" && $channel_id != 8000000 )
					$list[] = $temp;
				if ($time >=$temp['time1'] && $time <$temp['time2'] && is_array($channels) && in_array($channel_id,$channels)) 
					$list[] = $temp;
			}
		}
		return $list;
	}
	
	public static function getActData($app_id,$channel_id,$vesion,$count=null){
		$key = "loadActivityConf".$app_id;
		$cache = JoyCache::getInstance();
        $result = $cache->get($key);
		$list = array();
		$time = date("Y-m-d H:i:s");
		if (!$result) return false;
		$ip = JoyManager::getRequest("ip",JoyUtil::getClientIp());
		$ct = JoyUtil::getAddress($ip);
        $count = $ct['country'];
		foreach($result as $temp){

			if ($temp['version'] && $vesion< $temp['version']) continue;
			if (!$temp['newicon'] ) continue;
			if(!empty($temp['ext']['area']) && $channel_id != "9999999"){
	             $tu = JoyManager::isArea($temp['ext'],'area',$count);
    			 if ( !$tu ) continue;
			}
			$type = $temp['type'] == 100 ?1:0;
			$url = $temp['type'] == 100 ?trim($temp['content']):0;
//			$type = $temp['id'] == 952 ?1:0;
//			$url = $temp['id'] == 952 ?"http://hijoyactive.joymeng.com/nc/index_01.php":0;
			$channels = $temp["channel_id"];
			if ($channels[0] == "no"){
				if (in_array($channel_id,$channels)){
					continue;
				}else{
					if ($time >=$temp['time1'] && $time <$temp['time2']) 
						$list[] = array('image'=>$temp['newicon'],'id'=>$temp['id'],'type'=>$type,'small_type'=>intval($temp['title2']),'content'=>$temp['title'],'url'=>$url,'reward'=>$temp['join_str']);
				}
			}else{
				if ($time >=$temp['time1'] && $time <$temp['time2'] && $temp['channel_id'] == "all"  )
					$list[] =  array('image'=>$temp['newicon'],'id'=>$temp['id'],'type'=>$type,'small_type'=>intval($temp['title2']),'content'=>$temp['title'],'url'=>$url,'reward'=>$temp['join_str']);
				if ($time >=$temp['time1'] && $time <$temp['time2'] && is_array($channels) && in_array($channel_id,$channels)) 
					$list[] =  array('image'=>$temp['newicon'],'id'=>$temp['id'],'type'=>$type,'small_type'=>intval($temp['title2']),'content'=>$temp['title'],'url'=>$url,'reward'=>$temp['join_str']);
			}
		}
		return $list;
	}
	
	public static function getNewIconData($app_id,$channel_id){
		$key = "loadNewIcon".$app_id;
		$cache = JoyCache::getInstance();
        $result = $cache->get($key);
		$time = date("Y-m-d H:i:s");
		if (!$result) return false;
		foreach($result as $temp){
			$channels = $temp["channel_id"];
			if ($channels[0] == "no"){
				if (in_array($channel_id,$channels)){
					continue;
				}else{
					if ($time >=$temp['start_time'] && $time <$temp['end_time'] && $channel_id != 8000000)
						return $temp['icon'];
				}
			}else{
				if ($time >=$temp['start_time'] && $time <$temp['end_time'] && $temp['channel_id'] == "all" && $channel_id != 8000000 )
					return $temp['icon'];
				if ($time >=$temp['start_time'] && $time <$temp['end_time'] && is_array($channels) && in_array($channel_id,$channels)) 
					return $temp['icon'];
			}
		}
		return "";
	}
	
	
	
	
	public static function isZhengBS($app_id,$channel_id=1){
		$key = "GameScoreCpRankList_".$app_id;
		$cache = JoyCache::getInstance();
        $result = $cache->get($key);
		$list = array();
		$time = date("Y-m-d H:i:s");
		if (!$result) return false;
		foreach($result as $temp){
			$channels = explode("|",$temp["channel_id"]);
			if ($channels[0] == "no"){
				if (in_array($channel_id,$channels)){
					continue;
				}else{
					if ($time >=$temp['time1'] && $time <$temp['time2']  && $temp['type']==1 && $channel_id != 8000000) 
						return $temp;
				}
			}else{
				if ($time >=$temp['time1'] && $time <$temp['time2'] && $temp['channel_id'] == "all" && $channel_id != 8000000 && $temp['type']==1)
					return $temp;
				if ($time >=$temp['time1'] && $time <$temp['time2'] && is_array($channels) && in_array($channel_id,$channels) && $temp['type']==1) 
					return $temp;
			}
		}
		return $list;
	}
	
	 public static function isChannelSMail($app_id,$channel_id,$vercode,$key_s="loadMail",$flage =true ){
	    $cache = JoyCache::getInstance();
	    if ($flage)
	   		$key = $key_s.$app_id;
	   	else 	
	   		$key = $key_s;
	    $result = $cache->get($key);
	    $list = array();
	    $time = date("Y-m-d H:i:s");
	    if (!$result) return false;
	    foreach($result as $temp){
    	    if ($temp['app_id'] != $app_id ) continue;
    	    if ($time < $temp['start_time'] || $time > $temp['end_time']  ) continue;
    	    if (isset($temp['enable'])) unset($temp['enable']);
    	    if (isset($temp['sort'])) unset($temp['sort']);
	        $channels = explode("|",$temp["channel_id"]);
	        if ($channels[0] == "no"){
	            if (!in_array($channel_id,$channels)){
	        		if ($temp["version_code"]){
	            		$t =  $temp['version_code']{0};
	            		$ver = trim(substr($temp["version_code"],1));
	            		if ($t == ">" && $vercode >$ver )$list[] = $temp;
	    		   		if ($t == "<" && $vercode < $ver )$list[] = $temp;
	    		   		if ($t == "=" && $vercode == $ver )$list[] = $temp;
	            	}else{
	            		$list[] = $temp;
	            	}
	            }
	        }else{
	            if ( $temp['channel_id'] == "all" || (is_array($channels) && in_array($channel_id,$channels)))
	    			if ($temp["version_code"]){
	            		$t =  $temp['version_code']{0};
	            		$ver = trim(substr($temp["version_code"],1));
	            		if ($t == ">" && $vercode >$ver )$list[] = $temp;
	    		   		if ($t == "<" && $vercode < $ver )$list[] = $temp;
	    		   		if ($t == "=" && $vercode == $ver )$list[] = $temp;
	            	}else{
	            		$list[] = $temp;
	            	}
	        }
	    }
	    return $list;
	}
	
	 public static function isChannelSPushMsg($app_id,$channel_id,$vercode,$imei=null){
	    $cache = JoyCache::getInstance();
	   	$key = "loadPushNotice_".$app_id;
	    $result = $cache->get($key);
	    $list = array();
	    $time = date("Y-m-d H:i:s");
	    if (!$result) return false;
	    $ip =  JoyManager::getRequest("ip",JoyUtil::getClientIp());
		$ct = JoyUtil::getAddress($ip);
        $count = $ct['country'];
	    foreach($result as $temp){
    	    if ($temp['app_id'] != $app_id ) continue;
    	    if ($time < $temp['start_time'] || $time > $temp['end_time']  ) continue;
    	    unset($temp['enable']);
    	    unset($temp['sort']);
    	    if (!$temp['date_type'])$temp['date_type'] = 0;
    	    if ($temp["player_type"] == 1){//所有玩家
    	    	$data = JoyManager::isData($temp,$channel_id,$vercode,$count);
		        if ($data) $list[] = $temp;
    	    }else if ($temp["player_type"] == 2){//付费玩家
    	    	$data = JoyManager::isData($temp,$channel_id,$vercode,$count);
		        if ($data){
		         	$cache = JoyCache::getInstance();
		        	$key = JoyRank::PUBLIC_USERS_CONSUME_KEY.$app_id;
		        	$uid = JoyManager::getRequest("guid",0);
					$money = $cache->hGet($key,$uid);
		        	if ( $money )$list[] = $temp;
		        }
    	    }else if ($temp["player_type"] == 3){//非付费玩家
		    	$data = JoyManager::isData($temp,$channel_id,$vercode,$count);
		        if ($data){
		         	$cache = JoyCache::getInstance();
		        	$key = JoyRank::PUBLIC_USERS_CONSUME_KEY.$app_id;
		        	$uid = JoyManager::getRequest("guid",0);
					$money = $cache->hGet($key,$uid);
		        	if ( !$money )$list[] = $temp;
		        }
    	    }else if ($temp["player_type"] == 4){//新注册用户
    	    	$data = JoyManager::isData($temp,$channel_id,$vercode,$count);
		         if ($data){
		        	$reg_time = date("Y-m-d",JoyManager::getRequest("regTime",0));
		        	if ($reg_time == date("Y-m-d"))$list[] = $temp;
		        }
    	    }else if ($temp["player_type"] == 5){//非新注册用户
    	    	$data = JoyManager::isData($temp,$channel_id,$vercode,$count);
		        if ($data){
		        	$reg_time = date("Y-m-d",JoyManager::getRequest("regTime",0));
		        	if ($reg_time != date("Y-m-d"))$list[] = $temp;
		        }
    	    }else {//指定玩家
    	     	 $imeis = explode("|",$temp["player_type"]);
    	    	 if ($imeis && is_array($imeis) && in_array($imei,$imeis)){
    	    	 	$list[] = $temp;
    	    	 }
    	    }
	    }
	    return $list;
	}
	
	public static function isData($temp,$channel_id,$vercode,$city){
		$channels = explode("|",$temp["channel_id"]);
		$data = array();
        if ($channels[0] == "no"){
            if (!in_array($channel_id,$channels)){
        		if ($temp["version_code"]){
            		$t =  $temp['version_code']{0};
            		$ver = trim(substr($temp["version_code"],1));
            		if ($t == ">" && $vercode >$ver ) $data = $temp;
    		   		if ($t == "<" && $vercode < $ver ) $data = $temp;
    		   		if ($t == "=" && $vercode == $ver )$data = $temp;
            	}else{
            		$data = $temp;
            	}
            }
        }else{
            if ( $temp['channel_id'] == "all" || (is_array($channels) && in_array($channel_id,$channels)))
    			if ($temp["version_code"]){
            		$t =  $temp['version_code']{0};
            		$ver = trim(substr($temp["version_code"],1));
            		if ($t == ">" && $vercode >$ver )$data =  $temp;
    		   		if ($t == "<" && $vercode < $ver )$data = $temp;
    		   		if ($t == "=" && $vercode == $ver )$data = $temp;
            	}else{
            		$data = $temp;
            	}
        }
        if ($data && $data['map']){
        	$tu = JoyManager::isArea($data,'map',$city);
        	if ( $tu )return $data;
        }else{
        	return $data;
        }
        return null;
	}
	public static function isArea($temp,$key='area',$city){
//		
//		if (!isset($temp[$key])) return false;
//		if (isset($temp[$key]) && empty($temp[$key])) return false;
//		
		if (substr($temp[$key],0,1) == "!"){
    		$t1 = explode(",",substr($temp[$key],1));
            $true = false;
            foreach($t1 as $t){
                if ( strstr($city,$t)) {
                    $true=true;
					break;
                }
            }
            if(!$true){
            	return $temp;
            }
    	}else{
    		$t1 = explode(",",$temp[$key]);
            $true = false;
	        foreach($t1 as $t){
                if ( strstr($city,$t)) {
		            $true = true;
                    break;
                }
            }
	        if ($true)  return $temp;
		}
		return null;
	}
	
	public static function isUserMail($result,$uid,$regTime,$isMoney){
		$data = array();
		foreach($result as $temp){
			$tmp = array();
			switch($temp['player_type']){
				case 1:{
					$tmp = array('id'=>$temp['id'],'title'=>$temp['title'],'content'=>$temp['content'],'type'=>$temp['type'],'value'=>$temp['value'],'icon'=>$temp['icon']);
					break;
				}
				case 2:{
					if ($isMoney) $tmp = array('id'=>$temp['id'],'title'=>$temp['title'],'content'=>$temp['content'],'type'=>$temp['type'],'value'=>$temp['value'],'icon'=>$temp['icon']);
					break;
				}
				case 3:{
					if (!$isMoney) $tmp = array('id'=>$temp['id'],'title'=>$temp['title'],'content'=>$temp['content'],'type'=>$temp['type'],'value'=>$temp['value'],'icon'=>$temp['icon']);
					break;
				}
				case 4:{
					$reg_time = date("Y-m-d",$regTime);
					if ($reg_time == date("Y-m-d")) $tmp = array('id'=>$temp['id'],'title'=>$temp['title'],'content'=>$temp['content'],'type'=>$temp['type'],'value'=>$temp['value'],'icon'=>$temp['icon']);
					break;
				}
				case 5:{
					$reg_time = date("Y-m-d",$regTime);
					if ($reg_time < date("Y-m-d")) $tmp = array('id'=>$temp['id'],'title'=>$temp['title'],'content'=>$temp['content'],'type'=>$temp['type'],'value'=>$temp['value'],'icon'=>$temp['icon']);
					break;
				}
				default:{
					$users = explode("|",$temp['player_type']);
					if (in_array($uid,$users)) $tmp = array('id'=>$temp['id'],'title'=>$temp['title'],'content'=>$temp['content'],'type'=>$temp['type'],'value'=>$temp['value'],'icon'=>$temp['icon']);
					break;
				}
			}
			if ($tmp) $data[] = $tmp;
		}
		return $data;
	}
	
	public static function getRankKey($app_id,$channel_id,$type=0){
		if ($type == 1){
			if ($channel_id >=8000000 && $channel_id <9000000){
				$key = "BearNewTypeRankData_old_ios_".$app_id;
				$allkey = "BearNewTypeRankData_All_old_ios_".$app_id;
			}else{
				$key = "BearNewTypeRankData_old_".$app_id;
				$allkey = "BearNewTypeRankData_All_old_".$app_id;
			}
		}else{
			if ($channel_id >=8000000 && $channel_id <9000000){
				$key = "BearNewTypeRankData_ios_".$app_id;
				$allkey = "BearNewTypeRankData_All_ios_".$app_id;
			}else{
				$key = "BearNewTypeRankData_".$app_id;
				$allkey = "BearNewTypeRankData_All_".$app_id;
			}
		}
		return $key."#".$allkey;
	}
	
	public static function getRankKey2($app_id,$channel_id,$type=0){
//		$cache = JoyCache::getInstance();
//		$uids = $cache->hGet("game_config_new","gameid_shipei");
//		if (isset($uids[$app_id]) && $uids[$app_id]){//重复游戏老用户。
//			$app_id = $uids[$app_id];
//		}
		if ($type == 1){
			if ($channel_id >=8000000 && $channel_id <9000000){
				$key = "BearNewTypeRankDatas_old_ios_".$app_id;
			}else{
				$key = "BearNewTypeRankDatas_old_".$app_id;
			}
		}elseif ($type == 2){
			if ($channel_id >=9000000 && $channel_id <9100000){
				$key = "BearNewTypeRankDatas_tw_".$app_id;
			}else{
				$key = "BearNewTypeRankDatas_".$app_id;
			}
		}else{
			if ($channel_id >=8000000 && $channel_id <9000000){
				$key = "BearNewTypeRankDatas_ios_".$app_id;
			}else{
				$key = "BearNewTypeRankDatas_".$app_id;
			}
		}
		return $key;
	}
	
	public static function getPkKey($app_id,$channel_id,$type=1,$gid=1){
		if ($type == 1){//报名KEY
//			if ($channel_id >=9000000 && $channel_id <9100000){
//				$key = "newGame_group_data_tw_".$app_id;
//			}else
			if ($channel_id >=8000000 && $channel_id <9000000){
				$key = "newGame_group_data_ios_".$app_id;
			}else{
				$key = "newGame_group_data_".$app_id;
			}
		}else if ($type == 2){//报名排行key
//			if ($channel_id >=9000000 && $channel_id <9100000){
//				$key = "newGame_group_data_score_tw_".$app_id;
//			}else
			if ($channel_id >=8000000 && $channel_id <9000000){
				$key = "newGame_group_data_score_ios_".$app_id."_".$gid;
			}else{
				$key = "newGame_group_data_score".$app_id."_".$gid;
			}
		}else if ($type == 3){//报名统计key
//			if ($channel_id >=9000000 && $channel_id <9100000){
//				$key = "BigbearPkUser_count_tw_".$app_id;
//			}else
			if ($channel_id >=8000000 && $channel_id <9000000){
				$key = "BigbearPkUser_count_ios_".$app_id;
			}else{
				$key = "BigbearPkUser_count_".$app_id;
			}
		}else if ($type == 4){//个人PK key
			if ($channel_id >=9000000 && $channel_id <9100000){
				$key = "bigbear_personPk_list_tw_".$app_id;
			}elseif ($channel_id >=8000000 && $channel_id <9000000){
				$key = "bigbear_personPk_list_ios_".$app_id."_".$gid;
			}else{
				$key = "bigbear_personPk_list_".$app_id."_".$gid;
			}
		}else if ($type == 5){//个人PK 随机取对手key
			if ($channel_id >=9000000 && $channel_id <9100000){
				$key = "bigbear_personPk_score_list_tw_".$app_id;
			}elseif ($channel_id >=8000000 && $channel_id <9000000){
				$key = "bigbear_personPk_score_list_ios_".$app_id."_".$gid;
			}else{
				$key = "bigbear_personPk_score_list_".$app_id."_".$gid;
			}
		}else if ($type == 6){//个人PK 随机取对手key
			if ($channel_id >=9000000 && $channel_id <9100000){
				$key = "bigbear_personPk_user_tw_".$app_id;
			}elseif ($channel_id >=8000000 && $channel_id <9000000){
				$key = "bigbear_personPk_user_ios_".$app_id;
			}else{
				$key = "bigbear_personPk_user_".$app_id;
			}
		}else if ($type == 7){//个人PK 每日积分排行
			if ($channel_id >=9000000 && $channel_id <9100000){
				$key = "bigbear_personPk_user_tw_record_".$app_id;
			}elseif ($channel_id >=8000000 && $channel_id <9000000){
				$key = "bigbear_personPk_user_ios_record_".$app_id;
			}else{
				$key = "bigbear_personPk_user_record_".$app_id;
			}
		}
		return $key;
	}
	
	
	public static function getChannelIdByCache($uid){
		$cache = JoyCache::getInstance();
//		$key = "lt_ucenter_channel_id_public_".$uid;
//		$chanelId = $cache->get($key);
		return 1;
	}
	
	public static  function checkKeyWord($word)
    {
    	$cache = JoyCache::getInstance();
        $keys = $cache->get('SENSITIVE_WORDS_LIST');
        foreach($keys as $v)
            $word = str_replace($v , 'xxx' , $word);
        $word = str_replace('"' , "" ,  $word);
        $word = str_replace( "'" ,"" , $word);
        $word = str_replace( "\\" ,"" , $word);
        $word = JoyManager::mySubstr($word,16);
        return $word;
    }
    
	public static  function checkKeyWords($word)
    {
    	$cache = JoyCache::getInstance();
        $keys = $cache->get('SENSITIVE_WORDS_LIST');
        $flag = false;
        foreach($keys as $v){
        	if ($word && trim($v) && stristr($word,trim($v))) return true;
        }
        return $flag;
    }
	
	public static function sendUserMsg($uid,$content,$app_id,$reward="",$type=1,$baomin="",$uuid=1,$title = ""){
		$cache = JoyCache::getInstance();
		if ($uid <0) return;
		$key = "userMessageByUidList_".$app_id."_".$uid;
        $data = $cache->get($key);
        $t = rand(1,100);
        $id = $t.substr(time(),4);
        $temp = array('id'=>$id,"content"=>$content,"title"=>$title,"time"=>date("Y-m-d"),"reward"=>$reward,"type"=>$type,'baomin'=>$baomin,"uuid"=>$uuid);
        $data[] = $temp;
        $cache->set($key,$data,1296000);
        return $data;
	}
	
	public static function sendUserMail($uid,$content,$app_id,$reward="",$title = "",$type=2){
		$cache = JoyCache::getInstance();
		if ($uid <0) return;
		$key = "userMailByUidList_".$app_id."_".$uid;
        $data = $cache->get($key);
        $t = rand(1,100);
        $id = $t.substr(time(),4);
        $temp = array('id'=>$id,"content"=>$content,"title"=>$title,"value"=>$reward,"type"=>$type,'icon'=>"");
        $data[] = $temp;
        $cache->set($key,$data,1296000);
        return $data;
	}
	
	public static function getUserMail($uid,$app_id){
		$cache = JoyCache::getInstance();
		if ($uid <0) return;
		$key = "userMailByUidList_".$app_id."_".$uid;
        $data = $cache->get($key);
        $cache->delete($key);
        return $data;
	}
	
	
	public static function getUserInfo($appid,$uid){
		$cache = JoyCache::getInstance();
		$key = JoyRank::GAME_USERS_INFO_DATA.$appid.'_'.$uid;
		$data = $cache->get($key);
		$table = "user_game_".$appid;
		if (!$data){
			$sql = "select * from $table where appid = $appid and uid = $uid ";
			$result = JoyDb::query($sql);
			if ($result){
				$data = $result[0];
				$data['goods'] =json_decode($data['goods'],true);
				$cache->set($key, $data);
			}else{
				$config = $cache->get(JoyRank::PUBLIC_GAME_CONFIG.$appid);
				$data['level'] = 1;
				$data['uid'] = $uid;
				$data['barriers'] = 1;
				$data['exp'] = 0;
				$data['time'] = time();
				$data['money'] = isset($config['money'])?$config['money']['value']:0;
				$data['energy'] = isset($config['energy'])?$config['energy']['value']:5;
				$data['energy_max'] = isset($config['energy_max'])?$config['energy_max']['value']:5;
				$data['goods'] = isset($config['goods']) && $config['goods']['value']?$config['goods']['value']:array();
				$cache->set($key, $data);
				$sql = "insert into $table(appid,uid,level,exp,money,energy,energy_max,goods,time) values(?,?,?,?,?,?,?,?,?)";
				$params = array($appid,$uid,$data['level'],$data['exp'],$data['money'],$data['energy'],$data['energy_max'],json_encode($data['goods']),$data['time']);
				JoyDb::update($sql, $params);
			}
		}
		return $data;
	}
	
	public function getIosAd($app_id,$macifa){
		$key = "ios_ad_macifa_".$app_id;
		$subkey = md5($macifa);
		$cache = JoyCache::getInstance();
		$user = $cache->hGet($key,$subkey);
//		if (!$user){
//			$sql = 'select dtime,jtime,state from ios_app_ad where macifa="'.$macifa.'"';
//			$data = JoyDb::query($sql);
//			if ($data){
//				$user = array(
//					'dtime'=>$data[0]['dtime'],
//					'jtime'=>$data[0]['jtime'],
//					'state'=>$data[0]['state'],
//				);
//				$cache->hSet($key,$subkey,$user);
//			}
//		}
		return $user;
	}
	
	public static function updateUserInfo($userInfo,$data,$appid){
		if ($data){
			$table = "user_game_".$appid;
			$uid = $userInfo['uid'];
			$sql = "update $table set ";
			$sql1 = ''; 
			$params = array();
			foreach ($data as $key=>$value){
				$userInfo[$key] = $value;
// 				$sql1 .= $key."=?,";
// 				$params[] = $value;
				$sql1 .= $key."= '".$value."',";
			}
			$sql1 = substr($sql1, 0,-1);
			$sql .= $sql1 . " where appid=$appid and uid=$uid ";
// 			JMQClient::writeMQ(JMQClient::DATABASE,JoyConst::MQ_DATABASE,$sql);
			JoyDb::query($sql);
// 			$sql .= $sql1 . " where appid=? and uid=? ";
// 			$params[] = $appid;
// 			$params[] = $uid;
// 			JoyDb::update($sql, $params);
			$cache = JoyCache::getInstance();
			$key = JoyRank::GAME_USERS_INFO_DATA.$appid.'_'.$uid;
			$cache->set($key, $userInfo);
		}
		
		return $userInfo;
	}
	/**
	 * 保存token
	 * 
	 * @param string $token
	 * @param string $uid
	 * @param string $username
	 */
	public static function saveToken($token, $uid) {
		$cache = JoyCache::getInstance();
		$cache->delete($token);
		$uid && $cache->hSet($token, 'uid', $uid, JoyConst::TOKEN_EXPIRED_TIME);
	}
	
	public static function generateToken($uuid){
		$token = "token_".md5($uuid . time());
		$cache = JoyCache::getInstance();
		$cache->set($token,$uuid,180);
		return $token;
	}
	
	public static function addRankData($type,$act,$app_id,$uid,$score,$language,$uuid=null,$gameid=null){
		$cache = JoyCache::getInstance();
		$myrank = array();
		$config = new Yaf_Config_Ini(CONFIG_INI, 'product');
		$filename = $config->source->baseuri."images/rocks_rank/default.png";
		$result['status'] = 1;
		$msg = array();
		switch ($type){
			case 2:{
				if ($score >=$act['score']){
					$key = $app_id.JoyRank::PUBLIC_USERS_PLAN_ACTIVTY.$type;
					$key1 = $app_id.JoyRank::PUBLIC_USERS_PLAN_ACTIVTY_COUNT.$type.date("Ymd");
					$subKey1 = $uid.$type;
					$tt = $cache->hGet($key1, $subKey1);
					$subKey = date("Ymd");
					$data = $cache->hGet($key, $subKey);
						
					!$data?$data=array():"";
					$temp = array('uid'=>$uid,'score'=>$score);
					$data[] = $temp;
					$cache->hSet($key, $subKey, $data);
					if (!$tt){
						$id = date("Ymd").$type;
						$myreward = $cache->get(JoyRank::PUBLIC_USERS_REWARD.$app_id."_".$uid);
						if ($myreward == "[]"){
							$myreward = array();
						}
						$myreward[$id] = array('time'=>date("Y-m-d"),'name'=>$act['name'],'reward'=>$act['reward'][0]);
						$cache->set(JoyRank::PUBLIC_USERS_REWARD.$app_id."_".$uid,$myreward);
						$string = "2|".date("Y-m-d H:i:s")."|".$uid."|".$app_id."|".json_encode($act['reward'][0])."|1";
						WriteLogs::putPlanReward(2, $string);
						$msg[] = "本次积分:".$score.',您已完成目标积分,挑战成功!';
						$cache->hSet($key1, $subKey1,date('Y-m-d'));
						
						//把本周的所有数据保存
						$key3 = 'rank_users_country_week_old'.$app_id.'_'.$language.'_0_2';
						$cache->set($key3,$uid);
						
					}else{
						$msg[] = "本次积分:".$score.',您已完成目标积分,挑战成功!';
					}
						
				}else{
					$msg[]  = "本次积分:".$score.",您距目标奖品还差".($act['score']-$score).",快点复活完成挑战吧!";
				}
				break;
			}
			case 3:{
				$key = $app_id.JoyRank::PUBLIC_USERS_PLAN_ACTIVTY.$type;
				$subKey = "subKey".date("w");
				$data = $cache->hGet($key, $subKey);
				if ($score >=$act['score']){
					!$data?$data=array():"";
					if (isset($data[$uid])){
						$data[$uid]++;
					}else{
						$data[$uid] = 1;
					}
					$cache->hSet($key, $subKey, $data);
					$msg[] = "本次积分:".$score.",完成次数:".$data[$uid].",大奖在即，复活继续完成挑战吧!";
				}else{
					$msg[] = "本次积分:".$score.",您距目标奖品还差".($act['score']-$score).",复活继续完成挑战吧!";
				}
				break;
			}
			case 4:{
				$key = $app_id.JoyRank::PUBLIC_USERS_PLAN_ACTIVTY.$type;
				$subKey = date("Ymd");
				$data = $cache->hGet($key, $subKey);
				$totalS = $act['num'][0];
				$count = count($act['num']);
				if (isset($data[$uid]) && $data[$uid]['level'] && $data[$uid]['level'] <= $count){
					if ($data[$uid]['level'] == $count){
						$msg[] = "本次积分:".$score.",已全部晋级成功,恭喜你!";
					}else{
						$totalS = $act['num'][$data[$uid]['level']];
						if ($score >=$totalS){
							$data[$uid]['level']++;
							$data[$uid]['score'] = $score;
							$cache->hSet($key, $subKey, $data);
						}
						$key1 = $app_id.JoyRank::PUBLIC_USERS_PLAN_ACTIVTY_COUNT.$type.date("Ymd");
						$subKey1 = $uid.$type;
						$tt = $cache->hGet($key1, $subKey1);
						if ($data[$uid]['level'] == $count){
							if (!$tt){
								$id = date("Ymd").$type;
								$myreward = $cache->get(JoyRank::PUBLIC_USERS_REWARD.$app_id."_".$uid);
								if ($myreward == "[]"){
									$myreward = array();
								}
								$myreward[$id] = array('time'=>date("Y-m-d"),'name'=>$act['name'],'reward'=>$act['reward'][0]);
								$cache->set(JoyRank::PUBLIC_USERS_REWARD.$app_id."_".$uid,$myreward);
								$msg[] = "本次积分:".$score.",当前级别:".$data[$uid]['level'].",已全部晋级成功,恭喜你!";
								$string = "4|".date("Y-m-d H:i:s")."|".$uid."|".$app_id."|".json_encode($act['reward'][0])."|1";
								WriteLogs::putPlanReward(4, $string);
								$cache->hSet($key1, $subKey1,date('Y-m-d'));
								
								//把本周的所有数据保存
								$key3 = 'rank_users_country_week_old'.$app_id.'_'.$language.'_0_4';
								$cache->set($key3,$uid);
							}
						}else{
							$msg[] = "本次积分:".$score.",当前级别:".$data[$uid]['level'].",快点复活，迅速晋级赢取50000大奖吧！";
						}
		
					}
				}elseif ($score >=$totalS){
					$data[$uid] = array('uid'=>$uid,'score'=>$score,'level'=>1);
					$cache->hSet($key, $subKey, $data);
					$msg[] = "本次积分:".$score.",当前级别:".$data[$uid]['level'].",快点复活，迅速晋级赢取50000大奖吧！";
				}else{
					$msg[] = "本次积分:".$score.",当前级别:0,快点复活，迅速晋级赢取50000大奖吧！";
				}
				break;
			}
			case 5:{
				// 				$act = $message[$type];
				$key = $app_id.JoyRank::PUBLIC_USERS_PLAN_ACTIVTY.$type."_".date("w");
				$user = UserModel::find($uid);
				$city_list = $user->city?json_decode($user->city,true):array();
				if (isset($city_list[$app_id]) && $city_list[$app_id]){
					$country = $city_list[$app_id];
				}
				$subKey = $country;
				$data = $cache->hGet($key, $subKey);
				if (isset($data[$uid]) && $score >$data[$uid]){
					$data[$uid] = $score;
					$cache->hSet($key, $subKey, $data);
				}elseif (!isset($data[$uid])){
					$data[$uid] = $score;
					$cache->hSet($key, $subKey, $data);
				}
// 				$myscore = array_sum($data);
				$alltearm = $cache->hGetAll($key);
				if ($alltearm){
					foreach ($alltearm as $key=>$temp){
						$temp = json_decode($temp,true);
						$tscore[$key] = array_sum($temp);
					}
					arsort($tscore);
				}
				$fscore = array_shift ($tscore);
				$msg[] = "本次积分:".$score.",您的积分可能影响整个团组的胜败，复活为我的团长我的团而战吧！";
				break;
			}
			case 6:{
				// 				$act = $message[$type];
				$key = $app_id.JoyRank::PUBLIC_USERS_PLAN_ACTIVTY.$type."_".date("Ymd");
				$time = date("i");
				if ($time > 30){
					$ltime = 60-$time;
					$time = date('H',strtotime(" +1 hour"))."00";
				}else{
					$ltime = 30-$time;
					$time = date('H')."30";
				}
				$subKey = $time;
		
				$data = $cache->hGet($key, $subKey);
				if (isset($data[$uid]) && $score >$data[$uid]){
					$data[$uid] = $score;
				}elseif(!isset($data[$uid])){
					$data[$uid] = $score;
				}
				$cache->hSet($key, $subKey, $data);
				$msg[] = "本次积分:".$score.",离本回合结算时间还有:".$ltime."分钟,马上复活,赢取本回合奖品!";
				break;
			}
			default:{
				$allkey = JoyRank::RANK_USERS_LIST_ALL.$app_id.'_'.$language;
				$alldata = $cache->hGet($allkey,$uid);
				$flag = false;
				if ($score > intval($alldata)){
					$alldata = $score;
					$cache->hSet($allkey,$uid,$alldata);
					$flag = true;
				}
				$user = UserModel::find($uid);
				if (is_numeric($user->city)){
					$user->city = "";
				}
		
				$city_list = $user->city?json_decode($user->city,true):array();
				if (isset($city_list[$app_id]) && $city_list[$app_id]){
					$country = $city_list[$app_id];
					$key = JoyRank::RANK_USERS_LIST.$app_id.'_'.$language;
					$data = $cache->hGet($key, $country);
					//全省排名
					if (count($data) < JoyRank::RANK_USERS_COUNT && $flag){
						$data[$uid] =  $score;
						arsort($data);
						$cache->hSet($key, $country,$data);
						$uidlist = array_keys($data);
						$rank = array_search($uid, $uidlist);
					}else{
						$lastUser = array_slice($data, -1,1);
						if ($score > $lastUser[0] && $flag){
							array_pop($data);
							$data[$uid] =  $score;
							arsort($data);
							$cache->hSet($key, $country,$data);
							$uidlist = array_keys($data);
							$rank = array_search($uid, $uidlist);
						}
					}
				}
		
				//全国排名
				$key_country = JoyRank::RANK_USERS_COUNTRY.$app_id.'_'.$language;
				$data_country = $cache->get($key_country);
				$lastUser = array_slice($data_country, -1,1);
				$rank = 50 + ($lastUser[0]-$score)/10+1;
				$myrank = array('rank'=>$rank,'uid'=>$uid,'score'=>intval($alldata),'name'=>$user->nickname);
				if (count($data_country) < JoyRank::RANK_USERS_COUNT){
					$key_1 = JoyRank::PUBLIC_USERS_CONSUME_KEY.$app_id;
					$payflag = $cache->hGet($key_1,$uid);
					if ($flag && $payflag){
						$data_country[$uid] =  $score;
						arsort($data_country);
						$cache->set($key_country,$data_country);
					}
					$uidlist = array_keys($data_country);
					$rank = array_search($uid, $uidlist);
					$myrank = array('rank'=>$rank+1,'uid'=>$uid,'score'=>intval($data_country[$uid]),'name'=>$user->nickname);
				}else{
					if ($score > $lastUser[0]){
						$key_1 = JoyRank::PUBLIC_USERS_CONSUME_KEY.$app_id;
						$payflag = $cache->hGet($key_1,$uid);
						if ($flag && $payflag){
							array_pop($data_country);
							$data_country[$uid] =  $score;
							arsort($data_country);
							$cache->set($key_country,$data_country);
						}
						$uidlist = array_keys($data_country);
						$rank = array_search($uid, $uidlist);
						$myrank = array('rank'=>$rank+1,'uid'=>$uid,'score'=>intval($data_country[$uid]),'name'=>$user->nickname);
					}
				}
				$end = $lastUser[0] - $score;
				if ($myrank){
					if ($myrank['rank'] < 21){
						$msg[] = "您当前是".$score."分,您即将拿到目标奖品,快点复活保持更高记录吧!";
					}else{
						$msg[] = "您当前是".$score."分,您距离目标奖品还差".$end."分,快点复活继续冲刺吧!";
					}
				}
				$filename = $config->source->baseuri."images/rocks_rank/goods.png";
			}
		}
		$result['data']= array('msg'=>$msg,'myrank'=>$myrank,'url'=>$filename);
		return $result;
	}
	

	
	public static function addEventData($type,$act,$app_id,$uid,$score,$userInfo,$language){
		$cache = JoyCache::getInstance();
		$msg = '';
		$result['status'] = 1;
		switch ($type){
			case 2:{
				if ($score >=$act['score']){
					$key = $app_id.JoyRank::PUBLIC_USERS_PLAN_ACTIVTY.$type;
					$key1 = $app_id.JoyRank::PUBLIC_USERS_PLAN_ACTIVTY_COUNT.$type.date("Ymd");
					$subKey1 = $uid.$type;
					$tt = $cache->hGet($key1, $subKey1);
					$subKey = date("Ymd");
					$data = $cache->hGet($key, $subKey);
	
					!$data?$data=array():"";
					$temp = array('uid'=>$uid,'score'=>$score);
					$data[] = $temp;
					$cache->hSet($key, $subKey, $data);
					if (!$tt){
						$id = date("Ymd").$type;
						$myreward = $cache->get(JoyRank::PUBLIC_USERS_REWARD.$app_id."_".$uid);
						$myreward[$id] = array('time'=>date("Y-m-d"),'name'=>$act['name'],'reward'=>$act['reward'][0]);
						$cache->set(JoyRank::PUBLIC_USERS_REWARD.$app_id."_".$uid,$myreward);
						$string = "2|".date("Y-m-d H:i:s")."|".$uid."|".$app_id."|".json_encode($act['reward'][0])."|1";
						WriteLogs::putPlanReward(2, $string);
						$msg = '挑战成功!奖品已发放,请查收.';
						$cache->hSet($key1, $subKey1,date('Y-m-d'));
						//给玩家发放奖励
						$userInfo = JoyManager::addEventReward($userInfo, $act, $language, $app_id, $cache);
					}else{
						$msg = '你已超越目标积分,挑战成功!';
					}
	
				}else{
					$msg = "你距目标奖品还差".($act['score']-$score).",继续加油!";
				}
				break;
			}
			case 4:{
				$key = $app_id.JoyRank::PUBLIC_USERS_PLAN_ACTIVTY.$type;
				$subKey = date("Ymd");
				$data = $cache->hGet($key, $subKey);
				$totalS = $act['num'][0];
				$count = count($act['num']);
				if (isset($data[$uid]) && $data[$uid]['level'] && $data[$uid]['level'] <= $count){
					if ($data[$uid]['level'] == $count){
						$msg = "当前晋级:".$data[$uid]['level']."挑战晋级任务完成";
					}else{
						$totalS = $act['num'][$data[$uid]['level']];
						if ($score >=$totalS){
							$data[$uid]['level']++;
							$data[$uid]['score'] = $score;
							$cache->hSet($key, $subKey, $data);
						}
						$key1 = $app_id.JoyRank::PUBLIC_USERS_PLAN_ACTIVTY_COUNT.$type.date("Ymd");
						$subKey1 = $uid.$type;
						$tt = $cache->hGet($key1, $subKey1);
						if ($data[$uid]['level'] == $count){
							if (!$tt){
								$id = date("Ymd").$type;
								$myreward = $cache->get(JoyRank::PUBLIC_USERS_REWARD.$app_id."_".$uid);
								$myreward[$id] = array('time'=>date("Y-m-d"),'name'=>$act['name'],'reward'=>$act['reward'][0]);
								$cache->set(JoyRank::PUBLIC_USERS_REWARD.$app_id."_".$uid,$myreward);
								$msg = "当前晋级:".$data[$uid]['level']."挑战成功!奖品已发放,请查收.";
								$string = "4|".date("Y-m-d H:i:s")."|".$uid."|".$app_id."|".json_encode($act['reward'][0])."|1";
								WriteLogs::putPlanReward(4, $string);
								$cache->hSet($key1, $subKey1,date('Y-m-d'));
	
								//给玩家发放奖励
								$userInfo = JoyManager::addEventReward($userInfo, $act, $language, $app_id, $cache);
							}
						}else{
							$msg = "当前晋级:".$data[$uid]['level']."下一级目标:".$act['num'][$data[$uid]['level']];
						}
	
					}
				}elseif ($score >=$totalS){
					$data[$uid] = array('uid'=>$uid,'score'=>$score,'level'=>1);
					$cache->hSet($key, $subKey, $data);
					$msg = "当前晋级:".$data[$uid]['level']."下一级目标:".$act['data'][$data[$uid]['level']];
				}else{
					$msg= "当前晋级:0"."下一级目标:".$act['data'][0];
				}
				break;
			}
		}
		
		$result['msg'] = $msg;
		$result['data']['userinfo'] = $userInfo;
		return $result;
	}
	
	
	public static function addEventReward($userInfo,$act,$language,$app_id,$cache){
		$reward = $act['reward'][0];
		$data = array();
		if ($language == "zh"){
			$msg = $act['name']."活动中，获得: ";
		}else{
			$msg = $act['name']."活动中，获得: ";
		}
		if (isset($reward['money']) && $reward['money']){
			$data['money'] = $userInfo['money'] + $reward['money'];
			if ($language == "zh"){
				$msg .= " 游戏币+" .$reward['money'];
			}else{
				$msg .= " moeny+" .$reward['money'];
			}
		}
		if (isset($reward['flower']) && $reward['flower']){
			$data['energy'] = $userInfo['energy'] + $reward['flower'];
			
			if ($language == "zh"){
				$msg .= " 精力点+" .$reward['money'];
			}else{
				$msg .= " energy+" .$reward['money'];
			}
			
		}
		if (isset($reward['goods']) && $reward['goods']){
			$expList = explode(",", $reward['goods']);
			$data['goods'] = $userInfo['goods'];
			foreach ($expList as $value){
				list($key,$temp) = explode("_", $value);
				$shop_goods =  $cache->hGet(JoyRank::PUBLIC_GAME_SHOP.$app_id,$key);
				if ($language == "zh"){
					$msg .= " ".$shop_goods['name']."*" .$temp;
				}else{
					$msg .= " ".$shop_goods['name']." *" .$temp;
				}
				if (isset($userInfo['goods'][$key]) && $userInfo['goods'][$key]){
					$data['goods'][$key] += $temp;
				}else{
					$data['goods'][$key] =  $temp;
				}
			}
		}
		$userInfo = JoyManager::updateUserInfo($userInfo,$data,$app_id);
		$id = time();
		$fuserMessage = $cache->get(JoyRank::PUBLIC_GAME_USER_MESSAGE.$app_id.'_'.$userInfo['uid']);
		$fuserMessage[$id] = array('id'=>$id,'type'=>4,'content'=>$msg,'fuid'=>$userInfo['uid']);
		$cache->set(JoyRank::PUBLIC_GAME_USER_MESSAGE.$app_id.'_'.$userInfo['uid'],$fuserMessage);
		return $userInfo;
	}
	
	/**
	 * 取得token保存的对象
	 * @param string $token
	 * @param string $key uid|user_name
	 * @return string
	 */
	public static function getToken($token, $key) {
		$cache = JoyCache::getInstance();
		$value = $cache->hGet($token, $key);
		return $value;
	}
	
	/**
	 * 取得token保存的对象
	 * @param string $token
	 * @param string $key uid|user_name
	 * @return string
	 */
	public static function getAllToken() {
		if(!isset($_REQUEST['token'])) {
			$result['status'] = JoyConst::FAILURE_TOKEN_EMPTY;
			$result['msg'] = 'auth failed.';
			exit(json_encode($result));
		}
		$token = $_REQUEST['token'];
		$cache = JoyCache::getInstance();
		$value = $cache->hGetAll($token);
		return $value;
	}
	
	/**
	 * 取得分表后的实表
	 * Enter description here ...
	 * @param string $table_prefix
	 * @param int $uid
	 * @param int $mod
	 * @return string
	 */
	public static function getTable($table_prefix, $uid, $mod = 4) {
		return $table_prefix.'_'.($uid % $mod);
	}
	
	/**
	 * 取得完整的avatar路径
	 * @param string $filename ex:1353037514093.png
	 * @return string ex:http://base_url/1353037514093.png
	 */
	public static function getAvatar($filename, $config = null) {
		if(empty($filename)) {
			return '';
		}
		$config || $config = new Yaf_Config_Ini(CONFIG_INI, 'product');
		return $config->avatar->baseuri . $filename;
	}
	
	/**
	 * 取得完整的avatar路径
	 * @param string $filename ex:1353037514093.png
	 * @return string ex:http://base_url/1353037514093.png
	 */
	public static function getRewardImage($rank,$appid=null, $max_count = 23) {
		$cache = JoyCache::getInstance();
		$data = $cache->get("loadRocksRank");
		$reward = $data[$appid];
		$count = count($data[$appid]);
		$filename = "";
		if ($rank <= $max_count){
			if ($rank > $count){
				$filename = $reward[$count]['iconUrl'];
			}else{
				$filename = $reward[$rank]['iconUrl'];
			}
		}

		return $filename;
	}
	
	/**
	 * 验证充值IP是否合法
	 */
	public static function authChargeIp() {
		$ip = JoyUtil::getIp();
		if(!in_array($ip, JoyConst::$charge_white_ip)) {
			exit(0);
		}
	}
	
	public static  function friends($uid){
		$cache = JoyCache::getInstance();
		$friend_id = array();
		$friend = $cache->get(JoyConst::FRIENDS_LIST.$uid);
		if ($friend){
			$friend_id = array_keys($friend);
		}else{
			$db = JoyDb::getInstance();
			$table_name = JoyManager::getTable('friend', $uid);
			$sql = "select friend_uid from {$table_name} where uid = '".$uid."' order by id desc ";
			$data = JoyDb::query($sql);
			$frineds = array();
			if ($data){
				foreach ($data as $temp){
					$friend_id[] = $temp['friend_uid'];
					$frineds[$temp['friend_uid']] = 1;
				}
			}
			$cache->set(JoyConst::FRIENDS_LIST.$uid,$frineds);
		}
		return $friend_id;
	}
	
	public static  function reduceCoin($user,$coin,$appid,$goods_id,$type,$channel_id){
		if ( $coin >0){
			if ( $user->coin <$coin){
				$result['status'] = 0;
				$result['msg'] = 'coin is not enough';
				exit(json_encode($result));
			}
			
			$sql = 'insert into use_coin_log(uid,coin,total_coin,time,type,appid,goods_id,channel_id) values('.$user->id.','.$coin.','.$user->coin.',"'.date('Y-m-d H:i:s').'","'.$type.'",'.$appid.','.$goods_id.',"'.$channel_id.'")';
// 			JMQClient::writeMQ(JMQClient::DATABASE,JoyConst::MQ_DATABASE,$sql);
			JoyDb::query($sql);
			$user->coin -= $coin;
			$user->coin < 0 && $user->coin = 0;
			$user->save();
		}
		return $user->coin;
	}
	
	
	public static  function getLanguage(){
		$config = new Yaf_Config_Ini(CONFIG_INI, 'product');
		$languageList = $config->language->list;
		$moren = $config->language->moren;
		if ($moren == 'zh'){
			return $moren;
		}
		$languageList = explode(",", $languageList);
		$language = strtolower(isset($_REQUEST['language'])?$_REQUEST['language']:$moren);
		if (!in_array($language, $languageList)){
			$language = $moren;
		}
		return $language;
	}
	
	public static function upLevel($userInfo,$appid,$exp,$ispass = 0,$money=0,$barriers= 1){
		$cache = JoyCache::getInstance();
		$data = array();
		$data['goods'] = $userInfo['goods'];
		$data['money'] = $userInfo['money'];
		if ($exp){
			$levle = $userInfo['level'];
			$exp +=  $userInfo['exp'];
			$expList = $cache->hGet(JoyRank::PUBLIC_GAME_EXP.$appid,$levle);
			while ($exp  >= $expList['exp']){
				$levle++;
				$exp -= $expList['exp'];
				$expList = $cache->hGet(JoyRank::PUBLIC_GAME_EXP.$appid,$levle);
				if (!$expList){
					$result['status'] = 0;
					$result['msg'] = 'level is max!';
					exit(json_encode($result));
				}
				//升级处理
				if ($levle > $userInfo['level'] ){
					//升级时给玩家加游戏币
					$data['money'] += $expList['money'];
					//升级时给玩家加物品
					if (isset($expList['goods_add']) && $expList['goods_add']){
						foreach ($expList['goods_add'] as $key=>$temp){
							if (isset($userInfo['goods'][$key]) && $userInfo['goods'][$key]){
								$data['goods'][$key] += $temp;
							}else{
								$data['goods'][$key] =  $temp;
							}
						}
							
					}
					//升级时给玩家减物品
					if (isset($expList['goods_pl']) && $expList['goods_pl']){
						foreach ($expList['goods_pl'] as $key=>$temp){
							if (isset($userInfo['goods'][$key]) && $userInfo['goods'][$key] >= $temp){
								$data['goods'][$key] -= $temp;
								if ($data['goods'][$key] <= 0){
									unset($data['goods'][$key]);
								}
							}
						}
					}
					//升级时给玩家恢复体力值
					if ($userInfo['energy'] < $userInfo['energy_max']){
						$data['energy'] = $userInfo['energy_max'];
					}
				}
			}
			$data['level'] = $levle;
			$data['exp'] = $exp;
		}
		$data['money'] += $money;
		if ($ispass && $barriers >= $userInfo['barriers']){
			$data['barriers'] = $barriers + 1;
		}
		$userInfo = JoyManager::updateUserInfo($userInfo,$data,$appid);
		return $userInfo;
	}
	
	public static function strlen_utf8($str) {
		$i = 0;
		$count = 0;
		$len = strlen ($str);
		while ($i < $len) {
			$chr = ord ($str[$i]);
			$count++;
			$i++;
			if($i >= $len) break;
			if($chr & 0x80) {
				$chr <<= 1;
				while ($chr & 0x80) {
					$i++;
					$chr <<= 1;
				}
			}
		}
		return $count;
	}
}
