<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\User;
use App\Http\Models\Category;

class CategoryController extends CommonController{	
    public function index(){
		$category=Category::getTree();
		return view('Admin/Basic_set/Category/category')->with('category',$category);
	}
	
	public function create(){
		$rst['top_c']=Category::where('pid',0)->get();
		return view('Admin/Basic_set/Category/category_create')->with('rst',$rst);
	}
	
	public function store(){
		$input=Input::except(['_token','sub']);
		$input['addtime']=time();
		$rules=['name'=>'required','no_order'=>'numeric'];
		$validator=Validator::make($input,$rules);
		if($validator->passes()){
			$re=Category::create($input);
			if($re){
				return redirect('admin/basic_set/category');
			}else{
				return back()->with('errors','数据填充失败，请稍后重试');
			}
		}else{
			return back()->withErrors($validator);
		}
	}
	
	public function edit($id){
		$rst['top_c']=Category::where('pid',0)->get();
		$field=Category::find($id);
		return view('Admin/Basic_set/Category/category_edit')->with('rst',$rst)->with('field',$field);
	}
	
	public function update($id){
		$input=Input::except('_token','_method','sub');
		$re=Category::where('id',$id)->update($input);
		if($re){
			return redirect('admin/basic_set/category');
		}else{
			return back()->with('error','分类信息更新失败，请稍后重试');
		}
	}
	
    public function destroy($id){
        $field=Category::find($id);
		$sub=Category::where('pid',$id)->get();
		if(count($sub)){
			$data=['status'=>0,'msg'=>'请先删除所有子分类，再删除父级分类！'];	
		}else{
			if($field->delete()){
				$data=['status'=>1,'msg'=>'删除成功！'];	
			}else{
				$data=['status'=>0,'msg'=>'删除失败,请稍后重试！'];	
			}
		}
		return $data;
    }
}
