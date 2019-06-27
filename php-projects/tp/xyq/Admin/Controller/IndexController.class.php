<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		$user=cookie('user');
		if($user==''){
			redirect('index.php?m=Admin&c=User&a=login');
		}
		
		$db=M('plugin_wish');
		//批量删除
		if($_POST['submit']){
			if(is_array($_POST['delcheck'])&& count($_POST['delcheck'] )>0){
				$delstr=implode(',', $_POST['delcheck'] );
				$db->query('delete from plugin_wish where id in('.$delstr.')');
			}
		}
		// echo $db->getLastSql();exit;

		$res['total']      = $db->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($res['total'],10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$res['show']       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$res['wishes'] = $db->limit($Page->firstRow.','.$Page->listRows)->select();
		
		
		// print_r($res['show']);
		$this->assign('res',$res);
		$this->display();
	}
	
}