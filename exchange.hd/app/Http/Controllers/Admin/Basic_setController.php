<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\User;
use App\Http\Models\Category;

class Basic_setController extends CommonController{	
	public function password(){
		if($input=Input::all()){
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
			return view('Admin/Basic_set/password');
		}
	}

    public function category(){
		$category=Category::getTree();
		return view('Admin/Basic_set/category')->with('category',$category);
	}

	public function change_order(){
		$input=Input::all();
		$rules=['no_order'=>'required|numeric'];
		$validator=Validator::make($input,$rules);
		if(!$validator->passes()){	
			$data=['status'=>2,'msg'=>'分类排序必须为数字,请重新填写！'];	
		}else{					
			$cate=Category::find($input['id']);
			$cate->no_order=$input['no_order'];
			$re=$cate->update();
			if($re){
				$data=['status'=>1,'msg'=>'分类排序更新成功！'];
			}else{
				$data=['status'=>0,'msg'=>'分类排序更新失败,请稍后重试！'];			
			}
			
		}
		return $data;
	}
}
