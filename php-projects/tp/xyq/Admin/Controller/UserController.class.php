<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller {
    public function login(){
		$user=cookie('user');
		if($user!=''){
			redirect('index.php?m=Admin&c=Index&a=index');
		}
		$this->display();
	}
	public function loginIn(){
		if(!empty($_POST['username'])){
			if($_POST['username'] == C('admin')){
				if($_POST['password'] == C('password')){
					cookie('user',C('admin'));
					echo "<script>alert('登陆成功!');location.href='index.php?m=Admin&c=Index&a=index';</script>";
				}else{
					echo "<script>alert('密码错误!');window.history.back();</script>";
				}
			}else{
				echo "<script>alert('用户名错误!');window.history.back();</script>";
			}
		}
	}
	public function logout(){
		cookie('user',null);
		redirect('index.php?m=Admin&c=User&a=login');
	}
}