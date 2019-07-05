<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
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
}