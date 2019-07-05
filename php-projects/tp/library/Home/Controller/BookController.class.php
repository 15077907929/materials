<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class BookController extends CommonController {
	public function index(){
		$db=M('bookinfo');
		$db2=M('purview');
		$db3=M('bookcase');
		$db4=M('booktype');
		$db5=M('publishing');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				$res['books']=$db->query('select book.barcode,book.id,book.name,bc.name as bookcasename,bt.name as typename,pb.name as pubname from bookinfo book join booktype bt on book.typeid=bt.id join bookcase bc on book.bookcase=bc.id join publishing pb on book.pubid=pb.id');
			break;
			case 'add':
				$res['bookcase']=$db3->select();
				$res['booktype']=$db4->select();
				$res['publishing']=$db5->select();
				if($_POST['sub']!=""){
					$data['barcode']=$_POST['barcode'];
					$data['name']=$_POST['name'];
					$data['typeid']=$_POST['typeid'];
					$data['author']=$_POST['author'];
					$data['pubid']=$_POST['pubid'];
					$data['price']=$_POST['price'];
					$data['bookcase']=$_POST['bookcaseid'];
					$data['operator']=cookie('user')['name'];
					$data['inTime']=date("Y-m-d");
					if($db->add($data)){
						echo '<script type="text/javascript">alert("图书信息添加成功！");history.back();</script>';
					}
					else{
						echo '<script type="text/javascript">alert("图书信息添加失败！");history.back();</script>';
					}
				}
			break;
			case 'modify':
				$res['info']=$db->where('id='.$_GET['id'])->find();
				$res['bookcase']=$db3->select();
				$res['booktype']=$db4->select();
				$res['publishing']=$db5->select();
				if($_POST['sub']!=""){
					$data['barcode']=$_POST['barcode'];
					$data['name']=$_POST['name'];
					$data['typeid']=$_POST['typeid'];
					$data['author']=$_POST['author'];
					$data['pubid']=$_POST['pubid'];
					$data['price']=$_POST['price'];
					$data['bookcase']=$_POST['bookcaseid'];
					$data['operator']=cookie('user')['name'];
					$data['inTime']=date("Y-m-d");
					$db->where('id='.$_POST['id'])->save($data);
					echo '<script type="text/javascript">alert("图书信息修改成功！");window.location="index.php?m=Home&c=Book&a=index&method=modify&id='.$_POST['id'].'";</script>';
				}
			break;
			case 'del':
				if($db->where('id='.$_GET['id'])->delete()){
					echo '<script type="text/javascript">alert("图书信息删除成功！");window.location="index.php?m=Home&c=Book&a=index";</script>';
				}
			break;
		}
		$this->assign('res',$res);
		$this->display('book_'.$method);	
	}
	
	public function look(){
		$db=M('bookinfo');
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
				$res['info']=$db->query('select book.barcode,book.id,book.name,book.price,book.author,bc.name as bookcasename,bt.name as typename,pb.name as pubname from bookinfo book join booktype bt on book.typeid=bt.id join bookcase bc on book.bookcase=bc.id join publishing pb on book.pubid=pb.id where book.id='.$_GET['id'])[0];
			break;
		}
		$this->assign('res',$res);
		$this->display('look_'.$method);		
	}
}