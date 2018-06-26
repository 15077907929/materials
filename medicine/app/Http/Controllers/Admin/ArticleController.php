<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\User;
use App\Http\Models\Category;
use App\Http\Models\Article;

class ArticleController extends CommonController{	
    public function index(){
		$cur_nav='art_list';
		$arts=Article::paginate(10);
		foreach($arts as &$val){
			$cate=Category::find($val->cate_id);
			if($cate['pid']!=0){
				$val['cate_name']=Category::find($cate->pid)['name'].' - '.Category::find($val->cate_id)['name'];
			}else{
				$val['cate_name']=Category::find($cate->pid)['name'];
			}
		}
		return view('Admin/Article/list',compact('cur_nav','arts'));
	}
	
	public function create(){
		$cur_nav='art_create';
		$cate=Category::where('pid',0)->get();
		foreach($cate as &$val){
			$val['sub']=Category::where('pid',$val->id)->get();
		}
		return view('Admin/Article/create',compact('cur_nav','cate'));
	}
	
	public function store(){
		$input=Input::except(['_token','sub']);
		$input['addtime']=date('Y-m-d');
		$rules=['title'=>'required','cate_id'=>'required','no_order'=>'numeric','content'=>'required'];
		$validator=Validator::make($input,$rules);
		if($validator->passes()){
			$re=Article::create($input);
			if($re){
				return redirect('admin/article');
			}else{
				return back()->with('errors','数据填充失败，请稍后重试');
			}
		}else{
			return back()->withErrors($validator);
		}
	}
	
	public function edit($id){
		$cur_nav='art_list';
		$cate=Category::where('pid',0)->get();
		foreach($cate as &$val){
			$val['sub']=Category::where('pid',$val->id)->get();
		}
		$field=Article::find($id);
		return view('Admin/Article/edit',compact('cur_nav','cate','field'));
	}
	
	public function update($id){
		$input=Input::except('_token','_method','sub');
		$re=Article::where('id',$id)->update($input);
		if($re){
			return redirect('admin/article');
		}else{
			return back()->with('error','分类信息更新失败，请稍后重试');
		}
	}
	
    public function destroy($id){
        $field=Article::find($id);
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
			$cate=Article::find($input['id']);
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
