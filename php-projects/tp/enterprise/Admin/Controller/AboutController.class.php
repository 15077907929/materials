<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class AboutController extends CommonController {	
	public function about(){
		$method = I('get.method') ? I('get.method') : 'show';
		$db=M('column');
		switch ($method) {
            case 'show':
				$res['info']=$db->where('id='.$_GET['id'])->find();
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
			case 'modify':
				$data['c_keywords']=$_POST['c_keywords'];
				$data['c_description']=$_POST['c_description'];
				$data['c_content']=$_POST['c_content'];
				$data['e_keywords']=$_POST['e_keywords'];
				$data['e_description']=$_POST['e_description'];
				$data['e_content']=$_POST['e_content'];
				if($db->where('id='.$_POST['id'])->save($data)){
					echo '<script type="text/javascript"> alert("操作成功"); location.href="index.php?m=Admin&c=About&a=about&id='.$_POST['id'].'"; </script>';
				}
			break;
		}
		$this->assign('res',$res);
		$this->display();
	}
}