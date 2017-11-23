<?php
    if(!mysql_connect('localhost','root','123456'))
	die('connect db error!');
    mysql_select_db('game_ddz_db');
    mysql_query('set names "utf8"');
?>
