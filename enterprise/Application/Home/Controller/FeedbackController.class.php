<?php
//在线反馈控制器
namespace Home\Controller;
use Think\Controller;
class FeedbackController extends CommonController{	
    public function feedback(){
		$db=M('web_feedback');
		$class_type=I('get.class_type');		
		switch($class_type){
			case 'base':
				$result_arr['para']=M('web_fdparameter')->field('id,name,wr_ok,type')->select();
				$fdlist=M('web_fdlist')->field('id,bigid,list')->select();
				foreach($result_arr['para'] as $key=>&$val){
					if($val['wr_ok']==1){
						$val['wr_ok']='*';
					}else{
						$val['wr_ok']='';
					}
					switch($val['type']){
						case 1:
							$val['type']='<input name=\'para'.$val['id'].'\' type=text size=30 />';
						break;
						case 2:
							$val['type']='<select name=para'.$val['id'].'><option select=selected value="">请选择</option>';						
							foreach($fdlist as $k=>$v){
								if($v['bigid']==$val['id']){
									$val['type']=$val['type'].'<option value='.$v['list'].'>'.$v['list'].'</option/>';
								}
							}
							$val['type']=$val['type'].'</select>';							
						break;
						case 3:
							$val['type']='<textarea name=\'para'.$val['id'].'\' cols=50 rows=5></textarea>';
						break;
					}
				}
			break;			
		}
				// echo '<pre>';
				// print_r($result_arr);
				// echo '</pre>';
		$this->assign('result_arr',$result_arr);
		$this->display('feedback');
	}
}