<?php
//任务管理控制器3
namespace Home\Controller;
use Home\Org\Html;
use Think\controller;
C('TMPL_ENGINE_TYPE','Smarty');
C('TMPL_ACTION_SUCCESS','Public/jump2');	//默认成功跳转对应的模板文件
class Task3Controller extends RoleController{
	function commentScore(){
		$method = I('get.method')?I('get.method'):'show';
		$html = new \Home\Org\Html();
		$db=M('comment_score');
        switch ($method){
            case 'show':
				$result_arr=$db->select();
				foreach($result_arr as $key=>$val){
					if($val['score_type']==1){
						$result_arr[$key]['score_type1']='是';
						$result_arr[$key]['score_type2']='否';
						$result_arr[$key]['country']='否';
					}else{
						$result_arr[$key]['score_type1']='否';
						$result_arr[$key]['score_type2']='是';	
						$result_arr[$key]['score_rate']='否';						
					}
				}
				// echo '<pre>';
				// print_r($result_arr);exit;
				$this->assign('result_arr',$result_arr);
				$this->display('commentScore');
			break;
			case 'add':
                if($_POST){
					$arr['cp'] = $_POST['cp'];
					$arr['package_name']=explode('##',trim($_POST['package_name']))[2];
                    $arr['game_name'] = trim($_POST['game_name']);
                    $arr['score_type']=$_POST['score_type'];
                    if($_POST['score_type']==1){	//自助评分
						$arr['score_rate']=$_POST['score_rate'];
					}
					if($_POST['score_type']==2){	//固定评分
						foreach($_POST['country'] as $key=>$val){
							$arr['country'].=$val.',';
						}
						$arr['country']=trim($arr['country'],',');
					}
					$arr['score']=$_POST['score'];
                    $arr['add_time'] = date('Y-m-d');
                    $addResult=$db->add($arr);
                    if($addResult) {
                        success('添加成功',U('Task3/commentScore?method=add'));
                    }else{
                        error('添加失败');
                    }
                }
				$this->assign('cp',$html->createInput('select','cp',null,getCpList()));
				$this->display('commentScore_add');
			break;
		}
	}
}