<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class SyssetController extends CommonController {
	public function bookcase(){
		$db=M('bookcase');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				$res['types']=$db->select();
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
		$db=M('publishing');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				$res['types']=$db->select();
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
	
	public function library(){
		$db=M('library');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
			
			break;
			case 'modify':
				$res['info']=$db->where('id=1')->find();
				if($_POST['sub']!=""){
					$data['name']=$_POST['name'];
					$data['curator']=$_POST['curator'];
					$data['tel']=$_POST['tel'];
					$data['address']=$_POST['address'];
					$data['email']=$_POST['email'];
					$data['url']=$_POST['url'];
					$data['createDate']=$_POST['createDate'];
					$data['introduce']=$_POST['introduce'];
					if(empty($res['info'])){
						$query=$db->add($data);
					}else{
						$query=$db->where('id=1')->save($data);
					}
					if($query){
						echo '<script type="text/javascript">alert("博考图书馆信息修改成功！");history.back();</script>';
					}else{
						echo '<script type="text/javascript">alert("博考图书馆信息修改失败！");history.back();</script>';
					}
				}			
			break;
		}
		$this->assign('res',$res);
		$this->display('library_'.$method);			
	}	
	
	public function parameter(){
		$db=M('parameter');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
			
			break;
			case 'modify':
				$res['info']=$db->where('id=1')->find();
				if($_POST['sub']!=""){
					$data['cost']=$_POST['cost'];
					$data['validity']=$_POST['validity'];
					if(empty($res['info'])){
						$query=$db->add($data);
					}else{
						$query=$db->where('id=1')->save($data);
					}
					if($query){
						echo '<script type="text/javascript">alert("修改成功！");history.back();</script>';
					}else{
						echo '<script type="text/javascript">alert("修改失败！");history.back();</script>';
					}
				}			
			break;
		}
		$this->assign('res',$res);
		$this->display('parameter_'.$method);			
	}
}