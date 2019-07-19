<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function __construct(){
		parent::__construct();
		
		$nav_search=M('column')->where('classtype=1')->select();
		foreach($nav_search as $val){
			if($val['module']==2 or $val['module']==3 or $val['module']==4 or $val['module']==5)
				$common['nav_search'][]=$val;
		}

		$nav_list=M('column')->where('nav=1 or nav=3')->select();
		foreach($nav_list as $val){
			switch($val['module']){
				case 0;
					$val['c_url']=(strstr($val['c_out_url'], 'http://'))?$val['c_out_url']:$navurl.$val['c_out_url'];
					$val['e_url']=(strstr($val['e_out_url'], 'http://'))?$val['e_out_url']:$navurl.$val['e_out_url'];
				break;
				case 1;
					$val['c_url']=$met_webhtm?$navurl.$val['foldername']."/".$val['filename'].".htm":'index.php?m=Home&c='.$val['foldername']."&a=show&id=".$val['id'];
					$val['e_url']=$met_webhtm?$navurl.$val['foldername']."/".$val['filename']."_en.htm":$navurl.$val['foldername']."/show.php?en=en&id=".$val['id'];
				break;
				case 2;
					$val['c_url']='index.php?m=Home&c='.$val['foldername'].'&a='.$val['filename'].'&class1='.$val['id'];
					$val['e_url']='index.php?m=Home&c='.$val['foldername']."&a=news&en=en&class1=".$val['id'];
				break;
				case 3;
					$val['c_url']='index.php?m=Home&c='.$val['foldername']."&a=product&class1=".$val['id'];
					$val['e_url']=$navurl.$val['foldername']."/product.php?en=en&class1=".$val['id'];
				break;
				case 4;
					$val['c_url']='index.php?m=Home&c='.$val['foldername']."&a=download&class1=".$val['id'];
					$val['e_url']=$navurl.$val['foldername']."/download.php?en=en&class1=".$val['id'];
				break;
				case 5;
					$val['c_url']='index.php?m=Home&c='.$navurl.$val['foldername'].'&a=img&class1='.$val['id'];
					$val['e_url']='index.php?m=Home&c='.$navurl.$val['foldername'].'&a=img&en=en&class1='.$val['id'];
				break;
				case 6;
					$val['c_url']='index.php?m=Home&c='.$val['foldername']."&a=job";
					$val['e_url']=$navurl.$val['foldername']."/job.php?en=en";
				break;
				case 7;
					$val['c_url']='index.php?m=Home&c='.$navurl.$val['foldername']."&a=message";
					$val['e_url']='index.php?m=Home&c='.$navurl.$val['foldername']."&a=message&en=en";
				break;
			}
			$common['nav_list'][]=$val;
		}
		
		$navfoot_list=M('column')->where('nav=2 or nav=3')->select();
		foreach($navfoot_list as $val){
			switch($val['module']){
				case 0;
					$val['c_url']=(strstr($val['c_out_url'], 'http://'))?$val['c_out_url']:$navurl.$val['c_out_url'];
					$val['e_url']=(strstr($val['e_out_url'], 'http://'))?$val['e_out_url']:$navurl.$val['e_out_url'];
				break;
				case 1;
					$val['c_url']=$met_webhtm?$navurl.$val['foldername']."/".$val['filename'].".htm":'index.php?m=Home&c='.$val['foldername']."&a=show&id=".$val['id'];
					$val['e_url']=$met_webhtm?$navurl.$val['foldername']."/".$val['filename']."_en.htm":$navurl.$val['foldername']."/show.php?en=en&id=".$val['id'];
				break;
				case 2;
					$val['c_url']='index.php?m=Home&c='.$val['foldername'].'&a='.$val['filename'].'&class1='.$val['id'];
					$val['e_url']='index.php?m=Home&c='.$val['foldername']."&a=news&en=en&class1=".$val['id'];
				break;
				case 3;
					$val['c_url']='index.php?m=Home&c='.$val['foldername']."&a=product&class1=".$val['id'];
					$val['e_url']=$navurl.$val['foldername']."/product.php?en=en&class1=".$val['id'];
				break;
				case 4;
					$val['c_url']='index.php?m=Home&c='.$val['foldername']."&a=download&class1=".$val['id'];
					$val['e_url']=$navurl.$val['foldername']."/download.php?en=en&class1=".$val['id'];
				break;
				case 5;
					$val['c_url']='index.php?m=Home&c='.$navurl.$val['foldername'].'&a=img&class1='.$val['id'];
					$val['e_url']='index.php?m=Home&c='.$navurl.$val['foldername'].'&a=img&en=en&class1='.$val['id'];
				break;
				case 6;
					$val['c_url']='index.php?m=Home&c='.$val['foldername']."&a=job";
					$val['e_url']=$navurl.$val['foldername']."/job.php?en=en";
				break;
				case 7;
					$val['c_url']='index.php?m=Home&c='.$navurl.$val['foldername']."&a=message";
					$val['e_url']='index.php?m=Home&c='.$navurl.$val['foldername']."&a=message&en=en";
				break;
			}
			$common['navfoot_list'][]=$val;
		}
		$this->assign('common',$common);
	} 	
}