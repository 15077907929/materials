<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function login(){
		$this->display();
	}
	
	public function loginIn(){
		$admin=M('admin')->where('name=\''.$_POST['name'].'\' and pwd=\''.md5($_POST['pwd']).'\'')->find();
		if($admin){
			cookie('admin',$admin);
			echo '<script type="text/javascript">alert("登录成功!"); window.location.href="index.php?m=Admin&c=Index&a=index";</script>';
		}else{
			echo '<script type="text/javascript">alert("对不起,用户名或密码输入错误!");history.back();</script>';
			exit;
		}
	}
	
	public function logout(){
		cookie('admin',null);
		redirect('index.php?m=Admin&c=Login&a=login');
	}
}