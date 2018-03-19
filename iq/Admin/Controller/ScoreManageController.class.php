<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class ScoreManageController extends CommonController {
    public function slist(){
		$result_arr['scores']=M('score')->table('users as u,score as s')->field('s.*,u.tel,u.rest,u.name,u.lock')->where('s.user_id = u.id')->select();
		foreach($result_arr['scores'] as $key=>&$val){
			$val['use_time']=floor((2400-$val['rest'])/60).'" '.((2400-$val['rest'])%60);
		}
		$this->assign('result_arr',$result_arr);
		$this->display('slist');
	}
	
	public function index(){
		$method = $_GET['method'] ? $_GET['method'] : '';
		$db=M('score');		
		switch ($method){
			case 'del':
				$id=I('get.id');
				$db->where('id='.$id)->delete();
				$this->redirect('index.php?m=Admin&c=ScoreManage&a=slist');
			break;		
		}
	}
}