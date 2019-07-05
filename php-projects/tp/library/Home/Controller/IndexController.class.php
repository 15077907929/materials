<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
		$res['rank']=M('borrow')->query('select * from (select bookid,count(bookid) as degree from borrow group by bookid) as borr join (select b.*,c.name as bookcasename,p.name as pubname,t.name as typename from bookinfo b left join bookcase c on b.bookcase=c.id join publishing p on b.pubid=p.id join booktype t on b.typeid=t.id where b.del=0) as book on borr.bookid=book.id order by borr.degree desc limit 10');		
		$this->assign('res',$res);
		$this->display();
	}
}