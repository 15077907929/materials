<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    public function login(){
		$user=cookie('user');
		if($user!=''){
			redirect('index.php?m=Home&c=Index&a=index');
		}
		$this->display();	
	} 

	public function chklogin(){
		$db=M('manager');      
		$user=$db->where('name=\''.$_POST['name'].'\' and pwd=\''.md5($_POST['pwd']).'\'')->find();
		if(!$user){
			echo "<script type='text/javascript'>alert('您输入的管理员名称错误，请重新输入！');history.back();</script>";
			exit;
		}else{
			cookie('user',$user);
			echo "<script>alert('管理员登录成功!');window.location='index.php';</script>";
		}	
	}
	
	public function safequit(){
		cookie('user',null);
		redirect('index.php?m=Home&c=User&a=login');
	}
	
	public function manager(){
		$res['user']=cookie('user');
		if($res['user']==''){
			echo "<script>alert('对不起，请通过正确的途径登录博考图书馆管理系统!');window.location.href='index.php?m=Home&c=User&a=login';</script>";
		}
		$db=M('manager');
		$db2=M('purview');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				$res['users']=$db->query('select m.id,m.name,p.sysset,p.readerset,p.bookset,p.borrowback,p.sysquery from manager as m left join (select * from purview)as p on m.id=p.mid');
			break;
			case 'add':
				if($_POST['submit']!=""){
					$data['name']=$_POST['name'];
					$data['pwd']=md5($_POST['pwd']);
					if($db->add($data)){
						echo '<script type="text/javascript">alert("管理员添加成功！");window.close();window.opener.location.reload();</script>';
					}
					else{
						echo '<script type="text/javascript">alert("管理员添加失败！");window.close();window.opener.location.reload();</script>';
					}
				}
			break;
			case 'modify':
				$res['info']=$db->query('select m.id,m.name,p.sysset,p.readerset,p.bookset,p.borrowback,p.sysquery from manager as m left join (select * from purview)as p on m.id=p.mid where m.id='.$_GET['id'])[0];
				if($_POST['submit']!=""){
					$data['mid']=$_POST['id'];
					$data['sysset']=$_POST['sysset']==""?0:1;
					$data['readerset']=$_POST['readerset']==""?0:1;
					$data['bookset']=$_POST['bookset']==""?0:1;
					$data['borrowback']=$_POST['borrowback']==""?0:1;
					$data['sysquery']=$_POST['sysquery']==""?0:1;
					$info=$db2->where('mid='.$_POST['id'])->find();
					if(!$info){
						$db2->add($data);
					}
					else{
						$db2->where('mid='.$_POST['id'])->save($data);
					}
					echo '<script type="text/javascript">alert("权限设置修改成功！");window.close();window.opener.location.reload();</script>';
				}
			break;
		}
		
		$this->assign('res',$res);
		$this->display('manager_'.$method);	
	}
}