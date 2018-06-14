<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{$field->title}} - blog</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="{{asset('Home/css/templatemo_style.css')}}" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="templatemo_wrapper">

	@include('Home/Common/header')
	
	@include('Home/Common/left')
	
    <div id="templatemo_right_column">
		<div id="templatemo_main">
			<h2>{{$field->title}}</h2>
            <div align="justify">{{$field->description}}</div>
            <div class="cleaner_h30"></div>
            <div class="service_box">{!!$field->content!!}</div>
    	</div>
		<div class="cleaner"></div>
		<div class="updown">
			<p>上一篇：
				@if($article['pre'])
					<a href="{{url('art/'.$article['pre']->id)}}">{{$article['pre']->title}}</a>
				@else
					<span>没有上一篇了</span>
				@endif			
			</p>
			<p>下一篇：
				@if($article['next'])
					<a href="{{url('art/'.$article['next']->id)}}">{{$article['next']->title}}</a>
				@else
					<span>没有下一篇了</span>
				@endif
			</p>
		</div>
	</div> 
	<div class="cleaner_h20"></div>
	
	@include('Home/Common/footer')
	
    <div class="cleaner"></div>
</div> 
</body>
</html>