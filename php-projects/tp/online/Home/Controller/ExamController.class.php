<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class ExamController extends CommonController {
    public function hall(){
		$this->display();
	}
	
	public function choose(){
		$res['subjects']=M('subject')->select();
		$this->assign('res',$res);
		$this->display();
	}
	
	public function start(){
		cookie('start',mktime());
		$user=cookie('user');
		if($user['status']==1){
			echo '<script type="text/javascript"> alert("您已经完成本类别的考试,不可以重复答题,谢谢!"); window.location.href="index.php";</script>';
		}
		$res['subject']=$_POST['subject'];
		$res['small_cate']=$_POST['small_cate'];
		$res['score']=0;
		$temp_arr=M('question')->where('subject='.$_POST['subject'].' and small_cate='.$_POST['small_cate'])->select();
		foreach($temp_arr as $val){
			switch($val['cate']){
				case 1:
					$res['sc'][]=$val;
				break;
				case 2:
					$res['mc'][]=$val;
				break;
				case 3:
					$res['jd'][]=$val;
				break;
				case 4:
					$res['ls'][]=$val;
				break;
			}
		}
		//单选
		foreach($res['sc'] as $key=>$val){
			$res['sc'][$key]['answer']=explode('*',$val['answer']);
			if(isset($_POST[$val['id']])){
				//考生提交的答案
				$res['sc'][$key]['_answer_key']=$_POST[$val['id']];
				switch($_POST[$val['id']]){
					case 0:
						$res['sc'][$key]['_answer']='A';
					break;
					case 1:
						$res['sc'][$key]['_answer']='B';
					break;
					case 2:
						$res['sc'][$key]['_answer']='C';
					break;
					case 3:
						$res['sc'][$key]['_answer']='D';
					break;
				}
				if($res['sc'][$key]['_answer']==$res['sc'][$key]['correct_answer']){
					$res['score']+=$res['sc'][$key]['score'];
				}
			}
		}	
		//多选
		foreach($res['mc'] as $key=>$val){
			$res['mc'][$key]['answer']=explode('*',$val['answer']);
			if(isset($_POST[$val['id']])){
				//考生提交的答案
				foreach($_POST[$val['id']] as $k=>$v){
					$res['mc'][$key]['_answer_key'][]=$v;
					switch($v){
						case 0:
							$res['mc'][$key]['_answer'].='A';
						break;
						case 1:
							$res['mc'][$key]['_answer'].='B';
						break;
						case 2:
							$res['mc'][$key]['_answer'].='C';
						break;
						case 3:
							$res['mc'][$key]['_answer'].='D';
						break;
					}	
					if($res['mc'][$key]['_answer']==$res['mc'][$key]['correct_answer']){
						$res['score']+=$res['mc'][$key]['score'];
					}
				}	
			}
		}
		//简答
		//论述
		// echo '<pre>';
		// print_r($_POST);
		// print_r($res);
		// echo '</pre>';
		//提交试卷
		if($_POST['sub']=='提交试卷'){
			$res['sub']=true;
			$data['date']=date('Y-m-d H:i:s');
			$data['score']=$res['score'];
			$data['subject']=$_POST['subject'];
			$data['status']=1;
			M('user')->where('id='.cookie('user')['id'])->save($data);
			$user['status']=1;
			cookie('user',$user);
		}
		$this->assign('res',$res);
		$this->display();
	}
	
	public function sparetime(){
		$starttime=cookie('start');
		$curtime=mktime();
		$time=$starttime+20*60-$curtime;
		echo $time;
	}
}