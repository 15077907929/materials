<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\Navs;

class NavsController extends CommonController{	
    public function index(){
		$navs=Navs::paginate(10);
		return view('Admin/Navs/navs')->with('navs',$navs);
	}
	
	public function create(){
		return view('Admin/Navs/navs_create');
	}
	
	public function store(){
		$input=Input::except(['_token','sub']);
		$rules=['name'=>'required','url'=>'required'];
		$validator=Validator::make($input,$rules);
		if($validator->passes()){
			$re=Navs::create($input);
			if($re){
				return redirect('admin/navs');
			}else{
				return back()->with('errors','数据填充失败，请稍后重试');
			}
		}else{
			return back()->withErrors($validator);
		}
	}
	
	public function edit($id){
		$field=Navs::find($id);
		return view('Admin/Navs/navs_edit')->with('field',$field);
	}
	
	public function update($id){
		$input=Input::except('_token','_method','sub');
		$re=Navs::where('id',$id)->update($input);
		if($re){
			return redirect('admin/navs');
		}else{
			return back()->with('error','分类信息更新失败，请稍后重试');
		}
	}
	
    public function destroy($id){
        $field=Navs::find($id);
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
			$cate=Navs::find($input['id']);
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
