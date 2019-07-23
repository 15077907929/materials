<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class ProductController extends CommonController {	
	public function product(){
		$method = I('get.method') ? I('get.method') : 'show';
		$db=M('column');
		$db2=M('product');
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
				$res['product']=$db2->select();
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
					$data['new_ok']=$_POST['new_ok'];
					$data['com_ok']=$_POST['com_ok'];
					$data['c_para1']=$_POST['c_para1'];
					$data['c_para2']=$_POST['c_para2'];
					$data['c_para3']=$_POST['c_para3'];
					$data['c_para4']=$_POST['c_para4'];
					$data['c_para5']=$_POST['c_para5'];
					$data['c_para6']=$_POST['c_para6'];
					$data['c_para7']=$_POST['c_para7'];
					$data['c_para8']=$_POST['c_para8'];
					$data['c_para9']=$_POST['c_para9'];
					$data['c_para10']=$_POST['c_para10'];
					$data['e_para1']=$_POST['e_para1'];
					$data['e_para2']=$_POST['e_para2'];
					$data['e_para3']=$_POST['e_para3'];
					$data['e_para4']=$_POST['e_para4'];
					$data['e_para5']=$_POST['e_para5'];
					$data['e_para6']=$_POST['e_para6'];
					$data['e_para7']=$_POST['e_para7'];
					$data['e_para8']=$_POST['e_para8'];
					$data['e_para9']=$_POST['e_para9'];
					$data['e_para10']=$_POST['e_para10'];
					if($db2->add($data)){
						echo '<script type="text/javascript"> alert("操作成功"); location.href="index.php?m=Admin&c=Product&a=product&class1='.$_POST['class1'].'"; </script>';
					}					
				}
				$res['info']=$db->where('id='.$_GET['class1'])->find();
				$res['column_list2']=$db->where('bigclass='.$_GET['class1'])->select();
				$res['column_list']=$db->where('module=3 and classtype=3')->select();
				if(!empty($res['column_list2'])){
					$res['class2_ok']=1;
				}
				$res['list_p']=M('parameter')->where('type=3 and use_ok=1')->select();
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
		$this->display('product_'.$method);
	}
}