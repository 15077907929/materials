<?php
session_start();
$ok=false;
if(!isset($_GET['entry'])){
	echo '请求参数错误';
	exit;
}
if(empty($_SESSION['user'])||$_SESSION['user']!='admin'){
	echo '请<a href="login.php">登录</a>后执行该操作。';
	exit;
}

$path=substr($_GET['entry'],0,6);
$entry=substr($_GET['entry'],7,9);
$file_name='contents/'.$path.'/'.$entry.'.txt';

if(file_exists($file_name)){
	$fp=fopen($file_name,'r');
	if($fp){
		flock($fp,LOCK_SH);
		$result=fread($fp,filesize($file_name));
	}
	flock($fp,LOCK_UN);
	fclose($fp);
	
	$content_array=explode('$|$',$result);
}

if(isset($_POST['title'])&&isset($_POST['content'])){
	$title=trim($_POST['title']);
	$content=trim($_POST['content']);
	if(file_exists($file_name)){
		$blog_temp=str_replace($content_array[0],$title,$result);
		$blog_str=str_replace($content_array[2],$content,$blog_temp);
	}

	$fp=fopen($file_name,'w');
	if($fp){
		flock($fp,LOCK_SH);
		$result=fwrite($fp,$blog_str);
		$lock=flock($fp,LOCK_UN);
		fclose($fp);
	}
	
	if(strlen($result)>0){
		$ok=true;
		$msg='日志修改成功<a href="post.php?entry='.$_GET['entry'].'">查看该日志文章</a>';
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
		BLOG名称
	</div>
	<div class="title">
		----I have a dream....
	</div>
	<div class="left">
		<div class="blog_entry">
			<div class="blog_title">添加一篇新日志</div>
			<div class="blog_body">
			<?php
			if($ok==false){
			?>
				<div class="blog_date"></div>
				<form name="edit" method="POST" action="edit.php?entry=<?php echo $_GET['entry']; ?>" onsubmit="return check();">
					<table>
						<tr><td>日志标题：</td></tr>
						<tr><td><input type="text" name="title" size="50" value="<?php echo $content_array[0]; ?>" /></td></tr>
						<tr><td>日志内容：</td></tr>
						<tr><td><textarea name="content" cols="49" rows="10"><?php echo $content_array[2]; ?></textarea></td></tr>
						<tr><td>创建于：<?php echo date('Y-m-d H:i:s',$content_array[1]); ?></td></tr>
						<tr><td><input type="submit" value="提交" /></td></tr>
					</table>
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

