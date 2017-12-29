<?php
namespace Home\Controller;	//我的办公桌控制器
use Think\Controller;
class MyDeskController extends CommonController{
	public function message(){	//短信箱
		$db=M('oa_message');
		$method=I('get.method')==''?'receive':I('get.method');
		switch($method){
			case 'receive':	//收件箱
				$result_arr=$db->table('oa_message as oa,members as m')->where('oa.send=m.id and receive='.cookie('userid'))->field('oa.id,oa.title,m.realname as send,oa.sendtime,oa.content')->select(); 
				foreach($result_arr as $key=>$val){
					$result_arr[$key]['sendtime']=date('Y-m-d',$val['sendtime']);
				}
				$this->assign('result_arr',$result_arr);
				$this->display();
			break;
		}
	}
	
	public function schedule(){	//日程安排
		$db=M('oa_schedule');
		$method=I('get.method')==''?'today':I('get.method');
		switch($method){
			case 'today':
				$result_arr=$db->where('inputer='.cookie('userid').' and intime='.strtotime(date('Y-m-d')))->select();
				foreach($result_arr as $key=>$val){
					$result_arr[$key]['intime']=date('Y-m-d',$val['intime']);
					$result_arr[$key]['m']=date('m',$val['intime']);
					$result_arr[$key]['d']=date('d',$val['intime']);
				}
				$this->assign('result_arr',$result_arr);
				$this->display('schedule_today');
			break;
		}
	}
	
	public function address_book(){	//通讯录
		$db=M('oa_letter');
		$method=I('get.method')==''?'personal':I('get.method');
		switch($method){
			case 'personal':	//个人通讯录
				$result_arr=$db->where('inputer='.cookie('userid'))->select(); 
				foreach($result_arr as $key=>$val){
					$result_arr[$key]['sendtime']=date('Y-m-d',$val['sendtime']);
				}
				$this->assign('result_arr',$result_arr);
				$this->display();
			break;
		}
	}
	
	public function filing_cabinet(){	//文件柜
		$db=M('oa_file');
		$method=I('get.method')==''?'show':I('get.method');
		switch($method){
			case 'show':	//文件列表
				$result_arr=$db->where('inputer='.cookie('userid'))->select(); 
				foreach($result_arr as $key=>$val){
					$result_arr[$key]['addtime']=date('Y-m-d',$val['addtime']);
				}
				$this->assign('result_arr',$result_arr);
				$this->display();
			break;
		}
	}
	
	public function favorite(){	//收藏夹
		$db=M('oa_favorite');
		$method=I('get.method')==''?'public':I('get.method');	
		switch($method){
			case 'public':
				$category=I('get.category')==''?'1':I('get.category');	
				$common_arr=M('oa_favorite_common')->table('oa_favorite_common as oa,web_type as w')->where('oa.typeid=w.id')->field('oa.title,oa.weburl,w.name as type,w.id as typeid')->select(); 
				foreach($common_arr as $key=>$val){
					if(!in_array($val['type'],$commen_categories)){
						$commen_categories[]=$val['type'];
					}
				}
				foreach($commen_categories as $key=>$val){
					foreach($common_arr as $k=>$v){
						if($val==$v['type']){
							$result_arr['common'][$val][]=array('title'=>$v['title'],'weburl'=>$v['weburl']);
						}
					}
				}
				$categories_temp=M('web_type')->select();
				foreach($categories_temp as $key=>$val){
					$result_arr['categories'][$val['id']]=$val;
				}
				$result_arr['category']=$result_arr['categories'][$category]['name'];	//当前分类名称
					
				$favorite_arr=$db->where('userid='.cookie('userid').' or isshare=1')->select();	//当前分类
				foreach($favorite_arr as $key=>$val){
					if($val['typeid']==$category){
						$result_arr['favorite_cur'][]=$val;
					}
				}
				$this->assign('result_arr',$result_arr);
				$this->display();
			break;	
		}			
	}

    public function article(){	//文章管理
		$db=M('oa_articles');
		$method=I('get.method')==''?'list':I('get.method');	
		switch($method){
			case 'list':
				$result_arr=$db->table('oa_articles as a,oa_type as t,management as m')->where('a.manageid=m.id and a.typeid=t.id and a.inputer='.cookie('userid'))->field('a.*,t.name as typename,m.name as management')->select(); 
				foreach($result_arr as $key=>&$val){	//取地址转换日期
					$val['addtime']=date('Y-m-d',$val['addtime']);
				}
				echo '<pre>';
				print_r($result_arr);
				echo '</pre>';
				$this->assign('result_arr',$result_arr);
				$this->display();
			break;
		}
	}
	
}






















