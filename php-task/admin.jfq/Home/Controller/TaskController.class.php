<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class TaskController extends CommonController {
    public function task(){
		$method = I('get.method') ? I('get.method') : 'show';
		$db=M('task');
		switch ($method) {
            case 'list':
				$res['list']=$db->select();
			break;  
			case 'show':
			
			break;
			case 'add':
				if($_POST){
					$data['taskName']=trim($_POST['taskName']);
					$data['app_name']=trim($_POST['app_name']);
					$data['app_img']=$_POST['app_img'];
					$data['taskType']=$_POST['taskType'];
					$data['app_income']=$_POST['app_income'];
					$data['app_identifier']=$_POST['app_identifier'];
					$data['endTime']=$_POST['endTime'];
					$data['ad_summary']=$_POST['ad_summary'];					
					if($data['taskName']==''){
						$res['code']=0;
						$res['msg']='任务名称不能为空';
						$res['data']='';
						$res['url']='';
						$res['wait']=3;
					}else{
						if($db->add($data)){
							$res=[
								'code'=>1,
								'msg'=>'任务添加成功',
								'data'=>'',	
								'url'=>'index.php?m=Home&c=Task&a=task&method=list',
								'wait'=>3,			
							];
						}
					}
					echo json_encode($res);
					exit;
				}
			break;
			case 'del':
				if($db->where('id='.$_GET['id'])->delete()){
					$res=[
						'code'=>1,
						'msg'=>'任务删除成功',
						'data'=>'',	
						'url'=>'index.php?m=Home&c=Task&a=task&method=list',
						'wait'=>3,			
					];
				}
				echo json_encode($res);
				exit;
			break;
			case 'edit':
				$res['info']=$db->where('id='.$_GET['id'])->find();
				if($_POST){
					$data['taskName']=trim($_POST['taskName']);
					$data['app_name']=trim($_POST['app_name']);
					$data['app_img']=$_POST['app_img'];
					$data['taskType']=$_POST['taskType'];
					$data['app_income']=$_POST['app_income'];
					$data['app_identifier']=$_POST['app_identifier'];
					$data['endTime']=$_POST['endTime'];
					$data['ad_summary']=$_POST['ad_summary'];					
					if($data['taskName']==''){
						$res['code']=0;
						$res['msg']='任务名称不能为空';
						$res['data']='';
						$res['url']='';
						$res['wait']=3;
					}else{
						if($db->where('id='.$_POST['id'])->save($data)){
							$res=[
								'code'=>1,
								'msg'=>'任务编辑成功',
								'data'=>'',	
								'url'=>'index.php?m=Home&c=Task&a=task&method=list',
								'wait'=>3,			
							];
						}
					}	
					echo json_encode($res);
					exit;					
				}
			break;
		}
		$this->assign('res',$res);
		$this->display('task_'.$method);
	}    
}