<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\Config;

class ConfigController extends CommonController{	
    public function index(){
		$config=Config::getConfig();
		return view('Admin/Config/config')->with('config',$config);
	}
	
	public function create(){
		return view('Admin/Config/config_create');
	}
	
	public function store(){
		$input=Input::except(['_token','sub']);
		$rules=['title'=>'required','name'=>'required'];
		$validator=Validator::make($input,$rules);
		if($validator->passes()){
			$re=Config::create($input);
			if($re){
				return redirect('admin/config');
			}else{
				return back()->with('errors','数据填充失败，请稍后重试');
			}
		}else{
			return back()->withErrors($validator);
		}
	}
	
	public function edit($id){
		$field=Config::find($id);
		return view('Admin/Config/config_edit')->with('field',$field);
	}
	
	public function update($id){
		$input=Input::except('_token','_method','sub');
		$re=Config::where('id',$id)->update($input);
		if($re){
			return redirect('admin/config');
		}else{
			return back()->with('error','分类信息更新失败，请稍后重试');
		}
	}
	
    public function destroy($id){
        $field=Config::find($id);
		if($field->delete()){
			$data=['status'=>1,'msg'=>'删除成功！'];	
		}else{
			$data=['status'=>0,'msg'=>'删除失败,请稍后重试！'];	
		}
		return $data;
    }
	
	public function show(){

	}
	
	public function change_order(){
		$input=Input::all();
		$rules=['no_order'=>'required|numeric'];
		$validator=Validator::make($input,$rules);
		if(!$validator->passes()){	
			$data=['status'=>2,'msg'=>'分类排序必须为数字,请重新填写！'];	
		}else{					
			$cate=Config::find($input['id']);
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
	
	public function change_content(){
		$input=Input::except('ord','sub','_token');
		foreach($input['id'] as $key=>$val){					
			$conf=Config::where('id',$val)->update(['content'=>$input['content'][$key]]);
		}
		return back()->with('msg','配置信息更新成功！');
	}
}
