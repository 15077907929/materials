<header>
	<div id="logo"><a href="/"></a></div>
	<nav class="topnav" id="topnav">
		<a class="@if($cur_nav=='index') current @endif" href="{{url('/')}}"><span>首页</span><span class="en">Protal</span></a>
		<a href="about.html"><span>关于我</span><span class="en">About</span></a>
		<a href="newlist.html"><span>慢生活</span><span class="en">Life</span></a>
		<a href="moodlist.html"><span>碎言碎语</span><span class="en">Doing</span></a>
		<a href="share.html"><span>模板分享</span><span class="en">Share</span></a>
		<a class="@if($cur_nav=='article') current @endif" href="{{url('/articles/1')}}"><span>学无止境</span><span class="en">Learn</span></a>
		<a href="book.html"><span>留言版</span><span class="en">Gustbook</span></a>
	</nav>
</header>