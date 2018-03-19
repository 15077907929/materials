<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class BasicSetController extends CommonController {
	public function password(){
		if($_POST){
			$method=$input['method'];
			switch ($method){
				case 'pass':
					$rules=['pass_n'=>'required|between:6,20|confirmed',];
					$messages=[
						'pass_n.required'=>'新密码不能为空',
						'pass_n.between'=>'新密码必须在6-20位之间',
						'pass_n.confirmed'=>'新密码和确认密码不匹配',
					];
					$validator=Validator::make($input,$rules,$messages);
					if($validator->passes()){
						$user=User::first();
						$_password=Crypt::decrypt($user->user_pass);
						if($input['pass_o']==$_password){
							$user->user_pass=Crypt::encrypt($input['pass_n']);
							$user->update();
							echo json_encode(['state'=>1,'msg'=>'修改密码成功']);
						}else{
							echo json_encode(['state'=>2,'msg'=>'原密码错误']);
						}
					}else{
						$msg='';
						$i=1;
						foreach($validator->errors()->all() as $error){
							$msg.=$i.'.'.$error.'&nbsp;&nbsp;&nbsp;&nbsp;';
							$i++;
						}
						echo json_encode(['state'=>3,'msg'=>$msg]);
					}
				break;
			}
		}else{
			$this->display('Basic_set/password');
		}
	}
	
	public function basic_set(){
		$db=M('basic_set');
		$rst['bsc']=$db->where('id=1')->find();
		if($_POST){
			$rst['bsc']['status']=$_POST['status'];
			$db->save($rst['bsc']);
			$rst['msg']='修改成功';
		}
		$this->assign('rst',$rst);
		$this->display('Basic_set/basic_set');
	}
}