<?php
    include('dbconnect.php');
    
    if($_POST['name'] && $_POST['password']){
	$sql=mysql_query('select count(*) as num from user_ddz where name=\''.$_POST['name'].'\' and password=\''.md5($_POST['password']).'\'');
        if(mysql_result($sql,0,num)){
	    setcookie('player_name',$_POST['name']);
	    setcookie('player_password',$_POST['password']);
	    header('location:hall.php');
	}else{
	   message('account/password error!','index.php');
	}
    }else{
        message('complete information and check for details!','index.php');
    }
?>
