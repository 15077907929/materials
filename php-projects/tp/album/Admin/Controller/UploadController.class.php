<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
use Admin\Model\UploadModel;
class UploadController extends CommonController {
    public function upload_step1(){
		$res['current_nav']='upload';
		$db=M('albums');
		$db2=M('imgs');
		$res['album']=$_GET['album_id'];
		$res['albums']=$db->select();
	
		$this->assign('res',$res);
		$this->display();
	}     
	
	public function upload_step2(){
		$res['current_nav']='upload';
		$db=M('albums');
		$db2=M('imgs');
		$res['album_id']=$_GET['album_id'];
	
		$this->assign('res',$res);
		$this->display();
	} 

	public function upload_step2_normal(){
		$res['current_nav']='upload';
		$db=M('albums');
		$db2=M('imgs');
		$res['album_id']=$_GET['album_id'];
	
		$this->assign('res',$res);
		$this->display();		
	}
	
	public function dopicupload(){
		$db=M('albums');
		$db2=M('imgs');
		$open_watermark = true;
        $watermark_path = 'Public/images/logo.png';
        $watermark_pos = 1;
        set_time_limit(0);
		
        $date = get_updir_name(C('imgdir_type'));
        if(!is_dir(APP_PATH.'Uploads/'.$date)){
            mkdir(APP_PATH.'Uploads/'.$date);
            chmod(APP_PATH.'Uploads/'.$date,0777);
        }

        $album_id=$_GET['album'];
        $album_arr = $db->where('id='.$album_id)->find();
		
        if($album_arr){
            $photo_private = $album_arr['private'];
        }else{
            $photo_private = 1;
        }

        if(C('demand_resize')){
            $pic_status = 1;
        }else{
            $pic_status = 3;
        }
        
        $empty_num = 0;
		
        foreach($_FILES['imgs']['name'] as $k=>$upfile){
            $tmpfile = $_FILES['imgs']['tmp_name'][$k];

            if (!empty($upfile)) {
                $filename = $upfile;
                $fileext = strtolower(end(explode('.',$filename)));
                if(!in_array($fileext,explode(',',C('allow_img_type')))){
                    showInfo('不支持的图片格式！',false);
                    exit;
                }
                if($_FILES['imgs']['size'][$k] > C('size_allow')){
                    showInfo('上传图片过大！不得大于'.C('size_allow').'字节！',false);
                    exit;
                }
                $key = md5(str_replace('.','',microtime(true)).mt_rand(10,99));
                $realpath = APP_PATH.'Uploads/'.mkImgLink($date,$key,$fileext,'orig');
                if(move_uploaded_file($tmpfile,$realpath)){
                    addwater($realpath);
                    @chmod($realpath,0777);
                    $db2->add(array('album'=>$album_id,
							'name'=>$filename,
							'dir'=>$date,
							'pickey'=>$key,
							'ext'=>$fileext,
							'author'=>cookie('user')['id'],
							'create_time'=>time(),
							'private' => $photo_private,
							'status' => $pic_status
						));
                }else{
                    showInfo('文件上传失败！',false);
                    exit;
                }
            }else{
                $empty_num++;
            }
        }
        if($empty_num == count($_FILES['imgs']['name'])){
            showInfo('您没有选择图片上传，请重新上传！',false);
            exit;
        }
		redirect('index.php?m=Admin&c=Upload&a=upload_step3&album='.$album_id);
	}
	
	public function upload_step3(){
		$res['current_nav']='upload';
		$db=M('albums');
		$db2=M('imgs');
		$res['album']=$_GET['album'];	
		$this->assign('res',$res);
		$this->display();
	} 
	
	public function reupload(){
		$db = M('imgs');
    
        $find = $db->where('id='.$_GET['id'])->find();
        if(!$find){
            echo '<script type="text/javascript"> top.reupload_alert("此照片不存在或已被删除!");</script>';
            exit;
        }
        if(empty($_FILES['imgs']['name'])){
            echo '<script type="text/javascript"> top.reupload_alert("请先选择要上传的图片!");</script>';
            exit;
        }
        
        $filename = $_FILES['imgs']['name'];
        $tmpfile = $_FILES['imgs']['tmp_name'];
        $fileext = strtolower(end(explode('.',$filename)));
        $oldext = $find['ext'];
        if($fileext != $oldext){
            echo '<script type="text/javascript"> top.reupload_alert("上传的文件的格式必须跟原图片一致!");</script>';
            exit;
        }
        if($_FILES['imgs']['size'] > C('size_allow')){
            echo '<script type="text/javascript"> top.reupload_alert("上传图片过大！不得大于'.C('size_allow').'字节！");</script>';
            exit;
        }
        $realpath = APP_PATH.'Uploads/'.mkImgLink($find['dir'],$find['pickey'],$find['ext'],'orig');
        
        delpicfile($find['dir'],$find['pickey'],$find['ext']);
        if(@move_uploaded_file($tmpfile,$realpath)){
            addwater($realpath);
            if(!C('demand_resize')){
                generatepic($find['dir'],$find['pickey'],$find['ext']);
            }
            @chmod($realpath,0755);
            echo '<script type="text/javascript"> top.reupload_ok("'.$_GET['id'].'","Uploads/'.mkImgLink($find['dir'],$find['pickey'],$find['ext'],'orig').'","Uploads/'.mkImgLink($find['dir'],$find['pickey'],$find['ext'],'thumb').'");</script>';
        }else{
            echo '<script type="text/javascript"> top.reupload_alert("文件上传失败!");</script>';
        }
	}
	
	public function process(){
		UploadModel::plupload();
	}
	
	function doupload(){
        set_time_limit(0);
        $this->_save_and_resize();
		$res['current_nav']='upload';
		$res['album']=$_GET['album'];	
		$this->assign('res',$res);
        $this->display('upload_step3');
    }
	
	function _save_and_resize(){
		$db=M('albums');
		$db2=M('imgs');
        $tmp_dir = where_is_tmp();
        $targetDir =  $tmp_dir. DIRECTORY_SEPARATOR . "plupload";
        
        $album_id = intval($_GET['album']);
		$album_arr = $db->where('id='.$album_id)->find();
        if($album_arr){
            $photo_private = $album_arr['private'];
        }else{
            $photo_private = 1;
        }
        
        $date = get_updir_name(C('imgdir_type'));
		if(!is_dir(APP_PATH.'Uploads/'.$date)){
            mkdir(APP_PATH.'Uploads/'.$date);
            chmod(APP_PATH.'Uploads/'.$date,0777);
        }

        if(C('demand_resize')){
            $pic_status = 1;
        }else{
            $pic_status = 3;
        }

        $files_count = intval($_POST['flash_uploader_count']);
        for($i=0;$i<$files_count;$i++){
            $tmpfile = $targetDir . DIRECTORY_SEPARATOR . $_POST["flash_uploader_{$i}_tmpname"];
            $filename = $_POST["flash_uploader_{$i}_name"];
            $status =  $_POST["flash_uploader_{$i}_status"];
            $fileext = strtolower(end(explode('.',$filename)));
            $key = md5(str_replace('.','',microtime(true)).mt_rand(10,99));
            $realpath = APP_PATH.'Uploads/'.mkImgLink($date,$key,$fileext,'orig');
            if($status == 'done' && file_exists($tmpfile)){
                if(@copy($tmpfile,$realpath)){
                    addwater($realpath);
                    @chmod($realpath,0755);
					 $db2->add(array('album'=>$album_id,
						'name'=>$filename,
						'dir'=>$date,
						'pickey'=>$key,
						'ext'=>$fileext,
						'author'=>cookie('user')['id'],
						'create_time'=>time(),
						'private' => $photo_private,
						'status' => $pic_status
					));
                }
            }
        }
    }
}