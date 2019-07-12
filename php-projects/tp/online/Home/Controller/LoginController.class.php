<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function login(){
		$this->display();
	}
	
	public function loginIn(){
		$user=M('user')->where('number=\''.$_POST['number'].'\' and pass=\''.$_POST['pass'].'\'')->find();
		
		if($user){
			cookie('user',$user);
			echo '<script type="text/javascript">alert("登录成功!"); window.location.href="index.php?m=Home&c=Exam&a=hall";</script>';
		}else{
			echo "登录失败!";
		}
	}
	
	public function register(){
		$this->display();
	}
	
	public function register_ok(){
		header('Content-Type: text/xml');
		//创建XML头
		echo '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>';
		//创建<response>元素
		echo '<response>';
		//获取用户姓名
		$data['name']=$_GET['name'];
		$data['tel']=$_GET['tel'];
		$data['address']=$_GET['address'];
		$data['number']=substr(mt_rand(100000,999999),0,6);
		$data['pass']=substr(mt_rand(100000,999999),0,6);
		//根据从客户端获取的用户创建输出
		if(M('user')->add($data)){
			echo '用户注册成功，这是您的准考证号码'.$data['number'].'和密码'.$data['pass'];
		}
		//关闭<response>元素
		echo '</response>';
	}
	
	public function logout(){
		cookie('user',null);
		redirect('index.php?m=Home&c=Login&a=login');
	}
}