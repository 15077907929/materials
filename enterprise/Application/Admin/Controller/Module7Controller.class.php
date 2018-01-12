<?php
//留言模块控制器
namespace Admin\Controller;
use Think\Controller;
class Module7Controller extends CommonController{	
	public function index(){	
		$method=(I('get.method')=='')?'add':I('get.method');	//请求方式
		$db=M('web_column');
		$p=(I('get.p')=='')?1:I('get.p');	//当前页
		$class1=I('get.class1');
		$count=M('web_message')->count();	//总记录数		
		switch($method){
			case 'add':				
				$result_arr['class2']=$db->field('id,name')->where('bigclass='.$class1)->select();			
			break;			
			case 'list':				
				$result_arr['data']=M('web_message')->field('id,name,tel,email,ip,addtime,readok')->page($p.',2')->select();
				foreach($result_arr['data'] as $key=>&$val){
					$val['ip']=long2ip($val['ip']);
					if($val['readok']==0){
						$val['readok']='否';
					}else{
						$val['readok']='是';
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