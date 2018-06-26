<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\Category;
use App\Http\Models\Article;

class CategoryController extends CommonController{	
    public function index(){
		$cur_nav='cate';
		$cate=Category::where('pid',0)->get();
		foreach($cate as &$val){
			$val['sub']=Category::where('pid',$val['id'])->get();
		}	
		return view('Admin/Category/list',compact('cur_nav','cate'));
	}
	
	public function create(){
		$cur_nav='cate';
		$cate=Category::where('pid',0)->get();
		return view('Admin/Category/create',compact('cur_nav','cate'));
	}
	
	public function store(){
		$input=Input::except(['_token','sub']);
		$input['addtime']=date('Y-m-d');
		$rules=['name'=>'required','no_order'=>'numeric'];
		$validator=Validator::make($input,$rules);
		if($validator->passes()){
			$re=Category::create($input);
			if($re){
				return redirect('admin/category');
			}else{
				return back()->with('errors','数据填充失败，请稍后重试');
			}
		}else{
			return back()->withErrors($validator);
		}
	}
	
	public function edit($id){
		$cur_nav='cate';
		$cate=Category::where('pid',0)->get();
		$field=Category::find($id);
		return view('Admin/Category/edit',compact('cur_nav','cate','field'));
	}
	
	public function update($id){
		$input=Input::except('_token','_method','sub');
		$re=Category::where('id',$id)->update($input);
		if($re){
			return redirect('admin/category');
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
			if($field['pid']==0){
				$child_ids=Category::where('pid',$id)->get();	//一级分类下的所有子分类文章
				foreach($child_ids as $val){
					$cate_id_arr[]=$val['id'];
				};
				$arts=Article::whereIn("cate_id",$cate_id_arr)->get();
			}else{
				$arts=Article::where('cate_id',$id)->get();	//子分类文章
			}
			if(count($arts)){
				$data=['status'=>0,'msg'=>'请先删除该分类下所有文章，再删除该分类！'];	
			}else{
				if($field->delete()){
					$data=['status'=>1,'msg'=>'删除成功！'];	
				}else{
					$data=['status'=>0,'msg'=>'删除失败,请稍后重试！'];	
				}				
			}
		}
		return $data;
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
