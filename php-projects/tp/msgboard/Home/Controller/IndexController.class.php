<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		$db=M('guestbook');
		$method = I('get.method') ? I('get.method') : 'show';
		if($_GET['p']){
			$res['p']=$_GET['p'];
		}else{
			$res['p']=1;
		}
		switch ($method) {
            case 'show':
				$res['total']      = $db->order('settop desc')->count();// 查询满足要求的总记录数
				$Page       = new \Think\Page($res['total'],C('page'));// 实例化分页类 传入总记录数和每页显示的记录数(25)
				$res['show']       = $Page->show();// 分页显示输出
				// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
				$res['list'] = $db->limit($Page->firstRow.','.$Page->listRows)->order('settop desc')->select();
			break;
			case 'add':
				if($_POST){
					$res['ac']='add';
					if(time()-cookie('timer')>120){
						$res['forbidden']=0;
						if($_POST['unum']==session('randValid')){
							$data['name']=addslashes(htmlspecialchars($_POST['name']));
							$data['email']=addslashes(htmlspecialchars($_POST['email']));
							$data['content']=addslashes(htmlspecialchars($_POST['content']));
							$data['ip']=ip2long($_SERVER["REMOTE_ADDR"]);
							$data['ifqqh']=$_POST["ifqqh"];
							if(empty($data['ifqqh'])) 
								$data['ifqqh']=0;
							$data['systime']=time();
							if(!empty($data['content']) and !empty($data['name'])){
								$data['ifshow']='';
								//还原空格和回车
								$data['content']=str_replace("　","",$data['content']);
								$data['content']=ereg_replace("\n","<br>　　",ereg_replace(" ","&nbsp;",$data['content']));
								if($ifauditing==1){
									$ifshow=0;
								}else{
									$ifshow=1;
								}
								//还原结束
								if($db->add($data)){
									cookie('timer',time());
									$res['msg']='恭喜您留言成功，正在返回请稍候……<br><a href=index.php>您可以点此手动返回</a>';
									$res['msg'].='<meta http-equiv="refresh" content="3; url=index.php">';
								}else{
									$res['msg']='留言失败！信息中可能含有敏感字符或不利于程序运行的特殊字符……';
									$res['msg'].'<meta http-equiv="refresh" content="5; url="'.$_SERVER['PHP_SELF'].'\>';
								}
							}else{
								$res['msg']='昵称和留言内容不能空，请重填！正在返回……<br><a href=index.php>您可以点此手动返回</a>';
								$res['msg'].='<meta http-equiv="refresh" content="3; url='.$_SERVER['HTTP_REFERER'].'">';
							}
						}else{
							$res['msg']='<script type="text/javascript">alert("对不起，验证码不正确，请重新输入……");history.back()</script>';
						}
					}else{
						$res['forbidden']=1;
					}
				}
			break;
			case 'edit':
				$pageUrl="index.php?p=".$res['p'];
				$res['info']=$db->where('id='.$_GET['id'])->find();
				if($_POST){
					$res['ac']='reply';
					$data['content']=addslashes($_POST['content']);
					$data['reply']=addslashes($_POST['reply']);
					$data['replytime']=time();
					//还原空格和回车
					if(!empty($data['content'])){
						$data['content']=str_replace('　','',$data['content']);
						$data['content']=ereg_replace("\n",'<br>　　',$data['content']);
					}
					if(!empty($data['reply'])){
						$data['reply']=str_replace('　','',$data['reply']);
						$data['reply']=ereg_replace("\n",'<br>　　',$data['reply']);
					}
					//还原结束
					$db->where('id='.$_POST['id'])->save($data);
					$res['msg']='编辑/回复成功，请稍候……<br><a href="'.$pageUrl.'">如果浏览器没有自动返回，请点击此处返回</a>';
					$res['msg'].='<meta http-equiv="refresh" content="2; url='.$pageUrl.'" />';
				}
			break;
		}
		$this->assign('res',$res);
		$this->display($method);
	}
	
	public function settop(){
		if($_GET['p']){
			$res['p']=$_GET['p'];
		}else{
			$res['p']=1;
		}
		$data['settop']=1;
		M('guestbook')->where('id='.$_GET['id'])->save($data);
		$this->assign('res',$res);
		$this->display();
	}	
	
	public function unsettop(){
		if($_GET['p']){
			$res['p']=$_GET['p'];
		}else{
			$res['p']=1;
		}
		$data['settop']=0;
		M('guestbook')->where('id='.$_GET['id'])->save($data);
		$this->assign('res',$res);
		$this->display();
	}
	
	public function del(){
		if($_GET['p']){
			$res['p']=$_GET['p'];
		}else{
			$res['p']=1;
		}
		M('guestbook')->where('id='.$_GET['id'])->delete();
		$this->assign('res',$res);
		$this->display();
	}
	
	public function setshow(){
		if($_GET['p']){
			$res['p']=$_GET['p'];
		}else{
			$res['p']=1;
		}
		$data['ifshow']=1;
		M('guestbook')->where('id='.$_GET['id'])->save($data);
		$this->assign('res',$res);
		$this->display();		
	}	
	
	public function unshow(){
		if($_GET['p']){
			$res['p']=$_GET['p'];
		}else{
			$res['p']=1;
		}
		$data['ifshow']=0;
		M('guestbook')->where('id='.$_GET['id'])->save($data);
		$this->assign('res',$res);
		$this->display();		
	}
}