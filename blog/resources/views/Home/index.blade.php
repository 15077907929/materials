<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{Config::get('web.web_title')}} - {{Config::get('web.seo_title')}}</title>
<meta name="keywords" content="{{Config::get('web.keywords')}}" />
<meta name="description" content="{{Config::get('web.description')}}" />
<link href="{{asset('Home/css/templatemo_style.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('Home/css/s3slider.css')}}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{asset('Home/js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('Home/js/s3Slider.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#slider').s3Slider({
            timeOut: 1600
        });
    });
</script>
</head>
<body>
<div id="templatemo_wrapper">

	@include('Home/Common/header')
	
	@include('Home/Common/left')
	
    <div id="templatemo_right_column">
    	<div id="featured_project">
            <div id="slider">
                <ul id="sliderContent">
                    <li class="sliderImage">
                        <a href=""><img src="{{asset('Home/images/slider/1.jpg')}}" alt="1" /></a>
                        <span class="top"><strong>Project 1</strong><br />Suspendisse turpis arcu, dignissim ac laoreet a, condimentum in massa.</span>
                    </li>
                    <li class="sliderImage">
                        <a href=""><img src="{{asset('Home/images/slider/2.jpg')}}" alt="2" /></a>
                        <span class="bottom"><strong>Project 2</strong><br />uisque eget elit quis augue pharetra feugiat.</span>
                    </li>
                    <li class="sliderImage">
                        <img src="{{asset('Home/images/slider/3.jpg')}}" alt="3" />
                        <span class="left"><strong>Project 3</strong><br />Sed et quam vitae ipsum vulputate varius vitae semper nunc.</span>
                    </li>
                    <li class="sliderImage">
                        <img src="{{asset('Home/images/slider/4.jpg')}}" alt="4" />
                        <span class="right"><strong>Project 4</strong><br />Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                    </li>
                    <li class="clear sliderImage"></li>
                </ul>
            </div>
        </div>
        <div id="templatemo_main">
			@foreach($article as $key=>$val)
            <div class="post_section">
                <span class="comment"><a href="blog_post.html">{{$val->view}}</a></span>
                <h2><a href="">{{$val->title}}</a></h2>
				{{date('F d, Y',$val->addtime)}} | <strong>Author:</strong> {{$val->editor}} | <strong>Category:</strong> 
				<a href="#">{{$val->cate_name}}</a>
                <img src="{{asset($val->thumb)}}" alt="{{$val->title}}" />
                <div class="desc">{{$val->description}}</div>
              <a href="">Continue reading...</a>
            </div>
			@endforeach
		</div>
		<div class="cleaner"></div>
	</div> 
	<div class="cleaner_h20"></div>
	
	@include('Home/Common/footer')
	
    <div class="cleaner"></div>
</div>
</body>
</html>