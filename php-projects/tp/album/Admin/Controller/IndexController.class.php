<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
		$res['current_nav']='all';
		$db=M('imgs');
		
		$res['page'] = $_GET['page'];
        if(!$res['page']){
            $res['page'] = 1;
        }

		$flag = $_GET['flag'];
        
        switch($flag){
            case '1':
				$res['msginfo'] = '<div id="msginfo" class="fail">操作失败！请先选择要操作的图片！ <a href="javascript:void(0)"onclick="$(\'#msginfo\').hide()">[关闭]</a></div>';
            break;
            case '2':
				$res['msginfo'] = '<div id="msginfo" class="fail">操作失败！请选择要移动的相册！<a href="javascript:void(0)"onclick="$(\'#msginfo\').hide()">[关闭]</a></div>';
            break;
            case '3':
				$res['msginfo'] = '<div id="msginfo" class="succ">操作成功！<a href="javascript:void(0)"onclick="$(\'#msginfo\').hide()">[关闭]</a></div>';
            break;
            default:
				$res['msginfo'] = '';
        }
		
		$res['albums'] = M('albums')->select();
		
		$res['sort'] = $_GET['sort'];
		if(!$res['sort']){
			$res['sort']='time_desc';
		}
		if($res['sort'] == 'time_asc'){
            $order = 'create_time asc';
        }else{
            $order = 'create_time desc';
        }
		
		$res['total_num']      = $db->order($order)->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($res['total_num'],15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$res['show']       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$res['imgs'] = $db->limit($Page->firstRow.','.$Page->listRows)->order($order)->select();
		
		
		$this->assign('res',$res);
		$this->display();
	}    
	
	public function album(){
		$res['current_nav']='album';
		$db=M('albums');
		
		$res['total_num']      = $db->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($res['total_num'],15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$res['show']       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$res['albums'] = $db->limit($Page->firstRow.','.$Page->listRows)->select();
		
		
		$this->assign('res',$res);
		$this->display();
	}
}