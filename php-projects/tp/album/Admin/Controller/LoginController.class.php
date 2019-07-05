<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function login(){
		$user=cookie('user');
		if($user!=''){
			redirect('index.php?m=Admin&c=Index&a=index');
		}
		$this->display();	
	} 

	public function loginIn(){
		$db=M('admin');      
		$user=$db->where('username=\''.$_POST['loginname'].'\' and userpass=\''.md5($_POST['operatorpw']).'\'')->find();
		if(!$user){
			cookie('flag',1);	//用户名密码错误
			redirect('index.php?m=Admin&c=Login&a=login');
		}else{
			if($_POST['remember']){
				$expire_time=86400*365;
				cookie('user',$user,$expire_time);
			}else{
				cookie('user',$user);
			}
			redirect('index.php?m=Admin&c=Index&a=index');
		}	
	}
	
	public function logout(){
		cookie('user',null);
		cookie('flag',2);	//成功退出
		redirect('index.php?m=Admin&c=Login&a=login');
	}
}