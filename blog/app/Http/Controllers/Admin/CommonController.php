<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller{
	public function top(){
		return view('Admin/Common/top');	
	}	
	public function left(){
		return view('Admin/Common/left');	
	}	
	public function left_switch(){
		return view('Admin/Common/left_switch');	
	}	
	public function bottom(){
		return view('Admin/Common/bottom');	
	}

	public function upload(){
		$file=Input::file('Filedata');
		if($file->isValid()){
			if($_POST['method']=='modify'){
				if(isset($_POST['thumb_o'])){
					if(file_exists(base_path().'/public'.$_POST['thumb_o'])){
						unlink(base_path().'/public'.$_POST['thumb_o']);
					}		
				}					
			}
			$extension=$file ->getClientOriginalExtension();	//上传文件的后缀
			$dir='/uploads/thumb/'.date('Ymd').'/';
			$newName=date('His'). mt_rand(100, 999) . '.' . $extension;
			$path=$file->move(base_path().'/public'.$dir, $newName);
			$filePath=$dir.$newName;
			return $filePath;
		}
	}
}
