<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>{{$art->title}} - {{$art->cate_name}} - {{$field->name}} - Medicine</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="{{asset('Home/css/base.css')}}" rel="stylesheet" />
<link href="{{asset('Home/css/new.css')}}" rel="stylesheet" />
</head>
<body>

@include('Home/Common/header')

<article class="blogs">
	<h1 class="t_nav">
		<span>您当前的位置：
			<a href="{{url('/')}}">首页</a>&nbsp;&gt;&nbsp;
			<a href="{{url('articles/'.$field->id)}}">{{$field->name}}</a>&nbsp;&gt;&nbsp;
			<a href="{{url('articles/'.$art->cate_id)}}">{{$art->cate_name}}</a>
		</span>
		<a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('articles/'.$field->id)}}" class="n2">{{$field->name}}</a>
	</h1>
	<div class="index_about">
		<h2 class="c_titile">{{$art->title}}</h2>
		<p class="box_c">
			<span class="d_time">发布时间：{{$art->addtime}}</span>
			<span>编辑：{{$art->editor}}</span>
			<span>互动QQ群：<a href="javascript:void(0);">280998807</a></span>
		</p>
		<ul class="infos">
			{!!$art->description!!}<br/><br/>
			{!!$art->content!!}
		</ul>
		<div class="keybq">
			<p><span>关键字词</span>：爱情,犯错,原谅,分手</p>
		</div>
		<div class="ad"> </div>
		<div class="nextinfo">
			<p>上一篇：<a href="/news/s/2013-09-04/606.html">程序员应该如何高效的工作学习</a></p>
			<p>下一篇：<a href="/news/s/2013-10-21/616.html">柴米油盐的生活才是真实</a></p>
		</div>
		<div class="otherlink">
			<h2>相关文章</h2>
			<ul>
				<li><a href="/news/s/2013-07-25/524.html" title="现在，我相信爱情！">现在，我相信爱情！</a></li>
				<li><a href="/newstalk/mood/2013-07-24/518.html" title="我希望我的爱情是这样的">我希望我的爱情是这样的</a></li>
				<li><a href="/newstalk/mood/2013-07-02/335.html" title="有种情谊，不是爱情，也算不得友情">有种情谊，不是爱情，也算不得友情</a></li>
				<li><a href="/newstalk/mood/2013-07-01/329.html" title="世上最美好的爱情">世上最美好的爱情</a></li>
				<li><a href="/news/read/2013-06-11/213.html" title="爱情没有永远，地老天荒也走不完">爱情没有永远，地老天荒也走不完</a></li>
				<li><a href="/news/s/2013-06-06/24.html" title="爱情的背叛者">爱情的背叛者</a></li>
			</ul>
		</div>
	</div>
	<aside class="right">
		<div class="blank"></div>
		<div class="news">
			<h3><p>栏目<span>最新</span></p></h3>
			<ul class="rank">
				<li><a href="/" title="Column 三栏布局 个人网站模板" target="_blank">Column 三栏布局 个人网站模板</a></li>
				<li><a href="/" title="with love for you 个人网站模板" target="_blank">with love for you 个人网站模板</a></li>
				<li><a href="/" title="免费收录网站搜索引擎登录口大全" target="_blank">免费收录网站搜索引擎登录口大全</a></li>
				<li><a href="/" title="做网站到底需要什么?" target="_blank">做网站到底需要什么?</a></li>
				<li><a href="/" title="企业做网站具体流程步骤" target="_blank">企业做网站具体流程步骤</a></li>
				<li><a href="/" title="建站流程篇——教你如何快速学会做网站" target="_blank">建站流程篇——教你如何快速学会做网站</a></li>
				<li><a href="/" title="box-shadow 阴影右下脚折边效果" target="_blank">box-shadow 阴影右下脚折边效果</a></li>
				<li><a href="/" title="打雷时室内、户外应该需要注意什么" target="_blank">打雷时室内、户外应该需要注意什么</a></li>
			</ul>
			<h3 class="ph"><p>点击<span>排行</span></p></h3>
			<ul class="paih">
				<li><a href="/" title="Column 三栏布局 个人网站模板" target="_blank">Column 三栏布局 个人网站模板</a></li>
				<li><a href="/" title="withlove for you 个人网站模板" target="_blank">with love for you 个人网站模板</a></li>
				<li><a href="/" title="免费收录网站搜索引擎登录口大全" target="_blank">免费收录网站搜索引擎登录口大全</a></li>
				<li><a href="/" title="做网站到底需要什么?" target="_blank">做网站到底需要什么?</a></li>
				<li><a href="/" title="企业做网站具体流程步骤" target="_blank">企业做网站具体流程步骤</a></li>
			</ul>
		</div>
		<div class="visitors">
			<h3><p>最近访客</p></h3>
			<ul></ul>
		</div>
	</aside>
</article>

@include('Home/Common/footer')

</body>
</html>