<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function __construct(){
		parent::__construct();
		$user=cookie('user');
		if($user==''){
			echo '<script type="text/javascript">window.location.href="index.php?m=Admin&c=Login&a=login";</script>';
		}
		$this->assign('user',$user);
	} 	
}