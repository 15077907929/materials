<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class UserController extends CommonController {
    public function index(){
		$db=M('user');
		$method = I('get.method') ? I('get.method') : 'list';
		switch ($method) {
			case 'list':
				$this->assign('cur_nav','list');
				$res['count']=$db->count();
				$Page=new \Think\Page($res['count'],125);
				$res['show']= $Page->show();// 分页显示输出
				$res['list'] = $db->limit($Page->firstRow.','.$Page->listRows)->select();
				$this->assign('res',$res);	// 赋值分页输出
				$this->display('list');
			break;			
			case 'search':
				$res['labels']=M('qq_group')->distinct(true)->field('labels')->select();
				$where='labels=\''.$_GET['labels'].'\'';
				$res['count']=$db->where($where)->count();
				$Page=new \Think\Page($res['count'],25);
				$res['show']= $Page->show();// 分页显示输出
				$res['list'] = $db->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
				
				$this->assign('cur_labels',$_GET['labels']);
				$this->assign('res',$res);
				$this->display('search');
			break;
			case 'add':
				$this->assign('cur_nav','add');
				if(I('post.sub')){
					foreach($_POST['appid'] as $val){
						$appid.=','.$val;
					}
					$appid=trim($appid,',');
					$arr=array(
						'user_name'=>I('post.user_name'),
						'user_pass'=>md5(I('post.user_pass')),
						'user_type'=>I('post.user_type'),
						'appid'=>$appid,
						'addtime'=>date('Y-m-d')
					);
					if($db->add($arr)){
						$this->success('添加成功');
						$this->redirect('index.php?m=Home&c=User&a=index&method=list');
						exit;
					}else{
						$this->error('添加失败');
					}
				}
				$this->display('add');
			break;
			case 'edit':
				$res['field']=$db->where('id='.$_GET['id'])->find();
				$this->assign('res',$res);
				if(I('post.sub')){
					foreach($_POST['appid'] as $val){
						$appid.=','.$val;
					}
					$appid=trim($appid,',');
					$arr=array(
						'user_name'=>I('post.user_name'),
						'user_pass'=>md5(I('post.user_pass')),
						'user_type'=>I('post.user_type'),
						'appid'=>$appid,
						'addtime'=>date('Y-m-d')
					);
					if($db->where('id='.$_POST['id'])->save($arr)){
						$this->success('修改成功');
						// $this->redirect(U('index.php?m=Home&c=User&a=index'));
						exit;
					}else{
						$this->error('修改失败');exit;
					}
				}
				$this->display('edit');
			break;
		}
		
	}
}