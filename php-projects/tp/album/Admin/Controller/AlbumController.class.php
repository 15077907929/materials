<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class AlbumController extends CommonController {
	public function ajax_create_album(){
		$db=M('albums');
		$data['name']=$_POST['album_name'];
        $data['private']=intval($_POST['album_private']);
		$data['create_time']=time();
        if($db->add($data)){
            $list = $db->select();
            echo json_encode(array('ret'=>true,'list'=>$list));
        }else{
            echo json_encode(array('ret'=>false,'msg'=>'创建相册失败！'));
        }
	}
	
	public function album(){
		$res['current_nav']='album';
		$db=M('albums');
		$db2=M('imgs');
		
		$res['total_num']      = $db->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($res['total_num'],15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$res['show']       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$res['albums'] = $db->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach($res['albums'] as $key=>$val){
			$cover=$db2->where('album='.$val['id'])->find();
			$res['albums'][$key]['cover'] = $cover?'Uploads/'.mkImgLink($cover['dir'],$cover['pickey'],$cover['ext'],'thumb'):'Public/images/nopic.jpg';
		}
		$this->assign('res',$res);
		$this->display();
	}
	
	public function photos(){
		$res['current_nav']='album';
		$db=M('albums');
		$db2=M('imgs');
		
		$res['albums'] = $db->select();
		$res['info'] = $db->where('id='.$_GET['album'])->find();
		
		$res['total_num']      = $db2->where('album='.$_GET['album'])->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($res['total_num'],15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$res['show']       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$res['photos'] = $db2->where('album='.$_GET['album'])->limit($Page->firstRow.','.$Page->listRows)->select();
		
		$this->assign('res',$res);
		$this->display();
	}
}