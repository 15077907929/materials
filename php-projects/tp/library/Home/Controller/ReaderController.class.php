<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class ReaderController extends Controller {
	public function rtype(){
		$res['user']=cookie('user');
		if($res['user']==''){
			echo "<script>alert('对不起，请通过正确的途径登录博考图书馆管理系统!');window.location.href='index.php?m=Home&c=User&a=login';</script>";
		}
		$db=M('readertype');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				$res['types']=$db->select();
				// $res['books']=$db->query('select m.id,m.name,p.sysset,p.readerset,p.bookset,p.borrowback,p.sysquery from bookinfo as m left join (select * from purview)as p on m.id=p.mid');
			break;
			case 'add':
				if($_POST['sub']!=""){
					$data['name']=$_POST['name'];
					$data['number']=$_POST['number'];
					if($db->add($data)){
						echo '<script type="text/javascript">alert("读者类型添加成功！");window.close();window.opener.location.reload();</script>';
					}
					else{
						echo '<script type="text/javascript">alert("读者类型添加失败！");window.close();window.opener.location.reload();</script>';
					}
				}
			break;
			case 'modify':
				// $res['info']=$db->query('select m.id,m.name,p.sysset,p.readerset,p.bookset,p.borrowback,p.sysquery from bookinfo as m left join (select * from purview)as p on m.id=p.mid where m.id='.$_GET['id'])[0];
				$res['info']=$db->where('id='.$_GET['id'])->find();
				if($_POST['sub']!=""){
					$data['name']=$_POST['name'];
					$data['number']=$_POST['number'];
					$db->where('id='.$_POST['id'])->save($data);
					echo '<script type="text/javascript">alert("读者类型修改成功！");window.close();window.opener.location.reload();</script>';
				}
			break;
			case 'del':
				if($db->where('id='.$_GET['id'])->delete()){
					echo '<script type="text/javascript">alert("读者类型删除成功！");window.location="index.php?m=Home&c=Reader&a=rtype";</script>';
				}else{
					echo '<script type="text/javascript">alert("读者类型删除操作失败！");history.go(-1);</script>';
				}
			break;
		}
		
		$this->assign('res',$res);
		$this->display('rtype_'.$method);	
	}
	
	public function index(){
		$res['user']=cookie('user');
		if($res['user']==''){
			echo "<script>alert('对不起，请通过正确的途径登录博考图书馆管理系统!');window.location.href='index.php?m=Home&c=User&a=login';</script>";
		}
		$db=M('reader');
		$db2=M('purview');
		$db3=M('readertype');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				// $res['list']=$db->select();
				$res['list']=$db->query('select r.id,r.barcode,r.name,t.name as typename,r.paperType,r.paperNO,r.tel,r.email from reader as r join (select * from readertype) as t on r.typeid=t.id');
			break;
			case 'add':
				$res['rtype']=$db3->select();
				if($_POST['sub']!=""){
					$data['name']=$_POST['name'];
					$data['sex']=$_POST['sex'];
					$data['barcode']=$_POST['barcode'];
					$data['typeid']=$_POST['typeid'];
					$data['paperType']=$_POST['paperType'];
					$data['paperNO']=$_POST['paperNO'];
					$data['operator']=cookie('user')['name'];
					$data['createDate']=date("Y-m-d");
					if($db->add($data)){
						echo '<script type="text/javascript">alert("读者信息添加成功！");window.opener.location.reload();</script>';
					}
					else{
						echo '<script type="text/javascript">alert("读者信息添加失败！");history.back();</script>';
					}
				}
			break;
			case 'modify':
				// $res['info']=$db->query('select m.id,m.name,p.sysset,p.readerset,p.bookset,p.borrowback,p.sysquery from bookinfo as m left join (select * from purview)as p on m.id=p.mid where m.id='.$_GET['id'])[0];
				$res['info']=$db->where('id='.$_GET['id'])->find();
				$res['rtype']=$db3->select();
				if($_POST['sub']!=""){
					$data['name']=$_POST['name'];
					$data['sex']=$_POST['sex'];
					$data['barcode']=$_POST['barcode'];
					$data['typeid']=$_POST['typeid'];
					$data['paperType']=$_POST['paperType'];
					$data['paperNO']=$_POST['paperNO'];
					$data['operator']=cookie('user')['name'];
					$db->where('id='.$_POST['id'])->save($data);
					// echo $db->getLastSql();exit;
					echo '<script type="text/javascript">alert("读者信息修改成功！");window.location="index.php?m=Home&c=Reader&a=index";</script>';
				}
			break;
			case 'del':
				if($db->where('id='.$_GET['id'])->delete()){
					echo '<script type="text/javascript">alert("读者信息删除成功！");window.location="index.php?m=Home&c=Reader&a=index";</script>';
				}
			break;
		}
		
		$this->assign('res',$res);
		$this->display('reader_'.$method);	
	}
}