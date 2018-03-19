<?php

//第一步，先从服务器取回代理IP列表，用户名和密码由我们分配
//num = 5 下发条数，前期最好不要超过 100，后期可以扩大到1000左右的并发
//geo = th 两位国家名称, 如ph, in, id, vn, us, cn
//net = wifi 现在还不支持按网络类型下发，不过即将支持

$api = "http://139.198.120.17/call?key=nutsmobi&secret=nutsadminsecret&num=5&geo=th";

//发起网络请求，其它语言可以用httpClient
//返回结果
//call result : {"error":false,"data":{"178.10.85.22":"139.198.120.93:8004","2.201.17.110":"139.198.120.93:8001","81.111.122.90":"139.198.120.93:8005","89.15.238.202":"139.198.120.93:8003","93.231.144.36":"139.198.120.93:8002"}}
$call_cmd = sprintf("curl -s '$api'");
$call_result = `$call_cmd`;

echo "call result : " . $call_result . PHP_EOL . PHP_EOL;

$call_result_arr = json_decode($call_result, true);
if (!$call_result_arr) {
	echo "json error" . PHP_EOL;
	exit;
}

if (!count($call_result_arr['data'])) {
	echo "result data empty " . PHP_EOL;
	exit;
}

foreach ($call_result_arr["data"] as $key => $val) {
	$user_ip = $key;
	$target_link = $val;

	$target_link_arr = explode(":", $target_link);
	if (count($target_link_arr) != 2) {
		echo "target_link_arr error : " . $target_link . PHP_EOL;
		exit;
	}
	$target_link_ip = $target_link_arr[0];
	$target_link_port = $target_link_arr[1];

	//将当前电脑的外网IP（本地IP），与要使用的远程IP进行绑定，建立双方Socks5通道
	//如果连接失败，请更换成其它IP
	$register_cmd = sprintf("curl -s 'http://139.198.120.17/register?t=%s&p=%s&a=on&key=nutsmobi'", $user_ip, $target_link_port);
	$register_result = `$register_cmd`;
	if (false === stripos($register_result, "success")) {
		echo "register error : " . $register_cmd . PHP_EOL;
		exit;
	}

	//通道建立好以后，可以执行网络业务
	//这里是一个测试外网IP的业务逻辑，用来检查s5代理是否可用，及延迟，可以根据延迟来确定是否使用这个IP
	//可以调用其它语言或者SDK使用这个 socks5的IP 和端口，前提是其它程序的本地IP必须与注册通道的程序在同一内网
	//由于是连接海外服务器，连接速度比较慢，请务必调整超时时间的参数
	$request_cmd = sprintf("curl -s -iL -m 20 --socks5-hostname 139.198.120.17:%s 'http://data.nutsmobi.com/ip.php'", $target_link_port);
	$request_result = `$request_cmd`;

	echo "user_ip : " . $user_ip . " and port : " . $target_link_port . PHP_EOL;
	echo $request_result . PHP_EOL . PHP_EOL;

	//业务完成，关闭Socks5通道
	$unregister_cmd = sprintf("curl -s 'http://139.198.120.17/register?t=%s&p=%s&a=off&key=nutsmobi'", $user_ip, $target_link_port);
	$unregister_result = `$unregister_cmd`;
	if (false === stripos($unregister_result, "success")) {
		echo "unRegister error : " . $unregister_cmd . PHP_EOL;
		exit;
	}
}


