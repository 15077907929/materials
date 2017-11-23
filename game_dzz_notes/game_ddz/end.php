<?php
    include('dbconnect.php');
	error_reporting(0);
	mysql_query('update room_ddz set player1_name=\'\',player2_name=\'\' where id='.$_GET['id']);
?>