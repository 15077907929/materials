<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		$db=M('plugin_wish');
		if ($_POST['search']){
			$res['wishes']=$db->where('name=\''.$_POST['nickname'].'\'')->select();
		}else{
			$res['total']      = $db->count();// 查询满足要求的总记录数
			$Page       = new \Think\Page($res['total'],10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$res['show']       = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$res['wishes'] = $db->limit($Page->firstRow.','.$Page->listRows)->select();
		}
		// echo $db->getLastSql();
		// print_r($res['show']);
		$this->assign('res',$res);
		$this->display();
	}
	
	public function new_post(){
		if($_POST['add']){
			$arr['name']=CleanHtmlTags(trim($_POST['singnature']));
			$arr['bg_id']=trim($_POST['tagbgcolor']);
			$arr['content']=CleanHtmlTags(trim($_POST['messages']));
			$arr['sign_id']=trim($_POST['tagbgpic']);
			if (!empty( $arr['singnature'])&&!empty($arr['tagbgcolor'])&&!empty($arr['messages'])&&!empty($arr['tagbgpic'] )&&!is_numeric($arr['tagbgcolor'])&&!is_numeric($arr['tagbgpic']))
				exit( '参数错误!' );
			$arr['ip'] = GetIP();
			$arr['add_time']=date('Y-m-d H:i:s');
			M('plugin_wish')->add($arr);
			header( "location:index.php" );
			exit;
		}
		$this->display();
	}
}