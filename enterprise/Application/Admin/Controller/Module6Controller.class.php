<?php
//招聘模块控制器
namespace Admin\Controller;
use Think\Controller;
class Module6Controller extends CommonController{	
	public function index(){	
		$method=(I('get.method')=='')?'add':I('get.method');	//请求方式
		$db=M('web_column');
		$p=(I('get.p')=='')?1:I('get.p');	//当前页
		$class1=I('get.class1');
		$count=M('web_job')->count();	//总记录数		
		switch($method){
			case 'add':				
				$result_arr['class2']=$db->field('id,name')->where('bigclass='.$class1)->select();			
			break;			
			case 'list':		
				$result_arr['class1']=$db->field('id,name')->where('id='.$class1)->select()[0];	
				$result_arr['sub']=$db->field('id,name')->where('bigclass='.$class1)->select();					
				$result_arr['data']=M('web_job')->field('id,position,count,place,deal,addtime,useful_life')->page($p.',2')->select();
				foreach($result_arr['data'] as $key=>&$val){
					if($val['count']==0){
						$val['count']='不限';
					}	
					if($val['useful_life']==0){
						$val['useful_life']='不限';
					}
				}
				$Page=new \Think\Page($count,2);	// 实例化分页类 传入总记录数和每页显示的记录数(2)
				$result_arr['page']=$Page->show();	// 分页显示输出				
			break;
		}
		// echo '<pre>';
		// print_r($result_arr);
		// echo '</pre>';	
		$this->assign('result_arr',$result_arr);
		$this->display($method);
	}
}