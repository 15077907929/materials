<div class="header clearfix">
    <div class="logo fl">
		<a href="javascript:void(0)">
			<img src="{{asset('Admin/images/logo.png')}}" />
		</a>
	</div>
	<div class="wel fl">管理员：<b>{{session('user')['user_name']}}</b> 您好，感谢登陆使用！</div>
	<div class="bar fr">
		<a href="{{url('admin/index')}}"><img style="border:none" src="{{asset('Admin/images/index.gif')}}" /></a>
		<a href="javascript:logout();"><img style="border:none" src="{{asset('Admin/images/out.gif')}}" /></a>
		<script type="text/javascript">
			function logout() {
				if(window.confirm('您确定要退出吗？')) {
					top.location = "{{url('admin/logout')}}";
				}
			}       
		</script>
	</div>
</div>