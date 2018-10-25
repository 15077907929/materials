<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class AddGroupTaskController extends CommonController {
    public function index(){
		$method = I('get.method') ? I('get.method') : 'list';
		$db=M('qq_joingroup_task');
		switch ($method) {
			case 'list':
				$this->assign('cur_nav','list');
				$labels=M('qq_group')->distinct(true)->field('labels')->select();
				$count=$db->count();
				$Page=new \Think\Page($count,25);
				$show= $Page->show();// 分页显示输出
				$list = $db->limit($Page->firstRow.','.$Page->listRows)->select();
				$this->assign('count',$count);
				//计算下发数
				foreach($list as &$val){
					$temp_str='';
					$res=M('qq_joingroup_result')->where('task_id='.$val['id'])->select();
					foreach($res as $v){
						$temp_str.=$v['group_id'].',';
					}
					$temp_str=trim($temp_str,',');
					$temp_arr=explode(',',$temp_str);
					$num=0;
					foreach($temp_arr as $t){
						if($t!=''){
							$num++;
						}
					}
					$val['down_num']=$num;
					if($val['down_num']==0){
						$val['status']='未下发';
					}else{
						if($val['down_num']<$val['group_num']){
							$val['status']='进行中';
						}else{
							$val['status']='已完成';
						}
					}
				}
				// echo '<pre>';
				// print_r($list);
				// echo '</pre>';exit;
				$this->assign('list',$list);	// 赋值数据集
				$this->assign('page',$show);	// 赋值分页输出
				$this->assign('labels',$labels);
				$this->display('list');
			break;	
			case 'check_group_num':
				$res=M('qq_group')->where('labels=\''.$_POST['labels'].'\'')->select();
				$group_num=count($res);
				if($group_num>$_POST['group_num']){
					echo json_encode(['status'=>1,'msg'=>'ok']);
				}else{
					echo json_encode(['status'=>0,'num'=>$group_num]);
				}
			break;
			case 'add':
				$labels=M('qq_group')->distinct(true)->field('labels')->select();
				$this->assign('cur_nav','add');
				$this->assign('labels',$labels);
				if(I('post.sub')){
					$arr=array(
						'labels'=>I('post.labels'),
						'group_num'=>I('post.group_num'),
						'group_limit'=>I('post.group_limit'),
						'starttime'=>I('post.start'),
						'endtime'=>I('post.end'),
						'addtime'=>date('Y-m-d')
					);
					if($db->add($arr)){
						$this->success('添加成功');exit;
					}else{
						$this->success('添加失败');
					}
				}
				$this->display('add');
			break;
			case 'del':
				if($db->where('id='.I('get.id'))->delete()){
					$this->success('删除成功');exit;
				}else{
					$this->success('删除失败');
				}
			break;
			case 'result':
				$this->assign('cur_nav','result');
				$res['labels']=M('qq_group')->distinct(true)->field('labels')->select();
				$res['count']=M('qq_joingroup_result')->count();
				$Page=new \Think\Page($count,25);
				$res['show']= $Page->show();
				$res['list'] = M('qq_joingroup_result')->limit($Page->firstRow.','.$Page->listRows)->select();
				$this->assign('res',$res);
				$this->display('result');			
			break;
		}
		
	}
}