<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class QueryController extends Controller {
	public function book(){
		$res['user']=cookie('user');
		if($res['user']==''){
			echo "<script>alert('对不起，请通过正确的途径登录博考图书馆管理系统!');window.location.href='index.php?m=Home&c=User&a=login';</script>";
		}
		$db=M('bookinfo');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				$res['books']=$db->select();
				if($_POST['key']==''){
					$res['sbooks']=$db->query('select book.barcode,book.id,book.name,bc.name as bookcasename,bt.name as typename,pb.name as pubname from bookinfo book join booktype bt on book.typeid=bt.id join bookcase bc on book.bookcase=bc.id join publishing pb on book.pubid=pb.id');
				}else{
					$res['sbooks']=$db->query('select book.barcode,book.id,book.name,bc.name as bookcasename,bt.name as typename,pb.name as pubname from bookinfo book join booktype bt on book.typeid=bt.id join bookcase bc on book.bookcase=bc.id join publishing pb on book.pubid=pb.id where '.$_POST['f'].' like \'%'.$_POST['key'].'%\'');
					$res['key']=$_POST['key'];
				}
			break;
		}
		$this->assign('res',$res);
		$this->display('book_'.$method);	
	}
	
	public function borrow(){
		$res['user']=cookie('user');
		if($res['user']==''){
			echo "<script>alert('对不起，请通过正确的途径登录博考图书馆管理系统!');window.location.href='index.php?m=Home&c=User&a=login';</script>";
		}
		$db=M('borrow');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				$res['borrows']=$db->query('select b.borrowTime,b.backTime,b.ifback,r.barcode as readerbarcode,r.name as readername,k.id,k.barcode,k.name as bookname from borrow b join reader r on b.readerid=r.id join bookinfo k on b.bookid=k.id');
				if($_POST['sub']!=''){
					$f=$_POST['f'];
					$key=$_POST['key'];
					$sdate=$_POST['sdate'];
					$edate=$_POST['edate'];
					$flag1=$_POST['flag1'];
					$flag2=$_POST['flag2'];
					if($flag1=='a'){
						$res['borrows']=$db->query('select b.borrowTime,b.backTime,b.ifback,r.barcode as readerbarcode,r.name as readername,k.id,k.barcode,k.name as bookname from borrow b join reader r on b.readerid=r.id join bookinfo k on b.bookid=k.id where '.$f.' like \'%'.$key.'%\'');
					}
					if($flag2=='b'){
						$res['borrows']=$db->query('select b.borrowTime,b.backTime,b.ifback,r.barcode as readerbarcode,r.name as readername,k.id,k.barcode,k.name as bookname from borrow b join reader r on b.readerid=r.id join bookinfo k on b.bookid=k.id where borrowTime between \''.$sdate.'\' and \''.$edate.'\'');
					}
					if($flag1=='a' && $flag2=='b'){
						$res['borrows']=$db->query('select b.borrowTime,b.backTime,b.ifback,r.barcode as readerbarcode,r.name as readername,k.id,k.barcode,k.name as bookname from borrow b join reader r on b.readerid=r.id join bookinfo k on b.bookid=k.id where borrowTime between \''.$sdate.'\' and \''.$edate.'\' and '.$f.' like \'%'.$key.'%\'');
					}
				}
			break;
		}
		$this->assign('res',$res);
		$this->display('borrow_'.$method);	
	}
	
	public function bremind(){
		$res['user']=cookie('user');
		if($res['user']==''){
			echo "<script>alert('对不起，请通过正确的途径登录博考图书馆管理系统!');window.location.href='index.php?m=Home&c=User&a=login';</script>";
		}
		$db=M('borrow');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				$time=date('Y-m-d');
				$res['list']=$db->query('select book.barcode,book.name as bookname,reader.barcode as readerbarcode,reader.name as readername,borr.borrowTime,borr.backTime,borr.ifback from bookinfo book join borrow as borr on book.id=borr.bookid join reader on borr.readerid=reader.id where borr.backTime<=\''.$time.'\' and borr.ifback=0');;
			break;
		}
		// print_r($res);
		// echo $db->getLastSql();
		$this->assign('res',$res);
		$this->display('bremind_'.$method);	
	}
}