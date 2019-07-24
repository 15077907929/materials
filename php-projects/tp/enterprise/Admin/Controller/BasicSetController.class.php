<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class BasicSetController extends CommonController {	
	public function admin(){
		$method = I('get.method') ? I('get.method') : 'show';
		$db=M('column');
		$db2=M('admin');
		switch ($method) {
			case 'show':
				$res['info']=$db->where('id='.$_GET['class1'])->find();
				$res['class2']=$_GET['class2'];
				$res['class3']=$_GET['class3'];
				$res['class2_list']=$db->where('bigclass='.$_GET['class1'])->select();
				if($_GET['class2']){
					$res['class3_list']=$db->where('bigclass='.$_GET['class2'])->select();
				}
				if(!empty($res['class2_list'])){
					$res['class2_listok']=1;
				}
				if(!empty($res['class3_list'])){
					$res['class3_listok']=1;
				}
				$res['admin']=$db2->select();
			break;
            case 'add':
				$res['column']=$db->where('bigclass=0 and if_in=0')->select();
				if($_POST){
					$data['c_title']=$_POST['c_title'];
					$data['c_keywords']=$_POST['c_keywords'];
					$data['c_description']=$_POST['c_description'];
					$data['c_content']=$_POST['c_content'];
					$data['e_title']=$_POST['e_title'];
					$data['e_keywords']=$_POST['e_keywords'];
					$data['e_description']=$_POST['e_description'];
					$data['e_content']=$_POST['e_content'];
					$data['class1']=$_POST['class1'];
					$data['class2']=intval($_POST['class2']);
					$data['class3']=intval($_POST['class3']);
					$data['imgurl']=$_POST['imgurl'];
					$data['imgurls']=$_POST['imgurls'];
					$data['img_ok']=intval($_POST['img_ok']);
					$data['issue']=$_POST['issue'];
					$data['hits']=$_POST['hits'];
					$data['addtime']=$_POST['addtime'];
					$data['updatetime']=$_POST['updatetime'];
					$data['new_ok']=intval($_POST['new_ok']);
					$data['com_ok']=intval($_POST['com_ok']);
					$data['adminurl']=$_POST['adminurl'];
					$data['filesize']=$_POST['filesize'];
					
					if($db2->add($data)){
						echo '<script type="text/javascript"> alert("操作成功"); location.href="index.php?m=Admin&c=admin&a=admin&class1='.$_POST['class1'].'"; </script>';
					}	
				}
				
				$res['info']=$db->where('id='.$_GET['class1'])->find();
				$res['column_list2']=$db->where('bigclass='.$_GET['class1'])->select();
				$res['column_list']=$db->where('module=4 and classtype=3')->select();
				if(!empty($res['column_list2'])){
					$res['class2_ok']=1;
				}
				$res['list_p']=M('parameter')->where('type=4 and use_ok=1')->select();
				$res['js']='<script type="text/javaScript">';
				$res['js'].='var onecount;';
				$res['js'].='subcat = new Array();';
				$i=0;
				foreach($res['column_list'] as $key=>$vallist){
					$res['js'].='subcat['.$i.'] = new Array("'.$vallist['c_name'].'","'.$vallist['bigclass'].'","'.$vallist['id'].'");';
					$i=$i+1;
				}
				$res['js'].='onecount='.$i.';';
				$res['js'].='</script>';

				// echo '<pre>';
				// print_r($res);
				// echo '</pre>';
				require_once(APP_PATH.'Admin/Org/fckeditor/fckeditor.php');
				$res['oFCKeditor'] = new \FCKeditor('c_content'); 
				$res['oFCKeditor']->BasePath = 'Admin/Org/fckeditor/';
				$res['oFCKeditor']->Value = $res['info']['c_content'];
				$res['oFCKeditor']->Width = '100%';   
				$res['oFCKeditor']->Height = '300';
				
				$res['e_oFCKeditor'] = new \FCKeditor('e_content'); 
				$res['e_oFCKeditor']->BasePath = 'Admin/Org/fckeditor/';
				$res['e_oFCKeditor']->Value = $res['info']['e_content'];
				$res['e_oFCKeditor']->Width = '100%';   
				$res['e_oFCKeditor']->Height = '300';
			break;
		}
		$this->assign('res',$res);
		$this->display('admin_'.$method);
	}
	
	public function basic(){
		$this->assign('res',$res);
		$this->display();
	}
	
	public function skin(){
		$db=M('skin');
		$res['skin']=$db->select();
		$this->assign('res',$res);
		$this->display();		
	}
	
	public function img(){
		$this->assign('res',$res);
		$this->display();
	}
	
	public function column(){
		$method = I('get.method') ? I('get.method') : 'show';
		$db=M('column');
		$db2=M('admin');
		switch ($method) {
			case 'show':
				$temp=$db->select();
				foreach($temp as $key=>$val){
					if($val['bigclass']==0){
						$res['column'][]=$val;
					}
					foreach($res['column'] as $k=>$v){
						if($v['id']==$val['bigclass']){
							$res['column'][$k]['sub'][]=$val;
						}
						foreach($res['column'][$k]['sub'] as $sub_k=>$sub_v){
							if($sub_v['id']==$val['bigclass']){
								$res['column'][$k]['sub'][$sub_k]['sub'][]=$val;
							}
						}
					}
				}
				// echo '<pre>';
				// print_r($res);exit;
			break;
		}
		$this->assign('res',$res);
		$this->display('column_'.$method);		
	}
	
	public function index_set(){
		require_once(APP_PATH.'Admin/Org/fckeditor/fckeditor.php');
		$res['oFCKeditor'] = new \FCKeditor('c_content'); 
		$res['oFCKeditor']->BasePath = 'Admin/Org/fckeditor/';
		$res['oFCKeditor']->Value = $res['info']['c_content'];
		$res['oFCKeditor']->Width = '100%';   
		$res['oFCKeditor']->Height = '300';
		
		$res['e_oFCKeditor'] = new \FCKeditor('e_content'); 
		$res['e_oFCKeditor']->BasePath = 'Admin/Org/fckeditor/';
		$res['e_oFCKeditor']->Value = $res['info']['e_content'];
		$res['e_oFCKeditor']->Width = '100%';   
		$res['e_oFCKeditor']->Height = '300';
		$this->assign('res',$res);
		$this->display();		
	}
	
	public function seo(){
		$this->assign('res',$res);
		$this->display();			
	}
	
	public function foot(){
		$this->assign('res',$res);
		$this->display();			
	}	
	
	public function flash(){
		$this->assign('res',$res);
		$this->display();			
	}
	
	public function label(){
		$this->assign('res',$res);
		$this->display();		
	}	
	
	public function online(){
		$method = I('get.method') ? I('get.method') : 'show';
		$db=M('column');
		$db2=M('admin');
		switch ($method) {
			case 'show':
			
			break;
		}
		$this->assign('res',$res);
		$this->display('online_'.$method);		
	}
	
	public function html(){
		$db=M('column');
		$temp_arr=$db->where('bigclass=0 and if_in=0')->select();
		foreach($temp_arr as $val){
			$res['module'.$val['module']][]=$val;
		}
		$this->assign('res',$res);
		$this->display();			
	}
	
	public function parameter(){
		$db=M('parameter');
		switch($_GET['type']){
			case "3";
				$res['p_title']='产品参数设置';
				$k=1;
			break;
			case "4";
				$res['p_title']='下载参数设置';
				$k=11;
			break;
			case "5";
				$res['p_title']='图片参数设置';
				$k=21;
			break;
		}
		$res['para']=$db->where('type='.$_GET['type'])->select();
		// print_r($res);
		$this->assign('res',$res);
		$this->display();		
	}
	
	public function database(){
		$method = I('get.method') ? I('get.method') : 'show';
		switch ($method) {
			case 'show':
				$temp_arr=M()->query('show tables');
				foreach($temp_arr as $val){
					$data=[];
					$data['name']=$val['Tables_in_enterprise'];
					$data['count']=M($data['name'])->count();
					$data['size']= M()->query('SHOW TABLE STATUS FROM enterprise LIKE \''.$data['name'].'\'')[0]['Data_length'];
					$data['size'] = round($data['size']/1024/1024, 2);
					$res['totalsize']+=$data['size'];
					$res['tables'][]=$data;
				}
			break;
		}
		$this->assign('res',$res);
		$this->display('database_'.$method);			
	}
}