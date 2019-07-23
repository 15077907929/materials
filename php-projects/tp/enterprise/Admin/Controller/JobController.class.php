<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class JobController extends CommonController {	
	public function job(){
		$method = I('get.method') ? I('get.method') : 'show';
		$db=M('column');
		$db2=M('job');
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
				$res['job']=$db2->select();
			break;
            case 'add':
				if($_POST){
					$data['c_position']=$_POST['c_position'];
					$data['e_position']=$_POST['e_position'];
					$data['count']=$_POST['count'];
					$data['c_place']=$_POST['c_place'];
					$data['e_place']=$_POST['e_place'];
					$data['c_deal']=$_POST['c_deal'];
					$data['e_deal']=$_POST['e_deal'];
					$data['c_content']=$_POST['c_content'];
					$data['e_content']=$_POST['e_content'];
					$data['useful_life']=$_POST['useful_life'];
					$data['addtime']=$_POST['addtime'];					  
					if($db2->add($data)){
						echo '<script type="text/javascript"> alert("操作成功"); location.href="index.php?m=Admin&c=job&a=job&class1='.$_POST['class1'].'"; </script>';
					}	
				}
				$res['class1']=$_GET['class1'];
				$res['info']=$db->where('id='.$_GET['class1'])->find();
				$res['column_list2']=$db->where('bigclass='.$_GET['class1'])->select();
				$res['column_list']=$db->where('module=5 and classtype=3')->select();
				if(!empty($res['column_list2'])){
					$res['class2_ok']=1;
				}
				$res['list_p']=M('parameter')->where('type=5 and use_ok=1')->select();
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
		$this->display('job_'.$method);
	}
}