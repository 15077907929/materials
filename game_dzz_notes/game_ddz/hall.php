<?php
    include('dbconnect.php');
?>
<!doctype html>
<html>
<head>
<meta http-equiv='content-type' content='text/html;charset=utf-8'/>
<meta name="keyword" content="ddz" />
<meta name="description" content="ddz" />
<link type="text/css" rel="stylesheet" href="css/style.css" />
<link type="text/css" rel="stylesheet" href="css/base.css" />
<script type="text/javascript" src="js/server.js"></script>
<title>开心斗地主——大厅</title>
</head>
<body class="hall_body">
<div class="hall_header clearfix">
	<div class="location fl">
	    现在位置:斗地主onWeb
	</div>
	<div class="quit fr">
	    <a href="logout.php">注销</a>
	</div>
</div>
<div class="hall_bd wrap">
    <div id="rooms" class="rooms">
		<div class="loading">loading...</div>
    </div>
	<script type="text/javascript">
		get_rooms();
		setInterval("get_rooms()",5000);
	</script>
</div>
</body>
</html>
