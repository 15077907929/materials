<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class AdminController extends CommonController {
    public function index(){
		$db=M('admin');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				$res['subjects']=$db->select();
			break;
			case 'add':
				if($db->add(array('name'=>$_POST['name']))){
					echo '<script type="text/javascript">alert("考题类别添加成功");window.location="index.php?m=Admin&c=Subject&a=index";</script>';
				}
			break;
			case 'del':
				if($db->where('id='.$_GET['id'])->delete()){
					echo '<script type="text/javascript">alert("考题类别删除成功");window.location="index.php?m=Admin&c=Subject&a=index";</script>';
				}				
			break;
		}
		$this->assign('res',$res);
		$this->display();
	}
}