<?php
	include('dbconnect.php');
	$sql=mysql_query('select * from room_ddz where id='.$_GET['id']);
	$num=mysql_num_rows($sql);
	
	$lord=mysql_result($sql,0,'lord');
	
	if($_GET['action']=='no'){
		if($_GET['player_id']=='player1'){
			$_GET['player_id']='player2';
		}else{
			$_GET['player_id']='player1';
		}
	}
	if($lord==''){
		mysql_query('update room_ddz set '.$_GET['player_id'].'_p=\''.mysql_result($sql,0,$_GET['player_id'].'_p').mysql_result($sql,0,"lord_p").'\',lord=\''.$_GET["player_id"].'\',flag=\''.$_GET['player_id'].'\' where id='.$_GET['id']);
	}
?>