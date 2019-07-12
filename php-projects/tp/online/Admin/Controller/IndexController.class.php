<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
		$db=M('user');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				$res['users']=$db->select();
			break;
			case 'search':
				$res['number']=$_POST['number'];
				$res['users']=$db->where('number=\''.$_POST['number'].'\'')->select();
			break;
			case 'del':
				if($db->where('id='.$_GET['id'])->delete()){
					echo '<script type="text/javascript">alert("考生信息删除成功");window.location="index.php?m=Admin&c=Index&a=index";</script>';
				}				
			break;
		}
		$this->assign('res',$res);
		$this->display();
	}
}