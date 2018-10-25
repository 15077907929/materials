<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class Article9Controller extends CommonController {
    public function index(){
		$method = I('get.method') ? I('get.method') : 'list';
		$db=M('987654321');
		switch ($method) {
			case 'list':
				$this->assign('cur_nav','list');
				$res['cates']=M('category')->select();
				$res['count']=$db->count();
				$Page=new \Think\Page($res['count'],100);
				$res['show']= $Page->show();// 分页显示输出
				$res['list'] = $db->limit($Page->firstRow.','.$Page->listRows)->select();
				foreach($res['list'] as &$val){
					$val['art_cate']=M('category')->where('cate_id='.$val['art_cate'])->find()['cate_name'];
				}
				$this->assign('res',$res);	// 赋值分页输出
				$this->display('list');
			break;	
			case 'add':
				$labels=M('qq_group')->distinct(true)->field('labels')->select();
				$this->assign('cur_nav','add');
				$this->assign('labels',$labels);
				if(I('post.sub')){
					$arr=array(
						'labels'=>I('post.labels'),
						'group_num'=>I('post.group_num'),
						'starttime'=>I('post.start'),
						'endtime'=>I('post.end'),
						'content'=>I('post.content'),
						'addtime'=>date('Y-m-d')
					);
					if($db->add($arr)){
						$this->success('添加成功');exit;
					}else{
						$this->success('添加失败');
					}
				}
				$this->display('add');
			break;			
			case 'edit':
				$res['field']=$db->where('art_id='.$_GET['art_id'])->find();
				$res['cates']=M('category')->select();
				$this->assign('cur_nav','edit');
				$this->assign('res',$res);
				
				if(I('post.sub')){
					$field=$db->where('art_id='.$_POST['art_id'])->find();
					preg_match_all('/<img [^\']*src="([^\"]*)"[^\']*\/>/iU', $field['art_content'], $img_arr);
					if(!empty($img_arr)){
						$old_img_arr=$img_arr[1];
					}

					preg_match_all('/<img [^\']*src="([^\"]*)"[^\']*\/>/iU', htmlspecialchars_decode(I('post.art_content')), $img_arr);
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
					
					$arr=array(
						'art_cate'=>I('post.art_cate'),
						'art_tit'=>I('post.art_tit'),
						'art_view'=>I('post.art_view'),
						'art_status'=>I('post.art_status'),
						'art_content'=>I('post.art_content')
					);
					if($db->where('art_id='.$_POST['art_id'])->save($arr)){
						$this->success('修改成功');exit;
					}else{
						$this->success('修改失败');exit;
					}
				}
				$this->display('edit');
			break;
			case 'move':
				$field=$db->where('art_id='.$_POST['art_id'])->find();
				if(empty($_POST['table'])){
					$this->error('另存为失败');exit;
				}else{
					foreach($_POST['table'] as $table){
						M($table)->add($field);
					}
					$this->success('另存为成功');exit;
				}
			break;
			case 'del':	
				$field=$db->where('art_id='.I('get.art_id'))->find();
				if($db->where('art_id='.I('get.art_id'))->delete()){
					if(file_exists($field['art_img'])){
						unlink($field['art_img']);
					}
					preg_match_all('/<img [^\']*src="([^\"]*)"[^\']*\/>/iU', $field['art_content'], $img_arr);
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
					$this->success('删除失败');exit;
				}
			break;
			case 'search':
				$res['cates']=M('category')->select();
				$where='art_cate=\''.$_GET['art_cate'].'\'';
				$res['count']=$db->where($where)->count();
				$Page=new \Think\Page($res['count'],100);
				$res['show']= $Page->show();// 分页显示输出
				$res['list'] = $db->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
				foreach($res['list'] as &$val){
					$val['art_cate']=M('category')->where('cate_id='.$val['art_cate'])->find()['cate_name'];
				}
				$this->assign('cur_cate',$_GET['art_cate']);
				$this->assign('res',$res);
				$this->display('search');
			break;
		}
		
	}
}