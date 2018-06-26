<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\User;

class IndexController extends CommonController{
	public function index(){
		$cur_nav='index';
		return view('Admin/index',compact('cur_nav'));	
	}	

	public function sys_info(){
		return view('Admin/sys_info');	
	}		
}
