<?php
namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Models\Navs;
use App\Http\Models\Links;
use App\Http\Models\Category;
use Illuminate\Support\Facades\View;

class CommonController extends Controller{
	public function __construct(){
		// $cate_p=Category::where('pid',0)->get();
		// View::share('cate_p',$cate_p);
	}
}
