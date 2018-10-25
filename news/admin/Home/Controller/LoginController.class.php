<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
	public function login(){
		if(cookie('user_name') && cookie('id')){
			redirect('index.php?m=Home&c=Index&a=index');
		}
		$this->display('login');
	}
	
	public function loginIn(){
		if($_POST){
			$code=I('post.code');
			if(false){
				cookie('msg','验证码错误');
				redirect('index.php?m=Home&c=Login&a=login');
			}else{
				$user_name=trim(I('post.user_name')); 
				$user_pass=md5(trim(I('post.user_pass')));
				$db=M('user');
				$user=$db->where(array('user_name'=>$user_name,'user_pass'=>$user_pass))->find();
				if(!$user){
					cookie('msg','用户名或密码错误');
					redirect('index.php?m=Home&c=Login&a=login');
				}else{
					cookie('user_name',$user['user_name']);
					cookie('id',$user['id']);
					cookie('appid',$user['appid']);
					cookie('user_type',$user['user_type']);
					cookie('msg',null);
					redirect('index.php?m=Home&c=Index&a=index');
				}
			}
		}		
	}
	
	public function code(){
		ob_clean();
		require(THINK_PATH.'Library/Org/Util/captcha/ValidateCode.class.php');
		$_vc = new \ValidateCode();	//实例化一个对象
		$_vc->doimg();
		cookie('code',$_vc->getCode());	//验证码保存到cookie中
		exit;
	}
	
	//退出
	public function logout(){
		cookie('user_name',null);
		cookie('id',null);
		redirect('index.php?m=Home&c=Login&a=login');
	}
}