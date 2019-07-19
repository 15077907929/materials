<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class QuestionController extends CommonController {
    public function question(){
		$res['class1_info']=M('column')->where('id='.$_GET['class1'])->find();
		// echo '<pre>';
		// print_r($res);
		// echo '</pre>';
		$this->assign('res',$res);
		$this->display();
	}
}