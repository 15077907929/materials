<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		$user=cookie('user');
		if($user==''){
			echo "<script>alert('对不起，请通过正确的途径登录博考图书馆管理系统!');window.location.href='index.php?m=Home&c=User&a=login';</script>";
		}
		$res['user']=$user;
		$res['rank']=M('borrow')->query('select * from (select bookid,count(bookid) as degree from borrow group by bookid) as borr join (select b.*,c.name as bookcasename,p.name as pubname,t.name as typename from bookinfo b left join bookcase c on b.bookcase=c.id join publishing p on b.pubid=p.id join booktype t on b.typeid=t.id where b.del=0) as book on borr.bookid=book.id order by borr.degree desc limit 10');		
		$this->assign('res',$res);
		$this->display();
	}
}