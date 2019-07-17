<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class AboutController extends CommonController {
    public function show(){
		$res['info']=M('column')->where('id='.$_GET['id'])->find();
		// echo '<pre>';
		// print_r($res);
		// echo '</pre>';
		$this->assign('res',$res);
		$this->display();
	}
}