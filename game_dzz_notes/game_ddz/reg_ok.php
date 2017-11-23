<?php
	error_reporting(0);
	include'dbconnect.php';
	if($_POST['name']&&$_POST['password']&&$_POST['password_r']){
		if($_POST['password']!=$_POST['password_r']){
			message('两次输入的密码不一致，请重新填写','reg.php');
		}
		$sql=mysql_query('select count(*) as num from user_ddz where name=\''.$_POST['name'].'\'');
		if(mysql_result($sql,0,'num')){
			message('抱歉，账号'.$_POST['name'].'已经存在','reg.php');
		}
		$query=mysql_query('insert into user_ddz set name=\''.$_POST['name'].'\',password=\''.md5($_POST['password']).'\'');
		if($query){
			message('注册成功，请登录游戏！','index.php');
		}else{
			echo 'insert into user_ddz set name=\''.$_POST['name'].'\',password=\''.md5($_POST['password']).'\'';
			echo '注册失败';
		}
	}else{
		message('资料填写不完整','reg.php');
	}
?>