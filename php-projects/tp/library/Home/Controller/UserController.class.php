<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class UserController extends CommonController {		
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
			case 'modify_pwd':
				if($_POST['sub']){
					$db->query('update manager set pwd=\''.md5($_POST['pwd']).'\' where name=\''.cookie('user')['name'].'\'');
					$res['user']['pwd']=md5($_POST['pwd']);
					cookie('user',$res['user']);
					echo '<script type="text/javascript">alert("口令更改成功!");window.location.href="index.php?m=Home&c=User&a=manager&method=modify_pwd";</script>';	
				}
			break;
			case 'del':
				$find=$db2->where('id='.$_GET['id'])->find();
				if($find){
					if($db->where('id='.$_GET['id'])->delete() && $db2->where('mid='.$_GET['id'])->delete()){
						echo '<script type="text/javascript">alert("管理员删除成功！");window.location="index.php?m=home&c=user&a=manager";</script>';
					}
				}else{
					if($db->where('id='.$_GET['id'])->delete()){
						echo '<script type="text/javascript">alert("管理员删除成功！");window.location="index.php?m=home&c=user&a=manager";</script>';
					}
				}
				echo '<script type="text/javascript">alert("管理员删除失败！");history.back();</script>';
			break;
		}
		
		$this->assign('res',$res);
		$this->display('manager_'.$method);	
	}
}