<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function __construct(){
		parent::__construct();
		$admin=cookie('admin');
		if($admin==''){
			echo '<script type="text/javascript">location.href="index.php?m=Home&c=Login&a=login";</script>';
		}
	} 	
}