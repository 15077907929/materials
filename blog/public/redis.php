<?php
	$redis=new Redis();
	$redis->connect('10.80.8.128',6379);
	$redis->select(5);
	$redis->set('weather','sunning');
	
	var_dump($redis->get('weather'));
	
	$redis->mset(array('height1'=>'170','height2'=>'171','height3'=>'172'));
	var_dump($redis->mget(array('height1','height2','height3')));
	
	$me=new ReflectionClass('Redis');
	
	echo '<pre>';
	print_r($me->getMethods());
	echo '</pre>';
	
	
	
	
	
	echo 'test';
?>