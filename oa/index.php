<?php
header("Content-type:text/html;charset=utf-8");
error_reporting(0);
//网络办公室
function gettime(){
	$t=explode(" ",microtime());
	return $t[1]+$t[0];
}
$start=gettime();
//开始缓存
ob_start('ob_gzhandler');
//读入global文件
require('global.php');
//是否显示执行时间
if($showtime==0){
	$start=0;
}
//检查安装文件是否存在
if(file_exists("install/install.php")){
	unlink('install/install.php');
	if(file_exists("install/install.php")){
		message('Please delete install.php via FTP!');
		exit();
	}
}
//检查变量防sql注入
$_POST=sql_injection($_POST);
$_GET=sql_injection($_GET);
//设置脚本执行时间为600秒
set_time_limit(600);
//设置session_id
$sid=$_COOKIE['sid'];

if($sid!=''){
	session_id($sid);
}
session_start();
//读取用户登入的id号，如果不能存在则注销这个变量
if(session_is_registered("user_system_id")){
	$user_system_ids=$_SESSION['user_system_id'];
	$user_system_ids=explode("|",$user_system_ids);
	$user_id=$user_system_ids[0];	//用户id值
	$system_id=$user_system_ids[1];	//系统id值
	if($system_id!=1){
		unset($user_system_ids,$user_id,$system_id);
		showmessage('对不起你已经登入了本工作室开发的另一个产品！<bt>请退出该产品','?filename=login');
	}
}else{
	unset($user_system_ids,$user_id,$system_id);
}
//判定是否登录过
if($filename!='login'){
	if(!isset($user_id)){
		$_GET['filename']='login';
	}
}

//设置管理权限
//如果存在cookie信息则读取cookie[group]管理权限信息
if(isset($_COOKIE['group'])){
	$group=explode("|",$_COOKIE['group']);
	$cookie_id=$group[0];	//用户id值
	$group_id=$group[1];	//用户组别
	$admin_id=$group[2];	//用户权限
	$user_name=$group[3];	//用户姓名
	$real_name=$group[4];	//用户真实姓名
}
//检查是否存在$user_id和$cookie_id相等，如果不等则重新设置cookie[group_id]管理权限信息
if(($user_id!=$cookie_id) and isset($user_id)){
	$query='select username,realname,groupid,admining from members where id='.$user_id.' and groupid<5 limit 1';
	$result=$db->query($query);
	if($db->num_rows($result)==1){
		$r=$db->fetch_array($result);
		$cookie_id=$user_id;	//用户id值
		$user_name=$r['username'];	//用户名
		$group_id=$r['groupid'];	//用户组别
		$admin_id=$r['admining'];	//管理分类的权限
		$real_name=$r['realname'];	//用户真实姓名	
		setcookie('group',$cookie_id.'|'.$group_id.'|'.$admin_id.'|'.$user_name.'|'.$real_name);
	}
}

unset($cookie_id);
//设置可操作的文件
$filename=$_GET['filename'];
$filenames=array('index','left','header','main','deal','info','login','setting','type','file','user','article','list','leave','calendar','schedule','fileg','softdown','message','table','favorite','classtable','show','soft_down','ftp','userlist','blank','register','rmsoft','setvar','log','reg');
$filename=empty($filename)?'index':$filename;
//操作记录
getlog();
//初始化变量
$tpl->assign(array('style'=>$style,'rootpath'=>$rootpath,'sitetitle'=>$sitetitle,'school_name'=>$school_name));
//读入相应文件入口
if(in_array($filename,$filenames)){
	include($admin_root.'/'.$filename.'.php');
}else{
	exit('您所操作的文件不存在，对不起该操作不可执行！');
}
?>