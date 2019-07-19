<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class AssetController extends CommonController {
    public function webuploader(){
		$method = I('get.method') ? I('get.method') : 'show';
		$db=M('borrow');
		switch ($method) {
            case 'show':
			
			break;
			case 'ajax_upload':
				$date = date('Ym');
				if(!is_dir(APP_PATH.'Uploads/'.$date)){
					mkdir(APP_PATH.'Uploads/'.$date);
					chmod(APP_PATH.'Uploads/'.$date,0777);
				}
				$fileext = strtolower(end(explode('.',$_FILES['file']['name'])));
				$key = md5(str_replace('.','',microtime(true)).mt_rand(10,99));
				$tmpfile = $_FILES['file']['tmp_name'];
				$realpath = APP_PATH.'Uploads/'.$date.'/'.$key.'.'.$fileext;
				if(move_uploaded_file($tmpfile,$realpath)){
					$res['code']=1;
					$res['msg']='上传成功!';
					$res['data']=[
							'filepath'=>'Uploads/'.$date.'/'.$key.'.'.$fileext,
							'name'=>$_FILES['file']['name'],
							'id'=>'WU_FILE_0',
							'preview_url'=>'Uploads/'.$date.'/'.$key.'.'.$fileext,
							'url'=>'Uploads/'.$date.'/'.$key.'.'.$fileext,
						];
					$res['url']='';
					$res['wait']=3;
				}
				echo json_encode($res);
				exit;
			break;
		}
		$this->assign('res',$res);
		$this->display();
	}    
}