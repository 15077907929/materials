<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function __construct(){
		parent::__construct();
		$common['admin']=cookie('admin');
		if($common['admin']==''){
			echo '<script type="text/javascript">window.location.href="index.php?m=Admin&c=Login&a=login";</script>';
		}		
		$this->assign('common',$common);
	} 	
	
	public function lefttree(){
		$temp_arr=M('column')->where('if_in=0')->select();
		foreach($temp_arr as $val){
			if($val['bigclass']==0){
				switch($val['module']){
					case 1;
						$lnav['list1'][]=$val;
					break;
					case 2;
						$lnav['list2'][]=$val;
					break;
					case 3;
						$lnav['list3'][]=$val;
					break;
					case 4;
						$lnav['list4'][]=$val;
					break;
					case 5;
						$lnav['list5'][]=$val;
					break;
					case 6;
						$lnav['list6'][]=$val;
					break;
					case 7;
						$lnav['list7'][]=$val;
					break;
				} 
			}else{
				switch($val['module']){
					case 1;
						$list11[]=$val;
						$list12[]=$val;
					break;
					case 2;
						$list22[]=$val;
					break;
					case 3;
						$list33[]=$val;
					break;
					case 4;
						$list44[]=$val;
					break;
					case 5;
						$list55[]=$val;
					break;
					case 6;
						$list66[]=$val;
					break;
					case 7;
						$list77[]=$val;
					break;
				}
			}			
		}
		// print_r($lnav);
		$this->assign('lnav',$lnav);
		$this->display();
	}
}