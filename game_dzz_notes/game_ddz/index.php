<?php
	error_reporting(0);
    include'dbconnect.php';
    if($player_name!='' && $play_name!='guest'){
        header('location:hall.php');
	exit;
    }	
?>
<!doctype html>
<html>
<head>
<meta http-equiv='content-type' content='text/html;charset=utf-8'/>
<meta name="keyword" content="ddz" />
<meta name="description" content="ddz" />
<link type="text/css" rel="stylesheet" href="css/style.css" />
<title>开心斗地主|在线斗地主</title>
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
<div class="p">开心斗地主</div>
<form class="login_form" name="login" method="post" action="login.php">
    <table>
	<tr>
	    <td class="hd">账 号:</td>
	    <td><input size="28" type="text" name="name" /></td>
	</tr>
	<tr>
	    <td class="hd">密 码:</td>
	    <td><input size="28" type="password" name="password" /></td>
	</tr>
	<tr>
	    <td></td>
	    <td class="sub_td">
		<input class="sub_btn" type="submit" name="sub" value="登录" />
	   	<a href="reg.php"><b>注册</b></a>
	    </td>
	</tr>
    </table>
</form>
<div class="footer">
    技术支持 && 版权	
</div>
</body>
</html>
