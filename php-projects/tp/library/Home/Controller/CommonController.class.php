<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function __construct(){
		parent::__construct();
		$user=cookie('user');
		if($user==''){
			echo '<script>alert("对不起，请通过正确的途径登录博考图书馆管理系统!");window.location.href="index.php?m=Home&c=Login&a=login";</script>';
		}
		$preview=M('preview')->query('select m.id,m.name,p.id,p.sysset,p.readerset,p.bookset,p.borrowback,p.sysquery from manager as m left join (select * from purview ) as p on m.id=p.mid where m.id='.$user['id'])[0];
		// print_r($preview);
		// echo M('preview')->getLastSql();
		$this->assign('user',$user);
		$this->assign('preview',$preview);
	} 	
}