<?php
namespace Home\Controller;	//教务管理控制器
use Think\Controller;
class DeanController extends CommonController{
	public function y_course($target_arr,$num,$class){
		if(empty($target_arr['list'])){
			return '/';
		}else{
			foreach($target_arr['list'] as $key=>$val){
				if($val['nonumber']==$num and $val['class']==$class){
					return '<a href="#" title="内 容：'.$val['content'].'&#10;科 目：'.$val['subject'].'&#10;点击链接取消预约">'.$val['teacher'].'<br>'.$val['grade'].'</a>';
				}
			}
			return '/';
		}
	}
		
	function classroom(){	//公共教室预约
		$db=M('oa_');
		$method=I('get.method')==''?'show':I('get.method');
		switch($method){
			case 'show':
				$week_arr=array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
				$result_arr['y_class']=M('oa_y_class')->where('type=1')->select();
				for($i=0;$i<7;$i++){
					$date=date('Y-m-d',strtotime(date('Y-m-d').' +'.$i.' day'));
					$result_arr['y_content'][]=array(
						'date'=>$date,
						'w'=>$week_arr[date('w',strtotime($date))],
						'list'=>M('oa_y_content')->table('classset as c,oa_y_content as oa')->field('c.name as grade,oa.class,oa.teacher,oa.subject,oa.nonumber,oa.content')->where('oa.grade=c.id and oa.state=1 and oa.ordertime='.strtotime(date('Y-m-d').' +'.$i.' day'))->select()
					);
				}
				$day_0=$result_arr['y_content'][0];
				$day_1=$result_arr['y_content'][1];
				$day_2=$result_arr['y_content'][2];
				$day_3=$result_arr['y_content'][3];
				$day_4=$result_arr['y_content'][4];
				$day_5=$result_arr['y_content'][5];
				$day_6=$result_arr['y_content'][6];
				foreach($result_arr['y_class'] as $key=>$val){
					$result_arr['y_tables'][$val['name']]=array(
						array(
							'date'=>date('Y-m-d'),'w'=>$week_arr[date('w',strtotime(date('Y-m-d')))],
							'1st'=>$this->y_course($day_0,1,$val['id']),'2nd'=>$this->y_course($day_0,2,$val['id']),
							'3rd'=>$this->y_course($day_0,3,$val['id']),'4th'=>$this->y_course($day_0,4,$val['id']),
							'5th'=>$this->y_course($day_0,5,$val['id']),'6th'=>$this->y_course($day_0,6,$val['id']),
							'7th'=>$this->y_course($day_0,7,$val['id']),'8th'=>$this->y_course($day_0,8,$val['id']),
						),						
						array(
							'date'=>date('Y-m-d',strtotime(date('Y-m-d').'+1 day')),'w'=>$week_arr[date('w',strtotime(date('Y-m-d').'+1 day'))],
							'1st'=>$this->y_course($day_1,1,$val['id']),'2nd'=>$this->y_course($day_1,2,$val['id']),
							'3rd'=>$this->y_course($day_1,3,$val['id']),'4th'=>$this->y_course($day_1,4,$val['id']),
							'5th'=>$this->y_course($day_1,5,$val['id']),'6th'=>$this->y_course($day_1,6,$val['id']),
							'7th'=>$this->y_course($day_1,7,$val['id']),'8th'=>$this->y_course($day_1,8,$val['id']),
						),						
						array(
							'date'=>date('Y-m-d',strtotime(date('Y-m-d').'+2 day')),'w'=>$week_arr[date('w',strtotime(date('Y-m-d').'+2 day'))],
							'1st'=>$this->y_course($day_2,1,$val['id']),'2nd'=>$this->y_course($day_2,2,$val['id']),
							'3rd'=>$this->y_course($day_2,3,$val['id']),'4th'=>$this->y_course($day_2,4,$val['id']),
							'5th'=>$this->y_course($day_2,5,$val['id']),'6th'=>$this->y_course($day_2,6,$val['id']),
							'7th'=>$this->y_course($day_2,7,$val['id']),'8th'=>$this->y_course($day_2,8,$val['id']),
						),						
						array(
							'date'=>date('Y-m-d',strtotime(date('Y-m-d').'+3 day')),'w'=>$week_arr[date('w',strtotime(date('Y-m-d').'+3 day'))],
							'1st'=>$this->y_course($day_3,1,$val['id']),'2nd'=>$this->y_course($day_3,2,$val['id']),
							'3rd'=>$this->y_course($day_3,3,$val['id']),'4th'=>$this->y_course($day_3,4,$val['id']),
							'5th'=>$this->y_course($day_3,5,$val['id']),'6th'=>$this->y_course($day_3,6,$val['id']),
							'7th'=>$this->y_course($day_3,7,$val['id']),'8th'=>$this->y_course($day_3,8,$val['id']),
						),						
						array(
							'date'=>date('Y-m-d',strtotime(date('Y-m-d').'+4 day')),'w'=>$week_arr[date('w',strtotime(date('Y-m-d').'+4 day'))],
							'1st'=>$this->y_course($day_4,1,$val['id']),'2nd'=>$this->y_course($day_4,2,$val['id']),
							'3rd'=>$this->y_course($day_4,3,$val['id']),'4th'=>$this->y_course($day_4,4,$val['id']),
							'5th'=>$this->y_course($day_4,5,$val['id']),'6th'=>$this->y_course($day_4,6,$val['id']),
							'7th'=>$this->y_course($day_4,7,$val['id']),'8th'=>$this->y_course($day_4,8,$val['id']),
						),
						array(
							'date'=>date('Y-m-d',strtotime(date('Y-m-d').'+5 day')),'w'=>$week_arr[date('w',strtotime(date('Y-m-d').'+5 day'))],
							'1st'=>$this->y_course($day_5,1,$val['id']),'2nd'=>$this->y_course($day_5,2,$val['id']),
							'3rd'=>$this->y_course($day_5,3,$val['id']),'4th'=>$this->y_course($day_5,4,$val['id']),
							'5th'=>$this->y_course($day_5,5,$val['id']),'6th'=>$this->y_course($day_5,6,$val['id']),
							'7th'=>$this->y_course($day_5,7,$val['id']),'8th'=>$this->y_course($day_5,8,$val['id']),
						),
						array(
							'date'=>date('Y-m-d',strtotime(date('Y-m-d').'+6 day')),'w'=>$week_arr[date('w',strtotime(date('Y-m-d').'+6 day'))],
							'1st'=>$this->y_course($day_6,1,$val['id']),'2nd'=>$this->y_course($day_6,2,$val['id']),
							'3rd'=>$this->y_course($day_6,3,$val['id']),'4th'=>$this->y_course($day_6,4,$val['id']),
							'5th'=>$this->y_course($day_6,5,$val['id']),'6th'=>$this->y_course($day_6,6,$val['id']),
							'7th'=>$this->y_course($day_6,7,$val['id']),'8th'=>$this->y_course($day_6,8,$val['id']),
						),
					);
				}
				//今天的预约课
				foreach($result_arr['y_content'] as $key=>$val){
					if($val['date']==date('Y-m-d')){
						foreach($result_arr['y_class'] as $k=>$v){
							foreach($val['list'] as $sub_k=>&$sub_v){
								if($sub_v['class']==$v['id']){
									$sub_v['class']=$v['name'];
								}
							}
						}
						$result_arr['y_today']=$val['list'];
					}
				}
				$this->assign('result_arr',$result_arr);
				$this->display('classroom');
			end;
		}					
	}
	
	function lab(){	//实验室预约
		$db=M('oa_');
		$method=I('get.method')==''?'show':I('get.method');
		switch($method){
			case 'show':
				$week_arr=array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
				$result_arr['y_class']=M('oa_y_class')->where('type=2')->select();
				foreach($result_arr['y_class'] as $key=>$val){
					$ids.=$val['id'].',';
				}
				$ids=trim($ids,',');
				for($i=0;$i<7;$i++){
					$date=date('Y-m-d',strtotime(date('Y-m-d').' +'.$i.' day'));
					$result_arr['y_content'][]=array(
						'date'=>$date,
						'w'=>$week_arr[date('w',strtotime($date))],
						'list'=>M('oa_y_content')->table('classset as c,oa_y_content as oa')->field('c.name as grade,oa.class,oa.teacher,oa.subject,oa.nonumber,oa.content')->where('oa.class in ('.$ids.') and oa.grade=c.id and oa.state=1 and oa.ordertime='.strtotime(date('Y-m-d').' +'.$i.' day'))->select()
					);
				}
				$day_0=$result_arr['y_content'][0];
				$day_1=$result_arr['y_content'][1];
				$day_2=$result_arr['y_content'][2];
				$day_3=$result_arr['y_content'][3];
				$day_4=$result_arr['y_content'][4];
				$day_5=$result_arr['y_content'][5];
				$day_6=$result_arr['y_content'][6];
				foreach($result_arr['y_class'] as $key=>$val){
					$result_arr['y_tables'][$val['address']]=array(
						array(
							'date'=>date('Y-m-d'),'w'=>$week_arr[date('w',strtotime(date('Y-m-d')))],
							'1st'=>$this->y_course($day_0,1,$val['id']),'2nd'=>$this->y_course($day_0,2,$val['id']),
							'3rd'=>$this->y_course($day_0,3,$val['id']),'4th'=>$this->y_course($day_0,4,$val['id']),
							'5th'=>$this->y_course($day_0,5,$val['id']),'6th'=>$this->y_course($day_0,6,$val['id']),
							'7th'=>$this->y_course($day_0,7,$val['id']),'8th'=>$this->y_course($day_0,8,$val['id']),
						),						
						array(
							'date'=>date('Y-m-d',strtotime(date('Y-m-d').'+1 day')),'w'=>$week_arr[date('w',strtotime(date('Y-m-d').'+1 day'))],
							'1st'=>$this->y_course($day_1,1,$val['id']),'2nd'=>$this->y_course($day_1,2,$val['id']),
							'3rd'=>$this->y_course($day_1,3,$val['id']),'4th'=>$this->y_course($day_1,4,$val['id']),
							'5th'=>$this->y_course($day_1,5,$val['id']),'6th'=>$this->y_course($day_1,6,$val['id']),
							'7th'=>$this->y_course($day_1,7,$val['id']),'8th'=>$this->y_course($day_1,8,$val['id']),
						),						
						array(
							'date'=>date('Y-m-d',strtotime(date('Y-m-d').'+2 day')),'w'=>$week_arr[date('w',strtotime(date('Y-m-d').'+2 day'))],
							'1st'=>$this->y_course($day_2,1,$val['id']),'2nd'=>$this->y_course($day_2,2,$val['id']),
							'3rd'=>$this->y_course($day_2,3,$val['id']),'4th'=>$this->y_course($day_2,4,$val['id']),
							'5th'=>$this->y_course($day_2,5,$val['id']),'6th'=>$this->y_course($day_2,6,$val['id']),
							'7th'=>$this->y_course($day_2,7,$val['id']),'8th'=>$this->y_course($day_2,8,$val['id']),
						),						
						array(
							'date'=>date('Y-m-d',strtotime(date('Y-m-d').'+3 day')),'w'=>$week_arr[date('w',strtotime(date('Y-m-d').'+3 day'))],
							'1st'=>$this->y_course($day_3,1,$val['id']),'2nd'=>$this->y_course($day_3,2,$val['id']),
							'3rd'=>$this->y_course($day_3,3,$val['id']),'4th'=>$this->y_course($day_3,4,$val['id']),
							'5th'=>$this->y_course($day_3,5,$val['id']),'6th'=>$this->y_course($day_3,6,$val['id']),
							'7th'=>$this->y_course($day_3,7,$val['id']),'8th'=>$this->y_course($day_3,8,$val['id']),
						),						
						array(
							'date'=>date('Y-m-d',strtotime(date('Y-m-d').'+4 day')),'w'=>$week_arr[date('w',strtotime(date('Y-m-d').'+4 day'))],
							'1st'=>$this->y_course($day_4,1,$val['id']),'2nd'=>$this->y_course($day_4,2,$val['id']),
							'3rd'=>$this->y_course($day_4,3,$val['id']),'4th'=>$this->y_course($day_4,4,$val['id']),
							'5th'=>$this->y_course($day_4,5,$val['id']),'6th'=>$this->y_course($day_4,6,$val['id']),
							'7th'=>$this->y_course($day_4,7,$val['id']),'8th'=>$this->y_course($day_4,8,$val['id']),
						),
						array(
							'date'=>date('Y-m-d',strtotime(date('Y-m-d').'+5 day')),'w'=>$week_arr[date('w',strtotime(date('Y-m-d').'+5 day'))],
							'1st'=>$this->y_course($day_5,1,$val['id']),'2nd'=>$this->y_course($day_5,2,$val['id']),
							'3rd'=>$this->y_course($day_5,3,$val['id']),'4th'=>$this->y_course($day_5,4,$val['id']),
							'5th'=>$this->y_course($day_5,5,$val['id']),'6th'=>$this->y_course($day_5,6,$val['id']),
							'7th'=>$this->y_course($day_5,7,$val['id']),'8th'=>$this->y_course($day_5,8,$val['id']),
						),
						array(
							'date'=>date('Y-m-d',strtotime(date('Y-m-d').'+6 day')),'w'=>$week_arr[date('w',strtotime(date('Y-m-d').'+6 day'))],
							'1st'=>$this->y_course($day_6,1,$val['id']),'2nd'=>$this->y_course($day_6,2,$val['id']),
							'3rd'=>$this->y_course($day_6,3,$val['id']),'4th'=>$this->y_course($day_6,4,$val['id']),
							'5th'=>$this->y_course($day_6,5,$val['id']),'6th'=>$this->y_course($day_6,6,$val['id']),
							'7th'=>$this->y_course($day_6,7,$val['id']),'8th'=>$this->y_course($day_6,8,$val['id']),
						),
					);
				}
				//今天的预约课
				foreach($result_arr['y_content'] as $key=>$val){
					if($val['date']==date('Y-m-d')){
						foreach($result_arr['y_class'] as $k=>$v){
							foreach($val['list'] as $sub_k=>&$sub_v){
								if($sub_v['class']==$v['id']){
									$sub_v['class']=$v['name'];
								}
							}
						}
						$result_arr['y_today']=$val['list'];
					}
				}
				$this->assign('result_arr',$result_arr);
				$this->display('lab');
			end;
		}					
	}

	function checkin(){	//演示实验室登记
		$db=M('oa_s_content');
		$method=I('get.method')==''?'show':I('get.method');
		switch($method){
			case 'show':
				$result_arr=$db->table('members as m,oa_s_content as oa')->field('oa.grade,oa.nonum,oa.title,oa.content,oa.intime,oa.state,m.realname')->where('oa.userid=m.id')->select();
				foreach($result_arr as $key=>&$val){
					$val['grade']=C('grade')[$val['grade']];
					$val['state']=C('s_state')[$val['state']];
				}
				// echo '<pre>';
				// print_r($result_arr);
				// echo '</pre>';				
				$this->assign('result_arr',$result_arr);
				$this->display('checkin');			
			end;
		}
	}
}