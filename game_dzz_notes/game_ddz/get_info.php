<?php
    include('dbconnect.php');
	error_reporting(0);
	
	$sql=mysql_query('select * from room_ddz where id='.$_GET['id']);
	$num=mysql_num_rows($sql);
	
	$player1_name=mysql_result($sql,0,'player1_name');
	$player2_name=mysql_result($sql,0,'player2_name');	
	$player1_p=mysql_result($sql,0,'player1_p');
	$player2_p=mysql_result($sql,0,'player2_p');		
	$lord_p=mysql_result($sql,0,'lord_p');
	$lord=mysql_result($sql,0,'lord');
	$flag=mysql_result($sql,0,'flag');
	$player1_show=mysql_result($sql,0,'player1_show');
	$player2_show=mysql_result($sql,0,'player2_show');	
	$player1_time=mysql_result($sql,0,'player1_time');
	$player2_time=mysql_result($sql,0,'player2_time');
	$system_time=mysql_result($sql,0,'system_time');
	
	if($player1_name){
		$sql_user_ddz=mysql_query('select * from user_ddz where name=\''.$player1_name.'\'');
		$player1_face=mysql_result($sql_user_ddz,0,'face');
		$player1_win=mysql_result($sql_user_ddz,0,'win');
		$player1_lost=mysql_result($sql_user_ddz,0,'lost');
		$player1_run=mysql_result($sql_user_ddz,0,'run');
		if($player1_win+$player1_lost+$player1_run==0){
			$player1_win_p=0;
		}else{
			$player1_win_p=round(100*$player1_win/($player1_win+$player1_lost+$player1_run));
			$player1_run_p=round(100*$player1_run/($player1_win+$player1_lost+$player1_run));
		}		
	}	
	if($player2_name){
		$sql_user_ddz=mysql_query('select * from user_ddz where name=\''.$player2_name.'\'');
		$player2_face=mysql_result($sql_user_ddz,0,'face');
		$player2_win=mysql_result($sql_user_ddz,0,'win');
		$player2_lost=mysql_result($sql_user_ddz,0,'lost');
		$player2_run=mysql_result($sql_user_ddz,0,'run');
		if($player2_win+$player1_lost+$player1_run==0){
			$player2_win_p=0;
		}else{
			$player2_win_p=round(100*$player2_win/($player2_win+$player2_lost+$player2_run));
			$player2_run_p=round(100*$player2_run/($player2_win+$player2_lost+$player2_run));
		}		
	}
	
	if($player1_p==''||$player2_p==''){
		mysql_query('update room_ddz set lord=\'\',player1_p=\'\',player2_p=\'\',lord_p=\'\',flag=\'\',player1_show=\'\',player2_show=\'\' where id='.$_GET['id']);
		if($player1_p==''&&$lord_p){
			mysql_query('update user_ddz set win=win+1 where name=\''.$player1_name.'\'');
			mysql_query('update user_ddz set lost=lost+1 where name=\''.$player2_name.'\'');
		}		
		if($player2_p==''&&$lord_p){
			mysql_query('update user_ddz set win=win+1 where name=\''.$player2_name.'\'');
			mysql_query('update user_ddz set lost=lost+1 where name=\''.$player1_name.'\'');
		}
		$lord_p='';
		$player1_p='';
		$player2_p='';
		$player1_show='';
		$player2_show='';
		$flag='';
	}
	
	if($_GET['player_id']=='player1'){
		if($system_time-$player2_time>30){
			mysql_query('update room_ddz set player2_name=\'\',lord=\'\',player1_p=\'\',player2_p=\'\',lord_p=\'\',flag=\'\',player2_time=0,player1_show=\'\',player2_show=\'\' where id='.$_GET['id']);
			mysql_query('update user_ddz set run=run+1 where name=\''.$player2_name.'\'');
		}
	}else{
		if($system_time-$player1_time>30){
			mysql_query('update room_ddz set player1_name=\'\',lord=\'\',player1_p=\'\',player2_p=\'\',lord_p=\'\',flag=\'\',player2_time=0,player1_show=\'\',player2_show=\'\' where id='.$_GET['id']);
			mysql_query('update user_ddz set run=run+1 where name=\''.$player1_name.'\'');
		}		
	}
	
	if($lord_p==''&&$player1_name&&$player2_name){
		$p_new=get_p();
		for($i=0;$i<17;$i++){
			$player1_p.=$p_new[$i].',';
		}		
		for($i=17;$i<34;$i++){
			$player2_p.=$p_new[$i].',';
		}
		for($i=34;$i<37;$i++){
			$lord_p.=$p_new[$i].',';
		}
		mysql_query('update room_ddz set player1_p=\''.$player1_p.'\',player2_p=\''.$player2_p.'\',lord_p=\''.$lord_p.'\' where id='.$_GET['id']);
	}

	$player1_p_num=sizeof(explode(',',$player1_p))-1;
	$player2_p_num=sizeof(explode(',',$player2_p))-1;
	
	mysql_query('update room_ddz set '.$_GET['player_id'].'_time=\''.$ori_time.'\',system_time=\''.$ori_time.'\' where id='.$_GET['id']);
	echo $player1_name.'|'.$player2_name.'|'.($_GET['player_id']=='player1'?renew($player1_p):renew($player2_p)).'|'.($_GET['player_id']=='player1'?$player2_p_num:$player1_p_num).'|'.$lord.'|'.renew($lord_p).'|'.$flag.'|'.$player1_show.'|'.$player2_show.'|'.$player1_face.'|'.$player2_face.'|'.$player1_win_p.'|'.$player2_win_p.'|'.$player1_run_p.'|'.$player2_run_p.'|';
?>