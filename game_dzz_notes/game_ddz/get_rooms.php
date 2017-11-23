<?php
header("Content-type:text/html;charset=utf-8");
error_reporting(0);
include('dbconnect.php');
$sql=mysql_query('select * from room_ddz');
$num=mysql_num_rows($sql);
echo '<ul class="clearfix">';
for($i=0;$i<$num;$i++){
	if($ori_time-mysql_result($sql,$i,'system_time')>30){
		mysql_query('update room_ddz set player1_name=\'\',player2_name=\'\',lord=\'\',player1_p=\'\',player2_p=\'\',lord_p=\'\',flag=\'\',player1_show=\'\',player2_show=\'\' where id='.mysql_result($sql,$i,'id'));
	}
	$player1_name=mysql_result($sql,$i,'player1_name');
	$player2_name=mysql_result($sql,$i,'player2_name');
	echo '<li><p class="room_number">'.mysql_result($sql,$i,'name').'</p><div class="pic"><span class="player1">'.$player1_name.'</span><a href="room_ddz.php?id='.mysql_result($sql,$i,'id').'"><img src="images/table'.(($player1_name||$player2_name)?"":"_blank").'.gif" /></a><span class="player2">'.$player2_name.'</span></div><p class="no_order">- '.($i+1).' -</p></li>';
}
echo '</ul>';
?>
