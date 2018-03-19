<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class QuestionManageController extends CommonController {
	public function qlist(){
		$method = $_GET['method'] ? $_GET['method'] : 'qlist';
		$db=M('questions');
		switch ($method){
			case 'qlist':
				$result_arr['questions']=$db->where('set_id='.$_GET['set_id'])->select();
				$result_arr['set_id']=$_GET['set_id'];
			break;
			case 'del':
				$id=I('get.id');
				$result_arr['question']=$db->where('id='.$id)->find();	//删除题目的同时，删除服务器上对于的图片
				preg_match_all('/<img [^>]* src="([^;]*)" [^>]*>/iU', $result_arr['question']['content'],$content_arr);
				preg_match_all('/<img [^>]* src="([^;]*)" [^>]*>/iU', $result_arr['question']['answers'],$answers_arr);
				foreach($content_arr[1] as $key=>$val){
					unlink($val);
				}
				foreach($answers_arr[1] as $key=>$val){
					unlink($val);
				}
				$db->where('id='.$id)->delete();
				$this->redirect('index.php?m=Admin&c=QuestionManage&a=qlist');
			break;
			case 'edit':
				$result_arr['question']=$db->where('id='.$_GET['id'])->find();
				if ($_POST) {
					$question['no_order']=$_POST['no_order'];
					$question['title']=$_POST['title'];
					$question['set_id']=$_POST['set_id'];
					$question['status']=$_POST['status'];
					$question['content']=$_POST['content'];
					$question['answers']=$_POST['answers'];
					$question['correct']=$_POST['correct'];
					if($db->where('id='.$_GET['id'])->save($question)){
						//设置成功后跳转页面的地址，默认的返回页面是$_SERVER['HTTP_REFERER']
						$this->success('修改成功');	
						exit;				
					}
				}
			break;
		}
		$this->assign('result_arr',$result_arr);
		$this->display($method);
	}	

    public function qadd(){
		$result_arr['set_id']=$_GET['set_id'];
        if ($_POST) {
			$question['no_order']=$_POST['no_order'];
			$question['title']=$_POST['title'];
			$question['set_id']=$_POST['set_id'];
			$question['content']=$_POST['content'];
			$question['answers']=$_POST['answers'];
			$question['correct']=$_POST['correct'];
			$question['status']=$_POST['status'];
			$question['addtime']=time();
			if(M('questions')->add($question)){
				//设置成功后跳转页面的地址，默认的返回页面是$_SERVER['HTTP_REFERER']
				$this->success('新增成功');	
				exit;				
			}
		}
		// echo M('scores')->getLastSql();

		$this->assign('result_arr',$result_arr);
		$this->display('qadd');
	}
}