<?php
//系统登录控制器
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
	public function chknumber(){
		$config =    array(
			'expire'=>60, //验证码有效期
		);
		$Verify=new \Think\Verify($config);
		$Verify->entry();	
	} 
    public function index(){
		$this->show();
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
		
		$db=M('members');
		$data=$db->where(array('username'=>$username,'password'=>$password))->select();
		if(!$data){
			$this->loginfail($username);
            $this->error('用户名或密码错误!');
        }else{
			$this->loginsucceed($username);
			cookie('username',$username);
			cookie('userid',$data[0]['id']);	//用户id
			cookie('realname',$data[0]['realname']);	//用户真实姓名
			$db2=M('management');
			$management_arr=$db2->where('id='.$data[0]['manageid'])->select();
			cookie('manage_name',$management_arr[0]['name']);	//用户所属部门名称
			redirect('index.php?m=Home&c=Index&a=index');
		}
	}
	
	public function logout(){
		cookie('username',null);
		redirect('index.php?m=Home&c=Login&a=index');
	}
	
	//后台登录成功记录
	public function loginsucceed($username,$password=''){
		$db=M('oa_loginlog');
		$data=array('username'=>$username,'password'=>'密码正确','date'=>time(),'ip'=>get_client_ip(1),'result'=>1);
		$db->add($data);
	}	
	
	//后台登录失败记录
	public function loginfail($username,$password=''){
		$db=M('oa_loginlog');
		$data=array('username'=>$username,'password'=>'密码错误','date'=>time(),'ip'=>get_client_ip(1),'result'=>2);
		$db->add($data);
	}
}