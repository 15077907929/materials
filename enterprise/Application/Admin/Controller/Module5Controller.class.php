<?php
//图片模块控制器
namespace Admin\Controller;
use Think\Controller;
class Module5Controller extends CommonController{	
	public function index(){	
		$method=(I('get.method')=='')?'add':I('get.method');	//请求方式
		$db=M('web_column');
		$p=(I('get.p')=='')?1:I('get.p');	//当前页
		$class1=I('get.class1');
		$count=M('web_img')->where('class1='.$class1)->count();	//总记录数		
		switch($method){
			case 'add':				
				$result_arr['class2']=$db->field('id,name')->where('bigclass='.$class1)->select();	
				$result_arr['para']=M('web_parameter')->field('name,mark')->where('type=4 and use_ok=1')->select();
			break;			
			case 'list':		
				$result_arr['class1']=$db->field('id,name')->where('id='.$class1)->select()[0];	
				$result_arr['sub']=$db->field('id,name')->where('bigclass='.$class1)->select();					
				$result_arr['data']=M('web_img')->field('id,title,com_ok,new_ok,updatetime')->where('class1='.$class1)->page($p.',2')->select();
				foreach($result_arr['data'] as $key=>&$val){
					if($val['new_ok']==0){
						$val['new_ok']='否';
					}else{
						$val['new_ok']='是';
					}	
					if($val['com_ok']==0){
						$val['com_ok']='否';
					}else{
						$val['com_ok']='是';
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