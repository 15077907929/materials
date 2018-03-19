<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
		$method=($_GET['method']=='')?'get_q':$_GET['method'];
		$start=cookie('user')['start_time'];
		$user['end_time'] = date('Y-m-d H:i:s');
		$user['rest'] = 2400 - (time() - strtotime($start));
		$detail=json_decode(M('users')->field('detail')->where('id='.cookie('user')['id'])->find()['detail']);
		foreach($detail as $key=>$val){	//获取答题的数组
			$rst['detail'][$key]=$val;	//记录当前题目答案状态
			$rst['done'][]=$key;
		}
		$rst['done']=json_encode($rst['done']);
		switch ($method){
			case 'get_q':
				$db=M('questions');
				$rst['questions']=$db->where('set_id=2')->select();
				$rst['num']=$db->where('set_id=2')->count();
				$rst['c_num']=($_GET['c_num']=='')?'1':$_GET['c_num'];
				$rst['c_question']=$db->where('set_id=2 and no_order='.$rst['c_num'])->find();
				
			break;
			case 'get_s':	//	获取剩余时间
				$s = 2400 - (time() - strtotime($start));
				echo json_encode(['status' => 1, 's' => $s]);exit;
			break;
			case 'save_archive':	//存档
				if($_GET['sub']==1){	//完成提交
				    $correct=M('questions')->field('no_order,correct')->where('set_id=2')->select();	//获取正确答案的数组
					foreach($correct as $key=>$val){
						$right_answer_arr[$val['no_order']]=$val['correct'];
					}
					$q_num=count($right_answer_arr);	//获取题目个数
					$score['score_2']=0;	//获取答对题目个数
					foreach($right_answer_arr as $key=>$val){
						if($rst['detail'][$key]==$val){
							$score['score_2']++;
						}
					}
					$score['score_2']=C('score')[$score['score_2']];	//计算分数，按正态分布计算
					$score['addtime'] = date('Y-m-d H:i:s');
					$score['user_id'] = cookie('user')['id'];
					$score['ip'] = get_client_ip();
					$result['status'] = 0;
					if( M('score')->add($score)){
						$result['status'] = 1;
					}		
				}else{
					$rst['detail'][$_POST['c_num']]=$_POST['answer'];
					$user['detail']=json_encode($rst['detail']);				
					if(M('users')->where('id='.cookie('user')['id'])->save($user)){
						$result['status'] = 1;
						$result['msg'] ='saved';
					}					
				}
				echo json_encode($result);exit;
			break;
		}
		$this->assign('rst',$rst);
		$this->display('index');
	}
}