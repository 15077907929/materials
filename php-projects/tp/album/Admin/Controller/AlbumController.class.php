<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
use Admin\Model\AlbumsModel;
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
	
	public function ajax_delalbum(){
		$db=M('albums');
		$db2=M('imgs');
		$find = $db->where('id='.$_GET['id'])->find();
		if(!$find){
			echo json_encode(array('ret'=>false,'msg'=>'要删除的相册不存在！'));
			exit;
		}
		$albums = $db2->where('album='.$_GET['id'])->select();
		if($albums){
			foreach($albums as $v){
				delpicfile($v['dir'],$v['pickey'],$v['ext']);
			}
		}
		if(AlbumsModel::del_album($_GET['id'])){
			echo json_encode(array('ret'=>true));
			exit;
		}else{
			echo json_encode(array('ret'=>false,'msg'=>'删除相册失败！'));
			exit;
		}
	}
	
	Public function ajax_edit_priv_albums(){
		$find=M('albums')->where('id='.$_POST['id'])->find();
        if($find){
            $html = '<div class="album_name_f"> <span>私有相册</span><input name="private" type="checkbox" value="1"';
            if($album['private'] == '1'){
                $html .=' checked="checked"';
            }
            $html .= ' /></div>';
            echo json_encode(array('ret'=>true,'html'=>$html));
            exit;
        }else{
            echo json_encode(array('ret'=>false,'msg'=>'相册不存在！'));
            exit;
        }
	}
	
	public function ajax_do_edit_priv_albums(){
        if(AlbumsModel::priv_album($_POST['id'],$_POST['private_v'])){
            echo json_encode(array('ret'=>true,'html'=>''));
            exit;
        }else{
            echo json_encode(array('ret'=>false,'msg'=>'修改相册权限失败！'));
            exit;
        }
	}
	
	public function ajax_renamealbum(){
		$db=M('albums');
		$data['name'] = trim($_POST['name']);

		$find = $db->where('id='.$_GET['id'])->find();
		if(!$find){
			echo json_encode(array('ret'=>false,'msg'=>'要编辑的相册不存在！'));
			exit;
		}
		if($data['name']){                
			if($db->where('id='.$_GET['id'])->save($data)){
				echo json_encode(array('ret'=>true,'albumname'=>$data['name']));
				exit;
			}else{
				echo json_encode(array('ret'=>false,'msg'=>'重命名相册失败！'));
				exit;
			}
		}else{
			echo json_encode(array('ret'=>true,'albumname'=>$find['name']));
			exit;
		}
	}
	
	public function ajax_delphoto(){
		$db=M('imgs');
		$find = $db->where('id='.$_GET['id'])->find();
		if(!$find){
			echo json_encode(array('ret'=>false,'msg'=>'要删除的图片不存在！'));
			exit;
		}
		delpicfile($find['dir'],$find['pickey'],$find['ext']);
		
		AlbumsModel::remove_cover($id);
		
		if($db->where('id='.$_GET['id'])->delete()){
			echo json_encode(array('ret'=>true));
			exit;
		}else{
			echo json_encode(array('ret'=>false,'msg'=>'删除图片失败！'));
			exit;
		}
	}
	
	public function ajax_set_cover(){
		$db=M('imgs');
		$find = $db->where('id='.$_GET['id'])->find();
		if(!$find){
			echo json_encode(array('ret'=>false,'msg'=>'图片已被删除无法设为封面！'));
			exit;
		}
		if(AlbumsModel::set_cover($find['album'],$_GET['id'])){
			echo json_encode(array('ret'=>true));
			exit;
		}else{
			echo json_encode(array('ret'=>false,'msg'=>'未能设为封面！'));
			exit;
		}
	}
	
	public function ajax_renamephoto(){
		$db=M('imgs');
		$data['name']=$_POST['name'];
		$find = $db->where('id='.$_GET['id'])->find();
		if(!$find){
			echo json_encode(array('ret'=>false,'msg'=>'要编辑的图片不存在！'));
			exit;
		}
		if($_POST['name']){
			if($db->where('id='.$_GET['id'])->save($data)){
				echo json_encode(array('ret'=>true,'picname'=>$data['name']));
				exit;
			}else{
				echo json_encode(array('ret'=>false,'msg'=>'重命名图片失败！'));
				exit;
			}
		}else{
			echo json_encode(array('ret'=>true,'picname'=>$find['name']));
			exit;
		}
	}
	
	public function ajax_get_albums(){
        $find = M('imgs')->where('id='.$_POST['id'])->find();
        $album_id = $find['album'];
        
        $list = AlbumsModel::get_albums_assoc($album_id);
        if($list){
            echo json_encode(array('ret'=>true,'list'=>$list));
            exit;
        }else{
            echo json_encode(array('ret'=>false,'msg'=>'目前无其他相册！'));
            exit;
        }
	}
	
	public function ajax_move_to_albums(){
		$db=M('imgs');
        $find = $db->where('id='.$_POST['id'])->find();
        if(!$find){
            echo json_encode(array('ret'=>false,'msg'=>'要移动的照片不存在！'));
            exit;
        }
        
        AlbumsModel::remove_cover($_POST['id']);

        if(AlbumsModel::update_pic($_POST['id'],$find['name'],intval($_POST['album_id']))){
            echo json_encode(array('ret'=>true));
            exit;
        }else{
            echo json_encode(array('ret'=>false,'msg'=>'未能移动照片！'));
            exit;
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
			$cover=AlbumsModel::get_cover($val['id'],$val['cover']);
			$res['albums'][$key]['cover'] = $cover?'Uploads/'.mkImgLink($cover['dir'],$cover['pickey'],$cover['ext'],'thumb'):'Public/images/nopic.jpg';
		}
		$this->assign('res',$res);
		$this->display();
	}
	
	public function photos(){
		$res['current_nav']='album';
		$db=M('albums');
		$db2=M('imgs');
		
        $res['page'] = $_GET['page'];
        if(!$res['page']){
            $res['page'] = 1;
        }
        if(!$_GET['album']){
            showInfo('相册参数错误！',false);
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
		
		$res['albums'] = AlbumsModel::get_albums_assoc($_GET['album']);
		$res['info'] = $db->where('id='.$_GET['album'])->find();
		
		$res['sort'] = $_GET['sort'];
		if(!$res['sort']){
			$res['sort']='time_desc';
		}
		if($res['sort'] == 'time_asc'){
            $order = 'create_time asc';
        }else{
            $order = 'create_time desc';
        }
		
		$res['total_num']      = $db2->order($order)->where('album='.$_GET['album'])->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($res['total_num'],15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$res['show']       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$res['photos'] = $db2->where('album='.$_GET['album'])->limit($Page->firstRow.','.$Page->listRows)->order($order)->select();
		
		$this->assign('res',$res);
		$this->display();
	}
}