<?php  /**图片处理**/
	error_reporting(0);
    require_once 'upfile.class.php';
    require_once 'watermark.class.php';
	$file_size=$_FILES['imgurl']['size'];
	$met_img_maxsize   = "2100000000";
	if($file_size>$met_img_maxsize){
		echo '<script type="text/javascript"> alert("文件已超出网站限制的最大值"); history.go(-1)"; </script>';
		exit;
	}
	$met_img_type      = "gif,jpg,png,jpeg,bmp";
    $f = new upfile($met_img_type,'',$met_img_maxsize,'');
    $img = new Watermark();
	//上传详细大图
    if($_FILES['imgurl']['name']!=''&&$_REQUEST['returnid']=="big"){
        $imgurl   = $f->upload('imgurl');
        $met_big_img = $imgurl; 
		$met_big_wate      = "1";
        if($met_big_wate==1){
			$met_wate_class=3;
            if($met_wate_class==2){
                // $img->met_image_name = $met_wate_img;//水印图片
                // $img->met_image_pos  = $met_watermark;
            }else {
                // $img->met_text       = $met_text_wate;
                // $img->met_text_size  = $met_text_size;
                // $img->met_text_color = $met_text_color;
                // $img->met_text_angle = $met_text_angle;
                // $img->met_text_pos   = $met_watermark;
                // $img->met_text_font  = $met_text_fonts;
            }

            $img->src_image_name=$imgurl;
            $img->save_file = $f->waterpath.$f->savename;
            $img->create();
			$imgurl =$f->savepath.'watermark/'.$f->savename;
        }
   
        //缩图
		if($_REQUEST['create_samll']==1 && $_FILES['imgurl']['name']!='' ){
            // file_unlink($imgurls);
			$met_img_x         = 200;
			$met_img_y         = 200;
            $imgurls = $f->createthumb($met_big_img,$met_img_x,$met_img_y);
			$met_thumb_wate    = "1";
            if($met_thumb_wate==1){
				$met_wate_class    = "1";
                if($met_wate_class==2){
                    $img->met_image_name = $met_wate_img;//水印图片
                    $img->met_image_pos = $met_watermark;
                }else {
                    // $img->met_text = $met_text_wate;
                    // $img->met_text_size = $met_text_size;
                    // $img->met_text_color = $met_text_color;
                    // $img->met_text_angle = $met_text_angle;
                    // $img->met_text_pos   = $met_watermark;
                    // $img->met_text_font = $met_text_fonts;
                }
                $img->save_file =$imgurls;
                // $img->create($imgurls);
            }
        }
		echo '<script type="text/javascript">';
		echo 'parent.document.myform.imgurl.value="'.date('Ym').'/watermark/'.$f->savename.'";';
		echo 'parent.document.myform.imgurls.value="'.date('Ym').'/thumb/'.$f->savename.'";';
		echo 'alert("上传成功,图片大小：';
		echo round($file_size/1024,2);
		echo 'K");';
		echo 'location.href="upload_photo.php?returnid=';
		echo $_REQUEST['returnid'];
		echo '&create_samll=';
		echo $_REQUEST['create_samll'];
		echo '"; </script>';		
	} 
	//上传缩略图		
	if($_FILES['imgurl']['name']!=''&&$_REQUEST['returnid']=="small") {  
		$f->savepath = $f->savepath.'/thumb/';
		$imgurls = $f->upload('imgurl');
		echo '<script type="text/javascript">';
		echo 'parent.document.myform.imgurls.value="'.date('Ym').'/thumb/'.$f->savename.'";';
		echo 'alert("上传成功,图片大小：';
		echo round($file_size/1024,2);
		echo 'K");';
		echo 'location.href="upload_photo.php?returnid=';
		echo $_REQUEST['returnid'];
		echo '&create_samll=';
		echo $_REQUEST['create_samll'];
		echo '"; </script>';
	}

//上传LOGO图		
if($_FILES['imgurl']['name']!=''&&$_REQUEST['returnid']=="logo") { 
            $f->savepath = $f->savepath;
            $imgurls = $f->upload('imgurl');
echo "<SCRIPT language=javascript>\n";
echo "parent.document.myform.met_logo.value='".$imgurls."';\n";
echo "alert('上传成功,图片大小：";
echo round($file_size/1024,2);
echo "K');";
echo "location.href='upload_photo.php?returnid=";
echo $returnid;
echo "&create_samll=";
echo $create_samll;
echo "'; </script>";	
}


//上传Flash图		
if($_FILES['imgurl']['name']!=''&&$_REQUEST['flash']=="flash") { 
	$f->savepath = $f->savepath;
	$imgurls = $f->upload('imgurl');
	echo "<SCRIPT language=javascript>\n";
	echo "parent.document.myform.".$returnid.".value='".$imgurls."';\n";
	echo "alert('上传成功,图片大小：";
	echo round($file_size/1024,2);
	echo "K');";
	echo "location.href='upload_photo.php?returnid=";
	echo $returnid;
	echo "&flash=";
	echo $flash;
	echo "'; </script>";	
}
    /**end**/
	
	// 删除文件的函数
	function file_unlink($file_name) {
		$area_lord=false;
		if(file_exists($file_name)) {
			@chmod($file_name,0777);
			$area_lord = @unlink($file_name);
		}
		return $area_lord;
	}
?>