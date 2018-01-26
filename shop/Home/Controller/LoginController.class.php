<?php
//会员登录控制器
namespace Home\Controller;
use Think\Controller;
class LoginController extends CommonController {
	public function login(){
		$this->display();
	}
	
	public function loginIn(){
		$username=I('get.username');
		$password=md5(I('get.password'));
		$user=M('cart_users')->where('username=\''.$username.'\' and password=\''.$password.'\'')->find();
		if(!$user){
			$result_arr['state']=0;
			$result_arr['info']='用户名或密码错误!';
		}else{
			cookie('username',$username);
			cookie('userid',$user['id']);
			$result_arr['state']=1;
			$result_arr['info']='登录成功!';			
		}
		$result_arr=json_encode($result_arr);
		echo $result_arr;
	}
	
	public function logined(){
		$this->display();
	}
	
	public function logout(){
		cookie('username',null);
		cookie('userid',null);
		$this->display();
	}
	
	public function code(){
		$config =    array(
			'expire'=>60, //验证码有效期
		);
		$Verify=new \Think\Verify($config);
		$Verify->entry();			
	}
	
	public function register(){
		$method=(I('get.method')=='')?'show':I('get.method');
		switch($method){
			case 'show':
			
			break;
			case 'ajax':
				$verify=new \Think\Verify();	//判断验证码是否正确
				if(!$verify->check(I('post.code'))){
					$result_arr['msg']='验证码错误!';
					$result_arr['state']=1;
				}else{
					$arr=array(
						'username'=>I('post.username'),
						'password'=>md5(I('post.password')),
						'email'=>I('post.email'),
						'sex'=>I('post.sex'),
					);
					if(M('cart_users')->add($arr)){
						$result_arr['msg']='注册成功!';
						$result_arr['state']=2;						
					}else{
						$result_arr['msg']='注册失败!';
						$result_arr['state']=3;							
					}
				}
				echo json_encode($result_arr);
				exit;
			break;
		}
		$this->display();
	}
	
	public function forget(){
		$method=(I('get.method')=='')?'show':I('get.method');
		switch($method){
			case 'show':
			
			break;
			case 'ajax':
				$user=M('cart_users')->field('id,username,email')->where('username=\''.I('get.username').'\'')->find();
				if(empty($user)){
					$result_arr['msg']='用户名不存在!';
				}else{
					$link='http://10.80.8.128/shop/index.php?m=Home&c=Login&a=reset';
					$str = '您好!'.$user['username'].'请点击下面的链接重置您的密码：'. $link;
					$result_arr['msg']='系统已向您的邮箱:'.$user['email'].'发送了一封邮件,请登录到您的邮箱及时重置您的密码！!';				
				}
				echo json_encode($result_arr);
				exit;
			break;
		}
		$this->display();
	}
}