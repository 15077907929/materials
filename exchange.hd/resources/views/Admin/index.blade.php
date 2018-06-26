<!doctype html>
<html>
<head>
<title>exchange - 后台管理中心</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="stylesheet" type="text/css" href="{{asset('Admin/css/base.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('Admin/css/style.css')}}" />
<script type="text/javascript" src="{{asset('Admin/js/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('Admin/js/base.js')}}"></script>
</head>
<body>

@include('Admin.Common.header')

<div class="container clearfix">
	
	@include('Admin.Common.left')
	
	<div class="content">
		<div class="breadcrumbs clearfix">
			<span class="fl"></span>
			<h4 class="fl">欢迎界面</h4>
			<span class="fr rbg"></span>
		</div>
		<div class="main index">
			<div class="bdtop clearfix">
				<div class="aArea fl">
					<h3>感谢您使用 RainMan 瑞曼 网站管理系统程序</h3>
					<img src="{{asset('Admin/images/ts.gif')}}" width="16" height="16" /> 提示：<br />
					<p>您现在使用的是 瑞曼网络工作室 开发的一套用于构建企业型网站的专业系统！如果您有任何疑问请点在线客服进行咨询！</p>
					<p>此程序是您建立地区级商家信息门户的首选方案！</p>
				</div>  
				<div class="bArea fr">
					<h4>最新动态</h4>
					<ul>
						<li>瑞曼网站管理系统！</li>
						<li>专业管理企业网站！</li>
						<li>瑞曼网站管理系统！</li>
						<li>专业管理企业网站！</li>
						<li>瑞曼网站管理系统！</li>
					</ul>				
				</div>
			</div>
			<div class="bdbot clearfix">
				<div class="bArea fl">
					<h4>最新动态</h4>
				</div>				
				<div class="bArea fr">
					<h4>最新动态</h4>
				</div>
			</div>
		</div>

		@include('Admin.Common.footer')	
		
	</div>
</div>
</body>
</html>