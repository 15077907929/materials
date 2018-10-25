<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
		M('conf')->where('id=1')->setInc('pv',1);	//pv加1
		$res['conf']=M('conf')->where('id=1')->find();
		$res['user_num']=count(M('user')->select());
		$this->assign('res',$res);
		$this->display('index');
	}
}