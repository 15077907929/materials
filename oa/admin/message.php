<?php
require('common.php');
//栏目数据读取
if($typeid){
	
}else{
	$now_typename='全部文章';
}
if($action==''){
	$action='receive';
}
$tpl->assign('now_typename',$now_typename);
switch($action){
	case 'new':
	break;
	case 'receive':
		//页码设置开始
		$sql='select count(*) from '.$table_message.' where receive='.$user_id;
		$result=$db->query_first($sql);
		$totalnum=$result[0];
		$pagenumber=intval($pagenumber);
		if(!isset($pagenumber) or $pagenumber==0){
			$pagenumber=1;
		}
		$curpage=($pagenumber-1)*$perpage;
		$pagenav=getpagenav($totalnum,'?filename=message&action=list');
		//页码设置结束
		//记录数据的读取
		$query='select '.$table_message.'.*,members.realname from '.$table_message.' left join members on '.$table_message.'.send=members.id where receive='.$user_id.' order by '.$table_message.'.id desc limit '.$curpage.','.$perpage;
		$result=$db->query($query);
		while($row=$db->fetch_array($result)){
			$sendtime=date('Y/m/d',$row['sendtime']);
			$content[]=array('id'=>$row['id'],'title'=>$row['title'],'realname'=>$row['realname'],'sendtime'=>$row['sendtime'],'content'=>$row['content']);
		}
		$tpl->assign('pagenav',$pagenav);
		$tpl->assign('content',$content);
	break;
}
$tpl->assign('action',$action);
$tpl->display('message.html');
?>