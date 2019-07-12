<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function __construct(){
		parent::__construct();
		$admin=cookie('admin');
		if($admin==''){
			echo '<script style="text/javascript">alert("请您正确登录！");window.location.href="index.php?m=Admin&c=Login&a=login";</script>';
		}
		$this->assign('admin',$admin);
	} 	
}