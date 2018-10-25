<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class Article31Controller extends CommonController {
    public function index(){
		$method = I('get.method') ? I('get.method') : 'list';
		$db=M('569856325');
		$this->assign('cur_nav',31);
		switch ($method) {
			case 'list':
				$res['count']=$db->count();
				$Page=new \Think\Page($res['count'],10000);
				$res['show']= $Page->show();// 分页显示输出
				$res['list'] = $db->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
				$this->assign('res',$res);	// 赋值分页输出
				$this->display('list');
			break;	
			case 'add':
				$this->assign('cur_nav','add');
				$this->assign('res',$res);
				if(I('post.sub')){
					$arr=array(
						'name'=>I('post.name'),
						'img'=>I('post.img'),
						'num'=>I('post.num'),
						'award'=>I('post.award'),
						'no_order'=>I('post.no_order'),
						'starttime'=>I('post.starttime'),
						'endtime'=>I('post.endtime'),
						'addtime'=>date('Y-m-d')
					);
					if($db->add($arr)){
						$this->success('添加成功');
						$this->redirect(U('index.php?m=Home&c=Article31&a=index&method=list'));
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
						'name'=>I('post.name'),
						'img'=>I('post.img'),
						'num'=>I('post.num'),
						'award'=>I('post.award'),
						'no_order'=>I('post.no_order'),
						'starttime'=>I('post.starttime'),
						'endtime'=>I('post.endtime'),
						'addtime'=>date('Y-m-d')
					);
					if($db->where('id='.$_POST['id'])->save($arr)){
						$this->success('修改成功');
						$this->redirect(U('index.php?m=Home&c=Article31&a=index&method=list'));
						exit;
					}else{
						// echo $db->getLastSql();exit;
						$this->error('修改失败');exit;
					}
				}
				$this->display('edit');
			break;
			case 'move':
				$field=$db->where('id='.$_POST['id'])->find();
				$field['cate']=I('post.cate');
				$field['tit']=I('post.tit');
				$field['img']=I('post.img');
				$field['view']=I('post.view');
				$field['order']=I('post.order');
				$field['content']=I('post.content');
				
				$field['status']=2;
				$field['addtime']=date('Y-m-d H:i:s');
				$db->where('id='.$field['id'])->save($field);
				
				
				if(empty($_POST['table'])){
					$this->error('另存为失败');exit;
				}else{
					foreach($_POST['table'] as $table){
						M($table)->add($field);
					}
					$this->success('另存为成功');exit;
				}
			break;
			case 'moveAll':
				$id_arr=explode(',',$_POST['ids']);
				foreach($id_arr as $val){
					$field=$db->where('id='.$val)->find();
					$field['status']=2;
					$field['addtime']=date('Y-m-d H:i:s');
					$db->where('id='.$field['id'])->save($field);
					if(empty($_POST['table'])){
					$this->error('另存为失败');exit;
					}else{
						foreach($_POST['table'] as $table){
							M($table)->add($field);
						}
					}
				}
				$this->success('另存为成功');exit;
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
			case 'search':
				if($_GET['status']){
					$where='status='.$_GET['status'];
				}else{
					$where='';
				}
				$res['count']=$db->where($where)->count();
				$Page=new \Think\Page($res['count'],100);
				$res['show']= $Page->show();// 分页显示输出
				$res['list'] = $db->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
				foreach($res['list'] as &$val){
					$val['cate']=M('category')->where('cate_id='.$val['cate'])->find()['cate_name'];
				}
				$this->assign('cur_status',$_GET['status']);
				$this->assign('res',$res);
				$this->display('search');
			break;
		}
	}
	
	public function pickup(){
		$this->assign('cur_nav','pickup');
		$method = I('get.method') ? I('get.method') : 'pickup';
		$db=$db;
		switch ($method) {
			case 'pickup':
				$this->display('pickup');		
			break;
			case 'pick':
				exec('/opt/php/bin/php /opt/data/web/news/admin/index.php Pickup/PickupArts/pickupKeyword/keyword/'.$_POST['keyword'].'/num/'.$_POST['num'], $output, $result);
				echo '<pre>';
				print_r($output);
				echo '</pre>';
			break;
		}
	}
	
	public function keyword(){
		$this->assign('cur_nav','keyword');
		$res['list']=$db->distinct(true)->where('keyword!=\'\'')->field('keyword')->select();
		foreach($res['list'] as &$val){
			$val['addtime']=$db->where('keyword!=\''.$val['keyword'].'\'')->field('addtime')->find()['addtime'];
		}
		$this->assign('res',$res);
		$this->display('keyword');		
	}
	
	public function gzConfig(){
		$method = I('get.method') ? I('get.method') : 'edit';
		switch ($method) {
			case 'edit':
				$res['field']=M('wechat_app')->where('id='.cookie('appid'))->find();
				$this->assign('res',$res);
				$this->assign('cur_nav','gz');
				$this->display('gzconfig_edit');
			break;	
			case 'update':
				$arr['gztitle']=$_POST['gztitle'];
				if(M('wechat_app')->where('id='.cookie('appid'))->save($arr)){
					$this->success('修改成功');
					exit;
				}else{
					$this->error('修改失败');exit;
				}
			break;
		}

			
		
				
	}
}