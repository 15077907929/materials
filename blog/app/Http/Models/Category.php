<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model{
    protected $table='category';
	protected $primaryKey='id';
	public $timestamps=false;
	protected $guarded=[];
	static function getTree(){
		$category=Category::where('pid','=',0)->orderBy('no_order','asc')->get();
		foreach($category as $key=>&$val){
			$val['sub']=Category::where('pid','=',$val['id'])->orderBy('no_order','asc')->get();
		}
		return $category;
	}
}
