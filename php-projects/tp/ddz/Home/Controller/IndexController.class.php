<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		$user=cookie('user');
		$ori_time=time();
		
		if($user==''){
			redirect('index.php?m=Home&c=User&a=login');
		}
		$p_new=get_p();
		echo '<pre>';
		print_r($p_new);
		echo '</pre>';
		$p_new=implode(',',$p_new);
		$p_new=renew($p_new);
		echo $p_new;
		
		
		
	}
	
	public function hall(){
		$user=cookie('user');
		if($user==''){
			redirect('index.php?m=Home&c=User&a=login');
		}
		$this->display();
	}
}