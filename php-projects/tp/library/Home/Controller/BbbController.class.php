<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class BbbController extends CommonController {
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
	
	public function renew(){
		$res['user']=cookie('user');
		if($res['user']==''){
			echo "<script>alert('对不起，请通过正确的途径登录博考图书馆管理系统!');window.location.href='index.php?m=Home&c=User&a=login';</script>";
		}
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
					$res['borr']=M('borrow')->query('select borr.id as borrid,borr.borrowTime,borr.backTime,borr.ifback,t.name as typename,t.number,book.name as bookname,book.price,pub.name as pubname,bc.name as bookcase from borrow as borr join reader r on borr.readerid=r.id join readertype t on r.typeid=t.id join bookinfo as book on book.id=borr.bookid join publishing as pub on book.pubid=pub.id  join bookcase as bc on book.bookcase=bc.id where r.barcode=\''.$_POST['barcode'].'\' and borr.ifback=0');
				}
			break;
			case 'borrow_oncemore':
				$barcode=$_GET['barcode'];
				$new=$_GET['backTime'];
				$newbackTime=date("Y-m-d",(mktime(0, 0, 0, substr($new,5,2), substr($new,8,2), substr($new,0,4))+3600*24*30));   //更新续借期，将动态获取的还书期日转化为时间截，然后再求出续借后的还书日期
				$borrid=$_GET['borrid'];
				$db->query('update borrow set backTime=\''.$newbackTime.'\',ifback=0,operator=\''.cookie('user')['name'].'\' where id='.$borrid);
				echo '<script type="text/javascript">alert("图书续借操作成功！");window.location.href="index.php?m=Home&c=Bbb&a=renew&barcode='.$barcode.'";</script>';
			break;
		}
		
		$this->assign('res',$res);
		$this->display('renew_'.$method);	
	}
	
	public function bookback(){
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
					$res['borr']=M('borrow')->query('select borr.id as borrid,borr.borrowTime,borr.backTime,borr.ifback,t.name as typename,t.number,book.name as bookname,book.price,pub.name as pubname,bc.name as bookcase from borrow as borr join reader r on borr.readerid=r.id join readertype t on r.typeid=t.id join bookinfo as book on book.id=borr.bookid join publishing as pub on book.pubid=pub.id  join bookcase as bc on book.bookcase=bc.id where r.barcode=\''.$_POST['barcode'].'\' and borr.ifback=0');
				}
			break;
			case 'back':
				$barcode=$_GET['barcode'];
				$backTime=date("Y-m-d");        //归还图书日期
				$borrid=$_GET[borrid];
				$db->query('update borrow set backTime=\''.$backTime.'\',ifback=1,operator=\''.cookie('user')['name'].'\' where id='.$borrid);
				echo '<script type="text/javascript">alert("图书归还操作成功！");window.location.href="index.php?m=Home&c=Bbb&a=bookback&barcode='.$barcode.'";</script>';
			break;
		}
		$this->assign('res',$res);
		$this->display('bookback_'.$method);	
	}
}