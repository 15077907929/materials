<?php
require('common.php');
//栏目数据读取
if($typeid){
	
}else{
	$now_typename='全部文章';
}
if($action==''){
	$action='today';
}
$tpl->assign('now_typename',$now_typename);
$tpl->assign('typeid',$typeid);
switch($action){
	case 'new':
	break;
	case 'today':
		//参数设置
		$nowday=mktime(0,0,0,date('m'),date('d'),date('Y'));
		//页码设置开始
		$sql='select count(*) from '.$table_schedule.' where inputer='.$user_id.' and intime='.$nowday;
		$result=$db->query_first($sql);
		$totalnum=$result[0];
		$pagenumber=intval($pagenumber);
		if(!isset($pagenumber) or $pagenumber==0){
			$pagenumber=1;
		}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,'?filename=schedule&action=list');
		//页码设置结束
		//记录数据的读取
		$query='select * from '.$table_schedule.' where inputer='.$user_id.' and (pretime<='.$nowday.' and intime>'.$nowday.') order by pretime asc limit '.$curpage.','.$perpage;
		$result=$db->query($query);
		while($row=$db->fetch_array($result)){
			$date_m=date('n',$row['intime']);
			if($nowday<=$row['intime'] and $nextday>=$row['intime']){
				$date_d='今日';
			}else{
				$date_d=date('d',$row['intime']);
			}
			$articleurl=$rootpath.'/show.php?id='.$row['articleid'];
			$content[]=array('id'=>$row['id'],'date_m'=>$row['date_m'],'date_d'=>$row['date_d'],'title'=>$row['title'],'content'=>$row['content'],'articleurl'=>$articleurl);
		}
		$tpl->assign('pagenav',$pagenav);
		$tpl->assign('content',$content);
	break;
}
$tpl->assign('action',$action);
$tpl->display('schedule.html');
?>