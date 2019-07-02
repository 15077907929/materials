<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class BbbController extends Controller {
	public function borrow(){
		$method = I('get.method') ? I('get.method') : 'show';
		$db=M('borrow');
		switch ($method) {
            case 'show':
				if($_POST['barcode']||$_GET['barcode']){
					if($_POST['barcode']==''){
						$_POST['barcode']=$_GET['barcode'];
					}
					$res['info']=M('reader')->query('select r.*,t.name as typename,t.number from reader r left join readertype t on r.typeid=t.id where r.barcode=\''.$_POST['barcode'].'\' limit 1')[0];
					if(isset($res['info']['sex'])){
						if($res['info']['sex']=='1'){
							$res['info']['sex']='男';
						}else{
							$res['info']['sex']='女';
						}
					}
					$res['borr']=$db->query('select r.*,borr.borrowTime,borr.backTime,book.name as bookname,book.price,pub.name as pubname,bc.name as bookcase from borrow as borr join bookinfo as book on book.id=borr.bookid join publishing as pub on book.pubid=pub.id  join bookcase as bc on book.bookcase=bc.id join reader as r on borr.readerid=r.id  where borr.readerid='.$res['info']['id'].' and borr.ifback=0');
					$res['borrnum']=count($res['borr']);
					// echo '<pre>';
					// print_r($arr);
					// echo '</pre>';
				}
				if($_POST['inputkey']!=""){
					$f=$_POST['f'];
					$inputkey=trim($_POST['inputkey']);
					$barcode=$_POST['barcode'];
					$data['readerid']=$_POST['rid'];
					$data['borrowTime']=date('Y-m-d');
					$data['backTime']=date("Y-m-d",(time()+3600*24*30));        //归还图书日期为当前期日期+30天期限
					$book=M('bookinfo')->where($f.'=\''.$inputkey.'\'')->find();	//检索图书信息是否存在
					if(empty($book)){
						echo '<script type="text/javascript">alert("该图书不存在！");window.location.href="index.php?m=Home&c=Bbb&a=borrow&barcode='.$barcode.'";</script>';
					}
					else{
						$query=M('reader')->query('select r.*,borr.borrowTime,borr.backTime,book.name as bookname,book.price,pub.name as pubname,bc.name as bookcase from borrow as borr join reader as r on borr.readerid=r.id join bookinfo as book on book.id=borr.bookid join publishing as pub on book.pubid=pub.id  join bookcase as bc on book.bookcase=bc.id  where borr.bookid='.$book['id'].' and borr.readerid='.$_POST['rid'].' and ifback=0');   //检索该读者所借阅的图书是否与再借图书重复
						if(!empty($query)){    //如果借阅的图书已被该读者借阅，那么提示不能重复借阅 
							echo '<script type="text/javascript">alert("该图书已经借阅！");window.location.href="index.php?m=Home&c=Bbb&a=borrow&barcode='.$barcode.'";</script>';
						}
						else{    //否则，完成图书借阅操作
							$data['bookid']=$book['id'];
							$data['operator']=cookie('user')['name'];
							$data['ifback']=0;
							$db->add($data);
							echo '<script type="text/javascript">alert("图书借阅操作成功！");window.location.href="index.php?m=Home&c=Bbb&a=borrow&barcode='.$barcode.'";</script>';
						}
					}
				}
			break;
		}
		$this->assign('res',$res);
		$this->display('borrow_'.$method);	
	}
	
	public function index(){
		$res['user']=cookie('user');
		if($res['user']==''){
			echo "<script>alert('对不起，请通过正确的途径登录博考图书馆管理系统!');window.location.href='index.php?m=Home&c=User&a=login';</script>";
		}
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
            case 'show':
			break;
			
		}
		
		$this->assign('res',$res);
		$this->display('book_'.$method);	
	}
}