<?php
$ok=true;
if(isset($_POST['title'])&&isset($_POST['content'])){
	$ok=true;
	$title=trim($_POST['title']);
	$content=trim($_POST['content']);
	$date=time();
	$blog_str=$title.'$|$'.$date.'$|$'.$content;
	
	$ym=date('Ym',time());
	$d=date('d',time());
	$time=date('His',time());
	$folder='contents/'.$ym;
	$file=$d.'-'.$time.'.txt';
	$filename=$folder.'/'.$file;
	$entry=$ym.'-'.$d.'-'.$time;
	if(file_exists($folder)==false){
		if(!mkdir($folder)){
			$ok=false;
			$msg='<font color="red">创建目录异常，添加日志失败</font>';
		}
	}
	$fp=fopen($filename,'w');
	if($fp){
		flock($fp,LOCK_SH);
		$result=fwrite($fp,$blog_str);
		$lock=flock($fp,LOCK_UN);
		fclose($fp);
	}
	if(strlen($result)>0){
		$ok=false;
		$msg='日志添加成功<a href="post.php?entry='.$entry.'">查看该日志文章</a>';
		echo $msg;
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
		if(add.title.value==''){
			alert("标题不能为空！");
			return false;
		}
		if(add.content.value==''){
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
				<div class="blog_date"></div>
				<form name="add" method="POST" action="add.php" onsubmit="return check();">
					<table>
						<tr><td>日志标题：</td></tr>
						<tr><td><input type="text" name="title" size="50" /></td></tr>
						<tr><td>日志内容：</td></tr>
						<tr><td><textarea name="content" cols="49" rows="10"></textarea></td></tr>
						<tr><td><input type="submit" value="提交" /></td></tr>
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

