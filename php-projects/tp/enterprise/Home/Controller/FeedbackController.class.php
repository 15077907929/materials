<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class FeedbackController extends CommonController {
    public function feedback(){
		$res['info']=M('column')->where('module=0')->find();
		// echo '<pre>';
		// print_r($res);
		// echo '</pre>';
		$this->assign('res',$res);
		$this->display();
	}
}