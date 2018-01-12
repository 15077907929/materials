<?php
//反馈模块控制器
namespace Admin\Controller;
use Think\Controller;
class FeedbackController extends CommonController{	
	public function index(){	
		$method=(I('get.method')=='')?'set':I('get.method');	//请求方式
		$db=M('web_column');
		$p=(I('get.p')=='')?1:I('get.p');	//当前页
		$class1=I('get.class1');
		$count=M('web_feedback')->count();	//总记录数		
		switch($method){
			case 'set':				
				$result_arr['class2']=$db->field('id,name')->where('bigclass='.$class1)->select();			
			break;				
			case 'setlist':				
				$result_arr['para']=M('web_fdparameter')->field('id,name,no_order,use_ok,wr_ok,type')->order('no_order asc')->select();
				foreach($result_arr['para'] as $key=>&$val){
					if($val['use_ok']==0){
						$val['use_ok']='';
					}else{
						$val['use_ok']='checked';
					}					
					if($val['wr_ok']==0){
						$val['wr_ok']='';
					}else{
						$val['wr_ok']='checked';
					}
					if($val['type']==1){
						$val['type']='简短字段';
					}elseif($val['type']==2){
						$val['type']='<font color=\'#f00\'>下拉菜单</font> 设置参数';
					}else{
						$val['type']='文本字段';
					}
				}
			break;			
			case 'list':				
				$result_arr['data']=M('web_feedback')->field('id,title,ip,addtime,readok')->page($p.',2')->select();
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