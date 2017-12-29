<?php
namespace Home\Controller;	//后勤管理控制器
use Think\Controller;
class LogisticsController extends CommonController{
	function repair(){	//网上报修
		$db=M('oa_b_content');
		$method=I('get.method')==''?'show':I('get.method');
		switch($method){	
			case 'show':
				$result_arr=$db->table('members as m,oa_b_content as oa')->field('oa.address,oa.content,oa.type,oa.intime,oa.retime,oa.state,m.realname')->where('oa.userid=m.id')->select();
				foreach($result_arr as $key=>&$val){
					$val['type']=C('b_type')[$val['type']];
					$val['state']=C('b_state')[$val['state']];
				}	
				$this->assign('result_arr',$result_arr);
				$this->display('repair');
			end;
		}
	}		

	function debits(){	//电教资料借记
		$db=M('oa_');
		$method=I('get.method')==''?'show':I('get.method');
		switch($method){	
			case 'show':
				$this->assign('result_arr',$result_arr);
				$this->display('debits');
			end;
		}
	}	
}	













