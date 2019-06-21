<?php
function renew($pai){
	$p=C('p');
	$pv=C('pv');
	$e_pai=explode(',',$pai);
	for($i=0;$i<sizeof($e_pai);$i++){
		for($j=$i+1;$j<sizeof($e_pai);$j++){
			if($pv[$e_pai[$i]]>$pv[$e_pai[$j]]){
				$temp=$e_pai[$i];
				$e_pai[$i]=$e_pai[$j];
				$e_pai[$j]=$temp;
			}
		}
	}
	for($pai='',$i=0;$i<sizeof($e_pai);$i++){
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
	$p_temp=C('p');
	$p_new=array();
	for($i=0;$i<37;$i++){
		$p_new[$i]=$p_temp[rand(0,sizeof($p_temp)-1)];
		for($p_temp_temp=array(),$j=0,$k=0;$j<sizeof($p_temp);$j++){
			if($p_temp[$j]!=$p_new[$i])
				$p_temp_temp[$k++]=$p_temp[$j];
		}
		$p_temp=array();
		$p_temp=$p_temp_temp;
	}
	return $p_new;
}