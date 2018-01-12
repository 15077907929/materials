<?php
//基本配置-数据库备份控制器
namespace Admin\Controller;
use Think\Controller;
class DatabaseController extends CommonController{	
	public function index(){	
		$method=(I('get.method')=='')?'show':I('get.method');	//请求方式
		$db=M();	
		switch($method){
			case 'show':				
				$result_arr['tables']=$db->query('show tables');
				$sysdb=$db->db(1,"mysql://root:123456@localhost:3306/information_schema");
				foreach($result_arr['tables'] as $key=>&$val){
					$val['count']=M($val['Tables_in_my_enterprise_web'])->count();
					$val['size']=$sysdb->query('select concat(round(sum(data_length/1024),2),\'KB\') as data from tables where table_schema=\'my_enterprise_web\' and table_name=\''.$val['Tables_in_my_enterprise_web'].'\'')[0]['data'];
					$result_arr['total_size']+=$val['size'];
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