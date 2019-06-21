<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    public function login(){
		$user=cookie('user');
		if($user!=''){
			redirect('index.php?m=Home&c=Index&a=hall');
		}
		$this->display();	
	} 
	public function loginIn(){
		if($_POST['name']&&$_POST['password']){
			$user=M('user_ddz')->where('name=\''.$_POST['name'].'\' and password=\''.md5($_POST['password']).'\'')->find();
			if($user){
				cookie('user',$user);
				redirect('index.php?m=Home&c=Index&a=hall');
			}else{
				message("账号/密码不正确！",'index.php?m=Home&c=User&a=login');
			}
		}else{
			message("请把资料填写完整！",'index.php?m=Home&c=User&a=login');
		}
	}
	public function register(){
		$user=cookie('user');
		if($user!=''){
			redirect('index.php?m=Home&c=Index&a=hall');
		}
		$this->display();
	
	}
	public function registerIn(){
		if($_POST['name']&&$_POST['password']&&$_POST['comform_password']){
			if($_POST['password']!=$_POST['comform_password']){
				message('两次输入的密码不一致，请重新填写！',"index.php?m=Home&c=User&a=register");
			}
			$user=M('user_ddz')->where('name=\''.$_POST['name'].'\'')->find();
			if($user){
				message('抱赚，账号'.$_POST['name'].'已经存在！', "index.php?m=Home&c=User&a=register");
			}else{
				$user=array('name'=>$_POST['name'],'password'=>md5($_POST['password']));
				if(M('user_ddz')->add($user)){
					message("注册成功，请登录游戏！",'index.php?m=Home&c=User&a=login');
				}else{
					message("注册失败，请稍后重试！",'index.php?m=Home&c=User&a=register');
				}
			}
		}else{
			message("请把资料填写完整！",'index.php?m=Home&c=User&a=register');
		}
	}
	public function logout(){
		cookie('user',null);
		redirect('index.php?m=Home&c=User&a=login');
	}
}