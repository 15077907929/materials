<?php
//图片中心控制器
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{	
	public function index(){
		$this->display();
	}
	
	public function chknumber(){
		$config =    array(
			'expire'=>60, //验证码有效期
		);
		$Verify=new \Think\Verify($config);
		$Verify->entry();	
	}
	
	//验证登录
	public function loginIn(){
		$username=I('post.username'); 
		$password=md5(I('post.password')); 
		$chknumber=I('post.chknumber');
		$verify=new \Think\Verify();	//判断验证码是否正确
		if(!$verify->check($chknumber,$id)){
			$this->error('验证码错误!');
		}
		$db=M('web_admin_table');
		$data=$db->where(array('username'=>$username,'password'=>$password))->select()[0];
		if(!$data){
            $this->error('用户名或密码错误!');
        }else{
			cookie('username',$username);
			cookie('realname',$data['realname']);	//用户真实姓名
			// exit;
			redirect('index.php?m=Admin&c=Index&a=index');
		}
	}
	
	//退出
	public function logout(){
		cookie('username',null);
		redirect('index.php?m=Admin&c=Login&a=index');
	}
}