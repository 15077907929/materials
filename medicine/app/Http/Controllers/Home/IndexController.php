<?php
namespace App\Http\Controllers\Home;
use App\Http\Models\Article;
use App\Http\Models\Category;

class IndexController extends CommonController{
	public function index(){
		$cur_nav='index';
		return view('Home/index',compact('cur_nav'));
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
