<?php
include'config.inc.php';
ob_start();
$p=array('1','2','3','4','5','7','8','9','10','11','12','13','F1','F2','F3','F4','F5','F6','F7','F8','F9','F10','F11','F12','F13','T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12','T13','H1','H2','H3','H4','H5','H6','H7','H8','H9','H10','H11','H12','H13','JOKE1','JOKE2');
$pv=array('3'=>3,'F3'=>3,'T3'=>3,'H3'=>3,
'4'=>4,'F4'=>4,'T4'=>4,'H4'=>4,
'5'=>5,'F5'=>5,'T5'=>5,'H5'=>5,
'6'=>6,'F6'=>6,'T6'=>6,'H6'=>6,
'7'=>7,'F7'=>7,'T7'=>7,'H7'=>7,
'8'=>8,'F8'=>8,'T8'=>8,'H8'=>8,
'9'=>9,'F9'=>9,'T9'=>9,'H9'=>9,
'10'=>10,'F10'=>10,'T10'=>10,'H10'=>10,
'11'=>11,'F11'=>11,'T11'=>11,'H11'=>11,
'12'=>12,'F12'=>12,'T12'=>12,'H12'=>12,
'13'=>13,'F13'=>13,'T13'=>13,'H13'=>13,
'1'=>14,'F1'=>14,'T1'=>14,'H1'=>14,
'2'=>15,'F2'=>15,'T2'=>15,'H2'=>15,
'JOKE1'=>16,'JOKE2'=>17,
);

function renew($pai){
	global $pv;
	$e_pai=explode(',',$pai);
	for($i=0;$i<sizeof($e_pai)-2;$i++){
		for($j=$i+1;$j<sizeof($e_pai)-1;$j++){
			if($pv[$e_pai[$i]]>$pv[$e_pai[$j]]){
				$temp=$e_pai[$i];
				$e_pai[$i]=$e_pai[$j];
				$e_pai[$j]=$temp;
			}
		}
	}
	for($pai='',$i=0;$i<sizeof($e_pai)-1;$i++){
		$pai.=$e_pai[$i].',';
	}
	return $pai;
}

function message($message,$url){
    setcookie('message',$message);
    header('location:'.$url);
    exit;	
}

function get_p(){
	global $p;
	$p_temp=$p;
	$p_new=array();
	for($i=0;$i<37;$i++){
		$p_new[$i]=$p_temp[rand(0,sizeof($p_temp)-1)];
		for($p_temp_temp=array(),$j=0,$k=0;$j<sizeof($p_temp);$j++){
			if($p_temp[$j]!=$p_new[$i]){
				$p_temp_temp[$k++]=$p_temp[$j];
			}
		}
		$p_temp=array();
		$p_temp=$p_temp_temp;
	}
	return $p_new;
}

mysql_query('set names utf8');

$player_name=$_COOKIE['player_name'];

$ori_time=time();
?>
