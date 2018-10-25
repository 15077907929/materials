<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class NboxController extends CommonController {
    public function index(){
		$method = I('get.method') ? I('get.method') : 'list';
		$db=M('nbox');
		$this->assign('cur_nav','nlist');
		switch ($method) {
			case 'list':
				$res['count']=$db->count();
				$Page=new \Think\Page($res['count'],10000);
				$res['show']= $Page->show();// 分页显示输出
				$res['list'] = $db->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
				foreach($res['list'] as &$val){
					$val['category']=M('nbox_cates')->where('id='.$val['category'])->find()['name'];
				}
				$this->assign('res',$res);	// 赋值分页输出
				$this->display('list');
			break;	
			case 'add':
				$res['cates']=M('category')->where('cate_id>21')->select();
				$res['keyword']=$db->distinct(true)->where('keyword!=\'\'')->field('keyword')->select();
				$this->assign('res',$res);
				if(I('post.sub')){
					$arr=array(
						'cate'=>I('post.cate'),
						'tit'=>I('post.tit'),
						'img'=>I('post.img'),
						'view'=>I('post.view'),
						'content'=>I('post.content'),
						'addtime'=>date('Y-m-d')
					);
					if($db->add($arr)){
						$this->success('添加成功');
						$this->redirect(U('index.php?m=Home&c=Nbox&a=index&method=list'));
					}else{
						$this->error('添加失败');
					}
				}
				$this->display('add');
			break;			
			case 'edit':
				$res['field']=$db->where('id='.$_GET['id'])->find();
				$res['keyword']=$db->distinct(true)->where('keyword!=\'\'')->field('keyword')->select();
				$res['cates']=M('category')->where('cate_id>21')->select();
				$this->assign('res',$res);
				
				if(I('post.sub')){
					$field=$db->where('id='.$_POST['id'])->find();
					preg_match_all('/<img [^\']*src="([^\"]*)"[^\']*\/>/iU', $field['content'], $img_arr);
					if(!empty($img_arr)){
						$old_img_arr=$img_arr[1];
					}

					preg_match_all('/<img [^\']*src="([^\"]*)"[^\']*\/>/iU', htmlspecialchars_decode(I('post.content')), $img_arr);
					if(!empty($img_arr)){
						$new_img_arr=$img_arr[1];
					}
											
					foreach($old_img_arr as $val){
						$find=false;
						foreach($new_img_arr as $v){
							if($val==$v){
								$find=true;
							}
						}
						if(!$find){
							if(file_exists('/opt/data/web/news/admin'.$val)){
								unlink('/opt/data/web/news/admin'.$val);
							}								
						}
					}
					if($field['img']!=I('post.img')){
						if(file_exists($field['img'])){
							unlink($field['img']);
						}
					}
					if($_POST['status']==0){
						$status=$_POST['status'];
					}else{
						$status=2;
					}
					$arr=array(
						'cate'=>I('post.cate'),
						'tit'=>I('post.tit'),
						'img'=>I('post.img'),
						'file'=>I('post.file'),
						'view'=>I('post.view'),
						'order'=>I('post.order'),
						'status'=>$status,
						'content'=>I('post.content')
					);
					if($db->where('id='.$_POST['id'])->save($arr)){
						$this->success('修改成功');
						$this->redirect(U('index.php?m=Home&c=Nbox&a=index&method=list'));
						exit;
					}else{
						$this->error('修改失败');exit;
					}
				}
				$this->display('edit');
			break;
			case 'del':	
				$field=$db->where('id='.I('get.id'))->find();
				if($db->where('id='.I('get.id'))->delete()){
					if(file_exists($field['img'])){
						unlink($field['img']);
					}
					preg_match_all('/<img [^\']*src="([^\"]*)"[^\']*\/>/iU', $field['content'], $img_arr);
					if(!empty($img_arr)){
						$img_arr=$img_arr[1];
					}
					foreach($img_arr as $key=>$val){
						if(file_exists('/opt/data/web/news/admin'.$val)){
							unlink('/opt/data/web/news/admin'.$val);
						}					
					}
					$this->success('删除成功');exit;
				}else{
					$this->error('删除失败');exit;
				}
			break;

		}
	}    
	
	public function cates(){
		$method = I('get.method') ? I('get.method') : 'list';
		$db=M('nbox_cates');
		$this->assign('cur_nav','ncates');
		switch ($method) {
			case 'list':
				$res['count']=$db->count();
				$Page=new \Think\Page($res['count'],10000);
				$res['show']= $Page->show();// 分页显示输出
				$res['list'] = $db->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
				$this->assign('res',$res);	// 赋值分页输出
				$this->display('cate_list');
			break;	
			case 'add':
				if(I('post.sub')){
					$arr=array(
						'name'=>I('post.name'),
						'img'=>I('post.img'),
						'addtime'=>date('Y-m-d')
					);
					if($db->add($arr)){
						$this->success('添加成功');
						$this->redirect(U('index.php?m=Home&c=Nbox&a=cates&method=list'));
					}else{
						$this->error('添加失败');
					}
				}
				$this->display('cate_add');
			break;			
			case 'edit':
				$res['field']=$db->where('id='.$_GET['id'])->find();
				if(I('post.sub')){
					$field=$db->where('id='.$_POST['id'])->find();
					if($field['img']!=I('post.img')){
						if(file_exists($field['img'])){
							unlink($field['img']);
						}
					}
					$arr=array(
						'name'=>I('post.name'),
						'img'=>I('post.img'),
					);
					if($db->where('id='.$_POST['id'])->save($arr)){
						$this->success('修改成功');
						$this->redirect(U('index.php?m=Home&c=Nbox&a=cates&method=list'));
						exit;
					}else{
						$this->error('修改失败');exit;
					}
				}
				$this->assign('res',$res);
				$this->display('cate_edit');
			break;
			case 'del':	
				$field=$db->where('id='.I('get.id'))->find();
				if($db->where('id='.I('get.id'))->delete()){
					if(file_exists($field['img'])){
						unlink($field['img']);
					}
					$this->success('删除成功');exit;
				}else{
					$this->error('删除失败');exit;
				}
			break;

		}
	}
}