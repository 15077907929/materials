<?php
if(!$_SESSION['user_system_id']){
	$referer='?filename=login';
	showmessage('你没有登入!',$referer);
}
//用户信息读取
$sql='select management.name from members left join management on members.manageid=management.id where members.id='.$user_id.' limit 1';
$row=$db->query_first($sql);
$managename=$row['name'];
$tpl->assign(array('real_name'=>$real_name,'managename'=>$managename));
//一级栏目数据读取
$query='select id,name,uid,layerid,ico from '.$table_type.' order by path,tid';
$result=$db->query($query);
while($row=$db->fetch_array($result)){
	$type[$row['uid']][]=$row['id'];
	$totaltype[$r['id']]=$row;
	if($row['layerid']==1){
		$toolbar_arr[]=$row;
	}
}
$toolbar='<li style="background:url(templates/'.$style.'/images/chatroom.gif) no-repeat left center;"><a class="noBg" href="">我的桌面</a><span class="split"></span></li>';
foreach($toolbar_arr as $key=>$value){
	$toolbar.='<li style="background:url(templates/'.$style.'/images/'.$value['ico'].') no-repeat left center;"><a href="">'.$value['name'].'</a>';
	//二级栏目数据读取
	$query='select id,name,uid,layerid,ico,actionurl from '.$table_type.' where layerid=2 and uid='.$value['id'].' order by id';
	$result=$db->query($query);
	$toolbar_sec_arr=array();
	while($row=$db->fetch_array($result)){
		$toolbar_sec_arr[]=$row;
	}
	$toolbar.='<dl class="hide subMenu">';
	foreach($toolbar_sec_arr as $k=>$v){
		$toolbar.='<dt style="background:url(templates/'.$style.'/images/'.$v['ico'].') no-repeat left center;"><a href="'.$v['actionurl'].'">'.$v['name'].'</a></dt>';
	}
	$toolbar.='</dl>';
	$toolbar.='<span class="split"></span></li>';
}
$toolbar.='<li style="background:url(templates/'.$style.'/images/workflow.gif) no-repeat left center;"><a class="noBg" href="">注销</a></li>';
$tpl->assign('school_name',$school_name);
$tpl->assign('toolbar',$toolbar);
?>