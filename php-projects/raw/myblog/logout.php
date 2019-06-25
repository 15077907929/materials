<?php
session_start();
$info='';
if(isset($_SESSION['user'])){
	$_SESSION['user']='';
	$msg='您已经成功退出，<a href="index.php">返回首页</a>';
}else{
	$msg='您未曾登录或已经超时退出，<a href="index.php">返回首页</a>';
}
?>
<!doctype html>
<html>
<head>
<title>BLOG</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
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
			<div class="blog_title">退出登录</div>
			<div class="blog_body">
				<?php echo $msg; ?>
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

