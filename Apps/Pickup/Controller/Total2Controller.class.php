<?php
//任务管理
namespace Pickup\Controller;
use Think\controller;
C('TMPL_ENGINE_TYPE','Smarty');
class Total2Controller extends RoleController{
	var $sort_num=1;	
	function get_result($table,$redis){
		$start=date('Y-m-d',strtotime(date('Y-m-d').'-7 day')).' 16:00:00';	//前i天
		$end=date('Y-m-d').' 16:00:00';
		$db2=M('google_app_config');
		$where='cp=\'自有游戏\' and start>\''.$start.'\' and start<=\''.$end.'\'';	
		if(I('get.sub_where')=='comment'){	//评论
			$sub_where='cp=\'自有游戏\' and comment_rate>0';
		}elseif(I('get.sub_where')=='nocomment'){
			$sub_where='cp=\'自有游戏\' and comment_rate=0';	//不包括评论
		}		
		$db=M($table);
		//获取前七天赵宁组的所有包名	此处获取协议表内的数据
		$package_name_arr=$db->distinct(true)->field('package_name')->where($where)->select();
		foreach($package_name_arr as $key=>$value){	//展示赵宁组前七天的成功总量数据，按天划分
			//获取各个包名对应的国家
			$country_arr=$db->distinct(true)->field('country')->where($where.' and package_name=\''.$value['package_name'].'\'')->select();
			foreach($country_arr as $k=>$v){
				$success_sum_arr=array();	//成功量数组
				$task_num_arr=array();	//任务量数组
				for($i=1;$i<=7;$i++){
					$success_sum=0;
					$sub_start=date('Y-m-d',strtotime(date('Y-m-d').'-'.$i.' day')).' 16:00:00';	//前i天
					$sub_end=date('Y-m-d',strtotime(date('Y-m-d').'-'.($i-1).' day')).' 16:00:00';
					$data=$db->where($sub_where.' and package_name=\''.$value['package_name'].'\' and country=\''.$v['country'].'\' and start>\''.$sub_start.'\' and start<=\''.$sub_end.'\'')->select();
					foreach ($data as $sub_k=>$sub_v){
						$success_sum+=intval(getRedis()->get($redis."{$sub_v['id']}"));
					}
					$success_sum_arr[]=$success_sum;
					$task_num_temp_arr=array();
					$task_num=0;
					$task_num_temp_arr=$db->field('count')->where($sub_where.' and package_name=\''.$value['package_name'].'\' and country=\''.$v['country'].'\' and start>\''.$sub_start.'\' and start<=\''.$sub_end.'\'')->select();
					foreach($task_num_temp_arr as $sub_k=>$sub_v){
						$task_num+=$sub_v['count'];
					}
					$task_num_arr[]=$task_num;
				}
				$success_sum=0;	//筛选掉数据全为零的记录
				foreach($success_sum_arr as $sub_k=>$sub_v){
					$success_sum+=$sub_v;
				}
				if($success_sum==0){ continue; }
				$success_data='';
				foreach($success_sum_arr as $sub_k=>$sub_v){
					$success_data.=$sub_v.',';
				}
				$success_data=trim($success_data,',');
				$game_name_arr=array();
				$game_name_arr=$db2->distinct(true)->field('game_name')->where('package_name=\''.$value['package_name'].'\'')->select();
				$game_name=$game_name_arr[0]['game_name'];			
				$series.='{
					name: \''.$game_name.'--协议--'.$v['country'].'\',
					marker: {
						symbol: \'square\'
					},
					data: ['.$success_data.']
				}'.',';		
				$result_arr[]=array(
					'sort_num'=>$this->sort_num++,
					'package_name'=>$value['package_name'],
					'game_name'=>$game_name,
					'country'=>$v['country'],
					'type'=>'协议',
					'success1'=>$success_sum_arr[0],
					'success2'=>$success_sum_arr[1],
					'success3'=>$success_sum_arr[2],
					'success4'=>$success_sum_arr[3],
					'success5'=>$success_sum_arr[4],
					'success6'=>$success_sum_arr[5],
					'success7'=>$success_sum_arr[6],
					'count1'=>$task_num_arr[0],
					'count2'=>$task_num_arr[1],
					'count3'=>$task_num_arr[2],
					'count4'=>$task_num_arr[3],
					'count5'=>$task_num_arr[4],
					'count6'=>$task_num_arr[5],
					'count7'=>$task_num_arr[6],
				);			
			}
		}	
		return array('series'=>$series,'result_arr'=>$result_arr);
	}
	
    function zhaoning(){
        $method = I('get.method')?I('get.method') : 'show';
		$sub_where = I('get.sub_where');
		$now_date=date('Y-m-d',strtotime(date('Y-m-d').'-1 day'));
        switch ($method){
            case 'show':
				$redis_date=getRedis()->get($now_date.'_dates_'.$sub_where);
				if($redis_date!=''){	//如果数据已缓存入redis，则从redis数据库查询
					$result_arr=getRedis()->get($now_date.'_result_arr_'.$sub_where);
					$date_arr=getRedis()->get($now_date.'_date_arr_'.$sub_where);
					$dates=getRedis()->get($now_date.'_dates_'.$sub_where);
					$series=getRedis()->get($now_date.'_series_'.$sub_where);
				}else{	//数据还没有存入redis，则从mysql里面查询
					$data_zj=$this->get_result('google_task_config','app_task_success_nums_id_');	//获取真机数据
					$data_xy=$this->get_result('search_keyword_ip_task','search_task_success_id_');	//获取协议数据
					$series=$data_zj['series'].$data_xy['series'];
					$result_arr=array_merge($data_zj['result_arr'],$data_xy['result_arr']);
					$date_arr=array(
						'datetime1'=>$now_date,
						'datetime2'=>date('Y-m-d',strtotime(date('Y-m-d').'-2 day')),
						'datetime3'=>date('Y-m-d',strtotime(date('Y-m-d').'-3 day')),
						'datetime4'=>date('Y-m-d',strtotime(date('Y-m-d').'-4 day')),
						'datetime5'=>date('Y-m-d',strtotime(date('Y-m-d').'-5 day')),
						'datetime6'=>date('Y-m-d',strtotime(date('Y-m-d').'-6 day')),
						'datetime7'=>date('Y-m-d',strtotime(date('Y-m-d').'-7 day')),
					);
					foreach($date_arr as $key=>$value){
						$dates.='\''.$value.'\',';
					}			
					$dates=trim($dates,',');
					$series=trim($series,',');
					//把查询的到数据缓存入redis数据库
					getRedis()->set($now_date.'_result_arr_'.$sub_where,$result_arr,86400);
					getRedis()->set($now_date.'_date_arr_'.$sub_where,$date_arr,86400);
					getRedis()->set($now_date.'_dates_'.$sub_where,$dates,86400);
					getRedis()->set($now_date.'_series_'.$sub_where,$series,86400);
				}
			break;
        }
    }
}
	
  