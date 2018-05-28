<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>左侧导航menu</title>
<link href="{{asset('Admin/css/left.css')}}" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{{asset('Admin/js/sdmenu.js')}}"></script>
<script type="text/javascript">
	var myMenu;
	window.onload = function() {
		myMenu = new SDMenu("my_menu");
		myMenu.init();
	};
</script>
</head>
<body>
<div id="left-top">
	<div><img src="{{asset('Admin/images/left/member.gif')}}" width="44" height="44" /></div>
    <span>用户：admin<br>角色：超级管理员</span>
</div>
    <div id="my_menu" class="sdmenu">
		<div class="collapsed">
			<span>基本设置</span>
			<a href="{{url('admin/config')}}" target="mainFrame">网站配置</a>
			<a href="{{url('admin/basic_set/password')}}" target="mainFrame">修改密码</a>
			<a href="{{url('admin/basic_set/category')}}" target="mainFrame">栏目管理</a>
		</div>
		<div>
			<span>文章管理</span>
			<a href="{{url('admin/article')}}" target="mainFrame">文章列表</a>
		</div>
		<div>
			<span>友情链接管理</span>
			<a href="{{url('admin/links')}}" target="mainFrame">友情链接列表</a>
		</div>		
		<div>
			<span>自定义导航</span>
			<a href="{{url('admin/navs')}}" target="mainFrame">导航列表</a>
		</div>
    </div>
	<script type="text/javascript">
		var len=document.getElementById("my_menu").getElementsByTagName("a").length;
		for(var i=0;i<len;i++){
			var obj=document.getElementById("my_menu").getElementsByTagName("a")[i];
			obj.onclick=function(){
				var len=document.getElementById("my_menu").getElementsByTagName("a").length;
				for(var i=0;i<len;i++){		
					document.getElementById("my_menu").getElementsByTagName("a")[i].className='';
				}				
				this.className="active";
			}
		}
	</script>
</body>
</html>