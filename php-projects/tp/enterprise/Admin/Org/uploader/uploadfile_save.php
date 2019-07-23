<?php  /**文件处理**/
$met_file_maxsize=100*1024*1024;
$file_size=$_FILES['imgurl']['size'];
if($file_size>$met_file_maxsize){
	echo '<script type="text/javascript"> alert("文件已超出网站限制的最大值"); history.go(-1); </script>';
	exit;
}

function upload($form, $met_file_format) {
	if (is_array($form)) {
		$filear = $form;
	} else {
		$filear = $_FILES[$form];
	}

	if (!is_writable('/opt/lampp/htdocs/enterprise.hd/Uploads/file/')) {
		echo '<script type="text/javascript"> alert("指定的路径不可写，或者没有此路径"); history.go(-1); </script>';
		exit;		
	}
	//取得扩展名
	$ext = explode(".", $filear["name"]);
	$ext = $ext[1];
	//设置保存文件名
	srand((double)microtime() * 1000000);
	$rnd = rand(100, 999);
	$name = date('U') + $rnd;
	$name = $name.'.'.$ext;

	if ($met_file_format != "" && !in_array(strtolower($ext), explode("|",strtolower($met_file_format)))) { 
		echo '<script type="text/javascript"> alert("文件格式不允许上传。"); history.go(-1); </script>';
		exit;			
	}

	if (!copy($filear['tmp_name'],'/opt/lampp/htdocs/enterprise.hd/Uploads/file/'.$name)) {
		$errors = array(0 => "文件上传成功",  1 =>"上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值。 ", 2 => "上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。 ", 3 => "文件只有部分被上传。 ", 4 => "没有文件被上传。 ");
		echo '<script type="text/javascript"> alert("'.$errors[$filear["error"]].'"); history.go(-1)"; </script>';
		exit;
	} else {
		@unlink($filear["tmp_name"]); //删除临时文件
	}
	return $name;
}

$met_file_format   = "rar|zip|txt|doc|pdf|jpg|xls|swf";
$downloadurl=upload('imgurl',$met_file_format);
if(!isset($_GET['returnid']))
	$returnid="downloadurl";  
	
echo '<script type="text/javascript">';
echo 'parent.document.myform.downloadurl.value=\''.$downloadurl.'\';';
echo 'parent.document.myform.filesize.value=\''.round($file_size/1024,2).'\';';
echo 'alert("上传成功,文件大小：';
echo round($file_size/1024,2);
echo 'K");';
echo 'location.href="upload_file.php"; </script>';	

/**end**/
?>