<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use App\Http\Models\User;

class LoginController extends CommonController{
	public function login(){
		if(session('user')){
			return redirect('admin/index');
		}
		if($input=Input::all()){
			if(strtolower($input['code'])!=$_SESSION['code']){
				return back()->with('msg','验证码错误');
			}else{
				$user=User::first();	//all()
				if($user['user_name']!=$input['user_name'] || Crypt::decrypt($user['user_pass'])!=$input['user_pass']){
					return back()->with('msg','用户名或密码错误');
				}
				session(['user'=>$user]);
				return redirect('admin/index');
			}
		}
		return view('Admin/login',['xd'=>'xuduo3']);
	}	
	
	public function code(){
		require (app_path().'/Tools/captcha/ValidateCode.class.php');
		$_vc = new \ValidateCode();	//实例化一个对象
		$_vc->doimg();
		$_SESSION['code'] = $_vc->getCode();	//验证码保存到SESSION中
		exit;
	}	
	
	public function logout(){
		session(['user'=>null]);
		return redirect('admin/login');
	}
}
