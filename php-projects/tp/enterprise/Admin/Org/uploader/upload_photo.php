<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="/Public/admin/css/metinfo_admin.css" />
<title>上传图片</title>
<script type="text/javascript" src="/Public/admin/js/zh_cn.js"></script>
<script type="text/javascript" src="/Public/admin/js/metinfo.js"></script>
</head>
<body>
<form enctype="multipart/form-data" method="POST" name="myform" onsubmit="return CheckFormupload();" action="upload_save.php?action=add" target="_self">
	<input name="imgurl" type="file" class="input" size="20" maxlength="200"> 
	<input type="submit" name="sub" value="上传" class="tj" />
	<input name="returnid" type="hidden" value="<? echo $_GET['returnid']; ?>" />
	<input name="create_samll" type="hidden" value="<? echo $_GET['create_samll']; ?>" />
	<input name="flash" type="hidden" value="<? echo $_GET['flash']; ?>" />
</form>
</body>
</html>