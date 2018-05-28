<?php
namespace App\Http\Controllers\Home;
use App\Http\Models\Article;
use App\Http\Models\Category;

class IndexController extends CommonController{
	public function index(){
		$article=Article::orderBy('addtime','desc')->take(2)->get();
		foreach($article as $key=>&$val){
			$val['cate_name']=Category::where('id',$val['cate_id'])->first()['name'];
		}
		// dd($article);
		return view('Home/index')->with('article',$article);
	}	

	public function cate(){
		return view('Home/cate');	
	}		
	
	public function article(){
		return view('Home/article');	
	}	
	
	public function contact(){
		return view('Home/contact');	
	}		
}
