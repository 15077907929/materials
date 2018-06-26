<aside class="left">
	<ul>
		<li>
			<a onclick="switchMenu($(this).next())">文章管理<img src="{{asset('Admin/images/menu_dropdown-arrow.png')}}" /></a>
			<dl>
				<dt class="@if($cur_nav=='art_list') on @endif"><a href="{{url('admin/article')}}">文章列表</a></dt>
				<dt class="@if($cur_nav=='art_create') on @endif"><a href="{{url('admin/article/create')}}">添加文章</a></dt>
			</dl>
		</li>
		<li>
			<a onclick="switchMenu($(this).next())">图片管理<img src="{{asset('Admin/images/menu_dropdown-arrow.png')}}" /></a>
			<dl>
				<dt href=""><a>图片管理</a></dt>
			</dl>
		</li>
		<li>
			<a onclick="switchMenu($(this).next())">产品管理<img src="{{asset('Admin/images/menu_dropdown-arrow.png')}}" /></a>
			<dl>
				<dt><a href="">品牌管理</a></dt>
				<dt><a href="">分类管理</a></dt>
				<dt><a href="">产品管理</a></dt>
			</dl>
		</li>
		<li>
			<a onclick="switchMenu($(this).next())">评论管理<img src="{{asset('Admin/images/menu_dropdown-arrow.png')}}" /></a>
			<dl>
				<dt><a href="">评论列表</a></dt>
				<dt><a href="">意见反馈</a></dt>
			</dl>
		</li>
		<li>
			<a onclick="switchMenu($(this).next())">会员管理<img src="{{asset('Admin/images/menu_dropdown-arrow.png')}}" /></a>
			<dl>
				<dt><a href="">会员列表</a></dt>
				<dt><a href="">删除的会员</a></dt>
				<dt><a href="">等级管理</a></dt>
				<dt><a href="">积分管理</a></dt>
				<dt><a href="">浏览记录</a></dt>
				<dt><a href="">下载记录</a></dt>
				<dt><a href="">分享记录</a></dt>
			</dl>
		</li>
		<li>
			<a onclick="switchMenu($(this).next())">管理员管理<img src="{{asset('Admin/images/menu_dropdown-arrow.png')}}" /></a>
			<dl>
				<dt><a href="">角色管理</a></dt>
				<dt><a href="">权限管理</a></dt>
				<dt><a href="">管理员列表</a></dt>
			</dl>
		</li>
		<li>
			<a onclick="switchMenu($(this).next())">系统统计<img src="{{asset('Admin/images/menu_dropdown-arrow.png')}}" /></a>
			<dl>
				<dt><a href="">折线图</a></dt>
				<dt><a href="">时间轴折线图</a></dt>
				<dt><a href="">区域图</a></dt>
				<dt><a href="">柱状图</a></dt>
				<dt><a href="">饼状图</a></dt>
				<dt><a href="">3D柱状图</a></dt>
				<dt><a href="">3D饼状图</a></dt>
			</dl>
		</li>
		<li>
			<a onclick="switchMenu($(this).next())">系统管理<img src="{{asset('Admin/images/menu_dropdown-arrow.png')}}" /></a>
			<dl>
				<dt><a href="">系统设置</a></dt>
				<dt class="@if($cur_nav=='cate') on @endif"><a href="{{url('admin/category')}}">文章分类</a></dt>
				<dt><a href="">数据字典</a></dt>
				<dt><a href="">屏蔽词</a></dt>
				<dt><a href="">系统日志</a></dt>
			</dl>
		</li>
	</ul>
</aside>
<script type="text/javascript" src="{{asset('Common/js/jquery.cookie.js')}}"></script>
<script type="text/javascript">
	function switchMenu(obj){
		//初始化效果
		$('.left dl').slideUp();
		$('.left dl').prev().removeClass('selected');
		$('.left dl dt').removeClass('on');
		//切换
		if(obj.css('display')=='none'){
			obj.slideDown();
			obj.prev().addClass('selected');
			//设置cookie
			var len=$('.left li').length;
			for(var i=0;i<len;i++){
				if($('.left li:eq('+i+') dl').prev().attr('class')=='selected'){
					$.cookie('selected', i,{ path: '/' });
					// alert($.cookie('selected'));
				}
			}
		}else{
			obj.slideUp();
			$('.left dl').prev().removeClass('selected');
			$.cookie('selected',null);
		}
	}
	$('.left li:eq('+$.cookie('selected')+') dl').css('display','block');	//读取cookie
	$('.left li:eq('+$.cookie('selected')+') dl').prev().addClass('selected');
</script>