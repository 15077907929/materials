<?php
namespace Home\Controller;	//行政管理控制器
use Think\Controller;
class AdmController extends CommonController{
	public function notice(){	//行政通知
		$db=M('oa_articles');
		$s_title_arr=explode(',',C('s_title'));
		$result_arr=$db->table('oa_articles as a,management as m')->where('a.typeid=7 and a.manageid=m.id')->field('a.title,a.s_title,a.author,a.addtime,m.name as management')->select(); 	
		foreach($result_arr as $key=>&$val){
			$val['m']=date('m',$val['addtime']);
			$val['d']=date('d',$val['addtime']);
			$val['addtime']=date('Y-m-d H:i:s',$val['addtime']);
			$val['s_title']=$s_title_arr[$val['s_title']];
		}
		$this->assign('result_arr',$result_arr);
		$this->display('notice');
	}
	
	public function arrangement(){	//工作安排
		$db=M('oa_articles');
		$s_title_arr=explode(',',C('s_title'));
		$result_arr=$db->table('oa_articles as a,management as m')->where('a.typeid=8 and a.manageid=m.id')->field('a.title,a.s_title,a.author,a.addtime,m.name as management')->select(); 
		foreach($result_arr as $key=>&$val){
			$val['m']=date('m',$val['addtime']);
			$val['d']=date('d',$val['addtime']);
			$val['addtime']=date('Y-m-d H:i:s',$val['addtime']);
			$val['s_title']=$s_title_arr[$val['s_title']];
		}

		$this->assign('result_arr',$result_arr);
		$this->display('arrangement');
	}	
	
	public function download(){	//资料下载
		$db=M('oa_articles');
		$s_title_arr=explode(',',C('s_title'));
		$result_arr=$db->table('oa_articles as a,management as m')->where('a.typeid=9 and a.manageid=m.id')->field('a.title,a.s_title,a.author,a.addtime,m.name as management')->select(); 
		foreach($result_arr as $key=>&$val){
			$val['m']=date('m',$val['addtime']);
			$val['d']=date('d',$val['addtime']);
			$val['addtime']=date('Y-m-d H:i:s',$val['addtime']);
			$val['s_title']=$s_title_arr[$val['s_title']];
		}
		$this->assign('result_arr',$result_arr);
		$this->display('download');
	}	
	
	public function meeting(){	//会议通知
		$db=M('oa_articles');
		$s_title_arr=explode(',',C('s_title'));
		$result_arr=$db->table('oa_articles as a,management as m')->where('a.typeid=10 and a.manageid=m.id')->field('a.title,a.s_title,a.author,a.addtime,m.name as management')->select(); 
		foreach($result_arr as $key=>&$val){
			$val['m']=date('m',$val['addtime']);
			$val['d']=date('d',$val['addtime']);
			$val['addtime']=date('Y-m-d H:i:s',$val['addtime']);
			$val['s_title']=$s_title_arr[$val['s_title']];
		}
		$this->assign('result_arr',$result_arr);
		$this->display('meeting');
	}
	
	public function leave(){	//公事病假
		$db=M('oa_leave');
		$method=I('get.method')==''?'today':I('get.method');
		$now=strtotime(date('Y-m-d'));
		$leavetype_arr=explode(',',C('leavetype'));
		switch($method){
			case 'today':
				$result_arr['leave']=$db->where('pass=1 and stime<='.$now.' and etime>='.$now)->select();
				foreach($result_arr['leave'] as $key=>&$val){
					$val['stime']=date('Y-m-d',$val['stime']);
					$val['etime']=date('Y-m-d',$val['etime']);
					$val['leavetype']=$leavetype_arr[$val['leavetype']];
				}
				$result_arr['m']=date('m');
				// echo '<pre>';
				// print_r($result_arr);
				// echo '</pre>';					
				$this->assign('result_arr',$result_arr);
				$this->display('leave');
			end;
		}		
	}
}