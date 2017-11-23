<?php
	header("Content-type:text/html;charset=utf-8");
	set_time_limit(120);
    include('dbconnect.php');
	error_reporting(0);
	$sql=mysql_query('select * from room_ddz where id='.$_GET['id']);
	$num=mysql_num_rows($sql);
	if(!$num){
		die('房间不存在！');
	}
	
	$name=mysql_result($sql,0,"name");
	$player1_name=mysql_result($sql,0,"player1_name");
	$player2_name=mysql_result($sql,0,"player2_name");
	
	if($player_name==''||($player_name!=$player1_name&&$player_name!=$player2_name)){
		header('location:join.php?id='.$_GET['id']);
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
<link type="text/css" rel="stylesheet" href="css/base.css" />
<script type="text/javascript" src="js/room_ddz.js"></script>
<title>开心斗地主</title>
</head>
<body class="room_ddz">
<div class="loading" id="loading">
	<img src="images/loading.gif" /><br/>
	游戏加载中,请稍后!
	<script type="text/javascript">
		<?php
			echo 'var player1_name=\''.$player1_name.'\';';
			echo 'var player2_name=\''.$player2_name.'\';';
			echo 'var id=\''.$_GET['id'].'\';';
			if($player_name==$player1_name){
				echo 'var player_id=\'player1\';';
			}else{
				echo 'var player_id=\'player2\';';
			}
		?>
		setInterval("get_info()",1000);
	</script>
</div>
<div class="main_echo" id="main_echo"></div>

</body>
</html>
