<?php
//栏目配置-基本信息控制器
namespace Admin\Controller;
use Think\Controller;
class ColumnController extends CommonController{	
	public function index(){	
		$method=(I('get.method')=='')?'show':I('get.method');	//请求方式
		$db=M('web_column');	
		switch($method){
			case 'show':				
				$result_arr['class1']=$db->field('id,name,module,nav,no_order,url')->where('class_type=1')->order('no_order asc')->select();
				foreach($result_arr['class1'] as $key=>&$val){
					$val['nav']=get_nav($val['nav']);
					$val['module']=get_module($val['module']);
					$val['class2']=$db->field('id,name,nav,no_order,url')->where('class_type=2 and bigclass='.$val['id'])->order('no_order asc')->select();
					foreach($val['class2'] as $k=>&$v){
						$v['nav']=get_nav($v['nav']);
						$v['class3']=$db->field('id,name,nav,no_order,url')->where('class_type=3 and bigclass='.$v['id'])->order('no_order asc')->select();
						foreach($v['class3'] as $sub_k=>&$sub_v){
							$sub_v['nav']=get_nav($sub_v['nav']);							
						}
					}
				}
				// echo '<pre>';
				// print_r($result_arr);
				// echo '</pre>';				
			break;
		}
		$this->assign('result_arr',$result_arr);
		$this->display();
	}
}