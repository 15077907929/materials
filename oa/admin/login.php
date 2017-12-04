<?php
/***************巢湖市槐林中学***************/
$action=$_GET['action'];
if($action=='login'){
	$referer=$referer?$referer:'index.php';
	//检查验证码是否输入正确
	if($_COOKIE['code']!=$_POST['chknumber']){
		$success='{success:false,msg:\'验证码错误\'}';
		echo $success;
		exit;
	}
	
	//格式化输入的账号和密码，并读取用户信息
	$username=$_POST['username'];
	$password=$_POST['password'];
	$username=addslashes($username);
	$password=addslashes($password);
	$password=md5($password);
	//验证是否为需要验证的用户
	$query='select * from members where username=\''.$username.'\' and groupid=99';
	$result=$db->query($query);
	//检测是否为教师账号
	if($db->num_rows($result)!=0){
		$success='success:false:"您需要管理员审核以后才能登入，请与管理员联系"';
		loginfail($username);
		echo $success;
		exit;
	}
	//检测是否为教师账号
	$query='select * from members where username=\''.$username.'\' and password=\''.$password.'\' and groupid<5';
	$result=$db->query($query);
	if($db->num_rows($result)!=0){
		$row=$db->fetch_array($result);
		$user_id=$row['id'];	//用户idzhi
		$system_id=1;	//系统id值
		$user_system_id=$user_id.'|'.$system_id;	//用户和系统id值

		$_SESSION['user_system_id']=$user_system_id;
		$success='{success:true}';
		//保留cookietime sessionid
		$cookietime=$_POST['cookietime'];
		if($cookietime>0){
			$cookietime=86400*$cookietime+time();
			$sid=md5(uniqid(rand()));
			session_id($sid);
			setcookie('sid',$sid,$cookietime);
		}
		loginsucceed($username);
	}else{
		//账号密码不匹配
		$success='{success:false,msg:\'账号或密码输入不对\'}';
		loginfail($username);
	}
	echo $success;
	header('location:index.php');
}elseif($action=='logout'){
	
}else{
	$tpl->assign(array('keywords'=>$sitekeywords,'description'=>$sitedescription));
	$tpl->display('login.html');
}
?>