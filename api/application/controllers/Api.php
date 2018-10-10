<?php
class ApiController extends Yaf_Controller_Abstract{
	//接口1，把搜索到的群存入数据库
	public function qq2dbAction(){
		if(empty($_POST)){
            $_POST = $_GET;
        }
        $req=file_get_contents('php://input');
        if(strstr($req, '{')){
            $_POST=json_decode($req, true);
        }
	
		$group_id = $_POST['qunid'];
		$group_member_num = $_POST['qunmembernum'];
		$labels = $_POST['labels'];
		if(trim($group_id)==''){
			echo '群号不能为空！';
			return false;
		}
		$sql='insert into qq_group set group_id=\''.$group_id.'\',group_member_num='.$group_member_num.',labels=\''.$labels.'\',addtime=\''.date('Y-m-d').'\'';
		if(JoyDb::insert($sql)){
			$arr=json_encode(['msg'=>'ok','status'=>'1']);
		}else{
			$arr=json_encode(['msg'=>'error','status'=>'0']);
		}
		echo $arr;
    }	
	
	//接口2，qq号状态异常上报接口
	public function qqerrorAction(){
		$QQ_account = $_GET['QQ_account'];
		$DeviceID = $_GET['DeviceID'];
		
		if(trim($QQ_account)==''){
			echo 'QQ号不能为空！';
			return false;
		}
		$sql='insert into qq_qq set QQ_account=\''.$QQ_account.'\',DeviceID=\''.$DeviceID.'\',status=0,addtime=\''.date('Y-m-d').'\'';
		if(JoyDb::insert($sql)){
			$arr=json_encode(['msg'=>'ok','status'=>'1']);
		}else{
			$arr=json_encode(['msg'=>'error','status'=>'0']);
		}
		echo $arr;
    }	
	
	//接口3，加群失败上报接口
	public function joinqqgrouperrorAction(){	
		$qunID = $_REQUEST['qunID'];
		$DeviceID = $_GET['DeviceID'];
		if(trim($qunID)==''){
			echo '群号不能为空！';
			return false;
		}
		$sql='update qq_group set DeviceID='.$DeviceID.',status=0 where qunID=\''.$qunID.'\'';
		if(JoyDb::update($sql)){
			$arr=json_encode(['msg'=>'ok','status'=>'1']);
		}else{
			$arr=json_encode(['msg'=>'error','status'=>'0']);
		}
		echo $arr;
    }	
	
	//接口4，手机端请求任务接口
	public function qqgettaskAction(){		
		$DeviceID = $_GET['DeviceID'];
		if(trim($DeviceID)==''){
			echo 'DeviceID不能为空！';
			return false;
		}
		$sql='select * from qq_task where DeviceID=\''.$DeviceID.'\'';
		$res=json_encode(JoyDb::query($sql));
		echo $res;
    }
}

