<div id="templatemo_left_column">
	<div id="templatemo_header">
		<div id="site_title">
			<h1><a href="">我的 <strong>博客</strong><span>欢迎浏览</span></a></h1>
		</div>
	</div> 
	<div id="templatemo_sidebar">
		<div id="templatemo_rss">
			<a href="#">SUBSCRIBE NOW <br /><span>to our rss feed</span></a>
		</div>
		<h4>文章分类</h4>
		<ul class="templatemo_list">
			@foreach($cate_p as $key=>$val)
			<li><a href="{{url('cate/'.$val->id)}}">{{$val->name}}</a></li>
			@endforeach
			
		</ul>
		<div class="cleaner_h40"></div>
		<h4>友情链接</h4>
		<ul class="templatemo_list">
			@foreach($links as $key=>$val)
			<li><a href="{{url($val->url)}}">{{$val->name}}</a></li>
			@endforeach
		</ul>
	</div>
</div>