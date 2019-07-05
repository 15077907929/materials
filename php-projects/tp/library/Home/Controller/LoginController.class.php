<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function login(){
		$user=cookie('user');
		if($user!=''){
			redirect('index.php?m=Home&c=Index&a=index');
		}
		$this->display();	
	} 

	public function chklogin(){
		$db=M('manager');      
		$user=$db->where('name=\''.$_POST['name'].'\' and pwd=\''.md5($_POST['pwd']).'\'')->find();
		if(!$user){
			echo "<script type='text/javascript'>alert('您输入的管理员名称错误，请重新输入！');history.back();</script>";
			exit;
		}else{
			cookie('user',$user);
			echo "<script>alert('管理员登录成功!');window.location='index.php';</script>";
		}	
	}
	
	public function safequit(){
		cookie('user',null);
		redirect('index.php?m=Home&c=Login&a=login');
	}
}