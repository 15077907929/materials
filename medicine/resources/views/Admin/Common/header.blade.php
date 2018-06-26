<header> 
	<div class="logo fl"><a href="{{url('admin/index')}}">Medicine</a></div>
	<div class="userbar fr">
		超级管理员
		<span>
			{{session('user')['user_name']}} <img src="{{asset('Admin/images/more_unfold.png')}}" />
			<ul class="hide">
				<li><a target="_blank" href="{{url('/')}}">网站首页</a></li>
				<li><a href="{{url('admin/index')}}">系统首页</a></li>
				<li><a href="">个人信息</a></li>
				<li><a href="">切换账户</a></li>
				<li><a href="{{url('admin/logout')}}">退出</a></li>
			</ul>
		</span> 
		<span>
			信息
		</span>
	</div>
</header>
<script type="text/javascript">
	$('.userbar span').hover(function(){
		$(this).find('ul').removeClass('hide');
	},function(){
		$(this).find('ul').addClass('hide');
	});
</script>