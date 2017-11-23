<?php
	$pai_new='';
    include('dbconnect.php');
	error_reporting(0);
	$sql=mysql_query('select * from room_ddz where id='.$_GET['id']);
	$num=mysql_num_rows($sql);
	if($_GET['p_show_var']==''){
		$_GET['p_show_var']='no';
	}
	$pai=mysql_result($sql,0,$_GET['player_id'].'_p');
	$e_pai=explode(",",$pai);
	$e_p_show_var=explode(",",$_GET['p_show_var']);
	for($i=0;$i<sizeof($e_pai)-1;$i++){
		$flag=1;
		for($j=0;$j<sizeof($e_p_show_var)-1;$j++){
			if($e_pai[$i]==$e_p_show_var[$j]){
				$flag=0;
			}
		}
		if($flag){
			$pai_new.=$e_pai[$i].",";
		}
	}
	mysql_query('update room_ddz set '.$_GET['player_id'].'_p=\''.$pai_new.'\','.$_GET['player_id'].'_show=\''.$_GET['p_show_var'].'\',flag=\''.($_GET['player_id']=='player1'?"player2":"player1").'\' where id='.$_GET['id']);
?>