<?php
class nBoxController extends Yaf_Controller_Abstract{
	public function userinitAction (){
		if(empty($_COOKIE['uid'])){
			$username=rand(1000,9999).rand(1000,9999).rand(1000,9999);
			$sql='insert into nbox_users set username=\''.$username.'\',addtime=\''.date('Y-m-d').'\'';
			JoyDb::insert($sql);
			$sql='select * from nbox_users where username=\''.$username.'\' limit 1';
			$res=JoyDb::query($sql);	
		}else{
			$sql='select * from nbox_users where id=\''.$_COOKIE['uid'].'\' limit 1';
			$res=JoyDb::query($sql);			
		}
		if(!empty($res)){
			$res=$res[0];
			echo json_encode(array('status'=>1,'res'=>$res));
		}else{
			echo json_encode(array('status'=>0,'msg'=>'error'));
		}
	}
	
    public function getindexdataAction(){
		//获取banner广告
		$sql='select * from advertisements where appid=\''.$_POST['appid'].'\' and pos=0';
		$res['banner']=JoyDb::query($sql);
		//获取热度飙升
		$sql='select n.*,c.name as cate_name from nbox as n,nbox_cates as c where n.appid=\''.$_POST['appid'].'\' and n.category=c.id and n.category=1';
		$res['hot_list']=JoyDb::query($sql);		
		//获取畅销游戏
		$sql='select n.*,c.name as cate_name from nbox as n,nbox_cates as c where n.appid=\''.$_POST['appid'].'\' and n.category=c.id and n.category=2';
		$res['best_list']=JoyDb::query($sql);		
		//获取精品推荐
		$sql='select n.*,c.name as cate_name from nbox as n,nbox_cates as c where n.appid=\''.$_POST['appid'].'\' and n.category=c.id and n.category=4';
		$res['finy_list']=JoyDb::query($sql);
		//获取分类游戏
		$sql='select * from nbox_cates';
		$res['cates']=JoyDb::query($sql);
		foreach($res['cates'] as &$cate){
			$sql='select n.*,c.name as cate_name from nbox as n,nbox_cates as c where n.appid=\''.$_POST['appid'].'\' and n.category=c.id and n.category='.$cate['id'];
			$cate['list']=JoyDb::query($sql);			
		}
		//获取底部广告
		$sql='select * from advertisements where appid=\''.$_POST['appid'].'\' and pos=1 limit 1';
		$res['bottom_ad']=JoyDb::query($sql);
		if(!empty($res['bottom_ad'])){
			$res['bottom_ad']=JoyDb::query($sql)[0];
		}
		echo json_encode(array('status'=>1,'res'=>$res));
	}
	
	public function getsigndataAction(){
		//获取signData
		$sql='select * from nbox_tasks';
		$res['tasks']=JoyDb::query($sql);
		$sql='select * from nbox_users where id=\''.$_COOKIE['uid'].'\' limit 1';
		$res['user']=JoyDb::query($sql);	
		if(!empty($res['user'])){
			$res['user']=$res['user'][0];
			//获取sign_days字符串
			$len=strlen($res['user']['total_sign_days']);
			switch($len){
				case 1:
					$res['user']['sign_days']=[0,0,0,$res['user']['total_sign_days']];
				break;
				case 2:
					$res['user']['sign_days']=[0,0,$res['user']['total_sign_days']{0},$res['user']['total_sign_days']{1}];
				break;
				default:
					$res['user']['sign_days']=[0,0,0,0];
				break;
			}
			//获取任务完成状况
			foreach($res['tasks'] as $key=>&$val){
				$val['receive_status']=$res['user']['receive_status']{$key};
			}
			if($res['user']['last_sign_date']==date('Y-m-d')){
				$res['user']['sign_status']=1;
			}
		}
		echo json_encode(array('status'=>1,'res'=>$res));
	}
	
	public function signAction(){
		//获取用户信息
		$sql='select * from nbox_users where id=\''.$_COOKIE['uid'].'\' limit 1';
		$user=JoyDb::query($sql);	
		if(!empty($user)){
			$user=$user[0];
			//签到加一并修改最近签到时间及修改任务完成状态
			if($user['last_sign_date']!=date('Y-m-d')){		
				$sql='select * from nbox_tasks';
				$tasks=JoyDb::query($sql);
				foreach($tasks as $key=>$task){
					if($task['task_days']==($user['total_sign_days']+1)){
						$user['receive_status']{$key}=1;
					}
				}
				$sql='update nbox_users set total_sign_days=total_sign_days+1,last_sign_date=\''.date('Y-m-d').'\',receive_status=\''.$user['receive_status'].'\' where id='.$_COOKIE['uid'];
				JoyDb::update($sql);
			}
			echo json_encode(array('status'=>1,'msg'=>'ok'));			
		}		
	}
	
	public function getrewardAction(){
		//获取用户信息
		$sql='select * from nbox_users where id=\''.$_COOKIE['uid'].'\' limit 1';
		$user=JoyDb::query($sql);	
		if(!empty($user)){
			$user=$user[0];
			$user['receive_status']{$_POST['tid']-1}=2;	
			//获取任务详细
			$sql='select * from nbox_tasks where id='.$_POST['tid'].' limit 1';
			$task=JoyDb::query($sql);
			if(!empty($task)){
				$task=$task[0];
				$sql='update nbox_users set gold=gold+'.$task['gold_num'].',luck_times=luck_times+'.$task['luck_times'].',receive_status=\''.$user['receive_status'].'\' where id='.$_COOKIE['uid'];
				JoyDb::update($sql);
				//插入gold明细
				$sql='insert into nbox_gold_detail set uid='.$_COOKIE['uid'].',cate=1,gold='.$task['gold_num'].',status=1,create_at=\''.date('Y-m-d').'\'';
				JoyDb::insert($sql);
				echo json_encode(array('status'=>1,'msg'=>'ok'));	
			}
		}
	}
	
	//获取用户金币明细
	public function getgolddetailAction(){
		$sql='select * from nbox_gold_detail where uid='.$_COOKIE['uid'].' order by id desc';
		$res=JoyDb::query($sql);
		foreach($res as &$val){
			if($val['cate']==1){
				$val['remark']='签到任务奖励';
			}elseif($val['cate']==2){
				$val['remark']='玩游戏任务奖励';
			}elseif($val['cate']==3){
				$val['remark']='抽奖奖励';
			}
		}
		echo json_encode(array('status'=>1,'res'=>$res));
	}
	
	public function appclickAction(){
		//实例化redis
		$redis = new Redis();
		//连接
		$redis->connect('192.168.8.109', 6380);
		//记录用户最近使用
		$lately_use_arr=$redis -> lRange('lately_use_'.$_COOKIE['uid'],0,10);
		$redis->lPush('lately_use_'.$_COOKIE['uid'],$_POST['id'].'||'.date('Y-m-d'));	
		if(count(($lately_use_arr))>10){
			$redis -> rPop('lately_use_'.$_COOKIE['uid']);
			echo count($lately_use_arr);
		}
		//设置过期时间
		$redis->expire('lately_use_'.$_COOKIE['uid'],60*60*24*30);
		
		//click时默认玩了游戏一次
		$sql='update nbox_users set play_games=play_games+1 where id='.$_COOKIE['uid'];
		JoyDb::update($sql);
		//修改任务完成状况
		$sql='select * from nbox_users where id=\''.$_COOKIE['uid'].'\' limit 1';
		$user=JoyDb::query($sql);	
		if(!empty($user)){
			$user=$user[0];
			//获取任务详细
			$sql='select * from nbox_game_tasks where task_type=1';
			$tasks=JoyDb::query($sql);
			foreach($tasks as $key=>$task){
				if($task['task_num']==$user['play_games']){
					$user['receive_game_status']{$key}=1;
				}
			}
			$sql='update nbox_users set receive_game_status='.$user['receive_game_status'].' where id='.$_COOKIE['uid'];
			JoyDb::update($sql);
		}

				
		echo json_encode(array('status'=>1,'msg'=>'ok'));
	}
	
	public function getlatelyuseddataAction(){
		//实例化redis
		$redis = new Redis();
		//连接
		$redis->connect('192.168.8.109', 6380);
		//记录用户最近使用
		$lately_data=$redis -> lRange('lately_use_'.$_COOKIE['uid'],0,10);
		foreach($lately_data as $key=>$val){
			$explode_arr=explode('||',$val);
			$nbox_ids[$key]=$explode_arr[0];
			$update_arr[$key]=$explode_arr[1];
		}
		$nbox_ids=array_unique($nbox_ids);
		foreach($nbox_ids as $key=>$val){
			$sql='select * from nbox where id='.$val.' limit 1';
			$box_app_arr=JoyDb::query($sql);
			if(!empty($box_app_arr)){
				$box_app_arr[0]['update_at']=$update_arr[$key];
				$res[]=$box_app_arr[0];
			}
		}
		echo json_encode(array('status'=>1,'res'=>$res));	
	}
	
	public function getgametasklistAction(){
		$sql='select * from nbox_game_tasks';
		$res['tasks']=JoyDb::query($sql);	
		$sql='select * from nbox_users where id=\''.$_COOKIE['uid'].'\' limit 1';
		$res['user']=JoyDb::query($sql);	
		if(!empty($res['user'])){
			$res['user']=$res['user'][0];
			//获取任务完成状况
			foreach($res['tasks'] as $key=>&$val){
				$val['receive_game_status']=$res['user']['receive_game_status']{$key};
				if($val['receive_game_status']==0){	//未完成
					$val['style']=2;
					$val['is_complete']=0;
					if($val['task_type']==1){
						$val['had_complete_count']=$res['user']['play_games'];
					}elseif($val['task_type']==2){
						$val['had_complete_count']=$res['user']['invite_friends'];
					}
				}
			}
			if($res['user']['last_sign_date']==date('Y-m-d')){
				$res['user']['sign_status']=1;
			}
		}
		echo json_encode(array('status'=>1,'res'=>$res));			
	}
	
	public function getgamerewardAction(){
		//获取用户信息
		$sql='select * from nbox_users where id=\''.$_COOKIE['uid'].'\' limit 1';
		$user=JoyDb::query($sql);	
		if(!empty($user)){
			$user=$user[0];
			$user['receive_game_status']{$_POST['tid']-1}=2;	
			//获取任务详细
			$sql='select * from nbox_game_tasks where id='.$_POST['tid'].' limit 1';
			$task=JoyDb::query($sql);
			if(!empty($task)){
				$task=$task[0];
				$sql='update nbox_users set gold=gold+'.$task['gold_num'].',receive_game_status=\''.$user['receive_game_status'].'\' where id='.$_COOKIE['uid'];
				JoyDb::update($sql);
				//插入gold明细
				$sql='insert into nbox_gold_detail set uid='.$_COOKIE['uid'].',cate=2,gold='.$task['gold_num'].',status=1,create_at=\''.date('Y-m-d').'\'';
				JoyDb::insert($sql);
				echo json_encode(array('status'=>1,'msg'=>'ok'));	
			}
		}
	}
	
	public function getluckdataAction(){
		//获取用户信息
		$sql='select * from nbox_users where id=\''.$_COOKIE['uid'].'\' limit 1';
		$user=JoyDb::query($sql);	
		if(!empty($user)){
			$user=$user[0];
			$res['luck_times']=$user['luck_times'];
			if($user['luck_times']==0){
				$res['luck_times']=0;
				$res['title']='系统提示！';
				$res['content']='您没有抽奖机会了！';
				echo json_encode(array('status'=>1,'res'=>$res));exit;				
			}
		}
		$res['n']=rand(0,15);
		$res['gold']=0;
		$res['title']='未中奖！';
		$res['content']='加油';
		if($res['n']%2==0){
			$res['n']=$res['n']+1;
		}
		switch($res['n']){
			case 1:
				$res['gold']=20;
				$res['title']='恭喜您中奖啦！';
				$res['content']='20金币已发放至余额';
			break;
			case 5:
				$res['gold']=40;
				$res['title']='恭喜您中奖啦！';
				$res['content']='40金币已发放至余额';
			break;
			case 9:
				$res['gold']=60;
				$res['title']='恭喜您中奖啦！';
				$res['content']='60金币已发放至余额';
			break;
			case 13:
				$res['gold']=80;
				$res['title']='恭喜您中奖啦！';
				$res['content']='80金币已发放至余额';
			break;
		}
		//发放金币
		$sql='update nbox_users set gold=gold+'.$res['gold'].',luck_times=luck_times-1 where id='.$_COOKIE['uid'];
		JoyDb::update($sql);
		//插入gold明细
		if($res['gold']>0){
			$sql='insert into nbox_gold_detail set uid='.$_COOKIE['uid'].',cate=3,gold='.$res['gold'].',status=1,create_at=\''.date('Y-m-d').'\'';
			JoyDb::insert($sql);
		}
		echo json_encode(array('status'=>1,'res'=>$res));
	}
}

