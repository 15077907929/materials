<?php
function showmessage($message,$url_forward='',$msgtype='message'){
	if($msgtype=='form'){
		
	}elseif($msgtype=='close'){
		
	}else{
		if($url_forward){
			$message.='<br/><a href="'.$url_forward.'">如果您的浏览器没有自动跳转，请点击这里</a>';
		}
	}
	exit($message);
}

function message($C_alert,$I_goback=''){
	if(!empty($I_goback)){
		echo '<script type="text/javascript">window.location.href='.$I_goback.'</script>';
	}else{
		echo '<script type="text/javascript">alert("'.$C_alert.'")</script>';
	}
}

//防sql注入函数
function sql_injection($content){
	if(!get_magic_quotes_gpc()){
		if(is_array($content)){
			foreach($content as $key=>$value){
				$content[$key]=addcslashes($value);
			}
		}else{
			addcslashes($content);
		}
	}
	return $content;
}

//获取客户端ip
function getip(){
	if(isset($_SERVER)){
		if(isset($_SERVER['HTTP_X_FORWARDER_FOR'])){
			$realip=$_SERVER['HTTP_X_FORWARDER_FOR'];
		}elseif(isset($_SERVER['HTTP_CLIENT_IP'])){
			$realip=$_SERVER['HTTP_CLIENT_IP'];
		}else{
			$realip=$_SERVER['REMOTE_ADDR'];
		}
	}else{
		if(getenv('HTTP_X_FORWARDER_FOR')){
			$realip=getenv('HTTP_X_FORWARDER_FOR');
		}elseif(getenv('HTTP_CLIENT_IP')){
			$realip=getenv('HTTP_CLIENT_IP');
		}else{
			$realip=getenv('REMOTE_ADDR');
		}
	}
	return $realip;
}

//后台管理记录
function getlog(){
	global $db,$table_adminlog;
	if(isset($_POST['action'])){
		$action=$_POST['action'];
	}elseif(isset($_GET['action'])){
		$action=$_GET['action'];
	}
	if(isset($action)){
		$script=getenv('REQUEST_URI');
		$db->query('insert into '.$table_adminlog.' set action=\''.htmlspecialchars(trim($action)).'\',script=\''.htmlspecialchars(trim($script)).'\',date='.time().',ip='.ip2long(getip()));
	}
}

//后台成功登录记录
function loginsucceed($username='',$password=''){
	global $db,$table_loginlog;
	$extra.='script:'.getenv('REQUEST_URI');
	$db->query('insert into '.$table_loginlog.' set username=\''.$username.'\',password=\'密码正确\',date='.time().',ip='.ip2long(getip()).',result=1');
}

//后台失败登录记录
function loginfail($username='',$password=''){
	global $db,$table_loginlog;
	$extra.='script:'.getenv('REQUEST_URI');
	$db->query('insert into '.$table_loginlog.' set username=\''.$username.'\',password=\'密码错误\',date='.time().',ip='.ip2long(getip()).',result=2');
}

function getpagenav($results,$address){
	
}
?>