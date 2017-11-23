<?php
	header("Content-type:text/html;charset=utf-8");
    include('dbconnect.php');
	error_reporting(0);
	
	$sql=mysql_query('select count(*) as num from room_ddz where (player1_name=\''.$player_name.'\' or player2_name=\''.$player_name.'\') and id='.$_GET['id']);
	if(mysql_result($sql,0,'num')){
		header('location:room_ddz.php?id='.$_GET['id']);
		exit;
	}else{
		$sql=mysql_query('select count(*) as num from user_ddz where name=\''.$player_name.'\'');
		if(!mysql_result($sql,0,'num')){
			header('location:index.php');
			exit;
		}
		$sql=mysql_query('select * from room_ddz where id='.$_GET['id']);
		$num=mysql_num_rows($sql);
		if(!$num){
			die('参数有误');
		}
		$player1_name=mysql_result($sql,0,"player1_name");
		$player2_name=mysql_result($sql,0,"player2_name");	
		if($player1_name&&$player2_name){
			header('location:hall.php');
			exit;
		}
		if($player1_name==''){
			mysql_query('update room_ddz set player1_name=\''.$player_name.'\',player1_time='.$ori_time.',system_time='.$ori_time.' where id='.$_GET['id']);
			header('location:room_ddz.php?id='.$_GET['id']);
			exit;
		}
		if($player2_name==''){
			mysql_query('update room_ddz set player2_name=\''.$player_name.'\',player2_time='.$ori_time.',system_time='.$ori_time.' where id='.$_GET['id']);
			header('location:room_ddz.php?id='.$_GET['id']);
			exit;
		}		
	}
?>