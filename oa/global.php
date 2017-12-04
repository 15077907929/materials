<?php
//巢湖市槐林中学
unset($dbservertype);
//load config
require('config.php');
//*****init*****//
//load db class
$dbservertype=strtolower($dbservertype);
$dbclassname='include/db_'.$dbservertype.'.php';
require($dbclassname);
//load db table
$tables=array('type','message','adminlog','loginlog','schedule');
foreach($tables as $tablename){
	${'table_'.$tablename}=$tablepre.$tablename;
}
//set db
$db=new FMysql;
$db->appname='大兵小将';
$db->appshortname='校园2017网络办公室';
$db->database=$dbname;
$db->server=$servername;
$db->user=$dbusername;
$db->password=$dbpassword;
$db->connect();
$db->query('set names '.$charset);
//load functions
require('include/functions.php');
/****************init Micro Template****************/
//load Micro Template
require('include/tpl.class.php');
//set Micro Template
$templates_dir='templates/'.$style.'/html';
$tpl=new MicroTpl($templates_dir);
?>