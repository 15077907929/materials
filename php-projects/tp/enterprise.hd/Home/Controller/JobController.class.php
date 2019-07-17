<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class JobController extends CommonController {
    public function job(){
		$res['info']=M('column')->where('module=6')->find();
		// echo '<pre>';
		// print_r($res);
		// echo '</pre>';
		$this->assign('res',$res);
		$this->display();
	}
}