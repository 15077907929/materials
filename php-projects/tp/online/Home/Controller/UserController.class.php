<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class UserController extends CommonController {
    public function score(){
		$res['subjects']=M('subject')->select();
		if($_POST){
			$res['users']=M('user')->where('id='.cookie('user')['id'].' and subject=\''.$_POST['subject'].'\'')->select();
			$res['subject']=$_POST['subject'];
		}
		$this->assign('res',$res);
		$this->display();
	}
	
	public function password(){
		$db=M('user');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				
			break;
			case 'edit':
				$pass=$_POST['pass'];
				$data['pass']=$_POST['pass2'];
				if($pass!=cookie('user')['pass']){
					echo '<script type="text/javascript">alert("您输入的准考证号码和密码不符，请重新输入！"); window.location.href="index.php?m=Home&c=User&a=password";</script>';
				}else{
					if($db->where('number=\''.$_POST['number'].'\'')->save($data)){
						echo '<script type="text/javascript">alert("密码更新成功！"); window.location.href="index.php?m=Home&c=User&a=password";</script>';
					}
				}			
			break;
		}
		$this->assign('res',$res);
		$this->display();
	}
}