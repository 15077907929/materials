<?php
namespace App\Http\Controllers\Home;
use App\Http\Models\Article;

class ArticleController extends CommonController{		
	public function art($id){
		$field=Article::find($id);
		$article['pre']=Article::where('id','<',$id)->orderBy('id','desc')->first();
		$article['next']=Article::where('id','>',$id)->orderBy('id','asc')->first();
		Article::where('id',$id)->increment('view',1);
		return view('Home/article',compact('field','article'));
	}
}
