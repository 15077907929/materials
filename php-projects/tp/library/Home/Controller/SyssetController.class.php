<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class SyssetController extends Controller {
	public function bookcase(){
		$res['user']=cookie('user');
		if($res['user']==''){
			echo "<script>alert('对不起，请通过正确的途径登录博考图书馆管理系统!');window.location.href='index.php?m=Home&c=User&a=login';</script>";
		}
		$db=M('bookcase');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				$res['types']=$db->select();
				// $res['books']=$db->query('select m.id,m.name,p.sysset,p.readerset,p.bookset,p.borrowback,p.sysquery from bookinfo as m left join (select * from purview)as p on m.id=p.mid');
			break;
			case 'add':
				if($_POST['sub']!=""){
					$data['name']=$_POST['name'];
					if($db->add($data)){
						echo '<script type="text/javascript">alert("书架信息添加成功！");window.close();window.opener.location.reload();</script>';
					}
					else{
						echo '<script type="text/javascript">alert("书架信息添加失败！");window.close();window.opener.location.reload();</script>';
					}
				}
			break;
			case 'modify':
				// $res['info']=$db->query('select m.id,m.name,p.sysset,p.readerset,p.bookset,p.borrowback,p.sysquery from bookinfo as m left join (select * from purview)as p on m.id=p.mid where m.id='.$_GET['id'])[0];
				$res['info']=$db->where('id='.$_GET['id'])->find();
				if($_POST['sub']!=""){
					$data['name']=$_POST['name'];
					$db->where('id='.$_POST['id'])->save($data);
					echo '<script type="text/javascript">alert("书架信息修改成功！");window.close();window.opener.location.reload();</script>';
				}
			break;
			case 'del':
				if($db->where('id='.$_GET['id'])->delete()){
					echo '<script type="text/javascript">alert("书架信息删除成功！");window.location="index.php?m=Home&c=Sysset&a=bookcase";</script>';
				}else{
					echo '<script type="text/javascript">alert("书架信息删除失败！");history.go(-1);</script>';
				}
			break;
		}
		
		$this->assign('res',$res);
		$this->display('bookcase_'.$method);	
	}	
	
	public function booktype(){
		$res['user']=cookie('user');
		if($res['user']==''){
			echo "<script>alert('对不起，请通过正确的途径登录博考图书馆管理系统!');window.location.href='index.php?m=Home&c=User&a=login';</script>";
		}
		$db=M('booktype');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				$res['types']=$db->select();
				// $res['books']=$db->query('select m.id,m.name,p.sysset,p.readerset,p.bookset,p.borrowback,p.sysquery from bookinfo as m left join (select * from purview)as p on m.id=p.mid');
			break;
			case 'add':
				if($_POST['sub']!=""){
					$data['name']=$_POST['name'];
					if($db->add($data)){
						echo '<script type="text/javascript">alert("图书类型添加成功！");window.close();window.opener.location.reload();</script>';
					}
					else{
						echo '<script type="text/javascript">alert("图书类型添加失败！");window.close();window.opener.location.reload();</script>';
					}
				}
			break;
			case 'modify':
				// $res['info']=$db->query('select m.id,m.name,p.sysset,p.readerset,p.bookset,p.borrowback,p.sysquery from bookinfo as m left join (select * from purview)as p on m.id=p.mid where m.id='.$_GET['id'])[0];
				$res['info']=$db->where('id='.$_GET['id'])->find();
				if($_POST['sub']!=""){
					$data['name']=$_POST['name'];
					$db->where('id='.$_POST['id'])->save($data);
					echo '<script type="text/javascript">alert("图书类型修改成功！");window.close();window.opener.location.reload();</script>';
				}
			break;
			case 'del':
				if($db->where('id='.$_GET['id'])->delete()){
					echo '<script type="text/javascript">alert("图书类型删除成功！");window.location="index.php?m=Home&c=Sysset&a=bookcase";</script>';
				}else{
					echo '<script type="text/javascript">alert("图书类型删除失败！");history.go(-1);</script>';
				}
			break;
		}
		
		$this->assign('res',$res);
		$this->display('booktype_'.$method);	
	}
	
	public function publishing(){
		$res['user']=cookie('user');
		if($res['user']==''){
			echo "<script>alert('对不起，请通过正确的途径登录博考图书馆管理系统!');window.location.href='index.php?m=Home&c=User&a=login';</script>";
		}
		$db=M('publishing');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				$res['types']=$db->select();
				// $res['books']=$db->query('select m.id,m.name,p.sysset,p.readerset,p.bookset,p.borrowback,p.sysquery from bookinfo as m left join (select * from purview)as p on m.id=p.mid');
			break;
			case 'add':
				if($_POST['sub']!=""){
					$data['ISBN']=$_POST['ISBN'];
					$data['name']=$_POST['name'];
					if($db->add($data)){
						echo '<script type="text/javascript">alert("出版社添加成功！");window.close();window.opener.location.reload();</script>';
					}
					else{
						echo '<script type="text/javascript">alert("出版社添加失败！");window.close();window.opener.location.reload();</script>';
					}
				}
			break;
			case 'modify':
				// $res['info']=$db->query('select m.id,m.name,p.sysset,p.readerset,p.bookset,p.borrowback,p.sysquery from bookinfo as m left join (select * from purview)as p on m.id=p.mid where m.id='.$_GET['id'])[0];
				$res['info']=$db->where('id='.$_GET['id'])->find();
				if($_POST['sub']!=""){
					$data['ISBN']=$_POST['ISBN'];
					$data['name']=$_POST['name'];
					$db->where('id='.$_POST['id'])->save($data);
					echo '<script type="text/javascript">alert("出版社修改成功！");window.close();window.opener.location.reload();</script>';
				}
			break;
			case 'del':
				if($db->where('id='.$_GET['id'])->delete()){
					echo '<script type="text/javascript">alert("出版社删除成功！");window.location="index.php?m=Home&c=Sysset&a=bookcase";</script>';
				}else{
					echo '<script type="text/javascript">alert("出版社删除失败！");history.go(-1);</script>';
				}
			break;
		}
		
		$this->assign('res',$res);
		$this->display('publishing_'.$method);	
	}
}