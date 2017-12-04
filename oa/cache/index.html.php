<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->ftpl_var['school_name'];?>--<?php echo $this->ftpl_var['sitetitle'];?></title>
<meta name="keywords" content="<?php echo $this->ftpl_var['keywords'];?>" />
<meta name="description" content="<?php echo $this->ftpl_var['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/<?php echo $this->ftpl_var['style'];?>/css/base.css" />
<link type="text/css" rel="stylesheet" href="templates/<?php echo $this->ftpl_var['style'];?>/css/style.css" />
<script type="text/javascript" src="templates/<?php echo $this->ftpl_var['style'];?>/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->ftpl_var['style'];?>/js/admin.js"></script>
</head>
<body>
<div class="header">
	<h2 class="logo"><img src="templates/<?php echo $this->ftpl_var['style'];?>/images/left_banner.gif" /></h2>
	<div class="header_sub clearfix">
		<div class="welcome fl"><?php echo $this->ftpl_var['school_name'];?>欢迎您</div>
		<div class="toolbar fr">
			<ul class="clearfix"><?php echo $this->ftpl_var['toolbar'];?></ul>
		</div>
	</div>
</div>
<div class="container clearfix">
	<div class="leftMenu fl">
		<div class="hd">
			<h4>我的菜单<span class="ico fr"></span></h4>
			<ul class="clearfix">
				<li><a href="">网路硬盘</a></li>
				<li><a href="">短信箱</a></li>
				<li><a href="">我的桌面</a></li>
			</ul>
		</div>
		<div class="bd">
			<ul>
				<li>我的办公桌<span class="ico fr"></span></li>
				<li>系统管理<span class="ico fr"></span></li>
			</ul>
		</div>
		<div class="sub">
			<ul class="clearfix">
				<li class="qj"><a href="">请 假</a></li>
				<li><a href="">收藏夹</a></li>
				<li><a href="">发表文章</a></li>
			</ul>
		</div>
	</div>
	<div class="main fr">
	
	</div>
</div>
<div class="footer clearfix">
	<div class="info fl">
		<span class="user">当前用户：<b><?php echo $this->ftpl_var['real_name'];?></b></span>
		<span class="department">部门：<b><?php echo $this->ftpl_var['managename'];?></b></span>
	</div>
	<div class="copyright fr">
		技术支持
	</div>
</div>
</body>
</html>