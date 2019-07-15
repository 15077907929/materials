<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function login(){
		if($_POST){
			$res['action']=$_POST['action'];
			if($_POST['unum']==session('randValid')){
				$admin=M('admin')->where('name=\''.$_POST['name'].'\'')->find();
				
				if($admin){
					if($admin['pwd']==md5($_POST['pwd'])){
						cookie('admin',$admin);
						$res['msg']='成功登录，请稍候……<br><a href="'.$pageUrl.'">如果浏览器没有自动返回，请点击此处返回</a>';
						$res['msg'].='<meta http-equiv="refresh" content="2; url=index.php">';
					}else{
						$res['msg']='<script type="text/javascript">alert("密码不正确！");history.go(-1)</script>';
					}
				}else{
					$res['msg']='<script type="text/javascript">alert("管理帐号不正确！");history.go(-1)</script>';
				}
			}else{
				$res['msg']='<script type="text/javascript">alert("验证码不正确，请重新输入……");history.go(-1)</script>';
			}
		}
		$this->assign('res',$res);
		$this->display();
	}
	
	public function logout(){
		cookie('admin',null);
		$this->display();
	}
}