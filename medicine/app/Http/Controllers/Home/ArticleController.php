<?php
namespace App\Http\Controllers\Home;
use App\Http\Models\Article;
use App\Http\Models\Category;

class ArticleController extends CommonController{		
	public function article($id){
		$cur_nav='article';
		$field=Category::find($id);
		$art=Article::find($id);
		$art['cate_name']=Category::find($art['cate_id'])['name'];
		$article['pre']=Article::where('id','<',$id)->orderBy('id','desc')->first();
		$article['next']=Article::where('id','>',$id)->orderBy('id','asc')->first();
		Article::where('id',$id)->increment('view',1);
		if($field['pid']!=0){
			$field=Category::find($field['pid']);
		}
		return view('Home/article',compact('cur_nav','field','art'));
	}
	
	public function articles($id){
		$cur_nav='article';
		$cate=Category::where('pid',0)->get();
		$field=Category::find($id);
		if($field['pid']==0){
			$child_ids=Category::where('pid',$id)->get();	//一级分类下的所有子分类文章
			foreach($child_ids as $val){
				$cate_id_arr[]=$val['id'];
			};
			$arts=Article::whereIn("cate_id",$cate_id_arr)->get();
			foreach($arts as &$val){
				$val['cate_name']=Category::find($val['cate_id'])['name'];
			}
		}else{
			$arts=Article::where("cate_id",$id)->get();	//子分类文章
			foreach($arts as &$val){
				$val['cate_name']=Category::find($val['cate_id'])['name'];
			}
		}
		if($field['pid']!=0){
			$field=Category::find($field['pid']);
			$field['sub_name']=Category::find($id)['name'];
		}
		return view('Home/articles',compact('cur_nav','cate','field','arts'));
	}
}
