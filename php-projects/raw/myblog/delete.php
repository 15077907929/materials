<?php
session_start();
$ok=false;

if(empty($_SESSION['user'])||$_SESSION['user']!='admin'){
	echo '请<a href="login.php">登录</a>后执行该操作。';
	exit;
}

if(!isset($_GET['entry'])){
	if(!isset($_POST['id'])){
		$ok=true;
		$msg='请求参数有误！<a href="index.php">返回首页</a>';
	}else{
		$path=substr($_POST['id'],0,6);
		$entry=substr($_POST['id'],7,9);
		$file_name='contents/'.$path.'/'.$entry.'.txt';
		if(unlink($file_name)){
			$ok=true;
			$msg='该日志成功删除！<a href="index.php">返回首页</a>';
		}else{
			$ok=true;
			$msg='该日志成功失败！<a href="index.php">返回首页</a>';
		}	
	}
}else{
	$form_data='';
	$path=substr($_GET['entry'],0,6);
	$entry=substr($_GET['entry'],7,9);
	$file_name='contents/'.$path.'/'.$entry.'.txt';
	if(file_exists($file_name)){
		$form_data='<input type="hidden" name="id" value="'.$_GET['entry'].'" />';
	}else{
		$ok=true;
		$msg='所要删除的日志不存在！<a href="index.php">返回首页</a>';
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
		if(edit.title.value==''){
			alert("标题不能为空！");
			return false;
		}
		if(edit.content.value==''){
			alert("内容不能为空！");
			return false;
		}
		return true;
	}
</script>
</head>
<body>
<div class="container">
	<div class="header">
		<h1>我的BLOG</h1>
	</div>
	<div class="title">
		----I have a dream....
	</div>
	<div class="left">
		<div class="blog_entry">
			<div class="blog_title">删除日志</div>
			<div class="blog_body">
			<?php
			if($ok==false){
			?>
				<div class="blog_date"></div>
				<form name="delete" method="POST" action="delete.php">
					<font color="red">删除的日志将无法恢复，确定要删除吗？</font><br/>
					<input type="submit" value="确定" />
					<?php echo $form_data; ?>
				</form>
			<?php
			}else{
				echo $msg;
			}
			?>
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

