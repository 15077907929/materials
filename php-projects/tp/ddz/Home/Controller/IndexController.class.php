<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		$p_new=get_p();
		echo '<pre>';
		print_r($p_new);
		echo '</pre>';
		$p_new=implode(',',$p_new);
		$p_new=renew($p_new);
		echo $p_new;
		$player_name=$_COOKIE['player_name'];
		$ori_time=time();
	}
}