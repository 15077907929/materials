<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class QuestionController extends CommonController {
    public function index(){
		$db=M('question');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				if($_POST){
					$res['questions']=$db->where('subject='.$_POST['subject'])->select();
					$res['subject']=$_POST['subject'];
				}else{
					$res['questions']=$db->select();
				}
				$res['subjects']=M('subject')->select();
			break;
			case 'add':
				$res['subjects']=M('subject')->select();
				if($_POST){
					$data['subject']=$_POST['subject'];
					$data['small_cate']=$_POST['small_cate'];
					$data['cate']=$_POST['cate'];
					$data['score']=$_POST['score'];
					$data['content']=$_POST['content'];
					$data['answer']=$_POST['answer'];
					$data['correct_answer']=$_POST['correct_answer'];
					if($db->add($data)){
						echo '<script type="text/javascript">alert("考题添加成功");window.location="index.php?m=Admin&c=Question&a=index&method=add";</script>';
					}
				}
			break;
			case 'edit':
				if($_POST){
					$data['subject']=$_POST['subject'];
					$data['small_cate']=$_POST['small_cate'];
					$data['cate']=$_POST['cate'];
					$data['score']=$_POST['score'];
					$data['content']=$_POST['content'];
					$data['answer']=$_POST['answer'];
					$data['correct_answer']=$_POST['correct_answer'];
					if($db->where('id='.$_POST['id'])->save($data)){
						echo '<script type="text/javascript">alert("考题更新成功");window.location="index.php?m=Admin&c=Question&a=index";</script>';
					}
				}			
			break;
			case 'del':
				if($db->where('id='.$_GET['id'])->delete()){
					echo '<script type="text/javascript">alert("考题删除成功");window.location="index.php?m=Admin&c=Question&a=index";</script>';
				}				
			break;
		}
		$this->assign('res',$res);
		$this->display('question_'.$method);
	}
}