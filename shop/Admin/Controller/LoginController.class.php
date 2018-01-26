<?php
//图片中心控制器
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{	
	public function login(){
		$this->display('login');
	}
	
	//验证登录
	public function loginIn(){
		$username=I('post.username'); 
		$password=md5(I('post.password')); 

		$db=M('cart_users');
		$data=$db->where(array('username'=>$username,'password'=>$password))->find();
		if(!$data){
            $result_arr['msg']='用户名或密码错误!';
        }else{
			cookie('username',$username);
			cookie('userid',$data['id']);	//用户真实姓名
			$result_arr=array('status'=>1);
		}
		echo json_encode($result_arr);
	}
	
	//退出
	public function logout(){
		cookie('username',null);
		cookie('userid',null);
		redirect('index.php?m=Admin&c=Login&a=login');
	}
}