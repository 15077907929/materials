<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
	public function login(){
		if(cookie('admin_name') && cookie('admin_id')){
			redirect('index.php?m=Admin&c=Index&a=index');
		}
		if($_POST){
			$code=I('post.code');
			if(strtolower($code)!=cookie('code')){
				$result_arr['msg']='验证码错误';
			}else{
				$admin_name=I('post.admin_name'); 
				$admin_pass=md5(I('post.admin_pass'));
				$db=M('admin_table');
				$admin=$db->where(array('admin_name'=>$admin_name,'admin_pass'=>$admin_pass))->find();
				if(!$admin){
					$result_arr['msg']='用户名或密码错误!';
				}else{
					cookie('admin_name',$admin['admin_name']);
					cookie('admin_id',$admin['id']);
					redirect('index.php?m=Admin&c=Index&a=index');
				}
			}
		}
		$this->assign('result_arr',$result_arr);
		$this->display('login');
	}
	
	public function code(){
		$_vc = new \Org\Util\captcha\ValidateCode();	//实例化一个对象
		$_vc->doimg();
		cookie('code',$_vc->getCode());	//验证码保存到cookie中
		exit;
	}
	
	//退出
	public function logout(){
		cookie('admin_name',null);
		cookie('admin_id',null);
		redirect('index.php?m=Admin&c=Login&a=login');
	}
}