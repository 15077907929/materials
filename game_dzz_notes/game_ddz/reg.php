<?php
	error_reporting(0);
	include'dbconnect.php';
?>
<!doctype html>
<html>
<head>
<meta http-equiv='content-type' content='text/html;charset=utf-8'/>
<meta name="keyword" content="ddz" />
<meta name="description" content="ddz" />
<link type="text/css" rel="stylesheet" href="css/style.css" />
<title>注册</title>
</head>
<body>
<div class="message">
	<?php
		if(isset($_COOKIE['message'])){
		echo $_COOKIE['message'];
		setcookie('message',null);
		}
	?>
</div>
<form name="reg_form" class="reg_form" action="reg_ok.php" method="post">
    <table>
		<tr>
			<td class="hd">账号:</td>
			<td><input size="28" type="name" name="name" /></td>
		</tr>
		<tr>
			<td class="hd">密码:</td>
			<td><input size="28" type="password" name="password" /></td>
		</tr>		
		<tr>
			<td class="hd">确认密码:</td>
			<td><input size="28" type="password" name="password_r" /></td>
		</tr>		
		<tr>
			<td></td>
			<td class="sub_td">
				<input class="sub_btn" type="submit" name="sub" value="注册" />
				<input class="sub_btn" type="reset" name="res" value="重置" />
			</td>
		</tr>
    </table>
</form>
</body>
</html>