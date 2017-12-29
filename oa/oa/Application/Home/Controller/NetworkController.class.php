<?php
namespace Home\Controller;	//网络控制器
use Think\Controller;
class NetworkController extends CommonController{
	public function ftp(){	//内网ftp
		$db=M('oa_');
		$method=I('get.method')==''?'show':I('get.method');
		switch($method){
			case 'show':	
				$this->assign('result_arr',$result_arr);
				$this->display();			
			break;
		}
	}
	
	public function discuss(){	//讨论区
		$db=M('oa_');
		$method=I('get.method')==''?'show':I('get.method');
		switch($method){
			case 'show':	//收件箱
				$this->assign('result_arr',$result_arr);
				$this->display();			
			break;
		}
	}	
	
	public function meeting(){	//网络会议
		$db=M('oa_');
		$method=I('get.method')==''?'show':I('get.method');
		switch($method){
			case 'show':	//收件箱
				$this->assign('result_arr',$result_arr);
				$this->display();			
			break;
		}
	}
	
	public function survey(){	//网络调查
		$db=M('oa_');
		$method=I('get.method')==''?'show':I('get.method');
		switch($method){
			case 'show':	//收件箱
				$this->assign('result_arr',$result_arr);
				$this->display();			
			break;
		}
	}
}