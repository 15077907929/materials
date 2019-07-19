<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class ArticleController extends CommonController {	
	public function article(){
		$method = I('get.method') ? I('get.method') : 'show';
		$db=M('column');
		$db2=M('news');
		switch ($method) {
			case 'show':
				$res['info']=$db->where('id='.$_GET['class1'])->find();
				$res['class2_list']=$db->where('bigclass='.$_GET['class1'])->select();
				if(!empty($res['class2_list'])){
					$res['class2_listok']=1;
				}
				$res['news']=$db2->select();
			break;
            case 'add':
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
					if($db2->add($data)){
						echo '<script type="text/javascript"> alert("操作成功"); location.href="index.php?m=Admin&c=Article&a=article&class1='.$_POST['class1'].'"; </script>';
					}					
				}
				$res['info']=$db->where('id='.$_GET['class1'])->find();
				$res['column_list2']=$db->where('bigclass='.$_GET['class1'])->select();
				$res['column_list']=$db->where('module=2 and classtype=3')->select();
				if(!empty($res['column_list2'])){
					$res['class2_ok']=1;
				}
				
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
		$this->display('article_'.$method);
	}
}