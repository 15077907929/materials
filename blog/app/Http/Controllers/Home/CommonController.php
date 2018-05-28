<?php
namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Models\Navs;
use App\Http\Models\Links;
use Illuminate\Support\Facades\View;

class CommonController extends Controller{
	public function __construct(){
		$navs=Navs::all();
		$cur_id=isset($_GET['id'])?$_GET['id']:1;
		$links=Links::all();
		// dd($links);
		View::share('navs',$navs);
		View::share('cur_id',$cur_id);
		View::share('links',$links);
	}
}
