<?php
namespace Home\Controller;	//教学管理控制器
use Think\Controller;
class EduController extends CommonController{
	function timetable(){	//课程表
		$db=M('oa_classtable');
		$method=I('get.method')==''?'search':I('get.method');
		switch($method){
			case 'search':
				$result_arr['classset']=M('classset')->select();					
				$this->assign('result_arr',$result_arr);
				$this->display('search');			
			end;
		}
	}
	
	function score(){	//成绩管理
		$db=M('oa_classtable');
		$method=I('get.method')==''?'release':I('get.method');
		switch($method){
			case 'release':
				// echo '<pre>';
				// print_r($classset);
				// echo '</pre>';						
				$this->assign('result_arr',$result_arr);
				$this->display('score');			
			end;
		}
	}
}