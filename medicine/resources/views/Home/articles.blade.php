<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>@if($field->sub_name!='') {{$field->sub_name}} - @endif {{$field->name}} - Medicine</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="{{asset('Home/css/base.css')}}" rel="stylesheet" />
<link href="{{asset('Home/css/style.css')}}" rel="stylesheet" />
</head>
<body>

@include('Home/Common/header')

<article class="blogs">
	<h1 class="t_nav">
		<span>“慢生活”不是懒惰，放慢速度不是拖延时间，而是让我们在生活中寻找到平衡。</span>
		<a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('articles/'.$field->id)}}" class="n2">{{$field->name}}</a>
	</h1>
	<div class="newblog left">
		@foreach($arts as $val)
		<h2>{{$val['title']}}</h2>
		<p class="dateview">
			<span>发布时间：{{$val['addtime']}}</span>
			<span>作者：{{$val['editor']}}</span>
			<span>分类：[<a href="{{url('articles/'.$val['cate_id'])}}">{{$val['cate_name']}}</a>]</span>
		</p>
		<figure><img src="{{asset('Home/images/001.png')}}"></figure>
		<ul class="nlist">
			<p>{{str_limit($val['description'],250,'...')}}</p>
			<a href="{{url('article/'.$val['id'])}}" target="_blank" class="readmore">阅读全文>></a>
		</ul>
		<div class="line"></div>
		@endforeach
		<div class="blank"></div>
		<div class="ad">  <img src="{{asset('Home/images/ad.png')}}" /></div>
		<div class="page">
			<a title="Total record"><b>41</b></a><b>1</b>
			<a href="/news/s/index_2.html">2</a>
			<a href="/news/s/index_2.html">&gt;</a>
			<a href="/news/s/index_2.html">&gt;&gt;</a>
		</div>
	</div>
	<aside class="right">
	   <div class="rnav">
			<ul>
				@foreach($cate as $key=>$val)
				<li class="rnav{{$key+1}}"><a href="{{url('articles/'.$val->id)}}">{{$val->name}}</a></li>
				@endforeach
			</ul>      
		</div>
	<div class="news">
		<h3><p>最新<span>文章</span></p></h3>
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
		<h3 class="ph">
		  <p>点击<span>排行</span></p>
		</h3>
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
		  <ul>

		  </ul>
		</div> 
	</aside>
</article>

@include('Home/Common/footer')

</body>
</html>