<?php
namespace Pickup\Controller;
class AjaxController extends RoleController{
    public function getPreKeyword(){
		$json=array();
		$package_name=$_GET['package_name'];
		$country=$_GET['country'];
		$query='select rank,word from app_keywords where package_name=\''.$package_name.'\' and country=\''.$country.'\' order by rank asc';
		$res=mysql_query($query);
		$keywords='';
		while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
			$keywords.='<option value=\''.$row['word'].'\'>排名：'.$row['rank'].' '.$row['word'].'</option>';
		}
		if($keywords==''){
			$json['status']=0;
			$json['info']='没有获取到关键词';
		}else{
			$json['status']=1;
			$json['info']='获取关键词成功';
			$json['keywords']=$keywords;
		}
		echo json_encode($json);
	}	
}