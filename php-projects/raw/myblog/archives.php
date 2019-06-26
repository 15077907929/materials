<?php
$login=false;
session_start();

if(!empty($_SESSION['user'])&&$_SESSION['user']=='admin')
	$login=true;

$ok=true;

if(!isset($_GET['ym'])||empty($_GET['ym'])){
	$ok=false;
	$msg='请求参数错误！<a href="index.php">返回首页</a>';
}


$folder_array=array();
$dir='contents';
$folder=$_GET['ym'];
if(!is_dir($dir.'/'.$folder)){
	$ok=false;
	$msg='请求参数错误！<a href="index.php">返回首页</a>';
}else{
	$post_data=array();
	$dh=opendir($dir.'/'.$folder);
	while(($filename=readdir($dh))!=false){
		if(is_file($dir.'/'.$folder.'/'.$filename)){
			$file=$filename;
			$file_name=$dir.'/'.$folder.'/'.$file;
			if(file_exists($file_name)){
				$fp=fopen($file_name,'r');
				if($fp){
					flock($fp,LOCK_SH);
					$result=fread($fp,filesize($file_name));
				}
				flock($fp,LOCK_UN);
				fclose($fp);
			}
			$temp_data=array();
			$content_array=explode('$|$',$result);
			$temp_data['subject']=$content_array[0];
			$temp_data['date']=date('Y-m-d H:i:s',$content_array[1]);
			$temp_data['content']=$content_array[2];
			$file=substr($file,0,9);
			$temp_data['filename']=$folder.'-'.$file;
			array_push($post_data,$temp_data);
		}
		
	}
}

$dh=opendir($dir);
if($dh){
	$filename=readdir($dh);
	while($filename){
		if($filename!='.'&&$filename!='..'){
			$folder_name=$filename;
			array_push($folder_array,$folder_name);
		}
		$filename=readdir($dh);
	}
}	
rsort($folder_array);


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
		<?php
		if($ok==true){
			foreach($post_data as $post){
		?>
		<div class="blog_entry">
			<div class="blog_title"><?php echo $post['subject']; ?></div>
			<div class="blog_body">
				<div class="blog_date"><?php echo $post['date']; ?></div>
				<?php echo $post['content']; ?>
				<div>
				<?php
				if($login){
					echo '<a href="edit.php?entry='.$post['filename'].'">编辑</a> &nbsp; <a href="delete.php?entry='.$post['filename'].'">删除</a>';
				}
				?>
				</div>
			</div>
		</div>
		<?php
			}
		}else{
			echo $msg;
		}
		?>
	</div>
	<div class="right">
		<div class="sidebar">
			<div class="menu_title">关于我</div>
			<div class="menu_body">
				我是个PHP爱好者
				<br/>
				<br/>
				<?php
				if($login){
					echo '<a href="logout.php">退出</a>';
				}
				else{
					echo '<a href="login.php">登录</a>';
				}
				?>
			</div>
		</div>
		<br/>
		<div class="sidebar">
			<div class="menu_title">日志归档</div>
			<?php
			foreach($folder_array as $ym){
				$entry=$ym;
				$ym=substr($ym,0,4).'-'.substr($ym,4,2);
			?>
			<div class="menu_body">
				<a href="archives.php?ym=<?php echo $entry; ?>"><?php echo $ym; ?></a>
			</div>
			<?php
			}
			?>
		</div>
	</div>
	<div class="footer">
		CopyRight 2019
	</div>
</div>
</body>
</html>

