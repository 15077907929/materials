<?php
include("config/auth.php");
session_start();
if(isset($_POST['user'])&&isset($_POST['passwd'])){
	$user=trim($_POST['user']);
	$passwd=trim($_POST['passwd']);
	$passwd=md5($passwd);
	echo $passwd;
	if($user!=$auth['user']||$passwd!=$auth['passwd']){
		echo '<strong><font color="red">用户名或密码错误！</font></strong>';
	}else{
		$_SESSION['user']=$user;
		header('location:index.php');
	}
}
?>
<!doctype html>
<html>
<head>
<title>基于文本的简易BLOG</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript">
	function check(){
		if(login.user.value==''){
			alert("用户名不能为空！");
			return false;
		}
		if(login.passwd.value==''){
			alert("密码不能为空！");
			return false;
		}
		return true;
	}
</script>
</head>
<body>
<div class="container">
	<div class="header">
		BLOG名称
	</div>
	<div class="title">
		----I have a dream....
	</div>
	<div class="left">
		<div class="blog_entry">
			<div class="blog_title">添加一篇新日志</div>
			<div class="blog_body">
				<div class="blog_date"></div>
				<form name="login" method="POST" action="login.php" onsubmit="return check();">
					<table>
						<tr><td>用户名称：</td></tr>
						<tr><td><input type="text" name="user" size="15" /></td></tr>
						<tr><td>用户密码：</td></tr>
						<tr><td><input type="password" name="passwd" size="15" /></td></tr>
						<tr><td><input type="submit" value="登录" /></td></tr>
					</table>
				</form>
			</div>
		</div>
	</div>
	<div class="right">
		<div class="sidebar">
			<div class="menu_title">关于我</div>
			<div class="menu_body">我是个PHP爱好者</div>
		</div>
	</div>
	<div class="footer">
		CopyRight 2019
	</div>
</div>
</body>
</html>

