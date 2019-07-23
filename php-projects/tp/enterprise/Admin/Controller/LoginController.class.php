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
		if($_POST['action']=='login'){
			$db=M('admin');
			$pass=md5($_POST['pass']);
			$met_login_code=1;
			//登陆验证码判断
			if($met_login_code==1){
				require_once APP_PATH.'/Admin/Org/captcha.class.php';
				$captcha= new \Captcha();
				if(!$captcha->CheckCode($_POST['code'])){
					echo("<script type='text/javascript'> alert('验证码错误!');location.href='index.php?m=Admin&c=Login&a=login';</script>");
					exit;
				}
			}
			$admin=$db->where('name=\''.$_POST['name'].'\'')->find();
			if (!$admin){
				echo("<script type='text/javascript'> alert('用户名不存在!');location.href='index.php?m=Admin&c=Login&a=login';</script>");
				exit;
			}elseif($admin['pass']!==$pass){
				echo("<script type='text/javascript'> alert('密码错误!');location.href='index.php?m=Admin&c=Login&a=login';</script>");
				exit;
			}else{ 
				cookie('admin',$admin);
				$data['modify_date']=time();
				$data['login']=$admin['login']+1;
				$data['modify_ip']=get_client_ip(1);
				$db->where('id='.$admin['id'])->save($data);
			}
			redirect('index.php?m=Admin&c=Index&a=index');
		}
	}
	
	public function code(){
		/**验证码显示**/
		require_once APP_PATH.'/Admin/Org/captcha.class.php';
		$captcha= new \Captcha();
		$captcha->OutCheckImage();
	}
	
	public function logout(){
		cookie('admin',null);
		cookie('flag',2);	//成功退出
		redirect('index.php?m=Admin&c=Login&a=login');
	}
}