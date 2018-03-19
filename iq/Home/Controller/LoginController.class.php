<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function login(){
		if($_POST['key']!=''){	// 登录验证
			$sys_ststus=M('basic_set')->where('id=1')->find()['status'];
			if($sys_ststus==0){
				$data['msg'] = '系统已关闭，请联系系统管理员！';
			}else{
				$user=M('users')->field('id,key,name,lock,start_time')->where('tel=\''.$_POST['tel'].'\'and `key`=\''.$_POST['key'].'\'')->find();
				if(!empty($user)){
					if($user['lock']==1){	// 一个卡号同时只允许一人使用
						$data['msg']='口令正在使用，请联系管理员';
					}else{
						if(empty($user['start_time'])){	// 首次登录
							$user['start_time']=date('Y-m-d H:i:s');
						}
						$user['lock']=1;
						$user['name']=$_POST['name'];
						M('users')->where('id='.$user['id'])->save($user);
						cookie('user',$user);
						$this->redirect('Index/index');
					}
				}else{
					$data['msg']='没有此口令，请尝试重新获取';
				}
			}
			$this->assign('data',$data);
		}
		$this->display('login');
	}
	
	public function get_key(){
		$method=$_GET['action'];
		switch ($method){
			case 'create':
				$sys_ststus=M('basic_set')->where('id=1')->find()['status'];
				if($sys_ststus==0){
					$result = ['status' => 0];
					$result['msg'] = '系统已关闭，请联系系统管理员！';			
					// echo json_encode( $result);exit;
				}else{
					$tel =$_GET['tel'];
					if( !empty( $tel)){ 	//检查手机号是否已经注册过
						$this->check_tel($tel);
					}
					//生成用户数据
					$user['key']=substr(md5('a'.time()), -6);
					$user['tel']=$_GET['tel'];
					$user['create_time']=date('Y-m-d H:i:s');
					$user['rest']=2400;
					if(!M('users')->add($user)){
						$result = ['status' => 0];
						$result['msg'] = '生成失败，请再重试一次( Duplicate)！';
					}else{
						if(!empty( $tel)) {
							$sms_content        = urlencode(str_replace('{token}', $user['key'], '您当前的访问口令是：{token} 请访问 http://iq.joymeng.com/a 继续完成测试，谢谢'));
							$sms_send_url       = "http://sendmsg.joymeng.com/index.php?let_mod=Api&let_ctrl=SendSms&let_act=index&phone_num={$tel}&content={$sms_content}";
							$result['sms_send'] = file_get_contents($sms_send_url);
							$result['status'] = 1;
							$result['msg'] = '发送成功，收到短信后凭口令登入！';
						}
					}
				}
				echo json_encode( $result);exit;			
			break;
		}
		$this->display('get_key');
	}
	
	public function check_tel($tel){
		$user = M('users')->where('tel=\''.$tel.'\'')->find(); 
		if(!empty($user)){
			$result['status'] = -2;
			$result['msg'] = '此手机已经开始了测试！';
			echo json_encode( $result);
			exit;
		}
	}
	
	//退出
	public function logout(){
		cookie('user',null);
		cookie('q_start',null);
		cookie('answer',null);
		redirect('index.php?m=Home&c=Login&a=login');
	}
}