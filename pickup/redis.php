<?php
//实例化redis
$redis = new Redis();
//连接
$redis->connect('192.168.1.10', 6381);
//检测是否连接成功
echo "Server is running: " . $redis->ping().'<br/>';
// 输出结果 Server is running: +PONG  

// $redis->set('facebook_app_id', '807403,811301,8136,808901,8145,807202,808102,8156,808202,810401,806801',3);  

// echo $redis->get('facebook_app_id');

$redis->sadd('facebook_app_id','807403');
$redis->sadd('facebook_app_id','811301');
$redis->sadd('facebook_app_id','8136');
$redis->sadd('facebook_app_id','808901');
$redis->sadd('facebook_app_id','8145');
$redis->sadd('facebook_app_id','807202');
$redis->sadd('facebook_app_id','808102');
$redis->sadd('facebook_app_id','8156');
$redis->sadd('facebook_app_id','808202');
$redis->sadd('facebook_app_id','810401');
$redis->sadd('facebook_app_id','806801');

$r = $redis->smembers('facebook_app_id');
print_r($r);
?>