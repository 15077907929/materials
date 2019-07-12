<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function __construct(){
		parent::__construct();
		$user=cookie('user');
		if($user==''){
			echo '<script style="text/javascript">alert("请正确登录");window.location.href="index.php?m=Home&c=Login&a=login";</script>';
		}
		$this->assign('user',$user);
	} 	
}